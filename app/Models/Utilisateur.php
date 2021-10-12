<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Utilisateur extends Model
{
    protected $fillable = ['Nom', 'Prenom', 'Email', 'MotdePasse', 'Etat', 'Auteur', 'Profil'];
}
