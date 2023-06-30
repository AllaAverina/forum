<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Role;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Topic;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ModeratorTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Indicates whether the default seeder should run before each test.
     *
     * @var bool
     */
    protected $seed = true;

    public function test_moderator_can_force_delete_any_topic(): void
    {
        $moder = User::factory()->create();
        $moder->roles()->sync(Role::where('role', 'moderator')->first()->id);
        $user = User::factory()->create();
        $topic = Topic::factory()->create(['user_id' => $user->id,]);

        $response = $this->actingAs($moder)->delete(route('topics.forceDestroy', $topic->slug));
        
        $this->assertDatabaseMissing('topics', ['id' => $topic->id, 'user_id' => $user->id,]);
    }

    public function test_moderator_can_force_delete_any_post(): void
    {
        $moder = User::factory()->create();
        $moder->roles()->sync(Role::where('role', 'moderator')->first()->id);
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($moder)->delete(route('posts.forceDestroy', $post->slug));

        $this->assertDatabaseMissing('posts', ['id' => $post->id, 'user_id' => $user->id,]);
    }

    public function test_moderator_can_force_delete_any_comment(): void
    {
        $moder = User::factory()->create();
        $moder->roles()->sync(Role::where('role', 'moderator')->first()->id);
        $user = User::factory()->create();
        $comment = Comment::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($moder)->delete(route('comments.forceDestroy', $comment->id));
        
        $this->assertDatabaseMissing('comments', ['id' => $comment->id, 'user_id' => $user->id,]);
    }
}
