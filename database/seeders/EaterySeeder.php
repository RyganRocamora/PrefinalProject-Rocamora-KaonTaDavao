<?php

namespace Database\Seeders;

use App\Models\Dish;
use App\Models\District;
use App\Models\Eatery;
use App\Models\Feature;
use App\Models\Permit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EaterySeeder extends Seeder
{
    public function run(): void
    {
        $poblacion = District::where('name', 'Poblacion')->firstOrFail();
        $sukiFeature = Feature::where('name', 'Suki ni Rocamora')->firstOrFail();
        $budgetFeature = Feature::where('name', 'Budget Meal')->firstOrFail();

        $myEateryName = 'Carinderia ni Rocamora';

        $myEatery = Eatery::create([
            'district_id' => $poblacion->id,
            'name' => $myEateryName,
            'slug' => Str::slug($myEateryName),
            'address' => 'San Pedro St., Poblacion, Davao City',
            'price_range' => 'budget',
            'specialty' => 'Tinolang Manok',
            'is_open' => true,
        ]);

        $myEatery->permit()->create([
            'permit_no' => 'DVO-2026-0313',
            'expires_on' => '2027-03-13',
        ]);

        $myEatery->features()->sync([
            $sukiFeature->id,
            $budgetFeature->id,
        ]);

        $myEatery->dishes()->createMany([
            [
                'name' => 'Tinolang Manok',
                'price' => 85.00,
                'is_bestseller' => true,
            ],
            [
                'name' => 'Kinilaw na Tuna',
                'price' => 120.00,
                'is_bestseller' => false,
            ],
            [
                'name' => 'Durian Shake',
                'price' => 75.00,
                'is_bestseller' => false,
            ],
        ]);

        $allFeatureIds = Feature::pluck('id');

        // 11 Open factory eateries
        $openEateries = Eatery::factory()->count(11)->create();

        foreach ($openEateries as $index => $eatery) {
            Permit::factory()->create([
                'eatery_id' => $eatery->id,
                // Make sure at least one permit is already expired
                'expires_on' => $index === 0
                    ? now()->subDays(15)->format('Y-m-d')
                    : fake()->dateTimeBetween('+1 month', '+18 months')->format('Y-m-d'),
            ]);

            Dish::factory()->count(rand(2, 5))->create([
                'eatery_id' => $eatery->id,
            ]);

            $eatery->features()->attach(
                $allFeatureIds->random(rand(1, 3))->all()
            );
        }

        // 3 Closed factory eateries
        $closedEateries = Eatery::factory()->closed()->count(3)->create();

        foreach ($closedEateries as $eatery) {
            Permit::factory()->create([
                'eatery_id' => $eatery->id,
            ]);

            Dish::factory()->count(rand(2, 5))->create([
                'eatery_id' => $eatery->id,
            ]);

            $eatery->features()->attach(
                $allFeatureIds->random(rand(1, 3))->all()
            );
        }
    }
}