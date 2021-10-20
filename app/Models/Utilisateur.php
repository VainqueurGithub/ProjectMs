<?php

namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Utilisateur extends Authenticable
{
	use HasFactory, HasRoles, Notifiable;
    protected $fillable = ['Nom', 'Prenom', 'Email', 'MotdePasse', 'Etat', 'Auteur', 'Profil'];
}
