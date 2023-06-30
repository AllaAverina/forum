<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Indicates whether the default seeder should run before each test.
     *
     * @var bool
     */
    protected $seed = true;

    public function test_auth_user_can_store_comment(): void
    {
        $user = User::factory()->create();
        $post = Post::get()->random();

        $response = $this->actingAs($user)
            ->from(route('posts.show', $post->slug))
            ->followingRedirects()
            ->post(route('posts.comments.store', $post->slug), [
                'body' => 'test comment',
            ]);

        $this->assertDatabaseHas('comments', [
            'body' => 'test comment',
            'post_id' => $post->id,
            'user_id' => $user->id,
        ]);

        $response->assertViewIs('post.post-comments')->assertSee('test comment')->assertSuccessful();
    }

    public function test_auth_user_can_see_edit_own_comment_form(): void
    {
        $user = User::factory()->create();
        $comment = Comment::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('comments.edit', $comment->id));
        $response->assertViewIs('comment.edit')->assertViewHas('comment', $comment)->assertSuccessful();
    }

    public function test_auth_user_can_update_own_comment(): void
    {
        $user = User::factory()->create();
        $comment = Comment::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->from(route('comments.edit', $comment->id))
            ->followingRedirects()
            ->put(route('comments.update', $comment->id), [
                'body' => 'new test comment',
            ]);

        $this->assertDatabaseMissing('comments', ['id' => $comment->id, 'body' => $comment->body, 'user_id' => $user->id,])
            ->assertDatabaseHas('comments', ['id' => $comment->id, 'body' => 'new test comment', 'user_id' => $user->id,]);

        $response->assertViewIs('comment.edit')->assertSee('new test comment')->assertSuccessful();
    }

    public function test_auth_user_can_destroy_own_comment(): void
    {
        $user = User::factory()->create();
        $comment = Comment::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete(route('comments.destroy', $comment->id));

        $this->assertSoftDeleted($comment);
    }

    public function test_auth_user_can_restore_own_comment(): void
    {
        $user = User::factory()->create();
        $comment = Comment::factory()->create(['user_id' => $user->id]);
        $comment->delete();

        $response = $this->actingAs($user)->patch(route('comments.restore', $comment->id));

        $this->assertDatabaseHas('comments', ['id' => $comment->id, 'deleted_at' => null, 'user_id' => $user->id,]);
    }
}
