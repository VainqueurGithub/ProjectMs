<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ExerciceComptable;
use App\Models\CompteSubdivisionnaire;
use App\Models\SousCompte;
class Journal extends Model
{
    protected $fillable = ['Ordre', 'Compte', 'TypeMvt', 'DateOperation', 'Piece', 'MD', 'MC', 'Etat','Exercice', 'Libelle', 'Sous_compte'];
    
    //To verify that only one Acount Number is set (Debit Account Or Credit Account)
    public static function UniqueFillfieldAcountNumber($v1,$v2)
    {
    	if((!empty($v1) AND empty($v2)) OR (!empty($v2) AND empty($v1))){
    		return true;
    	}
    }
    
    //To verify that only one Amount column is set (Debit Amount Or Credit Amount)
    public static function UniqueFillfieldAmount($v1,$v2)
    {
    	if((!empty($v1) AND empty($v2)) OR (!empty($v2) AND empty($v1))){
    		return true;
    	}
    }

   //To verify if Debit Account setted is matching with the Amount Column
    public static function matchingSetting($v1,$v2,$v3,$v4)
    {
        if((!empty($v1) AND !empty($v2)) AND (empty($v3) AND empty($v4))){
            return true;
        }elseif((empty($v1) AND empty($v2)) AND (!empty($v3) AND !empty($v4))){
            return true;
        }else{
            return false;
        }
    }

    public static function changeeditorialmode($Exercice){
        $Exe = ExerciceComptable::findOrFail($Exercice);
        $Exe->update([
            'Editorial_mode'=>1
        ]);
    }
 
    public function compte_subdiv(){
        return $this->belongsTo(CompteSubdivisionnaire::class, 'Compte');
    }

    public function sous_compte(){
        return $this->belongsTo(SousCompte::class, 'Sous_compte');
    }
}
