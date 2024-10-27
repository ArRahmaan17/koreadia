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
            'phone_number' => '(+62) 895-229-83270',
            'valid' => TRUE,
            'created_at' => now(),
        ]);
        \App\Models\Menu::insert([
            [
                'id' => '1',
                'name' => 'Dashboard',
                'route' => 'home',
                'icon' => 'ri-home-smile-2-fill',
                'parent' => 0,
                'place' => 0,
                'created_at' => '2024-10-26 19:45:22',
                'updated_at' => '2024-10-26 19:45:22'
            ],
            [
                'id' => '2',
                'name' => 'Master',
                'route' => '#master',
                'icon' => 'bx bxs-data',
                'parent' => 0,
                'place' => 0,
                'created_at' => '2024-10-27 02:48:13',
                'updated_at' => '2024-10-27 02:48:13'
            ],
            [
                'id' => '3',
                'name' => 'Menu',
                'route' => 'master.menu.index',
                'icon' => 'bx bx-list-ol',
                'parent' => 2,
                'place' => 0,
                'created_at' => '2024-10-27 02:49:12',
                'updated_at' => '2024-10-27 02:49:12'
            ],
            [
                'id' => '8',
                'name' => 'Role',
                'route' => 'master.role.index',
                'icon' => 'bx bxs-user-check',
                'parent' => 2,
                'place' => 0,
                'created_at' => '2024-10-27 02:54:39',
                'updated_at' => '2024-10-27 02:54:39'
            ],
            [
                'id' => '9',
                'name' => 'Mail',
                'route' => '#mail',
                'icon' => 'bx bxs-envelope',
                'parent' => 2,
                'place' => 0,
                'created_at' => '2024-10-27 02:56:32',
                'updated_at' => '2024-10-27 02:56:32'
            ],
            [
                'id' => '6',
                'name' => 'Priority',
                'route' => 'master.priority.index',
                'icon' => 'bx bx-list-check',
                'parent' => 9,
                'place' => 0,
                'created_at' => '2024-10-27 02:52:08',
                'updated_at' => '2024-10-27 02:52:08'
            ],
            [
                'id' => '5',
                'name' => 'Agenda',
                'route' => 'master.agenda.index',
                'icon' => 'bx bxs-calendar-event',
                'parent' => 9,
                'place' => 0,
                'created_at' => '2024-10-27 02:50:49',
                'updated_at' => '2024-10-27 02:50:49'
            ],
            [
                'id' => '4',
                'name' => 'Type',
                'route' => 'master.type.index',
                'icon' => 'bx bxs-grid',
                'parent' => 9,
                'place' => 0,
                'created_at' => '2024-10-27 02:49:54',
                'updated_at' => '2024-10-27 02:49:54'
            ],
            [
                'id' => '10',
                'name' => 'Mail In',
                'route' => 'mail.in.index',
                'icon' => 'bx bx-mail-send',
                'parent' => 0,
                'place' => 0,
                'created_at' => '2024-10-27 03:02:20',
                'updated_at' => '2024-10-27 03:02:20'
            ],
            [
                'id' => '11',
                'name' => 'Role User',
                'route' => 'master.role-user.index',
                'icon' => 'bx bxs-user-voice',
                'parent' => 2,
                'place' => 0,
                'created_at' => '2024-10-27 03:15:57',
                'updated_at' => '2024-10-27 03:15:57'
            ],
            [
                'id' => '12',
                'name' => 'User',
                'route' => 'master.user.index',
                'icon' => 'bx bxs-group',
                'parent' => 2,
                'place' => 0,
                'created_at' => '2024-10-27 03:48:42',
                'updated_at' => '2024-10-27 03:48:42'
            ]
        ]);
        \App\Models\Role::insert([
            [
                'id' => '1',
                'name' => 'Developer',
                'description' => 'Developer App',
                'created_at' => '2024-10-26 19:45:22',
                'updated_at' => '2024-10-26 19:45:22'
            ],
            [
                'id' => '2',
                'name' => 'Admin Sistem',
                'description' => 'Sistem Administrator',
                'created_at' => '2024-10-27 02:46:40',
                'updated_at' => '2024-10-27 02:46:40'
            ],
            [
                'id' => '3',
                'name' => 'Admin Biro Umum',
                'description' => 'Biro Umum Administrator',
                'created_at' => '2024-10-27 02:47:05',
                'updated_at' => '2024-10-27 02:47:05'
            ],
            [
                'id' => '4',
                'name' => 'User Eselon',
                'description' => 'Sistem Eselon User',
                'created_at' => '2024-10-27 02:47:29',
                'updated_at' => '2024-10-27 02:47:29'
            ]
        ]);
        \App\Models\RoleMenu::insert([
            [
                'id' => '1',
                'role_id' => '1',
                'menu_id' => '1',
                'created_at' => '2024-10-26 19:45:22',
                'updated_at' => '2024-10-26 19:45:22'
            ],
            [
                'id' => '2',
                'role_id' => '2',
                'menu_id' => '1',
                'created_at' => '2024-10-27 02:46:40',
                'updated_at' => '2024-10-27 02:46:40'
            ],
            [
                'id' => '3',
                'role_id' => '3',
                'menu_id' => '1',
                'created_at' => '2024-10-27 02:47:05',
                'updated_at' => '2024-10-27 02:47:05'
            ],
            [
                'id' => '4',
                'role_id' => '4',
                'menu_id' => '1',
                'created_at' => '2024-10-27 02:47:29',
                'updated_at' => '2024-10-27 02:47:29'
            ],
            [
                'id' => '5',
                'role_id' => '1',
                'menu_id' => '2',
                'created_at' => '2024-10-27 09:48:13',
                'updated_at' => null
            ],
            [
                'id' => '6',
                'role_id' => '2',
                'menu_id' => '2',
                'created_at' => '2024-10-27 09:48:13',
                'updated_at' => null
            ],
            [
                'id' => '7',
                'role_id' => '1',
                'menu_id' => '3',
                'created_at' => '2024-10-27 09:49:12',
                'updated_at' => null
            ],
            [
                'id' => '8',
                'role_id' => '1',
                'menu_id' => '4',
                'created_at' => '2024-10-27 09:49:54',
                'updated_at' => null
            ],
            [
                'id' => '9',
                'role_id' => '2',
                'menu_id' => '4',
                'created_at' => '2024-10-27 09:49:54',
                'updated_at' => null
            ],
            [
                'id' => '10',
                'role_id' => '1',
                'menu_id' => '5',
                'created_at' => '2024-10-27 09:50:49',
                'updated_at' => null
            ],
            [
                'id' => '11',
                'role_id' => '2',
                'menu_id' => '5',
                'created_at' => '2024-10-27 09:50:49',
                'updated_at' => null
            ],
            [
                'id' => '12',
                'role_id' => '1',
                'menu_id' => '6',
                'created_at' => '2024-10-27 09:52:08',
                'updated_at' => null
            ],
            [
                'id' => '13',
                'role_id' => '2',
                'menu_id' => '6',
                'created_at' => '2024-10-27 09:52:08',
                'updated_at' => null
            ],
            [
                'id' => '16',
                'role_id' => '1',
                'menu_id' => '8',
                'created_at' => '2024-10-27 09:54:39',
                'updated_at' => null
            ],
            [
                'id' => '17',
                'role_id' => '1',
                'menu_id' => '9',
                'created_at' => '2024-10-27 09:56:32',
                'updated_at' => null
            ],
            [
                'id' => '18',
                'role_id' => '2',
                'menu_id' => '9',
                'created_at' => '2024-10-27 09:56:32',
                'updated_at' => null
            ],
            [
                'id' => '19',
                'role_id' => '1',
                'menu_id' => '10',
                'created_at' => '2024-10-27 10:02:20',
                'updated_at' => null
            ],
            [
                'id' => '20',
                'role_id' => '2',
                'menu_id' => '10',
                'created_at' => '2024-10-27 10:02:20',
                'updated_at' => null
            ],
            [
                'id' => '21',
                'role_id' => '3',
                'menu_id' => '10',
                'created_at' => '2024-10-27 10:02:20',
                'updated_at' => null
            ],
            [
                'id' => '22',
                'role_id' => '4',
                'menu_id' => '10',
                'created_at' => '2024-10-27 10:02:20',
                'updated_at' => null
            ],
            [
                'id' => '23',
                'role_id' => '1',
                'menu_id' => '11',
                'created_at' => '2024-10-27 10:15:57',
                'updated_at' => null
            ],
            [
                'id' => '24',
                'role_id' => '1',
                'menu_id' => '12',
                'created_at' => '2024-10-27 10:48:42',
                'updated_at' => null
            ]
        ]);
        \App\Models\RoleUser::insert([
            [
                'id' => '1',
                'user_id' => '1',
                'role_id' => '1',
                'created_at' => '2024-10-26 19:45:22',
                'updated_at' => '2024-10-26 19:45:22'
            ]
        ]);
    }
}
