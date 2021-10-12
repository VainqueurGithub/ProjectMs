<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Utilisateur;
use App\Models\Partenaire;
use App\Models\Parametre;
use\App\Models\ExerciceComptable;
use App\Http\Requests;
use Carbon\Carbon;
class ConnexionController extends Controller
{
    public function index()
	{
      	return view('welcome');
	}
    public function Verification(Request $request)
    { 
      $request->Password = sha1($request->PassWord);

    //On Test si l'utilisateur Existe dans la BDD

       $UtilisateurNbre = Utilisateur::whereEtatAndEmailAndMotdepasse(0,$request->UserName,$request->Password)->count();

  if ($UtilisateurNbre>0) 
  {
      $Utilisateur = Utilisateur::whereEtatAndEmailAndMotdepasse(0,$request->UserName,$request->Password)->first();
      
      	if ($Utilisateur->Email == $request->UserName AND $Utilisateur->MotdePasse == $request->Password) 
      	{
          $request->session()->put('id',$Utilisateur->id);
      	  $request->session()->put('Nom',$Utilisateur->Nom);
      	  $request->session()->put('Prenom',$Utilisateur->Prenom);
      	  $request->session()->put('Email',$Utilisateur->Email);
      	  $request->session()->put('Etat',$Utilisateur->Etat);
          $request->session()->put('Profil','User');
          $request->session()->put('Fonction',$Utilisateur->Profil);
          
          //ON VERIFIE S'IL Y A UN EXERCICE OUVERT
                $NbreExercice = ExerciceComptable::whereEtatAndCloturer(0,0)->count('id'); 
                if ($NbreExercice>0) { // CAS OU IL Y A UN EXERCICE OUVERT
                    $Exercice = ExerciceComptable::whereEtatAndCloturer(0,0)->first();
                }else{ // CAS OU IL N'Y A PAS 
                    $Exercice = new ExerciceComptable;
                }
                
                $request->session()->put('ExerciceDevise', $Exercice->Devise);
                $request->session()->put('ExerciceNbreDecimal', $Exercice->NbreDecimal);
                $request->session()->put('ExerciceSeparateurDecimal', $Exercice->separateurDecimal);
                $request->session()->put('ExerciceseparateurMilieu', $Exercice->separateurMilieu);
                $request->session()->put('ExerciceComptableId', $Exercice->id);
                $request->session()->put('ExerciceComptableDebut', $Exercice->Debut);
                $request->session()->put('ExerciceComptableFin', $Exercice->Fin);

               //Recuperer les informations generales de L'entreprise
                $NbreInfo = Parametre::where('entete', '!=', '')->where('footer', '!=', null)->count('id');
                if($NbreInfo > 0){
                    
                $InfoGeneral = Parametre::where('entete', '!=', '')->where('footer', '!=', null)->first();
                 
                $request->session()->put('Nom_Societe', $InfoGeneral->nom_societe);
                $request->session()->put('Nif', $InfoGeneral->nif);
                $request->session()->put('email', $InfoGeneral->email);
                $request->session()->put('Telephone', $InfoGeneral->telephone);
                $request->session()->put('Adresse', $InfoGeneral->adresse);
                $request->session()->put('BqnomUn', $InfoGeneral->bq_nom_un);
                $request->session()->put('BqnumUn', $InfoGeneral->bq_num_un);
                $request->session()->put('BqnomDeux', $InfoGeneral->bq_nom_deux);
                $request->session()->put('BqnumDeux', $InfoGeneral->bq_num_deux);
                $request->session()->put('Headerfile', $InfoGeneral->entete);
                $request->session()->put('Footerfile', $InfoGeneral->footer);
                    
                }else{
                 //   $InfoGeneral = InfoGeneral::where('entete', '!=', '')->where('entete', '!=', null)->first();
                 
                $request->session()->put('Nom_Societe', "");
                $request->session()->put('Nif', "");
                $request->session()->put('email', "");
                $request->session()->put('Telephone', "");
                $request->session()->put('Adresse', "");
                $request->session()->put('BqnomUn', "");
                $request->session()->put('BqnumUn', "");
                $request->session()->put('BqnomDeux', "");
                $request->session()->put('BqnumDeux', "");
                $request->session()->put('Headerfile', "");
                $request->session()->put('Footerfile', "");
                }
          $ToDay = Date("Y-m");
          $CurrentYear = Date("Y");
          $request->session()->put('yearcurrent', $CurrentYear);
          $request->session()->put('periodbeg', $ToDay."-01");
          $request->session()->put('periodend', $ToDay."-31");
      		return redirect(route('TableauDeBord'));
      	}
      	else
      	{
      		session()->flash('ErrorAu', 'Vos Parametres de Connexion sont érronés');
      		return view('welcome');
      	}
  }
  else
  {
    session()->flash('ErrorAu', 'Vos Parametres de Connexion sont érronés');
          return view('welcome');
  }    
}
 
 public function VerifLogin(Request $request)
 {
   $request->Password = sha1($request->PassWord);

    //On Test si le Partenaire Existe dans la BDD

       $PartenaireNbre = Partenaire::whereEtatAndCodeAndMotdepasse(0,$request->UserName,$request->Password)->count();

  if ($PartenaireNbre>0) 
  {
      $Partenaire = Partenaire::whereEtatAndCodeAndMotdepasse(0,$request->UserName,$request->Password)->first();
      
        if ($Partenaire->Code == $request->UserName AND $Partenaire->MotdePasse == $request->Password) 
        {
          $request->session()->put('id',$Partenaire->id);
          $request->session()->put('Paterner',$Partenaire->id);
          $request->session()->put('Nom',$Partenaire->Partenaire);
          $request->session()->put('Code',$Partenaire->Code);
          $request->session()->put('AdhesionMin',$Partenaire->AdhesionMin);
          $request->session()->put('Profil','Partenaire');
          $request->session()->put('Etat',$Partenaire->Etat);
          return redirect(route('Affiliers.index'));
        }
        else
        {
          session()->flash('ErrorAu', 'Vos Parametres de Connexion sont érronés');
          return redirect(route('Login'));
        }
  }
  else
  {
    session()->flash('ErrorAu', 'Vos Parametres de Connexion sont érronés');
          return redirect(route('Login'));
  }    
 }

  public function Deconnexion(Request $request)
  {
    $request->session()->flush();
    $User = session()->get('Profil');
    $request->session()->put('User',$User);
    if($User == 'User')
    {
      return redirect(route('index'));
    }
    else 
    {
      return redirect(route('Login'));
    }
  }
}
