<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Composer;

class GenerateCrud extends Command
{
        /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:cred {controlName : Class (singular) for example Post}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Composer $composer,Command $command)
    {
        parent::__construct();
        $this->composer = $composer;
        $this->command = $command;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->getTimeZione();
        
        $controlName = $this->getArgument('controlName');  

        if (File::exists(app_path('\\'.$this->prepareModelFileName($controlName)))) 
         {
            if($this->confirm('CRUD FOR MODEL '.$controlName.'  HAS BEEN ALREADY GENERATED DO YOU WANT TO CONTINUE?? ')) 
            {
                $this->info('OverWriting the Existing Files');

                $this->handleOverWriteFunctions($controlName);

            }else
            {
                exit($this->info('No files has been generated'));
            }             
         }
         else
         {
            $this->handleAllFunctions($controlName);

         }

        $this->composer->dumpAutoloads();
        $this->composer->dumpOptimized();     
        


        $controlName = $this->getArgument('controlName');  
        

           
    }

    public function handleAllFunctions($controlName='')
    {
        $this->generateRoutes($controlName);
        $this->generateModel($controlName);
        $this->generateController($controlName);
        $this->creteRequiredFolders($controlName);
        $this->generateResource($controlName);
        $this->generateStoreRequest($controlName);
        $this->generateUpdateRequest($controlName);
        $this->generateBaseRepositoryFiles($controlName);
        $this->generateRepositoryClass($controlName);
        $this->generateRepositoryInterface($controlName);
        $this->generateMigration($controlName);
        $this->generateFaker($controlName);
        $this->generateIndex($controlName);
        $this->generateCreate($controlName);
        $this->generateForm($controlName);
        $this->generateEdit($controlName);
        $this->generateShow($controlName);
    }

    public function handleOverWriteFunctions($controlName='')
    {
        
        $this->generateModel($controlName);
        $this->generateController($controlName);
        $this->creteRequiredFolders($controlName);
        $this->generateResource($controlName);
        $this->generateStoreRequest($controlName);
        $this->generateUpdateRequest($controlName);
        $this->generateBaseRepositoryFiles($controlName);
        $this->generateRepositoryClass($controlName);
        $this->generateRepositoryInterface($controlName);
        $this->generateFaker($controlName);
        $this->generateIndex($controlName);
        $this->generateCreate($controlName);
        $this->generateForm($controlName);
        $this->generateEdit($controlName);
        $this->generateShow($controlName);
    }

    private  function getArgument($controlName='')
    {
        return $this->argument($controlName);
    }

    private function prepareModelClassName($controlName='')
    {
        return ucfirst($controlName);
    }

    protected function getDummyParameters()
     {
        $dummyArray =   [
                            '{{authorName}}','{{authorEmail}}','{{modelClassName}}',
                            '{{controllerClassName}}','{{variableNameSingular}}',
                            '{{variableNamePlural}}','{{tableName}}','{{storeRequestClassName}}',
                            '{{updateRequestClassName}}','{{resourceClassName}}','{{viewFolderName}}',
                            '{{baseRepositoryClassName}}','{{baseRepositoryInterfaceName}}','{{repositoryClassName}}',
                            '{{repositoryInterfaceName}}','{{migrationClassName}}','{{generatedAt}}',
                        ];

        return $dummyArray;
     } 


     public function generateBaseRepositoryFiles($controlName='')
     {
        $this->generateBaseRepositoryClass($controlName);
        $this->generateBaseRepositoryInterface($controlName);
     }

     protected function getOriginalParameters($controlName)
     {
         $originalArray =   [
                                'A. Manojkiran', 'manojkiran10031998@gmail.com', $this->prepareModelClassName($controlName),
                                $this->prepareControllerClassName($controlName),$this->prepareSingularVariableName($controlName),
                                $this->preparePluralVariableName($controlName),$this->preparetableName($controlName),$this->prepareStoreRequestClassName($controlName),
                                $this->prepareUpdateRequestClassName($controlName),$this->detResourceCN($controlName),$this->prepareVieweFolderName($controlName),
                                $this->getBaseRepositoryClassName(),$this->getBaseRepositoryInterfaceName(),$this->generateRepositoryClassName($controlName),
                                $this->generateRepositoryInterfaceClassName($controlName),$this->prepareMigrationClassName($controlName),$this->getCurrentTimeStamp(),
                            ];

        return $originalArray;
     } 

     protected function generateRepositoryClass($controlName='')
    {
        $this->findForReplaceAndCreate(
                                        $controlName,$this->getDummyParameters(),$this->getOriginalParameters($controlName),$this->getStubContents('Repository'),$this->getRepositoryFolderPath(),
                                        $this->generateRepositoryFileName($controlName)
                                      );
    }

    protected function generateRepositoryInterface($controlName='')
    {
        $this->findForReplaceAndCreate(
                                        $controlName,$this->getDummyParameters(),$this->getOriginalParameters($controlName),$this->getStubContents('RepositoryInterface'),
                                        $this->getRepositoryFolderPath(),$this->generateRepositoryInterfaceFileName($controlName)
                                      );
    }

    protected function generateMigration($controlName='')
    {

        $this->findForReplaceAndCreate(
                                            $controlName,$this->getDummyParameters(),$this->getOriginalParameters($controlName),$this->getStubContents('Migration'),
                                            $this->getDatabaseFolderPath(),$this->prepareMigrationFileName($controlName)
                                     );        
    }

    protected function generateFaker($controlName='')
    {

        $this->findForReplaceAndCreate(
                                            $controlName,$this->getDummyParameters(),$this->getOriginalParameters($controlName),$this->getStubContents('Factory'),
                                            $this->getFactoryFolderPath(),$this->prepareFakerFileName($controlName)
                                      );        
    }

    protected function generateIndex($controlName='')
    {

        $this->findForReplaceAndCreate(
                                            $controlName,$this->getDummyParameters(),$this->getOriginalParameters($controlName),$this->getStubContents('Index'),
                                            $this->prepareVieweFolderNameWithPath($controlName),'index.blade.php'
                                      );        
    }


    protected function generateCreate($controlName='')
    {

        $this->findForReplaceAndCreate(
                                            $controlName,$this->getDummyParameters(),$this->getOriginalParameters($controlName),$this->getStubContents('Create'),
                                            $this->prepareVieweFolderNameWithPath($controlName),'create.blade.php'
                                      );       
    }

    protected function generateForm($controlName='')
    {

        $this->findForReplaceAndCreate(
                                            $controlName,$this->getDummyParameters(),$this->getOriginalParameters($controlName),$this->getStubContents('Form'),
                                            $this->prepareVieweFolderNameWithPath($controlName),'_form.blade.php'
                                      );
    }

    protected function generateEdit($controlName='')
    {

        $this->findForReplaceAndCreate(
                                            $controlName,$this->getDummyParameters(),$this->getOriginalParameters($controlName),$this->getStubContents('Edit'),
                                            $this->prepareVieweFolderNameWithPath($controlName),'edit.blade.php'
                                      );
    }

    protected function generateShow($controlName='')
    {
        $this->findForReplaceAndCreate(
                                            $controlName,$this->getDummyParameters(),$this->getOriginalParameters($controlName),$this->getStubContents('Show'),
                                            $this->prepareVieweFolderNameWithPath($controlName),'show.blade.php'
                                      );
    }


    protected function prepareMigrationFileName($controlName='')
    {
        return date('Y_m_d_His').'_create_'.$this->preparetableName($controlName).'_table.php';
    }

    private function prepareFakerFileName($controlName='')
    {
        return $this->prepareModelClassName($controlName).'Factory.php';
    }

    private function prepareMigrationClassName($controlName='')
    {
        return "Create".Str::plural(ucfirst($controlName))."Table";
    }

    private function generateRepositoryClassName($controlName='')
    {
        
        return $this->prepareModelClassName($controlName).'Repository';
    }

    private function generateRepositoryFileName($controlName='')
    {
        
        return $this->generateRepositoryClassName($controlName).'.php';
    }


     private function generateRepositoryInterfaceClassName($controlName='')
    {
        
        return $this->generateRepositoryClassName($controlName).'Interface';
    }

    private function generateRepositoryInterfaceFileName($controlName='')
    {
        
        return $this->generateRepositoryInterfaceClassName($controlName).'.php';
    }



     
    protected function generateBaseRepositoryClass($controlName)
    {
        $this->findForReplaceAndCreateIfNotExists(
                                                    $controlName,$this->getDummyParameters(),$this->getOriginalParameters($controlName),
                                                    $this->getStubContents('BaseRepository'),$this->getRepositoryFolderPath(),$this->getBaseRepositoryFileName()
                                                 );
    }

    protected function generateBaseRepositoryInterface($controlName)
    {
        $this->findForReplaceAndCreateIfNotExists(
                                                    $controlName,$this->getDummyParameters(),$this->getOriginalParameters($controlName),
                                                    $this->getStubContents('BaseRepositoryInterface'),$this->getRepositoryFolderPath(),
                                                    $this->getBaseRepositoryInterfaceFileName()
                                                 );
    }

    public function getBaseRepositoryClassName() {
        return 'BaseRepository';
    }
    public function getBaseRepositoryFileName() {
        return $this->getBaseRepositoryClassName() . '.php';
    }
    public function getBaseRepositoryInterfaceName() {
        return $this->getBaseRepositoryClassName() . 'Interface';
    }
    public function getBaseRepositoryInterfaceFileName() {
        return $this->getBaseRepositoryInterfaceName() . '.php';
    }

    protected function generateModel($controlName)
    {
        $this->findForReplaceAndCreate(
                                            $controlName,$this->getDummyParameters(),$this->getOriginalParameters($controlName),$this->getStubContents('Model'),
                                            $this->prepareModelFolderName(),$this->prepareModelFileName($controlName)
                                      );
    }
    protected function generateResource($controlName)
    {
        $this->findForReplaceAndCreate(
                                            $controlName,$this->getDummyParameters(),$this->getOriginalParameters($controlName),$this->getStubContents('Resource'),
                                            $this->detResourceFolder(),$this->prepareResourceFileName($controlName)
                                      );
    }
    protected function generateStoreRequest($controlName)
    {
        $this->findForReplaceAndCreate(
                                            $controlName,$this->getDummyParameters(),$this->getOriginalParameters($controlName),$this->getStubContents('StoreRequest'),
                                            $this->detRequestFolder(),$this->prepareStoreRequestFileName($controlName)
                                      );
    }
    protected function generateUpdateRequest($controlName)
    {
       $this->findForReplaceAndCreate(
                                            $controlName,$this->getDummyParameters(),$this->getOriginalParameters($controlName),$this->getStubContents('UpdateRequest'),
                                            $this->detRequestFolder(),$this->prepareUpdateRequestFileName($controlName)
                                     );
    }

    protected function generateController($controlName)
    {
        $this->findForReplaceAndCreate(
                                            $controlName,$this->getDummyParameters(),$this->getOriginalParameters($controlName),
                                            $this->getStubContents('Controller'),$this->prepareControllerFolderName(),$this->prepareControllerFileName($controlName)
                                      );
    }

    private function prepareStoreRequestClassName($controlName='')   {   return $this->prepareModelClassName($controlName).'StoreRequest';   }
    private function prepareStoreRequestFileName($controlName='')    {   return $this->prepareStoreRequestClassName($controlName).'.php';    }
    private function prepareUpdateRequestClassName($controlName='')  {   return $this->prepareModelClassName($controlName).'UpdateRequest';  }
    private function prepareUpdateRequestFileName($controlName='')   {   return $this->prepareUpdateRequestClassName($controlName).'.php';   }

    private function creteRequiredFolders($controlName='')
    {
            $this->creatFolderIfNotExists($this->getRepositoryFolderPath());
            $this->creatFolderIfNotExists($this->detRequestFolder());
            $this->creatFolderIfNotExists($this->detResourceFolder());
            $this->creatFolderIfNotExists($this->prepareVieweFolderNameWithPath($controlName)); 
    }

    private function getRepositoryFolderPath()                      {   return app_path(DIRECTORY_SEPARATOR.'Repositories'.DIRECTORY_SEPARATOR);    }
    private function getDatabaseFolderPath()                        {   return database_path(DIRECTORY_SEPARATOR.'migrations'.DIRECTORY_SEPARATOR); }
    private function getFactoryFolderPath()                         {   return database_path(DIRECTORY_SEPARATOR.'factories'.DIRECTORY_SEPARATOR);  }
    private function prepareVieweFolderName($controlName='')        {   return str_plural(strtolower($controlName));                                }
    private function prepareVieweFolderNameWithPath($controlName='')
    {
        return $this->prepareViewPathName($controlName).$this->prepareVieweFolderName($controlName).DIRECTORY_SEPARATOR;
    }
    private function prepareViewPathName($controlName='')           {   return resource_path(DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR);        }
    private function detResourceFolder()      {     return app_path(DIRECTORY_SEPARATOR.'Http'.DIRECTORY_SEPARATOR.'Resources'.DIRECTORY_SEPARATOR);  }
    private function detRequestFolder()       {     return app_path(DIRECTORY_SEPARATOR.'Http'.DIRECTORY_SEPARATOR.'Requests'.DIRECTORY_SEPARATOR);   }
    private function detResourceCN($controlName='') {        return $this->prepareModelClassName($controlName).'Resource';       }    
    private function detRepoCN($controlName='')     {        return $this->prepareModelClassName($controlName).'Repository';     }
    private function detRepoFN($controlName='')     {       return $this->prepareModelClassName($controlName).'Repository.php';  }      

    protected function generateRoutes($controlName='')
    {
        $this->generateWebRoutes($controlName);
        $this->generateApiRoutes($controlName);
    }
    protected function generateWebRoutes($controlName='')
    {
        $this->findForReplaceAndAppend(
                                            $controlName,$this->getDummyParameters(),$this->getOriginalParameters($controlName),
                                            $this->getStubContents('WebRoutes'),$this->detWEBRouteFP()
                                      );
    }

    protected function generateApiRoutes($controlName='')
    {
        $this->findForReplaceAndAppend(
                                            $controlName,$this->getDummyParameters(),$this->getOriginalParameters($controlName),
                                            $this->getStubContents('ApiRoutes'),$this->detAPIRouteFP()
                                      );
    }

    private function creatFolderIfNotExists($folderWithFileName='')
    {
        if(!File::isDirectory($folderWithFileName))
        {
            File::makeDirectory($folderWithFileName, 0777, true, true);
        }
    }



    private function detWEBRouteFP()        {return base_path(DIRECTORY_SEPARATOR.'routes'.DIRECTORY_SEPARATOR.'web.php');      }
    private function detAPIRouteFP()        {return base_path(DIRECTORY_SEPARATOR.'routes'.DIRECTORY_SEPARATOR.'api.php');      }
    private function preparePluralVariableName($controlName='')     {   return str_plural(camel_case($controlName));    }
    private function prepareSingularVariableName($controlName='')   {return camel_case($controlName);                   }
    private function getCurrentTimeStamp()      {            return date('l jS \of F Y h:i:s A');                        }
    private function prepareModelFileName($controlName='')  { return $this->prepareModelClassName($controlName).'.php';  }
    private function prepareResourceFileName($controlName='') {return $this->detResourceCN($controlName).'.php';    }
    private function preparetableName($controlName=''){return Str::plural(strtolower(Str::snake($controlName)));    }
    private function prepareModelFolderName()   {   return app_path(DIRECTORY_SEPARATOR.'Models'.DIRECTORY_SEPARATOR);   }

    private function prepareControllerFolderName()
    {
        return  app_path(DIRECTORY_SEPARATOR.'Http'.DIRECTORY_SEPARATOR.'Controllers'.DIRECTORY_SEPARATOR);
    }
    private function prepareControllerClassName($controlName='')    { return $this->prepareModelClassName($controlName).'Controller';   } 
    private function prepareControllerFileName($controlName='')     {   return $this->prepareControllerClassName($controlName).'.php';  }
    private  function getTimeZione()        {       return date_default_timezone_set('Asia/Calcutta');      }



    private function findForReplaceAndAppend($controlName='',$dummyStubContent='',$newStubContent='',$stubContents='',$realFileName='')
    {
        $lineBreak="\n";
        $newContent = $this->replaceInStub($dummyStubContent,$newStubContent,$stubContents);
        $this->appendToFile($realFileName,$lineBreak.$newContent);
    }

    private function findForReplaceAndCreate($controlName='',$dummyStubContent='',$newStubContent='',$stubContents='',$filePath='',$fileName='')
    {
        $fileContents = $this->replaceInStub($dummyStubContent,$newStubContent,$stubContents);
        file_put_contents($filePath.$fileName,$fileContents);
    }

    private function findForReplaceAndCreateIfNotExists($controlName='',$dummyStubContent='',$newStubContent='',$stubContents='',$filePath='',$fileName='')
    {
        $fileWithPath = $filePath.$fileName;

        if (!File::exists($fileWithPath)) 
        {
            $fileContents = $this->replaceInStub($dummyStubContent,$newStubContent,$stubContents);
            file_put_contents($filePath.$fileName,$fileContents);
        }
        
    }

    private function replaceInStub($findFor='',$replaceWith='',$paragraphText='')
    {
        $newPhrase = str_replace($findFor, $replaceWith, $paragraphText);
        return $newPhrase;
    }

    private function appendToFile($filePath='',$text='')
    {
        File::append($filePath,$text."\n");
    }

    private function getStubContents($type)
    {
        return file_get_contents(resource_path("stubsbread/$type.stub"));
    }
}
