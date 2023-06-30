<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create(['nickname' => 'admin', 'email' => 'admin@example.com'])
            ->roles()->attach([
                Role::where('role', 'administrator')->first()->id,
                Role::where('role', 'moderator')->first()->id
            ]);
        User::factory(2)->create()->each(function ($user) {
            $user->roles()->attach(Role::where('role', 'moderator')->first()->id);
        });
        User::factory(32)->create();
    }
}
