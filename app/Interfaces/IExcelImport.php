<?php
namespace App\Interfaces;

interface IExcelImport{

	// UPLOADAGE DES AYANTS DROITS D'UN AFFILIE PRECIS

	public function uplodaAyantDroit($request);

	// UPLOADAGE DES AFFILIES SELON L'ORIGINE

	public function uploadAffilier($request);

    // UPLOADAGE DES SERVICES POUR UN PARTENAIRE PRECIS

    public function uploadService($request); 

    public function uploadIntialBilan($request); 
}
?>