<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']);

        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        $permissions = [
            'manage inventory',
            'monitor admin'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $superAdminRole->syncPermissions($permissions);
        $adminRole->syncPermissions(['manage inventory']);

        $superAdmin = User::firstOrCreate([
            'email' => 'superadmin@gmail.com'
        ], [
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'dob' => '1990-12-10',
            'username' => 'superadmin',
            'name' => 'superadmin',
            'mobile' => '1234567890',
            'address' => '123 Admin St',
            'state' => 'Admin State',
            'city' => 'Admin City',
            'pincode' => '123456',
            'password' => bcrypt('Welcome@123')
        ]);

        $superAdmin->assignRole($superAdminRole);
    }
}
