<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Interfaces\IExcelImport as IExcelImport;

use App\Models\AyantDroit;
use App\Models\Affilier;
use App\Models\MedicamentPartenaire;
use App\Models\Repportage;
use App\Models\medicamentsservice;
use App\Models\Historiquemedicaments;
//use Excel;
//use Input;

//use App\Exports\UsersExport;

use App\Imports\AyantDroitImport;
use App\Imports\MedicamentPartenaireImport;
use App\Imports\RepportageImport;
use Maatwebsite\Excel\Facades\Excel;

class ExcelImport extends Model implements IExcelImport
{   
    
    //CETTE FONCTION VA IMPORTER LES AFFILIER D'UNE ORIGINE PRECISE DANS UN FICHIER EXCEL
	public function uploadAffilier($request){
         
        //  //J'ouvre mon fichier en ecriture:
        //  $ecrire = fopen('codesumulaire.txt',"w");

        //  //Je tronque mon fichier jusqu'au pointeur en position 0.
        //  ftruncate($ecrire,0);

        // set_time_limit(0); //Augmenter le temps de chargement d'une page lors de l'importation        
        // $Today = date('Y-m-d');        
        // $extensions = array("xls","xlsx","xlm","xla","xlc","xlt","xlw", "csv");  //Constitution d'un tableau des extensions acceptables

        // $result = array($request->file('fichier')->getClientOriginalExtension()); // Recuperation du contenu de notre fichier

        // if(in_array($result[0],$extensions)){ // Verification de l'extension du fichier
        //   // Do something when Succeeded 

        //     $data = Excel::load(Input::file('fichier'), function($reader) {})->get(); //Lecture du contenu de notre fichier
        //     if(!empty($data) && $data->count()){ //on test si le fichier contient quelque chose

        //         foreach ($data->toArray() as $key => $value) { //Parcours de notre fichier
           
        //             //On verifie si toutes les colonnes de notre fichier sont remplies
        //             if (!empty($value['code']) && !empty($value['nom']) && !empty($value['prenom']) && !empty($value['anneenaissance']) && !empty($value['adresse']) && !empty($value['piece']) && !empty($value['telephone']) && !empty($value['dateentree']) && !empty($value['limitelaboratoire']) && !empty($value['limitekinesitherapie']) && !empty($value['limitereanimation']) && !empty($value['limiteimageriemedicale']) && !empty($value['cotisation']) && !empty($value['sa']) && !empty($value['hopplafchambre']) && !empty($value['hpcnuit']) && !empty($value['limitehospgenerale']) && !empty($value['limitematernite']) && !empty($value['couverturematernite']) && !empty($value['pharmacie']) && !empty($value['limitesmedicaments']) && !empty($value['limiteslunettes']) && !empty($value['limitesdents'])) {

        //                 $CurrentYear = date('Y');
        //                 //Verification de L'unicite du code et de la piece d'identification
        //                 $NbreCode = Affilier::whereCode($value['code'])->where('Etat', '!=', 2)->count();
        //                 $NbrePiece = Affilier::wherePieceindentite($value['piece'])->count();
       
        
        //                 if ($NbreCode == 0) 
        //                 {  
        //                     if ($NbrePiece == 0) 
        //                     {
        //                         Affilier::create([
        //                         'Code' => $value['code'],
        //                         'Nom' => $value['nom'],
        //                         'Prenom' => $value['prenom'],
        //                         'Origine' => $request->Origine,
        //                         'DateEntree' => $value['dateentree'],
        //                         'CotisationM' => $value['cotisation'],
        //                         'SoinsAmbilatoire' => $value['sa'],
        //                         'PlafondChambre' => $value['hopplafchambre'],
        //                         'PCNuit' => $value['hpcnuit'],
        //                         'UniteMaternite' => $value['limitematernite'],
        //                         'ElseUniteMaternite' => $value['couverturematernite'],
        //                         'Pharmacie' => $value['pharmacie'],
        //                         'Annee' => $CurrentYear,
        //                         'PieceIndentite' => $value['piece'],
        //                         'Telephone' => $value['telephone'],
        //                         'DateNaiss' => $value['anneenaissance'],
        //                         'Lunette' => $value['limiteslunettes'],
        //                         'dents' => $value['limitesdents'],
        //                         'Hospitalisation'=>$value['limitehospgenerale'],
        //                         'imagerie'=>$value['limiteimageriemedicale'],
        //                         'reanimation'=>$value['limitereanimation'],
        //                         'kinesie'=>$value['limitekinesitherapie'],
        //                         'labo'=>$value['limitelaboratoire'],
        //                         'Adresse' => $value['adresse'],
        //                         'Medicament' => $value['limitesmedicaments']
        //                         ]);
                               
        //                        //Enregistrement de l'affilier lui meme entant qu'un ayant droit a son propre compte
        //                         $MaxId = Affilier::all()->max('id');
        //                            AyantDroit::create([
        //                             'Affilier' =>$MaxId,
        //                             'Nom' => $value['nom'],
        //                             'Prenom' => $value['prenom'],
        //                             'Lien' => 'Lui meme'
        //                         ]);

        //                          session()->flash('message', 'Fichier chargé completement avec success, '. $data->count().' Enregistrements ont été ajoutés');
        //                     }
        //                     else
        //                     {
        //                         //session()->flash('messageDelete', 'Cette Piece existe deja');
        //                          file_put_contents('codesumulaire.txt', "\n".$value['piece'], FILE_APPEND);  
        //                     }
        //                 }
        //                 else
        //                 {
        //                   //session()->flash('messageDelete', 'Ce Code est deja Attribué'); 
        //                   file_put_contents('codesumulaire.txt', "\n".$value['code'], FILE_APPEND);  
        //                 }   
        //             }else{
        //                  session()->flash('messageDelete', 'Erreur de chargement vous avez tenté de Changer un fichier vide ou incomplet');
        //             }    
        //         }
        //     }else{
        //         session()->flash('messageDelete', 'Une erreur s\'est produit lors du chargement');
        //     }
        // }
        // else{
        //     session()->flash('messageDelete', 'Erreur pendant le Telechargement du fichier');
        // }
        //  // Nom du fichier à ouvrir
        // $fichier = file("codesumulaire.txt");

        // return redirect(route('Origines.index', compact('fichier')));
    }
    
    
    
    
    
    
    
    

    //CETTE FONCTION VA IMPORTER LES SERVICES D'UN PARTENAIRE PRECIS DANS UN FICHIER EXCEL
    public function uploadService($request){
       
    	set_time_limit(0);  
        Excel::import(new MedicamentPartenaireImport,request()->file('services'));      

    }


    //CETTE FONCTION VA IMPORTER LES AYANT DROIT D'UN AFFILIER PRECIS DANS UN FICHIER EXCEL
    public function uplodaAyantDroit($request){

    	set_time_limit(0); 
        Excel::import(new AyantDroitImport,request()->file('fichier'));
    }


    public function uploadIntialBilan($request){

        set_time_limit(0); 
        Excel::import(new RepportageImport,request()->file('file'));
    } 
    
    
    //CETTE FONCTION VA IMPORTER LES AYANT DROIT D'UNE ORIGINE PRECISE DANS UN FICHIER EXCEL
    public function uplodaAyantDroitByOrigine($request){

    // 	set_time_limit(0);               
    //     $extensions = array("xls","xlsx","xlm","xla","xlc","xlt","xlw", "csv");
    //     $result = array($request->file('fichier')->getClientOriginalExtension());

    //     if(in_array($result[0],$extensions)){
          

    //         $data = Excel::load(Input::file('fichier'), function($reader) {})->get();
    //         if(!empty($data) && $data->count()){

    //             foreach ($data->toArray() as $key => $value) {
           
    //                 if (!empty($value['code']) &&!empty($value['lien']) && !empty($value['nom']) && !empty($value['prenom'])) {
                        
    //                     $Affilie = Affilier::whereEtatAndCode(0,$value['code'])->first();
                        
    //                     if(is_null($Affilie)){
                            
    //                     }else{
    //                         AyantDroit::create([
    //                         'Nom' => $value['nom'],
    //                         'Prenom' => $value['prenom'],
    //                         'Affilier' => $Affilie->id,
    //                         'Lien' => $value['lien']
    //                     ]);
    //                     }
    //                     session()->flash('message', 'Fichier chargé completement avec success, '. $data->count().' Enregistrement(s) ajouté(s)');
    //                 }else{
    //                     session()->flash('messageDelete', 'Erreur de chargement vous avez tenté de Changer un fichier vide ou incomplet');
    //                 }    
    //             }
    //         }else{

    //             session()->flash('messageDelete', 'Une erreur s\'est produit lors du chargement');
    //         }
    //     }
    //     else{
    //         session()->flash('messageDelete', 'Erreur pendant le Telechargement du fichier');
    //     }
    // }

        set_time_limit(0); 
        Excel::import(new AyantDroitImport,request()->file('fichier'));
    }
}
