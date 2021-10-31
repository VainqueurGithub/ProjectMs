<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Cotisation;
use App\Models\Facture;
use App\Models\Partenaire;
class Statistic extends Component
{
     public function render()
    {   
        $CurentYear = date('Y');
        $NbreCot = Cotisation::whereEtatAndAnnee(0,$CurentYear)->count('id');
        $MontantCot = Cotisation::whereEtatAndAnnee(0,$CurentYear)->sum('Montant');

        $NbreCons = Facture::where('Etat', '!=', 2)->whereAnneet($CurentYear)->count('id');
        $MontantCons = Facture::where('Etat', '!=', 2)->whereAnneet($CurentYear)->sum('SAAT');
         
        $Taux_croissance = ($MontantCons*100)/$MontantCot;

        $ECART = number_format($MontantCot-$MontantCons,2,',',' ');
        $MontantCons = number_format($MontantCons,2,',',' ');
        $MontantCot = number_format($MontantCot,2,',',' ');
        
        return view('livewire.statistic', compact('NbreCot', 'MontantCot', 'NbreCons', 'MontantCons', 'ECART', 'CurentYear', 'Taux_croissance'));
    }
}
