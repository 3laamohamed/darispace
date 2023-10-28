<?php

namespace Botble\Api\Http\Controllers;

use BaseHelper;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Location\Http\Resources\CountryResource;
use Botble\Location\Models\Country;
use Botble\Location\Repositories\Interfaces\CountryInterface;
use Botble\Base\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Location\Http\Resources\CityResource;
use Botble\Location\Http\Resources\StateResource;
use Botble\Location\Models\City;
use Botble\Location\Models\State;
use Botble\Location\Repositories\Interfaces\CityInterface;
use Botble\Location\Repositories\Interfaces\StateInterface;
use Botble\RealEstate\Http\Resources\CurrencyResource;
use Botble\RealEstate\Models\Currency;
use Botble\RealEstate\Repositories\Interfaces\CurrencyInterface;

class CountryController extends BaseController
{
    public function __construct(protected CountryInterface $countryRepository,
                    protected CityInterface $cityRepository,
                    protected CurrencyInterface $currencyRepository,
                    protected StateInterface $stateRepository
                    )
    {
    }

    public function getCountries(Request $request, BaseHttpResponse $response)
    {
        $keyword = BaseHelper::stringify($request->input('q'));

        // if (! $keyword) {
        //     return $response->setData([]);
        // }

        $data = $this->countryRepository->advancedGet([
            'condition' => [
                ['countries.name', 'LIKE', '%' . $keyword . '%'],
            ],
            'select' => ['countries.id', 'countries.name'],
            'take' => 10,
            'order_by' => ['order' => 'ASC', 'name' => 'ASC'],
        ]);

        // dd($data);
        $data->prepend(new Country(['id' => 0, 'name' => trans('plugins/location::city.select_country')]));

        return $response->setData(CountryResource::collection($data));
    }

    public function getCities(Request $request, BaseHttpResponse $response)
    {
        $params = [
            'select' => ['cities.id', 'cities.name', 'cities.state_id'],
            'condition' => [
                'cities.status' => BaseStatusEnum::PUBLISHED,
                // 'cities.is_real_estate' => $request->is_real_estate,
            ],
            'order_by' => ['order' => 'ASC', 'name' => 'ASC'],
        ];

        if ($request->input('state_id') && $request->input('state_id')) {
            $params['condition']['cities.state_id'] = $request->input('state_id');
        }

        if ($request->input('is_real_estate') && $request->input('is_real_estate') != 'null') {
            $params['condition']['cities.is_real_estate'] = $request->input('is_real_estate');
        }

        $data = $this->cityRepository->advancedGet($params);

        $data->prepend(new City(['id' => 0, 'name' => trans('plugins/location::city.select_city')]));

        // dd($data);
        return $response->setData(CityResource::collection($data));
    }

    public function getStates(Request $request, BaseHttpResponse $response)
    {
        $params = [
            'select' => ['states.id', 'states.name'],
            'condition' => [
                'states.status' => BaseStatusEnum::PUBLISHED,
            ],
            'order_by' => ['order' => 'ASC', 'name' => 'ASC'],
        ];

        if ($request->input('country_id') && $request->input('country_id') != 'null') {
            $params['condition']['states.country_id'] = $request->input('country_id');
        }

        $data = $this->stateRepository->advancedGet($params);

        $data->prepend(new State(['id' => 0, 'name' => trans('plugins/location::city.select_state')]));

        return $response->setData(StateResource::collection($data));
    }

    public function getCurrencies(Request $request, BaseHttpResponse $response)
    {
        $keyword = BaseHelper::stringify($request->input('q'));

        // if (! $keyword) {
        //     return $response->setData([]);
        // }

        $data = $this->currencyRepository->advancedGet([
            'condition' => [
                ['title', 'LIKE', '%' . $keyword . '%'],
            ],
            // 'select' => ['id', 'name'],
            'take' => 10,
            'order_by' => ['order' => 'ASC', 'id' => 'ASC'],
        ]);


        return $response->setData(CurrencyResource::collection($data));
    }

}
