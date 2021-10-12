<?php
namespace App\Interfaces;

interface IFacture{

	/** 
       AFFICHE TOUS LES SERVICES

	**/
   public function fetchtAll();

   	/** 
       CREER UN NOUVEAU QUARTIER

	**/
//public function saveData($request, $id);
 

 
   	/** 
       SUPPRIMER UN QUARTIER

	**/
  // public function deleteData($id);

  public function showData($id);
}
?>