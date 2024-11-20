<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\City;
use App\Models\Color;
use App\Models\Country;
use App\Models\Neighborhood;
use App\Models\Size;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        Category::factory()->count(5)->create();
        Color::factory()->count(5)->create();
        Size::factory()->count(5)->create();
        Country::factory()->has(
            City::factory()->has(
                Neighborhood::factory()->count(8)
            )->count(4)
        )->count(3)->create();
    }
}
