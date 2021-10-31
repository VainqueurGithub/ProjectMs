<?php

namespace App\Models;
use App\Models\MedicamentPartenaire;
use App\Models\Historiquemedicaments;
use Illuminate\Database\Eloquent\Model;
use App\Interfaces\IMedicamentservice as IMedicamentservice;
use Illuminate\Support\Facades\DB;
class medicamentsservice extends Model implements IMedicamentservice
{   
    protected $table = 'medicamentsservices';
    protected $fillable = ['propriete', 'libelle', 'Etat'];

    //Afficher tous les medicaments
    public function fetchtAll(){
      return  $this->where('Etat', 0)->get();
    }


    public function savedata($request, $id){
      //ON CREER UN NOUVEAU OBJECT
      if (is_null($id)) {
        $Today = date('Y-m-d');
        if($this->UniqueMedicament($request->Propriete)==false){
          $this::create([
            'propriete'=>$request->Libelle,
            'libelle'=>$request->Propriete
          ]);
          return redirect(route('Medicaments.index'));
        }else{
          session()->flash('messageDelete', 'Ce Medicament existe deja');
          return redirect()->back();
        }
      }
      else{
        if($this->UniqueMedicamentModify($request->Propriete, $id)==false){
          $medicament = $this::findOrFail($id);
          $medicament->update([
            'libelle'=>$request->Propriete,
            'propriete'=>$request->Libelle
          ]);
          return redirect(route('Medicaments.index'));
        }else{
          return redirect()->back();
        } 
      }

    }

    //Supprimer un object

    public function deleteData($id){
        $medicament = $this::findOrFail($id);
        $medicament->destroy($id);
        return redirect(route('Medicaments.index'));
    }

    //Montre le detail d'un object
    public function showData($id){

      return $medicaments = DB::table('medicamentsservices')
        ->join('medicament_partenaires', 'medicamentsservices.id', '=', 'medicament_partenaires.medicament')
        ->join('partenaires', 'partenaires.id', '=', 'medicament_partenaires.partenaire')
        ->select(DB::raw('medicament_partenaires.code, medicament_partenaires.prix, medicamentsservices.propriete, partenaires.Partenaire, medicament_partenaires.id, medicament_partenaires.created_at'))
        ->where('medicamentsservices.id', $id)
        ->get();
    }

    //Fx pour verifier qu'un partenaire n'a pas + 1 medicament avec le meme code cas d'ajout
    public function UniqueMedicament ($Libelle){
      $Nbre = medicamentsservice::wherePropriete($Libelle)->count('id');

      if($Nbre===0){
           return false;
      } else{
      	return true;
      }
    }


    //Fx pour verifier qu'un partenaire n'a pas + 1 medicament avec le meme code cas de modification
    public function UniqueMedicamentModify ($Libelle, $id){
      $Nbre = medicamentsservice::wherePropriete($Libelle)->where('id', '!=', $id)->count('id');

      if($Nbre===0){
           return false;
      } else{
        return true;
      }
    }

    public function ChangerPrixStore($request, $Medicament){
        $medicament =MedicamentPartenaire::findOrFail($Medicament);
        $Today = date('Y-m-d');

          //Sauvegarder les informations dans l'historique
          Historiquemedicaments::create([
            'Medicament'=>$Medicament,
            'Prix'=>$medicament->prix,
            'Debut'=>$medicament->updated_at->format('Y-m-d'),
            'Fin'=>$Today
          ]);  

        $medicament =MedicamentPartenaire::findOrFail($Medicament);
        $medicament->update([
            'prix'=>$request->Prix
        ]);
    }

    public function Historique($Med){
      return  $Medicaments = DB::table('medicament_partenaires')
       ->join('historiquemedicaments', 'historiquemedicaments.Medicament', '=', 'medicament_partenaires.id')
       ->select(DB::raw('medicament_partenaires.code, historiquemedicaments.Prix, historiquemedicaments.Debut, historiquemedicaments.Fin'))
       ->where('historiquemedicaments.Medicament', $Med)
       ->get();
    }
}
