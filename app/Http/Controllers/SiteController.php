<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CbeInfoBusTiming;
use App\Helpers\ApplicationHelper;
use Illuminate\Support\Arr;

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

                //select location_to_name from cbe_info_location_tos table
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
       // dd($busResultCollection);
       

       // dd(ApplicationHelper::sqlWithParm($busResultQuery));
       // dd($busResultCollection);
       //converting the builder query to collection

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
    public function serachBus(Request $request)
    {
      
      $fromLocation = $request->location_from;
      $toLocation = $request->location_to;
      // dd($request->all());
      // $this->validate(
      //   request(),
      //   [
      //     'location_from' => 'required',
      //     'location_to' => 'required',
      //   ],
      //   [
      //     'location_from.required' => 'Choose Location From',
      //     'location_to.required' => 'Choose Location To',
      //   ]
      // );
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

            

                // if (empty($request->location_from) && is_null($request->location_from) && $request->location_from == "") 
                // {
                //     $modelTableNameWithNameSpace = $nameSpace.'\\'.$modelTableName;
                     
                // }

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

                 $viewShare = ['isSearchBusAvailable','busSearchResult','currentTime','nextTimeLimit','busResultCollection','busResultSearchCollection','fromLocation','toLocation'];

                return view('searchresults',compact($viewShare));      

    }
}
