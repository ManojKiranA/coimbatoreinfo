<?php

namespace App\Http\Controllers;

use App\Models\CbeInfoBusTiming;
use App\Http\Resources\CbeInfoBusTimingResource;
use App\Http\Requests\CbeInfoBusTimingStoreRequest;
use App\Http\Requests\CbeInfoBusTimingUpdateRequest;
use App\Repositories\CbeInfoBusTimingRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

use App\Models\CbeInfoLocationFrom;
use App\Models\CbeInfoLocationTo;
use App\Models\CbeInfoBusName;
use App\Models\CbeInfoBusType;
use App\Models\CbeInfoBusVia;

use App\Helpers\BladeHelper;
use App\Helpers\ApplicationHelper;

class CbeInfoBusTimingController extends Controller
{
    /**
     * Create a new CbeInfoBusTimingController instance.
     *
     * @return void
     */
    protected $cbeInfoBusTiming;

    public function __construct(CbeInfoBusTiming $cbeInfoBusTiming,Request $request)
    {
        $this->middleware('auth');
        // $this->cbeInfoBusTiming = new CbeInfoBusTimingRepository($cbeInfoBusTiming);

         $this->cbeInfoBusTiming = $this->cbeInfoBusTiming;
    }
    /**
     * Display a listing of the resource.
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
       
        




                $result = CbeInfoBusTiming::leftJoin('cbe_info_bus_names as bus_name_table', 'bus_name_table.id', '=', 'cbe_info_bus_timings.bus_id')
                                    ->leftJoin('cbe_info_bus_types as bus_type_table','bus_type_table.id','=','cbe_info_bus_timings.bus_type_id')
                                    ->leftJoin('cbe_info_location_froms as location_from_table','location_from_table.id','=','cbe_info_bus_timings.bus_point_from')
                                    ->leftJoin('cbe_info_location_tos as location_to_table','location_to_table.id','=','cbe_info_bus_timings.bus_point_to')
                                    
                                    ->select('cbe_info_bus_timings.id','cbe_info_bus_timings.bus_time','bus_name_table.bus_name as busName','bus_type_table.bus_type_name as busType','location_from_table.location_from_name as locationFrom','location_to_table.location_to_name as toLocation');
                // print_r(ApplicationHelper::getEloquentSqlWithBindings($result));
                                    // print_r($result->toSql());


        $cbeInfoBusTimings = CbeInfoBusTiming::latest()->paginate();
        $viewShare = ['cbeInfoBusTimings'];
        return view('cbeinfobustimings.index', compact($viewShare));
    }
    public function addHours($realTime='',$addHours=2)
    {        
        // h:i A
       $nextHour =  date( "H:i", strtotime($realTime)+$addHours*60*60 );

       $newFormat = date('h:i A', strtotime($nextHour));

       return $newFormat;        
    }
    /**
     * Show the form for creating a new resource.
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //list of the busses available in the bus from location
        $modelPath = ['App','Models'];

        $busFromArray = ApplicationHelper::toDropDown('CbeInfoLocationFrom',$modelPath,'location_from_name','id','Select From Location');
        
        $busToArray = ApplicationHelper::toDropDown('CbeInfoLocationTo',$modelPath,'location_to_name','id','Select To Location');

        $busRouteArray = ApplicationHelper::toDropDown('CbeInfoBusVia',$modelPath,'bus_via_name','id','Select Route');

        $busNameArray = ApplicationHelper::toDropDown('CbeInfoBusName',$modelPath,'bus_name','id','Choose the Bus');

        $busTypeArray = ApplicationHelper::toDropDown('CbeInfoBusType',$modelPath,'bus_type_name','id','Choose the Bus Type');


        $viewShare = [ 'busFromArray','busToArray','busRouteArray','busNameArray','busTypeArray'];
        return view('cbeinfobustimings.create', compact($viewShare));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @param  \App\Http\CbeInfoBusTimingStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CbeInfoBusTimingStoreRequest $request)
    {       
        $createTimeArray = array_merge(
                                    $request->all(),
                                    [
                                        'bus_time' => date("H:i", strtotime($request->bus_time)),
                                    ]
                                    );

        CbeInfoBusTiming::create($createTimeArray);
        return redirect()->route('cbeInfoBusTimings.index')->with('success','CbeInfoBusTiming Created Successfully');
    }
    /**
     * Display the specified resource.
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @param  int  $id
     * @param  \App\CbeInfoBusTiming  $CbeInfoBusTiming
     * @return \Illuminate\Http\Response
     */
    public function show($id,CbeInfoBusTiming $cbeInfoBusTiming)
    {
        $cbeInfoBusTiming = CbeInfoBusTiming::findOrFail($id);
        $viewShare = ['cbeInfoBusTiming'];
        return view('cbeinfobustimings.show',compact($viewShare));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com
     * @param  \App\CbeInfoBusTiming  $CbeInfoBusTiming
     * @return \Illuminate\Http\Response
     */
    public function edit($id,CbeInfoBusTiming $CbeInfoBusTiming)
    {

        $cbeInfoBusTiming = CbeInfoBusTiming::findOrFail($id);
        //list of the busses available in the bus from location
        $modelPath = ['App','Models'];

        $busFromArray = ApplicationHelper::toDropDown('CbeInfoLocationFrom',$modelPath,'location_from_name','id','Select From Location');
        
        $busToArray = ApplicationHelper::toDropDown('CbeInfoLocationTo',$modelPath,'location_to_name','id','Select To Location');

        $busRouteArray = ApplicationHelper::toDropDown('CbeInfoBusVia',$modelPath,'bus_via_name','id','Select Route');

        $busNameArray = ApplicationHelper::toDropDown('CbeInfoBusName',$modelPath,'bus_name','id','Choose the Bus');

        $busTypeArray = ApplicationHelper::toDropDown('CbeInfoBusType',$modelPath,'bus_type_name','id','Choose the Bus Type');


        $viewShare = [ 'busFromArray','busToArray','busRouteArray','busNameArray','busTypeArray','cbeInfoBusTiming'];


        
        
        return view('cbeinfobustimings.edit',compact($viewShare));
    }
    /**
     * Update the specified resource in storage.
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @param  \Illuminate\Http\CbeInfoBusTimingUpdateRequest  $request
     * @param  \App\CbeInfoBusTiming  $CbeInfoBusTiming
     * @return \Illuminate\Http\Response
     */
    public function update(CbeInfoBusTimingUpdateRequest $request, $id)
    {
        $cbeInfoBusTiming = CbeInfoBusTiming::find($id);

        $updateTimeArray = array_merge(
                                    $request->all(),
                                    [
                                        'bus_time' => date("H:i", strtotime($request->bus_time)),
                                    ]
                                    );


        $cbeInfoBusTiming->update($updateTimeArray);
        return redirect()->route('cbeInfoBusTimings.index')->with('success','CbeInfoBusTiming Updated Successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @param  \App\CbeInfoBusTiming  $CbeInfoBusTiming
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,CbeInfoBusTiming $CbeInfoBusTiming)
    {
        $cbeInfoBusTiming = CbeInfoBusTiming::findOrFail($id);
        if (!empty($cbeInfoBusTiming))
        {
            $cbeInfoBusTiming->delete();
            return redirect()->route('cbeInfoBusTimings.index')->with('success','CbeInfoBusTiming Deleted Successfully');

        }else{
            return redirect()->route('cbeInfoBusTimings.index')->with('error','CbeInfoBusTiming Not Found');
        }
    }
}
