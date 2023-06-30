<?php

namespace Tests\Feature;

use App\Models\Topic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TopicTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Indicates whether the default seeder should run before each test.
     *
     * @var bool
     */
    protected $seed = true;

    public function test_view_topics(): void
    {
        $response = $this->get(route('topics.index'));
        $response->assertViewIs('topic.index')->assertViewHas('topics')->assertSuccessful();
    }

    public function test_search_topics(): void
    {
        $response = $this->get(route('topics.index', ['search' => fake()->randomLetter(),]));
        $response->assertViewIs('topic.index')->assertViewHas('topics')->assertSuccessful();
    }

    public function test_show_topic(): void
    {
        $topic = Topic::get()->random();
        $response = $this->get(route('topics.show', $topic->slug));
        $response->assertViewIs('topic.topic-posts')
            ->assertViewHas('topic', $topic)
            ->assertViewHas('posts')
            ->assertSuccessful();
    }

    public function test_auth_user_can_see_create_topic_form(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('topics.create'));
        $response->assertViewIs('topic.create-edit')->assertSuccessful();
    }

    public function test_auth_user_can_store_topic(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->followingRedirects()
            ->post(route('topics.store'), [
                'title' => 'test title',
                'subtitle' => 'test subtitle',
            ]);

        $this->assertDatabaseHas('topics', [
            'title' => 'test title',
            'subtitle' => 'test subtitle',
            'user_id' => $user->id,
        ]);

        $response->assertViewIs('topic.create-edit')
            ->assertSee(['test title', 'test subtitle'])
            ->assertSuccessful();
    }

    public function test_auth_user_can_see_edit_own_topic_form(): void
    {
        $user = User::factory()->create();
        $topic = Topic::factory()->create(['user_id' => $user->id,]);

        $response = $this->actingAs($user)->get(route('topics.edit', $topic->slug));
        $response->assertViewIs('topic.create-edit')
            ->assertViewHas('topic', $topic)
            ->assertSuccessful();
    }

    public function test_auth_user_can_update_own_topic(): void
    {
        $user = User::factory()->create();
        $topic = Topic::factory()->create(['user_id' => $user->id,]);

        $response = $this->actingAs($user)
            ->from(route('topics.edit', $topic->slug))
            ->followingRedirects()
            ->put(route('topics.update', $topic->slug), [
                'title' => 'new test title',
                'subtitle' => $topic->subtitle,
            ]);

        $this->assertDatabaseMissing('topics', [
            'id' => $topic->id,
            'title' => $topic->title,
            'user_id' => $topic->id,
        ])
            ->assertDatabaseHas('topics', [
                'id' => $topic->id,
                'title' => 'new test title',
                'user_id' => $user->id,
            ]);

        $response->assertViewIs('topic.create-edit')->assertSee('new test title')->assertSuccessful();
    }

    public function test_auth_user_can_destroy_own_topic(): void
    {
        $user = User::factory()->create();
        $topic = Topic::factory()->create(['user_id' => $user->id,]);

        $response = $this->actingAs($user)->delete(route('topics.destroy', $topic->slug));

        $this->assertSoftDeleted($topic);
    }

    public function test_auth_user_can_restore_own_topic(): void
    {
        $user = User::factory()->create();
        $topic = Topic::factory()->create(['user_id' => $user->id,]);
        $topic->delete();

        $response = $this->actingAs($user)->patch(route('topics.restore', $topic->slug));

        $this->assertDatabaseHas('topics', ['id' => $topic->id, 'deleted_at' => null, 'user_id' => $user->id,]);
    }
}
