<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $user = User::create([
        //     'name' => 'Admin', 
        //     'email' => 'admin@gmail.com',
        //     'password' => 'admin123'
        // ]);
    
        // $role = Role::create(['name' => 'admin']);
     
        // $permissions = Permission::pluck('id','id')->all();
   
        // $role->syncPermissions($permissions);
     
        // $user->assignRole([$role->id]);

        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);
    }
}