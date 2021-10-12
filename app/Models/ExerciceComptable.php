<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExerciceComptable extends Model
{
    protected $fillable = ['Debut', 'Fin', 'NbreDecimal', 'separateurDecimal', 'separateurMilieu', 'Etat', 'Devise', 'Cloturer', 'Editorial_mode'];

    public static function UniqueExercice ($Debut, $Fin)
    {
    	$NbreExercice = ExerciceComptable::whereDebutAndFin($Debut, $Fin)->count();
    	//$Diff = $Fin-$Debut;

    	if ($NbreExercice > 0) {
    		return false;
    	}else{
    		return true;
    	}
    }

    public static function VerifyNbreDecimal($value)
    {
    	if (preg_match("#[0-9]{1}#",$value)) {
    		return true;
    	}
    }

    public static function VerifyseparateurDecimalseparateurMilieu($value, $value1)
    {
    	if (preg_match("#^[,\.]$#",$value) AND preg_match("#^[,\.]$#",$value1)) {
    		return true;
    	}
    }
}
