<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $adminPermTitles=[
            'create-any-task', // create task for any project
            'edit-any-task', // edit task for any project
            'delete-any-task', // delete task for any project
            'create-project', // create project
            'edit-any-project', // edit any project
            'delete-any-project', // delete any project
        ];

        $userPermissionTitles=[
            'create-task', // create task for owned project
            'edit-task', // edit task for owned project
            'delete-task', // delete task for owned project
            'create-project', // create project
            'edit-project', // edit project
            'delete-project', // delete project
        ];
        $allPermTitles=array_merge($adminPermTitles, $userPermissionTitles);
        $allPermTitles=array_unique($allPermTitles);

        // Seed Permissions
        $allPerms=array_map(
            function ($item) {
                return ['title' => $item];
            }, $allPermTitles
        );
        Permission::insert($allPerms);

        // create user role
        $userRole=Role::create(['title' => 'user']);
        // set permissions for user role
        $userRole->permissions()->attach(
            Permission::whereIn('title', $userPermissionTitles)->get()
        );

        // create admin role
        $adminRole=Role::create(['title' => 'admin']);
        // set permissions for admin role
        $adminRole->permissions()
            ->attach(Permission::whereIn('title', $adminPermTitles)->get());

        // create an admin
        $admin=User::create(
            [
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt('password'),
            ]
        );

        // set admin role
        $admin->roles()->attach($adminRole);
    }
}
