<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parametre extends Model
{
    protected $fillable = ['nom_societe', 'nif', 'email', 'telephone', 'adresse', 'bq_nom_un', 'bq_num_un', 'bq_nom_deux', 'bq_num_deux', 'entete', 'footer'];
}
