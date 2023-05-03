<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => ucfirst(fake()->unique()->words(rand(1, 10), true)),
            'subtitle' => fake()->randomElement([null, ucfirst(fake()->words(rand(5, 20), true))]),
            'body' => fake()->text(500),
            'created_at' => fake()->randomElement([now(), fake()->dateTimeBetween('-1 year', now())]),
            'user_id' => fake()->numberBetween(1, 30),
            'topic_id' => fake()->numberBetween(1, 25),
        ];
    }
}
