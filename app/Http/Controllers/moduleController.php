<?php

namespace App\Http\Controllers;
use App\Http\Requests\moduleFormRequest;
use Illuminate\Http\Request;
use App\Models\module;
use App\Models\permission;
use DB;
class moduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modules = DB::table('modules')
                   ->leftJoin('permissions', 'modules.id', '=', 'permissions.module_id')
                   ->select(DB::raw('modules.id, modules.module, modules.etat, count(permissions.module_id) as NPerm'))
                   ->groupBy('modules.id')
                   ->get();
        $mod = new module();
        return view('modules.index', compact('modules', 'mod')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(moduleFormRequest $request)
    {
        module::create([
            'module'=>$request->Module
        ]);
        session()->flash('message', 'Vous venez d\'ajouter '.$request->Module.' comme Module d\'accèss au système MS');
        return redirect(route('module.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        $Permissions = permission::whereModuleId($id)->get();
        return view('modules.show', compact('id', 'Permissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
