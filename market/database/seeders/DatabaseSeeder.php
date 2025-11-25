<?php

namespace Database\Seeders;

use App\Enums\Role\RoleEnum;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = [
            'name' => 'user',
            'email' => 'user@mail.ru',
            'password' => Hash::make(1234),
        ];

        $user = User::firstOrCreate([
            'email' => $user['email'],
        ], $user);

        $role = Role::firstOrCreate([
            'title' => RoleEnum::ADMIN->value,
        ]);

        $user->roles()->sync($role->id);
    }
}
