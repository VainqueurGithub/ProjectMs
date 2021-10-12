<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Origine;
use App\Models\AyantDroit;
use App\Interfaces\IOrigine as IOrigine;
use App\Models\Affilier;
use App\Interfaces\IAffilie as IAffilie;
use App\Models\ExcelImport;
use App\Interfaces\IExcelImport as IExcelImport;
use App\Models\Cotisation;
class OrigineController extends Controller
{

     public function __construct(IOrigine $Origine, IAffilie $Affilier, IExcelImport $ExcelImport){
        $this->Origine = $Origine;
        $this->Affilier = $Affilier;
        $this->ExcelImport = $ExcelImport;
        $this->middleware('guest');
      }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $Origines = $this->Origine->fetchtAll();
       $Nbre = $this->Affilier->AffilieRedondance();
       $Origine = new Origine;
        // Nom du fichier à ouvrir
        $fichier = file("codesumulaire.txt");
       return view('Origines.index', compact('Origines', 'Nbre', 'fichier', 'Origine'));  
    }
    
    //EFFACER LE CONTENU DU FICHIER
    public function cleanFile(){
        //J'ouvre mon fichier en ecriture:
        $ecrire = fopen('codesumulaire.txt',"w");
        //Je tronque mon fichier jusqu'au pointeur en position 0.
        ftruncate($ecrire,0);
        return redirect(route('Origines.index'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {  
       $Origine = new Origine;
       return view('Origines.create', compact('Origine'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  
        $NbreO = Origine::whereOrigine($request->Origine)->count();
       if ($NbreO == 0) 
       {
          $this->validate($request, [
          'Origine' => 'required'
           ]);
            Origine::create([
            'Origine' => $request->Origine
        ]);
         session()->flash('message', 'Origine Créee avec success!');
        }
        else
        {
         session()->flash('messageDelete', 'Cet Origine existe deja');
        }

        return redirect(route('Origines.index'));
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
        $Origine = Origine::findOrFail($id);
        return view('Origines.edit', compact('Origine'));
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
      $NbreO = Origine::whereOrigine($request->Origine)->where('id', '!=', $id)->count();
       if ($NbreO == 0) 
       {
          $this->validate($request, [
          'Origine' => 'required'
           ]);

          $Origine = Origine::findOrFail($id);
            $Origine->update([
            'Origine' => $request->Origine
        ]);
         session()->flash('message', 'Origine Modifiee avec success!');
        }
        else
        {
         session()->flash('messageDelete', 'Cet Origine existe deja');
        }
        return redirect(route('Origines.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Origine = Origine::findOrFail($id);
            $Origine->update([
            'Etat' => 1
        ]);
         session()->flash('messageDelete', 'Origine Supprimee avec success!');
        return redirect(route('Origines.index')); 
    }


    public function getOrigineId(Request $request){

        $OrigId = $request->get('origine');
        $Origines = Origine::whereId($OrigId)->get();
       

        $OrigineDetail="";
        foreach ($Origines as $Origine) {
            $OrigineDetail =  $Origine->id.'#'.$Origine->Origine;
        }
        
        echo  $OrigineDetail;
    }

    public function perfomAction(Request $request){

        //CAS D'ACTION UPLOADAGE FICHIER
        if (isset($request->action) AND $request->action==0) {

            $this->ExcelImport->uploadAffilier($request);
   
        }
        
        //CAS D'ACTION UPLOADAGE FICHIER AYANTS DROITS BY ORIGINE
        elseif(isset($request->action) AND $request->action==3){
            $this->ExcelImport->uplodaAyantDroitByOrigine($request);
        }
        //CAS D'ACTION SUPPRESSION TOUS LES AFFILIES POUR UN ORIGINE X
        elseif (isset($request->action) AND $request->action==1) {
            
            $Affiliers = $this->Affilier->AffilierByOrigine($request->Origine);

            foreach ($Affiliers as $Aff) {
                 $this->Affilier->deleteData($Aff->id);
            }

        //CAS D'ACTION SUPPRESSION TOUS LES AFFILIES AVEC LEUR ORIGINE   
        }elseif(isset($request->action) AND $request->action==2){

            $Affiliers = $this->Affilier->AffilierByOrigine($request->Origine);

            foreach ($Affiliers as $Aff) {
               $this->Affilier->deleteData($Aff->id);
            }
           
            $this->Origine->deleteData($request->Origine);
            
        }elseif(isset($request->action) AND $request->action==4){
              $Affiliers = $this->Affilier->AffilierByOrigine($request->Origine);

            foreach ($Affiliers as $Aff) {
                
                //Trouver la Cotisation Mensuelle de L'Affilier
        $Affilier = Affilier::findOrFail($Aff->id);

        //Trouver Le montant deja Cotisé Pour Ce Mois 
        $Montant = Cotisation::whereEtatAndAffilierAndMoisAndAnnee(0,$Aff->id,$request->Mois,$request->Annee)->sum('Montant');
        $Montant +=$request->Montant;

        if ($Affilier->CotisationM>=$Montant) 
        {
           if ($request->Mois == 1) {
             Cotisation::create([
            'Affilier' =>$Aff->id,
            'Mois' =>$request->Mois,
            'Montant' =>$request->Montant,
            'Janvier' => $request->Montant,
            'DateCreation' =>$request->Annee.'-'.$request->Mois.'-01',
            'Annee' =>$request->Annee,
            'Datepayement'=>$request->Datepayement
              ]);
           }
           elseif ($request->Mois == 2) {
            Cotisation::create([
            'Affilier' =>$Aff->id,
            'Mois' =>$request->Mois,
            'Montant' =>$request->Montant,
            'Fevrier' => $request->Montant,
            'DateCreation' =>$request->Annee.'-'.$request->Mois.'-01',
            'Annee' =>$request->Annee,
            'Datepayement'=>$request->Datepayement
              ]);
            }
            elseif ($request->Mois == 3) {
            Cotisation::create([
            'Affilier' =>$Aff->id,
            'Mois' =>$request->Mois,
            'Montant' =>$request->Montant,
            'Mars' => $request->Montant,
            'DateCreation' =>$request->Annee.'-'.$request->Mois.'-01',
            'Annee' =>$request->Annee,
            'Datepayement'=>$request->Datepayement
              ]);
            }
             elseif ($request->Mois == 4) {
            Cotisation::create([
            'Affilier' =>$Aff->id,
            'Mois' =>$request->Mois,
            'Montant' =>$request->Montant,
            'Avril' => $request->Montant,
            'DateCreation' =>$request->Annee.'-'.$request->Mois.'-01',
            'Annee' =>$request->Annee,
            'Datepayement'=>$request->Datepayement
              ]);
            }
            elseif ($request->Mois == 5) {
            Cotisation::create([
            'Affilier' =>$Aff->id,
            'Mois' =>$request->Mois,
            'Montant' =>$request->Montant,
            'Mai' => $request->Montant,
            'DateCreation' =>$request->Annee.'-'.$request->Mois.'-01',
            'Annee' =>$request->Annee,
            'Datepayement'=>$request->Datepayement
              ]);
            }
            elseif ($request->Mois == 6) {
            Cotisation::create([
            'Affilier' =>$Aff->id,
            'Mois' =>$request->Mois,
            'Montant' =>$request->Montant,
            'Juin' => $request->Montant,
            'DateCreation' =>$request->Annee.'-'.$request->Mois.'-01',
            'Annee' =>$request->Annee,
            'Datepayement'=>$request->Datepayement
              ]);
            }
            elseif ($request->Mois == 7) {
            Cotisation::create([
            'Affilier' =>$Aff->id,
            'Mois' =>$request->Mois,
            'Montant' =>$request->Montant,
            'Juillet' => $request->Montant,
            'DateCreation' =>$request->Annee.'-'.$request->Mois.'-01',
            'Annee' =>$request->Annee,
            'Datepayement'=>$request->Datepayement
              ]);
            }
            elseif ($request->Mois == 8) {
            Cotisation::create([
            'Affilier' =>$Aff->id,
            'Mois' =>$request->Mois,
            'Montant' =>$request->Montant,
            'Aout' => $request->Montant,
            'DateCreation' =>$request->Annee.'-'.$request->Mois.'-01',
            'Annee' =>$request->Annee,
            'Datepayement'=>$request->Datepayement
              ]);
            }
            elseif ($request->Mois == 9) {
            Cotisation::create([
            'Affilier' =>$Aff->id,
            'Mois' =>$request->Mois,
            'Montant' =>$request->Montant,
            'Semptembre' => $request->Montant,
            'DateCreation' =>$request->Annee.'-'.$request->Mois.'-01',
            'Annee' =>$request->Annee,
            'Datepayement'=>$request->Datepayement
              ]);
            }
            elseif ($request->Mois == 10) {
            Cotisation::create([
            'Affilier' =>$Aff->id,
            'Mois' =>$request->Mois,
            'Montant' =>$request->Montant,
            'Octobre' => $request->Montant,
            'DateCreation' =>$request->Annee.'-'.$request->Mois.'-01',
            'Annee' =>$request->Annee,
            'Datepayement'=>$request->Datepayement
              ]);
            }
            elseif ($request->Mois == 11) {
            Cotisation::create([
            'Affilier' =>$Aff->id,
            'Mois' =>$request->Mois,
            'Montant' =>$request->Montant,
            'Novembre' => $request->Montant,
            'DateCreation' =>$request->Annee.'-'.$request->Mois.'-01',
            'Annee' =>$request->Annee,
            'Datepayement'=>$request->Datepayement
              ]);
            }
            elseif ($request->Mois == 12) {
            Cotisation::create([
            'Affilier' =>$Aff->id,
            'Mois' =>$request->Mois,
            'Montant' =>$request->Montant,
            'Decembre' => $request->Montant,
            'DateCreation' =>$request->Annee.'-'.$request->Mois.'-01',
            'Annee' =>$request->Annee,
            'Datepayement'=>$request->Datepayement
              ]);
            }
         }
        else
        {
         session()->flash('messageDelete', 'Vous avez depassé la cotisation mensuelle');
        }


            }
        }

       return back();
    } 
}
