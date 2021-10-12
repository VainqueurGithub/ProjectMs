<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Commande;
use App\Models\Facture;
use App\Models\Affilier;
use App\Models\Service;
use App\Models\AffilierPartenaire;
use App\Models\medicamentsservice;
use App\Models\MedicamentPartenaire;
use App\Interfaces\ICommande as ICommande;
use App\Interfaces\IFacture as IFacture;
use App\Interfaces\IAffilie as IAffilie;
use App\Interfaces\IService as IService;
use Illuminate\Support\Facades\DB;
class CommandeController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
       return view('Commandes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {     
        
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
        $Facture = Commande::findOrFail($id);
        $Facture = $Facture->Facture;
        $FactureDet = Facture::findOrFail($Facture);
        $Trait = Service::findOrFail($FactureDet->TypeTraitement);
        $Commande = Commande::findOrFail($id);
        $NbreMedi = MedicamentPartenaire::whereIdAndPartenaire($Commande->Propriete,$FactureDet->Partenaire)->count('id');
        if($NbreMedi > 0){
          $medicaments = MedicamentPartenaire::whereIdAndPartenaire($Commande->Propriete, $FactureDet->Partenaire)->first();
        }else{
          $medicaments = new MedicamentPartenaire;
        }
        $NbreSejour = Commande::whereEtatAndFactureAndSejour(0,$Facture,1)->count('id'); 
        $NbreCommande = Commande::whereEtatAndFacture(0,$Facture)->count('id');
        $Services = DB::table('affilier_partenaires')
                     ->join('services', 'services.id', '=', 'affilier_partenaires.Service')
                     ->select(DB::raw('affilier_partenaires.Etat,affilier_partenaires.Affilier, affilier_partenaires.Partenaire,services.Traitement,services.service,services.id'))
                    ->where('affilier_partenaires.Etat',0)
                    ->where('affilier_partenaires.Affilier',$FactureDet->Affilier)
                    ->where('affilier_partenaires.Partenaire',$FactureDet->Partenaire)
                    ->where('services.id',$FactureDet->TypeTraitement)
                    ->get();
        if ($NbreCommande>0) 
        {
          $MontantCommande = Commande::whereEtatAndFacture(0,$Facture)->sum('PT');
        }
        else
        {
          $MontantCommande =0;   
        }
        return view('Commandes.edit', compact('NbreCommande', 'MontantCommande', 'Facture', 'Commande', 'Services', 'NbreSejour', 'FactureDet', 'medicaments','Trait'));
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
       $Facture = $request->Facture;
       $Details = Facture::findOrFail($Facture);
       $PU = MedicamentPartenaire::whereMedicamentAndPartenaire($request->Propriete, $Details->Partenaire)->first();
       if($PU == null){
         $PU = MedicamentPartenaire::whereIdAndPartenaire($request->Propriete, $Details->Partenaire)->first();
       }
          

        $this->validate($request, [
        'Facture' => 'required', 
        'Libelle' => 'required',
        'Propriete'=>'required'
        ]);
        $Commande = Commande::findOrFail($id);
         $Commande->update([
            'Facture' => $request->Facture,
            'Libelle' => $request->Libelle,
            'PU' => $PU->prix,
            'Qte' => $request->Quantite,
            'Sejour' => $request->Sejour,
            'Propriete' => $request->Propriete,
            'PT' => $request->Quantite*$PU->prix,
           ]);
             //On verifie si la facture possede au moins une command=> pour eviter les erreur  
             $NbreCommande = $this->Commande->NbreCommande($Facture);
             if ($NbreCommande>0) 
             { 
              //Dans le cas ou la facture possede une commande, on calcul le Montant Total
                $MontantCommande = $this->Commande->MontantCommande($Facture);
              //Detail de la facture=>on cherche a savoir le type de traitement de la facture  

                //$Fact = Facture::findOrFail($Facture);
                $Fact = $this->Facture->showData($Facture);

                //Detail de l'affilier=>on trouve le limites maternite

                $Affilier = $this->Affilier->showData($Fact->Affilier);

                //$Fact = Service::findOrFail($Fact->TypeTraitement);
                 $Fact = $this->Service->showData($Fact->TypeTraitement);


              //FX POUR CALCULER LES LIMITES

               $Response = $this->Commande->CalculLimite($Fact->Traitement, $MontantCommande, $Affilier, $Facture);

          }
          else
          {
            $MontantCommande =0;
            $ComptantAffilier=0;
            $SAAT=0;   
          }

            $Facture = $this->Facture->showData($Facture);

            $keywords = preg_split("/[\s,]+/", $Response);
            $SAAT = $keywords[0];
            $ComptantAffilier = $keywords[1];

           //ATTRIBUTION DE MONTANT ASSURANCE A UN MOIS X
            $this->Commande->Attributionamountmonth($Facture->Mois, $SAAT, $Facture, $id);
 
             $Facture->update([
            'Etat' => 1,
            'Montant' => $MontantCommande,
            'SAAT' => $SAAT,
            'ComptantAffilier' => $ComptantAffilier
              ]);
             return redirect(route('Factures.show', compact('Facture')));   
       }   

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $Facture = Commande::findOrFail($id);
         $Facture = $Facture->Facture;
        
         Commande::destroy($id);
         
              //On verifie si la facture possede au moins une command=> pour eviter les erreur  
             $NbreCommande = $this->Commande->NbreCommande($Facture);
             if ($NbreCommande>0) 
             { 
              //Dans le cas ou la facture possede une commande, on calcul le Montant Total
                $MontantCommande = $this->Commande->MontantCommande($Facture)->sum('PT');
              //Detail de la facture=>on cherche a savoir le type de traitement de la facture  

                //$Fact = Facture::findOrFail($Facture);
                $Fact = $this->Facture->showData($Facture);

                //Detail de l'affilier=>on trouve le limites maternite

                $Affilier = $this->Affilier->showData($Fact->Affilier);

                //$Fact = Service::findOrFail($Fact->TypeTraitement);
                 $Fact = $this->Service->showData($Fact->TypeTraitement);


              //FX POUR CALCULER LES LIMITES

               $Response = $this->Commande->CalculLimite($Fact->Traitement, $MontantCommande, $Affilier, $Facture); 
          }
          else
          {
            $MontantCommande =0;
            $ComptantAffilier=0;
            $SAAT=0;   
          }

            $Facture = $this->Facture->showData($Facture);
            $keywords = preg_split("/[\s,]+/", $Response);
            $SAAT = $keywords[0];
            $ComptantAffilier = $keywords[1];

           //ATTRIBUTION DE MONTANT ASSURANCE A UN MOIS X
            $this->Commande->Attributionamountmonth($Facture->Mois, $SAAT, $Facture, $id);
             $Facture->update([
            'Etat' => 1,
            'Montant' => $MontantCommande,
            'SAAT' => $SAAT,
            'ComptantAffilier' => $ComptantAffilier
              ]);
            return redirect(route('Factures.show', compact('Facture'))); 
    }

    public function Commandecreate($Facture)
    {  
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
        
        return view('Commandes.create', compact('Facture', 'NbreCommande', 'MontantCommande', 'Services', 'FactureDet', 'NbreSejour', 'Service')); 
  }
}
