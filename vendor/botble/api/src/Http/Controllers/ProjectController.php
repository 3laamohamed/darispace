<?php

namespace Botble\Api\Http\Controllers;

use App\Http\Controllers\Controller;
use Botble\Api\Http\Resources\ProjectResource;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Location\Http\Resources\CityResource;
use Botble\Location\Models\City;
use Botble\Location\Repositories\Interfaces\CityInterface;
use Botble\RealEstate\Models\Category;
use Botble\RealEstate\Models\Investor;
use Botble\RealEstate\Models\Project;
use Botble\RealEstate\Supports\RealEstateHelper;
use Botble\RealEstate\Repositories\Interfaces\ProjectInterface;
use Botble\Base\Supports\Helper;
use Illuminate\Http\Request;
use SlugHelper;

class ProjectController extends Controller
{
    /**
     * Get the project project information.
     *
     * @group Project
     * @authenticated
     */
    public function getProjects(BaseHttpResponse $response)
    {
        $projects = Project::get();
        return $response->setData(ProjectResource::collection($projects));
    }

    public function filterProjects(Request $request)
    {
        $helper = new RealEstateHelper();
        $projects = $helper->getProjectsFilter($request->perPage);
        return ProjectResource::collection($projects);
    }

    public function filterSelections(BaseHttpResponse $response)
    {
        $filters=[];
        $filters['cities']=City::where('status',BaseStatusEnum::PUBLISHED)->orderBy('name','ASC')->where('is_real_estate',1)->get();
        $filters['categories']=Category::get();
        $filters['investors']=Investor::get();
        return $response->setData($filters);
    }

    public function getProject($id , BaseHttpResponse $response)
    {
        $project = Project::find($id);
        Helper::handleViewCount($project, 'viewed_project');

        return $response->setData(new ProjectResource($project));
    }

    public function getProjectBySlug($key , BaseHttpResponse $response, ProjectInterface $projectRepository)
    {
        $slug = SlugHelper::getSlug($key, SlugHelper::getPrefix(Project::class));

        // dd($slug,SlugHelper::getPrefix(Project::class));
        if (! $slug) {
            abort(404);
        }

        $helper=new RealEstateHelper();
        $project = $projectRepository->advancedGet(array_merge([
            'with' => $helper->getProjectRelationsQuery(),
            'condition' => ['id' => $slug->reference_id],
            'take' => 1,
        ],  $helper->getReviewExtraData()));

        if (! $project) {
            abort(404);
        }

        if ($project->slugable->key !== $key) {
            return redirect()->to($project->url);
        }
        Helper::handleViewCount($project, 'viewed_project');

        return $response->setData(new ProjectResource($project));
    }

    public function getCities(Request $request, BaseHttpResponse $response)
    {
        $data=City::where('status',BaseStatusEnum::PUBLISHED)->orderBy('name','ASC')->with('projects')->whereHas('projects')->get();

        return $response->setData(CityResource::collection($data));
    }
}
