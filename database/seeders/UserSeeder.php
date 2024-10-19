<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdminUser = User::create([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'superadmin@mail.com',
            'password' => bcrypt('admin1234'),
            'type' => 1,
            'email_verified_at' => now(),
        ]);
        $superAdminRole = Role::create(['name' => 'Super Admin']);
        $superAdminUser->assignRole($superAdminRole);

        $adminUser = User::create([
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => bcrypt('admin'),
            'type' => 1,
            'email_verified_at' => now(),
        ]);
        $adminRole = Role::create(['name' => 'Admin']);
        $permissions = Permission::all();
        $adminRole->syncPermissions($permissions);
        $adminUser->assignRole($adminRole);
    }
}
