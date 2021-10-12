<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class historiqueCotisationMontant extends Model
{
    protected $table = 'historique_cotisation_montants';
    protected $fillable = ['Affilier_id', 'Montant', 'Mois', 'Annee'];
    
}
