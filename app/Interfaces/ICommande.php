<?php
namespace App\Interfaces;

interface ICommande{

	/** 
    AFFICHE TOUS LES AFFILIES AVEC LEUR ORIGINE

	**/
  

   	/** 
       CREER UNE COMMANDE

	**/
   public function saveData($request, $id);
 

 
   	/** 
       CALCULER LES LIMITER

	**/
   public function CalculLimite($TyTraitement, $MontantCommande, $Affilier, $Type);

   
   // NOMBRE DE COMMANDE PAR FACTURE

   public function NbreCommande($facture);


   // MONTANT TOTAL DE COMMANDES D'UNE FACTURE
   public function MontantCommande($facture);


  // 
  // public function MontantCommande($facture);

   public function Attributionamountmonth($Month, $Insuranceamount, $Bill, $id);

}
?>