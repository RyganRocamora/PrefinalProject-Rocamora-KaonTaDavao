<?php

namespace Database\Factories;

use App\Models\District;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Eatery>
 */
class EateryFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->company() . ' Carinderia';
        $name = Str::limit($name, 95, '');

        return [
            'district_id' => District::inRandomOrder()->value('id') ?? District::factory(),
            'name' => $name,
            'slug' => Str::slug($name),
            'address' => fake()->streetAddress() . ', Davao City',
            'price_range' => fake()->randomElement(['budget', 'mid', 'splurge']),
            'specialty' => fake()->randomElement([
                'Tinolang Manok',
                'Sinuglaw',
                'Bulalo',
                'Kare-Kare',
                'Lechon Kawali',
                'Beef Pares',
                'Kinilaw na Malasugue',
                'Chicken Inasal',
                null,
            ]),
            'is_open' => true,
        ];
    }

    public function closed(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_open' => false,
        ]);
    }
}