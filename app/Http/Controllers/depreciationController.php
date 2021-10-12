<?php

namespace App\Http\Controllers;
use App\Models\biens;
use App\Models\depreciation;
use App\Models\Depreciationtype;
use App\Models\ExerciceComptable;
use Illuminate\Http\Request;
use DB;
class depreciationController extends Controller
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
        if (isset($request->generate)) {
            
        }
        
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
        //
    }

    public function depreciationForm(Request $request){

       if (isset($request->Rapport)) {
            $Depreciations =DB::table('depreciations')
                ->join('biens', 'biens.id', '=', 'depreciations.Bien_id')
                ->join('depreciationtypes', 'depreciationtypes.id', '=', 'biens.Type')
                ->select(DB::raw('depreciations.id,biens.Nom,YEAR(depreciations.Date_debut) as Annee,depreciations.Montant'))
                ->where('depreciations.Reported_in', session()->get('ExerciceComptableId'))
                ->where('biens.Type', $request->Type)
                ->where('depreciations.Reported_in', $request->Exercice)
                ->get();
            $Total = DB::table('depreciations')
                ->join('biens', 'biens.id', '=', 'depreciations.Bien_id')
                ->join('depreciationtypes', 'depreciationtypes.id', '=', 'biens.Type')
                ->select(DB::raw(''))
                ->where('depreciations.Reported_in', session()->get('ExerciceComptableId'))
                ->where('depreciations.Reported_in', $request->Exercice)
                ->where('biens.Type', $request->Type)
                ->sum('depreciations.Montant');                
            $Types = Depreciationtype::whereEtat(0)->get();
        }else{
            $Depreciations =DB::table('depreciations')
                ->join('biens', 'biens.id', '=', 'depreciations.Bien_id')
                ->select(DB::raw('depreciations.id,biens.Nom,YEAR(depreciations.Date_debut) as Annee,depreciations.Montant'))
                ->where('depreciations.Reported_in', session()->get('ExerciceComptableId'))
                ->get();
            $Total = DB::table('depreciations')
                ->join('biens', 'biens.id', '=', 'depreciations.Bien_id')
                ->select(DB::raw(''))
                ->where('depreciations.Reported_in', session()->get('ExerciceComptableId'))
                ->sum('depreciations.Montant');                
            $Types = Depreciationtype::whereEtat(0)->get();
        } 
        
        $ExerciceComptables = ExerciceComptable::whereEtat(0)->get();
        return  view('depreciations/Biens.depreciationForm', compact('Depreciations', 'Types', 'Total', 'ExerciceComptables'));
    }
}
