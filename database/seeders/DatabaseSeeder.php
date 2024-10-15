<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Doglex',
            'username' => 'dev.rahmaan',
            'password' => Hash::make('mamanrecing'),
            'avatar' => 'avatar-1.jpg',
            'created_at' => now(),
        ]);
        \App\Models\Role::create([
            'name' => 'Developer',
            'description' => 'Developer App',
        ]);
        \App\Models\RoleUser::create([
            'role_id' => 1,
            'user_id' => 1,
        ]);
        \App\Models\Menu::create([
            'name' => 'Dashboard',
            'route' => 'home',
            'icon' => 'ri-home-smile-2-fill',
            'place' => 0,
            'parent' => 0,
        ]);
        \App\Models\RoleMenu::create([
            'role_id' => 1,
            'menu_id' => 1,
        ]);
    }
}
