<?php

namespace App\Http\Controllers;
use App\Http\Requests\medicamentPartenaireFormRequest;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Historiquemedicaments;
use App\Models\Partenaire;
use App\Models\Consomation;
use App\Models\medicamentsservice;
use App\Models\MedicamentPartenaire;
class medicamentPartenaireController extends Controller
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
    public function store(medicamentPartenaireFormRequest $request)
    {  
        $Today = date('Y-m-d');
        $id = $request->Libelle;
        MedicamentPartenaire::create([
            'medicament'=>$request->Libelle,
            'partenaire'=>$request->Partenaire,
            'prix'=>$request->Prix,
            'code'=>$request->Code,
            'designation'=>$request->Designation
        ]);
        session()->flash('message', 'Prestation ajoutée');
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
        $Partenaires = Partenaire::whereEtat(0)->get();
        $medicament = MedicamentPartenaire::findOrFail($id);
        $Partenaire = Partenaire::findOrFail($medicament->partenaire);
        $id = $medicament->medicament;
        return view('MedicamentPartenaire.edit', compact('Partenaires', 'medicament', 'Partenaire', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(medicamentPartenaireFormRequest $request, $id)
    {
        $medicament = MedicamentPartenaire::findOrFail($id);
        $prix = $medicament->prix;
        $medicament->update([
            'medicament'=>$request->Libelle,
            'partenaire'=>$request->Partenaire,
            'prix'=>$request->Prix,
            'code'=>$request->Code,
            'designation'=>$request->Designation
        ]);

        session()->flash('message', 'Prestation Mis à jour avec succèss');
        return back();
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

    //Rattacher un medicament a un Partenaire

    public function Rattacher($id){
        $Partenaires = Partenaire::whereEtat(0)->get();
        $Partenaire = New Partenaire;
        $medicament = New medicamentsservice;
        return view('medicamentPartenaire.create', compact('id', 'Partenaires', 'Partenaire', 'medicament'));
    }
}
