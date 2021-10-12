<?php

namespace App\Models;
use App\Models\ComptePricipal;
use App\Models\SousCompte;
use App\Models\journal;
use Illuminate\Database\Eloquent\Model;

class CompteSubdivisionnaire extends Model
{
    protected $fillable = ['NumeroCompte', 'Intitule', 'ComptePricipal', 'Etat', 'resultat_exercice'];

    public static function UniqueCompte($value)
    {
    	$Nbre = CompteSubdivisionnaire::whereNumerocompte($value)->count('id');
    	if ($Nbre == 0) {
    		return true;
    	}
    }

    public static function UniqueResultatExercicePerte(){
        $Nbre = CompteSubdivisionnaire::whereResultatExercice(1)->count('id');
        if ($Nbre == 0) {
            return true;
        }
    }

    public static function UniqueResultatExerciceBenefice(){
        $Nbre = CompteSubdivisionnaire::whereResultatExercice(2)->count('id');
        if ($Nbre == 0) {
            return true;
        }
    }

    public function compteprincipal(){
        return $this->belongsTo(ComptePrincipal::class, 'ComptePricipal');
    }

    public function souscompte(){
        return $this->hasMany(SousCompte::class, 'Compte_subd');
    }

    public function journal(){
        return $this->hasMany(journal::class, 'Compte');
    }
}
