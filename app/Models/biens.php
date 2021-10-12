<?php

namespace App\Models;
use App\Models\Depreciationtype;
use App\Models\CompteSubdivisionnaire;
use App\Models\SousCompte;
use Illuminate\Database\Eloquent\Model;

class biens extends Model
{
    protected $fillable = ['Nom', 'Type', 'Date_acquis', 'Moyen_acquis', 'Mis_service', 'Montant', 'Duree', 'Taux', 'Methode', 'Provenance', 'Etat', 'Last_depreciation', 'Compte_subd1', 'Compte_sous1', 'Duree_utilise', 'Compte_subd2', 'Compte_sous2'];

    public function type_bien(){
    	return $this->hasOne(Depreciationtype::class, 'Type');
    }

        public function compte_subdiv(){
        return $this->belongsTo(CompteSubdivisionnaire::class, 'Compte');
    }

    public function sous_compte(){
        return $this->belongsTo(SousCompte::class, 'Sous_compte');
    }
}
