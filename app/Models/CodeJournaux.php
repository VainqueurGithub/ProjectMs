<?php

namespace App\Models;
use App\Models\ComptePrincipal;
use Illuminate\Database\Eloquent\Model;

class CodeJournaux extends Model
{
    protected $fillable = ['Code', 'Journal', 'Etat'];

    public function setCodeAttribute($value){
    	$this->attributes['Code'] = strtoupper($value);
    }

     public function setJournalAttribute($value){
    	$this->attributes['Journal'] = strtoupper($value);
    }

    public static function uniqueCode($value)
    {
    	$Nbre = CodeJournaux::whereEtatAndCode(0, strtoupper($value))->count('id');

    	if ($Nbre==0) {
    		return true;
    	}else{
    		return false;
    	}
    }

    public static function uniqueCodeUpdate($value, $id)
    {
        $Nbre = CodeJournaux::whereEtatAndCode(0, strtoupper($value))->where('id', '!=', $id)->count('id');

        if ($Nbre==0) {
            return true;
        }else{
            return false;
        }
    }

    public function compteprincipal(){
        return $this->belongsToMany(ComptePrincipal::class, 'CompteJournal', 'Compte', 'Journal');
    }
}
