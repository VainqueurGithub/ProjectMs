<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\biens;
class Depreciationtype extends Model
{
    protected $fillable = ['Type', 'Etat'];

    //FX POUR VERIFIER UNICITE DU TYPE DANS LA TABLE
    public static function uniqueType($type){
       $Nbre = Depreciationtype::whereEtatAndType(0, $type)->count();

       if ($Nbre!=0) {
       	  return false;
       }else{
       	return true;
       }
    }

    public function bien(){
      return $this->hasMany(biens::class, 'Type');
    }
}
