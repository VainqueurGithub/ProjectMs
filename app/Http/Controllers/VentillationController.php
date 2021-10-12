<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Facture;
use App\Models\Affilier;
use App\Models\AyantDroit;
use App\Models\Partenaire;
use App\Models\Cotisation;
use App\Models\Consomation;
use App\Models\Origine;
use Illuminate\Support\Facades\DB;
use PDF;
class VentillationController extends Controller
{   
    public function VentillationGeneral()
    {           
        $Affiliers = Affilier::all();
        $Factures = Facture::where('Etat', '!=', 2)->groupBy('Affilier')->get()
        ;
        $NbreFacture=Facture::where('Etat', '!=', 2)->count();
        $NbreCotisation=Cotisation::where('Etat', '=', 0)->count();
        $table="";
        $Somme = [];
        //if ($NbreFacture > 0 OR $NbreCotisation > 0) {
          $Somme = DB::table('factures')
                     ->select(DB::raw('sum(factures.Janvier) as J,sum(factures.Fevrier) as F, sum(factures.Mars) as M, sum(factures.Avril) as A, sum(factures.Mai) as Ma, sum(factures.Juin) as Ju, sum(factures.Juillet) as Jui, sum(factures.Aout) as Ao, sum(factures.semptembre) as S, sum(factures.Octobre) as O, sum(factures.Novembre) as N, sum(factures.Decembre) as D, count(distinct(factures.Affilier)) as AF, sum(factures.Janvier+factures.Fevrier+factures.Mars+factures.Avril+factures.Mai+factures.Juin+factures.Juillet+factures.Aout+factures.semptembre+factures.Octobre+factures.Novembre+factures.Decembre) as ST'))
                     ->where('factures.Etat','!=',2)
                     ->get();
         
         $EcartT=0;
         $TCot = 0;
         $Affiliers = Affilier::all();
         $NbreAff = Affilier::where('Etat', '!=', 2)->count('id'); 

         foreach($Affiliers as $Aff){
            $NbreAyD = AyantDroit::whereEtatAndAffilier(0,$Aff->id)->where('Lien', '!=', 'Lui meme')->count('id');

            $NbreAyDTS =DB::table('ayant_droits')
                       ->join('affiliers', 'affiliers.id', '=', 'ayant_droits.Affilier') 
                       ->select(DB::raw('count(ayant_droits.id) as NbreAyDT'))
                       ->where('ayant_droits.Etat', '=', 0)
                       ->where('affiliers.Etat', '!=', 2)
                       ->where('ayant_droits.Lien', '!=', 'Lui meme')
                       ->get();


            $id_Affilier=$Aff->id;
            $Affilier=Affilier::where('id',$id_Affilier)->first();
            $comm = DB::table('factures')
                     ->select(DB::raw('sum(factures.Janvier) as J,sum(factures.Fevrier) as F, sum(factures.Mars) as M, sum(factures.Avril) as A, sum(factures.Mai) as Ma, sum(factures.Juin) as Ju, sum(factures.Juillet) as Jui, sum(factures.Aout) as Ao, sum(factures.semptembre) as S, sum(factures.Octobre) as O, sum(factures.Novembre) as N, sum(factures.Decembre) as D, factures.Affilier, sum(factures.Janvier+factures.Fevrier+factures.Mars+factures.Avril+factures.Mai+factures.Juin+factures.Juillet+factures.Aout+factures.semptembre+factures.Octobre+factures.Novembre+factures.Decembre) as ST'))
                     ->where('factures.Etat','!=',2)
                     ->where('factures.Affilier',$Aff->id)
                     ->get();

            $cotis = DB::table('cotisations')
                     ->select(DB::raw('sum(Montant) as CS'))
                     ->where('cotisations.Etat',0)
                     ->where('cotisations.Affilier',$Aff->id)
                     ->get();         

            foreach ($comm as $com) 
            {
                foreach ($cotis as $coti) 
                {
                    $Ecart = $coti->CS-$com->ST;
                    $EcartT +=$Ecart;
                    $TCot += $coti->CS;

          if ($Aff->Etat==2) 
          {
               $table.="
                    <tr class='odd gradeX' style='color:red;'>
                        <td>".$Aff->Code."</td>
                        <td>".$Aff->Nom.' '.$Aff->Prenom."</td>
                        <td>".$NbreAyD."</td>
                         <td>".$com->J."</td>
                         <td>".$com->F."</td>
                        <td>".$com->M."</td>
                        <td>".$com->A."</td>
                        <td>".$com->Ma."</td>
                        <td>".$com->Ju."</td>
                        <td>".$com->Jui."</td>
                        <td>".$com->Ao."</td>
                        <td>".$com->S."</td>
                       <td>".$com->O."</td>
                       <td>".$com->N."</td>
                        <td>".$com->D."</td>
                        <td>".$coti->CS."</td>
                        <td>".$com->ST."</td>
                        <td>".$Ecart."</td>
                    </tr>";
          }
          else
          {
             $table.="
                    <tr class='odd gradeX'>
                        <td>".$Aff->Code."</td>
                        <td>".$Aff->Nom.' '.$Aff->Prenom."</td>
                        <td>".$NbreAyD."</td>
                         <td>".$com->J."</td>
                         <td>".$com->F."</td>
                        <td>".$com->M."</td>
                        <td>".$com->A."</td>
                        <td>".$com->Ma."</td>
                        <td>".$com->Ju."</td>
                        <td>".$com->Jui."</td>
                        <td>".$com->Ao."</td>
                        <td>".$com->S."</td>
                       <td>".$com->O."</td>
                       <td>".$com->N."</td>
                        <td>".$com->D."</td>
                        <td>".$coti->CS."</td>
                        <td>".$com->ST."</td>
                        <td>".$Ecart."</td>
                    </tr>";
          }
           
                    }
                   }
            }
        //}
        $tableListe=$table;
    	 return view('Ventillations/VentillationGeneral', compact('tableListe', 'Somme', 'EcartT', 'NbreAff', 'TCot', 'NbreAyDTS'));
    }

    public function VentillationIndividu(Request $request)
    {
        $Affiliers = Affilier::all();
        $Factures = Facture::where('Etat','!=',2)->groupBy('Affilier')->get()
        ;
        $NbreFacture=Facture::where('Etat','!=',2)->count();
        $NbreCotisation=Cotisation::where('Etat', '=', 0)->count();
        $table="";
        $Somme = [];
        //if ($NbreFacture > 0 OR $NbreCotisation > 0) {
          $Somme = DB::table('factures')
                     ->select(DB::raw('sum(factures.Janvier) as J,sum(factures.Fevrier) as F, sum(factures.Mars) as M, sum(factures.Avril) as A, sum(factures.Mai) as Ma, sum(factures.Juin) as Ju, sum(factures.Juillet) as Jui, sum(factures.Aout) as Ao, sum(factures.semptembre) as S, sum(factures.Octobre) as O, sum(factures.Novembre) as N, sum(factures.Decembre) as D, count(distinct(factures.Affilier)) as AF, sum(factures.Janvier+factures.Fevrier+factures.Mars+factures.Avril+factures.Mai+factures.Juin+factures.Juillet+factures.Aout+factures.semptembre+factures.Octobre+factures.Novembre+factures.Decembre) as ST'))
                     ->where('factures.Etat','!=',2)
                     ->get();
         
         $EcartT=0;
         $TCot=0;
         $Affiliers = Affilier::all();
         $NbreAff = Affilier::where('Etat', '!=', 2)->count('id'); 

         foreach($Affiliers as $Aff){

            $id_Affilier=$Aff->id;
            $Affilier=Affilier::where('id',$id_Affilier)->first();
            $comm = DB::table('factures')
                     ->select(DB::raw('sum(factures.Janvier) as J,sum(factures.Fevrier) as F, sum(factures.Mars) as M, sum(factures.Avril) as A, sum(factures.Mai) as Ma, sum(factures.Juin) as Ju, sum(factures.Juillet) as Jui, sum(factures.Aout) as Ao, sum(factures.semptembre) as S, sum(factures.Octobre) as O, sum(factures.Novembre) as N, sum(factures.Decembre) as D, factures.Affilier, sum(factures.Janvier+factures.Fevrier+factures.Mars+factures.Avril+factures.Mai+factures.Juin+factures.Juillet+factures.Aout+factures.semptembre+factures.Octobre+factures.Novembre+factures.Decembre) as ST'))
                     ->where('factures.Etat','!=',2)
                     ->where('factures.Affilier',$Aff->id)
                     ->get();

            $cotis = DB::table('cotisations')
                     ->select(DB::raw('sum(Montant) as CS'))
                     ->where('cotisations.Etat',0)
                     ->where('cotisations.Affilier',$Aff->id)
                     ->get();         

            foreach ($comm as $com) 
            {
                foreach ($cotis as $coti) 
                {
                    $Ecart = $coti->CS-$com->ST;
                    $EcartT +=$Ecart;
                    $TCot+=$coti->CS;
            
            if ($Aff->Etat==2) 
            {
                $table.="
                    <tr class='odd gradeX' style='color:red;'>
                       <td>".$Aff->Code."</td>
                        <td>".$Aff->Nom.' '.$Aff->Prenom."</td>
                         <td>".$com->J."</td>
                         <td>".$com->F."</td>
                        <td>".$com->M."</td>
                        <td>".$com->A."</td>
                        <td>".$com->Ma."</td>
                        <td>".$com->Ju."</td>
                        <td>".$com->Jui."</td>
                        <td>".$com->Ao."</td>
                        <td>".$com->S."</td>
                       <td>".$com->O."</td>
                       <td>".$com->N."</td>
                        <td>".$com->D."</td>
                        <td>".$coti->CS."</td>
                        <td>".$com->ST."</td>
                        <td>".$Ecart."</td>
                    </tr>";
            }
            else
            {
                 $table.="
                    <tr class='odd gradeX'>
                       <td>".$Aff->Code."</td>
                        <td>".$Aff->Nom.' '.$Aff->Prenom."</td>
                         <td>".$com->J."</td>
                         <td>".$com->F."</td>
                        <td>".$com->M."</td>
                        <td>".$com->A."</td>
                        <td>".$com->Ma."</td>
                        <td>".$com->Ju."</td>
                        <td>".$com->Jui."</td>
                        <td>".$com->Ao."</td>
                        <td>".$com->S."</td>
                       <td>".$com->O."</td>
                       <td>".$com->N."</td>
                        <td>".$com->D."</td>
                        <td>".$coti->CS."</td>
                        <td>".$com->ST."</td>
                        <td>".$Ecart."</td>
                    </tr>";
            }
                    }
                   }
            }
        //}
        $tableListe=$table;
         return view('Ventillations/VentillationIndividu', compact('tableListe', 'Somme', 'EcartT', 'NbreAff', 'Affiliers', 'TCot'));
         // return view('Ventillations/VentillationIndividu', compact('tableListe', 'Somme', 'Affiliers'));
        } 
    public function PdfCreateIndividu(Request $request)
    {   $Consomation = Consomation::findOrFail(1);
    	$Somme = [];
        $Ecart = 0;
        $TCot=0;
        $Montant =0;
        $Individu = Affilier::findOrFail($request->Individu);
        //Dans le Cas de La rechercher 
        if (isset($request->Individu) && !empty($request->Individu) && isset($request->Debut) && !empty($request->Debut) && isset($request->Fin) && !empty($request->Fin)) 
        {
        $Affiliers = Affilier::whereEtat(0)->get();
        $Factures = Facture::where('Etat','!=',2)->groupBy('Affilier')->get()
        ;
         $NbreFacture=Facture::where('Etat','!=',2)->count();
         $table="";

        $SumFact = Facture::whereEtatAndAffilier(1,$request->Individu)->sum('SAAT'); 
        $SumCot = Cotisation::whereEtatAndAffilier(0,$request->Individu)->sum('Montant');
         $comm = DB::table('factures')
                     ->select(DB::raw('*'))
                     ->where('Etat','!=',2)
                     ->whereAffilier($request->Individu)
                     ->whereBetween('DateTraitement',[$request->Debut, $request->Fin])
                     ->get();

           $cotis = DB::table('cotisations')
                     ->select(DB::raw('sum(Montant) as CS'))
                     ->where('cotisations.Etat',0)
                     ->where('cotisations.Affilier',$request->Individu)
                     ->get(); 
                            
          $Somme = DB::table('factures')
                     ->select(DB::raw('sum(Janvier) as J,sum(Fevrier) as F, sum(Mars) as M, sum(Avril) as A, sum(Mai) as Ma, sum(Juin) as Ju, sum(Juillet) as Jui, sum(Aout) as Ao, sum(semptembre) as S, sum(Octobre) as O, sum(Novembre) as N, sum(Decembre) as D, count(distinct(Affilier)) as AF, sum(Janvier+Fevrier+Mars+Avril+Mai+Juin+Juillet+Aout+semptembre+Octobre+Novembre+Decembre) as ST'))
                     ->where('Etat','!=',2)
                     ->whereAffilier($request->Individu)
                     ->whereBetween('DateTraitement',[$request->Debut, $request->Fin])
                     ->get();           
         foreach($comm as $com){

            $id_Affilier=$com->Affilier;
            $id_Droit=$com->Beneficiaire;
            $Affilier=Affilier::where('id',$id_Affilier)->first();
            $AyantDroit=AyantDroit::where('id',$id_Droit)->first();
            $Origine = Origine::findOrFail($Affilier->Origine);
            $Partenaire = Partenaire::findOrFail($com->Partenaire);
            

        foreach ($cotis as $coti) 
        {       
            $coti->CS-=$Montant;
            $Montant = $com->SAAT;
            $Ecart = $coti->CS-$Montant;
                           $table.="
                    <tr class='odd gradeX'>
                         <td>".$Affilier->Code."</td>
                         <td>".$com->DateTraitement."</td>
                        <td>".$Affilier->Nom.' '.$Affilier->Prenom."</td>
                         <td>".$AyantDroit->Nom.' '.$AyantDroit->Prenom."</td>
                         <td>".$Origine->Origine."</td>
                        <td>".$Affilier->DateEntree."</td>
                        <td>".$Affilier->CotisationM."</td>
                        <td>".$coti->CS."</td>
                        <td>".$com->SAAT."</td>
                        <td>".$Partenaire->Partenaire."</td>
                        <td>".$Ecart."</td>
                    </tr>"; 

            // $Ecart-=$com->SAAT;                                     # code...
        }        

                    }
        $tableListe=$table;
        $pdf = PDF::loadView('Ventillations.PdfCreateIndividu', compact('tableListe', 'Somme', 'Individu', 'Ecart', 'SumFact', 'SumCot', 'Consomation'))->setPaper('a3', 'Paysage');
         $fileName = 'Ventillation';
         return $pdf->stream($fileName . '.pdf');

        }
        elseif (isset($request->Individu) && !empty($request->Individu)) 
        {
         $Affiliers = Affilier::whereEtat(0)->get();
        $Factures = Facture::where('Etat','!=',2)->groupBy('Affilier')->get()
        ;

        $SumFact = Facture::whereEtatAndAffilier(1,$request->Individu)->sum('SAAT'); 
        $SumCot = Cotisation::whereEtatAndAffilier(0,$request->Individu)->sum('Montant');

         $NbreFacture=Facture::where('Etat','!=',2)->count();
         $table="";
         $comm = DB::table('factures')
                     ->select(DB::raw('*'))
                     ->where('Etat','!=',2)
                     ->whereAffilier($request->Individu)
                     ->get();

           $cotis = DB::table('cotisations')
                     ->select(DB::raw('sum(Montant) as CS'))
                     ->where('cotisations.Etat',0)
                     ->where('cotisations.Affilier',$request->Individu)
                     ->get(); 
                            
          $Somme = DB::table('factures')
                     ->select(DB::raw('sum(Janvier) as J,sum(Fevrier) as F, sum(Mars) as M, sum(Avril) as A, sum(Mai) as Ma, sum(Juin) as Ju, sum(Juillet) as Jui, sum(Aout) as Ao, sum(semptembre) as S, sum(Octobre) as O, sum(Novembre) as N, sum(Decembre) as D, count(distinct(Affilier)) as AF, sum(Janvier+Fevrier+Mars+Avril+Mai+Juin+Juillet+Aout+semptembre+Octobre+Novembre+Decembre) as ST'))
                     ->where('Etat','!=',2)
                     ->whereAffilier($request->Individu)
                     ->get();           
         foreach($comm as $com){

            $id_Affilier=$com->Affilier;
            $id_Droit=$com->Beneficiaire;
            $Affilier=Affilier::where('id',$id_Affilier)->first();
            $AyantDroit=AyantDroit::where('id',$id_Droit)->first();
            $Origine = Origine::findOrFail($Affilier->Origine);
            $Partenaire = Partenaire::findOrFail($com->Partenaire);
        

        foreach ($cotis as $coti) 
        {       
            $coti->CS-=$Montant;
            $Montant = $com->SAAT;
            $Ecart = $coti->CS-$Montant;
                           $table.="
                    <tr class='odd gradeX'>
                         <td>".$Affilier->Code."</td>
                         <td>".$com->DateTraitement."</td>
                        <td>".$Affilier->Nom.' '.$Affilier->Prenom."</td>
                         <td>".$AyantDroit->Nom.' '.$AyantDroit->Prenom."</td>
                         <td>".$Origine->Origine."</td>
                        <td>".$Affilier->DateEntree."</td>
                        <td>".$Affilier->CotisationM."</td>
                        <td>".$coti->CS."</td>
                        <td>".$com->SAAT."</td>
                        <td>".$Partenaire->Partenaire."</td>
                        <td>".$Ecart."</td>
                    </tr>"; 

             //$Ecart-=$com->Montant;                                     # code...
        }        

                    }
        $tableListe=$table;
        $pdf = PDF::loadView('Ventillations.PdfCreateIndividu', compact('tableListe', 'Somme', 'Individu', 'Ecart', 'SumFact', 'SumCot', 'Consomation'))->setPaper('a3', 'Paysage');
         $fileName = 'Ventillation';
         return $pdf->stream($fileName . '.pdf');
        }
        //Dans le Cas Contraire
        else
        {
        $Affiliers = Affilier::whereEtat(0)->get();
        $Factures = Facture::where('Etat','!=',2)->groupBy('Affilier')->get()
        ;
         $NbreFacture=Facture::where('Etat','!=',2)->count();
        $table="";
        
        if ($NbreFacture > 0) {
         $comm = DB::table('factures')
                     ->select(DB::raw('sum(Janvier) as J,sum(Fevrier) as F, sum(Mars) as M, sum(Avril) as A, sum(Mai) as Ma, sum(Juin) as Ju, sum(Juillet) as Jui, sum(Aout) as Ao, sum(semptembre) as S, sum(Octobre) as O, sum(Novembre) as N, sum(Decembre) as D, Affilier, sum(Janvier+Fevrier+Mars+Avril+Mai+Juin+Juillet+Aout+semptembre+Octobre+Novembre+Decembre) as ST'))
                     ->where('Etat','!=',2)
                     ->groupBy('Affilier')
                     ->get();

          $Somme = DB::table('factures')
                     ->select(DB::raw('sum(Janvier) as J,sum(Fevrier) as F, sum(Mars) as M, sum(Avril) as A, sum(Mai) as Ma, sum(Juin) as Ju, sum(Juillet) as Jui, sum(Aout) as Ao, sum(semptembre) as S, sum(Octobre) as O, sum(Novembre) as N, sum(Decembre) as D, count(distinct(Affilier)) as AF, sum(Janvier+Fevrier+Mars+Avril+Mai+Juin+Juillet+Aout+semptembre+Octobre+Novembre+Decembre) as ST'))
                     ->where('Etat','!=',2)
                     ->get();           
         foreach($comm as $com){

            $id_Affilier=$com->Affilier;
            $Affilier=Affilier::where('id',$id_Affilier)->first();

            $table.="
                    <tr class='odd gradeX'>
                        <td>".$Affilier->Nom.' '.$Affilier->Prenom."</td>
                         <td>".$com->J."</td>
                         <td>".$com->F."</td>
                        <td>".$com->M."</td>
                        <td>".$com->A."</td>
                        <td>".$com->Ma."</td>
                        <td>".$com->Ju."</td>
                        <td>".$com->Jui."</td>
                        <td>".$com->Ao."</td>
                        <td>".$com->S."</td>
                       <td>".$com->O."</td>
                       <td>".$com->N."</td>
                        <td>".$com->D."</td>
                        <td>".$com->ST."</td>
                        <td>".$com->ST."</td>
                    </tr>";
                    }     
        }
        $tableListe=$table;
         $pdf = PDF::loadView('Ventillations.PdfCreateIndividu', compact('tableListe', 'Somme', 'Individu', 'Consomation'))->setPaper('a3', 'Paysage');
         $fileName = 'Ventillation';
         return $pdf->stream($fileName . '.pdf');
        }
    }


    public function VentillationGroupe()
    {    
    	$Somme = [];
         $EcartT =0;
         $TCot=0;
        $Groupes = Origine::all();
        $Factures = Facture::where('Etat','!=',2)->groupBy('Affilier')->get()
        ;
         $NbreFacture=Facture::where('Etat','!=',2)->count();
         $NbreCotisation=Cotisation::where('Etat', '=', 0)->count();
        $table="";
        
        //if ($NbreFacture > 0 OR $NbreCotisation > 0) {
          $Somme = DB::table('factures')
                    ->join('affiliers', 'affiliers.id', '=', 'factures.Affilier')
                     ->select(DB::raw('sum(Janvier) as J,sum(Fevrier) as F, sum(Mars) as M, sum(Avril) as A, sum(Mai) as Ma, sum(Juin) as Ju, sum(Juillet) as Jui, sum(Aout) as Ao, sum(semptembre) as S, sum(Octobre) as O, sum(Novembre) as N, sum(Decembre) as D, count(distinct(Affilier)) as AF, sum(Janvier+Fevrier+Mars+Avril+Mai+Juin+Juillet+Aout+semptembre+Octobre+Novembre+Decembre) as ST'))
                     ->where('factures.Etat','!=',2)
                     ->where('affiliers.Etat',0)
                     ->get();

         $Origines=Origine::all(); 
         $NbreOri = Origine::all()->count('id');                     
         foreach($Origines as $Origine){
             
        //  $NbreAyD = AyantDroit::whereEtatAndAffilier(0,$Aff->id)->where('Lien', '!=', 'Lui meme')->count('id');
        // $NbreAyDT = AyantDroit::whereEtat(0)->where('Lien', '!=', 'Lui meme')->count('id');
        
         $NbreAyD = DB::table('origines')
                     ->join('affiliers', 'affiliers.Origine', '=', 'origines.id')
                     ->join('ayant_droits', 'ayant_droits.Affilier', '=', 'affiliers.id')
                     ->select(DB::raw('count(ayant_droits.id) as N'))
                     ->where('affiliers.Origine','=',$Origine->id)
                     ->where('affiliers.Etat',0)
                     ->where('ayant_droits.Etat',0)
                     //->where('origines.Etat',0)
                     ->where('Lien', '!=', 'Lui meme')
                     ->get();
                     
        $NbreAyDT = DB::table('origines')
                     ->join('affiliers', 'affiliers.Origine', '=', 'origines.id')
                     ->join('ayant_droits', 'ayant_droits.Affilier', '=', 'affiliers.id')
                     ->select(DB::raw('count(ayant_droits.id) as N'))
                     ->where('affiliers.Etat','!=',2)
                     ->where('ayant_droits.Etat',0)
                    // ->where('origines.Etat',0)
                     ->where('Lien', '!=', 'Lui meme')
                     ->get();

         $comm = DB::table('factures')
                     ->join('affiliers', 'affiliers.id', '=', 'factures.Affilier')
                     ->select(DB::raw('sum(Janvier) as J,sum(Fevrier) as F, sum(Mars) as M, sum(Avril) as A, sum(Mai) as Ma, sum(Juin) as Ju, sum(Juillet) as Jui, sum(Aout) as Ao, sum(semptembre) as S, sum(Octobre) as O, sum(Novembre) as N, sum(Decembre) as D, Affilier,Origine, sum(Janvier+Fevrier+Mars+Avril+Mai+Juin+Juillet+Aout+semptembre+Octobre+Novembre+Decembre) as ST'))
                     ->where('factures.Etat','!=',2)
                     ->where('affiliers.Etat',0)
                     ->where('Origine',$Origine->id)
                     ->get();

         $cotis = DB::table('cotisations')
                     ->join('affiliers', 'affiliers.id', '=', 'cotisations.Affilier')
                     ->select(DB::raw('sum(Montant) as CS'))
                     ->where('cotisations.Etat',0)
                     ->where('affiliers.Etat',0)
                      ->where('Origine',$Origine->id)
                     ->get();         
            

          foreach ($comm as $com) 
          { 
            foreach ($cotis as $coti) 
            {
              foreach($NbreAyD as $ND)
              {
                   $Ecart = $coti->CS-$com->ST;
              $EcartT +=$Ecart;
              $TCot+=$coti->CS;

              if ($Origine->Etat==2) 
              {
                  $table.="
                    <tr class='odd gradeX' style='color:red;'>
                        <td>".$Origine->Origine."</td>
                         <td>".$ND->N."</td>
                         <td>".$com->J."</td>
                         <td>".$com->F."</td>
                        <td>".$com->M."</td>
                        <td>".$com->A."</td>
                        <td>".$com->Ma."</td>
                        <td>".$com->Ju."</td>
                        <td>".$com->Jui."</td>
                        <td>".$com->Ao."</td>
                        <td>".$com->S."</td>
                       <td>".$com->O."</td>
                       <td>".$com->N."</td>
                        <td>".$com->D."</td>
                        <td>".$coti->CS."</td>
                        <td>".$com->ST."</td>
                        <td>".$Ecart."</td>
                    </tr>";
              }
              else
              {
                   $table.="
                    <tr class='odd gradeX'>
                        <td>".$Origine->Origine."</td>
                         <td>".$ND->N."</td>
                         <td>".$com->J."</td>
                         <td>".$com->F."</td>
                        <td>".$com->M."</td>
                        <td>".$com->A."</td>
                        <td>".$com->Ma."</td>
                        <td>".$com->Ju."</td>
                        <td>".$com->Jui."</td>
                        <td>".$com->Ao."</td>
                        <td>".$com->S."</td>
                       <td>".$com->O."</td>
                       <td>".$com->N."</td>
                        <td>".$com->D."</td>
                        <td>".$coti->CS."</td>
                        <td>".$com->ST."</td>
                        <td>".$Ecart."</td>
                    </tr>"; 
              }
            
              }
             
                    }
                }
             }          # code...
        //}
        $tableListe=$table;
         return view('Ventillations/VentillationGroupe', compact('tableListe', 'Somme', 'Groupes', 'EcartT', 'NbreOri', 'TCot', 'NbreAyDT'));
    }

    public function PdfVentillationGroupe()
    {  
        $Consomation = Consomation::findOrFail(1);
         $Somme = [];
         $EcartT =0;
         $TCot=0;
        $Groupes = DB::table('affiliers')
                  ->select(DB::raw('distinct(Origine)'))
                  ->whereEtat(0)
                  ->get(); 
        $Factures = Facture::where('Etat','!=',2)->groupBy('Affilier')->get()
        ;
         $NbreFacture=Facture::where('Etat','!=',2)->count();
        $table="";
        
        //if ($NbreFacture > 0) {
          $Somme = DB::table('factures')
                    ->join('affiliers', 'affiliers.id', '=', 'factures.Affilier')
                     ->select(DB::raw('sum(Janvier) as J,sum(Fevrier) as F, sum(Mars) as M, sum(Avril) as A, sum(Mai) as Ma, sum(Juin) as Ju, sum(Juillet) as Jui, sum(Aout) as Ao, sum(semptembre) as S, sum(Octobre) as O, sum(Novembre) as N, sum(Decembre) as D, count(distinct(Affilier)) as AF, sum(Janvier+Fevrier+Mars+Avril+Mai+Juin+Juillet+Aout+semptembre+Octobre+Novembre+Decembre) as ST'))
                     ->where('factures.Etat','!=', 2)
                     ->where('affiliers.Etat',0)
                     ->get();

         $Origines=Origine::all(); 
         $NbreOri = Origine::all()->count('id');                     
         foreach($Origines as $Origine){
         
        $NbreAyD = DB::table('origines')
                     ->join('affiliers', 'affiliers.Origine', '=', 'origines.id')
                     ->join('ayant_droits', 'ayant_droits.Affilier', '=', 'affiliers.id')
                     ->select(DB::raw('count(ayant_droits.id) as N'))
                     ->where('affiliers.Origine','=',$Origine->id)
                     ->where('affiliers.Etat',0)
                     ->where('ayant_droits.Etat',0)
                     ->where('origines.Etat',0)
                     ->where('Lien', '!=', 'Lui meme')
                     ->get();
                     
        $NbreAyDT = DB::table('origines')
                     ->join('affiliers', 'affiliers.Origine', '=', 'origines.id')
                     ->join('ayant_droits', 'ayant_droits.Affilier', '=', 'affiliers.id')
                     ->select(DB::raw('count(ayant_droits.id) as N'))
                     ->where('affiliers.Etat',0)
                     ->where('ayant_droits.Etat',0)
                     ->where('origines.Etat',0)
                     ->where('Lien', '!=', 'Lui meme')
                     ->get();
                     
         $comm = DB::table('factures')
                     ->join('affiliers', 'affiliers.id', '=', 'factures.Affilier')
                     ->select(DB::raw('sum(Janvier) as J,sum(Fevrier) as F, sum(Mars) as M, sum(Avril) as A, sum(Mai) as Ma, sum(Juin) as Ju, sum(Juillet) as Jui, sum(Aout) as Ao, sum(semptembre) as S, sum(Octobre) as O, sum(Novembre) as N, sum(Decembre) as D, Affilier,Origine, sum(Janvier+Fevrier+Mars+Avril+Mai+Juin+Juillet+Aout+semptembre+Octobre+Novembre+Decembre) as ST'))
                     ->where('factures.Etat','!=',2)
                     ->where('affiliers.Etat',0)
                     ->where('Origine',$Origine->id)
                     ->get();

         $cotis = DB::table('cotisations')
                     ->join('affiliers', 'affiliers.id', '=', 'cotisations.Affilier')
                     ->select(DB::raw('sum(Montant) as CS'))
                     ->where('cotisations.Etat',0)
                     ->where('affiliers.Etat',0)
                      ->where('Origine',$Origine->id)
                     ->get();         
            

          foreach ($comm as $com) 
          { 
            foreach ($cotis as $coti) 
            {
              foreach($NbreAyD as $ND)
              {
                  $Ecart = $coti->CS-$com->ST;
              $EcartT +=$Ecart;
              $TCot +=$coti->CS;

              if ($Origine->Etat==2) 
              {
                  $table.="
                    <tr class='odd gradeX' style='color:red;'>
                        <td>".$Origine->Origine."</td>
                         <td>".$ND->N."</td>
                         <td>".$com->J."</td>
                         <td>".$com->F."</td>
                        <td>".$com->M."</td>
                        <td>".$com->A."</td>
                        <td>".$com->Ma."</td>
                        <td>".$com->Ju."</td>
                        <td>".$com->Jui."</td>
                        <td>".$com->Ao."</td>
                        <td>".$com->S."</td>
                       <td>".$com->O."</td>
                       <td>".$com->N."</td>
                        <td>".$com->D."</td>
                        <td>".$coti->CS."</td>
                        <td>".$com->ST."</td>
                        <td>".$Ecart."</td>
                    </tr>";
              }
              else
              {
                $table.="
                    <tr class='odd gradeX'>
                        <td>".$Origine->Origine."</td>
                         <td>".$ND->N."</td>
                         <td>".$com->J."</td>
                         <td>".$com->F."</td>
                        <td>".$com->M."</td>
                        <td>".$com->A."</td>
                        <td>".$com->Ma."</td>
                        <td>".$com->Ju."</td>
                        <td>".$com->Jui."</td>
                        <td>".$com->Ao."</td>
                        <td>".$com->S."</td>
                       <td>".$com->O."</td>
                       <td>".$com->N."</td>
                        <td>".$com->D."</td>
                        <td>".$coti->CS."</td>
                        <td>".$com->ST."</td>
                        <td>".$Ecart."</td>
                    </tr>";
              }
            
              }
              
                    }
                }
             }          # code...
       // }
         $tableListe=$table;
         $pdf = PDF::loadView('Ventillations.PdfVentillationGroupe', compact('tableListe', 'Somme', 'EcartT', 'NbreOri', 'Groupes', 'TCot', 'Consomation', 'NbreAyDT'))->setPaper('a3', 'Paysage');
         $fileName = 'Ventillation';
         return $pdf->stream($fileName . '.pdf');
    }

        public function PdfCreateGroupe(Request $request)
        {
        $Consomation = Consomation::findOrFail(1);    
        $EcartT=0;
        $TCot=0;     
        $Somme = [];
        $Debut = $request->Debut;
        $Fin = $request->Fin;
        $Groupe = Origine::findOrFail($request->Groupe);
        $NbreFacture=Facture::where('Etat','!=',2)->count();
        $table="";

        if(isset($request->Groupe) && !empty($request->Groupe) && isset($request->Debut) && !empty($request->Debut) && isset($request->Fin) && !empty($request->Fin))
        {    
         $Somme = DB::table('factures')
                     ->join('affiliers', 'affiliers.id', '=', 'factures.Affilier')
                     ->select(DB::raw('sum(factures.Janvier) as J,sum(factures.Fevrier) as F, sum(factures.Mars) as M, sum(factures.Avril) as A, sum(factures.Mai) as Ma, sum(factures.Juin) as Ju, sum(factures.Juillet) as Jui, sum(factures.Aout) as Ao, sum(factures.semptembre) as S, sum(factures.Octobre) as O, sum(factures.Novembre) as N, sum(factures.Decembre) as D, count(distinct(factures.Affilier)) as AF, Origine, sum(factures.Janvier+factures.Fevrier+factures.Mars+factures.Avril+factures.Mai+factures.Juin+factures.Juillet+factures.Aout+factures.semptembre+factures.Octobre+factures.Novembre+factures.Decembre) as ST'))
                     ->where('factures.Etat','!=',2)
                     //->where('affiliers.Etat',0)
                     ->where('affiliers.Origine',$request->Groupe)
                     ->whereBetween('DateTraitement', [$Debut, $Fin])
                     ->get();
         
         
         $Affiliers = Affilier::whereOrigine($request->Groupe)->get(); 
         $NbreAff = Affilier::whereOrigine($request->Groupe)->count(); 
         $NbreAyDT=0;         
         foreach($Affiliers as $Aff){
             
            $NbreAyD = AyantDroit::whereEtatAndAffilier(0,$Aff->id)->where('Lien', '!=', 'Lui meme')->count('id');
            //$NbreAyDT = AyantDroit::whereEtat(0,$Aff->id)->where('Lien', '!=', 'Lui meme')->count('id'); 

            $id_Affilier=$Aff->id;
            $Affilier=Affilier::where('id',$id_Affilier)->first();
            $comm = DB::table('factures')
                     ->select(DB::raw('sum(factures.Janvier) as J,sum(factures.Fevrier) as F, sum(factures.Mars) as M, sum(factures.Avril) as A, sum(factures.Mai) as Ma, sum(factures.Juin) as Ju, sum(factures.Juillet) as Jui, sum(factures.Aout) as Ao, sum(factures.semptembre) as S, sum(factures.Octobre) as O, sum(factures.Novembre) as N, sum(factures.Decembre) as D, factures.Affilier, sum(factures.Janvier+factures.Fevrier+factures.Mars+factures.Avril+factures.Mai+factures.Juin+factures.Juillet+factures.Aout+factures.semptembre+factures.Octobre+factures.Novembre+factures.Decembre) as ST'))
                     ->where('factures.Etat','!=',2)
                     ->where('factures.Affilier',$Aff->id)
                     ->whereBetween('DateTraitement', [$Debut, $Fin])
                     ->get();

            $cotis = DB::table('cotisations')
                     ->select(DB::raw('sum(Montant) as CS'))
                     ->where('cotisations.Etat',0)
                     ->where('cotisations.Affilier',$Aff->id)
                     ->whereBetween('DateCreation', [$Debut, $Fin])
                     ->get();         

            foreach ($comm as $com) 
            {
                foreach ($cotis as $coti) 
                {
                    $Ecart = $coti->CS-$com->ST;
                    $EcartT +=$Ecart;
                    $TCot+=$coti->CS;
         if ($Affilier->Etat==2) 
         {
               $table.="
                    <tr class='odd gradeX' style='color:red;'>
                        <td>".$Aff->Nom.' '.$Aff->Prenom."</td>
                        <td>".$NbreAyD."</td>
                         <td>".$com->J."</td>
                         <td>".$com->F."</td>
                        <td>".$com->M."</td>
                        <td>".$com->A."</td>
                        <td>".$com->Ma."</td>
                        <td>".$com->Ju."</td>
                        <td>".$com->Jui."</td>
                        <td>".$com->Ao."</td>
                        <td>".$com->S."</td>
                       <td>".$com->O."</td>
                       <td>".$com->N."</td>
                        <td>".$com->D."</td>
                        <td>".$coti->CS."</td>
                        <td>".$com->ST."</td>
                        <td>".$Ecart."</td>
                    </tr>";
          }
          else
          {
               $table.="
                    <tr class='odd gradeX'>
                        <td>".$Aff->Nom.' '.$Aff->Prenom."</td>
                        <td>".$NbreAyD."</td>
                         <td>".$com->J."</td>
                         <td>".$com->F."</td>
                        <td>".$com->M."</td>
                        <td>".$com->A."</td>
                        <td>".$com->Ma."</td>
                        <td>".$com->Ju."</td>
                        <td>".$com->Jui."</td>
                        <td>".$com->Ao."</td>
                        <td>".$com->S."</td>
                       <td>".$com->O."</td>
                       <td>".$com->N."</td>
                        <td>".$com->D."</td>
                        <td>".$coti->CS."</td>
                        <td>".$com->ST."</td>
                        <td>".$Ecart."</td>
                    </tr>";
          } 
                    }
                   }
            }
            $NbreAyDT+=$NbreAyD;
        $tableListe=$table;
         $pdf = PDF::loadView('Ventillations.PdfCreateGroupe', compact('tableListe', 'Somme', 'Debut', 'Fin', 'NbreAff', 'EcartT', 'Groupe', 'TCot', 'Consomation', 'NbreAyDT', 'Debut', 'Fin'))->setPaper('a3', 'Paysage');
         $fileName = 'Ventillation';
         return $pdf->stream($fileName . '.pdf');  
        }
        elseif (isset($request->Groupe) && !empty($request->Groupe)) 
        {
            $Debut = '';
            $Fin = '';
        $Somme = DB::table('factures')
                     ->join('affiliers', 'affiliers.id', '=', 'factures.Affilier')
                     ->select(DB::raw('sum(factures.Janvier) as J,sum(factures.Fevrier) as F, sum(factures.Mars) as M, sum(factures.Avril) as A, sum(factures.Mai) as Ma, sum(factures.Juin) as Ju, sum(factures.Juillet) as Jui, sum(factures.Aout) as Ao, sum(factures.semptembre) as S, sum(factures.Octobre) as O, sum(factures.Novembre) as N, sum(factures.Decembre) as D, count(distinct(factures.Affilier)) as AF, Origine, sum(factures.Janvier+factures.Fevrier+factures.Mars+factures.Avril+factures.Mai+factures.Juin+factures.Juillet+factures.Aout+factures.semptembre+factures.Octobre+factures.Novembre+factures.Decembre) as ST'))
                     ->where('factures.Etat','!=',2)
                     //->where('affiliers.Etat',0)
                     ->where('affiliers.Origine',$request->Groupe)
                     ->get();
         
         $Affiliers = Affilier::whereOrigine($request->Groupe)->get(); 
         $NbreAff = Affilier::whereOrigine($request->Groupe)->count();   
         $NbreAyDT=0;       
         foreach($Affiliers as $Aff){
            
            $NbreAyD = AyantDroit::whereEtatAndAffilier($Aff->id)->where('Lien', '!=', 'Lui meme')->count('id');
            //$NbreAyDT = AyantDroit::whereEtat(0)->where('Lien', '!=', 'Lui meme')->count('id');
            
            $id_Affilier=$Aff->id;
            $Affilier=Affilier::where('id',$id_Affilier)->first();
            $comm = DB::table('factures')
                     ->select(DB::raw('sum(factures.Janvier) as J,sum(factures.Fevrier) as F, sum(factures.Mars) as M, sum(factures.Avril) as A, sum(factures.Mai) as Ma, sum(factures.Juin) as Ju, sum(factures.Juillet) as Jui, sum(factures.Aout) as Ao, sum(factures.semptembre) as S, sum(factures.Octobre) as O, sum(factures.Novembre) as N, sum(factures.Decembre) as D, factures.Affilier, sum(factures.Janvier+factures.Fevrier+factures.Mars+factures.Avril+factures.Mai+factures.Juin+factures.Juillet+factures.Aout+factures.semptembre+factures.Octobre+factures.Novembre+factures.Decembre) as ST'))
                     ->where('factures.Etat','!=',0)
                     ->where('factures.Affilier',$Aff->id)
                     ->get();

            $cotis = DB::table('cotisations')
                     ->select(DB::raw('sum(Montant) as CS'))
                     ->where('cotisations.Etat',0)
                     ->where('cotisations.Affilier',$Aff->id)
                     ->get();         

            foreach ($comm as $com) 
            {
                foreach ($cotis as $coti) 
                {
                    $Ecart = $coti->CS-$com->ST;
                    $EcartT +=$Ecart;
                    $TCot+=$coti->CS;
         if ($Affilier->Etat==2) 
         {
             $table.="
                    <tr class='odd gradeX' style='color:red;'>
                        <td>".$Aff->Nom.' '.$Aff->Prenom."</td>
                        <td>".$NbreAyD."</td>
                         <td>".$com->J."</td>
                         <td>".$com->F."</td>
                        <td>".$com->M."</td>
                        <td>".$com->A."</td>
                        <td>".$com->Ma."</td>
                        <td>".$com->Ju."</td>
                        <td>".$com->Jui."</td>
                        <td>".$com->Ao."</td>
                        <td>".$com->S."</td>
                       <td>".$com->O."</td>
                       <td>".$com->N."</td>
                        <td>".$com->D."</td>
                        <td>".$coti->CS."</td>
                        <td>".$com->ST."</td>
                        <td>".$Ecart."</td>
                    </tr>";
         }
         else
         {
            $table.="
                    <tr class='odd gradeX'>
                        <td>".$Aff->Nom.' '.$Aff->Prenom."</td>
                        <td>".$NbreAyD."</td>
                         <td>".$com->J."</td>
                         <td>".$com->F."</td>
                        <td>".$com->M."</td>
                        <td>".$com->A."</td>
                        <td>".$com->Ma."</td>
                        <td>".$com->Ju."</td>
                        <td>".$com->Jui."</td>
                        <td>".$com->Ao."</td>
                        <td>".$com->S."</td>
                       <td>".$com->O."</td>
                       <td>".$com->N."</td>
                        <td>".$com->D."</td>
                        <td>".$coti->CS."</td>
                        <td>".$com->ST."</td>
                        <td>".$Ecart."</td>
                    </tr>";
         }
                    }
                   }
            }
            $NbreAyDT+=$NbreAyD;
        $tableListe=$table;
         $pdf = PDF::loadView('Ventillations.PdfCreateGroupe', compact('tableListe', 'Somme', 'Debut', 'Fin', 'NbreAff', 'EcartT', 'Groupe', 'TCot', 'Consomation', 'NbreAyDT', 'Debut', 'Fin'))->setPaper('a3', 'Paysage');
         $fileName = 'Ventillation';
         return $pdf->stream($fileName . '.pdf');
        }
        //Dans le Cas Contraire
        elseif(isset($request->Debut) && !empty($request->Debut) && isset($request->Fin) && !empty($request->Fin))
        {
         $Somme = [];
         $EcartT =0;
         $Debut = $request->Debut;
         $Fin = $request->Fin;
         $Groupes = DB::table('Affiliers')
                  ->select(DB::raw('distinct(Origine)'))
                  //->whereEtat(0)
                  ->get(); 
           $Factures = Facture::where('Etat','!=',2)->groupBy('Affilier')->get();
           $NbreFacture=Facture::where('Etat','!=',2)->count();
           $table="";
        
        if ($NbreFacture > 0) {
          $Somme = DB::table('factures')
                    ->join('affiliers', 'affiliers.id', '=', 'factures.Affilier')
                     ->select(DB::raw('sum(Janvier) as J,sum(Fevrier) as F, sum(Mars) as M, sum(Avril) as A, sum(Mai) as Ma, sum(Juin) as Ju, sum(Juillet) as Jui, sum(Aout) as Ao, sum(semptembre) as S, sum(Octobre) as O, sum(Novembre) as N, sum(Decembre) as D, count(distinct(Affilier)) as AF, sum(Janvier+Fevrier+Mars+Avril+Mai+Juin+Juillet+Aout+semptembre+Octobre+Novembre+Decembre) as ST'))
                     ->where('factures.Etat','!=',2)
                    // ->where('affiliers.Etat',0)
                     ->whereBetween('DateTraitement', [$Debut, $Fin])
                     ->get();

         $Origines=Origine::whereEtat(0)->get(); 
         $NbreOri = Origine::whereEtat(0)->count('id');                     
         foreach($Origines as $Origine){
             
        $NbreAyD = DB::table('origines')
                     ->join('affiliers', 'affiliers.Origine', '=', 'origines.id')
                     ->join('ayant_droits', 'ayant_droits.Affilier', '=', 'affiliers.id')
                     ->select(DB::raw('count(ayant_droits.id) as N'))
                     ->where('affiliers.Origine','=',$Origine->id)
                     // ->where('affiliers.Etat',0)
                     // ->where('ayant_droits.Etat',0)
                     ->where('origines.Etat',0)
                     ->where('Lien', '!=', 'Lui meme')
                     ->get();
                     
        $NbreAyDT = DB::table('origines')
                     ->join('affiliers', 'affiliers.Origine', '=', 'origines.id')
                     ->join('ayant_droits', 'ayant_droits.Affilier', '=', 'affiliers.id')
                     ->select(DB::raw('count(ayant_droits.id) as N'))
                     // ->where('affiliers.Etat',0)
                     // ->where('ayant_droits.Etat',0)
                     ->where('origines.Etat',0)
                     ->where('Lien', '!=', 'Lui meme')
                     ->get();
                     
         $comm = DB::table('factures')
                     ->join('affiliers', 'affiliers.id', '=', 'factures.Affilier')
                     ->select(DB::raw('sum(Janvier) as J,sum(Fevrier) as F, sum(Mars) as M, sum(Avril) as A, sum(Mai) as Ma, sum(Juin) as Ju, sum(Juillet) as Jui, sum(Aout) as Ao, sum(semptembre) as S, sum(Octobre) as O, sum(Novembre) as N, sum(Decembre) as D, Affilier,Origine, sum(Janvier+Fevrier+Mars+Avril+Mai+Juin+Juillet+Aout+semptembre+Octobre+Novembre+Decembre) as ST'))
                     ->where('factures.Etat','!=',2)
                      //->where('affiliers.Etat','=',0)
                     ->where('Origine',$Origine->id)
                     ->whereBetween('DateTraitement', [$Debut, $Fin])
                     ->get();

         $cotis = DB::table('cotisations')
                     ->join('affiliers', 'affiliers.id', '=', 'cotisations.Affilier')
                     ->select(DB::raw('sum(Montant) as CS'))
                     ->where('cotisations.Etat',0)
                      ->where('Origine',$Origine->id)
                      ->whereBetween('DateCreation', [$Debut, $Fin])
                     ->get();         
            

          foreach ($comm as $com) 
          { 
            foreach ($cotis as $coti) 
            {
              foreach($NbreAyD as $ND)
              {
                 $Ecart = $coti->CS-$com->ST;
              $EcartT +=$Ecart;
            $table.="
                    <tr class='odd gradeX'>
                        <td>".$Origine->Origine."</td>
                        <td>".$ND->N."</td>
                         <td>".$com->J."</td>
                         <td>".$com->F."</td>
                        <td>".$com->M."</td>
                        <td>".$com->A."</td>
                        <td>".$com->Ma."</td>
                        <td>".$com->Ju."</td>
                        <td>".$com->Jui."</td>
                        <td>".$com->Ao."</td>
                        <td>".$com->S."</td>
                       <td>".$com->O."</td>
                       <td>".$com->N."</td>
                        <td>".$com->D."</td>
                        <td>".$com->ST."</td>
                        <td>".$Ecart."</td>
                    </tr>"; 
              }
              
                    }
                }
             }          # code...
        }
         $tableListe=$table;
         $pdf = PDF::loadView('Ventillations.PdfVentillationGroupe', compact('tableListe', 'Somme', 'EcartT', 'NbreOri', 'Groupes', 'Consomation', 'NbreAyDT'))->setPaper('a3', 'Paysage');
         $fileName = 'Ventillation';
         return $pdf->stream($fileName . '.pdf');
    }
    }


    public function PdfVentillationGeneral()
    {   $Consomation = Consomation::findOrFail(1);
        $Affiliers = Affilier::all();
        $Factures = Facture::where('Etat','!=',2)->groupBy('Affilier')->get()
        ;
        $NbreFacture=Facture::where('Etat','!=',2)->count();
        $table="";
        $Somme = [];
        //if ($NbreFacture > 0) {
         $Somme = DB::table('factures')
                     ->select(DB::raw('sum(factures.Janvier) as J,sum(factures.Fevrier) as F, sum(factures.Mars) as M, sum(factures.Avril) as A, sum(factures.Mai) as Ma, sum(factures.Juin) as Ju, sum(factures.Juillet) as Jui, sum(factures.Aout) as Ao, sum(factures.semptembre) as S, sum(factures.Octobre) as O, sum(factures.Novembre) as N, sum(factures.Decembre) as D, count(distinct(factures.Affilier)) as AF, sum(factures.Janvier+factures.Fevrier+factures.Mars+factures.Avril+factures.Mai+factures.Juin+factures.Juillet+factures.Aout+factures.semptembre+factures.Octobre+factures.Novembre+factures.Decembre) as ST'))
                     ->where('factures.Etat','!=',2)
                     ->get();
         
         $EcartT=0;
         $TCot=0;
         $Affiliers = Affilier::all(); 
         $NbreAff = Affilier::all()->count();          
         foreach($Affiliers as $Aff){
            $NbreAyD = AyantDroit::whereEtatAndAffilier(0,$Aff->id)->where('Lien', '!=', 'Lui meme')->count('id');
            $NbreAyDT = AyantDroit::whereEtat(0)->where('Lien', '!=', 'Lui meme')->count('id');
            $id_Affilier=$Aff->id;
            $Affilier=Affilier::where('id',$id_Affilier)->first();
            $comm = DB::table('factures')
                     ->select(DB::raw('sum(factures.Janvier) as J,sum(factures.Fevrier) as F, sum(factures.Mars) as M, sum(factures.Avril) as A, sum(factures.Mai) as Ma, sum(factures.Juin) as Ju, sum(factures.Juillet) as Jui, sum(factures.Aout) as Ao, sum(factures.semptembre) as S, sum(factures.Octobre) as O, sum(factures.Novembre) as N, sum(factures.Decembre) as D, factures.Affilier, sum(factures.Janvier+factures.Fevrier+factures.Mars+factures.Avril+factures.Mai+factures.Juin+factures.Juillet+factures.Aout+factures.semptembre+factures.Octobre+factures.Novembre+factures.Decembre) as ST'))
                     ->where('factures.Etat','!=',2)
                     ->where('factures.Affilier',$Aff->id)
                     ->get();

            $cotis = DB::table('cotisations')
                     ->select(DB::raw('sum(Montant) as CS'))
                     ->where('cotisations.Etat',0)
                     ->where('cotisations.Affilier',$Aff->id)
                     ->get();         

            foreach ($comm as $com) 
            {
                foreach ($cotis as $coti) 
                {
                    $Ecart = $coti->CS-$com->ST;
                    $EcartT +=$Ecart;
                    $TCot +=$coti->CS;
         if ($Affilier->Etat==2) 
         {
             $table.="
                    <tr class='odd gradeX' style='color:red;'>
                         <td>".$Aff->Code."</td>
                        <td>".$Aff->Nom.' '.$Aff->Prenom."</td>
                        <td>".$NbreAyD."</td>
                         <td>".$com->J."</td>
                         <td>".$com->F."</td>
                        <td>".$com->M."</td>
                        <td>".$com->A."</td>
                        <td>".$com->Ma."</td>
                        <td>".$com->Ju."</td>
                        <td>".$com->Jui."</td>
                        <td>".$com->Ao."</td>
                        <td>".$com->S."</td>
                       <td>".$com->O."</td>
                       <td>".$com->N."</td>
                        <td>".$com->D."</td>
                        <td>".$coti->CS."</td>
                        <td>".$com->ST."</td>
                        <td>".$Ecart."</td>
                    </tr>";
         }
         else
         {
            $table.="
                    <tr class='odd gradeX'>
                         <td>".$Aff->Code."</td>
                        <td>".$Aff->Nom.' '.$Aff->Prenom."</td>
                        <td>".$NbreAyD."</td>
                         <td>".$com->J."</td>
                         <td>".$com->F."</td>
                        <td>".$com->M."</td>
                        <td>".$com->A."</td>
                        <td>".$com->Ma."</td>
                        <td>".$com->Ju."</td>
                        <td>".$com->Jui."</td>
                        <td>".$com->Ao."</td>
                        <td>".$com->S."</td>
                       <td>".$com->O."</td>
                       <td>".$com->N."</td>
                        <td>".$com->D."</td>
                        <td>".$coti->CS."</td>
                        <td>".$com->ST."</td>
                        <td>".$Ecart."</td>
                    </tr>";
         }
            
                    }
                   }
            }
        //}
        $tableListe=$table;
         $pdf = PDF::loadView('Ventillations.PdfVentillationGeneral', compact('tableListe', 'Somme', 'EcartT', 'NbreAff', 'TCot', 'Consomation','NbreAyDT', 'NbreAyD'))->setPaper('a3', 'Paysage');
         $fileName = 'Ventillation';
         return $pdf->stream($fileName . '.pdf');
    }

    public function PdfCreateGeneral(Request $request)
    {   $Consomation = Consomation::findOrFail(1);
    	$Somme = [];
        $Debut = $request->Debut;
        $Fin = $request->Fin;
        $Affiliers = Affilier::all();
        $Factures = Facture::where('Etat','!=',2)->groupBy('Affilier')->get();
        $NbreFacture=Facture::where('Etat','!=',2)->count();
        $NbreCotisation=Cotisation::where('Etat','=',0)->count();
        $table="";
        if ($NbreFacture > 0 || $NbreCotisation > 0) {
         $Somme = DB::table('factures')
                     ->select(DB::raw('sum(factures.Janvier) as J,sum(factures.Fevrier) as F, sum(factures.Mars) as M, sum(factures.Avril) as A, sum(factures.Mai) as Ma, sum(factures.Juin) as Ju, sum(factures.Juillet) as Jui, sum(factures.Aout) as Ao, sum(factures.semptembre) as S, sum(factures.Octobre) as O, sum(factures.Novembre) as N, sum(factures.Decembre) as D, count(distinct(factures.Affilier)) as AF, sum(factures.Janvier+factures.Fevrier+factures.Mars+factures.Avril+factures.Mai+factures.Juin+factures.Juillet+factures.Aout+factures.semptembre+factures.Octobre+factures.Novembre+factures.Decembre) as ST'))
                     ->where('factures.Etat','!=',2)
                     ->whereBetween('DateTraitement', [$Debut, $Fin])
                     ->get();
         
         $EcartT=0;
         $TCot=0;
         $Affiliers = Affilier::all(); 
         $NbreAff = Affilier::all()->count();          
         foreach($Affiliers as $Aff){
           $NbreAyD = AyantDroit::whereEtatAndAffilier(0,$Aff->id)->where('Lien', '!=', 'Lui meme')->count('id');
            $NbreAyDT = AyantDroit::whereEtat(0)->where('Lien', '!=', 'Lui meme')->count('id');
            $id_Affilier=$Aff->id;
            $Affilier=Affilier::where('id',$id_Affilier)->first();
            $comm = DB::table('factures')
                     ->select(DB::raw('sum(factures.Janvier) as J,sum(factures.Fevrier) as F, sum(factures.Mars) as M, sum(factures.Avril) as A, sum(factures.Mai) as Ma, sum(factures.Juin) as Ju, sum(factures.Juillet) as Jui, sum(factures.Aout) as Ao, sum(factures.semptembre) as S, sum(factures.Octobre) as O, sum(factures.Novembre) as N, sum(factures.Decembre) as D, factures.Affilier, sum(factures.Janvier+factures.Fevrier+factures.Mars+factures.Avril+factures.Mai+factures.Juin+factures.Juillet+factures.Aout+factures.semptembre+factures.Octobre+factures.Novembre+factures.Decembre) as ST'))
                     ->where('factures.Etat','!=',2)
                     ->where('factures.Affilier',$Aff->id)
                     ->whereBetween('DateTraitement', [$Debut, $Fin])
                     ->get();

            $cotis = DB::table('cotisations')
                     ->select(DB::raw('sum(Montant) as CS'))
                     ->where('cotisations.Etat',0)
                     ->where('cotisations.Affilier',$Aff->id)
                     ->whereBetween('DateCreation', [$Debut, $Fin])
                     ->get();         

            foreach ($comm as $com) 
            {
                foreach ($cotis as $coti) 
                {
                    $Ecart = $coti->CS-$com->ST;
                    $EcartT +=$Ecart;
                    $TCot +=$coti->CS;
 
         if ($Affilier->Etat==2) 
         {
             $table.="
                    <tr class='odd gradeX' style='color:red;'>
                        <td>".$Aff->Code."</td>
                        <td>".$Aff->Nom.' '.$Aff->Prenom."</td>
                        <td>".$NbreAyD."</td>
                         <td>".$com->J."</td>
                         <td>".$com->F."</td>
                        <td>".$com->M."</td>
                        <td>".$com->A."</td>
                        <td>".$com->Ma."</td>
                        <td>".$com->Ju."</td>
                        <td>".$com->Jui."</td>
                        <td>".$com->Ao."</td>
                        <td>".$com->S."</td>
                       <td>".$com->O."</td>
                       <td>".$com->N."</td>
                        <td>".$com->D."</td>
                        <td>".$coti->CS."</td>
                        <td>".$com->ST."</td>
                        <td>".$Ecart."</td>
                    </tr>";
         }
         else
         {
             $table.="
                    <tr class='odd gradeX'>
                        <td>".$Aff->Code."</td>
                        <td>".$Aff->Nom.' '.$Aff->Prenom."</td>
                        <td>".$NbreAyD."</td>
                         <td>".$com->J."</td>
                         <td>".$com->F."</td>
                        <td>".$com->M."</td>
                        <td>".$com->A."</td>
                        <td>".$com->Ma."</td>
                        <td>".$com->Ju."</td>
                        <td>".$com->Jui."</td>
                        <td>".$com->Ao."</td>
                        <td>".$com->S."</td>
                       <td>".$com->O."</td>
                       <td>".$com->N."</td>
                        <td>".$com->D."</td>
                        <td>".$coti->CS."</td>
                        <td>".$com->ST."</td>
                        <td>".$Ecart."</td>
                    </tr>";
         }
           
                    }
                   }
            }
        }
        $tableListe=$table;
         $pdf = PDF::loadView('Ventillations.PdfCreateGeneral', compact('tableListe', 'Somme', 'Debut', 'Fin', 'NbreAff', 'EcartT', 'TCot', 'Consomation', 'NbreAyDT', 'NbreAyD'))->setPaper('a3', 'Paysage');
         $fileName = 'Ventillation';
         return $pdf->stream($fileName . '.pdf');  
    } 

    public function research(Request $request){
        $Affilier=$request->get('affilie');
        $Affiliers=Affilier::where('Code','like','%'.$Affilier.'%')->get();
        $allAffiliers="";
        foreach ($Affiliers as $Affilier) {
            $allAffiliers.="<option value='".$Affilier->id."'>".$Affilier->Code.'/'.$Affilier->Nom.'/'.$Affilier->Prenom."</option>";
        }
        echo $allAffiliers;
    }  

    //Formulaire de Recherche du details de la consommantion d'un affilie 

    public function ConsommationDetail(Request $request)
    {  
        $Affiliers = Affilier::all();
        $Factures = Facture::where('Etat','!=',2)->groupBy('Affilier')->get()
        ;
        $NbreFacture=Facture::where('Etat','!=',2)->count();
        $NbreCotisation=Cotisation::where('Etat', '=', 0)->count();
        $table="";
        $Somme = [];
        //if ($NbreFacture > 0 OR $NbreCotisation > 0) {
          $Somme = DB::table('factures')
                     ->select(DB::raw('sum(factures.Janvier) as J,sum(factures.Fevrier) as F, sum(factures.Mars) as M, sum(factures.Avril) as A, sum(factures.Mai) as Ma, sum(factures.Juin) as Ju, sum(factures.Juillet) as Jui, sum(factures.Aout) as Ao, sum(factures.semptembre) as S, sum(factures.Octobre) as O, sum(factures.Novembre) as N, sum(factures.Decembre) as D, count(distinct(factures.Affilier)) as AF, sum(factures.Janvier+factures.Fevrier+factures.Mars+factures.Avril+factures.Mai+factures.Juin+factures.Juillet+factures.Aout+factures.semptembre+factures.Octobre+factures.Novembre+factures.Decembre) as ST'))
                     ->where('factures.Etat','!=',2)
                     ->get();
         
         $EcartT=0;
         $TCot=0;
         $Affiliers = Affilier::all();
         $NbreAff = Affilier::where('Etat', '!=', 2)->count('id'); 

         foreach($Affiliers as $Aff){

            $id_Affilier=$Aff->id;
            $Affilier=Affilier::where('id',$id_Affilier)->first();
            $comm = DB::table('factures')
                     ->select(DB::raw('sum(factures.Janvier) as J,sum(factures.Fevrier) as F, sum(factures.Mars) as M, sum(factures.Avril) as A, sum(factures.Mai) as Ma, sum(factures.Juin) as Ju, sum(factures.Juillet) as Jui, sum(factures.Aout) as Ao, sum(factures.semptembre) as S, sum(factures.Octobre) as O, sum(factures.Novembre) as N, sum(factures.Decembre) as D, factures.Affilier, sum(factures.Janvier+factures.Fevrier+factures.Mars+factures.Avril+factures.Mai+factures.Juin+factures.Juillet+factures.Aout+factures.semptembre+factures.Octobre+factures.Novembre+factures.Decembre) as ST'))
                     ->where('factures.Etat','!=',2)
                     ->where('factures.Affilier',$Aff->id)
                     ->get();

            $cotis = DB::table('cotisations')
                     ->select(DB::raw('sum(Montant) as CS'))
                     ->where('cotisations.Etat',0)
                     ->where('cotisations.Affilier',$Aff->id)
                     ->get();         

            foreach ($comm as $com) 
            {
                foreach ($cotis as $coti) 
                {
                    $Ecart = $coti->CS-$com->ST;
                    $EcartT +=$Ecart;
                    $TCot+=$coti->CS;
            
            if ($Aff->Etat==2) 
            {
                $table.="
                    <tr class='odd gradeX' style='color:red;'>
                       <td>".$Aff->Code."</td>
                        <td>".$Aff->Nom.' '.$Aff->Prenom."</td>
                         <td>".$com->J."</td>
                         <td>".$com->F."</td>
                        <td>".$com->M."</td>
                        <td>".$com->A."</td>
                        <td>".$com->Ma."</td>
                        <td>".$com->Ju."</td>
                        <td>".$com->Jui."</td>
                        <td>".$com->Ao."</td>
                        <td>".$com->S."</td>
                       <td>".$com->O."</td>
                       <td>".$com->N."</td>
                        <td>".$com->D."</td>
                        <td>".$coti->CS."</td>
                        <td>".$com->ST."</td>
                        <td>".$Ecart."</td>
                    </tr>";
            }
            else
            {
                 $table.="
                    <tr class='odd gradeX'>
                       <td>".$Aff->Code."</td>
                        <td>".$Aff->Nom.' '.$Aff->Prenom."</td>
                         <td>".$com->J."</td>
                         <td>".$com->F."</td>
                        <td>".$com->M."</td>
                        <td>".$com->A."</td>
                        <td>".$com->Ma."</td>
                        <td>".$com->Ju."</td>
                        <td>".$com->Jui."</td>
                        <td>".$com->Ao."</td>
                        <td>".$com->S."</td>
                       <td>".$com->O."</td>
                       <td>".$com->N."</td>
                        <td>".$com->D."</td>
                        <td>".$coti->CS."</td>
                        <td>".$com->ST."</td>
                        <td>".$Ecart."</td>
                    </tr>";
            }
                    }
                   }
            }
        //}
        $tableListe=$table;
         return view('Ventillations/ConsommationDetail', compact('tableListe', 'Somme', 'EcartT', 'NbreAff', 'Affiliers', 'TCot'));
    } 

    // Vue detaillée de la consommation d'un affilie sur PDF

    public function PdfViewDetails(Request $request){

        $Consomation = Consomation::findOrFail(1);
        $Somme = [];
        $Ecart = 0;
        $TCot=0;
        $Montant =0;
        $Individu = Affilier::findOrFail($request->Individu);
        //Dans le Cas de La rechercher 
        if (isset($request->Individu) && !empty($request->Individu) && isset($request->Debut) && !empty($request->Debut) && isset($request->Fin) && !empty($request->Fin)) 
        {
        $Affiliers = Affilier::whereEtat(0)->get();
        $Factures = Facture::where('Etat','!=',2)->groupBy('Affilier')->get()
        ;
         $NbreFacture=Facture::where('Etat','!=',2)->count();
         $table="";

        $SumFact =DB::table('factures')
        ->select('*')
        ->where('Etat', 1)
        ->where('Affilier', $request->Individu) 
        ->sum('SAAT'); 
        $SumCom  =DB::table('factures')
        ->select('*')
        ->where('Etat', 1)
        ->where('Affilier', $request->Individu) 
        ->sum('ComptantAffilier'); 
        $SumCot = Cotisation::whereEtatAndAffilier(0,$request->Individu)->sum('Montant');
         $comm = DB::table('factures')
                     ->select(DB::raw('*'))
                     ->where('Etat','!=',2)
                     ->whereAffilier($request->Individu)
                     ->whereBetween('DateTraitement',[$request->Debut, $request->Fin])
                     ->get();

           $cotis = DB::table('cotisations')
                     ->select(DB::raw('sum(Montant) as CS'))
                     ->where('cotisations.Etat',0)
                     ->where('cotisations.Affilier',$request->Individu)
                     ->get(); 
                            
          $Somme = DB::table('factures')
                     ->select(DB::raw('sum(Janvier) as J,sum(Fevrier) as F, sum(Mars) as M, sum(Avril) as A, sum(Mai) as Ma, sum(Juin) as Ju, sum(Juillet) as Jui, sum(Aout) as Ao, sum(semptembre) as S, sum(Octobre) as O, sum(Novembre) as N, sum(Decembre) as D, count(distinct(Affilier)) as AF, sum(Janvier+Fevrier+Mars+Avril+Mai+Juin+Juillet+Aout+semptembre+Octobre+Novembre+Decembre) as ST'))
                     ->where('Etat','!=',2)
                     ->whereAffilier($request->Individu)
                     ->whereBetween('DateTraitement',[$request->Debut, $request->Fin])
                     ->get();           
         foreach($comm as $com){

            $Detai = '';
            $Details = DB::table('factures')
            ->join('commandes', 'commandes.Facture', '=', 'factures.id')
            ->Leftjoin('medicament_partenaires', 'medicament_partenaires.medicament', '=', 'commandes.Propriete')
            ->select(DB::raw('commandes.PU, commandes.Qte, commandes.PT, medicament_partenaires.designation, commandes.Propriete'))
            ->where('factures.id', $com->id)
            ->get();
             
             // on constitue une liste de details des commandes
               foreach ($Details as $Detail) {
                //On fait test sur la designation de la table 'medicament_partenaires', car avant la 1ere maintenance elle n'existait pas et on utilisait la propriete de la table commandes, mais avec les modifications cette propriete sera remplace par designation de la table medicament_partenaires.
                if ($Detail->designation=='') {
                     $Detai.="
                  <ul style='list-style-type: none;'><li>".$Detail->Propriete.' x '.$Detail->Qte.' = '.$Detail->PT."</li></ul>";
                }else{
                     $Detai.="
                  <ul><li>".$Detail->designation.' x '.$Detail->Qte.' = '.$Detail->PT."</li></ul>";
                }
               
               }
            $ListeDetails = $Detai;
            $id_Affilier=$com->Affilier;
            $id_Droit=$com->Beneficiaire;
            $Affilier=Affilier::where('id',$id_Affilier)->first();
            $AyantDroit=AyantDroit::where('id',$id_Droit)->first();
            $Origine = Origine::findOrFail($Affilier->Origine);
            $Partenaire = Partenaire::findOrFail($com->Partenaire);
            

        foreach ($cotis as $coti) 
        {       
            $coti->CS-=$Montant;
            $Montant = $com->SAAT;
            $Ecart = $coti->CS-$Montant;
                           $table.="
                    <tr class='odd gradeX'>
                         <td>".$Affilier->Code."</td>
                         <td>".$com->DateTraitement."</td>
                        <td>".$Affilier->Nom.' '.$Affilier->Prenom."</td>
                         <td>".$AyantDroit->Nom.' '.$AyantDroit->Prenom."</td>
                         <td>".$Origine->Origine."</td>
                         <td>".$ListeDetails."</td>
                         <td>".$com->ComptantAffilier."</td>
                        <td>".$com->SAAT."</td>
                        <td>".$Partenaire->Partenaire."</td>
                    </tr>"; 

            // $Ecart-=$com->SAAT;                                     # code...
        }        

                    }
        $tableListe=$table;
        $pdf = PDF::loadView('Ventillations.PdfViewDetails', compact('tableListe', 'Somme', 'Individu', 'Ecart', 'SumFact', 'SumCot', 'Consomation', 'SumCom'))->setPaper('a3', 'Paysage');
         $fileName = 'Ventillation';
         return $pdf->stream($fileName . '.pdf');

        }
        elseif (isset($request->Individu) && !empty($request->Individu)) 
        {
         $Affiliers = Affilier::whereEtat(0)->get();
        $Factures = Facture::where('Etat','!=',2)->groupBy('Affilier')->get()
        ;

        $SumFact = Facture::whereEtatAndAffilier(1,$request->Individu)->sum('SAAT');
        $SumCom = Facture::whereEtatAndAffilier(1,$request->Individu)->sum('ComptantAffilier');
        $SumCot = Cotisation::whereEtatAndAffilier(0,$request->Individu)->sum('Montant');

         $NbreFacture=Facture::where('Etat','!=',2)->count();
         $table="";
         $comm = DB::table('factures')
                     ->select(DB::raw('*'))
                     ->where('Etat','!=',2)
                     ->whereAffilier($request->Individu)
                     ->get();

           $cotis = DB::table('cotisations')
                     ->select(DB::raw('sum(Montant) as CS'))
                     ->where('cotisations.Etat',0)
                     ->where('cotisations.Affilier',$request->Individu)
                     ->get(); 
                            
          $Somme = DB::table('factures')
                     ->select(DB::raw('sum(Janvier) as J,sum(Fevrier) as F, sum(Mars) as M, sum(Avril) as A, sum(Mai) as Ma, sum(Juin) as Ju, sum(Juillet) as Jui, sum(Aout) as Ao, sum(semptembre) as S, sum(Octobre) as O, sum(Novembre) as N, sum(Decembre) as D, count(distinct(Affilier)) as AF, sum(Janvier+Fevrier+Mars+Avril+Mai+Juin+Juillet+Aout+semptembre+Octobre+Novembre+Decembre) as ST'))
                     ->where('Etat','!=',2)
                     ->whereAffilier($request->Individu)
                     ->get();           
         foreach($comm as $com){
            $Detai = '';
            $Details = DB::table('factures')
            ->join('commandes', 'commandes.Facture', '=', 'factures.id')
            ->Leftjoin('medicament_partenaires', 'medicament_partenaires.medicament', '=', 'commandes.Propriete')
            ->select(DB::raw('commandes.PU, commandes.Qte, commandes.PT, medicament_partenaires.designation, commandes.Propriete'))
            ->where('factures.id', $com->id)
            ->get();
             
             // on constitue une liste de details des commandes
               foreach ($Details as $Detail) {
                //On fait test sur la designation de la table 'medicament_partenaires', car avant la 1ere maintenance elle n'existait pas et on utilisait la propriete de la table commandes, mais avec les modifications cette propriete sera remplace par designation de la table medicament_partenaires.
                if ($Detail->designation=='') {
                     $Detai.="
                  <ul style='list-style-type: none;'><li>".$Detail->Propriete.' x '.$Detail->Qte.' = '.$Detail->PT."</li></ul>";
                }else{
                     $Detai.="
                  <ul><li>".$Detail->designation.' x '.$Detail->Qte.' = '.$Detail->PT."</li></ul>";
                }
               
               }
            $ListeDetails = $Detai;
            $id_Affilier=$com->Affilier;
            $id_Droit=$com->Beneficiaire;
            $Affilier=Affilier::where('id',$id_Affilier)->first();
            $AyantDroit=AyantDroit::where('id',$id_Droit)->first();
            $Origine = Origine::findOrFail($Affilier->Origine);
            $Partenaire = Partenaire::findOrFail($com->Partenaire);
        

        foreach ($cotis as $coti) 
        {       
            $coti->CS-=$Montant;
            $Montant = $com->SAAT;
            $Ecart = $coti->CS-$Montant;
                           $table.="
                    <tr class='odd gradeX'>
                         <td>".$Affilier->Code."</td>
                         <td>".$com->DateTraitement."</td>
                        <td>".$Affilier->Nom.' '.$Affilier->Prenom."</td>
                         <td>".$AyantDroit->Nom.' '.$AyantDroit->Prenom."</td>
                         <td>".$Origine->Origine."</td>
                         <td>".$ListeDetails."</td>
                        <td>".$com->ComptantAffilier."</td>
                        <td>".$com->SAAT."</td>
                        <td>".$Partenaire->Partenaire."</td>
                    </tr>"; 

             //$Ecart-=$com->Montant;                                     # code...
        }        

                    }
        $tableListe=$table;
        $pdf = PDF::loadView('Ventillations.PdfViewDetails', compact('tableListe', 'Somme', 'Individu', 'Ecart', 'SumFact', 'SumCot', 'Consomation', 'SumCom'))->setPaper('a3', 'Paysage');
         $fileName = 'Ventillation';
         return $pdf->stream($fileName . '.pdf');
        }
        //Dans le Cas Contraire
        else
        {
        $Affiliers = Affilier::whereEtat(0)->get();
        $Factures = Facture::where('Etat','!=',2)->groupBy('Affilier')->get()
        ;
         $NbreFacture=Facture::where('Etat','!=',2)->count();
        $table="";
        
        if ($NbreFacture > 0) {
         $comm = DB::table('factures')
                     ->select(DB::raw('sum(Janvier) as J,sum(Fevrier) as F, sum(Mars) as M, sum(Avril) as A, sum(Mai) as Ma, sum(Juin) as Ju, sum(Juillet) as Jui, sum(Aout) as Ao, sum(semptembre) as S, sum(Octobre) as O, sum(Novembre) as N, sum(Decembre) as D, Affilier, sum(Janvier+Fevrier+Mars+Avril+Mai+Juin+Juillet+Aout+semptembre+Octobre+Novembre+Decembre) as ST'))
                     ->where('Etat','!=',2)
                     ->groupBy('Affilier')
                     ->get();

          $Somme = DB::table('factures')
                     ->select(DB::raw('sum(Janvier) as J,sum(Fevrier) as F, sum(Mars) as M, sum(Avril) as A, sum(Mai) as Ma, sum(Juin) as Ju, sum(Juillet) as Jui, sum(Aout) as Ao, sum(semptembre) as S, sum(Octobre) as O, sum(Novembre) as N, sum(Decembre) as D, count(distinct(Affilier)) as AF, sum(Janvier+Fevrier+Mars+Avril+Mai+Juin+Juillet+Aout+semptembre+Octobre+Novembre+Decembre) as ST'))
                     ->where('Etat','!=',2)
                     ->get();           
         foreach($comm as $com){

            $id_Affilier=$com->Affilier;
            $Affilier=Affilier::where('id',$id_Affilier)->first();

            $table.="
                    <tr class='odd gradeX'>
                        <td>".$Affilier->Nom.' '.$Affilier->Prenom."</td>
                         <td>".$com->J."</td>
                         <td>".$com->F."</td>
                        <td>".$com->M."</td>
                        <td>".$com->A."</td>
                        <td>".$com->Ma."</td>
                        <td>".$com->Ju."</td>
                        <td>".$com->Jui."</td>
                        <td>".$com->Ao."</td>
                        <td>".$com->S."</td>
                       <td>".$com->O."</td>
                       <td>".$com->N."</td>
                        <td>".$com->D."</td>
                        <td>".$com->ST."</td>
                        <td>".$com->ST."</td>
                    </tr>";
                    }     
        }
        $tableListe=$table;
         $pdf = PDF::loadView('Ventillations.PdfViewDetails', compact('tableListe', 'Somme', 'Individu', 'Consomation'))->setPaper('a3', 'Paysage');
         $fileName = 'Ventillation';
         return $pdf->stream($fileName . '.pdf');
        }
    }
}
