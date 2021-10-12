<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Interfaces\IFacture as IFacture;
class Facture extends Model implements IFacture
{   
	protected $table = 'factures';
    protected $fillable = ['NumFacture', 'Affilier', 'Beneficiaire', 'Partenaire', 'Montant', 'DatePayement', 'ModePayement', 'PCNuit', 'UniteMaternite', 'ElseUniteMaternite', 'Pharmacie', 'Annee', 'Etat', 'PieceIndentite', 'Telephone', 'Mois', 'DateTraitement', 'DateTransimission', 'Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Semptembre', 'Octobre', 'Novembre', 'Decembre', 'AnneeT', 'TypeTraitement', 'SAAT', 'ComptantAffilier', 'Auteur', 'Auteurtype'];
   

   public function fetchtAll(){
    	 return	$this->where('Etat', 0)->get();
    }


    public function showData($id){
    	 return	$this::findOrFail($id);
    }
}
