<?php

namespace App\Http\Livewire;

use Livewire\Component;
use DB;
class Dashboard extends Component
{  
    public function render()
    {   
                    //$Cotisations = Cotisation::all();
        $CurentYear = date('Y');
        $tabCot = [];
        $tabFact = [];

        $tabCotAff = [];
        $tabFactAff = [];
        $AffilierTab = [];

        for ($i=1; $i <=12 ; $i++) { 
             $cotisation = DB::table('cotisations')
                    ->select(DB::raw(''))
                     ->where('cotisations.Annee','=',$CurentYear)
                     ->where('cotisations.Etat', '=',0)
                     ->where('cotisations.Mois', '=',$i)
                     ->sum('Montant');

            $tabCot[] = $cotisation;          
        }

        for ($i=1; $i <=12 ; $i++) { 
             $facture = DB::table('factures')
                     ->select(DB::raw(''))
                     ->where('factures.Annee','=',$CurentYear)
                     ->where('factures.Etat', '!=', 2)
                     ->where('factures.Mois', '=', $i)
                     ->sum('SAAT');

            $tabFact[] = $facture;          
        }


        // DEUXIEME GRAPH

              $comms = DB::table('affiliers')
                     ->join('factures', 'factures.Affilier', '=', 'affiliers.id')
                     ->select(DB::raw('sum(SAAT) as sum_sup,CONCAT(Nom, Prenom) as fullname, affiliers.id'))
                     ->where('factures.Annee','=',$CurentYear)
                     ->where('factures.Etat', '!=', 2)
                     ->groupBy('Affilier')
                     ->orderBy('sum_sup','desc')
                     ->limit(7)
                     ->get();

            foreach ($comms as $key => $value) {
                
                $tabFactAff[] = $value->sum_sup;
                $cot = DB::table('affiliers')
                     ->join('cotisations', 'cotisations.Affilier', '=', 'affiliers.id')
                     ->select(DB::raw(''))
                     ->where('cotisations.Annee','=',$CurentYear)
                     ->where('cotisations.Etat', '=', 0)
                     ->where('affiliers.id', $value->id)
                     ->limit(7)
                     ->sum('Montant');
                $tabCotAff[]=$cot; 
                $AffilierTab[]= $value->fullname;   
                        
            }         

       
        return view('livewire.dashboard',[
            'cotisation' => $tabCot,
            'facture' => $tabFact,
            'tabFactAff'=> $tabFactAff,
            'tabCotAff'=> $tabCotAff,
            'AffilierTab'=> $AffilierTab
        ]);
    }
}
