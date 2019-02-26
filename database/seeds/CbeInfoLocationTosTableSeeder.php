<?php

use Illuminate\Database\Seeder;

class CbeInfoLocationTosTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('cbe_info_location_tos')->delete();
        
        \DB::table('cbe_info_location_tos')->insert(array (
            0 => 
            array (
                'id' => 1,
                'location_to_name' => 'Irugur',
                'created_by' => 1,
                'updated_by' => NULL,
                'created_at' => '2019-02-24 09:57:21',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'location_to_name' => 'Sulur',
                'created_by' => 1,
                'updated_by' => NULL,
                'created_at' => '2019-02-24 10:04:37',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'location_to_name' => 'Maruthamalai',
                'created_by' => 1,
                'updated_by' => NULL,
                'created_at' => '2019-02-24 10:13:01',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}