<?php

namespace Database\Factories;

use App\Models\Eatery;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Permit>
 */
class PermitFactory extends Factory
{
    public function definition(): array
    {
        return [
            'eatery_id' => Eatery::factory(),
            'permit_no' => 'DVO-2026-' . fake()->unique()->numerify('#####'),
            'expires_on' => fake()->dateTimeBetween('+1 month', '+2 years')->format('Y-m-d'),
        ];
    }
}