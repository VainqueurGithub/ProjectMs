<?php

namespace App\Models;
use App\Models\Type;
use App\Models\CodeJournaux;
use App\Models\CompteSubdivisionnaire;
use App\Models\Repportage;
use Illuminate\Database\Eloquent\Model;

class ComptePrincipal extends Model
{
    protected $fillable = ['NumeroCompte', 'Intitule', 'TypeCompte', 'Categorie', 'Etat', 'Appartenance', 'resultat_exercice', 'soldeJournalier'];

    public static function UniqueCompte($value)
    {
    	$Nbre = ComptePrincipal::whereNumerocompte($value)->count('id');
    	if ($Nbre == 0) {
    		return true;
    	}
    }

    public function type(){
    	return $this->belongsTo(Type::class, 'TypeCompte');
    }

    public function compte_subdivionnaire(){
    	return $this->hasMany(CompteSubdivisionnaire::class, 'ComptePricipal');
    }

    public function codejournaux(){
        return $this->belongsToMany(CodeJournaux::class, 'CompteJournal', 'Compte', 'Journal');
    }

    public function repportage(){
        return $this->hasMany(Repportage::class, 'compte_id');
    }
}
