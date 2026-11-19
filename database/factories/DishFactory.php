<?php

namespace Database\Factories;

use App\Models\Eatery;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Dish>
 */
class DishFactory extends Factory
{
    public function definition(): array
    {
        return [
            'eatery_id' => Eatery::factory(),
            'name' => fake()->randomElement([
                'Pork Adobo',
                'Sinigang na Baboy',
                'Beef Nilaga',
                'Tinolang Isda',
                'Bicol Express',
                'Pinakbet',
                'Fried Bangus',
                'Dinuguan',
                'Pansit Bihon',
                'Halo-Halo',
            ]),
            'price' => fake()->randomFloat(2, 45, 250),
            'is_bestseller' => fake()->boolean(25),
        ];
    }
}