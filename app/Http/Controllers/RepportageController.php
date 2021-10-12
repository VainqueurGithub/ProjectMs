<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReportageFormRequest;
use App\Http\Requests;
use App\Models\Repportage;
use App\Models\ComptePrincipal;
use App\Models\ExcelImport;
use App\Interfaces\IExcelImport as IExcelImport;
use App\Interfaces\IRepportage as IRepportage;
use DB;

class RepportageController extends Controller
{  
    public function __construct(IExcelImport $ExcelImport, IRepportage $Repportage){
        $this->ExcelImport = $ExcelImport;
        $this->Repportage = $Repportage;
        $this->middleware('guest');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $CompteSubdivisionnaires = DB::table('types')
                                ->join('compte_principals', 'types.id', '=', 'compte_principals.TypeCompte')
                                ->select(DB::raw('compte_principals.id, compte_principals.NumeroCompte, compte_principals.Intitule'))
                                ->where('types.Etat',0)
                                ->where('types.Type_Compte',1)
                                ->where('compte_principals.Etat',0)->get();
        $Repportage = new Repportage;
        $Saisies = DB::table('compte_principals')
                ->join('repportages', 'repportages.compte_id', '=', 'compte_principals.id')
                ->select(DB::raw('DISTINCT(compte_principals.NumeroCompte),repportages.id, repportages.montant, repportages.type_mvt'))
                ->get();
        return view('Comptabilite/CompteRepport.SaisieNouveauForm', compact('Saisies', 'Repportage', 'CompteSubdivisionnaires'));
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
    public function store(ReportageFormRequest $request)
    {   
     
      if($request->Montant!=0){
          Repportage::create([
            'compte_id'=>$request->Compte,
            'montant'=>$request->Montant,
            'reported_in'=>session()->get('ExerciceComptableId'),
            'type_mvt'=>$request->Categorie
        ]);
      }else{
        session()->flash('messageDelete', 'Le Montant à repporter ne peut pas etre égale à 0 !');
      }     
        return redirect(route('Repportage.index')); 
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
        $CompteSubdivisionnaires = DB::table('types')
                                ->join('compte_principals', 'types.id', '=', 'compte_principals.TypeCompte')
                                ->select(DB::raw('compte_principals.id, compte_principals.NumeroCompte, compte_principals.Intitule'))
                                ->where('types.Etat',0)
                                ->where('types.Type_Compte',1)
                                ->where('compte_principals.Etat',0)->get();

        $Repportage = Repportage::findOrFail($id);
       $Saisies = DB::table('compte_principals')
                ->join('repportages', 'repportages.compte_id', '=', 'compte_principals.id')
                ->select(DB::raw('DISTINCT(compte_principals.NumeroCompte),repportages.id, repportages.montant, repportages.type_mvt'))
                ->get();

        return view('Comptabilite/CompteRepport.SaisieNouveauFormEdit', compact('Saisies', 'Repportage', 'CompteSubdivisionnaires'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ReportageFormRequest $request, $id)
    {   
          $Repportage = Repportage::findOrFail($id);
      if($request->Montant!=0){
          $Repportage->update([
            'compte_id'=>$request->Compte,
            'montant'=>$request->Montant,
            'type_mvt'=>$request->Categorie
        ]);
      }else{
        session()->flash('messageDelete', 'Le Montant à repporter ne peut pas etre égale à 0 !');
      }     
        return redirect(route('Repportage.index')); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $Repportage = Repportage::findOrFail($id);
         $Repportage->destroy($id);

         session()->flash('messageDelete', 'Suppression effectuée avec success !');
         return redirect(route('SaisieNouveauForm')); 
    }

    public function uploadinitialbilanform(){
        return view('Comptabilite/CompteRepport.uploadinitialbilanform');
    }

    public function getRepportageId(){
         $RepportId = $request->get('repportage');
         $Compte =DB::table('compte_principals')
                ->join('repportages', 'repportages.compte_id', '=', 'compte_principals.id')
                ->select(DB::raw('compte_principals.id,compte_principals.NumeroCompte, compte_principals.Intitule, repportages.montant'))
                ->where('repportage.id', $RepportId)->first();
       
        $CompteAll ='<option value='.$Compte->id.'>'.$Compte->NumeroCompte.' - '.$Compte->Intitule.'</option>'; 
        $TypeDetail =  $Compte->montant.'#'.$CompteAll;
        echo  $TypeDetail;
    }

    public function uploadfile(Request $request){

           $this->ExcelImport->uploadIntialBilan($request);
           return back();
    }
}
