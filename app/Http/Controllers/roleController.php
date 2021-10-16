<?php

namespace App\Http\Controllers;
use App\Http\Requests\roleFormRequest;
use Illuminate\Http\Request;
use App\Models\role;
use App\Models\permission;
use App\Models\role_permission;
use DB;
class roleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = role::whereEtat(0)->get();
        $rol = new role();
        return view('roles.index', compact('roles', 'rol')); 
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
    public function store(roleFormRequest $request)
    {
        role::create([
            'role'=>$request->Role
        ]);
        session()->flash('message', 'Vous venez d\'ajouter '.$request->Role.' comme role d\'accèss au système MS');
        return redirect(route('role.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Permissions = DB::table('permissions')
                    ->leftJoin('role_permissions', 'role_permissions.permission_id', '=', 'permissions.id')
                    ->join('modules', 'modules.id', '=', 'permissions.module_id')
                    ->select(DB::raw('permissions.id, permissions.link,permissions.action,modules.module'))
                    ->get();
        return view('roles.show', compact('Permissions', 'id'));
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

    public function remove_permission(){

    }

    public function add_permission(Request $request){
        $permissions = $request['permission'];
        $i=0;
        $rol = $request->role;
     if ($request['permission']!=0) {
        for ($i=0; $i <count($request['permission']) ; $i++) { 
            $permission = (int)$permissions[$i];
        
                role_permission::create([
                        'role_id'=>$request->role,
                        'permission_id'=>$permission
                    ]);
        } 
      }else{
        session()->flash('messageDelete', 'Aucun compte n\'a été attaché au journal');
      }
        return redirect(route('role.index'));   
    }
}
