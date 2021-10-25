<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class guichets extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'comptesubd_id', 'souscompte_id'];
}
