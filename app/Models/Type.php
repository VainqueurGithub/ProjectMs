<?php

namespace App\Models;
use App\Models\ComptePrincipal;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $fillable = ['Class', 'Types', 'Etat','Type_Compte'];

    public static function UniqueTypeAcount($value)
    {
    	$NbreTypeAcount = Type::whereTypes($value)->count('id');
    	if ($NbreTypeAcount === 0) {
    		return true;
    	}
    }

    public static function uniqueClass($value)
    {
    	$NbreClass = Type::whereClass(strtoupper($value))->count('id');
    	if($NbreClass === 0){
    		return true;
    	}
    }

    public function setTypesAttribute($value){
         $this->attributes['Types'] = strtoupper($value);
    }

    public function compte_principal(){
        return $this->hasMany(ComptePrincipal::class, 'TypeCompte');
    }
}
