<?php

namespace Botble\Api\Http\Controllers;

use App\Http\Controllers\Controller;
use Botble\Api\Http\Resources\InvestorResource;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Blog\Models\Category;
use Botble\Location\Models\City;
use Botble\RealEstate\Models\Investor;
use Botble\RealEstate\Supports\RealEstateHelper;
use Illuminate\Http\Request;

class InvestorController extends Controller
{
    /**
     * Get the investor investor information.
     *
     * @group Investor
     * @authenticated
     */
    public function getInvestors(BaseHttpResponse $response)
    {
        $investors = Investor::get();
        return $response->setData(InvestorResource::collection($investors));
    }

    public function filterInvestors(Request $request)
    {
        $helper = new RealEstateHelper();
        $investors = $helper->getInvestorsFilter($request->perPage);
        return InvestorResource::collection($investors);
    }

    public function filterSelections(BaseHttpResponse $response)
    {
        $filters=[];
        $filters['cities']=City::get();
        $filters['categories']=Category::get();
        $filters['investors']=Investor::get();
        return $response->setData($filters);
    }

    public function getInvestor($id , BaseHttpResponse $response)
    {
        $investor = Investor::find($id);
        return $response->setData(new InvestorResource($investor));
    }

    /**
     * Update Avatar
     *
     * @bodyParam avatar file required Avatar file.
     *
     * @group Investor
     * @authenticated
     */

}
