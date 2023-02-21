<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProviencesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('proviences')->delete();
        
        \DB::table('proviences')->insert(array (
            0 => 
            array (
                'id' => 1,
                'country_id' => 1,
                'provience_name' => 'British Columbia',
                'created_at' => '2022-11-15 00:23:25',
                'updated_at' => '2022-11-15 00:23:25',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'country_id' => 1,
                'provience_name' => 'Ontario',
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}