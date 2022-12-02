<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // membuat seeder User
        $admin = User::create([
            "name"      => "admin",
            "email"     => "admin@test",
            "password"  => Hash::make("admin123"),
        ]);
        $permission = Permission::all();
        $role = Role::find(1);
        $role->syncPermissions($permission);
        $admin->assignRole($role);
    }
}
