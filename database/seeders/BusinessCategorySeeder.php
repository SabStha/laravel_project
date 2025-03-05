<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BusinessCategory;

class BusinessCategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['category_name' => '飲食'], // Food & Beverage
            ['category_name' => '小売・販売'], // Retail & Sales
            ['category_name' => '接客・サービス'], // Customer Service
            ['category_name' => '清掃'], // Cleaning
            ['category_name' => 'ベッドメイク'], // Bed Making
        ];

        foreach ($categories as $category) {
            BusinessCategory::create($category);
        }
    }
}

