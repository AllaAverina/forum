<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Indicates whether the default seeder should run before each test.
     *
     * @var bool
     */
    protected $seed = true;

    public function test_view_posts(): void
    {
        $response = $this->get(route('posts.index'));
        $response->assertViewIs('post.index')->assertViewHas('posts')->assertSuccessful();
    }

    public function test_search_posts(): void
    {
        $response = $this->get(route('posts.index', ['search' => fake()->randomLetter(),]));
        $response->assertViewIs('post.index')->assertViewHas('posts')->assertSuccessful();
    }

    public function test_show_post(): void
    {
        $post = Post::get()->random();
        $response = $this->get(route('posts.show', $post->slug));
        $response->assertViewIs('post.post-comments')
            ->assertViewHas('post', $post)
            ->assertViewHas('comments')
            ->assertSuccessful();
    }

    public function test_auth_user_can_see_create_post_form(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('posts.create'));
        $response->assertViewIs('post.create-edit')->assertSuccessful();
    }

    public function test_auth_user_can_store_post(): void
    {
        $user = User::factory()->create();
        $topic = Topic::get()->random();

        $response = $this->actingAs($user)
            ->followingRedirects()
            ->post(route('posts.store'), [
                'topic_id' => $topic->id,
                'title' => 'test title',
                'subtitle' => 'test subtitle',
                'body' => 'test body',
            ]);

        $this->assertDatabaseHas('posts', [
            'title' => 'test title',
            'subtitle' => 'test subtitle',
            'body' => 'test body',
            'user_id' => $user->id,
            'topic_id' => $topic->id,
        ]);
        
        $response->assertViewIs('post.create-edit')
            ->assertSee(['test title', 'test subtitle', 'test body'])
            ->assertSuccessful();
    }

    public function test_auth_user_can_see_edit_own_post_form(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id,]);

        $response = $this->actingAs($user)->get(route('posts.edit', $post->slug));
        $response->assertViewIs('post.create-edit')
            ->assertViewHas('post', $post)
            ->assertSuccessful();
    }

    public function test_auth_user_can_update_own_post(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id,]);
        $topic = Topic::get()->random();

        $response = $this->actingAs($user)
            ->from(route('posts.edit', $post->slug))
            ->followingRedirects()
            ->put(route('posts.update', $post->slug), [
                'topic_id' => $topic->id,
                'title' => 'new test title',
                'subtitle' => $post->subtitle,
                'body' => $post->body,
            ]);

        $this->assertDatabaseMissing('posts', [
            'id' => $post->id,
            'title' => $post->title,
            'user_id' => $user->id,
        ])
            ->assertDatabaseHas('posts', [
                'id' => $post->id,
                'title' => 'new test title',
                'user_id' => $user->id,
                'topic_id' => $topic->id,
            ]);

        $response->assertViewIs('post.create-edit')->assertSee('new test title')->assertSuccessful();
    }

    public function test_auth_user_can_destroy_own_post(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id,]);

        $response = $this->actingAs($user)->delete(route('posts.destroy', $post->slug));

        $this->assertSoftDeleted($post);
    }

    public function test_auth_user_can_restore_own_post(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id,]);
        $post->delete();

        $response = $this->actingAs($user)->patch(route('posts.restore', $post->slug));

        $this->assertDatabaseHas('posts', ['id' => $post->id, 'deleted_at' => null, 'user_id' => $user->id,]);
    }
}
