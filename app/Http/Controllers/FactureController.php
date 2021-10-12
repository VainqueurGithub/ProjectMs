<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Facture;
use App\Models\Affilier;
use App\Models\AyantDroit;
use App\Models\Partenaire;
use App\Models\Consomation;
use App\Models\Origine;
use App\Models\Cotisation;
use App\Models\Commande;
use App\Models\Service;
use App\Models\AffilierPartenaire;
use App\Models\medicamentsservice;
use App\Models\MedicamentPartenaire;
use App\Interfaces\ICommande as ICommande;
use App\Interfaces\IFacture as IFacture;
use App\Interfaces\IAffilie as IAffilie;
use App\Interfaces\IService as IService;
use Illuminate\Support\Facades\DB;
use PDF;
use Cart;
use Carbon\Carbon;
class FactureController extends Controller
{   

    public function __construct(ICommande $Commande, IAffilie $Affilier, IService $Service, IFacture $Facture){
        $this->Commande = $Commande;
        $this->Affilier = $Affilier;
         $this->Service = $Service;
        $this->Facture = $Facture;
        $this->middleware('guest');
      } 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {    
        $Etatf = 2;
        $table="";
         if(session()->get('Profil')=='Partenaire')
            {
               $FacturesNbre = Facture::where('Etat', '!=', 2)->wherePartenaire(session()->get('id'))->count('id'); 
            }
            else
            {
               $FacturesNbre = Facture::where('Etat', '!=', 2)->count('id');
            }

        if ($FacturesNbre > 0) { 
            if(session()->get('Profil')=='Partenaire')
            { 
               $Factures = Facture::where('Etat', '!=', 2)->wherePartenaire(session()->get('id'))->get(); 
            }
            else
            {
               $Factures = Facture::where('Etat', '!=', 2)->get();
            }
         foreach($Factures as $Facture){

            $id_Affilier=$Facture->Affilier;
            $Affilier=Affilier::where('id',$id_Affilier)->first();


            $id_Beneficiaire=$Facture->Beneficiaire;
            $Beneficiaire=AyantDroit::where('id',$id_Beneficiaire)->first();

            $id_Partenaire=$Facture->Partenaire;
            $Partenaire=Partenaire::where('id',$id_Partenaire)->first();
   
   if ($Affilier->Etat==2) 
   {
       if (session()->get('Profil') == 'User') 
        {
           $table.="
                    <tr class='odd gradeX' style='color: red;'>
                        <td>".$Facture->NumFacture.'/'.$Facture->Annee."</td>
                        <td>".$Facture->DateTraitement."</td>
                        <td>".$Facture->DateTransimission."</td>
                        <td>".$Affilier->Nom.' '.$Affilier->Prenom."</td>
                        <td>".$Beneficiaire->Nom.' '.$Beneficiaire->Prenom."</td>
                        <td>".$Partenaire->Partenaire."</td>
                        <td>".$Facture->SAAT."</td>
                        <td>".$Facture->DatePayement."</td>
                        <td>".$Facture->ModePayement."</td>

                        <td class='center f-icon'>
                            <a href='".route('Factures.show',$Facture)."'><i class='fas fa-eye'></i></a>

                            <a href='".route('PdfFacture',$Facture)."'><i class='fa fa-print'></i></a>
                            <a href='".route('Factures.edit',$Facture)."'>
                                <i class='fas fa-edit'></i>
                                </a>
                            <form action='".route('Factures.destroy',$Facture)."' method='POST'>
                           
                                ".csrf_field()."
                                ".method_field('DELETE')."
                                <button>
                                    <i class='fas fa-trash'></i>
                                    </button>
                            </form>
                            
                        </td>
                      
                    </tr>";
        }
        else
        {
            $table.="
                    <tr class='odd gradeX' style='color: red;'>
                        <td>".$Facture->NumFacture.'/'.$Facture->Annee."</td>
                         <td>".$Facture->DateTraitement."</td>
                         <td>".$Facture->DateTransimission."</td>
                        <td>".$Affilier->Nom.' '.$Affilier->Prenom."</td>
                        <td>".$Beneficiaire->Nom.' '.$Beneficiaire->Prenom."</td>
                        <td>".$Partenaire->Partenaire."</td>
                        <td>".$Facture->Montant."</td>
                        <td>".$Facture->DatePayement."</td>
                        <td>".$Facture->ModePayement."</td>

                        <td class='center f-icon'>
                            <a href='".route('Factures.show',$Facture)."'><i class='fas fa-eye'></i></a>

                            <a href='".route('PdfFacture',$Facture)."'><i class='fa fa-print'></i></a>
                            <a href='".route('Factures.edit',$Facture)."'>
                                <i class='fas fa-edit'></i>
                                </a>
                            <form action='".route('Factures.destroy',$Facture)."' method='POST'>
                           
                                ".csrf_field()."
                                ".method_field('DELETE')."
                                <button>
                                    <i class='fas fa-trash'></i>
                                    </button>
                            </form>
                            
                        </td>
                      
                    </tr>";
        }
   }
   else
   {
      if (session()->get('Profil') == 'User') 
        {
           $table.="
                    <tr class='odd gradeX'>
                        <td>".$Facture->NumFacture.'/'.$Facture->Annee."</td>
                        <td>".$Facture->DateTraitement."</td>
                        <td>".$Facture->DateTransimission."</td>
                        <td>".$Affilier->Nom.' '.$Affilier->Prenom."</td>
                        <td>".$Beneficiaire->Nom.' '.$Beneficiaire->Prenom."</td>
                        <td>".$Partenaire->Partenaire."</td>
                        <td>".$Facture->SAAT."</td>
                        <td>".$Facture->DatePayement."</td>
                        <td>".$Facture->ModePayement."</td>

                        <td class='center f-icon'>
                            <form action='".route('Factures.destroy',$Facture)."' method='POST'>
                            <a href='".route('Factures.show',$Facture)."'><i class='fa fa-pencil'></i></a>
                            
                                ".csrf_field()."
                                ".method_field('DELETE')."
                                <button><img src='".url('icons/icons8_Delete_52px.png')."' width='10px' height='10px'>
                                    </button>
                                    
                                <a href='".route('PdfFacture',$Facture)."'><i class='fa fa-print'></i></a>
                                
                                <a href='".route('Factures.edit',$Facture)."'><img src='".url('icons/icons8_Receive_Cash_24px_1.png')."' width='20px' height='20px'></a>
                            </form>
                            
                        </td>
                      
                    </tr>";
        }
        else
        {
            $table.="
                    <tr class='odd gradeX'>
                        <td>".$Facture->NumFacture.'/'.$Facture->Annee."</td>
                         <td>".$Facture->DateTraitement."</td>
                         <td>".$Facture->DateTransimission."</td>
                        <td>".$Affilier->Nom.' '.$Affilier->Prenom."</td>
                        <td>".$Beneficiaire->Nom.' '.$Beneficiaire->Prenom."</td>
                        <td>".$Partenaire->Partenaire."</td>
                        <td>".$Facture->Montant."</td>
                        <td>".$Facture->DatePayement."</td>
                        <td>".$Facture->ModePayement."</td>

                        <td class='center f-icon'>
                            <form action='".route('Factures.destroy',$Facture)."' method='POST'>
                            <a href='".route('Factures.show',$Facture)."'><i class='fa fa-pencil'></i></a>
                            
                                ".csrf_field()."
                                ".method_field('DELETE')."
                                <button><img src='".url('icons/icons8_Delete_52px.png')."' width='10px' height='10px'>
                                    </button>
                                    
                                <a href='".route('PdfFacture',$Facture)."'><i class='fa fa-print'></i></a>
                            </form>
                            
                        </td>
                      
                    </tr>";
        }
   }
       
        }
        }

        $tableListe=$table;
        return view('Factures.index', compact('tableListe'));
    }

        //AYANT DROIT

     public function getProduiBenfic(Request $request){
        $AYANT=$request->get('id_affilier');
        $TOUS=AyantDroit::where('Affilier',$AYANT)->get();
        $allAyantDroit="<option selected='selected'>Selectionner</option>";
        foreach ($TOUS as $keyAyant) {
            $allAyantDroit.="<option value='".$keyAyant->id."'>".$keyAyant->Nom.' '.$keyAyant->Prenom.' /'.$keyAyant->Lien."</option>";
        }
        echo $allAyantDroit;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $Affiliers = Affilier::whereEtat(0)->get();
        $AyantDroits = AyantDroit::whereEtat(0)->get(); 
        $Partenaires = Partenaire::whereEtat(0)->get(); 
        return view('Factures.create', compact('Affiliers', 'AyantDroits', 'Partenaires'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
       //$Annee = $request->DateT->date_format('Y');

       $Annee = Carbon::createFromDate($request->DateT)->format('Y');
       $Mois = Carbon::createFromDate($request->DateT)->format('m');
       if(session()->get('Profil')=="User"){
            $Type = "U";
        }else{
            $Type = "P";
        }

        $content = Cart::getContent()->where('prestation', session()->get('service'))->where('user', session()->get('id').$Type)->where('Paterner', session()->get('Paterner'));

        $total = Cart::TotalCart($content);

        if (session()->get('Profil') == 'Partenaire') 
        {
             $CurrentYear = date('Y');
             $this->validate($request, [
             //'Affilier' => 'required', 
             'DateT' => 'required',
             'AyantDroits' => 'required'
          ]);
        }
        else
        {
             $CurrentYear = date('Y');
            $this->validate($request, [
            //'Affilier' => 'required', 
            'DateT' => 'required',
            'AyantDroits' => 'required',
            //'Partenaire' => 'required',
            'DateTrans' =>'required'
            ]);
        }

      //Verification de la personne qui emet la facture
        if (session()->get('Profil') == 'Partenaire') 
        {
            $Partenaire = session()->get('id');
            $DateTrans = $request->DateT;
        } 
        else
        {
            $Partenaire = session()->get('Paterner');
            $DateTrans = $request->DateTrans;
        }  
      
      //Detail de l'affilier=>on trouve le limites maternite
     $Affilier = $this->Affilier->showData(session()->get('Aff'));
     //FX POUR CALCULER LES LIMITES
     $TypeT = DB::table('services')
              ->select(DB::raw("Traitement"))
              ->whereId(session()->get('service'))
              ->first();
      $TypeT =  $TypeT->Traitement;        
     $Response = $this->Commande->CalculLimite($TypeT, $total, $Affilier, $Type);

     //ATTRIBUTION DE MONTANT ASSURANCE A UN MOIS X
     $keywords = preg_split("/[\s,]+/", $Response);
     $SAAT = $keywords[0];
     $ComptantAffilier = $keywords[1];

    $NbreEnr = Facture::all()->count('id');
    if ($NbreEnr >0) 
    {
        $MaxId = Facture::all()->max('id');
        $Facture = Facture::findOrFail($MaxId);

        if ($Facture->Annee == $CurrentYear) 
        { 
            $Facture->NumFacture+=1;
           Facture::create([
            'NumFacture' => $Facture->NumFacture,
            'DateTraitement' => $request->DateT,
            'DateTransimission' => $DateTrans,
            'Affilier' => session()->get('Aff'),
            'Beneficiaire' => $request->AyantDroits,
            'TypeTraitement' => session()->get('service'),
            'Partenaire' => $Partenaire,
            'Auteur' => session()->get('id'),
            'Auteurtype' => session()->get('Profil'),
            'Annee' => $CurrentYear,
            'Montant' =>$total,
            'Mois'=> $Mois,
            'AnneeT'=>$Annee,
            'SAAT' => $SAAT,
            'ComptantAffilier' => $ComptantAffilier
           ]);   
        }
        else
        {
          $Facture->NumFacture =1;
          Facture::create([
            'NumFacture' => $Facture->NumFacture,
            'DateTraitement' => $request->DateT,
            'DateTransimission' => $DateTrans,
            'Affilier' => session()->get('Aff'),
            'Beneficiaire' => $request->AyantDroits,
            'TypeTraitement' => session()->get('service'),
            'Partenaire' => $Partenaire,
            'Auteur' => session()->get('id'),
            'Auteurtype' => session()->get('Profil'),
            'Annee' => $CurrentYear,
            'Montant' =>$total,
            'Mois'=> $Mois,
            'AnneeT'=>$Annee,
            'SAAT' => $SAAT,
            'ComptantAffilier' => $ComptantAffilier
           ]);    
        }
    }
    else
    {
       $NumFacture =1;
          Facture::create([
            'NumFacture' => $NumFacture,
            'DateTraitement' => $request->DateT,
            'DateTransimission' => $DateTrans,
            'Affilier' => session()->get('Aff'),
            'Beneficiaire' => $request->AyantDroits,
            'TypeTraitement' => session()->get('service'),
            'Partenaire' => $Partenaire,
            'Auteur' => session()->get('id'),
            'Auteurtype' => session()->get('Profil'),
            'Annee' => $CurrentYear,
            'Montant' =>$total,
            'Mois'=> $Mois,
            'AnneeT'=>$Annee,
            'SAAT' => $SAAT,
            'ComptantAffilier' => $ComptantAffilier
           ]);     
    }
    
    $Facture = Facture::all()->max('id');
    $Details = $this->Facture->showData($Facture);
    
    //STOCKAGE DES ITEMS DU PANIER DANS LA BDD
    $this->Commande->saveData($content,$Facture);
    $Facture = $this->Facture->showData($Facture);
    $this->Commande->Attributionamountmonth(6, $SAAT, $Facture, null);  
    Cart::ClearCart($content);  
   return redirect(route('PdfFacture', compact('Facture')));
 }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   $Facture = $id;
        $DetailsFacture = Facture::findOrFail($id);
        $Affilier = Affilier::findOrFail($DetailsFacture->Affilier);
        
        $Affiliers = DB::table('affiliers')
                     ->join('affilier_partenaires', 'affiliers.id', '=', 'affilier_partenaires.Affilier')
                     ->select(DB::raw('*'))
                     ->where('affilier_partenaires.Partenaire', $DetailsFacture->Partenaire)
                     ->where('affiliers.Etat', '=',0)
                     ->get();
        $AffilierPartenaire = AffilierPartenaire::whereEtatAndAffilierAndPartenaire(0,$DetailsFacture->Affilier,$DetailsFacture->Partenaire)->first();             
        $AyantDroit = AyantDroit::findOrFail($DetailsFacture->Beneficiaire);
        $AyantDroits = AyantDroit::whereEtatAndAffilier(0,$DetailsFacture->Affilier)->get();
        $Partenaire = Partenaire::findOrFail($DetailsFacture->Partenaire);
        $Partenaires = Partenaire::whereEtat(0)->get();

        $DetailsCommandes =DB::table('commandes')
        ->join('medicament_partenaires', 'medicament_partenaires.id', '=', 'commandes.Propriete')
        ->select(DB::raw('medicament_partenaires.designation, commandes.PU, commandes.PT, commandes.Qte, commandes.id'))
        ->whereFacture($id)
        ->get();

       $table=''; 
       


       foreach ($DetailsCommandes as $DetailsCommande) 
       {
           $table.= "<tr>
             <td>".$DetailsCommande->designation."</td>
             <td>".$DetailsCommande->PU."</td>
             <td>".$DetailsCommande->Qte."</td>
             <td>".$DetailsCommande->PT."</td>
             <td>
             
              <a href='".route('Commandes.edit', $DetailsCommande->id)."'><img src='".url('icons/icons8_Edit_26px.png')."' width='20px' height='20px'>
                    </a>

                    <form action='".route('Commandes.destroy', $DetailsCommande->id)."' method='POST' style='display: inline-block;' onsubmit='return confirm('Etez -vous sur de cette Operation ?')'>
                    ".csrf_field()."
                    ".method_field('DELETE')."
                    
                    <button onclick='return confirm('Etez -vous sur de cette Operation ?') ><img src='".url('icons/icons8_Delete_52px.png')."' width='20px' height='20px'>
                    </button>
                </form>
                </td>
           </tr>";
       }
       $tableListe = $table;
        return view('Factures.show', compact('Facture', 'DetailsFacture', 'tableListe', 'Affilier', 'Affiliers', 'AyantDroit', 'AyantDroits', 'Partenaire', 'Partenaires', 'AffilierPartenaire'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Facture = Facture::findOrFail($id);
        $CodeAffilier = Affilier::findOrFail($Facture->Affilier);
        $NomBeneficiare= AyantDroit::findOrFail($Facture->Beneficiaire);
        $Partenaire = Partenaire::findOrFail($Facture->Partenaire);
        $Affiliers = Affilier::whereEtat(0)->get();
        $AyantDroits = AyantDroit::whereEtat(0)->get(); 
        $Partenaires = Partenaire::whereEtat(0)->get(); 
        return view('Factures.edit', compact('Facture', 'CodeAffilier', 'NomBeneficiare', 'Affiliers', 'AyantDroits', 'Partenaires', 'Partenaire'));
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

        if (isset($request->Payement)) 
        {
            $this->validate($request, [
            'DatePay' => 'required', 
            'ModePay' => 'required'
            ]);

            $Facture = Facture::findOrFail($id);
            $Facture->update([
                'ModePayement'=>$request->ModePay,
                'DatePayement'=>$request->DatePay
            ]);

            return redirect(route('Factures.index'));
        }
        else{
        if (session()->get('Profil') == 'Partenaire') 
        {
             $CurrentYear = date('Y');
             $this->validate($request, [
             'Affilier' => 'required', 
             'DateT' => 'required',
             'AyantDroits' => 'required',
             'TraitementT' =>'required'
          ]);
        }
        else
        {
             $CurrentYear = date('Y');
            $this->validate($request, [
            'Affilier' => 'required', 
            'DateT' => 'required',
            'AyantDroits' => 'required',
            'Partenaire' => 'required',
            'TraitementT' =>'required'
            ]);
        }

      //Verification de la personne qui emet la facture
        if (session()->get('Profil') == 'Partenaire') 
        {
            $Partenaire = session()->get('id');
        } 
        else
        {
            $Partenaire = $request->Partenaire;
        }  
        
    $NbreEnr = Facture::all()->count('id');
    if ($NbreEnr >0) 
    {
        $Facture = Facture::findOrFail($id);
           $Facture->update([
            'DateTraitement' => $request->DateT,
            'Affilier' => $request->Affilier,
            'Beneficiaire' => $request->AyantDroits,
            'Partenaire' => $Partenaire,
            'TypeTraitement' => $request->TraitementT
           ]);   
    }
    else{}
    
        $DateFind = DB::table('factures')
                     ->select(DB::raw('MONTH(DateTraitement) as Mois,YEAR(DateTraitement) as Annee'))
                     ->whereId($id)
                     ->get();
        $Facture = Facture::findOrFail($id);
          
         $Facture->update([
            'Janvier' => 0,
            'Fevrier' => 0,
            'Mars' => 0,
            'Avril' => 0,
            'Mai' => 0,
            'Juin' => 0,
            'Juillet' => 0,
            'Aout' => 0,
            'Semptembre' => 0,
            'Octobre' => 0,
            'Novembre' => 0,
            'Decembre' => 0
              ]);

          foreach ($DateFind as $DateF) 
          {
          
           if ($DateF->Mois == 1) {
             $Facture->update([
            'Mois' =>   $DateF->Mois,
            'Janvier' => $Facture->Montant,
            'AnneeT' =>  $DateF->Annee
              ]);
           }
           elseif ($DateF->Mois == 2) {
            $Facture->update([
            'Mois' =>   $DateF->Mois,
            'Fevrier' => $Facture->Montant,
            'AnneeT' =>  $DateF->Annee
              ]);
            }
            elseif ($DateF->Mois == 3) {
                $Facture->update([
            'Mois' =>   $DateF->Mois,
            'Mars' => $Facture->Montant,
            'AnneeT' =>  $DateF->Annee
              ]);
             }
             elseif ($DateF->Mois == 4) {
                 $Facture->update([
            'Mois' =>   $DateF->Mois,
            'Avril' => $Facture->Montant,
            'AnneeT' =>  $DateF->Annee
              ]);
              }
              elseif ($DateF->Mois == 5) {
                 $Facture->update([
            'Mois' =>   $DateF->Mois,
            'Mai' => $Facture->Montant,
            'AnneeT' =>  $DateF->Annee
              ]);
               }elseif ($DateF->Mois == 6) {
                  $Facture->update([
            'Mois' =>   $DateF->Mois,
            'Juin' => $Facture->Montant,
            'AnneeT' =>  $DateF->Annee
              ]);
               }elseif ($DateF->Mois == 7) {
                    $Facture->update([
            'Mois' =>   $DateF->Mois,
            'Juillet' => $Facture->Montant,
            'AnneeT' =>  $DateF->Annee
              ]);
               }elseif ($DateF->Mois == 8) {
                  $Facture->update([
            'Mois' =>   $DateF->Mois,
            'Aout' => $Facture->Montant,
            'AnneeT' =>  $DateF->Annee
              ]);
               }elseif ($DateF->Mois == 9) {
                 $Facture->update([
            'Mois' =>   $DateF->Mois,
            'Semptembre' => $Facture->Montant,
            'AnneeT' =>  $DateF->Annee
              ]);
               }elseif ($DateF->Mois == 10) {
                 $Facture->update([
            'Mois' =>   $DateF->Mois,
            'Octobre' => $Facture->Montant,
            'AnneeT' =>  $DateF->Annee
              ]);
               }elseif ($DateF->Mois == 11) {
                 $Facture->update([
            'Mois' =>   $DateF->Mois,
            'Novembre' => $Facture->Montant,
            'AnneeT' =>  $DateF->Annee
              ]);
               }elseif ($DateF->Mois == 12) {
                 $Facture->update([
            'Mois' =>   $DateF->Mois,
            'Decembre' => $Facture->Montant,
            'AnneeT' =>  $DateF->Annee
              ]);
               }
        }        
         return redirect(route('Factures.show', compact('id'))); 
        } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $Facture = Facture::findOrFail($id);
        $Facture->update([
            'Etat' => 2
        ]);
       session()->flash('messageDelete', 'Facture supprimée');
       return redirect(route('Factures.index')); 
    }

    public function CorbFact()
    {
        $table="";
        $FacturesNbre=Facture::whereEtat(2)->count();

        if ($FacturesNbre > 0) {

         $Factures = Facture::whereEtat(2)->get();
         foreach($Factures as $Facture){

            $id_Affilier=$Facture->Affilier;
            $Affilier=Affilier::where('id',$id_Affilier)->first();


            $id_Beneficiaire=$Facture->Beneficiaire;
            $Beneficiaire=AyantDroit::where('id',$id_Beneficiaire)->first();

            $id_Partenaire=$Facture->Partenaire;
            $Partenaire=Partenaire::where('id',$id_Partenaire)->first();


            $table.="
                    <tr class='odd gradeX'>
                        <td>".$Facture->NumFacture.'/'.$Facture->Annee."</td>
                         <td>".$Facture->DateTraitement."</td>
                        <td>".$Affilier->Nom.' '.$Affilier->Prenom."</td>
                        <td>".$Beneficiaire->Nom.' '.$Beneficiaire->Prenom."</td>
                        <td>".$Facture->DateTransimission."</td>
                        <td>".$Partenaire->Partenaire."</td>
                        <td>".$Facture->SAAT."</td>
                        <td>".$Facture->DatePayement."</td>
                        <td>".$Facture->ModePayement."</td>

                        <td class='center f-icon'>
                            <a href='".route('RestaureFact',$Facture)."'><img src='".url('icons/icons8_Reset_24px.png')."'></a> 
                            <form action='".route('SupprimerDefini',$Facture)."' method='POST' style='display:inline-block;'>
                               ".csrf_field()."
                                ".method_field('DELETE')."
                                <button><i class='fa fas-trash'></i>
                                    </button>
                                    
                                
                            </form>
                        </td>
                      
                    </tr>";
                    }
                       # code...
        }

        $tableListe=$table;
        return view('Factures.CorbFact', compact('tableListe'));
    }

    public function RestaureFact($id)
    {
       $Facture = Facture::findOrFail($id);
        $Facture->update([
            'Etat' => 1
        ]);
       return redirect(route('CorbFact')); 
    }


    public function SupprimerDefini($id)
    {  
        $Commandes = Commande::whereFacture($id)->get();

        foreach($Commandes as $Commande)
        {
            Commande::destroy($Commande->id);
        }
        Facture::destroy($id);
        return redirect(route('CorbFact')); 
    }



 public function JournalFacture()
 //Debut Fx
{ 
       $table="";
       $Somme = []; 
       $comm =[];
     if(session()->get('Profil')!='Partenaire')
     //Verification !Partenaire 
     {
     $Partenaires = Partenaire::whereEtat(0)->get();
     $Origines = Origine::whereEtat(0)->get(); 
     $Affiliers = Affilier::all();
     $Factures = Facture::where('Etat', '!=', 2)->groupBy('Affilier')->get();
     $NbreCot=Facture::where('Etat', '!=', 2)->count();
        if ($NbreCot > 0)
        //Verification d'existance d'1 proformat 
        {
         $comm = DB::table('factures')
                     ->join('affiliers', 'affiliers.id', '=', 'factures.Affilier')
                     ->select(DB::raw('sum(Janvier) as J,sum(Fevrier) as F, sum(Mars) as M, sum(Avril) as A, sum(Mai) as Ma, sum(Juin) as Ju, sum(Juillet) as Jui, sum(Aout) as Ao, sum(semptembre) as S, sum(Octobre) as O, sum(Novembre) as N, sum(Decembre) as D, Affilier, sum(Janvier+Fevrier+Mars+Avril+Mai+Juin+Juillet+Aout+semptembre+Octobre+Novembre+Decembre) as ST'))
                     ->where('factures.Etat', '!=', 2)
                     ->where('affiliers.Etat', '!=', 1)
                     ->groupBy('Affilier')
                     ->get();

          $Somme = DB::table('factures')
                     ->join('affiliers', 'affiliers.id', '=', 'factures.Affilier')
                     ->select(DB::raw('sum(Janvier) as J,sum(Fevrier) as F, sum(Mars) as M, sum(Avril) as A, sum(Mai) as Ma, sum(Juin) as Ju, sum(Juillet) as Jui, sum(Aout) as Ao, sum(semptembre) as S, sum(Octobre) as O, sum(Novembre) as N, sum(Decembre) as D, count(distinct(Affilier)) as AF, sum(Janvier+Fevrier+Mars+Avril+Mai+Juin+Juillet+Aout+semptembre+Octobre+Novembre+Decembre) as ST'))
                     ->where('factures.Etat', '!=', 2)
                     ->where('affiliers.Etat', '!=', 1)
                     ->get(); 
          // Fin Verification d'existance d'1 proformat            
        }
      //Fin Verification Partenaire   
     }
     //Admin syst
     else{
         $Partenaires = Partenaire::whereEtat(0)->get();
         $Origines = Origine::whereEtat(0)->get(); 
         $Affiliers = Affilier::all();
         $Factures = Facture::where('Etat', '!=', 2)->wherePartenaire(session()->get('id'))->groupBy('Affilier')->get();
         $NbreCot=Facture::where('Etat', '!=', 2)->wherePartenaire(session()->get('id'))->count();
         if ($NbreCot > 0) {
         $comm = DB::table('factures')
                     ->join('affiliers', 'affiliers.id', '=', 'factures.Affilier')
                     ->select(DB::raw('sum(Janvier) as J,sum(Fevrier) as F, sum(Mars) as M, sum(Avril) as A, sum(Mai) as Ma, sum(Juin) as Ju, sum(Juillet) as Jui, sum(Aout) as Ao, sum(semptembre) as S, sum(Octobre) as O, sum(Novembre) as N, sum(Decembre) as D, Affilier, sum(Janvier+Fevrier+Mars+Avril+Mai+Juin+Juillet+Aout+semptembre+Octobre+Novembre+Decembre) as ST'))
                     ->where('factures.Etat', '!=', 2)
                     ->where('factures.Partenaire', '=', session()->get('id'))
                     ->where('affiliers.Etat', '!=', 1)
                     ->groupBy('Affilier')
                     ->get();
         
         $Somme = DB::table('factures')
                     ->join('affiliers', 'affiliers.id', '=', 'factures.Affilier')
                     ->select(DB::raw('sum(Janvier) as J,sum(Fevrier) as F, sum(Mars) as M, sum(Avril) as A, sum(Mai) as Ma, sum(Juin) as Ju, sum(Juillet) as Jui, sum(Aout) as Ao, sum(semptembre) as S, sum(Octobre) as O, sum(Novembre) as N, sum(Decembre) as D, count(distinct(Affilier)) as AF, sum(Janvier+Fevrier+Mars+Avril+Mai+Juin+Juillet+Aout+semptembre+Octobre+Novembre+Decembre) as ST'))
                     ->where('factures.Etat', '!=', 2)
                     ->where('factures.Partenaire', '=', session()->get('id'))
                     ->where('affiliers.Etat', '!=', 1)
                     ->get();                            
                     
      }
     } 
     
         foreach($comm as $com){

            $id_Affilier=$com->Affilier;
            $Affilier=Affilier::where('id',$id_Affilier)->first();

      if ($Affilier->Etat==2) 
      {
           $table.="
                    <tr class='odd gradeX' style='color:red;'>
                        <td>".$Affilier->Code."</td>
                        <td>".$Affilier->Nom.' '.$Affilier->Prenom."</td>
                         <td>".number_format($com->J,0,',',' ')."</td>
                         <td>".number_format($com->F,0,',',' ')."</td>
                        <td>".number_format($com->M,0,',',' ')."</td>
                        <td>".number_format($com->A,0,',',' ')."</td>
                        <td>".number_format($com->Ma,0,',',' ')."</td>
                        <td>".number_format($com->Ju,0,',',' ')."</td>
                        <td>".number_format($com->Jui,0,',',' ')."</td>
                        <td>".number_format($com->Ao,0,',',' ')."</td>
                        <td>".number_format($com->S,0,',',' ')."</td>
                       <td>".number_format($com->O,0,',',' ')."</td>
                       <td>".number_format($com->N,0,',',' ')."</td>
                        <td>".number_format($com->D,0,',',' ')."</td>
                        <td>".number_format($com->ST,0,',',' ')."</td>
                    </tr>"; 
      }
      else
      {
         $table.="
                    <tr class='odd gradeX'>
                        <td>".$Affilier->Code."</td>
                        <td>".$Affilier->Nom.' '.$Affilier->Prenom."</td>
                         <td>".number_format($com->J,0,',',' ')."</td>
                         <td>".number_format($com->F,0,',',' ')."</td>
                        <td>".number_format($com->M,0,',',' ')."</td>
                        <td>".number_format($com->A,0,',',' ')."</td>
                        <td>".number_format($com->Ma,0,',',' ')."</td>
                        <td>".number_format($com->Ju,0,',',' ')."</td>
                        <td>".number_format($com->Jui,0,',',' ')."</td>
                        <td>".number_format($com->Ao,0,',',' ')."</td>
                        <td>".number_format($com->S,0,',',' ')."</td>
                       <td>".number_format($com->O,0,',',' ')."</td>
                       <td>".number_format($com->N,0,',',' ')."</td>
                        <td>".number_format($com->D,0,',',' ')."</td>
                        <td>".number_format($com->ST,0,',',' ')."</td>
                    </tr>";
          }
                    }
                       # code...
        $tableListe=$table;
        return view('Factures.Journal', compact('tableListe', 'Somme', 'Affiliers', 'Partenaires', 'Origines'));
}


    public function PdfCreateFactures(Request $request)
    {   
        set_time_limit(300);
        $Consomation = Consomation::findOrFail(1);
        $Somme = [];
        $Partenaire = '';
        $Individu = '';
        $Origine = '';
        $Debut='';
        $Fin='';
        $AyaDrA='';
         
        if (isset($request->Partenaire) && !empty($request->Partenaire) && isset($request->Individu) && !empty($request->Individu) && !empty($request->Debut) && isset($request->Debut) && !empty($request->Fin) && isset($request->Fin))
        {
            $Partenaire =Partenaire::findOrFail($request->Partenaire);
            $Individu = Affilier::findOrFail($request->Individu);
            $Debut = $request->Debut;
            $Fin = $request->Fin;
        
            $NbreCot = DB::table('factures')
                     ->join('affiliers', 'affiliers.id', '=', 'factures.Affilier')
                     ->select(DB::raw('sum(factures.id) as NbreCot, factures.Partenaire,Origine,factures.Affilier'))
                     ->where('factures.Partenaire', $request->Partenaire)
                     ->whereBetween('DateTraitement', [$request->Debut, $request->Fin])
                     ->where('factures.Affilier', $request->Individu)
                     ->where('factures.Etat', '!=', 2)
                     ->get();
                       
        $table="";

      foreach ($NbreCot as $Nbre) 
      {      
        if ($Nbre->NbreCot > 0) {
         $comm = DB::table('factures')
                     ->join('affiliers', 'affiliers.id', '=', 'factures.Affilier')
                     ->select(DB::raw('sum(Janvier) as J,sum(Fevrier) as F, sum(Mars) as M, sum(Avril) as A, sum(Mai) as Ma, sum(Juin) as Ju, sum(Juillet) as Jui, sum(Aout) as Ao, sum(semptembre) as S, sum(Octobre) as O, sum(Novembre) as N, sum(Decembre) as D, Affilier, sum(Janvier+Fevrier+Mars+Avril+Mai+Juin+Juillet+Aout+semptembre+Octobre+Novembre+Decembre) as ST, affiliers.Code,affiliers.Nom,affiliers.Prenom,affiliers.id'))
                      ->where('factures.Partenaire', $request->Partenaire)
                     ->whereBetween('DateTraitement', [$request->Debut, $request->Fin])
                     ->where('factures.Affilier', $request->Individu)
                     ->where('factures.Etat', '!=', 2)
                     //->where('affiliers.Etat', '!=', 1)
                     ->groupBy('Affilier')
                     ->get();

          $Somme = DB::table('factures')
                     ->join('affiliers', 'affiliers.id', '=', 'factures.Affilier')
                     ->select(DB::raw('sum(Janvier) as J,sum(Fevrier) as F, sum(Mars) as M, sum(Avril) as A, sum(Mai) as Ma, sum(Juin) as Ju, sum(Juillet) as Jui, sum(Aout) as Ao, sum(semptembre) as S, sum(Octobre) as O, sum(Novembre) as N, sum(Decembre) as D, count(distinct(Affilier)) as AF, sum(Janvier+Fevrier+Mars+Avril+Mai+Juin+Juillet+Aout+semptembre+Octobre+Novembre+Decembre) as ST, affiliers.Code, affiliers.Nom, affiliers.Prenom'))
                     ->where('factures.Partenaire', $request->Partenaire)
                     ->whereBetween('DateTraitement', [$request->Debut, $request->Fin])
                     ->where('factures.Affilier', $request->Individu)
                     ->where('factures.Etat', '!=', 2)
                     //->where('affiliers.Etat', '!=', 1)
                     ->get();           
         foreach($comm as $com){
           $Commandes = Commande::whereFacture($com->id)->get();

            foreach ($Commandes as $Commande) 
            {  
               if (is_numeric($Commande->Propriete)) 
               {
                 $Comman = MedicamentPartenaire::wherePartenaireAndId($com->Partenaire,$Commande->Propriete)->first(); 
                 $AyaDrA.="
                 <ul><li>".$Comman->designation."</li></ul>";
               }else{
                  $AyaDrA.="
                 <ul><li>".$Commande->Propriete."</li></ul>"; 
               }   
            }
            $table.="
                    <tr class='odd gradeX'>
                        <td>".$com->Code."</td>
                        <td>".$com->Nom.' '.$com->Prenom."</td>
                        <td>".$AyaDrA."</td>
                         <td>".number_format($com->J,0,',',' ')."</td>
                         <td>".number_format($com->F,0,',',' ')."</td>
                        <td>".number_format($com->M,0,',',' ')."</td>
                        <td>".number_format($com->A,0,',',' ')."</td>
                        <td>".number_format($com->Ma,0,',',' ')."</td>
                        <td>".number_format($com->Ju,0,',',' ')."</td>
                        <td>".number_format($com->Jui,0,',',' ')."</td>
                        <td>".number_format($com->Ao,0,',',' ')."</td>
                        <td>".number_format($com->S,0,',',' ')."</td>
                       <td>".number_format($com->O,0,',',' ')."</td>
                       <td>".number_format($com->N,0,',',' ')."</td>
                        <td>".number_format($com->D,0,',',' ')."</td>
                        <td>".number_format($com->ST,0,',',' ')."</td>
                    </tr>";
                    }
                       # code...
        }
        $tableListe=$table;
        $pdf = PDF::loadView('Factures.PdfCreateFactures', compact('tableListe', 'Somme', 'Partenaire', 'Individu', 'Origine', 'Debut', 'Fin', 'Consomation'))->setPaper('a3', 'Paysage');
         $fileName = 'Journal';
         return $pdf->stream($fileName . '.pdf');
        }
       }
        elseif (isset($request->Partenaire) && !empty($request->Partenaire) && isset($request->Groupe) && !empty($request->Groupe) && !empty($request->Debut) && isset($request->Debut) && !empty($request->Fin) && isset($request->Fin))
        {   

            $NbreCot = DB::table('factures')
                     ->join('affiliers', 'affiliers.id', '=', 'factures.Affilier')
                     ->select(DB::raw('sum(factures.id) as NbreCot, Partenaire,Origine'))
                     ->where('factures.Partenaire', $request->Partenaire)
                     ->whereBetween('DateTraitement', [$request->Debut, $request->Fin])
                     ->where('affiliers.Origine', $request->Groupe)
                     ->where('factures.Etat', '!=', 2)
                     ->get();
            $Partenaire =Partenaire::findOrFail($request->Partenaire); 
            $Origine =Origine::findOrFail($request->Groupe); 
            $Debut = $request->Debut;
            $Fin = $request->Fin;

        $table="";

      foreach ($NbreCot as $Nbre) 
      {      
        if ($Nbre->NbreCot > 0) {
         $comm = DB::table('factures')
                     ->join('affiliers', 'affiliers.id', '=', 'factures.Affilier')
                     ->select(DB::raw('sum(Janvier) as J,sum(Fevrier) as F, sum(Mars) as M, sum(Avril) as A, sum(Mai) as Ma, sum(Juin) as Ju, sum(Juillet) as Jui, sum(Aout) as Ao, sum(semptembre) as S, sum(Octobre) as O, sum(Novembre) as N, sum(Decembre) as D, Affilier, sum(Janvier+Fevrier+Mars+Avril+Mai+Juin+Juillet+Aout+semptembre+Octobre+Novembre+Decembre) as ST,affiliers.Code,affiliers.Nom,affiliers.Prenom,affiliers.id'))
                     ->where('factures.Partenaire', $request->Partenaire)
                     ->whereBetween('DateTraitement', [$request->Debut, $request->Fin])
                     ->where('affiliers.Origine', $request->Groupe)
                     ->where('factures.Etat', '!=', 2)
                     //->where('affiliers.Etat', '!=', 1)
                     ->groupBy('Affilier')
                     ->get();

          $Somme = DB::table('factures')
                     ->join('affiliers', 'affiliers.id', '=', 'factures.Affilier')
                     ->select(DB::raw('sum(Janvier) as J,sum(Fevrier) as F, sum(Mars) as M, sum(Avril) as A, sum(Mai) as Ma, sum(Juin) as Ju, sum(Juillet) as Jui, sum(Aout) as Ao, sum(semptembre) as S, sum(Octobre) as O, sum(Novembre) as N, sum(Decembre) as D, count(distinct(Affilier)) as AF, sum(Janvier+Fevrier+Mars+Avril+Mai+Juin+Juillet+Aout+semptembre+Octobre+Novembre+Decembre) as ST'))
                     ->where('factures.Partenaire', $request->Partenaire)
                     ->whereBetween('DateTraitement', [$request->Debut, $request->Fin])
                     ->where('affiliers.Origine', $request->Groupe)
                     ->where('factures.Etat', '!=', 2)
                     //->where('affiliers.Etat', '!=', 1)
                     ->get();           
         foreach($comm as $com){
           $Commandes = Commande::whereFacture($com->id)->get();

            foreach ($Commandes as $Commande) 
            {  
               if (is_numeric($Commande->Propriete)) 
               {
                 $Comman = MedicamentPartenaire::wherePartenaireAndId($com->Partenaire,$Commande->Propriete)->first(); 
                 $AyaDrA.="
                 <ul><li>".$Comman->designation."</li></ul>";
               }else{
                  $AyaDrA.="
                 <ul><li>".$Commande->Propriete."</li></ul>"; 
               }   
            }
            $table.="
                    <tr class='odd gradeX'>
                        <td>".$com->Code."</td>
                        <td>".$com->Nom.' '.$com->Prenom."</td>
                        <td>".$AyaDrA."</td>
                         <td>".number_format($com->J,0,',',' ')."</td>
                         <td>".number_format($com->F,0,',',' ')."</td>
                        <td>".number_format($com->M,0,',',' ')."</td>
                        <td>".number_format($com->A,0,',',' ')."</td>
                        <td>".number_format($com->Ma,0,',',' ')."</td>
                        <td>".number_format($com->Ju,0,',',' ')."</td>
                        <td>".number_format($com->Jui,0,',',' ')."</td>
                        <td>".number_format($com->Ao,0,',',' ')."</td>
                        <td>".number_format($com->S,0,',',' ')."</td>
                      <td>".number_format($com->O,0,',',' ')."</td>
                      <td>".number_format($com->N,0,',',' ')."</td>
                        <td>".number_format($com->D,0,',',' ')."</td>
                        <td>".number_format($com->ST,0,',',' ')."</td>
                    </tr>";
                    }
                      # code...
        }
        $tableListe=$table;
        $pdf = PDF::loadView('Factures.PdfCreateFactures', compact('tableListe', 'Somme', 'Partenaire', 'Origine', 'Individu', 'Debut', 'Fin', 'Consomation'))->setPaper('a3', 'Paysage');
         $fileName = 'Journal';
         return $pdf->stream($fileName . '.pdf');
        }
      }
        elseif (isset($request->Partenaire) && !empty($request->Partenaire) && isset($request->Groupe) && !empty($request->Groupe))
        {
            $Partenaire =Partenaire::findOrFail($request->Partenaire); 
            $Origine =Origine::findOrFail($request->Groupe);  
            $NbreCot = DB::table('factures')
                     ->join('affiliers', 'affiliers.id', '=', 'factures.Affilier')
                     ->select(DB::raw('sum(factures.id) as NbreCot, Partenaire,Origine'))
                     ->where('factures.Partenaire', $request->Partenaire)
                     ->where('affiliers.Origine', $request->Groupe)
                     ->where('factures.Etat', '!=', 2)
                     ->get();
                       
        $table="";

      foreach ($NbreCot as $Nbre) 
      {      
        if ($Nbre->NbreCot > 0) {
         $comm = DB::table('factures')
                     ->join('affiliers', 'affiliers.id', '=', 'factures.Affilier')
                     ->select(DB::raw('sum(Janvier) as J,sum(Fevrier) as F, sum(Mars) as M, sum(Avril) as A, sum(Mai) as Ma, sum(Juin) as Ju, sum(Juillet) as Jui, sum(Aout) as Ao, sum(semptembre) as S, sum(Octobre) as O, sum(Novembre) as N, sum(Decembre) as D, Affilier, sum(Janvier+Fevrier+Mars+Avril+Mai+Juin+Juillet+Aout+semptembre+Octobre+Novembre+Decembre) as ST,affiliers.Code,affiliers.Nom,affiliers.Prenom,affiliers.id'))
                      ->where('factures.Partenaire', $request->Partenaire)
                     ->where('affiliers.Origine', $request->Groupe)
                     ->where('factures.Etat', '!=', 2)
                     //->where('affiliers.Etat', '!=', 1)
                     ->groupBy('Affilier')
                     ->get();

          $Somme = DB::table('factures')
                     ->join('affiliers', 'affiliers.id', '=', 'factures.Affilier')
                     ->select(DB::raw('sum(Janvier) as J,sum(Fevrier) as F, sum(Mars) as M, sum(Avril) as A, sum(Mai) as Ma, sum(Juin) as Ju, sum(Juillet) as Jui, sum(Aout) as Ao, sum(semptembre) as S, sum(Octobre) as O, sum(Novembre) as N, sum(Decembre) as D, count(distinct(Affilier)) as AF, sum(Janvier+Fevrier+Mars+Avril+Mai+Juin+Juillet+Aout+semptembre+Octobre+Novembre+Decembre) as ST'))
                     ->where('factures.Partenaire', $request->Partenaire)
                     ->where('affiliers.Origine', $request->Groupe)
                     ->where('factures.Etat', '!=', 2)
                     //->where('affiliers.Etat', '!=', 1)
                     ->get();           
         foreach($comm as $com){
           $Commandes = Commande::whereFacture($com->id)->get();

            foreach ($Commandes as $Commande) 
            {  
               if (is_numeric($Commande->Propriete)) 
               {
                 $Comman = MedicamentPartenaire::wherePartenaireAndId($com->Partenaire,$Commande->Propriete)->first(); 
                 $AyaDrA.="
                 <ul><li>".$Comman->designation."</li></ul>";
               }else{
                  $AyaDrA.="
                 <ul><li>".$Commande->Propriete."</li></ul>"; 
               }   
            }
            $table.="
                    <tr class='odd gradeX'>
                        <td>".$com->Code."</td>
                        <td>".$com->Nom.' '.$com->Prenom."</td>
                        <td>".$AyaDrA."</td>
                         <td>".number_format($com->J,0,',',' ')."</td>
                         <td>".number_format($com->F,0,',',' ')."</td>
                        <td>".number_format($com->M,0,',',' ')."</td>
                        <td>".number_format($com->A,0,',',' ')."</td>
                        <td>".number_format($com->Ma,0,',',' ')."</td>
                        <td>".number_format($com->Ju,0,',',' ')."</td>
                        <td>".number_format($com->Jui,0,',',' ')."</td>
                        <td>".number_format($com->Ao,0,',',' ')."</td>
                        <td>".number_format($com->S,0,',',' ')."</td>
                       <td>".number_format($com->O,0,',',' ')."</td>
                       <td>".number_format($com->N,0,',',' ')."</td>
                        <td>".number_format($com->D,0,',',' ')."</td>
                        <td>".number_format($com->ST,0,',',' ')."</td>
                    </tr>";
                    }
                       # code...
        }
        $tableListe=$table;
        $pdf = PDF::loadView('Factures.PdfCreateFactures', compact('tableListe', 'Somme', 'Partenaire', 'Origine', 'Individu', 'Debut', 'Fin', 'Consomation'))->setPaper('a3', 'Paysage');
         $fileName = 'Journal';
         return $pdf->stream($fileName . '.pdf');
        }
       }

       elseif (isset($request->Partenaire) && !empty($request->Partenaire) && isset($request->Individu) && !empty($request->Individu))
        {
            $Partenaire =Partenaire::findOrFail($request->Partenaire); 
            $Individu = Affilier::findOrFail($request->Individu);  
            $NbreCot = DB::table('factures')
                     ->join('affiliers', 'affiliers.id', '=', 'factures.Affilier')
                     ->select(DB::raw('sum(factures.id) as NbreCot, Partenaire,Origine'))
                     ->where('factures.Partenaire', $request->Partenaire)
                     ->where('factures.Affilier', $request->Individu)
                     ->where('factures.Etat', '!=', 2)
                     ->get();
                       
        $table="";

      foreach ($NbreCot as $Nbre) 
      {      
        if ($Nbre->NbreCot > 0) {
         $comm = DB::table('factures')
                     ->join('affiliers', 'affiliers.id', '=', 'factures.Affilier')
                     ->select(DB::raw('sum(Janvier) as J,sum(Fevrier) as F, sum(Mars) as M, sum(Avril) as A, sum(Mai) as Ma, sum(Juin) as Ju, sum(Juillet) as Jui, sum(Aout) as Ao, sum(semptembre) as S, sum(Octobre) as O, sum(Novembre) as N, sum(Decembre) as D, Affilier, sum(Janvier+Fevrier+Mars+Avril+Mai+Juin+Juillet+Aout+semptembre+Octobre+Novembre+Decembre) as ST, affiliers.Code,affiliers.Nom,affiliers.Prenom,affiliers.id'))
                     ->where('factures.Partenaire', $request->Partenaire)
                     ->where('factures.Affilier', $request->Individu)
                     ->where('factures.Etat', '!=', 2)
                     //->where('affiliers.Etat', '!=', 1)
                     ->groupBy('Affilier')
                     ->get();

          $Somme = DB::table('factures')
                     ->join('affiliers', 'affiliers.id', '=', 'factures.Affilier')
                     ->select(DB::raw('sum(Janvier) as J,sum(Fevrier) as F, sum(Mars) as M, sum(Avril) as A, sum(Mai) as Ma, sum(Juin) as Ju, sum(Juillet) as Jui, sum(Aout) as Ao, sum(semptembre) as S, sum(Octobre) as O, sum(Novembre) as N, sum(Decembre) as D, count(distinct(Affilier)) as AF, sum(Janvier+Fevrier+Mars+Avril+Mai+Juin+Juillet+Aout+semptembre+Octobre+Novembre+Decembre) as ST'))
                     ->where('factures.Partenaire', $request->Partenaire)
                     ->where('factures.Affilier', $request->Individu)
                     //->where('affiliers.Etat', '!=', 1)
                     ->where('factures.Etat', '!=', 2)
                     ->get();           
         foreach($comm as $com){
           $Commandes = Commande::whereFacture($com->id)->get();

            foreach ($Commandes as $Commande) 
            {  
               if (is_numeric($Commande->Propriete)) 
               {
                 $Comman = MedicamentPartenaire::wherePartenaireAndId($com->Partenaire,$Commande->Propriete)->first(); 
                 $AyaDrA.="
                 <ul><li>".$Comman->designation."</li></ul>";
               }else{
                  $AyaDrA.="
                 <ul><li>".$Commande->Propriete."</li></ul>"; 
               }   
            }
              
            $table.="
                    <tr class='odd gradeX'>
                        <td>".$com->Code."</td>
                        <td>".$com->Nom.' '.$com->Prenom."</td>
                        <td>".$AyaDrA."</td>
                         <td>".number_format($com->J,0,',',' ')."</td>
                         <td>".number_format($com->F,0,',',' ')."</td>
                        <td>".number_format($com->M,0,',',' ')."</td>
                        <td>".number_format($com->A,0,',',' ')."</td>
                        <td>".number_format($com->Ma,0,',',' ')."</td>
                        <td>".number_format($com->Ju,0,',',' ')."</td>
                        <td>".number_format($com->Jui,0,',',' ')."</td>
                        <td>".number_format($com->Ao,0,',',' ')."</td>
                        <td>".number_format($com->S,0,',',' ')."</td>
                       <td>".number_format($com->O,0,',',' ')."</td>
                       <td>".number_format($com->N,0,',',' ')."</td>
                        <td>".number_format($com->D,0,',',' ')."</td>
                        <td>".number_format($com->ST,0,',',' ')."</td>
                    </tr>";
                    }
                       # code...
        }
        $tableListe=$table;
        $pdf = PDF::loadView('Factures.PdfCreateFactures', compact('tableListe', 'Somme', 'Partenaire', 'Origine', 'Individu', 'Debut', 'Fin', 'Consomation'))->setPaper('a3', 'Paysage');
         $fileName = 'Journal';
         return $pdf->stream($fileName . '.pdf');
        }
       }

        elseif (isset($request->Groupe) && !empty($request->Groupe) && isset($request->Debut) && !empty($request->Debut) && isset($request->Debut) && !empty($request->Fin)) 
        {
         $Origine = Origine::findOrFail($request->Groupe);
         $Debut = $request->Debut; 
         $Fin = $request->Fin;   
        $NbreCot=Facture::where('Etat', '!=', 2)->count();
        $table="";
        if ($NbreCot > 0) {
         $comm = DB::table('factures')
                     ->join('affiliers', 'affiliers.id', '=', 'factures.Affilier')
                     ->select(DB::raw('sum(Janvier) as J,sum(Fevrier) as F, sum(Mars) as M, sum(Avril) as A, sum(Mai) as Ma, sum(Juin) as Ju, sum(Juillet) as Jui, sum(Aout) as Ao, sum(semptembre) as S, sum(Octobre) as O, sum(Novembre) as N, sum(Decembre) as D, Affilier, sum(Janvier+Fevrier+Mars+Avril+Mai+Juin+Juillet+Aout+semptembre+Octobre+Novembre+Decembre) as ST,affiliers.Code,affiliers.Nom,affiliers.Prenom,affiliers.id'))
                     ->whereOrigine($request->Groupe)
                     ->whereBetween('DateTraitement',[$request->Debut, $request->Fin])
                     ->where('factures.Etat', '!=', 2)
                     //->where('affiliers.Etat', '!=', 1)
                     ->groupBy('Affilier')
                     ->get();

          $Somme = DB::table('factures')
                     ->join('affiliers', 'affiliers.id', '=', 'factures.Affilier')
                     ->select(DB::raw('sum(Janvier) as J,sum(Fevrier) as F, sum(Mars) as M, sum(Avril) as A, sum(Mai) as Ma, sum(Juin) as Ju, sum(Juillet) as Jui, sum(Aout) as Ao, sum(semptembre) as S, sum(Octobre) as O, sum(Novembre) as N, sum(Decembre) as D, count(distinct(Affilier)) as AF, sum(Janvier+Fevrier+Mars+Avril+Mai+Juin+Juillet+Aout+semptembre+Octobre+Novembre+Decembre) as ST'))
                     ->whereOrigine($request->Groupe)
                     ->whereBetween('DateTraitement',[$request->Debut, $request->Fin])
                     ->where('factures.Etat', '!=', 2)
                     //->where('affiliers.Etat', '!=', 1)
                     ->get();           
         foreach($comm as $com){
           $Commandes = Commande::whereFacture($com->id)->get();

            foreach ($Commandes as $Commande) 
            {  
               if (is_numeric($Commande->Propriete)) 
               {
                 $Comman = MedicamentPartenaire::wherePartenaireAndId($com->Partenaire,$Commande->Propriete)->first(); 
                 $AyaDrA.="
                 <ul><li>".$Comman->designation."</li></ul>";
               }else{
                  $AyaDrA.="
                 <ul><li>".$Commande->Propriete."</li></ul>"; 
               }   
            }
              
            $table.="
                    <tr class='odd gradeX'>
                        <td>".$com->Code."</td>
                        <td>".$com->Nom.' '.$com->Prenom."</td>
                        <td>".$AyaDrA."</td>
                         <td>".number_format($com->J,0,',',' ')."</td>
                         <td>".number_format($com->F,0,',',' ')."</td>
                        <td>".number_format($com->M,0,',',' ')."</td>
                        <td>".number_format($com->A,0,',',' ')."</td>
                        <td>".number_format($com->Ma,0,',',' ')."</td>
                        <td>".number_format($com->Ju,0,',',' ')."</td>
                        <td>".number_format($com->Jui,0,',',' ')."</td>
                        <td>".number_format($com->Ao,0,',',' ')."</td>
                        <td>".number_format($com->S,0,',',' ')."</td>
                       <td>".number_format($com->O,0,',',' ')."</td>
                       <td>".number_format($com->N,0,',',' ')."</td>
                        <td>".number_format($com->D,0,',',' ')."</td>
                        <td>".number_format($com->ST,0,',',' ')."</td>
                    </tr>";
                    }
                       # code...
        }
        $tableListe=$table;
        $pdf = PDF::loadView('Factures.PdfCreateFactures', compact('tableListe', 'Somme', 'Origine', 'Debut', 'Fin', 'Partenaire', 'Individu', 'Consomation'))->setPaper('a3', 'Paysage');
         $fileName = 'Journal';
         return $pdf->stream($fileName . '.pdf');

        }
        elseif (isset($request->Individu) && !empty($request->Individu) && isset($request->Debut) && !empty($request->Debut) && isset($request->Debut) && !empty($request->Fin)) 
        {
        $Individu = Affilier::findOrFail($request->Individu);
         $Debut = $request->Debut; 
         $Fin = $request->Fin;   
        $NbreCot=Facture::where('Etat', '!=', 2)->count();
        $table="";
        if ($NbreCot > 0) {
         $comm = DB::table('factures')
                      ->join('affiliers', 'affiliers.id', '=', 'factures.Affilier')
                     ->select(DB::raw('sum(Janvier) as J,sum(Fevrier) as F, sum(Mars) as M, sum(Avril) as A, sum(Mai) as Ma, sum(Juin) as Ju, sum(Juillet) as Jui, sum(Aout) as Ao, sum(semptembre) as S, sum(Octobre) as O, sum(Novembre) as N, sum(Decembre) as D, Affilier, sum(Janvier+Fevrier+Mars+Avril+Mai+Juin+Juillet+Aout+semptembre+Octobre+Novembre+Decembre) as ST,affiliers.Code,affiliers.Nom,affiliers.Prenom,affiliers.Etat,factures.Etat,affiliers.id,factures.Partenaire'))
                     ->where('factures.Etat', '!=', 2)
                     //->where('affiliers.Etat', '!=', 1)
                     ->whereAffilier($request->Individu)
                     ->whereBetween('DateTraitement',[$request->Debut, $request->Fin])
                     ->groupBy('Affilier')
                     ->get();

          $Somme = DB::table('factures')
                     ->join('affiliers', 'affiliers.id', '=', 'factures.Affilier')
                     ->select(DB::raw('sum(Janvier) as J,sum(Fevrier) as F, sum(Mars) as M, sum(Avril) as A, sum(Mai) as Ma, sum(Juin) as Ju, sum(Juillet) as Jui, sum(Aout) as Ao, sum(semptembre) as S, sum(Octobre) as O, sum(Novembre) as N, sum(Decembre) as D, count(distinct(Affilier)) as AF, sum(Janvier+Fevrier+Mars+Avril+Mai+Juin+Juillet+Aout+semptembre+Octobre+Novembre+Decembre) as ST'))
                     ->where('factures.Etat', '!=', 2)
                     //->where('affiliers.Etat', '!=', 1)
                     ->whereAffilier($request->Individu)
                     ->whereBetween('DateTraitement',[$request->Debut, $request->Fin])
                     ->get();           
         foreach($comm as $com){
           $Commandes = Commande::whereFacture($com->id)->get();

            foreach ($Commandes as $Commande) 
            {  
               if (is_numeric($Commande->Propriete)) 
               {
                 $Comman = MedicamentPartenaire::wherePartenaireAndId($com->Partenaire,$Commande->Propriete)->first(); 
                 $AyaDrA.="
                 <ul><li>".$Comman->designation."</li></ul>";
               }else{
                  $AyaDrA.="
                 <ul><li>".$Commande->Propriete."</li></ul>"; 
               }   
            }
              
            $table.="
                    <tr class='odd gradeX'>
                        <td>".$com->Code."</td>
                        <td>".$com->Nom.' '.$com->Prenom."</td>
                        <td>".$AyaDrA."</td>
                         <td>".number_format($com->J,0,',',' ')."</td>
                         <td>".number_format($com->F,0,',',' ')."</td>
                        <td>".number_format($com->M,0,',',' ')."</td>
                        <td>".number_format($com->A,0,',',' ')."</td>
                        <td>".number_format($com->Ma,0,',',' ')."</td>
                        <td>".number_format($com->Ju,0,',',' ')."</td>
                        <td>".number_format($com->Jui,0,',',' ')."</td>
                        <td>".number_format($com->Ao,0,',',' ')."</td>
                        <td>".number_format($com->S,0,',',' ')."</td>
                       <td>".number_format($com->O,0,',',' ')."</td>
                       <td>".number_format($com->N,0,',',' ')."</td>
                        <td>".number_format($com->D,0,',',' ')."</td>
                        <td>".number_format($com->ST,0,',',' ')."</td>
                    </tr>";
                    }
                       # code...
        }
        $tableListe=$table;
        $pdf = PDF::loadView('Factures.PdfCreateFactures', compact('tableListe', 'Somme', 'Individu', 'Debut', 'Fin', 'Partenaire', 'Origine', 'Consomation'))->setPaper('a3', 'Paysage');
         $fileName = 'Journal';
         return $pdf->stream($fileName . '.pdf');

        }
      elseif (isset($request->Partenaire) && !empty($request->Partenaire) && isset($request->Debut) && !empty($request->Debut) && isset($request->Debut) && !empty($request->Fin)) 
        {
        $Partenaire = Partenaire::findOrFail($request->Partenaire);
        $Debut = $request->Debut; 
        $Fin = $request->Fin;   
        $NbreCot=Facture::where('Etat', '!=', 2)->count();
        $table="";
        if ($NbreCot > 0) {
         $comm = DB::table('factures')
                     ->join('affiliers', 'affiliers.id', '=', 'factures.Affilier')
                     ->select(DB::raw('sum(Janvier) as J,sum(Fevrier) as F, sum(Mars) as M, sum(Avril) as A, sum(Mai) as Ma, sum(Juin) as Ju, sum(Juillet) as Jui, sum(Aout) as Ao, sum(semptembre) as S, sum(Octobre) as O, sum(Novembre) as N, sum(Decembre) as D, Affilier, sum(Janvier+Fevrier+Mars+Avril+Mai+Juin+Juillet+Aout+semptembre+Octobre+Novembre+Decembre) as ST,affiliers.Code,affiliers.Nom,affiliers.Prenom,affiliers.Etat,factures.Etat,affiliers.id, factures.id as Fid, factures.Partenaire'))
                      ->where('factures.Etat', '!=', 2)
                     ->where('factures.Partenaire',$request->Partenaire)
                     ->whereBetween('factures.DateTraitement',[$request->Debut, $request->Fin])
                     ->groupBy('factures.Affilier')
                     ->get();

          $Somme = DB::table('factures')
                     ->join('affiliers', 'affiliers.id', '=', 'factures.Affilier')
                     ->join('partenaires', 'partenaires.id', '=', 'factures.Partenaire')
                     ->select(DB::raw('sum(Janvier) as J,sum(Fevrier) as F, sum(Mars) as M, sum(Avril) as A, sum(Mai) as Ma, sum(Juin) as Ju, sum(Juillet) as Jui, sum(Aout) as Ao, sum(semptembre) as S, sum(Octobre) as O, sum(Novembre) as N, sum(Decembre) as D, count(distinct(Affilier)) as AF, sum(Janvier+Fevrier+Mars+Avril+Mai+Juin+Juillet+Aout+semptembre+Octobre+Novembre+Decembre) as ST'))
                      ->where('factures.Etat', '!=', 2)
                     // ->where('affiliers.Etat', '!=', 1)
                     ->where('factures.Partenaire', $request->Partenaire)
                     ->whereBetween('factures.DateTraitement',[$request->Debut, $request->Fin])
                     ->get();           
         foreach($comm as $com){

           $Commandes = DB::table('commandes')
                    ->join('factures', 'factures.id', '=', 'commandes.Facture')
                    ->select(DB::raw('commandes.Propriete'))
                    ->where('commandes.Facture', $com->Fid)
                    ->where('factures.Affilier', $com->id)->get();

            foreach ($Commandes as $Commande) 
            {  
               if (is_numeric($Commande->Propriete)) 
               { 
                $ProprieteCasted = (int)$Commande->Propriete;
                 $Comman = MedicamentPartenaire::wherePartenaireAndId($com->Partenaire,$ProprieteCasted)->first(); 
                 if(is_null($Comman)){
                    $AyaDrA.="
                 <ul><li>".'MECINE NOT FOUND'."</li></ul>";
               }else{
                $AyaDrA.="
                 <ul><li>".$Comman->designation."</li></ul>";
                }
               }else{
                  $AyaDrA.="
                 <ul><li>".$Commande->Propriete."</li></ul>"; 
               }   
            }
              $TAyaDrA=$AyaDrA;
              $AyaDrA="";
              $table.="
                    <tr class='odd gradeX'>
                        <td>".$com->Code."</td>
                        <td>".$com->Nom.' '.$com->Prenom."</td>
                        <td>".$TAyaDrA."</td>
                        <td>".number_format($com->J,0,',',' ')."</td>
                        <td>".number_format($com->F,0,',',' ')."</td>
                        <td>".number_format($com->M,0,',',' ')."</td>
                        <td>".number_format($com->A,0,',',' ')."</td>
                        <td>".number_format($com->Ma,0,',',' ')."</td>
                        <td>".number_format($com->Ju,0,',',' ')."</td>
                        <td>".number_format($com->Jui,0,',',' ')."</td>
                        <td>".number_format($com->Ao,0,',',' ')."</td>
                        <td>".number_format($com->S,0,',',' ')."</td>
                        <td>".number_format($com->O,0,',',' ')."</td>
                        <td>".number_format($com->N,0,',',' ')."</td>
                        <td>".number_format($com->D,0,',',' ')."</td>
                        <td>".number_format($com->ST,0,',',' ')."</td>
                    </tr>";
                    }
                      # code...
        }
        $tableListe=$table;
        $pdf = PDF::loadView('Factures.PdfCreateFactures', compact('tableListe', 'Somme', 'Individu', 'Debut', 'Fin', 'Partenaire', 'Origine', 'Consomation'))->setPaper('a3', 'Paysage');
         $fileName = 'Journal';
         return $pdf->stream($fileName . '.pdf');
        }

        elseif (isset($request->Debut) && !empty($request->Debut) && isset($request->Fin) && !empty($request->Fin)) 
        {
        $Debut = $request->Debut; 
        $Fin = $request->Fin;   
        $NbreCot=Facture::where('Etat', '!=', 2)->count();
        $table="";
        if ($NbreCot > 0) {
         $comm = DB::table('factures')
                     ->join('affiliers', 'affiliers.id', '=', 'factures.Affilier')
                     ->select(DB::raw('sum(Janvier) as J,sum(Fevrier) as F, sum(Mars) as M, sum(Avril) as A, sum(Mai) as Ma, sum(Juin) as Ju, sum(Juillet) as Jui, sum(Aout) as Ao, sum(semptembre) as S, sum(Octobre) as O, sum(Novembre) as N, sum(Decembre) as D, Affilier, sum(Janvier+Fevrier+Mars+Avril+Mai+Juin+Juillet+Aout+semptembre+Octobre+Novembre+Decembre) as ST,affiliers.Code,affiliers.Nom,affiliers.Prenom,factures.Etat,affiliers.Etat,affiliers.id'))
                      ->where('factures.Etat', '!=', 2)
                      //->where('affiliers.Etat', '!=', 1)
                     ->whereBetween('DateTraitement',[$request->Debut, $request->Fin])
                     ->groupBy('Affilier')
                     ->get();

          $Somme = DB::table('factures')
                     ->join('affiliers', 'affiliers.id', '=', 'factures.Affilier')
                     ->select(DB::raw('sum(Janvier) as J,sum(Fevrier) as F, sum(Mars) as M, sum(Avril) as A, sum(Mai) as Ma, sum(Juin) as Ju, sum(Juillet) as Jui, sum(Aout) as Ao, sum(semptembre) as S, sum(Octobre) as O, sum(Novembre) as N, sum(Decembre) as D, count(distinct(Affilier)) as AF, sum(Janvier+Fevrier+Mars+Avril+Mai+Juin+Juillet+Aout+semptembre+Octobre+Novembre+Decembre) as ST'))
                      ->where('factures.Etat', '!=', 2)
                      //->where('affiliers.Etat', '!=', 1)
                     ->whereBetween('DateTraitement',[$request->Debut, $request->Fin])
                     ->get();           
         foreach($comm as $com){

            $Commandes = Commande::whereFacture($com->id)->get();

            foreach ($Commandes as $Commande) 
            {  
               if (is_numeric($Commande->Propriete)) 
               {
                 $Comman = MedicamentPartenaire::wherePartenaireAndId($com->Partenaire,$Commande->Propriete)->first(); 
                 $AyaDrA.="
                 <ul><li>".$Comman->designation."</li></ul>";
               }else{
                  $AyaDrA.="
                 <ul><li>".$Commande->Propriete."</li></ul>"; 
               }   
            }

            $table.="
                    <tr class='odd gradeX'>
                        <td>".$com->Code."</td>
                        <td>".$com->Nom.' '.$com->Prenom."</td>
                        <td>".$AyaDrA."</td>
                         <td>".number_format($com->J,0,',',' ')."</td>
                         <td>".number_format($com->F,0,',',' ')."</td>
                        <td>".number_format($com->M,0,',',' ')."</td>
                        <td>".number_format($com->A,0,',',' ')."</td>
                        <td>".number_format($com->Ma,0,',',' ')."</td>
                        <td>".number_format($com->Ju,0,',',' ')."</td>
                        <td>".number_format($com->Jui,0,',',' ')."</td>
                        <td>".number_format($com->Ao,0,',',' ')."</td>
                        <td>".number_format($com->S,0,',',' ')."</td>
                      <td>".number_format($com->O,0,',',' ')."</td>
                      <td>".number_format($com->N,0,',',' ')."</td>
                        <td>".number_format($com->D,0,',',' ')."</td>
                        <td>".number_format($com->ST,0,',',' ')."</td>
                    </tr>";
                    }
                      # code...
        }
        $tableListe=$table;
        $pdf = PDF::loadView('Factures.PdfCreateFactures', compact('tableListe', 'Somme', 'Debut', 'Fin', 'Partenaire', 'Origine', 'Individu', 'Consomation'))->setPaper('a3', 'Paysage');
         $fileName = 'Journal';
         return $pdf->stream($fileName . '.pdf');
        }
        elseif (isset($request->Individu) && !empty($request->Individu)) 
        {
        $Individu = Affilier::findOrFail($request->Individu);   
        $NbreCot=Facture::where('Etat','!=', 2)->where('Affilier', $request->Individu)->count();
        $table="";
        if ($NbreCot > 0) {
         $comm = DB::table('factures')
                     ->join('services', 'services.id', '=', 'factures.TypeTraitement')
                     ->join('affiliers', 'affiliers.id', '=', 'factures.Affilier')
                     ->select(DB::raw('sum(Janvier) as J,sum(Fevrier) as F, sum(Mars) as M, sum(Avril) as A, sum(Mai) as Ma, sum(Juin) as Ju, sum(Juillet) as Jui, sum(Aout) as Ao, sum(semptembre) as S, sum(Octobre) as O, sum(Novembre) as N, sum(Decembre) as D, Affilier,factures.Etat, sum(Janvier+Fevrier+Mars+Avril+Mai+Juin+Juillet+Aout+semptembre+Octobre+Novembre+Decembre) as ST,affiliers.Code,affiliers.Nom,affiliers.Prenom,affiliers.Etat,factures.id,services.service,factures.Partenaire,affiliers.id'))
                     ->where('factures.Etat', '!=', 2)
                     //->where('affiliers.Etat', '!=', 1)
                     ->whereAffilier($request->Individu)
                     ->get();

          $Somme = DB::table('factures')
                     ->join('affiliers', 'affiliers.id', '=', 'factures.Affilier')
                     ->select(DB::raw('sum(Janvier) as J,sum(Fevrier) as F, sum(Mars) as M, sum(Avril) as A, sum(Mai) as Ma, sum(Juin) as Ju, sum(Juillet) as Jui, sum(Aout) as Ao, sum(semptembre) as S, sum(Octobre) as O, sum(Novembre) as N, sum(Decembre) as D, count(distinct(Affilier)) as AF,sum(Janvier+Fevrier+Mars+Avril+Mai+Juin+Juillet+Aout+semptembre+Octobre+Novembre+Decembre) as ST,affiliers.Etat,factures.Etat'))
                      ->where('factures.Etat', '!=', 2)
                      //->where('affiliers.Etat', '!=', 1)
                     ->whereAffilier($request->Individu)
                     ->get();           
         foreach($comm as $com){

           $Commandes = Commande::whereFacture($com->id)->get();

            foreach ($Commandes as $Commande) 
            {  
               if (is_numeric($Commande->Propriete)) 
               {
                 $Comman = MedicamentPartenaire::wherePartenaireAndId($com->Partenaire,$Commande->Propriete)->first(); 
                 $AyaDrA.="
                 <ul><li>".$Comman->designation."</li></ul>";
               }else{
                  $AyaDrA.="
                 <ul><li>".$Commande->Propriete."</li></ul>"; 
               }   
            }
            $table.="
                    <tr class='odd gradeX'>
                        <td>".$com->Code."</td>
                        <td>".$com->Nom.' '.$com->Prenom."</td>
                        <td>".$AyaDrA."</td>
                        <td>".number_format($com->J,0,',',' ')."</td>
                        <td>".number_format($com->F,0,',',' ')."</td>
                        <td>".number_format($com->M,0,',',' ')."</td>
                        <td>".number_format($com->A,0,',',' ')."</td>
                        <td>".number_format($com->Ma,0,',',' ')."</td>
                        <td>".number_format($com->Ju,0,',',' ')."</td>
                        <td>".number_format($com->Jui,0,',',' ')."</td>
                        <td>".number_format($com->Ao,0,',',' ')."</td>
                        <td>".number_format($com->S,0,',',' ')."</td>
                       <td>".number_format($com->O,0,',',' ')."</td>
                       <td>".number_format($com->N,0,',',' ')."</td>
                        <td>".number_format($com->D,0,',',' ')."</td>
                        <td>".number_format($com->ST,0,',',' ')."</td>
                    </tr>";
                    }
                       # code...
        }
        $tableListe=$table;
        $pdf = PDF::loadView('Factures.PdfCreateFactures', compact('tableListe', 'Somme', 'Individu', 'Partenaire', 'Origine', 'Fin', 'Debut', 'Consomation'))->setPaper('a3', 'Paysage');
         $fileName = 'Journal';
         return $pdf->stream($fileName . '.pdf');
        }
        elseif (isset($request->Groupe) && !empty($request->Groupe)) 
        {
        $Origine = Origine::findOrFail($request->Groupe);
        $NbreCot = DB::table('factures')
                     ->join('affiliers', 'affiliers.id', '=', 'factures.Affilier')
                     ->select(DB::raw('sum(factures.id) as NbreCot, Origine'))
                      ->where('affiliers.Origine', $request->Groupe)
                      ->where('factures.Etat', '!=', 2)
                     ->get();
                       
        $table="";

      foreach ($NbreCot as $Nbre) 
      {      
        if($Nbre->NbreCot > 0) {
         $comm = DB::table('factures')
                     ->join('affiliers', 'affiliers.id', '=', 'factures.Affilier')
                     ->select(DB::raw('sum(Janvier) as J,sum(Fevrier) as F, sum(Mars) as M, sum(Avril) as A, sum(Mai) as Ma, sum(Juin) as Ju, sum(Juillet) as Jui, sum(Aout) as Ao, sum(semptembre) as S, sum(Octobre) as O, sum(Novembre) as N, sum(Decembre) as D, Affilier, sum(Janvier+Fevrier+Mars+Avril+Mai+Juin+Juillet+Aout+semptembre+Octobre+Novembre+Decembre) as ST,affiliers.Code,affiliers.Nom,affiliers.Prenom,affiliers.id'))
                      ->whereOrigine($request->Groupe)
                      //->where('affiliers.Etat', '!=', 1)
                      ->where('factures.Etat', '!=', 2)
                     ->get();

          $Somme = DB::table('factures')
                     ->join('affiliers', 'affiliers.id', '=', 'factures.Affilier')
                     ->select(DB::raw('sum(Janvier) as J,sum(Fevrier) as F, sum(Mars) as M, sum(Avril) as A, sum(Mai) as Ma, sum(Juin) as Ju, sum(Juillet) as Jui, sum(Aout) as Ao, sum(semptembre) as S, sum(Octobre) as O, sum(Novembre) as N, sum(Decembre) as D, count(distinct(Affilier)) as AF, sum(Janvier+Fevrier+Mars+Avril+Mai+Juin+Juillet+Aout+semptembre+Octobre+Novembre+Decembre) as ST'))
                      ->whereOrigine($request->Groupe)
                      //->where('affiliers.Etat', '!=', 1)
                      ->where('factures.Etat', '!=', 2)
                      ->get();           
         foreach($comm as $com){
           $Commandes = Commande::whereFacture($com->id)->get();

            foreach ($Commandes as $Commande) 
            {  
               if (is_numeric($Commande->Propriete)) 
               {
                 $Comman = MedicamentPartenaire::wherePartenaireAndId($com->Partenaire,$Commande->Propriete)->first(); 
                 $AyaDrA.="
                 <ul><li>".$Comman->designation."</li></ul>";
               }else{
                  $AyaDrA.="
                 <ul><li>".$Commande->Propriete."</li></ul>"; 
               }   
            }
              
            $table.="
                    <tr class='odd gradeX'>
                        <td>".$com->Code."</td>
                        <td>".$com->Nom.' '.$com->Prenom."</td>
                        <td>".$AyaDrA."</td>
                         <td>".number_format($com->J,0,',',' ')."</td>
                         <td>".number_format($com->F,0,',',' ')."</td>
                        <td>".number_format($com->M,0,',',' ')."</td>
                        <td>".number_format($com->A,0,',',' ')."</td>
                        <td>".number_format($com->Ma,0,',',' ')."</td>
                        <td>".number_format($com->Ju,0,',',' ')."</td>
                        <td>".number_format($com->Jui,0,',',' ')."</td>
                        <td>".number_format($com->Ao,0,',',' ')."</td>
                        <td>".number_format($com->S,0,',',' ')."</td>
                      <td>".number_format($com->O,0,',',' ')."</td>
                      <td>".number_format($com->N,0,',',' ')."</td>
                        <td>".number_format($com->D,0,',',' ')."</td>
                        <td>".number_format($com->ST,0,',',' ')."</td>
                    </tr>";
                    }
                      # code...
        }
        $tableListe=$table;
        $pdf = PDF::loadView('Factures.PdfCreateFactures', compact('tableListe', 'Somme', 'Origine', 'Individu', 'Partenaire', 'Debut', 'Fin', 'Consomation'))->setPaper('a3', 'Paysage');
         $fileName = 'Journal';
         return $pdf->stream($fileName . '.pdf');
        }
        } 
        elseif (isset($request->Partenaire) && !empty($request->Partenaire)) 
        {
        $Partenaire = Partenaire::findOrFail($request->Partenaire);   
        $NbreCot = DB::table('factures')
                     ->join('affiliers', 'affiliers.id', '=', 'factures.Affilier')
                     ->select(DB::raw('count(factures.id) as NbreCot, Partenaire, Affilier'))
                      ->where('factures.Partenaire', $request->Partenaire)
                      ->where('factures.Etat', '!=', 2)
                     ->get();
                       
        $table="";

      foreach ($NbreCot as $Nbre) 
      {      
        if ($Nbre->NbreCot > 0) {
         $comm = DB::table('factures')
                     ->join('affiliers', 'affiliers.id', '=', 'factures.Affilier')
                     ->join('partenaires', 'partenaires.id', '=', 'factures.Partenaire')
                     ->select(DB::raw('sum(Janvier) as J,sum(Fevrier) as F, sum(Mars) as M, sum(Avril) as A, sum(Mai) as Ma, sum(Juin) as Ju, sum(Juillet) as Jui, sum(Aout) as Ao, sum(semptembre) as S, sum(Octobre) as O, sum(Novembre) as N, sum(Decembre) as D, Affilier, sum(Janvier+Fevrier+Mars+Avril+Mai+Juin+Juillet+Aout+semptembre+Octobre+Novembre+Decembre) as ST, affiliers.Nom, affiliers.Prenom,affiliers.Code,factures.Partenaire,affiliers.id'))
                      ->where('factures.Partenaire', $request->Partenaire)
                      ->where('factures.Etat', '!=', 2)
                      //->where('affiliers.Etat', '!=', 1)
                      ->groupBy('Affilier')
                     ->get();

          $Somme = DB::table('factures')
                     ->join('affiliers', 'affiliers.id', '=', 'factures.Affilier')
                     ->join('partenaires', 'partenaires.id', '=', 'factures.Partenaire')
                     ->select(DB::raw('sum(Janvier) as J,sum(Fevrier) as F, sum(Mars) as M, sum(Avril) as A, sum(Mai) as Ma, sum(Juin) as Ju, sum(Juillet) as Jui, sum(Aout) as Ao, sum(semptembre) as S, sum(Octobre) as O, sum(Novembre) as N, sum(Decembre) as D, count(distinct(Affilier)) as AF, sum(Janvier+Fevrier+Mars+Avril+Mai+Juin+Juillet+Aout+semptembre+Octobre+Novembre+Decembre) as ST,factures.Partenaire'))
                      ->where('factures.Partenaire',$request->Partenaire)
                      ->where('factures.Etat', '!=', 2)
                      //->where('affiliers.Etat', '!=', 1)
                     ->get();           
         foreach($comm as $com){
           $Commandes = Commande::whereFacture($com->id)->get();

            foreach ($Commandes as $Commande) 
            {  
               if (is_numeric($Commande->Propriete)) 
               {
                 $Comman = MedicamentPartenaire::wherePartenaireAndId($com->Partenaire,$Commande->Propriete)->first(); 
                 $AyaDrA.="
                 <ul><li>".$Comman->designation."</li></ul>";
               }else{
                  $AyaDrA.="
                 <ul><li>".$Commande->Propriete."</li></ul>"; 
               }   
            }
            $table.="
                    <tr class='odd gradeX'>
                        <td>".$com->Code."</td>
                        <td>".$com->Nom.' '.$com->Prenom."</td>
                        <td>".$AyaDrA."</td>
                         <td>".number_format($com->J,0,',',' ')."</td>
                         <td>".number_format($com->F,0,',',' ')."</td>
                        <td>".number_format($com->M,0,',',' ')."</td>
                        <td>".number_format($com->A,0,',',' ')."</td>
                        <td>".number_format($com->Ma,0,',',' ')."</td>
                        <td>".number_format($com->Ju,0,',',' ')."</td>
                        <td>".number_format($com->Jui,0,',',' ')."</td>
                        <td>".number_format($com->Ao,0,',',' ')."</td>
                        <td>".number_format($com->S,0,',',' ')."</td>
                      <td>".number_format($com->O,0,',',' ')."</td>
                      <td>".number_format($com->N,0,',',' ')."</td>
                        <td>".number_format($com->D,0,',',' ')."</td>
                        <td>".number_format($com->ST,0,',',' ')."</td>
                    </tr>";
                    }
                      # code...
        }
        $tableListe=$table;
        $pdf = PDF::loadView('Factures.PdfCreateFactures', compact('tableListe', 'Somme', 'Partenaire', 'Individu', 'Origine', 'Debut', 'Fin', 'Consomation'))->setPaper('a3', 'Paysage');
         $fileName = 'Journal';
         return $pdf->stream($fileName . '.pdf');
        }
      }
        }
        
        //Pour Imprimer La facture Chez le Partenaire
        public function PdfFacture($Facture)
        {   
            $Consomation = Consomation::findOrFail(1);
            $table = " ";
            $Fact = Facture::findOrFail($Facture);

            //Ajouter les separateur du millier
            $ComptantAffilier = number_format($Fact->ComptantAffilier,2,',',' '); 

            $SAAT = number_format($Fact->SAAT,2,',',' ');

             $Montant = number_format($Fact->Montant,2,',',' '); 
            $NCommande = Commande::whereEtatAndFacture(0,$Facture)->count('id');


            $id_Affilier=$Fact->Affilier;
            $Affilier=Affilier::where('id',$id_Affilier)->first();
            $Origine=Origine::where('id',$Affilier->Origine)->first();
             $id_Beneficiaire=$Fact->Beneficiaire;
             $Beneficiaire=AyantDroit::where('id',$id_Beneficiaire)->first();

            $id_Partenaire=$Fact->Partenaire;
            $Partenaire=Partenaire::where('id',$id_Partenaire)->first();

            if ($NCommande>0)
            {
              $Commandes =DB::table('commandes')
              ->Leftjoin('medicament_partenaires', 'medicament_partenaires.id', '=', 'commandes.Propriete')
              ->select(DB::raw('commandes.Libelle,medicament_partenaires.designation as Medicament, commandes.PU, commandes.Qte, commandes.PT,commandes.Propriete')) 
              ->where('commandes.Etat',0)
              ->where('commandes.Facture', $Facture) 
              ->get(); 

            foreach($Commandes as $Commande){
            $id_Service = $Commande->Libelle;
            $Service = Service::findOrFail($id_Service);
            if ($Commande->Medicament=='') {
                 $table.="
                    <tr class='odd gradeX'>
                        <td>".$Service->service.'/'.$Commande->Propriete."</td>
                         <td>".$Commande->PU."</td>
                         <td>".$Commande->Qte."</td>
                        <td>".$Commande->PT."</td>
                    </tr>";
            }else{
                 $table.="
                    <tr class='odd gradeX'>
                        <td>".$Service->service.'/'.$Commande->Medicament."</td>
                         <td>".$Commande->PU."</td>
                         <td>".$Commande->Qte."</td>
                        <td>".$Commande->PT."</td>
                    </tr>";
             }        # code... 
            }
            }
         $tableListe=$table;
         
         $Service = Service::findOrFail($Fact->TypeTraitement);
         $pdf = PDF::loadView('Factures.PdfFacture', compact('tableListe', 'Affilier', 'Beneficiaire', 'Partenaire', 'Fact', 'ComptantAffilier', 'SAAT', 'Montant', 'Origine', 'Consomation', 'Service'))->setPaper('a5', 'Paysage');
         $fileName = 'Facture';
         return $pdf->stream($fileName . '.pdf');
        }

        public function research(Request $request){
        $Affilier=$request->get('affilie');
        $Affiliers=Affilier::where('Code','like','%'.$Affilier.'%')->where('Etat',0)->get();
        $allAffiliers="";
        foreach ($Affiliers as $Affilier) {
            $allAffiliers.="<option value='".$Affilier->id."'>".$Affilier->Code.'/'.$Affilier->Nom.'/'.$Affilier->Prenom."</option>";
        }
        echo $allAffiliers;
    }

    public function elaborer_facture(){
        $Facture = 56;
        $FactureDet = Facture::findOrFail($Facture);
        $NbreSejour = Commande::whereEtatAndFactureAndSejour(0,$Facture,1)->count('id'); 
        $Service = Service::findOrFail($FactureDet->TypeTraitement);
        $Services = DB::table('affilier_partenaires')
                     ->join('services', 'services.id', '=', 'affilier_partenaires.Service')
                     ->select(DB::raw('affilier_partenaires.Etat,affilier_partenaires.Affilier, affilier_partenaires.Partenaire,services.Traitement,services.service,services.id'))
                    ->where('affilier_partenaires.Etat',0)
                    ->where('affilier_partenaires.Affilier',$FactureDet->Affilier)
                    ->where('affilier_partenaires.Partenaire',$FactureDet->Partenaire)
                    ->where('services.id',$FactureDet->TypeTraitement)
                    ->get();
        
        $NbreCommande = Commande::whereEtatAndFacture(0,$Facture)->count('id');
        if ($NbreCommande>0) 
        {
          $MontantCommande = Commande::whereEtatAndFacture(0,$Facture)->sum('PT');
        }
        else
        {
          $MontantCommande =0;   
        }
        
        

        return view('Factures.elaborer_facture', compact('Facture', 'NbreCommande', 'MontantCommande', 'Services', 'FactureDet', 'NbreSejour', 'Service'));
    }
}
