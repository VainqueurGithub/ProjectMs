<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parametre;
use App\Http\Requests;
use App\Http\Requests\ParametreFormRequest;
class ParametreController extends Controller
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
        $Nbre = Parametre::whereId($id)->count('id');
        if ($Nbre>0) {
            $Parametre = Parametre::findOrFail($id);
        }else{
           $Parametre = NEW Parametre;
        }
        return view('Comptabilite/Parametre.edit', compact('Parametre'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ParametreFormRequest $request, $id)
    {   

        $Nbre = Parametre::whereId($id)->count('id');
        if ($Nbre>0) {
            $Parametre = Parametre::findOrFail($id);
        }else{
           $Parametre = NEW Parametre;
        }

        $Headerfile = $request->file('entete');
        $Footerfile = $request->file('footer');
        $Header ='images/'.$Headerfile->getClientOriginalName();
        $Footer ='images/'. $Footerfile->getClientOriginalName();

        if (($Headerfile->move('images', $Header)) AND ($Footerfile->move('images', $Footer))) {
    
        $Parametre->update([
            'nom_societe'=>$request->Nom,
            'nif'=>$request->Nif,
            'email'=>$request->email,
            'telephone'=>$request->telephone,
            'adresse'=>$request->adresse,
            'bq_nom_un'=>$request->first_banque_name,
            'bq_num_un'=>$request->first_banque_number,
            'bq_nom_deux'=>$request->second_banque_name,
            'bq_num_deux'=>$request->second_banque_number,
            'entete'=>$Header,
            'footer'=>$Footer,
        ]);
      }

              $InfoGeneral = Parametre::where('entete', '!=', '')->where('footer', '!=', null)->first();
                $request->session()->put('Nom_Societe', $InfoGeneral->nom_societe);
                $request->session()->put('Nif', $InfoGeneral->nif);
                $request->session()->put('email', $InfoGeneral->email);
                $request->session()->put('Telephone', $InfoGeneral->telephone);
                $request->session()->put('Adresse', $InfoGeneral->adresse);
                $request->session()->put('BqnomUn', $InfoGeneral->bq_nom_un);
                $request->session()->put('BqnumUn', $InfoGeneral->bq_num_un);
                $request->session()->put('BqnomDeux', $InfoGeneral->bq_nom_deux);
                $request->session()->put('BqnumDeux', $InfoGeneral->bq_num_deux);
                $request->session()->put('Headerfile', $InfoGeneral->entete);
                $request->session()->put('Footerfile', $InfoGeneral->footer);

        return redirect(route('Parametre_generaux.edit', compact('id')));
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
}
