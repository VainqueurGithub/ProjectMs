<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class compte_report_compte extends Model
{
    protected $fillable = ['compte_repport_id', 'compte_principale_id', 'etat'];
}
