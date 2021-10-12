<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class soldeJournalier extends Model
{
    use HasFactory;
    protected $fillable = ['Comptesudb', 'Souscompte', 'dateOperation', 'repporterAu', 'montant'];
}
