<?php

namespace App\Models;
use App\Models\Affilier;
use App\Models\AyantDroit;
use Illuminate\Database\Eloquent\Model;

class mouvement_affiliers extends Model
{
    protected $table = 'mouvent_beneficiaires';
    protected $fillable = ['beneficiaire_id', 'type_mvt', 'date_mvt', 'motif', 'type_beneficiaire', 'annee', 'Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre', 'mois','status'];
    protected $dates = ['date_mvt'];

    public static function getStatus($beneficiaire, $beneficiaire_type){
    	$MaxId  = mouvement_affiliers::whereBeneficiaireIdAndTypeBeneficiaire($beneficiaire,$beneficiaire_type)->max('id');
    	$Details = mouvement_affiliers::findOrFail($MaxId);

      //CAS D'UN AFFILIER
        if($beneficiaire_type==1){
           $Aff = Affilier::findOrFail($beneficiaire);
           //CAS D'UNE ENTREE
           if ($Details->type_mvt==1) {
           	   $Aff->update([
              	'status'=>0
              ]);
           }
           //CAS D'UNE SORTIE
           elseif ($Details->type_mvt==2) {
           	 $Aff->update([
              	'status'=>1
              ]);
           }
        }elseif ($beneficiaire_type==2) {
        	$AyantD = AyantDroit::findOrFail($beneficiaire);
        	//CAS D'UNE ENTREE
           if ($Details->type_mvt==1) {
           	   $AyantD->update([
              	'status'=>0
              ]);
           }
           //CAS D'UNE SORTIE
           elseif ($Details->type_mvt==2) {
           	 $AyantD->update([
              	'status'=>1
              ]);
           }
        }
    }
}
