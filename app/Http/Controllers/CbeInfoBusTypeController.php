<?php

namespace App\Http\Controllers;

use App\Models\CbeInfoBusType;
use App\Http\Resources\CbeInfoBusTypeResource;
use App\Http\Requests\CbeInfoBusTypeStoreRequest;
use App\Http\Requests\CbeInfoBusTypeUpdateRequest;
use App\Repositories\CbeInfoBusTypeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

use App\Helpers\BladeHelper;
use App\Helpers\ApplicationHelper;

class CbeInfoBusTypeController extends Controller
{
    /**
     * Create a new CbeInfoBusTypeController instance.
     *
     * @return void
     */
    protected $cbeInfoBusType;

    public function __construct(CbeInfoBusType $cbeInfoBusType,Request $request)
    {
        $this->middleware('auth');
        // $this->cbeInfoBusType = new CbeInfoBusTypeRepository($cbeInfoBusType);

         $this->cbeInfoBusType = $this->cbeInfoBusType;
    }
    /**
     * Display a listing of the resource.
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $cbeInfoBusTypes = CbeInfoBusType::latest()->paginate();
        $viewShare = ['cbeInfoBusTypes'];
        return view('cbeinfobustypes.index', compact($viewShare));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $viewShare = [''];
        return view('cbeinfobustypes.create', compact($viewShare));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @param  \App\Http\CbeInfoBusTypeStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CbeInfoBusTypeStoreRequest $request)
    {
        CbeInfoBusType::create($request->all());
        return redirect()->route('cbeInfoBusTypes.index')->with('success','CbeInfoBusType Created Successfully');
    }
    /**
     * Display the specified resource.
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @param  int  $id
     * @param  \App\CbeInfoBusType  $CbeInfoBusType
     * @return \Illuminate\Http\Response
     */
    public function show($id,CbeInfoBusType $cbeInfoBusType)
    {
        $cbeInfoBusType = CbeInfoBusType::findOrFail($id);
        $viewShare = ['cbeInfoBusType'];
        return view('cbeinfobustypes.show',compact($viewShare));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com
     * @param  \App\CbeInfoBusType  $CbeInfoBusType
     * @return \Illuminate\Http\Response
     */
    public function edit($id,CbeInfoBusType $CbeInfoBusType)
    {
        $cbeInfoBusType = CbeInfoBusType::findOrFail($id);
        $viewShare = ['cbeInfoBusType'];
        return view('cbeinfobustypes.edit',compact($viewShare));
    }
    /**
     * Update the specified resource in storage.
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @param  \Illuminate\Http\CbeInfoBusTypeUpdateRequest  $request
     * @param  \App\CbeInfoBusType  $CbeInfoBusType
     * @return \Illuminate\Http\Response
     */
    public function update(CbeInfoBusTypeUpdateRequest $request, $id)
    {
        $cbeInfoBusType = CbeInfoBusType::find($id);
        $cbeInfoBusType->update($request->all());        
        return redirect()->route('cbeInfoBusTypes.index')->with('success','CbeInfoBusType Updated Successfully');
    }    
    /**
     * Remove the specified resource from storage.
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @param  \App\CbeInfoBusType  $CbeInfoBusType
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,CbeInfoBusType $CbeInfoBusType)
    {
        $cbeInfoBusType = CbeInfoBusType::findOrFail($id);
        if (!empty($cbeInfoBusType))
        {
            $cbeInfoBusType->delete();
            return redirect()->route('cbeInfoBusTypes.index')->with('success','CbeInfoBusType Deleted Successfully');

        }else{
            return redirect()->route('cbeInfoBusTypes.index')->with('error','CbeInfoBusType Not Found');
        }
    }
}
