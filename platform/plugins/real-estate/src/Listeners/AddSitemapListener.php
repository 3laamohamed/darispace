<?php

namespace Botble\RealEstate\Listeners;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Location\Repositories\Interfaces\CityInterface;
use Botble\RealEstate\Repositories\Interfaces\AccountInterface;
use Botble\RealEstate\Repositories\Interfaces\CategoryInterface;
use Botble\RealEstate\Repositories\Interfaces\ProjectInterface;
use Botble\RealEstate\Repositories\Interfaces\PropertyInterface;
use RealEstateHelper;
use SiteMapManager;

class AddSitemapListener
{
    public function __construct(
        protected ProjectInterface $projectRepository,
        protected PropertyInterface $propertyRepository,
        protected AccountInterface $accountRepository,
        protected CategoryInterface $categoryRepository,
        protected CityInterface $cityRepository
    ) {
    }

    public function handle(): void
    {
        $projects = $this->projectRepository->advancedGet([
            'condition' => RealEstateHelper::getProjectDisplayQueryConditions(),
            'with' => ['slugable'],
        ]);

        SiteMapManager::add(route('public.projects'), '2023-02-01 00:00:00', '0.4', 'monthly');

        foreach ($projects as $project) {
            SiteMapManager::add($project->url, $project->updated_at, '0.8');
        }

        $properties = $this->propertyRepository->advancedGet([
            'condition' => RealEstateHelper::getPropertyDisplayQueryConditions(),
            'with' => ['slugable'],
        ]);

        SiteMapManager::add(route('public.properties'), '2023-02-01 00:00:00', '0.4', 'monthly');

        foreach ($properties as $property) {
            SiteMapManager::add($property->url, $property->updated_at, '0.8');
        }

        $accounts = $this->accountRepository->all();

        SiteMapManager::add(route('public.agents'), '2023-02-01 00:00:00', '0.4', 'monthly');

        foreach ($accounts as $account) {
            if (! $account->username) {
                continue;
            }

            SiteMapManager::add(route('public.agent', $account->username), $account->updated_at, '0.8');
        }

        $categories = $this->categoryRepository->allBy(['status' => BaseStatusEnum::PUBLISHED], ['slugable']);

        foreach ($categories as $category) {
            SiteMapManager::add($category->url, $category->updated_at, '0.8');
        }

        $cities = $this->cityRepository->advancedGet([
            'condition' => ['status' => BaseStatusEnum::PUBLISHED],
        ]);

        foreach ($cities as $city) {
            SiteMapManager::add(route('public.properties-by-city', $city->slug), $city->updated_at, '0.8');
            SiteMapManager::add(route('public.projects-by-city', $city->slug), $city->updated_at, '0.8');
        }
    }
}
