<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('countries')->delete();
        
        \DB::table('countries')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Canada',
                'country_code' => 1,
                'created_at' => '2022-11-15 00:22:26',
                'updated_at' => '2022-11-15 00:22:26',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}