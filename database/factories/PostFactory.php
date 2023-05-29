<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Topic;
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
            'user_id' => User::get()->random()->id,
            'topic_id' => Topic::get()->random()->id,
        ];
    }
}
