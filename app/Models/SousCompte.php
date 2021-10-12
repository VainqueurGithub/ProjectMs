<?php

namespace App\Models;
use App\Models\CompteSubdivisionnaire;
use Illuminate\Database\Eloquent\Model;

class SousCompte extends Model
{
     protected $fillable = ['NumeroCompte', 'Intitule', 'Compte_subd', 'Etat'];

    public static function UniqueCompte($value)
    {
    	$Nbre = SousCompte::whereNumerocompte($value)->count('id');
    	if ($Nbre == 0) {
    		return true;
    	}
    }

    public function compte_subdivionnaire(){
        return $this->belongsTo(CompteSubdivisionnaire::class, 'Compte_subd');
    }
}
