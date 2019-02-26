<?php

namespace App\Http\Controllers;

use App\Models\CbeInfoBusVia;
use App\Http\Resources\CbeInfoBusViaResource;
use App\Http\Requests\CbeInfoBusViaStoreRequest;
use App\Http\Requests\CbeInfoBusViaUpdateRequest;
use App\Repositories\CbeInfoBusViaRepository;
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

class CbeInfoBusViaController extends Controller
{
    /**
     * Create a new CbeInfoBusViaController instance.
     *
     * @return void
     */
    protected $cbeInfoBusVia;

    public function __construct(CbeInfoBusVia $cbeInfoBusVia,Request $request)
    {
        $this->middleware('auth');
        // $this->cbeInfoBusVia = new CbeInfoBusViaRepository($cbeInfoBusVia);

         $this->cbeInfoBusVia = $this->cbeInfoBusVia;
    }
    /**
     * Display a listing of the resource.
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $cbeInfoBusVias = CbeInfoBusVia::latest()->paginate();
        $viewShare = ['cbeInfoBusVias'];
        return view('cbeinfobusvias.index', compact($viewShare));
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
        return view('cbeinfobusvias.create', compact($viewShare));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @param  \App\Http\CbeInfoBusViaStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CbeInfoBusViaStoreRequest $request)
    {
        CbeInfoBusVia::create($request->all());
        return redirect()->route('cbeInfoBusVias.index')->with('success','CbeInfoBusVia Created Successfully');
    }
    /**
     * Display the specified resource.
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @param  int  $id
     * @param  \App\CbeInfoBusVia  $CbeInfoBusVia
     * @return \Illuminate\Http\Response
     */
    public function show($id,CbeInfoBusVia $cbeInfoBusVia)
    {
        $cbeInfoBusVia = CbeInfoBusVia::findOrFail($id);
        $viewShare = ['cbeInfoBusVia'];
        return view('cbeinfobusvias.show',compact($viewShare));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com
     * @param  \App\CbeInfoBusVia  $CbeInfoBusVia
     * @return \Illuminate\Http\Response
     */
    public function edit($id,CbeInfoBusVia $CbeInfoBusVia)
    {
        $cbeInfoBusVia = CbeInfoBusVia::findOrFail($id);
        $viewShare = ['cbeInfoBusVia'];
        return view('cbeinfobusvias.edit',compact($viewShare));
    }
    /**
     * Update the specified resource in storage.
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @param  \Illuminate\Http\CbeInfoBusViaUpdateRequest  $request
     * @param  \App\CbeInfoBusVia  $CbeInfoBusVia
     * @return \Illuminate\Http\Response
     */
    public function update(CbeInfoBusViaUpdateRequest $request, $id)
    {
        $cbeInfoBusVia = CbeInfoBusVia::find($id);
        $cbeInfoBusVia->update($request->all());        
        return redirect()->route('cbeInfoBusVias.index')->with('success','CbeInfoBusVia Updated Successfully');
    }    
    /**
     * Remove the specified resource from storage.
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @param  \App\CbeInfoBusVia  $CbeInfoBusVia
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,CbeInfoBusVia $CbeInfoBusVia)
    {
        $cbeInfoBusVia = CbeInfoBusVia::findOrFail($id);
        if (!empty($cbeInfoBusVia))
        {
            $cbeInfoBusVia->delete();
            return redirect()->route('cbeInfoBusVias.index')->with('success','CbeInfoBusVia Deleted Successfully');

        }else{
            return redirect()->route('cbeInfoBusVias.index')->with('error','CbeInfoBusVia Not Found');
        }
    }
}
