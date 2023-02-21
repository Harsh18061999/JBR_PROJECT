<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('roles')->delete();
        
        \DB::table('roles')->insert(array (
            0 => 
            array (
                'id' => 3,
                'name' => 'user',
                'guard_name' => 'web',
                'created_at' => '2023-02-19 01:20:02',
                'updated_at' => '2023-02-21 16:22:40',
            ),
            1 => 
            array (
                'id' => 4,
                'name' => 'admin',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:22:17',
                'updated_at' => '2023-02-20 17:23:49',
            ),
        ));
        
        
    }
}