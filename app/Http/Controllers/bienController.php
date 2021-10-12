<?php

namespace App\Http\Controllers;
use App\Models\biens;
use App\Models\Depreciationtype;
use App\Models\depreciation;
use App\Models\Journal;
use App\Models\CompteSubdivisionnaire;
use Illuminate\Http\Request;
use App\Http\Requests\bienformrequest;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Input;
class bienController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $Types = Depreciationtype::whereEtat(0)->get();
        $Biens = biens::whereEtat(0)->get();
        return  view('depreciations/Biens.index', compact('Biens', 'Types'));
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
    public function store(bienformrequest $request)
    {   
        biens::create([
            'Type'=>$request->Type,
            'Nom'=>$request->Nom,
            'Date_acquis'=>$request->Dateacquis,
            'Moyen_acquis'=>$request->Moyen,
            'Mis_service'=>$request->Misservice,
            'Montant'=>$request->Montant,
            'Duree'=>$request->Duree,
            'Taux'=>$request->Taux,
            'Methode'=>$request->Methode,
            'Provenance'=>$request->Provenance,
            'Last_depreciation'=>$request->Misservice,
            'Compte_subd1'=>$request->Csubdiv1,
            'Compte_sous1'=>$request->sc_compte1,
            'Compte_subd2'=>$request->Csubdiv2,
            'Compte_sous2'=>$request->sc_compte2
        ]);
        return redirect(route('Bien.index'));
    }

    /**11 
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
         //J'ouvre mon fichier en ecriture:
         $ecrire = fopen('plan_depreciation.txt',"w");
         //Je tronque mon fichier jusqu'au pointeur en position 0.
         ftruncate($ecrire,0);

        //GENERATION DU PLAN D'AMORTISEMENT
         $Imo = DB::table('biens')
              ->select(DB::raw('id,Duree,Mis_service'))
              ->whereEtat(0)
              ->whereId($id)
              ->first();

         $B = biens::findOrFail($id);
            $B->update([
                'Last_depreciation'=>$Imo->Mis_service,
            ]); 
                  
           $j=0;
         for ($i=0; $i <= $Imo->Duree; $i++) { 

            $Bien = DB::table('biens')
              ->select(DB::raw('Methode, DAY(Last_depreciation) as Jour, MONTH(Last_depreciation) as Moi, YEAR(Last_depreciation) as annee, Montant, Taux, id, Last_depreciation,Duree, DAY(Mis_service) as MJour, MONTH(Mis_service) as MMois, Mis_service'))
              ->whereEtat(0)
              ->whereId($id)
              ->first();
             $Anne = $Bien->annee+$j;
             $Jour = $Bien->MJour-1;
            if ($i==$Imo->Duree) {
                $end_date = $Bien->annee.'-'.$Bien->MMois.'-'.$Jour;
            }else{
               $end_date = $Anne.'-12-31';
            }
            
            $B = biens::findOrFail($id);
            $B->update([
                'Last_depreciation'=>$end_date,
            ]); 

            $depreciation_amount = depreciation::depreciation_amount($id);
           
           fputs($ecrire, 1+$i."|");
           fputs($ecrire, $Bien->id."|");
           fputs($ecrire, $Bien->Last_depreciation."|");
           fputs($ecrire, $end_date."|");
           fputs($ecrire, $depreciation_amount."\n");
             $j=1;  
         }  
         fclose($ecrire);
        
         $table = "";
         $ecrire = 'plan_depreciation.txt';
         if(file_exists($ecrire)) {
         if(filesize($ecrire) != 0) { // le fichier n'est pas vide
 
         $lignes = file($ecrire);
 
         foreach($lignes as $ligne_num => $ligne) { // on lit le fichier de façon séquentielle
         $array = explode('|', $ligne); // retire le séparateur
         $DetailD = depreciation::whereBienIdAndDateDebutAndDateFin($array[1],$array[2],$array[3])->first();

         if (is_null($DetailD)) {
             $table.="<tr>
         <td>". $array[0] ."</td>
         <td>". $array[1] ."</td>
         <td>". $array[2] ."</td>
         <td>". $array[3] ."</td>
         <td>". $array[4] ."</td>
          <td class='center f-icon'>
            <a href='".route('TransfererCompta',$ligne)."'>Transferer</a>
          </td>
         </tr>";
         }else{
            $table.="<tr>
         <td>". $array[0] ."</td>
         <td>". $array[1] ."</td>
         <td>". $array[2] ."</td>
         <td>". $array[3] ."</td>
         <td>". $array[4] ."</td>
          <td class='center f-icon'>Comptabilisé</td>
         </tr>";
         }
         
    }
  }
} 
        $TableListe = $table;
        return  view('depreciations/Biens.show', compact('TableListe'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $Bien =DB::table('biens')
              ->join('depreciationtypes', 'depreciationtypes.id', 'biens.Type')
              ->select(DB::raw('depreciationtypes.id, depreciationtypes.Type,biens.id as Bid,biens.Nom, biens.Date_acquis, biens.Moyen_acquis, biens.Mis_service, biens.Montant, biens.Duree, Taux,biens.Methode, biens.Provenance')) 
              ->where('biens.id', $id)
              ->first();

        $CompteSubd1 = DB::table('biens')
                    ->join('compte_subdivisionnaires', 'compte_subdivisionnaires.id', '=', 'biens.Compte_subd1')    
                    ->select(DB::raw('compte_subdivisionnaires.NumeroCompte, compte_subdivisionnaires.Intitule, compte_subdivisionnaires.id'))
                    ->first();  

        $CompteSubd2 = DB::table('biens')
                    ->join('compte_subdivisionnaires', 'compte_subdivisionnaires.id', '=', 'biens.Compte_subd2')    
                    ->select(DB::raw('compte_subdivisionnaires.NumeroCompte, compte_subdivisionnaires.Intitule, compte_subdivisionnaires.id'))
                    ->first();  

        $Scomptes1 = DB::table('biens')
                    ->join('sous_comptes', 'sous_comptes.id', '=', 'biens.Compte_sous1')    
                    ->select(DB::raw('sous_comptes.NumeroCompte, sous_comptes.Intitule, sous_comptes.id'))
                    ->first();  

        $Scomptes2 = DB::table('biens')
                    ->join('sous_comptes', 'sous_comptes.id', '=', 'biens.Compte_sous2')    
                    ->select(DB::raw('sous_comptes.NumeroCompte, sous_comptes.Intitule, sous_comptes.id'))
                    ->first();  
        $Depreciationtype = Depreciationtype::whereEtat(0)->get();
        $Scomptes = CompteSubdivisionnaire::whereEtat(0)->get();
        return view('depreciations/Biens.edit', compact('Bien', 'Depreciationtype', 'Scomptes', 'CompteSubd1', 'CompteSubd2', 'Scomptes1', 'Scomptes2'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(bienformrequest $request, $id)
    {   
        $Bien = biens::findOrFail($id);
         $Bien->update([
            'Type'=>$request->Type,
            'Nom'=>$request->Nom,
            'Date_acquis'=>$request->Dateacquis,
            'Moyen_acquis'=>$request->Moyen,
            'Mis_service'=>$request->Misservice,
            'Montant'=>$request->Montant,
            'Duree'=>$request->Duree,
            'Taux'=>$request->Taux,
            'Methode'=>$request->Methode,
            'Provenance'=>$request->Provenance,
            'Last_depreciation'=>$request->Misservice,
            'Compte_subd1'=>$request->Csubdiv1,
            'Compte_sous1'=>$request->sc_compte1,
            'Compte_subd2'=>$request->Csubdiv2,
            'Compte_sous2'=>$request->sc_compte2
        ]);
        return redirect(route('Bien.index'));
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

    public function TransfererCompta($row){
        $array = explode('|', $row);
        depreciation::create([
            'Bien_id'=>$array[1],
            'Date_debut'=>$array[2],
            'Date_fin'=>$array[3],
            'Montant'=>$array[4],
            'Reported_in'=>session()->get('ExerciceComptableId')
        ]);
        $Bien = $array[1];
        $Detail = biens::findOrFail($Bien);
         Journal::create([
            //'Ordre'=>$request->Ordre,
            'Compte'=>$Detail->Compte_subd1,
            'TypeMvt'=>1,
            'Sous_compte'=>$Detail->Compte_sous1,
            'DateOperation'=>date('Y-m-d'),
            'MD'=>$array[4],
            'Libelle'=>'Dotations aux amortissements',
            'Exercice'=>session()->get('ExerciceComptableId')
              ]);

         Journal::create([
            //'Ordre'=>$request->Ordre,
            'Compte'=>$Detail->Compte_subd2,
            'TypeMvt'=>2,
            'Sous_compte'=>$Detail->Compte_sous2,
            'DateOperation'=>date('Y-m-d'),
            'MC'=>$array[4],
            'Libelle'=>'Amortissements',
            'Exercice'=>session()->get('ExerciceComptableId')
         ]);

        session()->flash('message', 'Ce Bien a été amortie de '.$array[4]); 
        return redirect(route('Bien.show', compact('Bien')));
    }
}
