<?php

namespace App\Models;
use App\Interfaces\IOrigine as IOrigine;
use Illuminate\Database\Eloquent\Model;

class Origine extends Model implements IOrigine
{
	protected $table = 'origines';
    protected $fillable = ['Origine', 'Etat'];

    public function fetchtAll(){
    	 return	$this->where('Etat', 0)->get();
    }


    public function showData($id){
    	 return	$this::findOrFail($id);
    }


    public function deleteData($id){
    	 $Origine = $this->showData($id);
  
        $Origine->update([
            'Etat' => 1
        ]);

         session()->flash('messageDelete', 'Origine(s) supprimé(s) avec success');
    }

}
