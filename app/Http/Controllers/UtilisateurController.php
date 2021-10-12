<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Utilisateur;
use App\Models\Partenaire;
use App\Http\Requests;

class UtilisateurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $Utilisateurs = Utilisateur::whereEtatAndConcepteur(0, 0)->get();
       return view('Utilisateurs.index', compact('Utilisateurs')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $Utilisateur =new Utilisateur;
        return view('Utilisateurs.create', compact('Utilisateur'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Verification de l'unicite de l'adresse Email
        $NbreEmail = Utilisateur::whereEmail($request->Email)->count();
        if ($NbreEmail == 0) 
        {
          $this->validate($request, [
          'Nom' => 'required', 
          'Prenom' => 'required',
          'Email' => 'required|Email',
          'Profil' => 'required'
          ]);

            Utilisateur::create([
            'Nom' => $request->Nom,
            'Prenom' => $request->Prenom,
            'Email' => $request->Email,
            'Profil' => $request->Profil,
            'MotdePasse' => sha1(12345)
        ]);

         session()->flash('message', 'Utilisateur Crée avec success!');
        }
        else
        {
           session()->flash('messageDelete', 'Adresse Email Existe deja'); 
        }

        return redirect(route('Utilisateurs.index'));
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
        $Utilisateur = Utilisateur::findOrFail($id);
        return view('Utilisateurs.edit', compact('Utilisateur'));
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
        $NbreEmail = Utilisateur::whereEmail($request->Email)->where('id', '!=', $id)->count();
        if ($NbreEmail == 0) 
        {
          $this->validate($request, [
          'Nom' => 'required', 
          'Prenom' => 'required',
          'Email' => 'required|Email',
          'Profil' => 'required'
          ]);
            
            $Utilisateur = Utilisateur::findOrFail($id);
            $Utilisateur->update([
            'Nom' => $request->Nom,
            'Prenom' => $request->Prenom,
            'Email' => $request->Email,
            'Profil' => $request->Profil
        ]);

         session()->flash('message', 'Utilisateur Modifié avec success!');
        }
        else
        {
           session()->flash('messageDelete', 'Adresse Email Existe deja'); 
        }

        return redirect(route('Utilisateurs.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
            $Utilisateur = Utilisateur::findOrFail($id);
            $Utilisateur->update([
            'Etat' =>1
        ]);
      session()->flash('messageDelete', 'Supression effectuee');       
      return redirect(route('Utilisateurs.index'));      
    }

    public function restaureMotDePasse($id)
    {
            $Utilisateur = Utilisateur::findOrFail($id);
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
           $Utilisateur = Utilisateur::findOrFail($id);
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
        $Utilisateurs = Utilisateur::whereEtat(1)->get();
       return view('Utilisateurs.CorbUser', compact('Utilisateurs')); 
    }

    public function RestaurerUser($id)
    {
        $Utilisateur = Utilisateur::findOrFail($id);
            $Utilisateur->update([
            'Etat' => 0 
        ]);
            return redirect(route('CorbUser'));
    }
}
