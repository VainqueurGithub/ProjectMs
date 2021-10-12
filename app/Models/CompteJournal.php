<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompteJournal extends Model
{
    protected $fillable=['Compte', 'Journal', 'etat'];

    public static function UniqueInsert($value1, $value2){
    	$Nbre = CompteJournal::whereCompteAndJournal($value1,$value2)->count('id');

    	if($Nbre==0){
    		return true;
    	}else{
    		return false;
    	}
    }

    public static function UniqueUpdate($value1, $value2,$id){
    	$Nbre = CompteJournal::whereCompteAndJournal($value1,$value2)->where('id', '!=', $id)->count('id');

    	if($Nbre==0){
    		return true;
    	}else{
    		return false;
    	}
    }
}
