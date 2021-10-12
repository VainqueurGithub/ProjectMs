<?php
namespace App\Interfaces;

interface IMedicamentservice{

  public function fetchtAll();

  public function deleteData($id);

  public function savedata($request, $id);

  public function showData($id);

   //Fx pour verifier qu'un partenaire n'a pas + 1 medicament avec le meme code cas d'ajout
    public function UniqueMedicament ($Libelle);
    //Fx pour verifier qu'un partenaire n'a pas + 1 medicament avec le meme code cas de modification
    public function UniqueMedicamentModify ($Libelle, $id);

    //Sauvegarder le Changement du Prix
    public function ChangerPrixStore($request, $Medicament);

    //Historique de prix
    public function Historique($Med);
}
?>