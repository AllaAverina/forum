<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'body' => fake()->text(),
            'created_at' => fake()->randomElement([now(), fake()->dateTimeBetween('-1 year', now())]),
            'user_id' => User::get()->random()->id,
            'post_id' => Post::get()->random()->id,

        ];
    }
}
