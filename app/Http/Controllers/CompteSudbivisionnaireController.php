<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use\App\Http\Requests\CompteSudivisionnaireRequest;
use App\Http\Requests;
use\App\Models\CompteSubdivisionnaire;
use\App\Models\SousCompte;
use Illuminate\Support\Facades\DB;
use PDF;
use\App\Models\ComptePrincipal;
class CompteSudbivisionnaireController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Comptes = ComptePrincipal::whereEtat(0)->get();
        $SubdComptes = CompteSubdivisionnaire::whereEtat(0)->get();         
        return view('Comptabilite/Comptedivisionnaire.index', compact('SubdComptes', 'Comptes'));
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
    public function store(CompteSudivisionnaireRequest $request)
    {  
       if (CompteSubdivisionnaire::UniqueCompte($request->Numero)==true){

          if ($request->resultat_exercice==1) {
                if(CompteSubdivisionnaire::UniqueResultatExercicePerte()==true){
                        CompteSubdivisionnaire::create([
                            'NumeroCompte'=>$request->Numero,
                            'Intitule'=>$request->Intitule,
                            'ComptePricipal'=>$request->Compte,
                            'resultat_exercice'=>$request->resultat_exercice
                        ]);
                }else{
                    session()->flash('messageDelete', 'Ce compte de résultat de perte existe déjà');
                } 
          }else{
            if (CompteSubdivisionnaire::UniqueResultatExerciceBenefice()==true){
                CompteSubdivisionnaire::create([
                    'NumeroCompte'=>$request->Numero,
                    'Intitule'=>$request->Intitule,
                    'ComptePricipal'=>$request->Compte,
                    'resultat_exercice'=>$request->resultat_exercice
                    ]);
                }else{
                    session()->flash('messageDelete', 'Ce compte de résultat de bénéfice existe déjà');
                }
          }
        }else{
            session()->flash('messageDelete', 'Ce compte existe déjà');
        } 
        return redirect(route('Comptedivisionnaire.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        $SousCompte = "";
        $IsNotEmpty = 'no';
        $Nbre = SousCompte::whereCompteSubdAndEtat($id,0)->count('id');
        if ($Nbre!=0) {
            $IsNotEmpty = 'yes';
            $SousCompte = SousCompte::whereCompteSubdAndEtat($id,0)->get();
        }
        return view('Comptabilite/Comptedivisionnaire.show', compact('SousCompte','IsNotEmpty'));
    }
    

    public function Amortissement_sous_compte($Compte){
        $SousCompte = "";
        $IsNotEmpty = 'no';
        $Nbre = SousCompte::whereCompteSubdAndEtat($Compte,0)->count('id');
        if ($Nbre!=0) {
            $IsNotEmpty = 'yes';
            $SousCompte = SousCompte::whereCompteSubdAndEtat($Compte,0)->get();
        }
        return view('Comptabilite/Comptedivisionnaire.show1', compact('SousCompte','IsNotEmpty'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $Comptes = ComptePrincipal::whereEtat(0)->get();
        $SCompte = CompteSubdivisionnaire::findOrFail($id);
        $Compte = ComptePrincipal::findOrFail($SCompte->ComptePricipal);
        return view('Comptabilite/Comptedivisionnaire.edit', compact('Comptes', 'SCompte', 'Compte'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CompteSudivisionnaireRequest $request, $id)
    {
         $SCompte=CompteSubdivisionnaire::findOrFail($id);
          $SCompte->update([
            'NumeroCompte'=>$request->Numero,
            'Intitule'=>$request->Intitule,
            'ComptePricipal'=>$request->Compte,
            'resultat_exercice'=>$request->resultat_exercice
        ]);
         return redirect(route('Comptedivisionnaire.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $SCompte = CompteSubdivisionnaire::findOrFail($id);
        $SCompte->update([
            'Etat'=>1
        ]);
        return redirect(route('Comptedivisionnaire.index'));
    }

    public function getCompteSubdivislId(Request $request){
        $Compteprincipales = ComptePrincipal::whereEtat(0)->get();
        $CompteId = $request->get('compte');
        $Compte =DB::table('compte_principals')
                ->join('compte_subdivisionnaires', 'compte_subdivisionnaires.ComptePricipal', '=', 'compte_principals.id')
                ->select(DB::raw('compte_subdivisionnaires.id,compte_subdivisionnaires.NumeroCompte, compte_subdivisionnaires.Intitule,compte_principals.id as CPid, compte_principals.NumeroCompte as CPN,compte_principals.Intitule as CPI, compte_subdivisionnaires.resultat_exercice'))
                ->where('compte_subdivisionnaires.id', $CompteId)->first();

        if ($Compte->resultat_exercice==1) {
            $Categorie = '<div class="custom-control custom-radio">
            <input type="radio" class="custom-control-input" name="resultat_exercice" value="1" checked="checked">
            <label class="custom-control-label">Perte</label>
            </div>
            <div class="custom-control custom-radio">
            <input type="radio" class="custom-control-input" name="resultat_exercice" value="2">
            <label class="custom-control-label">Bénéfice</label>
            </div>';
        }else if($Compte->resultat_exercice==2){
             $Categorie = '<div class="custom-control custom-radio">
            <input type="radio" class="custom-control-input" name="resultat_exercice" value="1">
            <label class="custom-control-label">Perte</label>
            </div>
            <div class="custom-control custom-radio">
            <input type="radio" class="custom-control-input" name="resultat_exercice" value="2" checked="checked">
            <label class="custom-control-label">Bénéfice</label>
            </div>';
        }else{
            $Categorie = '<div class="custom-control custom-radio">
            <input type="radio" class="custom-control-input" name="resultat_exercice" value="1">
            <label class="custom-control-label">Perte</label>
            </div>
            <div class="custom-control custom-radio">
            <input type="radio" class="custom-control-input" name="resultat_exercice" value="2" checked="checked">
            <label class="custom-control-label">Bénéfice</label>
            </div>';
        }        
       
        $CompteAll ='<option value='.$Compte->CPid.'>'.$Compte->CPN.' - '.$Compte->CPI.'</option>'; 
                foreach($Compteprincipales as $Compteprincipale){
                    $CompteAll.='<option value='.$Compteprincipale->id.'>'.$Compteprincipale->NumeroCompte.' - '.$Compteprincipale->Intitule.'</option>';
                }
            $TypeDetail =  $Compte->id.'#'.$Compte->NumeroCompte.'#'.$Compte->Intitule.'#'.$CompteAll.'#'.$Categorie;
        echo  $TypeDetail;
    }

    public function UpdateCompteSudb(Request $request){
        $SCompte = CompteSubdivisionnaire::findOrFail($request->Identifiant);
        $SCompte->update([
            'NumeroCompte'=>$request->Numero,
            'Intitule'=>$request->Intitule,
            'ComptePricipal'=>$request->Compte,
            'resultat_exercice'=>$request->resultat_exercice
        ]);
         return redirect(route('Comptedivisionnaire.index'));
    }
}
