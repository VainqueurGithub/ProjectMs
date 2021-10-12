<?php
namespace App\Interfaces;

interface IAffilie{

	/** 
    AFFICHE TOUS LES AFFILIES AVEC LEUR ORIGINE

	**/
   public function fetchtAll($Code);

   	/** 
       CREER UN NOUVEAU QUARTIER

	**/
   public function saveData($request, $id);
 

 
   	/** 
       SUPPRIMER UN QUARTIER

	**/
   public function deleteData($id);

   public function multidelete($request);

   public function showData($id);

   public function AffilierByOrigine($id);
    public function AffilieRedondance();
}
?>