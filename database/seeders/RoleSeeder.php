<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'student']);
        Role::create(['name' => 'teacher']);
        Role::create(['name' => 'schoolAdmin']);
//        Permission::create(['name' => 'puedeCrearPosts']);
//        Permission::create(['name' => 'post create']);
//        Permission::create(['name' => 'admin usuarios']);
//        Permission::create(['name' => 'subir recursos']);
//        Permission::create(['name' => 'ver cursos']);
    }
}
