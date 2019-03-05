<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

use App\Models\CbeInfoLocationFrom;
use App\Models\CbeInfoLocationTo;
use App\Models\CbeInfoBusVia;
use App\Models\CbeInfoBusType;
use App\Models\CbeInfoBusName;
use App\Models\CbeInfoBusTiming;




class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        Schema::disableForeignKeyConstraints();

        $this->truncateAllTables();
        $this->call(UsersTableSeeder::class);
        // factory(CbeInfoLocationFrom::class, 100)->create();
        // factory(CbeInfoLocationTo::class, 100)->create();
        // factory(CbeInfoBusVia::class, 50)->create();
        // factory(CbeInfoBusType::class, 10)->create();
        // factory(CbeInfoBusName::class, 30)->create();
        // factory(CbeInfoBusTiming::class, 500)->create();        
        $this->call(CbeInfoBusNamesTableSeeder::class);
        $this->call(CbeInfoBusTypesTableSeeder::class);
        $this->call(CbeInfoBusViasTableSeeder::class);
        $this->call(CbeInfoLocationFromsTableSeeder::class);
        $this->call(CbeInfoLocationTosTableSeeder::class);
        $dispatcher = CbeInfoBusTiming::getEventDispatcher();
        // disabling the events
        CbeInfoBusTiming::unsetEventDispatcher();
        // perform the operation you want
        factory(CbeInfoBusTiming::class, 1000)->create();
        //$eventToDone;
        // enabling the event dispatcher
        CbeInfoBusTiming::setEventDispatcher($dispatcher);
        // $this->disableEvents('CbeInfoBusTiming',['App','Models'],factory(CbeInfoBusTiming::class, 1500)->create());

        Schema::enableForeignKeyConstraints();

        


    }

    private function truncateAllTables()
    {
        $tableNames = Schema::getConnection()->getDoctrineSchemaManager()->listTableNames();

        foreach ($tableNames as $name)
        {
            //if you don't want to truncate migrations
            if ($name == 'migrations')
            {
                continue;
            }
            else
            {
                $this->command->warn('Truncating Table '.$name);
                DB::table($name)->truncate();
                $this->command->warn('Truncated Table '.$name);
            }
            

        }
    }
    public function disableEvents($modelTableName='',$nameSpace='',$eventToDone='')
    {
                //if the given name space iin array the implode to string with \\
                if (is_array($nameSpace))
                {
                    $nameSpace =  implode('\\', $nameSpace);
                }
                //by default laravel ships with name space App so while is $nameSpace is not passed considering the
                // model namespace as App
                if (empty($nameSpace) || is_null($nameSpace) || $nameSpace === "") 
                {                
                   $modelTableNameWithNameSpace = "App".'\\'.$modelTableName;
                }
                //if you are using custom name space such as App\Models\Base\Country.php
                //$namespce must be ['App','Models','Base']
                if (is_array($nameSpace)) 
                {
                    $modelTableNameWithNameSpace = $nameSpace.'\\'.$modelTableName;
                    
                }
                //if you are passing Such as App in name space
                elseif (!is_array($nameSpace) && !empty($nameSpace) && !is_null($nameSpace) && $nameSpace !== "") 
                {
                    $modelTableNameWithNameSpace = $nameSpace.'\\'.$modelTableName;
                     
                }
                //if the class exist with current namespace convert to container instance.
                if (class_exists($modelTableNameWithNameSpace)) 
                {
                        // $currentModelWithNameSpace = Container::getInstance()->make($modelTableNameWithNameSpace);
                        // use Illuminate\Container\Container;
                        $currentModelWithNameSpace = app($modelTableNameWithNameSpace);
                }
                //else throw the class not found exception
                else
                {
                    throw new \Exception("Unable to find Model : $modelTableName With NameSpace $nameSpace", E_USER_ERROR);
                }

                // getting the dispatcher instance (needed to enable again the event observer later on)
        $dispatcher = $currentModelWithNameSpace::getEventDispatcher();
        // disabling the events
        $currentModelWithNameSpace::unsetEventDispatcher();
        // perform the operation you want
        // factory(CbeInfoBusTiming::class, 1000)->create();
        $eventToDone;
        // enabling the event dispatcher
        $currentModelWithNameSpace::setEventDispatcher($dispatcher);

    }
}
