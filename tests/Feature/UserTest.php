<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Indicates whether the default seeder should run before each test.
     *
     * @var bool
     */
    protected $seed = true;

    public function test_view_users(): void
    {
        $response = $this->get(route('users.index'));
        $response->assertViewIs('user.index')->assertViewHas('users')->assertSuccessful();
    }

    public function test_search_users(): void
    {
        $response = $this->get(route('users.index', ['search' => fake()->randomLetter(),]));
        $response->assertViewIs('user.index')->assertViewHas('users')->assertSuccessful();
    }

    public function test_show_user(): void
    {
        $user = User::get()->random();
        $response = $this->get(route('users.show', $user->nickname));
        $response->assertViewIs('user.show')
            ->assertViewHas('user', $user)
            ->assertSuccessful();
    }

    public function test_show_user_and_posts(): void
    {
        $user = User::get()->random();
        $response = $this->get(route('users.show', [$user->nickname, 'posts']));
        $response->assertViewIs('user.show')
            ->assertViewHas('user', $user)
            ->assertViewHas('posts')
            ->assertSuccessful();
    }

    public function test_show_user_and_comments(): void
    {
        $user = User::get()->random();
        $response = $this->get(route('users.show', [$user->nickname, 'comments']));
        $response->assertViewIs('user.show')
            ->assertViewHas('user', $user)
            ->assertViewHas('comments')
            ->assertSuccessful();
    }

    public function test_show_user_and_topics(): void
    {
        $user = User::get()->random();
        $response = $this->get(route('users.show', [$user->nickname, 'topics']));
        $response->assertViewIs('user.show')
            ->assertViewHas('user', $user)
            ->assertViewHas('topics')
            ->assertSuccessful();
    }
}
