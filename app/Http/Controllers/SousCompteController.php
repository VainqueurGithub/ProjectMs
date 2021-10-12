<?php

namespace App\Http\Controllers;
use\App\Models\CompteSubdivisionnaire;
use\App\Http\Requests\SCompteFormRequest;
use\App\Models\SousCompte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class SousCompteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Comptes = CompteSubdivisionnaire::whereEtat(0)->get();
       
        $SComptes = SousCompte::whereEtat(0)->get();
        return view('Comptabilite/SComptes.index', compact('SComptes', 'Comptes'));
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
    public function store(SCompteFormRequest $request)
    {
        if (SousCompte::UniqueCompte($request->Numero)==true) {
             SousCompte::create([
            'NumeroCompte'=>$request->Numero,
            'Intitule'=>$request->Intitule,
            'Compte_subd'=>$request->Compte
        ]);
        } 
        return redirect(route('sous_compte.index'));
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
        $SCompte = SousCompte::findOrFail($id);
        $SCompte->update([
            'Etat'=>1
        ]);
        return redirect(route('sous_compte.index'));
    }

    public function getSCompteId(Request $request){
        $SComptes = CompteSubdivisionnaire::whereEtat(0)->get();
        $CompteId = $request->get('compte');
        $Compte =DB::table('compte_subdivisionnaires')
                ->join('sous_comptes', 'sous_comptes.Compte_subd', '=', 'compte_subdivisionnaires.id')
                ->select(DB::raw('sous_comptes.id,sous_comptes.NumeroCompte, sous_comptes.Intitule,compte_subdivisionnaires.id as CPid, compte_subdivisionnaires.NumeroCompte as CPN,compte_subdivisionnaires.Intitule as CPI'))
                ->where('sous_comptes.id', $CompteId)->first();
       
        $CompteAll ='<option value='.$Compte->CPid.'>'.$Compte->CPN.' - '.$Compte->CPI.'</option>'; 
                foreach($SComptes as $SCompte){
                    $CompteAll.='<option value='.$SCompte->id.'>'.$SCompte->NumeroCompte.' - '.$SCompte->Intitule.'</option>';
                }
            $TypeDetail =  $Compte->id.'#'.$Compte->NumeroCompte.'#'.$Compte->Intitule.'#'.$CompteAll;
        echo  $TypeDetail;
    }

    public function UpdateSousCompte(Request $request){
        $SCompte = SousCompte::findOrFail($request->Identifiant);
        $SCompte->update([
            'NumeroCompte'=>$request->Numero,
            'Intitule'=>$request->Intitule,
            'Compte_subd'=>$request->Compte
        ]);
         return redirect(route('sous_compte.index'));
    }
}
