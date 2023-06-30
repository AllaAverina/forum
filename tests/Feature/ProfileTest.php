<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Indicates whether the default seeder should run before each test.
     *
     * @var bool
     */
    protected $seed = true;

    public function test_auth_user_can_see_profile(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('profile.show'));

        $response->assertViewIs('user.show')
            ->assertViewHas('user', $user)
            ->assertSuccessful();
    }

    public function test_auth_user_can_see_profile_with_posts(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('profile.show', 'posts'));

        $response->assertViewIs('user.show')
            ->assertViewHas('user', $user)
            ->assertViewHas('posts')
            ->assertSuccessful();
    }

    public function test_auth_user_can_see_profile_with_comments(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('profile.show', 'comments'));

        $response->assertViewIs('user.show')
            ->assertViewHas('user', $user)
            ->assertViewHas('comments')
            ->assertSuccessful();
    }

    public function test_auth_user_can_see_profile_with_topics(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('profile.show', 'topics'));

        $response->assertViewIs('user.show')
            ->assertViewHas('user', $user)
            ->assertViewHas('topics')
            ->assertSuccessful();
    }

    public function test_auth_user_can_see_edit_profile_form(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('profile.edit'));

        $response->assertViewIs('profile.edit')
            ->assertViewHas('user', $user)
            ->assertSuccessful();
    }

    public function test_middleware_destroy_profile(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->delete(route('profile.destroy'));

        $response->assertRedirect(route('password.confirm'));
    }
}
