<?php

use Illuminate\Database\Seeder;

class CbeInfoBusNamesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('cbe_info_bus_names')->delete();
        
        \DB::table('cbe_info_bus_names')->insert(array (
            0 => 
            array (
                'id' => 1,
                'bus_name' => '93',
                'created_by' => 1,
                'updated_by' => NULL,
                'created_at' => '2019-02-24 09:59:15',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'bus_name' => '65A',
                'created_by' => 1,
                'updated_by' => NULL,
                'created_at' => '2019-02-24 10:05:23',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'bus_name' => '70',
                'created_by' => 1,
                'updated_by' => NULL,
                'created_at' => '2019-02-24 10:13:37',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}