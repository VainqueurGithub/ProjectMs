<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class CompteRepport extends Model
{
    protected $fillable = ['NumeroCompte', 'Type_compte', 'Etat'];

    public static function UniqueCompte($value)
    {
    	$Nbre = CompteRepport::whereNumerocompte($value)->count('id');
    	if ($Nbre == 0) {
    		return true;
    	}
    }
}
