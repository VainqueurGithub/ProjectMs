<?php

namespace App\models;
use App\Interfaces\IRepportage as IRepportage;
use App\Models\ComptePrincipal;
use Illuminate\Database\Eloquent\Model;
use App\Models\Repportage;
use DB;
class Repportage extends Model implements IRepportage
{
    protected $fillable = ['exercice_id', 'compte_id', 'comptesubd_id', 'montant', 'etat', 'reported_in', 'type_mvt'];
    public function compte_principal(){
    	return $this->belongsTo(ComptePrincipal::class, 'compte_id');
    }
    
    public function cloturerchargeetproduit($request){
        
        // SOLDE DE L'EXERCICE ANTERIEUR
        
        $SoldeAntExer =DB::table('repportages')
                      ->join('exercice_comptables', 'exercice_comptables.id', 'repportages.reported_in')
                      ->join('compte_subdivisionnaires', 'compte_subdivisionnaires.id', '=' ,'repportages.comptesubd_id') 
                      ->select(DB::raw('*'))
                      ->where('compte_subdivisionnaires.resultat_exercice', '!=', 0)
                      ->where('repportages.reported_in', session()->get('ExerciceComptableId'))
                      ->where('exercice_comptables.Editorial_mode', 0)
                      ->sum('montant');

        $SOLDE = 0;
    	// RECUPERATION DU MONTANT TOTAL DE DEBUT  POUR LES COMPTES DE PRODUIT 
        $ProduitD = DB::table('types')
            ->join('compte_principals', 'compte_principals.TypeCompte', '=', 'types.id')
            ->leftJoin('compte_subdivisionnaires', 'compte_subdivisionnaires.ComptePricipal', '=', 'compte_principals.id')
            ->leftJoin('journals', 'journals.Compte', '=', 'compte_subdivisionnaires.id')
            ->join('exercice_comptables', 'exercice_comptables.id','=','journals.Exercice')
            ->select(DB::raw('*'))
            ->where('types.Type_Compte', 2)
            ->where('types.Class', 7)
            ->where('journals.Exercice', session()->get('ExerciceComptableId'))
            ->where('exercice_comptables.Editorial_mode', 0)
            ->sum('journals.MD');
        
        // RECUPERATION DU MONTANT TOTAL DE CREDIT POUR LES COMPTES DE PRODUIT
        $ProduitC = DB::table('types')
            ->join('compte_principals', 'compte_principals.TypeCompte', '=', 'types.id')
            ->leftJoin('compte_subdivisionnaires', 'compte_subdivisionnaires.ComptePricipal', '=', 'compte_principals.id')
            ->leftJoin('journals', 'journals.Compte', '=', 'compte_subdivisionnaires.id')
            ->join('exercice_comptables', 'exercice_comptables.id','=','journals.Exercice')
            ->select(DB::raw('*'))
            ->where('types.Type_Compte', 2)
            ->where('types.Class', 7)
            ->where('journals.Exercice', session()->get('ExerciceComptableId'))
            ->where('exercice_comptables.Editorial_mode', 0)
            ->sum('journals.MC');    

        // RECUPERATION DU MONTANT TOTAL DE DEBUT  POUR LES COMPTES DE CHARGE 
        $ChargeD = DB::table('types')
            ->join('compte_principals', 'compte_principals.TypeCompte', '=', 'types.id')
            ->leftJoin('compte_subdivisionnaires', 'compte_subdivisionnaires.ComptePricipal', '=', 'compte_principals.id')
            ->leftJoin('journals', 'journals.Compte', '=', 'compte_subdivisionnaires.id')
            ->join('exercice_comptables', 'exercice_comptables.id','=','journals.Exercice')
            ->select(DB::raw('*'))
            ->where('types.Type_Compte', 2)
            ->where('types.Class', 6)
            ->where('journals.Exercice', session()->get('ExerciceComptableId'))
            ->where('exercice_comptables.Editorial_mode', 0)
            ->sum('journals.MD');
        
        // RECUPERATION DU MONTANT TOTAL DE CREDIT POUR LES COMPTES DE CHARGE
        $ChargeC = DB::table('types')
            ->join('compte_principals', 'compte_principals.TypeCompte', '=', 'types.id')
            ->leftJoin('compte_subdivisionnaires', 'compte_subdivisionnaires.ComptePricipal', '=', 'compte_principals.id')
            ->leftJoin('journals', 'journals.Compte', '=', 'compte_subdivisionnaires.id')
            ->join('exercice_comptables', 'exercice_comptables.id','=','journals.Exercice')
            ->select(DB::raw('*'))
            ->where('types.Type_Compte', 2)
            ->where('types.Class', 6)
            ->where('journals.Exercice', session()->get('ExerciceComptableId'))
            ->where('exercice_comptables.Editorial_mode', 0)
            ->sum('journals.MC'); 

        // RESULTAT DE L'EXERCICE
        $SOLDE = ($ProduitD-$ProduitC) - ($ChargeD-$ChargeC) + $SoldeAntExer;

        return $SOLDE;      
    }

    public function cloturergrandlivre($compte){

    	// RECUPERATION DU MONTANT TOTAL DE DEBUT  POUR UN COMPTE DU BILAN 
        $MontantD = DB::table('types')
            ->join('compte_principals', 'compte_principals.TypeCompte', '=', 'types.id')
            ->leftJoin('compte_subdivisionnaires', 'compte_subdivisionnaires.ComptePricipal', '=', 'compte_principals.id')
            ->leftJoin('journals', 'journals.Compte', '=', 'compte_subdivisionnaires.id')
            ->join('exercice_comptables', 'exercice_comptables.id','=','journals.Exercice')
            ->select(DB::raw('*'))
            ->where('types.Type_Compte', 1)
            ->where('compte_principals.resultat_exercice', 0)
            ->where('journals.Exercice', session()->get('ExerciceComptableId'))
            ->where('compte_principals.id', $compte)
            ->where('exercice_comptables.Editorial_mode', 0)
            ->sum('journals.MD');
        
        // RECUPERATION DU MONTANT TOTAL DE CREDIT POUR LES COMPTES DE CHARGE
        $MontantC = DB::table('types')
            ->join('compte_principals', 'compte_principals.TypeCompte', '=', 'types.id')
            ->leftJoin('compte_subdivisionnaires', 'compte_subdivisionnaires.ComptePricipal', '=', 'compte_principals.id')
            ->leftJoin('journals', 'journals.Compte', '=', 'compte_subdivisionnaires.id')
            ->join('exercice_comptables', 'exercice_comptables.id','=','journals.Exercice')
            ->select(DB::raw('*'))
            ->where('types.Type_Compte', 1)
            ->where('compte_principals.resultat_exercice', 0)
            ->where('compte_principals.id', $compte)
            ->where('journals.Exercice', session()->get('ExerciceComptableId'))
            ->where('exercice_comptables.Editorial_mode', 0)
            ->sum('journals.MC');

        // SOLDE DE L'EXERCICE ANTERIEUR
        
        $SoldeAntExer = DB::table('repportages')
            ->join('compte_principals', 'compte_principals.id', '=', 'repportages.compte_id')
            ->join('exercice_comptables', 'exercice_comptables.id','=','repportages.reported_in')
            ->select(DB::raw('*'))
            ->where('compte_principals.resultat_exercice', 0)
            ->where('compte_principals.id', $compte)
            ->where('repportages.reported_in', session()->get('ExerciceComptableId'))
            ->where('exercice_comptables.Editorial_mode', 0)
            ->sum('montant');

        $SOLDE = ($MontantD - $MontantC)+$SoldeAntExer;

        return $SOLDE;
    }

    public function resultatexercicerepportedaccount($solde){
          if ($solde<0) {
            $Compte = DB::table('types')
            ->join('compte_principals', 'compte_principals.TypeCompte', '=', 'types.id')
            ->leftJoin('compte_subdivisionnaires', 'compte_subdivisionnaires.ComptePricipal', '=', 'compte_principals.id')
            ->select(DB::raw('compte_principals.id, compte_subdivisionnaires.id as subdId'))
            ->where('compte_subdivisionnaires.resultat_exercice', 1)
            ->first();
          }else{
             $Compte = DB::table('types')
            ->join('compte_principals', 'compte_principals.TypeCompte', '=', 'types.id')
            ->leftJoin('compte_subdivisionnaires', 'compte_subdivisionnaires.ComptePricipal', '=', 'compte_principals.id')
            ->select(DB::raw('compte_principals.id, compte_subdivisionnaires.id as subdId'))
            ->where('compte_subdivisionnaires.resultat_exercice', 2)
            ->first();
          }

          return $Compte;
    }
}
