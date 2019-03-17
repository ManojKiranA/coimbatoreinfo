<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CbeInfoBusTiming;
use App\Helpers\ApplicationHelper;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Builder;
use App\Models\User;


class SiteController extends Controller
{


    public function landingPage()
    {
    	//list of fields to be selected 
    	$selectArray = 	[	//select id from bus timings table
    						'cbe_info_bus_timings.id',
    						//select bus_time from bus timings table
    						'cbe_info_bus_timings.bus_time',
    						//select bus_name from cbe_info_bus_names table
    						'BNT.bus_name as busName',
    						//select bus_type_name from cbe_info_bus_types table
    						'BTT.bus_type_name as busType',
    						//select location_from_name from cbe_info_location_froms table
    						'LFT.location_from_name as locationFrom',
    						//select location_to_name from cbe_info_location_tos table
    						'LTT.location_to_name as toLocation',
                //select bus_via_name from cbe_info_bus_vias table
                'BVT.bus_via_name as busGoingVia',
    					];

              $currentTime = date('H:i');
              $nextTimeLimit = $this->addHours($currentTime,2);
              

    	
    	//joining all the tables and getting the query
    	$busResultQuery = CbeInfoBusTiming::
    							//join thecbe_info_bus_names AS BNT BY matching the id on BNT and bus_id on cbe_info_bus_timings
    							 leftJoin('cbe_info_bus_names as BNT', 'BNT.id', '=', 'cbe_info_bus_timings.bus_id')
    								//join cbe_info_bus_types AS BTT BY matching the id on BTT and bus_type_id on cbe_info_bus_timings
	                ->leftJoin('cbe_info_bus_types as BTT','BTT.id','=','cbe_info_bus_timings.bus_type_id')
	                //join cbe_info_location_froms AS LFT BY matching the id on LFT and bus_point_from on cbe_info_bus_timings
	                ->leftJoin('cbe_info_location_froms as LFT','LFT.id','=','cbe_info_bus_timings.bus_point_from')
	                //join cbe_info_location_tos AS LTT BY matching the id on LTT and bus_point_to on cbe_info_bus_timings
									->leftJoin('cbe_info_location_tos as LTT','LTT.id','=','cbe_info_bus_timings.bus_point_to')
                  ->leftJoin('cbe_info_bus_vias as BVT','BVT.id','=','cbe_info_bus_timings.bus_route_id')
									//adding where time(`bus_time`) >= '.$currentTime.'
                  ->whereTime('bus_time', '>', $currentTime)
                  //adding where time(`bus_time`) <= '.$nextTimeLimit.'
                  ->WhereTime('bus_time', '<', $nextTimeLimit)
                  ->orderBy('bus_time','ASC')
                  //selecting the required fields
                  ->select($selectArray);
        //converting the builder query to collection
       $busResultCollection = $busResultQuery->get();
       


       if ($busResultCollection->isNotEmpty()) 
       {
        $isBusAvailable = "AVAILABLE";

       	$busResult = $busResultQuery->paginate(20,['*'],'seacrh-page');
       }elseif ($busResultCollection->isEmpty()) 
       {
        
         $isBusAvailable = "NOT AVAILABLE";
         $busResult ='';
       }

       $viewShare = ['isBusAvailable','busResult','currentTime','nextTimeLimit','busResultCollection'];

    	return view('welcome',compact($viewShare));
    }

    public function addHours($realTime='',$addHours=2)
    {        
        // h:i A
       $nextHour =  date("H:i", strtotime($realTime)+$addHours*60*60 );

       $newFormat = date('H:i', strtotime($nextHour));

       return $newFormat;        
    }


    public function search($modelTableName='',$searchFileds='',$searchKeyWord='',$joinableQuery=[])
    {  


      $skippedFileds = ['created_at','updated_at'];    
  
      if ($searchFileds === '*')
      {        
        $allfilelds = $modelTableName->getFillable();

        $mainTableSearchFields = self::arrayem($allfilelds,$skippedFileds);
      }

      elseif ($searchFileds !== '*') 
      {
        if (!is_array($searchFileds)) 
        {
          $mainTableSearchFields = explode(' ', $searchFileds);
        }
        elseif (is_array($searchFileds)) 
        {
          $mainTableSearchFields = $searchFileds;
        }
      }


     // $mainTableSearchQuery =  $modelTableName::where(function ($query) use ($searchKeyWord,$mainTableSearchFields) {
     //        foreach ($mainTableSearchFields as $field) {
     //             $query->orWhere($field, 'LIKE', "%$searchKeyWord%");
     //        }
     //    });

     // $mainTableSearchQuery =  $modelTableName::leftJoin();

     // dd(ApplicationHelper::mysql($mainTableSearchQuery));


    }

    public  function isValuePasses($passesValue='')
    {
       if (empty($passesValue) || is_null($passesValue) || $passesValue === "") 
        {                
           return 'NOT_PASSED';
        }else
        {
            return 'PASSED';
        }
    }

    public function arrayem($array='',$arrayValues='')
    {
      if (!is_array($arrayValues)) 
      {
        if (($keyOfValue = array_search($arrayValues, $array)) !== false) 
        {
          unset($array[$keyOfValue]);
        }

        return $array;   
      }elseif (is_array($arrayValues)) 
      {
        return array_diff($array, $arrayValues);
      }
      
    }



    public function serachBus(Request $request)
    {



//       $searchObject = new CbeInfoBusTiming;
//       $joinedArray = [['cbe_info_bus_names as BNT', 'BNT.id', '=', 'cbe_info_bus_timings.bus_id'],['cbe_info_bus_types as BTT','BTT.id','=','cbe_info_bus_timings.bus_type_id']];
//       $serachBus = self::search($searchObject,'*','17:00',$joinedArray);
//       // dd($serachBus);



// $searck = CbeInfoBusTiming::search(['bus_time','bus_route_id'], ['17:00','03:00']);
// $searckn = CbeInfoBusTiming::multipleSearchWithOutRelation(['bus_time','bus_route_id'], ['17:00','03:00']);

// dd(ApplicationHelper::mysql($searck),ApplicationHelper::mysql($searckn));


      
      $fromLocation = $request->location_from;
      $toLocation = $request->location_to;
      //list of fields to be selected 
      $selectArray =  [ //select id from bus timings table
                'cbe_info_bus_timings.id',
                //select bus_time from bus timings table
                'cbe_info_bus_timings.bus_time',
                //select bus_name from cbe_info_bus_names table
                'BNT.bus_name as busName',
                //select bus_type_name from cbe_info_bus_types table
                'BTT.bus_type_name as busType',
                //select location_from_name from cbe_info_location_froms table
                'LFT.location_from_name as locationFrom',
                //select location_to_name from cbe_info_location_tos table
                'LTT.location_to_name as toLocation',

                //select location_to_name from cbe_info_location_tos table
                'BVT.bus_via_name as busGoingVia',
              ];

              $currentTime = date('H:i');
              $nextTimeLimit = $this->addHours($currentTime,2);

            

              $whereArray = 
                          [
                            ['LFT.id','=',$request->location_from],
                            ['LTT.id','=',$request->location_to],
                          ];
                  

      //joining all the tables and getting the query
      $busResultSearchQuery = CbeInfoBusTiming::
                  //join thecbe_info_bus_names AS BNT BY matching the id on BNT and bus_id on cbe_info_bus_timings
                   leftJoin('cbe_info_bus_names as BNT', 'BNT.id', '=', 'cbe_info_bus_timings.bus_id')
                    //join cbe_info_bus_types AS BTT BY matching the id on BTT and bus_type_id on cbe_info_bus_timings
                  ->leftJoin('cbe_info_bus_types as BTT','BTT.id','=','cbe_info_bus_timings.bus_type_id')
                  //join cbe_info_location_froms AS LFT BY matching the id on LFT and bus_point_from on cbe_info_bus_timings
                  ->leftJoin('cbe_info_location_froms as LFT','LFT.id','=','cbe_info_bus_timings.bus_point_from')
                  //join cbe_info_location_tos AS LTT BY matching the id on LTT and bus_point_to on cbe_info_bus_timings
                  ->leftJoin('cbe_info_location_tos as LTT','LTT.id','=','cbe_info_bus_timings.bus_point_to')
                  ->leftJoin('cbe_info_bus_vias as BVT','BVT.id','=','cbe_info_bus_timings.bus_route_id')
                  //adding where time(`bus_time`) >= '.$currentTime.'
                  ->whereTime('bus_time', '>', $currentTime)
                  //adding where time(`bus_time`) <= '.$nextTimeLimit.'
                  ->whereTime('bus_time', '<', $nextTimeLimit)
                  //
                  ->orderBy('bus_time','ASC')
                  //adding where 
                  ->where($whereArray)
                  //selecting the required fields
                  ->select($selectArray);
                  //converting the builder query to collection

                 
                 $busResultSearchCollection = $busResultSearchQuery->get();
                 // dd(ApplicationHelper::sqlWithParm($busResultQuery));
                 // dd($busResultCollection);
                 //converting the builder query to collection
                 if ($busResultSearchCollection->isNotEmpty()) 
                 {
                  $isSearchBusAvailable = "AVAILABLE";

                  $busSearchResult = $busResultSearchQuery->paginate(20);


                 }elseif ($busResultSearchCollection->isNotEmpty()) 
                 {
                   $isSearchBusAvailable = "NOT AVAILABLE";
                 }
                 

                 $viewShare = ['isSearchBusAvailable','busSearchResult','currentTime','nextTimeLimit','busResultSearchCollection','busResultSearchCollection','fromLocation','toLocation'];

                return view('searchresults',compact($viewShare));      

    }
}
