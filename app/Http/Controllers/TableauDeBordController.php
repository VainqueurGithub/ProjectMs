<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Cotisation;
use App\Models\Facture;
use App\Models\Partenaire;
use Illuminate\Support\Facades\DB;

class TableauDeBordController extends Controller
{
    public function TableauDeBord()
    {   $CurentYear = date('Y');
        $NbreCot = Cotisation::whereEtatAndAnnee(0,$CurentYear)->count('id');
        $MontantCot = Cotisation::whereEtatAndAnnee(0,$CurentYear)->sum('Montant');

        $NbreCons = Facture::where('Etat', '!=', 2)->whereAnneet($CurentYear)->count('id');
        $MontantCons = Facture::where('Etat', '!=', 2)->whereAnneet($CurentYear)->sum('SAAT');
        
        $ECART = number_format($MontantCot-$MontantCons,2,',',' ');
        $MontantCons = number_format($MontantCons,2,',',' ');
        $MontantCot = number_format($MontantCot,2,',',' ');

        return view('TableauDeBord', compact('NbreCot', 'MontantCot', 'NbreCons', 'MontantCons', 'ECART'));
    }
    
    public function graphic(){
              $CurentYear = date('Y');
              $comm = DB::table('affiliers')
                     ->join('cotisations', 'cotisations.Affilier', '=', 'affiliers.id')
                     ->select(DB::raw('sum(Montant) as sum_sup,Affilier,Nom,Prenom'))
                     ->where('cotisations.Annee','=',$CurentYear)
                     ->where('affiliers.Etat', '=', 0)
                     ->where('cotisations.Etat', '=',0)
                     ->groupBy('Affilier')
                     ->orderBy('sum_sup','desc')
                     ->limit(5)
                     ->get();
            $graph="";
            foreach ($comm as $keyComme) {
               $graph.=$keyComme->Nom.' '.$keyComme->Prenom."#";
               $graph.=$keyComme->sum_sup."#";
            }
            echo $graph; 
    }

    public function consommer(){
              $CurentYear = date('Y');
              $comm = DB::table('affiliers')
                     ->join('factures', 'factures.Affilier', '=', 'affiliers.id')
                     ->select(DB::raw('sum(SAAT) as sum_sup,Affilier,Nom,Prenom'))
                     ->where('factures.Annee','=',$CurentYear)
                     ->where('affiliers.Etat', '=', 0)
                     ->where('factures.Etat', '!=', 2)
                     // ->where('factures.ModePayement','!=','')
                     // ->where('factures.DatePayement','!=',"")
                     ->groupBy('Affilier')
                     ->orderBy('sum_sup','desc')
                     ->limit(5)
                     ->get();
            $graph="";
            foreach ($comm as $keyComme) {
               $graph.=$keyComme->Nom.' '.$keyComme->Prenom."#";
               $graph.=$keyComme->sum_sup."#";
            }
            echo $graph; 
    }

     public function dettePart(){
              $CurentYear = date('Y');
              $comm = DB::table('partenaires')
                     ->join('factures', 'factures.Partenaire', '=', 'partenaires.id')
                     ->select(DB::raw('sum(SAAT) as sum_sup,partenaires.Partenaire'))
                     ->where('factures.Annee','=',$CurentYear)
                     ->where('factures.ModePayement','=',"")
                     ->where('factures.Etat', '!=', 2)
                     ->where('partenaires.Etat', '=', 0)
                     ->groupBy('Partenaire')
                     ->orderBy('sum_sup','desc')
                     ->limit(5)
                     ->get();
            $graph="";
            foreach ($comm as $keyComme) {
               $graph.=$keyComme->Partenaire."#";
               $graph.=$keyComme->sum_sup."#";
            }
            $graph.='cool';
            echo $graph; 
    }

      public function ecart(){
              
              $DateALL = DB::table('cotisations')
                     ->where('cotisations.Etat', '=', 0)
                     ->groupBy('Annee')
                     ->orderBy('Annee','desc')
                     ->limit(7)
                     ->get();
            $graph="";
            foreach ($DateALL as $keyComme) {
                $ANNEECOUR=$keyComme->Annee;

                $comm = DB::table('factures')
                     ->select(DB::raw('sum(SAAT) as sum_sup'))
                     ->where('factures.Etat', '!=', 2)
                     ->where('Annee','=',$ANNEECOUR)
                     ->get();
                     $consommation=0;
                    foreach ($comm as $key) {
                      $consommation=$key->sum_sup;
                    }
                    if (empty($consommation)) {
                       $consommation=0;
                    }

                 $cotiser = DB::table('cotisations')
                     ->select(DB::raw('sum(Montant) as sum_sup'))
                     ->where('Annee','=',$ANNEECOUR)
                     ->where('cotisations.Etat', '=', 0)
                     ->get();
                     $cotisation=0;
                    foreach ($cotiser as $keyCot) {
                      $cotisation=$keyCot->sum_sup;
                    }

                $ECART=$cotisation-$consommation;
                $graph.=$ANNEECOUR.'#'.$cotisation.'#'.$consommation.'#'.$ECART.'#';
               // $graph.=$keyComme->sum_sup."#";

            }
            echo $graph; 
    }




}
