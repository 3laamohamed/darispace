<?php

namespace Database\Seeders;

use Botble\Base\Models\MetaBox as MetaBoxModel;
use Botble\Base\Supports\BaseSeeder;
use Botble\Language\Models\LanguageMeta;
use Botble\RealEstate\Models\Category;
use Botble\Slug\Models\Slug;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use SlugHelper;

class CategorySeeder extends BaseSeeder
{
    public function run(): void
    {
        Category::truncate();

        $categories = [
            'Apartment',
            'Villa',
            'Condo',
            'House',
            'Land',
            'Commercial property',
        ];

        DB::table('re_categories_translations')->truncate();
        MetaBoxModel::where('reference_type', Category::class)->delete();
        LanguageMeta::where('reference_type', Category::class)->delete();
        Slug::where('reference_type', Category::class)->delete();

        foreach ($categories as $item) {
            $category = Category::create([
                'name' => $item,
                'description' => fake()->realText(),
                'is_default' => rand(0, 1),
            ]);

            Slug::create([
                'reference_type' => Category::class,
                'reference_id' => $category->id,
                'key' => Str::slug($category->name),
                'prefix' => SlugHelper::getPrefix(Category::class),
            ]);
        }

        $translations = [
            'Căn hộ',
            'Biệt thự',
            'Condo',
            'Nhà ở',
            'Đất',
            'Căn hộ thương mại',
        ];

        foreach ($translations as $index => $item) {
            DB::table('re_categories_translations')->insert([
                'name' => $item,
                'lang_code' => 'vi',
                're_categories_id' => $index + 9,
            ]);
        }
    }
}
