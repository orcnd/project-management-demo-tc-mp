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
     * Seed the application's database.
     */
    public function run(): void
    {
        // Permissions
        Permission::insert([
            ['title' => 'create-tasks'],
            ['title' => 'edit-tasks'],
            ['title' => 'delete-tasks'],
            ['title' => 'create-projects'],
            ['title' => 'edit-projects'],
            ['title' => 'delete-projects'],
            ['title' => 'create-users'],
            ['title' => 'edit-users'],
            ['title' => 'delete-users'],
            ['title' => 'create-roles'],
            ['title' => 'edit-roles'],
            ['title' => 'delete-roles'],
            ['title' => 'create-permissions'],
            ['title' => 'edit-permissions'],
            ['title' => 'delete-permissions'],
        ]);
        
        // Roles
        Role::create(['title' => 'user']);
        $adminRole=Role::create(['title' => 'admin']);
        $adminRole->permissions()->attach(Permission::all());
        
        $admin=User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
        ]);
        
        $admin->roles()->attach($adminRole);
    }
}
