<?php

namespace App\Http\Controllers;
use App\Models\AyantDroit;
use App\Models\Partenaire;
use App\Models\Service;
use Cart;
use App\Models\MedicamentPartenaire;
use App\Models\Facture;
use Illuminate\Http\Request;

class PrestationController extends Controller
{
    public function form_prest(Request $request, $service,$adherant){
        if(session()->get('Profil')=="User"){
            $Type = "U";
        }else{
            $Type = "P";
        }

         $request->session()->put('service',$service);

    	$Aff = $adherant;
    	$Prestation = Service::findOrFail($service);
    	$AyantDroits = AyantDroit::whereAffilierAndEtat($Aff,0)->get();
    	$Partenaires = Partenaire::whereEtat(0)->get();

    	if(session()->get('Profil')=='Partenaire'){
           $Medicaments = MedicamentPartenaire::wherePartenaire(session()->get('id'))->get();
        }else{
           $Medicaments = MedicamentPartenaire::wherePartenaire(session()->get('Paterner'))->get();
        }
    	$sejourExist = Cart::sejourExist($Type);
        $totalQuant = Cart::getContent()->where('adherant', session()->get('Aff'))->where('prestation', session()->get('service'))->where('user', session()->get('id').$Type)->where('Paterner', session()->get('Paterner'))->count();

        $content = Cart::getContent()->where('prestation', session()->get('service'))->where('user', session()->get('id').$Type)->where('Paterner', session()->get('Paterner'));

        $total = Cart::TotalCart($content);
        return view('Prestation.create', compact('Aff', 'AyantDroits', 'Partenaires', 'Prestation', 'Medicaments', 'total', 'sejourExist', 'totalQuant'));
    }
}
