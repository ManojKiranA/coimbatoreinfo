<?php

use Illuminate\Database\Seeder;

class CbeInfoLocationFromsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('cbe_info_location_froms')->delete();
        
        \DB::table('cbe_info_location_froms')->insert(array (
            0 => 
            array (
                'id' => 1,
                'location_from_name' => 'Gandhipuram',
                'created_by' => 1,
                'updated_by' => NULL,
                'created_at' => '2019-02-24 09:56:50',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}