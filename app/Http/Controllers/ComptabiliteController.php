<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use\App\Models\ExerciceComptable;
use\App\Models\ComptePrincipal;
use\App\Models\CompteSubdivisionnaire;
use\App\Models\SousCompte;
use\App\Models\CodeJournaux;
use\App\Models\Journal;
use App\Http\Requests;

class ComptabiliteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
       $Exercice = ExerciceComptable::whereEtatAndCloturer(0,0)->first(); 
       session()->put('ExerciceComptableId', $Exercice->id);
       session()->put('ExerciceComptableDebut', $Exercice->Debut);
       session()->put('ExerciceComptableFin', $Exercice->Fin);
       return view('Comptabilite.index');
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
        //
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

    public function rapport_comptabilite(){
        $Exe = ExerciceComptable::findOrFail(session()->get('ExerciceComptableId'));
        $ComptePrincipals = ComptePrincipal::whereEtat(0)->get();
        $CompteSubdivisionnaires = CompteSubdivisionnaire::whereEtat(0)->get();
        $SComptes = SousCompte::whereEtat(0)->get();
        $CodeJournaux = CodeJournaux::whereEtat(0)->get();
        $Journal = New Journal;
        return  view('Comptabilite/Journal.repport', compact('Exe', 'ComptePrincipals', 'CompteSubdivisionnaires', 'SComptes', 'CodeJournaux', 'Journal'));
    }
}
