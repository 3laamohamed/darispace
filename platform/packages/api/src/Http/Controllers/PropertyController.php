<?php

namespace Botble\Api\Http\Controllers;

use App\Http\Controllers\Controller;
use Botble\Api\Http\Resources\PropertyResource;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\RealEstate\Models\Property;
use Botble\RealEstate\Supports\RealEstateHelper;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    /**
     * Get the property property information.
     *
     * @group Property
     * @authenticated
     */
    public function getProperties(BaseHttpResponse $response)
    {
        $properties = Property::get();
        return $response->setData(PropertyResource::collection($properties));
    }

    public function filterProperties(Request $request)
    {
        $helper = new RealEstateHelper();
        $properties = $helper->getPropertiesFilter($request->perPage);
        return PropertyResource::collection($properties);
    }

    public function getProperty($id , BaseHttpResponse $response)
    {
        $property = Property::find($id);
        return $response->setData(new PropertyResource($property));
    }

    /**
     * Update Avatar
     *
     * @bodyParam avatar file required Avatar file.
     *
     * @group Property
     * @authenticated
     */

}
