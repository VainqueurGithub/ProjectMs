<?php

namespace App\Http\Controllers;
use\App\Http\Requests\CompteRepportFromRequest;
use Illuminate\Http\Request;
use\App\Models\ComptePrincipal;
use\App\Models\CompteRepport;
use\App\Models\Repportage;
use\App\Models\CompteSubdivisionnaire;
use\App\Models\compte_report_compte;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;

class CompteRepportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $Comptes=DB::table('compte_repports')
                 ->Leftjoin('compte_report_comptes', 'compte_repports.id', '=', 'compte_report_comptes.compte_repport_id')
                 ->select(DB::raw('compte_repports.id,compte_repports.NumeroCompte,compte_repports.Type_compte'))
                 ->where('compte_repports.etat',0)
                 //->where('compte_report_comptes.etat',0)
                 ->groupBy('compte_repports.id')
                 ->get();  
        $ComptePrincipal = ComptePrincipal::whereEtat(0)->get();      
        return view('Comptabilite/CompteRepport.index', compact('Comptes', 'ComptePrincipal'));
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
    public function store(CompteRepportFromRequest $request)
    {  
       if (CompteRepport::UniqueCompte($request->Numero)) {
                CompteRepport::create([
                'NumeroCompte'=>$request->Numero,
                'Type_compte'=>$request->TypeCompte
                ]);
        }
        return redirect(route('CompteRepport.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        $CompteR = $id;
        $ComptePrincipal = DB::table('compte_principals')
                          ->Leftjoin('compte_report_comptes', 'compte_principals.id', '=', 'compte_report_comptes.compte_principale_id')
                          ->select(DB::raw('compte_report_comptes.compte_principale_id,compte_principals.id,compte_principals.NumeroCompte,compte_principals.Intitule,compte_report_comptes.compte_repport_id,compte_report_comptes.etat'))
                          ->get();
        return view('Comptabilite/CompteRepport.show', compact('ComptePrincipal', 'CompteR'));
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
    public function update(CompteRepportFromRequest $request, $id)
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

    //FX POUR ATTACHER DES COMPTES A CES COMPTE DE REPPORT

    public function attachedAccount(Request $request){
          
        $comptes = $request['compte'];
        $i=0;
        
        $NbreR = compte_report_compte::whereCompteRepportId($request->CompteR)->count('id');
        $ComptesR = compte_report_compte::whereCompteRepportId($request->CompteR)->get();

        for ($i=0; $i <count($request['compte']) ; $i++) { 
            $compte = (int)$comptes[$i];
           
           if ($NbreR>0) {
               foreach ($ComptesR as $CompteR) {
                $Nbre = compte_report_compte::whereCompteRepportIdAndComptePrincipaleId($request->CompteR,$compte)->count('id');
                if($Nbre>0){
                    $CompteToUpdate = compte_report_compte::whereCompteRepportIdAndComptePrincipaleId($request->CompteR,$compte)->first();
                    $CompteToUpdate->update([
                    'etat'=>0
                    ]);
                }else{
                    compte_report_compte::create([
                        'compte_principale_id'=>$compte,
                        'compte_repport_id'=>$request->CompteR
                    ]);
                }
            } 
           }else{
               compte_report_compte::create([
                        'compte_principale_id'=>$compte,
                        'compte_repport_id'=>$request->CompteR
                    ]);
           }
            
        } 
        return redirect(route('CompteRepport.index'));   
    }
    
    //FX POUR DETTACHER DES COMPTES A CES COMPTE DE REPPORT
    public function dettachedAccount(Request $request){
          
        $comptes = $request['compte'];
        $i=0;
        for ($i=0; $i <count($request['compte']) ; $i++) { 
            $compte = (int)$comptes[$i];
            $CompteR = compte_report_compte::whereCompteRepportIdAndComptePrincipaleId($request->CompteR,$compte)->first();    
            $CompteR->update([
                'etat'=>1
            ]);
        } 
        return redirect(route('CompteRepport.index'));   
    }

    public function researchComptesReported(Request $request){
        $Compte=$request->get('NumeroCompte');
        $SComptes=DB::table('compte_principals')
                  ->join('compte_report_comptes', 'compte_report_comptes.compte_principale_id', '=', 'compte_principals.id')
                  ->select(DB::raw('DISTINCT(compte_principals.id),compte_principals.NumeroCompte,compte_principals.Intitule'))
                 ->where('compte_principals.NumeroCompte','like','%'.$Compte.'%')
                 ->where('compte_principals.Etat',0)
                 ->where('compte_report_comptes.Etat',0)
                 ->get();


        $AllSComptes="";
        foreach ($SComptes as $SCompte) {
            $AllSComptes.="<option value='".$SCompte->id."'>".$SCompte->NumeroCompte.'/'.$SCompte->Intitule."</option>";
        }
        echo $AllSComptes;
    }

    public function SettedAccountAsRepported($id){
        $CompteR = $id;
        $ComptePrincipal = DB::table('compte_principals')
                          ->join('compte_report_comptes', 'compte_principals.id', '=', 'compte_report_comptes.compte_principale_id')
                          ->select(DB::raw('compte_report_comptes.compte_principale_id,compte_principals.id,compte_principals.NumeroCompte,compte_principals.Intitule,compte_report_comptes.compte_repport_id'))
                          ->where('compte_report_comptes.compte_repport_id',$id)
                          ->where('compte_report_comptes.etat',0)
                          ->get();
        return view('Comptabilite/CompteRepport.show1', compact('ComptePrincipal', 'CompteR'));
    }
}
