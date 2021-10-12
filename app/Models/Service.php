<?php

namespace App\Models;

use App\Interfaces\IService as IService;
use Illuminate\Database\Eloquent\Model;

class Service extends Model implements IService
{   

	protected $table = 'services';
    protected $fillable = ['Service', 'Traitement', 'Etat'];

    public function setServiceAttribute($value)
    {
        $this->attributes['Service'] = strtoupper($value);
    }

    public function fetchtAll(){
    	 return	$this->where('Etat', 0)->get();
    }


    public function showData($id){
    	 return	$this::findOrFail($id);
    }
}
