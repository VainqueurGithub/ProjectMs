<?php

namespace App\Http\Controllers;
use\App\Http\Requests\TypeFormRequest;
use Illuminate\Http\Request;
use\App\Models\Type;


class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Types = Type::whereEtat(0)->get();
        return view("Comptabilite/TypeCompte.index", compact('Types'));
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
    public function store(TypeFormRequest $request)
    {  
       if (Type::UniqueTypeAcount($request->Intitule)==true AND Type::uniqueClass($request->Classe)==true) {
            Type::create([
            'Class'=>$request->Classe,
            'Types'=>$request->Intitule,
            'Type_Compte'=>$request->Type
            ]);
        } 
        return redirect(route('TypeCompte.index'));
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
        $Type = Type::findOrFail($id);
        return view('Comptabilite/TypeCompte.edit', compact('Type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TypeFormRequest $request, $id)
    {
        $Type = Type::findOrFail($id);
        $Type->update([
            'Class'=>$request->Classe,
            'Types'=>$request->Nature
        ]);
         return redirect(route('TypeCompte.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Type = Type::findOrFail($id);
        $Type->update([
            'Etat'=>1
        ]);

        return redirect(route('TypeCompte.index'));
    }

    public function getTypeCompteId(Request $request){
        $TypeId = $request->get('type');
        $Type = Type::findOrFail($TypeId);
        
        if ($Type->Type_Compte==1) {
            $radiobuttom = '<div class="form-inline">
            Comptes du Bilan <input type="radio" name="Type" class="form-control" value="1" checked="checked">
            </div>
            <div class="form-inline">
            Comptes de gestion <input type="radio" name="Type" class="form-control" value="2">
           </div>';
        }else if($Type->Type_Compte==2){
             $radiobuttom = ' <div class="form-inline">
             Comptes du Bilan <input type="radio" name="Type" class="form-control" value="1">
             </div>
             <div class="form-inline">
             Comptes de gestion <input type="radio" name="Type" class="form-control" value="2" checked="checked">
            </div>';
        }
        
            $TypeDetail =  $Type->id.'#'.$Type->Class.'#'.$Type->Types.'#'.$radiobuttom;

        echo  $TypeDetail;
    }

    public function Update_typeCompte(Request $request){
        $Type = Type::findOrFail($request->Identifiant);
        $Type->update([
            'Class'=>$request->Classe,
            'Types'=>$request->Intitule,
            'Type_Compte'=>$request->Type
        ]);
        return redirect(route('TypeCompte.index'));
    }
}
