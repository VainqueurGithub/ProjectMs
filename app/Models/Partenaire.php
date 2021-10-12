<?php

namespace App\Models;

use App\Interfaces\IPartenaire as IPartenaire;
use Illuminate\Database\Eloquent\Model;

class Partenaire extends Model implements IPartenaire
{   
	protected $table = 'partenaires';
    protected $fillable = ['Code', 'Partenaire', 'Type', 'AdhesionMin', 'Annee', 'Etat', 'MotdePasse', 'account'];

    

    public function fetchtAll(){
    	 return	$this->where('Etat', 0)->get();
    }


    public function showData($id){
    	 return	$this::findOrFail($id);
    }
}
