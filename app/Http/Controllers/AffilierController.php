<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AffilierFormRequest;
use App\Http\Requests;
use App\Models\Affilier;
use App\Models\Partenaire;
use App\Models\AyantDroit;
use App\Models\Origine;
use App\Models\Service;
use App\Models\AffilierPartenaire;
use App\Models\Consomation;
use App\Models\mouvement_affiliers;
use App\Models\Facture;
use Illuminate\Support\Facades\DB;
use App\Interfaces\IAffilie as IAffilie;
use App\Interfaces\IOrigine as IOrigine;
use App\Interfaces\IAyantDroit as IAyantDroit;
use App\Interfaces\IService as IService;
use App\Interfaces\IPartenaire as IPartenaire;
use PDF;
use Carbon\Carbon;
class AffilierController extends Controller
{

     public function __construct(IAffilie $Affilier, IOrigine $Origine, IAyantDroit $AyantDroit, IService $Service, IPartenaire $Partenaire){
        $this->Affilier = $Affilier;
        $this->Origine = $Origine;
        $this->AyantDroit = $AyantDroit;
        $this->Service = $Service;
        $this->Partenaire = $Partenaire;
        $this->middleware('guest');
      }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
       set_time_limit(600); // Extends to 5 minutes. 
       //$Affiliers = $this->Affilier->fetchtAll();
       $Affiliers = [];
       $Origines = $this->Origine->fetchtAll();
       return view('Affiliers.index', compact('Affiliers', 'Origines'));
    } 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $Origines = $this->Origine->fetchtAll();
        $Affilier = new Affilier;
        $Ori = new Origine;
        return view ('Affiliers.create', compact('Origines', 'Affilier', 'Ori'));
    }
    
    public function research(Request $request){

       if(session()->get('Profil') == 'Partenaire')
       {  
            $Affiliers = DB::table('affilier_partenaires')
                 ->join('affiliers', 'affilier_partenaires.Affilier', '=', 'affiliers.id')
                 ->join('origines', 'origines.id', '=', 'affiliers.Origine')
                ->select(DB::raw('affiliers.id,affiliers.Code, affiliers.Nom,affiliers.Prenom,affiliers.Origine,affilier_partenaires.Partenaire, origines.Origine,affiliers.status'))
                ->wherePartenaire(session()->get('id'))
                 ->where('affiliers.Etat',0)
                ->where('affiliers.Code','like','%'.$request->Code.'%')
                ->where('affilier_partenaires.Etat',0)
                ->groupBy('affiliers.id')
                ->get();         
        }else{
    
           $Affiliers = DB::table('affiliers')
                ->Leftjoin('affilier_partenaires','affilier_partenaires.Affilier' , '=', 'affiliers.id')
                ->join('origines', 'origines.id', '=', 'affiliers.Origine')
                ->select(DB::raw('affiliers.id,affiliers.Code, affiliers.Nom,affiliers.Prenom,affiliers.Origine,affilier_partenaires.Partenaire, origines.Origine,affiliers.status'))
                 ->where('affiliers.Code','like','%'.$request->Code.'%')
                ->where('affiliers.Etat',0)
                ->groupBy('affiliers.id')
                ->get();        
        } 
       //$Affiliers = $this->Affilier->fetchtAll($request->Code);
       $Origines = $this->Origine->fetchtAll();
       return view('Affiliers.index', compact('Affiliers', 'Origines')); 
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AffilierFormRequest $request)
    {    
        $this->Affilier->saveData($request, null);
        return redirect(route('Affiliers.index')); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

       $Affilier = $this->Affilier->showData($id);
       $AyantDroits = $this->AyantDroit->selectayantdroitbyaffilier($id);
       

    $Partenaires = DB::table('affilier_partenaires')
                    ->join('partenaires', 'affilier_partenaires.Partenaire', '=', 'partenaires.id')
                     ->join('services', 'affilier_partenaires.Service', '=', 'services.id')
                     ->select(DB::raw('partenaires.id,partenaires.Type, partenaires.Partenaire,partenaires.created_at,affilier_partenaires.Affilier,affilier_partenaires.Etat,affilier_partenaires.SA,affilier_partenaires.Hospitalisation,affilier_partenaires.Service as SAP, services.Service'))
                     ->whereAffilier($id)
                     ->where('affilier_partenaires.Etat',0)
                     ->get();

     $ServiceAff = $this->Service->fetchtAll(); 

    $PartNonAccess = $this->Partenaire->fetchtAll();            
    $Origine = $this->Origine->showData($Affilier->Origine);

    return view('Affiliers.show', compact('Affilier', 'AyantDroits', 'Partenaires', 'Origine', 'id', 'PartNonAccess', 'ServiceAff')); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $Affilier = $this->Affilier->showData($id);
        $Ori = $this->Origine->showData($Affilier->Origine);
        $Origines = $this->Origine->fetchtAll();
        //dump($Affilier);
        return view('Affiliers.edit', compact('Affilier', 'Ori', 'Origines'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AffilierFormRequest $request, $id)
    {

       $this->Affilier->saveData($request, $id);

        return redirect( route('Affiliers.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $this->Affilier->deleteData($id);
       return redirect(route('Affiliers.index')); 
     }

     // Fonction pour la suppression definitive de l'enregistrement.

     public function SupprimerDef($id)
     {
       $Affilier = $this->Affilier->showData($id);
    
        $Affilier->update([
            'Etat' => 2
        ]);
        session()->flash('messageDelete', 'Cet Affilier a été supprimé');
        return redirect(route('CorbAffil'));
     }

     public function CorbAffil()
     {
        $Affiliers = Affilier::whereEtat(1)->get();   
        return view('Affiliers.Corbeille', compact('Affiliers'));
     }

     public function RestaureAff($id)
     {
        $Affilier = $this->Affilier->showData($id);
        $Affilier->update([
            'Etat' =>0
        ]);

        return redirect(route('CorbAffil'));
     }



     public function AffilierPartenaire(Request $request)
     {  
        set_time_limit(0);
        $Affilier =$request->Affilier;
        //Cas du Bouton Ajouter

        if (isset($request->Ajouter)) {
            $Nbre = AffilierPartenaire::whereAffilierAndPartenaireAndService($request->Affilier, $request->Partenaire, $request->Service)->count();

            //1. Cas D'attribution par groupe et Tout les services
             if (isset($request->Groupe) && !empty($request->Groupe) && $request->Groupe !='Moimeme' && isset($request->Service) && !empty($request->Service) && $request->Service =='Tout') 
             {
                $Affiliers = Affilier::whereEtatAndOrigine(0,$request->Groupe)->get();
                foreach ($Affiliers as $Affilier) 
                {
                    $Services = Service::whereEtat(0)->get(); 
                    foreach ($Services as $Service) 
                    {
                    $Nbre = AffilierPartenaire::whereAffilierAndPartenaireAndService($Affilier->id, $request->Partenaire, $Service->id)->count();

                    if ($Nbre==0) { 
                    AffilierPartenaire::create([
                    'Affilier' => $Affilier->id,
                    'Partenaire' => $request->Partenaire,
                    'Service' => $Service->id
                    ]);
                    }else{
                    $Detail = AffilierPartenaire::whereAffilierAndPartenaireAndService($Affilier->id, $request->Partenaire,$Service->id)->first();
                    if ($Detail->Etat==1) 
                    {
                      $Detail->update([
                       'Etat' =>0
                      ]);  
                    }
                  } 
                }
              }
            }//2.Cas D'attribution par groupe et un service
             elseif (isset($request->Groupe) && !empty($request->Groupe) && $request->Groupe !='Moimeme' && isset($request->Service) && !empty($request->Service) && $request->Service !='Tout') 
             {
                $Affiliers = Affilier::whereEtatAndOrigine(0,$request->Groupe)->get();
                foreach ($Affiliers as $Affilier) 
                {
                $Nbre = AffilierPartenaire::whereAffilierAndPartenaireAndService($Affilier->id, $request->Partenaire, $request->Service)->count();

                    if ($Nbre==0) { 
                    AffilierPartenaire::create([
                    'Affilier' => $Affilier->id,
                    'Partenaire' => $request->Partenaire,
                    'Service' => $request->Service
                    ]);
                    }else{
                    $Detail = AffilierPartenaire::whereAffilierAndPartenaireAndService($Affilier->id, $request->Partenaire,$request->Service)->first();
                    if ($Detail->Etat==1) 
                    {
                      $Detail->update([
                       'Etat' =>0
                      ]);  
                    }
                  } 
                }
              }//3.Cas D'attribution par personne et +++ Services
             elseif (isset($request->Groupe) && !empty($request->Groupe) && $request->Groupe =='Moimeme' && isset($request->Service) && !empty($request->Service) && $request->Service =='Tout') 
             {
                $Services = Service::whereEtat(0)->get();
                foreach ($Services as $Service) 
                {
                $Nbre = AffilierPartenaire::whereAffilierAndPartenaireAndService($request->Affilier, $request->Partenaire, $Service->id)->count();

                    if ($Nbre==0) { 
                    AffilierPartenaire::create([
                    'Affilier' => $request->Affilier,
                    'Partenaire' => $request->Partenaire,
                    'Service' => $Service->id
                    ]);
                    }else{
                    $Detail = AffilierPartenaire::whereAffilierAndPartenaireAndService($request->Affilier, $request->Partenaire,$Service->id)->first();
                    if ($Detail->Etat==1) 
                    {
                      $Detail->update([
                       'Etat' =>0
                      ]);  
                    }
                  } 
                }
              }
              //4.Cas D'attribution par personne et Service
              else
              {  
            $Nbre = AffilierPartenaire::whereAffilierAndPartenaireAndService($request->Affilier, $request->Partenaire, $request->Service)->count();

                    if ($Nbre==0) { 
                    AffilierPartenaire::create([
                    'Affilier' => $request->Affilier,
                    'Partenaire' => $request->Partenaire,
                    'Service' => $request->Service
                    ]);
                    }else{
                    $Detail = AffilierPartenaire::whereAffilierAndPartenaireAndService($request->Affilier, $request->Partenaire,$request->Service)->first();
                    if ($Detail->Etat==1) 
                    {
                      $Detail->update([
                       'Etat' =>0
                      ]);  
                    }
                  } 
             }
       
        }   
       return redirect(route('Affiliers.show', compact('Affilier')));    
     }

    public function AffilierPatenerD(Request $request)
    {    
        set_time_limit(0);
        $Affilier = $request->Affilier;
        //Cas De Suppression Par GROUPE 
        if (isset($request->Groupe) && !empty($request->Groupe) && $request->Groupe !='Moimeme') 
        {   
            //On recupere tous les affilies appartenant a ce groupe
            $Affiliers = Affilier::whereEtatAndOrigine(0,$request->Groupe)->get();

            //Cas de Suppression de tous les service
            if (isset($request->Service) && !empty($request->Service) && $request->Service =='All') {
                
                //On parcour le tableau des affilies
                foreach ($Affiliers as $Affilier) 
                { 

                    //On recupere tous les services fournis par les partenaire chez cet affilié
                    $Services = AffilierPartenaire::whereAffilierAndPartenaire($Affilier->id,$request->Partenaire)->get(); 

                    //On parcour les tableau de service du partenaire pour verifié si reellement ce service existe chez l'affilié
                    foreach ($Services as $Service) {
                        $Nbre = AffilierPartenaire::whereAffilierAndPartenaireAndService($Affilier->id, $request->Partenaire, $Service->Service)->count();

                        if ($Nbre>0) 
                        {
                            $Detail = AffilierPartenaire::whereAffilierAndPartenaireAndService($Affilier->id, $request->Partenaire,$Service->Service)->first();
        
                            $Detail->update([
                            'Etat' =>1
                            ]);   
                        } 
                    }  
                }     
            }
            else
            {
               
                //On parcour le tableau des affilies
                foreach ($Affiliers as $Affilier) 
                { 
                    $Nbre = AffilierPartenaire::whereAffilierAndPartenaireAndService($Affilier->id, $request->Partenaire, $request->Service)->count();

                    if ($Nbre>0) 
                    {
                        $Detail = AffilierPartenaire::whereAffilierAndPartenaireAndService($Affilier->id, $request->Partenaire,$request->Service)->first();
        
                        $Detail->update([
                            'Etat' =>1
                        ]);   
                    }   
                } 
            }
            
        }
        else
        {
            $Nbre = AffilierPartenaire::whereAffilierAndPartenaireAndService($request->Affilier, $request->Partenaire, $request->Service)->count();
            
            //Cas de Suppression de tous les service
            if (isset($request->Service) && !empty($request->Service) && $request->Service =='All') {
                //On recupere tous les services fournis par les partenaire chez cet affilié
                $Services = AffilierPartenaire::whereAffilierAndPartenaire($request->Affilier,$request->Partenaire)->get(); 

                //On parcour les tableau de service du partenaire pour verifié si reellement ce service existe chez l'affilié
                foreach ($Services as $Service) {
                    $Nbre = AffilierPartenaire::whereAffilierAndPartenaireAndService($request->Affilier, $request->Partenaire, $Service->Service)->count();

                    if ($Nbre>0) 
                    {
                        $Detail = AffilierPartenaire::whereAffilierAndPartenaireAndService($request->Affilier, $request->Partenaire,$Service->Service)->first();
        
                        $Detail->update([
                            'Etat' =>1
                        ]);   
                    } 
                } 
            }
            else
            {
               
                $Nbre = AffilierPartenaire::whereAffilierAndPartenaireAndService($request->Affilier, $request->Partenaire, $request->Service)->count();
                    if ($Nbre>0) 
                    {
                        $Detail = AffilierPartenaire::whereAffilierAndPartenaireAndService($request->Affilier, $request->Partenaire,$request->Service)->first();
        
                        $Detail->update([
                            'Etat' =>1
                        ]);   
                    }   
            } 
        }
 
        return redirect(route('Affiliers.show', compact('Affilier')));    
    }

     public function PdfListeAffilie($Origine)
     {  
        set_time_limit(1200);
        $NbreCons = Consomation::whereId(1)->count('id');
        if ($NbreCons>0) {
            $Consomation = Consomation::findOrFail(1);
        }else{
            $Consomation = New Consomation;
        }
           $NbreAD =0;  
            $table="";
            $AyaDrA="";
       
             $NbreAff = Affilier::whereEtatAndOrigine(0,$Origine)->count();
          
             if ($NbreAff > 0) {

             $Affiliers = Affilier::whereEtatAndOrigine(0,$Origine)->get();
             $SommeOrigine = Affilier::whereEtatAndOrigine(0,$Origine)->sum('CotisationM');
             foreach($Affiliers as $Aff){
            $id_Origine=$Aff->Origine;
            $AyantDroits = AyantDroit::whereEtatAndAffilier(0,$Aff->id)->get();

            $NAyantDroits = AyantDroit::whereEtatAndAffilier(0,$Aff->id)->where('Lien', '!=', 'Lui meme')->count();
            $NbreAD += $NAyantDroits;

            foreach ($AyantDroits as $AyantDroit) 
            {  
               if ($AyantDroit->Lien != 'Lui meme') 
               {
                  $AyaDrA.="
                 <ul><li>".$AyantDroit->Nom.' '.$AyantDroit->Prenom."</li></ul>";
               }   
            }
              $Origine=Origine::where('id',$id_Origine)->first();
        
            $TAyaDrA=$AyaDrA;
            $AyaDrA="";
            $table.="
                    <tr class='odd gradeX'>
                        <td>".$Aff->Code."</td>
                        <td>".$Aff->Nom.' '.$Aff->Prenom."</td>
                        <td>".$TAyaDrA."</td>
                        <td>".$Aff->Adresse."</td>
                        <td>".$Aff->DateNaiss."</td>
                        <td>".$Origine->Origine."</td>
                        <td>".$Aff->DateEntree."</td>
                        <td>".$Aff->CotisationM."</td>
                        <td>".$Aff->SoinsAmbilatoire.'%'."</td>
                        <td>".$Aff->PlafondChambre.'%  avec '.$Aff->PCNuit.' FBU /Nuitée'."</td>
                        <td>".$Aff->UniteMaternite.' FBU'."</td>
                        <td>".$Aff->Pharmacie.' FBU'."</td>
        </tr>";   
     }
        }else{
            $SommeOrigine = 0;
            $Origine = new Origine;
        }
        $tableListe=$table;
         $pdf = PDF::loadView('Affiliers.PdfListeAffilie', compact('tableListe', 'Origine', 'Consomation', 'SommeOrigine', 'NbreAD', 'NbreAff'))->setPaper('a2', 'Paysage');
         $fileName = 'Affiliers';
         return $pdf->stream($fileName . '.pdf');   
}

  
  // Creer Une Nouvelle Facture
  public function addBillForm($Aff)
  { 
    $Services = DB::table('affilier_partenaires')
                    ->join('services' , 'services.id', '=', 'affilier_partenaires.Service')
                    ->select(DB::raw('DISTINCT(services.id),services.service, services.Traitement'))
                    ->wherePartenaire(session()->get('id'))
                    ->whereAffilier($Aff)
                    ->where('affilier_partenaires.Etat',0)
                    ->where('services.Etat',0)
                    ->get();                                  


        $AllPrestations="<input type='hidden' id='adherantId' value='".$Aff."'/>";
        foreach ($Services as $Service) {
            $AllPrestations.=
            "<li>
              <button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopupPrestation(this); return false;' value='".$Service->id."'>".$Service->service."</button>
            </li>";
        }
        echo $AllPrestations;
  }

  public function availablePartener($Aff){
     $AffilierPartenaire = DB::table('affilier_partenaires')
                     ->join('partenaires', 'partenaires.id', '=', 'affilier_partenaires.Partenaire')
                     ->select(DB::raw('partenaires.Partenaire, partenaires.id'))
                    ->where('affilier_partenaires.Affilier', $Aff)
                    ->where('affilier_partenaires.Etat',0)
                    ->groupBy('partenaires.id')
                    ->get();  

     $Partenaires="<input type='hidden' id='affilieID' value='".$Aff."'/>";
        foreach ($AffilierPartenaire as $AffilierParten) {
            $Partenaires.=
            "<li>
              <button style='border: none;cursor: pointer;' data-toggle='modal' data-target='#modal-default1' onclick='openPrestationModal1(this); return false;' value='".$AffilierParten->id."'>".$AffilierParten->Partenaire."</button>
            </li>";
        }
        echo $Partenaires;                
  }

  public function availablePrestation(Request $request){
    $Paterner = $request->get('partener');
    $Aff = $request->get('adherant');
    $request->session()->put('Aff',$Aff);
    $request->session()->put('Paterner',$Paterner);
    $Services = DB::table('affilier_partenaires')
                    ->join('services' , 'services.id', '=', 'affilier_partenaires.Service')
                    ->select(DB::raw('DISTINCT(services.id),services.service, services.Traitement'))
                    ->wherePartenaire($Paterner)
                    ->whereAffilier($Aff)
                    ->where('affilier_partenaires.Etat',0)
                    ->where('services.Etat',0)
                    ->get();                                  


        $AllPrestations="<input type='hidden' id='adherantId' value='".$Aff."'/>";
        foreach ($Services as $Service) {
            $AllPrestations.=
            "<li>
              <button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopupPrestation(this); return false;' value='".$Service->id."'>".$Service->service."</button>
            </li>";
        }
        echo $AllPrestations;

  }
  public function Deletemulite(){
    
  }

  public function FicheAdhesion($Affilier){
     $DateDelivrey = Carbon::now('America/Vancouver'); 
      $Affil = DB::table('affiliers')
            ->select(DB::raw('affiliers.Code,affiliers.Nom,affiliers.Prenom,affiliers.DateNaiss,affiliers.Adresse,affiliers.DateEntree,affiliers.id,affiliers.profession,affiliers.droit_adhesion,affiliers.periode_observation'))
            ->where('affiliers.id', $Affilier)
            ->first();

       $beneficiaires = DB::table('ayant_droits')
            ->select(DB::raw('ayant_droits.Nom,ayant_droits.Prenom,ayant_droits.Lien'))
            ->where('ayant_droits.Etat',0)
            ->where('ayant_droits.Affilier', $Affilier)
            ->get();      
      //return view('Affiliers.FicheAdhesion', compact('Affil', 'beneficiaires', 'DateDelivrey'));

     $pdf = PDF::loadView('Affiliers.FicheAdhesion', compact('Affil', 'beneficiaires', 'DateDelivrey'))->setPaper('a4', 'Paysage');
     $fileName = 'Fiche Adhesion';
         return $pdf->stream($fileName . '.pdf');
  }

  public function CarteAdhesion($Affilier){
         $Services = Service::select("service")->whereEtat(0)->get();
         $Adherant = DB::table('affiliers')
            ->select(DB::raw('affiliers.Code,affiliers.Nom,affiliers.Prenom,affiliers.DateNaiss'))
            ->where('affiliers.id', $Affilier)
            ->first();
        $beneficiaires = DB::table('ayant_droits')
            ->select(DB::raw('ayant_droits.Nom,ayant_droits.Prenom'))
            ->where('ayant_droits.Etat',0)
            ->where('ayant_droits.Affilier', $Affilier)
            ->get(); 
    //return view('Affiliers.FicheAdhesion', compact('Adherant', 'beneficiaires', 'Services'));
     $pdf = PDF::loadView('Affiliers.CarteAdhesion', compact('Adherant', 'beneficiaires', 'Services'))->setPaper('a6', 'Paysage');
     $fileName = 'Carte Adhesion';
         return $pdf->stream($fileName . '.pdf');          
  }

  public function registre_adhesion($periodbeg, $periodend){

      $mouvements = DB::table('mouvent_beneficiaires')
            ->select(DB::raw('DATE_FORMAT(date_mvt, "%e %M ") AS DateE, date_mvt'))
            ->whereBetween('date_mvt',[$periodbeg, $periodend])
            ->groupBy("date_mvt")
            ->get();
           $table="";
           $table1="";
           $TotalEntreAdherant=0;
           $TotalSortieAdherant=0;
           $TotalAdherant = 0;
           $TotalEntreAyantdroit=0;
           $TotalSortieAyantdroit=0;
           $TotalAyantdroit = 0;
           $TotalEntrieG = 0;
           $TotalOutG = 0;
           $TotalG = 0;
           foreach ($mouvements as $mouvement) 
            {  
               $outAdherant = DB::table('mouvent_beneficiaires')
                    ->select(DB::raw(''))
                    ->where('date_mvt',$mouvement->date_mvt)
                    ->where('type_mvt',2)
                    ->where('type_beneficiaire',1)
                    ->count('id');

               $entrieAdherant = DB::table('mouvent_beneficiaires')
                    ->select(DB::raw(''))
                    ->where('date_mvt',$mouvement->date_mvt)
                    ->where('type_mvt',1)
                     ->where('type_beneficiaire',1)
                    ->count('id');

               $outAyantdroit = DB::table('mouvent_beneficiaires')
                    ->select(DB::raw(''))
                    ->where('date_mvt',$mouvement->date_mvt)
                    ->where('type_mvt',2)
                    ->where('type_beneficiaire',2)
                    ->count('id');

               $entrieAyantdroit = DB::table('mouvent_beneficiaires')
                    ->select(DB::raw(''))
                    ->where('date_mvt',$mouvement->date_mvt)
                    ->where('type_mvt',1)
                     ->where('type_beneficiaire',2)
                    ->count('id');
                $TotalEntreAdherant+=$entrieAdherant;
                $TotalSortieAdherant+=$outAdherant;
                $diffAdherant = $entrieAdherant-$outAdherant;
                $TotalAdherant+=$diffAdherant;

                $TotalEntreAyantdroit+=$entrieAyantdroit;
                $TotalSortieAyantdroit+=$outAyantdroit;
                $diffAyantdroit = $entrieAyantdroit-$outAyantdroit;
                $TotalAyantdroit+=$diffAyantdroit;

                $TotalEntrie = $entrieAdherant+$entrieAyantdroit;
                $TotalOut = $outAdherant+$outAyantdroit;
                $Total = $TotalEntrie-$TotalOut;

                $TotalEntrieG += $TotalEntrie;
                $TotalOutG += $TotalOut;
                $TotalG += $Total;

                $table.="
                    <tr class='odd gradeX'>
                        <td>".$mouvement->DateE."</td>

                        <td>
                           <button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this); return false;' value=".$mouvement->date_mvt.'*1*1'.">".$entrieAdherant."</button>
                        </td>
                        <td>
                           <button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this); return false;' value=".$mouvement->date_mvt.'*2*1'.">".$outAdherant."</button>
                        </td>
                        <td>".$diffAdherant."</td>

                        <td>
                          <button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this); return false;' value=".$mouvement->date_mvt.'*1*2'.">".$entrieAyantdroit."</button>
                        </td>
                        <td>
                          <button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this); return false;' value=".$mouvement->date_mvt.'*2*2'.">".$outAyantdroit."</button>
                        </td>
                        <td>".$diffAyantdroit."</td>

                        <td>".$TotalEntrie."</td>
                        <td>".$TotalOut."</td>
                        <td>".$Total."</td>
                    </tr>";   
            }
      $table1.="
         <tr>
           <th>Total de la Periode</th>
           <th>".$TotalEntreAdherant."</th>
           <th>".$TotalSortieAdherant."</th>
           <th>".$TotalAdherant."</th>
           <th>".$TotalEntreAyantdroit."</th>
           <th>".$TotalSortieAyantdroit."</th>
           <th>".$TotalAyantdroit."</th>
           <th>".$TotalEntrieG."</th>
           <th>".$TotalOutG."</th>
           <th>".$TotalG."</th>
         </tr>";       
     $tableListe=$table;
     return view('Affiliers.registre_adhesion', compact('tableListe', 'table1'));
      }
     


    public function registre_adhesion_generate(Request $request){
        $mouvements = DB::table('mouvent_beneficiaires')
            ->select(DB::raw('DATE_FORMAT(date_mvt, "%e %M ") AS DateE, date_mvt'))
            ->whereBetween('date_mvt',[$request->debut, $request->fin])
            ->groupBy("date_mvt")
            ->get();
           $table="";
           $table1="";
           $TotalEntreAdherant=0;
           $TotalSortieAdherant=0;
           $TotalAdherant = 0;
           $TotalEntreAyantdroit=0;
           $TotalSortieAyantdroit=0;
           $TotalAyantdroit = 0;
           $TotalEntrieG = 0;
           $TotalOutG = 0;
           $TotalG = 0;
           foreach ($mouvements as $mouvement) 
            {  
               $outAdherant = DB::table('mouvent_beneficiaires')
                    ->select(DB::raw(''))
                    ->where('date_mvt',$mouvement->date_mvt)
                    ->where('type_mvt',2)
                    ->where('type_beneficiaire',1)
                    ->count('id');

               $entrieAdherant = DB::table('mouvent_beneficiaires')
                    ->select(DB::raw(''))
                    ->where('date_mvt',$mouvement->date_mvt)
                    ->where('type_mvt',1)
                     ->where('type_beneficiaire',1)
                    ->count('id');

               $outAyantdroit = DB::table('mouvent_beneficiaires')
                    ->select(DB::raw(''))
                    ->where('date_mvt',$mouvement->date_mvt)
                    ->where('type_mvt',2)
                    ->where('type_beneficiaire',2)
                    ->count('id');

               $entrieAyantdroit = DB::table('mouvent_beneficiaires')
                    ->select(DB::raw(''))
                    ->where('date_mvt',$mouvement->date_mvt)
                    ->where('type_mvt',1)
                     ->where('type_beneficiaire',2)
                    ->count('id');
                $TotalEntreAdherant+=$entrieAdherant;
                $TotalSortieAdherant+=$outAdherant;
                $diffAdherant = $entrieAdherant-$outAdherant;
                $TotalAdherant+=$diffAdherant;

                $TotalEntreAyantdroit+=$entrieAyantdroit;
                $TotalSortieAyantdroit+=$outAyantdroit;
                $diffAyantdroit = $entrieAyantdroit-$outAyantdroit;
                $TotalAyantdroit+=$diffAyantdroit;

                $TotalEntrie = $entrieAdherant+$entrieAyantdroit;
                $TotalOut = $outAdherant+$outAyantdroit;
                $Total = $TotalEntrie-$TotalOut;

                $TotalEntrieG += $TotalEntrie;
                $TotalOutG += $TotalOut;
                $TotalG += $Total;

                $table.="
                    <tr class='odd gradeX'>
                        <td>".$mouvement->DateE."</td>

                        <td>
                           <button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this); return false;' value=".$mouvement->date_mvt.'*1*1'.">".$entrieAdherant."</button>
                        </td>
                        <td>
                           <button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this); return false;' value=".$mouvement->date_mvt.'*2*1'.">".$outAdherant."</button>
                        </td>
                        <td>".$diffAdherant."</td>

                        <td>
                          <button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this); return false;' value=".$mouvement->date_mvt.'*1*2'.">".$entrieAyantdroit."</button>
                        </td>
                        <td>
                          <button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this); return false;' value=".$mouvement->date_mvt.'*2*2'.">".$outAyantdroit."</button>
                        </td>
                        <td>".$diffAyantdroit."</td>

                        <td>".$TotalEntrie."</td>
                        <td>".$TotalOut."</td>
                        <td>".$Total."</td>
                    </tr>";   
            }
      $table1.="
         <tr>
           <th>Total de la Periode</th>
           <th>".$TotalEntreAdherant."</th>
           <th>".$TotalSortieAdherant."</th>
           <th>".$TotalAdherant."</th>
           <th>".$TotalEntreAyantdroit."</th>
           <th>".$TotalSortieAyantdroit."</th>
           <th>".$TotalAyantdroit."</th>
           <th>".$TotalEntrieG."</th>
           <th>".$TotalOutG."</th>
           <th>".$TotalG."</th>
         </tr>";       
     $tableListe=$table;
     return view('Affiliers.registre_adhesion', compact('tableListe', 'table1'));
    }

    public function tableau_suivi ($currentyear){
        $LastYear = $currentyear-1;
        $annees = DB::table('mouvent_beneficiaires')
            ->select(DB::raw('DISTINCT(annee)'))
            ->get();
        //POUR LES ADHERANT
        $EntreesAdh = DB::table('mouvent_beneficiaires')
            ->select(DB::raw('sum(Janvier) as J,sum(Fevrier) as F, sum(Mars) as M, sum(Avril) as A, sum(Mai) as Ma, sum(Juin) as Ju, sum(Juillet) as Jui, sum(Aout) as Ao, sum(Septembre) as S, sum(Octobre) as O, sum(Novembre) as N, sum(Decembre) as D, sum(Janvier+Fevrier+Mars+Avril+Mai+Juin+Juillet+Aout+Septembre+Octobre+Novembre+Decembre) as ST'))
            ->where('annee',$currentyear)
            ->whereTypeBeneficiaire(1)
            ->whereTypeMvt(1)
            ->get();

        $SortiesAdh = DB::table('mouvent_beneficiaires')
            ->select(DB::raw('sum(Janvier) as J,sum(Fevrier) as F, sum(Mars) as M, sum(Avril) as A, sum(Mai) as Ma, sum(Juin) as Ju, sum(Juillet) as Jui, sum(Aout) as Ao, sum(Septembre) as S, sum(Octobre) as O, sum(Novembre) as N, sum(Decembre) as D, sum(Janvier+Fevrier+Mars+Avril+Mai+Juin+Juillet+Aout+Septembre+Octobre+Novembre+Decembre) as ST'))
            ->where('annee',$currentyear)
            ->whereTypeBeneficiaire(1)
            ->whereTypeMvt(2)
            ->get();

        $EntreesAdhLastYear = DB::table('mouvent_beneficiaires')
            ->select(DB::raw(''))
            ->where('annee',$currentyear-1)
            ->whereTypeBeneficiaire(1)
            ->whereTypeMvt(1)
            ->sum('id');

        $SortiesAdhLastYear = DB::table('mouvent_beneficiaires')
            ->select(DB::raw(''))
            ->where('annee',$currentyear-1)
            ->whereTypeBeneficiaire(1)
            ->whereTypeMvt(2)
           ->sum('id');            
        $TotalLastYear = $EntreesAdhLastYear-$SortiesAdhLastYear;
     // POUR LES AYANT DROIT
        
        $EntreesAyants = DB::table('mouvent_beneficiaires')
            ->select(DB::raw('sum(Janvier) as J,sum(Fevrier) as F, sum(Mars) as M, sum(Avril) as A, sum(Mai) as Ma, sum(Juin) as Ju, sum(Juillet) as Jui, sum(Aout) as Ao, sum(Septembre) as S, sum(Octobre) as O, sum(Novembre) as N, sum(Decembre) as D, sum(Janvier+Fevrier+Mars+Avril+Mai+Juin+Juillet+Aout+Septembre+Octobre+Novembre+Decembre) as ST'))
            ->where('annee',$currentyear)
            ->whereTypeBeneficiaire(2)
            ->whereTypeMvt(1)
            ->get();

        $SortiesAyants = DB::table('mouvent_beneficiaires')
            ->select(DB::raw('sum(Janvier) as J,sum(Fevrier) as F, sum(Mars) as M, sum(Avril) as A, sum(Mai) as Ma, sum(Juin) as Ju, sum(Juillet) as Jui, sum(Aout) as Ao, sum(Septembre) as S, sum(Octobre) as O, sum(Novembre) as N, sum(Decembre) as D, sum(Janvier+Fevrier+Mars+Avril+Mai+Juin+Juillet+Aout+Septembre+Octobre+Novembre+Decembre) as ST'))
            ->where('annee',$currentyear)
            ->whereTypeBeneficiaire(2)
            ->whereTypeMvt(2)
            ->get();

        $EntreesAyantsLastYear = DB::table('mouvent_beneficiaires')
            ->select(DB::raw(''))
            ->where('annee',$currentyear-1)
            ->whereTypeBeneficiaire(1)
            ->whereTypeMvt(1)
            ->sum('id');

        $SortiesAyantsLastYear = DB::table('mouvent_beneficiaires')
            ->select(DB::raw(''))
            ->where('annee',$currentyear-1)
            ->whereTypeBeneficiaire(1)
            ->whereTypeMvt(2)
           ->sum('id');            
        $TotalAyantLastYear = $EntreesAyantsLastYear-$SortiesAyantsLastYear;    

        $totalAdh="";
        $totalAyants="";
        $tailleMoyenneFam="";
    
     foreach ($EntreesAdh as $EntreeAdh) { 
        foreach ($SortiesAdh as $SortieAdh) {
            $totalAdh.="
                <tr class='odd gradeX'>
                    <th>Total adhérents</th>
                    <th>".$TotalLastYear."</th>";
                     $Janvier = $TotalLastYear+$EntreeAdh->J-$SortieAdh->J;
                  $totalAdh.="<th>".$Janvier."</th>";

                     $Fevrier = $Janvier+$EntreeAdh->F-$SortieAdh->F;
                  $totalAdh.="<th>".$Fevrier."</th>";
                     $Mars = $Fevrier+$EntreeAdh->M-$SortieAdh->M;
                  $totalAdh.="<th>".$Mars."</th>";
                     $Avril = $Mars+$EntreeAdh->A-$SortieAdh->A;
                  $totalAdh.="<th>".$Avril."</th>";
                     $Mai = $Avril+$EntreeAdh->M-$SortieAdh->M;
                  $totalAdh.="<th>".$Mai."</th>";
                     $Juin = $Mai+$EntreeAdh->Ju-$SortieAdh->Ju;
                  $totalAdh.="<th>".$Juin."</th>";
                     $Juillet = $Juin+$EntreeAdh->Jui-$SortieAdh->Jui;
                  $totalAdh.="<th>".$Juillet."</th>";
                     $Aout = $Juillet+$EntreeAdh->Ao-$SortieAdh->Ao;
                  $totalAdh.="<th>".$Aout."</th>";
                     $Septembre = $Aout+$EntreeAdh->S-$SortieAdh->S;
                  $totalAdh.="<th>".$Septembre."</th>";
                     $Octobre = $Septembre+$EntreeAdh->O-$SortieAdh->O;
                  $totalAdh.="<th>".$Octobre."</th>";
                     $Novembre = $Octobre+$EntreeAdh->N-$SortieAdh->N;
                  $totalAdh.="<th>".$Novembre."</th>";
                     $Decembre = $Novembre+$EntreeAdh->D-$SortieAdh->D;
                  $totalAdh.="<th>".$Decembre."</th>
                  <th></th>
                </tr>";   
             }
     } 


          foreach ($EntreesAyants as $EntreeAyants) { 
        foreach ($SortiesAyants as $SortieAyants) {
            $totalAyants.="
                <tr class='odd gradeX'>
                    <th>Total bénefic.</th>
                    <th>".$TotalAyantLastYear."</th>";
                     $JanvierA = $TotalAyantLastYear+$EntreeAyants->J-$SortieAyants->J;
                  $totalAyants.="<th>".$JanvierA."</th>";
                     $FevrierA = $JanvierA+$EntreeAyants->F-$SortieAyants->F;
                  $totalAyants.="<th>".$FevrierA."</th>";
                     $MarsA = $FevrierA+$EntreeAyants->M-$SortieAyants->M;
                  $totalAyants.="<th>".$MarsA."</th>";
                     $AvrilA = $MarsA+$EntreeAyants->A-$SortieAyants->A;
                  $totalAyants.="<th>".$AvrilA."</th>";
                     $MaiA = $AvrilA+$EntreeAyants->M-$SortieAyants->M;
                  $totalAyants.="<th>".$MaiA."</th>";
                     $JuinA = $MaiA+$EntreeAyants->Ju-$SortieAyants->Ju;
                  $totalAyants.="<th>".$JuinA."</th>";
                     $JuilletA = $JuinA+$EntreeAyants->Jui-$SortieAyants->Jui;
                  $totalAyants.="<th>".$JuilletA."</th>";
                     $AoutA = $JuilletA+$EntreeAyants->Ao-$SortieAyants->Ao;
                  $totalAyants.="<th>".$AoutA."</th>";
                     $SeptembreA = $AoutA+$EntreeAyants->S-$SortieAyants->S;
                  $totalAyants.="<th>".$SeptembreA."</th>";
                     $OctobreA = $SeptembreA+$EntreeAyants->O-$SortieAyants->O;
                  $totalAyants.="<th>".$OctobreA."</th>";
                     $NovembreA = $OctobreA+$EntreeAyants->N-$SortieAyants->N;
                  $totalAyants.="<th>".$NovembreA."</th>";
                     $DecembreA = $NovembreA+$EntreeAyants->D-$SortieAyants->D;
                  $totalAyants.="<th>".$DecembreA."</th>
                  <td></th>
                </tr>";   
             }
            }

             if ($TotalAyantLastYear!=0) {
                 $TailleLastYear = $TotalLastYear/$TotalAyantLastYear;
             }else{
                $TailleLastYear=0;
             }
             $tailleMoyenneFam.="
                <tr class='odd gradeX'>
                    <th>Taille Moyenne Famille</th>
                    <th>".$TailleLastYear."</th>";
                     $JanvierA = $TotalAyantLastYear+$EntreeAyants->J-$SortieAyants->J;
                     if ($JanvierA!=0) {
                         $TailleJanvier = $Janvier/$JanvierA;
                     }else{
                        $TailleJanvier=0;
                     }
                  $tailleMoyenneFam.="<th>".$TailleJanvier."</th>";

                     $FevrierA = $JanvierA+$EntreeAyants->F-$SortieAyants->F;
                      if ($FevrierA!=0) {
                         $TailleFevrier = $Fevrier/$FevrierA;
                     }else{
                        $TailleFevrier=0;
                     }
                  $tailleMoyenneFam.="<th>".$TailleFevrier."</th>";

                     $MarsA = $FevrierA+$EntreeAyants->M-$SortieAyants->M;
                     if ($MarsA!=0) {
                        $TailleMars = $Mars/$MarsA;
                     }else{
                        $TailleMars=0;
                     }
                  $tailleMoyenneFam.="<th>".$TailleMars."</th>";

                     $AvrilA = $MarsA+$EntreeAyants->A-$SortieAyants->A;
                     if ($AvrilA!=0) {
                        $TailleAvril = $Avril/$AvrilA;
                     }else{
                        $TailleAvril=0;
                     }
                  $tailleMoyenneFam.="<th>".$TailleAvril."</th>";

                     $MaiA = $AvrilA+$EntreeAyants->M-$SortieAyants->M;
                      if ($MaiA!=0) {
                         $TailleMai = $Mai/$MaiA;
                     }else{
                        $TailleMai=0;
                     }
                  $tailleMoyenneFam.="<th>".$TailleMai."</th>";

                     $JuinA = $MaiA+$EntreeAyants->Ju-$SortieAyants->Ju;
                      if ($JuinA!=0) {
                        $TailleJuin = $Juin/$JuinA;
                     }else{
                        $TailleJuin=0;
                     }
                  $tailleMoyenneFam.="<th>".$TailleJuin."</th>";

                     $JuilletA = $JuinA+$EntreeAyants->Jui-$SortieAyants->Jui;
                     if ($JuilletA!=0) {
                        $TailleJuillet = $Juillet/$JuilletA;
                     }else{
                        $TailleJuillet=0;
                     }
                  $tailleMoyenneFam.="<th>".$TailleJuillet."</th>";

                     $AoutA = $JuilletA+$EntreeAyants->Ao-$SortieAyants->Ao;
                      if ($AoutA!=0) {
                        $TailleAout = $Aout/$AoutA;
                     }else{
                        $TailleAout=0;
                     }
                  $tailleMoyenneFam.="<th>".$TailleAout."</th>";

                     $SeptembreA = $AoutA+$EntreeAyants->S-$SortieAyants->S;
                     if ($SeptembreA!=0) {
                        $TailleSeptembre = $Septembre/$SeptembreA;
                     }else{
                        $TailleSeptembre=0;
                     }
                  $tailleMoyenneFam.="<th>".$TailleSeptembre."</th>";

                     $OctobreA = $SeptembreA+$EntreeAyants->O-$SortieAyants->O;
                     if ($OctobreA!=0) {
                        $TailleOctobre = $Octobre/$OctobreA;
                     }else{
                        $TailleOctobre=0;
                     }
                  $tailleMoyenneFam.="<th>".$TailleOctobre."</th>";

                     $NovembreA = $OctobreA+$EntreeAyants->N-$SortieAyants->N;
                     if ($NovembreA!=0) {
                        $TailleNovembre = $Novembre/$NovembreA;
                     }else{
                        $TailleNovembre=0;
                     }
                  $tailleMoyenneFam.="<th>".$TailleNovembre."</th>";

                     $DecembreA = $NovembreA+$EntreeAyants->D-$SortieAyants->D;
                     if ($DecembreA!=0) {
                        $TailleDecembre = $Decembre/$DecembreA;
                     }else{
                        $TailleDecembre=0;
                     }
                  $tailleMoyenneFam.="<th>".$TailleDecembre."</th>
                  <th></th>
                </tr>";   

     return view('Affiliers.tableau_suivi', compact('EntreesAdh', 'SortiesAdh', 'totalAdh', 'LastYear', 'EntreesAyants', 'SortiesAyants', 'totalAyants', 'tailleMoyenneFam', 'currentyear', 'annees')); 
    }

    public function beneficiairestatus($aff, $type_ben){
         $Mvts="";
     if ($type_ben==1) {
        $NbreMvt = DB::table('mouvent_beneficiaires')
            ->join('affiliers', 'affiliers.id', '=', 'mouvent_beneficiaires.beneficiaire_id')
            ->select(DB::raw(''))
            ->where('mouvent_beneficiaires.type_beneficiaire',$type_ben)
            ->where('mouvent_beneficiaires.beneficiaire_id',$aff)
            ->groupBy('affiliers.id')
            ->max('mouvent_beneficiaires.id');

        if ($NbreMvt>0) {
        $Mouvements = DB::table('mouvent_beneficiaires')
            ->join('affiliers', 'affiliers.id', '=', 'mouvent_beneficiaires.beneficiaire_id')
            ->select(DB::raw('mouvent_beneficiaires.type_mvt'))
            ->where('mouvent_beneficiaires.type_beneficiaire',$type_ben)
            ->where('mouvent_beneficiaires.beneficiaire_id',$aff)
            ->where('mouvent_beneficiaires.id',$NbreMvt)
            ->groupBy('affiliers.id')
            ->get();

            foreach ($Mouvements as $Mouvement) {
            if($Mouvement->type_mvt==1){
            $Mvts.="<option value='2'>Sortie</option>";
            }elseif ($Mouvement->type_mvt==2) {
                $Mvts.="<option value='1'>Entree</option>";
            }
           }
    }else{
        $Mvts.="<option value='1'>Entree</option>";
     }
    }else{
        $NbreMvt = DB::table('mouvent_beneficiaires')
            ->join('ayant_droits', 'ayant_droits.id', '=', 'mouvent_beneficiaires.beneficiaire_id')
            ->select(DB::raw(''))
            ->where('mouvent_beneficiaires.type_beneficiaire',$type_ben)
            ->where('mouvent_beneficiaires.beneficiaire_id',$aff)
            ->groupBy('ayant_droits.id')
            ->max('mouvent_beneficiaires.id');

    if ($NbreMvt>0) {
        $Mouvements = DB::table('mouvent_beneficiaires')
            ->join('ayant_droits', 'ayant_droits.id', '=', 'mouvent_beneficiaires.beneficiaire_id')
            ->select(DB::raw('mouvent_beneficiaires.type_mvt'))
            ->where('mouvent_beneficiaires.type_beneficiaire',$type_ben)
            ->where('mouvent_beneficiaires.beneficiaire_id',$aff)
            ->where('mouvent_beneficiaires.id',$NbreMvt)
            ->groupBy('ayant_droits.id')
            ->get();

            foreach ($Mouvements as $Mouvement) {
            if($Mouvement->type_mvt==1){
            $Mvts.="<option value='2'>Sortie</option>";
            }elseif ($Mouvement->type_mvt==2) {
                $Mvts.="<option value='1'>Entree</option>";
            }
           }
    }else{
        $Mvts.="<option value='1'>Entree</option>";
     }
    }    

        
        echo $Mvts;    
    }  
}      
  