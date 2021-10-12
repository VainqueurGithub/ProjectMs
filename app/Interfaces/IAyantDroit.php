<?php
namespace App\Interfaces;
interface IAyantDroit{

	/** 
       AFFICHE TOUS LES AYANTS SELON UN AFFILIE

	**/
   public function selectayantdroitbyaffilier($id);

   	/** 
       AFFICHER L'AYANT DROIT AVEC SON AFFILIE PARENT

	**/
    public function fetchAll();
 
    public function saveData($request, $id);
    public function showData($id);
 
   	/** 
       SUPPRIMER UN QUARTIER

	**/
  // public function deleteData($id);
}
?>