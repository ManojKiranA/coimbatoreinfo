<?php

namespace App\Http\Controllers;

use App\Models\CbeInfoLocationFrom;
use App\Http\Resources\CbeInfoLocationFromResource;
use App\Http\Requests\CbeInfoLocationFromStoreRequest;
use App\Http\Requests\CbeInfoLocationFromUpdateRequest;
use App\Repositories\CbeInfoLocationFromRepository;
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

class CbeInfoLocationFromController extends Controller
{
    /**
     * Create a new CbeInfoLocationFromController instance.
     *
     * @return void
     */
    protected $cbeInfoLocationFrom;

    public function __construct(CbeInfoLocationFrom $cbeInfoLocationFrom,Request $request)
    {
        $this->middleware('auth');
        // $this->cbeInfoLocationFrom = new CbeInfoLocationFromRepository($cbeInfoLocationFrom);

         $this->cbeInfoLocationFrom = $this->cbeInfoLocationFrom;
    }
    /**
     * Display a listing of the resource.
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $cbeInfoLocationFroms = CbeInfoLocationFrom::latest()->paginate();
        $viewShare = ['cbeInfoLocationFroms'];
        return view('cbeinfolocationfroms.index', compact($viewShare));
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
        return view('cbeinfolocationfroms.create', compact($viewShare));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @param  \App\Http\CbeInfoLocationFromStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CbeInfoLocationFromStoreRequest $request)
    {
        CbeInfoLocationFrom::create($request->all());
        return redirect()->route('cbeInfoLocationFroms.index')->with('success','Location Created Successfully');
    }
    /**
     * Display the specified resource.
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @param  int  $id
     * @param  \App\CbeInfoLocationFrom  $CbeInfoLocationFrom
     * @return \Illuminate\Http\Response
     */
    public function show($id,CbeInfoLocationFrom $cbeInfoLocationFrom)
    {
        $cbeInfoLocationFrom = CbeInfoLocationFrom::findOrFail($id);
        $viewShare = ['cbeInfoLocationFrom'];
        return view('cbeinfolocationfroms.show',compact($viewShare));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com
     * @param  \App\CbeInfoLocationFrom  $CbeInfoLocationFrom
     * @return \Illuminate\Http\Response
     */
    public function edit($id,CbeInfoLocationFrom $CbeInfoLocationFrom)
    {
        $cbeInfoLocationFrom = CbeInfoLocationFrom::findOrFail($id);
        $viewShare = ['cbeInfoLocationFrom'];
        return view('cbeinfolocationfroms.edit',compact($viewShare));
    }
    /**
     * Update the specified resource in storage.
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CbeInfoLocationFrom  $CbeInfoLocationFrom
     * @return \Illuminate\Http\Response
     */
    public function update(CbeInfoLocationFromUpdateRequest $request, $id)
    {
        $cbeInfoLocationFrom = CbeInfoLocationFrom::find($id);
        $cbeInfoLocationFrom->update($request->all());
        return redirect()->route('cbeInfoLocationFroms.index')->with('success','Location Updated Successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @param  \App\CbeInfoLocationFrom  $CbeInfoLocationFrom
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,CbeInfoLocationFrom $CbeInfoLocationFrom)
    {
        $cbeInfoLocationFrom = CbeInfoLocationFrom::findOrFail($id);
        if (!empty($cbeInfoLocationFrom))
        {
            $cbeInfoLocationFrom->delete();
            return redirect()->route('cbeInfoLocationFroms.index')->with('success','Location Deleted Successfully');

        }else{
            return redirect()->route('cbeInfoLocationFroms.index')->with('error','Location Not Found');
        }
    }
}
