<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Historiquemedicaments extends Model
{
    protected $fillable = ['Medicament', 'Prix', 'Debut', 'Fin'];
}
