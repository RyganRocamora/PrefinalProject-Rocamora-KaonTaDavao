<?php

namespace Database\Seeders;

use App\Models\Feature;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    public function run(): void
    {
        $features = [
            'Suki ni Rocamora',
            'Budget Meal',
            'Halal',
            'Open 24 Hours',
            'Aircon',
            'Wi-Fi Available',
        ];

        foreach ($features as $name) {
            Feature::create(['name' => $name]);
        }
    }
}