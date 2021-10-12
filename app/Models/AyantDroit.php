<?php

namespace App\Models;

use App\Interfaces\IAyantDroit as IAyantDroit;
use Illuminate\Database\Eloquent\Model;
use Origine;
use App\Models\AyantDroit;
use DB;

class AyantDroit extends Model implements IAyantDroit
{ 
	protected $table = 'ayant_droits';
    protected $fillable = ['Nom', 'Prenom', 'Affilier', 'Etat', 'Lien', 'status', 'Code'];

    public function selectayantdroitbyaffilier($id){
    	return $this::whereEtatAndAffilier(0,$id)->get();
    }
 

    public function fetchAll(){

      	$AyantDroits= DB::table('ayant_droits')
                     ->join('affiliers', 'affiliers.id', '=', 'ayant_droits.Affilier')
                     ->select(DB::raw('ayant_droits.id,ayant_droits.Etat,ayant_droits.Affilier,ayant_droits.Nom,ayant_droits.Prenom,ayant_droits.Lien,ayant_droits.created_at,affiliers.Code, affiliers.Etat')) 
                     ->where('ayant_droits.Etat',0) 
                     ->where('affiliers.Etat','!=', 2)
                     ->groupBy('ayant_droits.id')
                     ->get();

        return $AyantDroits;             
    }

    public function showData($id){
    	return $this::findOrFail($id);
    }

    public function saveData($request, $id){
       

       //ICI ON INSERE LES DONNEES DANS LA BASE DE DONNEES
    	if (is_null($id)) {
    		

    		if (isset($request->Lien) && !empty($request->Lien) AND $request->Lien != 'Autres') 
            {
                 $this::create([
                'Code' => $request->Code,
                'Nom' => $request->Nom,
                'Prenom' => $request->Prenom,
                'Affilier' => $request->Affilier,
                'Lien' => $request->Lien,
                'status'=>1
                ]);
            }
            elseif (isset($request->LienA) && !empty($request->LienA)) 
            {
                $this::create([
                'Code' => $request->Code,    
                'Nom' => $request->Nom,
                'Prenom' => $request->Prenom,
                'Affilier' => $request->Affilier,
                'Lien' => $request->LienA,
                'status'=>1
                ]);
            }

    	}
    	else{


    		$AyantDroit = $this->showData($id);

            if (isset($request->Lien) && !empty($request->Lien) && $request->Lien != 'Autres') 
            { 
                $AyantDroit->update([
                'Code' => $request->Code,
                'Nom' => $request->Nom,
                'Prenom' => $request->Prenom,
                'Affilier' => $request->Affilier,
                'Lien' => $request->Lien
                ]);
            }
            elseif (isset($request->LienA) && !empty($request->LienA)) 
            {
                $AyantDroit->update([
                'Code' => $request->Code,    
                'Nom' => $request->Nom,
                'Prenom' => $request->Prenom,
                'Affilier' => $request->Affilier,
                'Lien' => $request->LienA
                ]);
            }
    	}
    }
}
