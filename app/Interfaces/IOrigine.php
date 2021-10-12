<?php
namespace App\Interfaces;

interface IOrigine{

	/** 
       AFFICHE TOUS LES ORIGINES

	**/
   public function fetchtAll();

   	/** 
       CREER UN NOUVEAU QUARTIER

	**/
//public function saveData($request, $id);
 

 
   	/** 
       SUPPRIMER UN QUARTIER

	**/
  public function deleteData($id);

  public function showData($id);
}
?>