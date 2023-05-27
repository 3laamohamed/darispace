<?php

namespace Botble\Api\Http\Controllers;

use App\Http\Controllers\Controller;
use Botble\Api\Http\Requests\AccountPropertyRequest;
use Botble\Api\Http\Resources\PropertyResource;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Location\Models\State;
use Botble\Media\Models\MediaFile;
use Botble\RealEstate\Enums\ModerationStatusEnum;
use Botble\RealEstate\Models\Account;
use Botble\RealEstate\Models\Category;
use Botble\RealEstate\Models\CustomFieldValue;
use Botble\RealEstate\Models\Facility;
use Botble\RealEstate\Models\Feature;
use Botble\RealEstate\Models\Property;
use Botble\RealEstate\Repositories\Interfaces\AccountActivityLogInterface;
use Botble\RealEstate\Repositories\Interfaces\AccountInterface;
use Botble\RealEstate\Repositories\Interfaces\PropertyInterface;
use Botble\RealEstate\Services\SaveFacilitiesService;
use Botble\RealEstate\Services\StorePropertyCategoryService;
use Botble\RealEstate\Supports\RealEstateHelper as SupportsRealEstateHelper;
use Botble\Slug\Models\Slug;
use RealEstateHelper;
use Botble\Slug\Repositories\Interfaces\SlugInterface;
use Botble\Slug\Services\SlugService;
use EmailHandler;
use Exception;
use Illuminate\Cache\Repository;
use Illuminate\Http\Request;
use SlugHelper;

class PropertyController extends Controller
{
    /**
     * Get the property property information.
     *
     * @group Property
     * @authenticated
     */
    public function __construct(
        Repository $config,
        protected AccountInterface $accountRepository,
        protected PropertyInterface $propertyRepository,
        protected AccountActivityLogInterface $activityLogRepository
    ) {

    }

    public function getProperties(BaseHttpResponse $response)
    {
        $properties = Property::get();
        return $response->setData(PropertyResource::collection($properties));
    }

    public function filterProperties(Request $request)
    {
        $helper = new SupportsRealEstateHelper();
        $properties = $helper->getPropertiesFilter($request->perPage);
        return PropertyResource::collection($properties);
    }

    public function filterSelections(BaseHttpResponse $response)
    {
        $filters=[];
        $filters['states']=State::get();
        $filters['categories']=Category::get();
        return $response->setData($filters);
    }

    public function getProperty($id , BaseHttpResponse $response)
    {
        $property = Property::find($id);
        return $response->setData(new PropertyResource($property));
    }
    public function categories(BaseHttpResponse $response)
    {
        $categories=Category::get();
        return $response->setData($categories);
    }

    public function facilities_features(BaseHttpResponse $response)
    {
        $filters=[];
        $filters['facilities']=Facility::select('id','name','status','icon')->get();
        $filters['features']=Feature::get();
        // dd($filters);
        return $response->setData($filters);
    }
    public function featuredProperties(BaseHttpResponse $response)
    {
        $properties = Property::where('is_featured',1)->limit(request()->perPage??12)->get();
        return $response->setData(PropertyResource::collection($properties));
    }

    public function recentProperties(BaseHttpResponse $response)
    {
        $properties = Property::latest()->limit(request()->perPage??12)->get();
        return $response->setData(PropertyResource::collection($properties));
    }

    public function getUserProperties(BaseHttpResponse $response)
    {
        $properties = Property::where('author_id',auth()->user()->id)->paginate(12);
        return PropertyResource::collection($properties);
    }

    public function store(
        AccountPropertyRequest $request,
        BaseHttpResponse $response,
        AccountInterface $accountRepository,
        StorePropertyCategoryService $propertyCategoryService,
        SaveFacilitiesService $saveFacilitiesService
    )
    {
        if (! auth()->user()->canPost()) {
            return $response
            ->setError()
            ->setCode(422)
            ->setMessage(trans('plugins/real-estate::package.add_credit_alert'));
        }

        $property = $this->propertyRepository->getModel();

        $slugService = new SlugService(app(SlugInterface::class));

        // $slugService->create($request->name,0,$property);
        $property->fill(array_merge($this->processRequestData($request), [
            'author_id' => auth()->id(),
            // 'slug' => $slugService->create($request->name,0,$property),
            'author_type' => Account::class,
        ]));

        // $property->model="Botble\\RealEstate\\Models\\Property";
        // $property->slug = $slugService->create($request->name,0,$property);
        // dd($property);

        if($request->images){
            $images=[];
            foreach ($request->images as $key => $img) {
                $file = $img;
                $ext=$file->extension();
                $time = time().$key;
                $imageName = $time.'-150x150.'.$ext;
                $imagePath = public_path(). '/storage/accounts/'.str_replace(' ','',auth()->user()->name);

                // dd($imagePath);
                $file->move($imagePath, $imageName);
                $oldPath=$imagePath.'/'.$time.'-150x150.'.$ext;
                $newPath = $imagePath.'/'.$time.'-600x400.'.$ext;
                // $img->move($imagePath, $time.'-150x150.'.$ext);
                \File::copy($oldPath , $newPath);
                $newPath = $imagePath.'/'.$time.'.'.$ext;
                \File::copy($oldPath , $newPath);

                // $img->move($imagePath, $time.'-150x150.'.$ext);

                $image=MediaFile::create([
                    'user_id'=>auth()->user()->id,
                    'name'=>$imageName,
                    'mime_type'=>$ext,
                    'size'=>454,
                    'url'=>'accounts/'.str_replace(' ','',auth()->user()->name).'/'.$time.'.'.$ext,
                ]);
                $images[]=$image->url;
            }

            // dd($images);

            $property->images=json_encode($images);
        }


        $property->expire_date = now()->addDays(RealEstateHelper::propertyExpiredDays());

        if (setting('enable_post_approval', 1) == 0) {
            $property->moderation_status = ModerationStatusEnum::APPROVED;
        }

        $property = $this->propertyRepository->createOrUpdate($property);

        Slug::create([
            'key'=>$slugService->create($request->name,0,$property),
            'reference_id'=>$property->id,
            'reference_type'=>'Botble\RealEstate\Models\Property',
            'prefix'=>'properties'
        ]);
        if ($property) {
            $customFields = CustomFieldValue::formatCustomFields($request->input('custom_fields') ?? []);

            $property->customFields()
                ->whereNotIn('id', collect($customFields)->pluck('id')->all())
                ->delete();

            $property->customFields()->saveMany($customFields);

            $property->features()->sync($request->input('features', []));
            // $property->categories()->sync($request->input('categories', []));

            $saveFacilitiesService->execute($property, $request->input('facilities', []));

            $propertyCategoryService->execute($request, $property);
        }


        $this->activityLogRepository->createOrUpdate([
            'action' => 'create_property',
            'account_id' => auth()->user()->id,
            'reference_name' => $property->name,
            'reference_url' => route('public.account.properties.edit', $property->id),
        ]);

        if (RealEstateHelper::isEnabledCreditsSystem()) {
            $account = $accountRepository->findOrFail(auth()->id());
            $account->credits--;
            $account->save();
        }

        EmailHandler::setModule(REAL_ESTATE_MODULE_SCREEN_NAME)
            ->setVariableValues([
                'post_name' => $property->name,
                'post_url' => route('property.edit', $property->id),
                'post_author' => $property->author->name,
            ])
            ->sendUsingTemplate('new-pending-property');

        return $response
            ->setPreviousUrl(route('public.account.properties.index'))
            ->setNextUrl(route('public.account.properties.edit', $property->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    protected function processRequestData(Request $request): array
    {
        $shortcodeCompiler = shortcode()->getCompiler();

        $request->merge([
            'content' => $shortcodeCompiler->strip($request->input('content'), $shortcodeCompiler->whitelistShortcodes()),
        ]);

        $except = [
            'is_featured',
            'author_id',
            'author_type',
            'expire_date',
        ];

        foreach ($except as $item) {
            $request->request->remove($item);
        }

        return $request->input();
    }

    /**
     * Update Avatar
     *
     * @bodyParam avatar file required Avatar file.
     *
     * @group Property
     * @authenticated
     */

     public function update(
        int|string $id,
        AccountPropertyRequest $request,
        BaseHttpResponse $response,
        StorePropertyCategoryService $propertyCategoryService,
        SaveFacilitiesService $saveFacilitiesService
    ) {
        $property = $this->propertyRepository->findOrFail($id);
        $images=$property->images;

        foreach ($request->deleted_images??[] as $value) {
            unset($images[$value]);
        }
        // dd($images);
        $property->fill($request->except(['expire_date']));

        $property->author_type = Account::class;
        // $property->images = json_encode(array_filter($request->input('images', [])));
        $property->moderation_status = $request->input('moderation_status');
        $property->never_expired = 0;

        if($request->images){
            foreach ($request->images as $key => $img) {
                $file = $img;
                $ext=$file->extension();
                $time = time().$key;
                $imageName = $time.'-150x150.'.$ext;
                $imagePath = public_path(). '/storage/accounts/'.str_replace(' ','',auth()->user()->name);

                // dd($imagePath);
                $file->move($imagePath, $imageName);
                $oldPath=$imagePath.'/'.$time.'-150x150.'.$ext;
                $newPath = $imagePath.'/'.$time.'-600x400.'.$ext;
                // $img->move($imagePath, $time.'-150x150.'.$ext);
                \File::copy($oldPath , $newPath);
                $newPath = $imagePath.'/'.$time.'.'.$ext;
                \File::copy($oldPath , $newPath);

                $image=MediaFile::create([
                    'user_id'=>auth()->user()->id,
                    'name'=>$imageName,
                    'mime_type'=>$ext,
                    'size'=>454,
                    'url'=>'accounts/'.str_replace(' ','',auth()->user()->name).'/'.$time.'.'.$ext,
                ]);
                $images[]=$image->url;
            }

            // dd($images);

            $property->images=json_encode($images);
        }

        $this->propertyRepository->createOrUpdate($property);

        $customFields = CustomFieldValue::formatCustomFields($request->input('custom_fields') ?? []);

        $property->customFields()
            ->whereNotIn('id', collect($customFields)->pluck('id')->all())
            ->delete();

        $property->customFields()->saveMany($customFields);

        $property->features()->sync($request->input('features', []));

        $saveFacilitiesService->execute($property, $request->input('facilities', []));

        $propertyCategoryService->execute($request, $property);

        return $response
            ->setPreviousUrl(route('property.index'))
            ->setNextUrl(route('property.edit', $property->id))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(int|string $id, Request $request, BaseHttpResponse $response)
    {
        try {
            $property = $this->propertyRepository->findOrFail($id);

            // if($property->expire_date <= \Carbon::now()){
            if(isset($property->duration) && $property->created_at >= now()->subDays($property->duration)){
                return $response
                ->setError()
                ->setMessage(__("You Can't Delete this Property Before Expire Date" ));
            }
            $property->features()->detach();
            $this->propertyRepository->delete($property);


            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }

}
