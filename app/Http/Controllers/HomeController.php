<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CbeInfoLocationFrom;
use App\Models\CbeInfoLocationTo;
use App\Models\CbeInfoBusName;
use App\Models\CbeInfoBusType;
use App\Models\CbeInfoBusVia;
use App\Models\CbeInfoBusTiming;
use App\Helpers\ApplicationHelper;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $busTypes = CbeInfoBusType::all();
        $fromLocation = CbeInfoLocationFrom::all();
        $toLocation = CbeInfoLocationTo::all();
        $busNames = CbeInfoBusName::all();
        $busRoutes= CbeInfoBusVia::all();
        $busTiming = CbeInfoBusTiming::all();

       $selectArray =   [   //select id from bus timings table
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
        $bussesInNextTwoHour = CbeInfoBusTiming::
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
                              ->select($selectArray)
                              //converting the builder query to collection
                              ->get();



        $viewShare = ['busTypes','fromLocation','toLocation','busNames','busRoutes','busTiming','bussesInNextTwoHour'];
        return view('home',compact($viewShare));
    }
    public function addHours($realTime='',$addHours=2)
    {        
        // h:i A
       $nextHour =  date("H:i", strtotime($realTime)+$addHours*60*60 );

       $newFormat = date('H:i', strtotime($nextHour));

       return $newFormat;        
    }
    public function tosql()
    {
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
                  dd('toSql() Method',$busResultQuery->toSql(),'MY OWN METHOD',ApplicationHelper::mysql($busResultQuery));
    }
}
