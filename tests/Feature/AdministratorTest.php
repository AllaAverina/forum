<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdministratorTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Indicates whether the default seeder should run before each test.
     *
     * @var bool
     */
    protected $seed = true;

    public function test_administrator_can_assign_user_as_moderator(): void
    {
        $admin = User::factory()->create();
        $admin->roles()->sync(Role::where('role', 'administrator')->first()->id);
        $user = User::factory()->create();

        $response = $this->actingAs($admin)->patch(route('moderators.assign', $user->nickname));
        
        $this->assertDatabaseHas('role_user', [
            'role_id' => Role::where('role', 'moderator')->first()->id,
            'user_id' => $user->id,
        ]);
    }

    public function test_administrator_can_remove_moderator(): void
    {
        $admin = User::factory()->create();
        $admin->roles()->sync(Role::where('role', 'administrator')->first()->id);

        $moderRoleId = Role::where('role', 'moderator')->first()->id;
        $moder = User::factory()->create();
        $moder->roles()->sync($moderRoleId);

        $response = $this->actingAs($admin)->patch(route('moderators.remove', $moder->nickname));

        $this->assertDatabaseMissing('role_user', ['role_id' => $moderRoleId, 'user_id' => $moder->id,]);
    }
}
