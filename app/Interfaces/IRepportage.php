<?php
namespace App\Interfaces;

interface IRepportage{
  
  //SOLDE DE COMPTE DES CHARGES ET DES PRODUITS
   public function cloturerchargeetproduit($request);
  //ARRET DES COMPTES DU GRAND LIVRE
   public function cloturergrandlivre($compte);
   //RECHERCHER DU COMPTE DE REPPORT DE RESULTAT 120 OR 129
   public function resultatexercicerepportedaccount($solde);
}
?>