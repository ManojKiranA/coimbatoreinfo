<?php

use Illuminate\Database\Seeder;
use App\Models\User;
class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Karthick',
                'email' => 'manoj@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$RgEnAGbp7kfXWJUYpRCHgu4kDFz2Ziu4EjMaa.1PRaljP2OjjHKVS',
                'remember_token' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2019-02-23 07:31:32',
                'updated_at' => '2019-02-23 07:31:32',
            ),
        ));

        factory(User::class, 3)->create();
        
        
    }
}