<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicamentPartenaire extends Model
{
    protected $fillable = ['partenaire', 'prix', 'code', 'designation', 'medicament'];
}
