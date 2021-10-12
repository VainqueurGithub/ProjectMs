<?php

namespace App\Imports;

use App\Models\MedicamentPartenaire;
use App\Models\Historiquemedicaments;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MedicamentPartenaireImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public $Partenaire
    public function model(array $row)
    {   
        $Today = date('Y-m-d');
        return new MedicamentPartenaire([
            //On verifie si toutes les colonnes de notre fichier sont remplies
            if (!empty($row['partenaire']) &&!empty($row['prix']) && !empty($row['code']) && !empty($row['designation'])) {
               //Verification de doublons  
               $Nbre = MedicamentPartenaire::wherePartenaireAndDesignation($row['partenaire'], $row['designation'])->count('id');
               //Cas des doublons, on fait la mise a jour
                if ($Nbre>0) { 
                    $medicament = MedicamentPartenaire::wherePartenaireAndDesignation($row['partenaire'], $row['designation'])->first(); 

                            $medicament->update([
                                'partenaire'=>$row['partenaire'],
                                'prix'=>$row['prix'],
                                'code'=>$row['code'],
                                'designation'=>$row['designation']
                            ]);

                            $Med = Historiquemedicaments::whereMedicament($medicament->id)->max('id');
                            //$NbreH= Historiquemedicaments::whereId($Med)->count('id');
                            if ($Med!=0) {
                                $History= Historiquemedicaments::findOrFail($Med);
                            }else{
                                $History= new Historiquemedicaments;
                            }

                            if($row['prix']!==$History->Prix){
                                //Sauvegarder les informations dans l'historique
                                $History->update([
                                    'Fin'=>$Today
                                ]);  

                                //Sauvegarder les informations dans l'historique
                                Historiquemedicaments::create([
                                'Medicament'=>$medicament->id,
                                'Prix'=>$row['prix'],
                                'Debut'=>$Today
                                ]);  
                            } 
                        }

                        //Cas contraire on fait l'insertion
                        else{
                              MedicamentPartenaire::create([
                                'partenaire'=>$row['partenaire'],
                                'prix'=>$row['prix'],
                                'code'=>$row['code'],
                                'designation'=>$row['designation']
                            ]);
            
                            $medicament = MedicamentPartenaire::all()->max('id');
                            $Med = MedicamentPartenaire::findOrFail($medicament);

                            //Sauvegarder les informations dans l'historique
                             Historiquemedicaments::create([
                               'Medicament'=>$Med->id,
                               'Prix'=>$value['prix'],
                               'Debut'=>$Today
                             ]);  
                        }
         
                        session()->flash('message', 'Fichier chargé completement avec success,Enregistrements ont été ajoutés');
                    }
                    else{
                         session()->flash('messageDelete', 'Erreur de chargement vous avez tenté de Changer un fichier vide ou incomplet');
                    }    
        ]);
    }
}
