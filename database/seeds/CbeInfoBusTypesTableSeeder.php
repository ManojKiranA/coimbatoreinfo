<?php

use Illuminate\Database\Seeder;

class CbeInfoBusTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('cbe_info_bus_types')->delete();
        
        \DB::table('cbe_info_bus_types')->insert(array (
            0 => 
            array (
                'id' => 1,
                'bus_type_name' => 'Govt',
                'created_by' => 1,
                'updated_by' => NULL,
                'created_at' => '2019-02-24 09:57:55',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'bus_type_name' => 'Pvt',
                'created_by' => 1,
                'updated_by' => NULL,
                'created_at' => '2019-02-24 10:05:03',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}