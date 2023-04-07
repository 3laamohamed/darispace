<?php

namespace Database\Seeders;

use Botble\Base\Supports\BaseSeeder;
use Botble\Location\Models\City;
use Botble\Location\Models\Country;
use Botble\Location\Models\State;
use Botble\RealEstate\Enums\ModerationStatusEnum;
use Botble\RealEstate\Models\Account;
use Botble\RealEstate\Models\Category;
use Botble\RealEstate\Models\Project;
use Botble\RealEstate\Models\Property;
use Botble\Slug\Models\Slug;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use SlugHelper;

class PropertySeeder extends BaseSeeder
{
    public function run(): void
    {
        Property::truncate();
        DB::table('re_property_categories')->truncate();

        $properties = [
            '3 Beds Villa Calpe, Alicante',
            'Lavida Plus Office-tel 1 Bedroom',
            'Vinhomes Grand Park Studio 1 Bedroom',
            'The Sun Avenue Office-tel 1 Bedroom',
            'Property For sale, Johannesburg, South Africa',
            'Stunning French Inspired Manor',
            'Villa for sale at Bermuda Dunes',
            'Walnut Park Apartment',
            '5 beds luxury house',
            'Family Victorian "View" Home',
            'Osaka Heights Apartment',
            'Private Estate Magnificent Views',
            'Thompson Road House for rent',
            'Brand New 1 Bedroom Apartment In First Class Location',
            'Elegant family home presents premium modern living',
            'Luxury Apartments in Singapore for Sale',
            '5 room luxury penthouse for sale in Kuala Lumpur',
            '2 Floor house in Compound Pejaten Barat Kemang',
            'Apartment Muiderstraatweg in Diemen',
            'Nice Apartment for rent in Berlin',
            'Pumpkin Key - Private Island',
        ];

        $projectsCount = Project::count();
        $countriesCount = Country::count();
        $statesCount = State::count();
        $citiesCount = City::count();
        $accountsCount = Account::count();
        $categoriesCount = Category::count();
        $inFiveYears = Carbon::now()->addYears(5)->year;

        foreach ($properties as $property) {
            $type = fake()->randomElement(['sale', 'rent']);

            $images = [];

            foreach (fake()->randomElements(range(1, 12), rand(5, 12)) as $image) {
                $images[] = "properties/$image.jpg";
            }

            $property = Property::create([
                'name' => $property,
                'description' => File::get(database_path('/seeders/contents/property-description.html')),
                'content' => File::get(database_path('/seeders/contents/property-content.html')),
                'location' => fake()->address(),
                'images' => json_encode($images),
                'project_id' => rand(1, $projectsCount),
                'author_id' => rand(1, $accountsCount),
                'author_type' => Account::class,
                'number_bedroom' => rand(1, 10),
                'number_bathroom' => rand(1, 10),
                'number_floor' => rand(1, 100),
                'square' => rand(1, 100) * 10,
                'price' => rand(100, 10000) * 100,
                'is_featured' => rand(0, 1),
                'status' => $type === 'sale' ? 'selling' : 'renting',
                'type' => $type,
                'moderation_status' => ModerationStatusEnum::APPROVED,
                'expire_date' => $inFiveYears,
                'never_expired' => true,
                'latitude' => fake()->latitude(42.4772, 44.0153),
                'longitude' => fake()->longitude(-74.7624, -76.7517),
                'views' => rand(0, 100000),
                'country_id' => rand(1, $countriesCount),
                'state_id' => rand(1, $statesCount),
                'city_id' => rand(1, $citiesCount),
            ]);

            $property->categories()->attach(fake()->randomElements(range(1, $categoriesCount), rand(1, 5)));

            Slug::create([
                'reference_type' => Property::class,
                'reference_id' => $property->id,
                'key' => Str::slug($property->name),
                'prefix' => SlugHelper::getPrefix(Property::class),
            ]);
        }
    }
}
