<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Partenaire;
use App\Http\Requests;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Arr;
use Hash;
use DB;
class UtilisateurController extends Controller
{  

    // function __construct()
    // {
    //      $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','store']]);
    //      $this->middleware('permission:user-create', ['only' => ['create','store']]);
    //      $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
    //      $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $Utilisateurs = User::all();
       return view('Utilisateurs.index', compact('Utilisateurs')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $roles = Role::pluck('name','name')->all();

        return view('Utilisateurs.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $this->validate($request, [

            'name' => 'required',

            'email' => 'required|email|unique:users,email',

            'roles' => 'required'

        ]);

    

        $input = $request->all();

        $input['password'] = Hash::make('BWLCMMPDVA');

    

        $user = User::create($input);

        $user->assignRole($request->input('roles'));

    

        return redirect()->route('Utilisateurs.index')

                        ->with('success','User created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();
    
        return view('users.edit', compact('user', 'roles', 'userRole'));
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
        //Verification de l'unicite de l'adresse Email
        $input = $request->all();
        
        if(!empty($input['password'])) { 
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));    
        }
    
        $user = User::find($id);
        $user->update($input);

        DB::table('model_has_roles')
            ->where('model_id', $id)
            ->delete();
    
        $user->assignRole($request->input('roles'));
    
        return redirect()->route('Utilisateurs.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
            $Utilisateur = User::findOrFail($id);
            $Utilisateur->update([
            'Etat' =>1
        ]);
      session()->flash('messageDelete', 'Supression effectuee');       
      return redirect(route('Utilisateurs.index'));      
    }

    public function restaureMotDePasse($id)
    {
            $Utilisateur = User::findOrFail($id);
            $Utilisateur->update([
            'MotdePasse' => sha1(12345)
        ]);
      session()->flash('message', 'Mot de passe restauré');       
      return redirect(route('Utilisateurs.index'));
    }

    public function ModifierMotdePasse()
    {
        return view('Utilisateurs.ModifierMotdePasse');
    }

    public function updateProfil(Request $request,$id)
    {   
        $this->validate($request, [
          'HoldPasseWord' => 'required', 
          'NewPassword' => 'required',
          'ConfirmNewPassword' => 'required'
          ]);
          $request->HoldPasseWord = sha1($request->HoldPasseWord);
          $request->NewPassword = sha1($request->NewPassword);
          $request->ConfirmNewPassword = sha1($request->ConfirmNewPassword);
        if (session()->get('Profil') == "Partenaire") 
        {
            $Partenaire = Partenaire::findOrFail($id);
            if ($request->HoldPasseWord == $Partenaire->MotdePasse) 
            {
                if ($request->NewPassword == $request->ConfirmNewPassword) 
                {
                   $Partenaire->update([
                   'MotdePasse' => $request->NewPassword
                   ]); 

                   session()->flash('message', 'Mot de passe Modifié');
                }
                else
                {
                  session()->flash('messageDelete', ' Le Noveau Mot de passe  Modifié est differe nt du mot de passe de Confirmation');  
                }
            }
            session()->flash('messageDelete', ' Mot de passe Incorrect');
        }
        else
        {
           $Utilisateur = User::findOrFail($id);
            if ($request->HoldPasseWord == $Utilisateur->MotdePasse) 
            {
                if ($request->NewPassword == $request->ConfirmNewPassword) 
                {
                   $Utilisateur->update([
                   'MotdePasse' => $request->NewPassword
                   ]); 

                   session()->flash('message', 'Mot de passe Modifié');
                }
                else
                {
                  session()->flash('messageDelete', ' Le Noveau Mot de passe  Modifié est differe nt du mot de passe de Confirmation');  
                }
            }
            session()->flash('messageDelete', ' Mot de passe Incorrect'); 
        }

        return redirect(route('ModifierMotdePasse'));
    }

    public function CorbUser()
    {
        $Utilisateurs = User::whereEtat(1)->get();
       return view('Utilisateurs.CorbUser', compact('Utilisateurs')); 
    }

    public function RestaurerUser($id)
    {
        $Utilisateur = User::findOrFail($id);
            $Utilisateur->update([
            'Etat' => 0 
        ]);
            return redirect(route('CorbUser'));
    }
}
