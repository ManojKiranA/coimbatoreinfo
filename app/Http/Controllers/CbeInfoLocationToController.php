<?php

namespace App\Http\Controllers;

use App\Models\CbeInfoLocationTo;
use App\Http\Resources\CbeInfoLocationToResource;
use App\Http\Requests\CbeInfoLocationToStoreRequest;
use App\Http\Requests\CbeInfoLocationToUpdateRequest;
use App\Repositories\CbeInfoLocationToRepository;
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

class CbeInfoLocationToController extends Controller
{
    /**
     * Create a new CbeInfoLocationToController instance.
     *
     * @return void
     */
    protected $cbeInfoLocationTo;

    public function __construct(CbeInfoLocationTo $cbeInfoLocationTo,Request $request)
    {
        $this->middleware('auth');
        // $this->cbeInfoLocationTo = new CbeInfoLocationToRepository($cbeInfoLocationTo);

         $this->cbeInfoLocationTo = $this->cbeInfoLocationTo;
    }
    /**
     * Display a listing of the resource.
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $cbeInfoLocationTos = CbeInfoLocationTo::latest()->paginate();
        $viewShare = ['cbeInfoLocationTos'];
        return view('cbeinfolocationtos.index', compact($viewShare));
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
        return view('cbeinfolocationtos.create', compact($viewShare));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @param  \App\Http\CbeInfoLocationToStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CbeInfoLocationToStoreRequest $request)
    {
        CbeInfoLocationTo::create($request->all());
        return redirect()->route('cbeInfoLocationTos.index')->with('success','CbeInfoLocationTo Created Successfully');
    }
    /**
     * Display the specified resource.
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @param  int  $id
     * @param  \App\CbeInfoLocationTo  $CbeInfoLocationTo
     * @return \Illuminate\Http\Response
     */
    public function show($id,CbeInfoLocationTo $cbeInfoLocationTo)
    {
        $cbeInfoLocationTo = CbeInfoLocationTo::findOrFail($id);
        $viewShare = ['cbeInfoLocationTo'];
        return view('cbeinfolocationtos.show',compact($viewShare));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com
     * @param  \App\CbeInfoLocationTo  $CbeInfoLocationTo
     * @return \Illuminate\Http\Response
     */
    public function edit($id,CbeInfoLocationTo $CbeInfoLocationTo)
    {
        $cbeInfoLocationTo = CbeInfoLocationTo::findOrFail($id);
        $viewShare = ['cbeInfoLocationTo'];
        return view('cbeinfolocationtos.edit',compact($viewShare));
    }
    /**
     * Update the specified resource in storage.
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @param  \Illuminate\Http\CbeInfoLocationToUpdateRequest  $request
     * @param  \App\CbeInfoLocationTo  $CbeInfoLocationTo
     * @return \Illuminate\Http\Response
     */
    public function update(CbeInfoLocationToUpdateRequest $request, $id)
    {
        $cbeInfoLocationTo = CbeInfoLocationTo::find($id);
        $cbeInfoLocationTo->update($request->all());        
        return redirect()->route('cbeInfoLocationTos.index')->with('success','CbeInfoLocationTo Updated Successfully');
    }    
    /**
     * Remove the specified resource from storage.
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @param  \App\CbeInfoLocationTo  $CbeInfoLocationTo
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,CbeInfoLocationTo $CbeInfoLocationTo)
    {
        $cbeInfoLocationTo = CbeInfoLocationTo::findOrFail($id);
        if (!empty($cbeInfoLocationTo))
        {
            $cbeInfoLocationTo->delete();
            return redirect()->route('cbeInfoLocationTos.index')->with('success','CbeInfoLocationTo Deleted Successfully');

        }else{
            return redirect()->route('cbeInfoLocationTos.index')->with('error','CbeInfoLocationTo Not Found');
        }
    }
}
