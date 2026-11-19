<?php

namespace Database\Factories;

use App\Models\Eatery;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    public function definition(): array
    {
        return [
            'eatery_id' => Eatery::factory(),
            'user_id' => User::inRandomOrder()->value('id') ?? User::factory(),
            'rating' => fake()->numberBetween(1, 5),
            'body' => fake()->paragraph(2),
        ];
    }
}