<?php
use App\Models\biens;
namespace App\Models;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\depreciation;
use Illuminate\Support\Facades\Input;
class depreciation extends Model
{
    protected $fillable = ['Bien_id', 'Date_debut', 'Date_fin', 'Montant', 'Reported_in'];

    public static function depreciation_amount($bien){

       $Bien = DB::table('biens')
              ->select(DB::raw('Methode, DAY(Last_depreciation) as Jour, MONTH(Last_depreciation) as Moi, YEAR(Last_depreciation) Annee,Montant, Taux, Duree, DAY(Mis_service) as MJour, MONTH(Mis_service) as MMoi, YEAR(Mis_service) as YAnnee,Last_depreciation'))
              ->whereEtat(0)
              ->whereId($bien)->first(); //On recuperer les informations par rapport au bien "Montant, Duree, Taux, ..."
        //On verifie la methode d'ammortissement à appliquer

        //$Manytimedepreciated = depreciation::whereBienId($bien)->count('id');  

       //J'ouvre mon fichier en ecriture:
       $ecrire = 'plan_depreciation.txt';
if(file_exists($ecrire)) {
    $tab = file($ecrire);  // place le fichier dans un tableau
    $Manytimedepreciated = count($tab);    // compte le nombre de ligne
    
} 

       if($Bien->Methode=="Lineaire"){
       	//Calcul du temps deja ecoulé dans l'anné, on considere que l'année a 360 jours  c-a-d 360/12 chaque moi
        
        if ($Manytimedepreciated==0) {
            $Elasped_time = $Bien->MMoi*30; // Le jour ecoulé par rapport au moi actuel - 1 c-a-d si moi actuel= 9 donc 9-1
        // calcule de jour ecoulé dans le moi actuel, nous allons tester que le jour actuel n'est pas 31 vu que on considere qu'un mois a 30 jours max.
          if ($Elasped_time!=360) {
            if ($Bien->MJour!=31) {
              $days = 30-$Bien->MJour+1;
              $Elasped_time -= $days; 
            }
              $remaing_time = 360-$Elasped_time;
              $depreciation_amount = ($Bien->Montant*($remaing_time/360)*$Bien->Taux)/100;
          }else{
             $depreciation_amount = ($Bien->Montant*$Bien->Taux)/100;
          }
        }else{
           $Elasped_time = $Bien->Moi*30; // Le jour ecoulé par rapport au moi actuel - 1 c-a-d si moi actuel= 9 donc 9-1
        // calcule de jour ecoulé dans le moi actuel, nous allons tester que le jour actuel n'est pas 31 vu que on considere qu'un mois a 30 jours max.

           if ($Elasped_time!=360) {
              if ($Bien->Jour!=31) {
                $days = 30-$Bien->Jour;
                $Elasped_time -= $days; 
              }
            $depreciation_amount = ($Bien->Montant*($Elasped_time/360)*$Bien->Taux)/100;
           }else{
             $depreciation_amount = ($Bien->Montant*$Bien->Taux)/100;
          }
        }
    }
    return $depreciation_amount;
    }
}
