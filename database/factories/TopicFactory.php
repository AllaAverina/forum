<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Topic>
 */
class TopicFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => ucfirst(fake()->unique()->words(rand(1, 5), true)),
            'subtitle' => fake()->randomElement([null, ucfirst(fake()->words(rand(5, 15), true))]),
            'created_at' => fake()->randomElement([now(), fake()->dateTimeBetween('-1 year', now())]),
            'user_id' => User::get()->random()->id,
        ];
    }
}
