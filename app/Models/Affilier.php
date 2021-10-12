<?php

namespace App\Models;
use App\Interfaces\IAffilie as IAffilie;
use Illuminate\Database\Eloquent\Model;
use Origine;
use App\Models\AyantDroit;
use App\Models\historiqueCotisationMontant;
use DB;
use Cache;
//use Redis;
class Affilier extends Model implements IAffilie
{

	  protected $table = 'affiliers';
    protected $fillable = ['Code', 'Nom', 'Prenom', 'Origine', 'CotisationM', 'SoinsAmbilatoire', 'PlafondChambre', 'PCNuit', 'UniteMaternite', 'ElseUniteMaternite', 'Pharmacie', 'Annee', 'Etat', 'PieceIndentite', 'Telephone', 'DateEntree', 'DateNaiss', 'Adresse', 'Medicament', 'Lunette', 'dents', 'labo', 'kinesie', 'reanimation', 'imagerie', 'Hospitalisation', 'status', 'profession', 'droit_adhesion', 'periode_observation', 'genre'];
    protected $dates = ['DateEntree'];
    
    // public function __construct(){
    //    $this->storage = Redis::Connection();
     
    // }
    //ON RECUPERE TOUTES LES DONNEES DES AFFILIES
       public function fetchtAll($CodeP){
       if(session()->get('Profil') == 'Partenaire')
       {  
           $results = Cache::remember('results', 120, function () { 
            //return DB::table('users')->get(); 
            return DB::table('affilier_partenaires')
                 ->join('affiliers', 'affilier_partenaires.Affilier', '=', 'affiliers.id')
                 ->join('origines', 'origines.id', '=', 'affiliers.Origine')
                ->select(DB::raw('affiliers.id,affiliers.Code, affiliers.Nom,affiliers.Prenom,affiliers.Origine,affilier_partenaires.Partenaire, origines.Origine,affiliers.status'))
                ->wherePartenaire(session()->get('id'))
                 ->where('affiliers.Etat',0)
                ->where('affiliers.Code','like','%'.$CodeP.'%')
                ->where('affilier_partenaires.Etat',0)
                ->groupBy('affiliers.id')
                ->get();     
            });    
        }else{
           $results = Cache::remember('results', 120, function () {
           return DB::table('affiliers')
                ->Leftjoin('affilier_partenaires','affilier_partenaires.Affilier' , '=', 'affiliers.id')
                ->join('origines', 'origines.id', '=', 'affiliers.Origine')
                ->select(DB::raw('affiliers.id,affiliers.Code, affiliers.Nom,affiliers.Prenom,affiliers.Origine,affilier_partenaires.Partenaire, origines.Origine,affiliers.status'))
                 ->where('affiliers.Code','like','%'.$CodeP.'%')
                ->where('affiliers.Etat',0)
                ->groupBy('affiliers.id')
                ->get();  
            });       
        }

        return $results;
    }

    public  function saveData($request, $id){
      
      //ON CREER UN NOUVEAU OBJECT
      if (is_null($id)) {
      	  
      	
          $CurrentYear = date('Y');
        //Verification de L'unicite du code
         
        $NbreCode = $this::whereCode($request->Code)->where('Etat', '!=', 2)->count();
        $NbrePiece = $this::wherePieceindentite($request->Piece)->count();
        //$NbreTelephone = Affilier::whereTelephone($request->Telephone)->where('Telephone', '!=', '')->count();
        
    if ($NbreCode == 0) 
    {  
       // if ($NbreTelephone == 0) 
       // {
            if ($NbrePiece == 0) 
            {
            $this::create([
            'Code' => $request->Code,
            'Nom' => $request->Nom,
            'Prenom' => $request->Prenom,
            'Origine' => $request->Origine,
            'DateEntree' => $request->DateEntree,
            'CotisationM' => $request->Cotisation,
            'SoinsAmbilatoire' => $request->SA,
            'PlafondChambre' => $request->HPC,
            'PCNuit' => $request->HPCN,
            'UniteMaternite' => $request->Maternite,
            'ElseUniteMaternite' => $request->MaterniteP,
            'Pharmacie' => $request->Pharmacie,
            'Annee' => $CurrentYear,
            'PieceIndentite' => $request->Piece,
            'Telephone' => $request->Telephone,
            'DateNaiss' => $request->DateNaiss,
            'Lunette' => $request->Lunette,
            'dents' => $request->dents,
            'Hospitalisation'=>$request->Hospitalisation,
            'imagerie'=>$request->Imagerie,
            'reanimation'=>$request->Reanimation,
            'kinesie'=>$request->Kinesitherapie,
            'labo'=>$request->Laboratoire,
            'Adresse' => $request->Adresse,
            'Medicament' => $request->Medicament,
            'profession'=> $request->Profession,
            'droit_adhesion'=> $request->DroitAdhesion,
            'periode_observation'=>$request->dateObservation,
            'genre'=>$request->gender,
            'Telephone'=>$request->Telephone,
            'status'=>1
        ]);
        
        $MaxId = $this::all()->max('id');

           AyantDroit::create([
            'Affilier' =>$MaxId,
            'Nom' => $request->Nom,
            'Prenom' => $request->Prenom,
            'Lien' => 'Lui meme',
            'status'=>1
        ]);
          
          //AJOUT DU MONTANT DANS L'HISTORIQUE  
            historiqueCotisationMontant::create([
               'affilier_id'=>$MaxId,
               'motant'=>$request->Cotisation
            ]);
            session()->flash('message', 'Affilier Crée avec success!');
            }
            else
            {
              session()->flash('messageDelete', 'Cette Piece existe deja');
            }
     }
     else
     {
       session()->flash('messageDelete', 'Ce Code est deja Attribué'); 
     }   




       //ON MODIFIE UN OBJECT
      }else{
         
          
        $Affilier = $this->showData($id);  
        //Verification de L'unicite du code
        $NbreCode = $this::whereCode($request->Code)->where('id', '!=',$id)->where('Etat', '!=', 2)->count();

        $NbrePiece = $this::wherePieceindentite($request->Piece)->where('id', '!=',$id)->count();
    if ($NbreCode == 0) 
    {  
        if ($NbrePiece == 0) 
        {
            $Affilier->update([
            'Code' => $request->Code,
            'Nom' => $request->Nom,
            'Prenom' => $request->Prenom,
            'Origine' => $request->Origine,
            'DateEntree' => $request->DateEntree,
            'CotisationM' => $request->Cotisation,
            'SoinsAmbilatoire' => $request->SA,
            'PlafondChambre' => $request->HPC,
            'PCNuit' => $request->HPCN,
            'UniteMaternite' => $request->Maternite,
            'ElseUniteMaternite' => $request->MaterniteP,
            'Pharmacie' => $request->Pharmacie,
            'PieceIndentite' => $request->Piece,
            'Telephone' => $request->Telephone,
            'DateNaiss' => $request->DateNaiss,
            'Adresse' => $request->Adresse,
            'Lunette' =>$request->Lunette,
            'dents' =>$request->dents,
            'Hospitalisation'=>$request->Hospitalisation,
            'imagerie'=>$request->Imagerie,
            'reanimation'=>$request->Reanimation,
            'kinesie'=>$request->Kinesitherapie,
            'labo'=>$request->Laboratoire,
            'Medicament' => $request->Medicament,
            'profession'=> $request->Profession,
            'droit_adhesion'=> $request->DroitAdhesion,
            'periode_observation'=>$request->dateObservation,
            'genre'=>$request->gender,
            'Telephone'=>$request->Telephone
        ]);
        
        $AyantDroit = AyantDroit::whereAffilierAndLien($id,'Lui meme')->first();
        $AyantDroit->update([
            'Affilier' =>$id,
            'Nom' => $request->Nom,
            'Prenom' => $request->Prenom,
            'Lien' => 'Lui meme'
        ]);

        session()->flash('message', 'Affilier Crée avec success!');
  
        }
        else
        {
            session()->flash('messageDelete', 'Cette Piece existe');
        }
     }
     else
     {
       session()->flash('messageDelete', 'Ce Code est deja Attribué'); 
     } 
    }
  }

     	
   // //ON SUPPRIMER UN OBJECT
   public function deleteData($id){
       $Affilier = $this->showData($id);
  
        $Affilier->update([
            'Etat' => 1
        ]);

         session()->flash('messageDelete', 'Affilier(s) supprimé(s) avec success');
     }

   public function multidelete($request){
    
   } 

   public function showData($id){
      $Affilier = $this::findOrFail($id);
      return $Affilier;
   }

   //FIND AFFILIE BY ORIGINE
   
   public function AffilierByOrigine($id){
      $Affiliers = $this->whereOrigine($id)->get();
      return $Affiliers;
   }
   
   public function AffilieRedondance(){
       $Nbre = DB::table('affiliers')
               ->select(DB::raw('count(id) as nbre'))
               ->Groupby('affiliers.Code')
               ->Having('nbre', '>', 1)
               ->get();
               return $Nbre;
   }

}
