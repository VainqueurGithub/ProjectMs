<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AffilierPartenaire extends Model
{
    protected $fillable = ['Affilier', 'Partenaire','Etat', 'Auteur','SA','Hospitalisation', 'Maternite', 'Service'];
}
