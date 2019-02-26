<?php

namespace App\Http\Controllers;

use App\Models\CbeInfoBusName;
use App\Http\Resources\CbeInfoBusNameResource;
use App\Http\Requests\CbeInfoBusNameStoreRequest;
use App\Http\Requests\CbeInfoBusNameUpdateRequest;
use App\Repositories\CbeInfoBusNameRepository;
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

class CbeInfoBusNameController extends Controller
{
    /**
     * Create a new CbeInfoBusNameController instance.
     *
     * @return void
     */
    protected $cbeInfoBusName;

    public function __construct(CbeInfoBusName $cbeInfoBusName,Request $request)
    {
        $this->middleware('auth');
        // $this->cbeInfoBusName = new CbeInfoBusNameRepository($cbeInfoBusName);

         $this->cbeInfoBusName = $this->cbeInfoBusName;
    }
    /**
     * Display a listing of the resource.
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $cbeInfoBusNames = CbeInfoBusName::latest()->paginate();
        $viewShare = ['cbeInfoBusNames'];
        return view('cbeinfobusnames.index', compact($viewShare));
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
        return view('cbeinfobusnames.create', compact($viewShare));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @param  \App\Http\CbeInfoBusNameStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CbeInfoBusNameStoreRequest $request)
    {
        CbeInfoBusName::create($request->all());
        return redirect()->route('cbeInfoBusNames.index')->with('success','CbeInfoBusName Created Successfully');
    }
    /**
     * Display the specified resource.
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @param  int  $id
     * @param  \App\CbeInfoBusName  $CbeInfoBusName
     * @return \Illuminate\Http\Response
     */
    public function show($id,CbeInfoBusName $cbeInfoBusName)
    {
        $cbeInfoBusName = CbeInfoBusName::findOrFail($id);
        $viewShare = ['cbeInfoBusName'];
        return view('cbeinfobusnames.show',compact($viewShare));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com
     * @param  \App\CbeInfoBusName  $CbeInfoBusName
     * @return \Illuminate\Http\Response
     */
    public function edit($id,CbeInfoBusName $CbeInfoBusName)
    {
        $cbeInfoBusName = CbeInfoBusName::findOrFail($id);
        $viewShare = ['cbeInfoBusName'];
        return view('cbeinfobusnames.edit',compact($viewShare));
    }
    /**
     * Update the specified resource in storage.
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @param  \Illuminate\Http\CbeInfoBusNameUpdateRequest  $request
     * @param  \App\CbeInfoBusName  $CbeInfoBusName
     * @return \Illuminate\Http\Response
     */
    public function update(CbeInfoBusNameUpdateRequest $request, $id)
    {
        $cbeInfoBusName = CbeInfoBusName::find($id);
        $cbeInfoBusName->update($request->all());        
        return redirect()->route('cbeInfoBusNames.index')->with('success','CbeInfoBusName Updated Successfully');
    }    
    /**
     * Remove the specified resource from storage.
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @param  \App\CbeInfoBusName  $CbeInfoBusName
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,CbeInfoBusName $CbeInfoBusName)
    {
        $cbeInfoBusName = CbeInfoBusName::findOrFail($id);
        if (!empty($cbeInfoBusName))
        {
            $cbeInfoBusName->delete();
            return redirect()->route('cbeInfoBusNames.index')->with('success','CbeInfoBusName Deleted Successfully');

        }else{
            return redirect()->route('cbeInfoBusNames.index')->with('error','CbeInfoBusName Not Found');
        }
    }
}
