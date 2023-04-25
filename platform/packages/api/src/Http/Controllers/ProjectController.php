<?php

namespace Botble\Api\Http\Controllers;

use App\Http\Controllers\Controller;
use Botble\Api\Http\Resources\ProjectResource;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\RealEstate\Models\Project;
use Botble\RealEstate\Supports\RealEstateHelper;
use Illuminate\Http\Request;

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

    public function getProject($id , BaseHttpResponse $response)
    {
        $project = Project::find($id);
        return $response->setData(new ProjectResource($project));
    }

    /**
     * Update Avatar
     *
     * @bodyParam avatar file required Avatar file.
     *
     * @group Project
     * @authenticated
     */

}
