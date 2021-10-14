<?php

namespace App\Http\Controllers;
use App\Models\ComptePrincipal;
use App\Models\CompteSubdivisionnaire;
use App\Models\soldeJournalier;
use App\Models\Journal;
use Illuminate\Http\Request;
use DB;

class SoldejournalierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {   
        $MontantMD = Journal::whereCompteAndSousCompteAndDateoperation($request->Compte,$request->sc_compte1,$request->SoldeOutcome)->sum('MD');
        $MontantMC = Journal::whereCompteAndSousCompteAndDateoperation($request->Compte,$request->sc_compte1,$request->SoldeOutcome)->sum('MC');

        soldeJournalier::create([
            'Comptesudb'=>$request->Compte,
            'Souscompte'=>$request->sc_compte1,
            'dateOperation'=>$request->SoldeOutcome,
            'repporterAu'=>$request->SoldeIncome,
            'montant'=>$MontantMD-$MontantMC
        ]);

        return back();
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
       $Solde = soldeJournalier::findOrFail($id); 
       $Solde->destroy($id);
       return back();
    }

    public function soldeJournalierForm(){
        $ComptePrincipals = ComptePrincipal::whereEtat(0)->get();
        return view('Comptabilite.Solde/soldeJournalierForm', compact('ComptePrincipals'));
    }

    public function SoldeJournalierAccount(Request $request){
         $comptes = $request['compte'];
         $i=0;

         for ($i=0; $i <count($request['compte']) ; $i++) { 
            $compte = (int)$comptes[$i];
            $CompteP = ComptePrincipal::findOrFail($compte); 
            if (isset($request->Ajouter)) {
                $CompteP->update([
                    'soldeJournalier'=>1
                ]);  
            }else if(isset($request->Supprimer)){
                $CompteP->update([
                    'soldeJournalier'=>0
                ]);  
            }
        } 
        
        return back();    
    }

    public function SoldeJournalier(){
        $Today = date('Y-m-d');
        $ComptePrincipals = ComptePrincipal::whereEtatAndSoldejournalier(0,1)->get();
        $Scomptes =DB::table('compte_principals')
                  ->join('compte_subdivisionnaires', 'compte_subdivisionnaires.ComptePricipal', '=', 'compte_principals.id')
                  ->select(DB::raw('compte_subdivisionnaires.id,compte_subdivisionnaires.NumeroCompte,compte_subdivisionnaires.Intitule'))
                  ->where('compte_subdivisionnaires.Etat',0)
                  ->where('compte_principals.soldeJournalier', 1)
                  ->get();

        $Soldes = DB::table('compte_subdivisionnaires')
                ->join('solde_journaliers', 'solde_journaliers.Comptesudb', '=', 'compte_subdivisionnaires.id')
                ->select(DB::raw('compte_subdivisionnaires.id, compte_subdivisionnaires.NumeroCompte, compte_subdivisionnaires.Intitule,solde_journaliers.dateOperation,solde_journaliers.repporterAu,sum(solde_journaliers.montant) as montant'))
                ->where('solde_journaliers.dateOperation',$Today)
                ->orWhere('solde_journaliers.repporterAu',$Today)
                ->orWhere('solde_journaliers.created_at',$Today)
                ->groupBy('compte_subdivisionnaires.id')
                ->groupBy('solde_journaliers.dateOperation')
                ->get();
        return view('Comptabilite.Solde/SoldeJournalier', compact('ComptePrincipals', 'Soldes', 'Scomptes'));
    }

    public function getSolde(Request $request){
        $MontantMD = Journal::whereCompteAndSousCompteAndDateoperation($request->Compte,$request->sc_compte1,$request->SoldeOutcome)->sum('MD');
        $MontantMC = Journal::whereCompteAndSousCompteAndDateoperation($request->Compte,$request->sc_compte1,$request->SoldeOutcome)->sum('MC');
    }

    public function solde_detail($id, $periode){
        $Soldes = DB::table('compte_subdivisionnaires')
                ->join('solde_journaliers', 'solde_journaliers.Comptesudb', '=', 'compte_subdivisionnaires.id')
                ->Leftjoin('sous_comptes', 'sous_comptes.id', '=', 'solde_journaliers.Souscompte')
                ->select(DB::raw('compte_subdivisionnaires.NumeroCompte,solde_journaliers.dateOperation,solde_journaliers.repporterAu,montant,sous_comptes.NumeroCompte as Nsc, sous_comptes.Intitule as Isc, solde_journaliers.id'))
                ->where('solde_journaliers.Comptesudb', $id)
                ->where('solde_journaliers.dateOperation', $periode)
                ->get();
        return view('Comptabilite.Solde/solde_detail', compact('Soldes'));
    }
}
