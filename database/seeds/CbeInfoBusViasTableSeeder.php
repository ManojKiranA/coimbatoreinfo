<?php

use Illuminate\Database\Seeder;

class CbeInfoBusViasTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('cbe_info_bus_vias')->delete();
        
        \DB::table('cbe_info_bus_vias')->insert(array (
            0 => 
            array (
                'id' => 1,
                'bus_via_name' => 'Peelamedu,Sitra,Chinniyampalyam,kulathur',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2019-02-24 09:59:37',
                'updated_at' => '2019-02-24 10:06:52',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'bus_via_name' => 'Lakshmimills,Peelamedu,ESI,Singanallur',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2019-02-24 10:05:45',
                'updated_at' => '2019-02-24 10:07:33',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'bus_via_name' => 'Sivanantha colony,Saibaba colony,Agriculture college,Bharathiyar University',
                'created_by' => 1,
                'updated_by' => NULL,
                'created_at' => '2019-02-24 10:15:06',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}