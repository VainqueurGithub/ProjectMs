<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use\App\Http\Requests\ComptePrincipalRequest;
use App\Http\Requests;
use\App\Models\ComptePrincipal;
use\App\Models\CodeJournaux;
use\App\Models\CompteJournal;
use\App\Models\Type;
use Illuminate\Support\Facades\DB;
use PDF;
class ComptePrincipalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $Types = Type::whereEtat(0)->get();
        $CodeJournaux = CodeJournaux::whereEtat(0)->get();
        $Comptes = ComptePrincipal::whereEtat(0)->get();
        return view('Comptabilite/ComptePrincipal.index', compact('Comptes', 'Types', 'CodeJournaux'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ComptePrincipalRequest $request)
    {  
       if (ComptePrincipal::UniqueCompte($request->Numero)) {
          if (empty($request->Categorie)) {
               ComptePrincipal::create([
            'NumeroCompte'=>$request->Numero,
            'Intitule'=>$request->Intitule,
            'TypeCompte'=>$request->TypeCompte,
            'Categorie'=>"",
            'Appartenance'=>$request->Appartenance,
            'resultat_exercice'=>$request->ResultatAccount
             ]);
            }else{
                 ComptePrincipal::create([
            'NumeroCompte'=>$request->Numero,
            'Intitule'=>$request->Intitule,
            'TypeCompte'=>$request->TypeCompte,
            'Categorie'=>$request->Categorie,
            'Appartenance'=>$request->Appartenance,
            'resultat_exercice'=>$request->ResultatAccount
             ]);
            }

            //Insertion dans la table de Liaison    
        } 

        return redirect(route('ComptePrincipal.index'));
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
        $Types = Type::whereEtat(0)->get();
        $ComptePrincipal = ComptePrincipal::findOrFail($id);
        $Type=Type::findOrFail($ComptePrincipal->TypeCompte);
        return view('Comptabilite/ComptePrincipal.edit', compact('Types', 'ComptePrincipal', 'Type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ComptePrincipalRequest $request, $id)
    {
        $ComptePrincipal=ComptePrincipal::findOrFail($id);
         if (empty($request->Categorie)) {
               $ComptePrincipal->update([
            'NumeroCompte'=>$request->Numero,
            'Intitule'=>$request->Intitule,
            'TypeCompte'=>$request->TypeCompte,
            'Categorie'=>"",
            'resultat_exercice'=>$request->ResultatAccount
           ]);
            }else{
            $ComptePrincipal->update([
            'NumeroCompte'=>$request->Numero,
            'Intitule'=>$request->Intitule,
            'TypeCompte'=>$request->TypeCompte,
            'Categorie'=>$request->Categorie,
            'resultat_exercice'=>$request->ResultatAccount
           ]);
        }
         return redirect(route('ComptePrincipal.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Compte = ComptePrincipal::findOrFail($id);
        $Compte->update([
            'Etat'=>1
        ]);

        return redirect(route('ComptePrincipal.index'));
    }

    public function getComptePrincipalId(Request $request){
        $TypeComptes = Type::whereEtat(0)->get();
        $CompteId = $request->get('compte');
        $Compte =DB::table('types')
                ->join('compte_principals', 'compte_principals.TypeCompte', '=', 'types.id')
                ->select(DB::raw('types.Types,types.Class, types.id as Tid, compte_principals.id, compte_principals.NumeroCompte,compte_principals.Intitule,compte_principals.Categorie,compte_principals.Appartenance,compte_principals.resultat_exercice'))
                ->where('compte_principals.id', $CompteId)->first();
        
        if ($Compte->Categorie=="Passif") {
            $Categorie = '<div class="custom-control custom-radio">
            <input type="radio" class="custom-control-input" id="customControlValidation1" name="Categorie" value="Passif" checked="checked">
            <label class="custom-control-label" for="customControlValidation1">Passif</label>
            </div>
            <div class="custom-control custom-radio">
            <input type="radio" class="custom-control-input" id="customControlValidation2" name="Categorie" value="Actif">
            <label class="custom-control-label" for="customControlValidation2">Actif</label>
            </div>';
        }else if($Compte->Categorie=="Actif"){
             $Categorie = '<div class="custom-control custom-radio">
            <input type="radio" class="custom-control-input" id="customControlValidation1" name="Categorie" value="Passif">
            <label class="custom-control-label" for="customControlValidation1">Passif</label>
            </div>
            <div class="custom-control custom-radio">
            <input type="radio" class="custom-control-input" id="customControlValidation2" name="Categorie" value="Actif" checked="checked">
            <label class="custom-control-label" for="customControlValidation2">Actif</label>
            </div>';
        }else{
            $Categorie = '<div class="custom-control custom-radio">
            <input type="radio" class="custom-control-input" id="customControlValidation1" name="Categorie" value="Passif">
            <label class="custom-control-label" for="customControlValidation1">Passif</label>
            </div>
            <div class="custom-control custom-radio">
            <input type="radio" class="custom-control-input" id="customControlValidation2" name="Categorie" value="Actif">
            <label class="custom-control-label" for="customControlValidation2">Actif</label>
            </div>';
        }
        
        if ($Compte->resultat_exercice == 1) {
            $ResultatRep = '<input type="checkbox" checked="checked" name="ResultatAccount" value="1">';
        }else{
            $ResultatRep = '<input type="checkbox" name="ResultatAccount" value="1">';
        }
        
        $Type ='<option value='.$Compte->Tid.'>'.$Compte->Class.' '.$Compte->Types.'</option>'; 
                foreach($TypeComptes as $TypeCompte){
                    $Type.='<option value='.$TypeCompte->id.'>'.$TypeCompte->Class.' '.$TypeCompte->Types.'</option>';
                }
        
        $Appartenance ='<option value='.$Compte->Appartenance.'>'.$Compte->Appartenance.'</option>
                        <option value="exploitation">exploitation</option>
                        <option value="financier">financièr(e)</option>
                        <option value="exceptionnel">exceptionnel(le)</option>';
       
        
            $TypeDetail =  $Compte->id.'#'.$Compte->NumeroCompte.'#'.$Compte->Intitule.'#'.$Type.'#'.$Appartenance.'#'.$Categorie.'#'.$ResultatRep;

        echo  $TypeDetail;
    }

    public function UpdateComptePrincipal(Request $request){
        $Compte = ComptePrincipal::findOrFail($request->Identifiant);
        $Compte->update([
            'NumeroCompte'=>$request->Numero,
            'Intitule'=>$request->Intitule,
            'TypeCompte'=>$request->TypeCompte,
            'Categorie'=>$request->Categorie,
            'Appartenance'=>$request->Appartenance
        ]);
        return redirect(route('ComptePrincipal.index'));
    }
}
