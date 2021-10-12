<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Cotisation;
use App\Models\Tauxcotisation;
class Cotisation extends Model
{
    protected $fillable = ['Affilier', 'Montant', 'Mois', '', 'Annee', 'Etat', 'DateCreation', 'Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Semptembre', 'Octobre', 'Novembre', 'Decembre', 'DateCreation', 'Datepayement', 'Cotisation_due', 'Arrieres_dus', 'Soldes_arrieres'];
    // protected $dates = ['DateCreation'];
   

   //Fonction pour calculer l'arrierés
    public static function Taux_cotisation($affilier, $year){
         // VERIFIE LE PARAMETRE DU TAUX DE COTISATION POUR L'ANNEE ETUDIEE
        $Paramseted = Tauxcotisation::whereParamAnnee($year)->count('id');
        
        if ($Paramseted!=0) {
            $Params = Tauxcotisation::whereParamAnnee($year)->first();
             // CAS DU TAUX DE COTISATION FORFAITAIRE
            if ($Params->param_taux==0) {
                $CotisationDue = $Params->param1;
            }
            // CAS DU TAUX DE COTISATION NOMBRE DE PERSONNE EN CHARGE
            elseif ($Params->param_taux==1) {
                if ($Params->param2==0) {
                    $Beneficiaire = AyantDroit::whereAffilierAndEtatAndStatus($affilier,0,0)->count('id');
                    $CotisationDue = $Beneficiaire*$Params->param1;
                }else{
                    $beneficiaire = AyantDroit::whereAffilierAndEtatAndStatus($affilier,0,0)->count('id');
                    //ON SOUSTRAIT L'AFFILIER PRINCIPALE
                    $beneficiaire-=1;
                    $CotisationDue = $beneficiaire*$Params->param1;
                    $CotisationDue+=$Params->param2;
                }
            }elseif ($Params->param_taux==2) {
                $CotisationDue = ($Affilier->revenu*$Params->param1)/100;
            }
        }else{
           $CotisationDue = "Not defined";
        }
        return $CotisationDue;
    }
}
