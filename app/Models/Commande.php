<?php

namespace App\Models;
use App\Interfaces\ICommande as ICommande;
use Illuminate\Database\Eloquent\Model;
use App\Models\MedicamentPartenaire;
use App\Models\Facture;
use Cart;
class Commande extends Model implements ICommande
{   
	protected $table = 'commandes';
    protected $fillable = ['Facture', 'Libelle', 'PU', 'Qte', 'PT', 'Propriete', 'Sejour'];


    public function saveData($Content, $Facture){
        foreach ($Content as $Item) {
             $this::create([
            'Facture' => $Facture,
            'Libelle' => session()->get('service'),
            'PU' => $Item->price,
            'Qte' => $Item->quantity,
            'Sejour' => $Item->sejour,
            'Propriete' => $Item->id,
            'PT' => $Item->prixtotal
           ]);
        }
    	 
    }


    public function CalculLimite($TypeTraitement, $MontantCommande, $Affilier, $Type){

       $content = Cart::getContent()->where('prestation', session()->get('service'))->where('user', session()->get('id').$Type)->where('Paterner', session()->get('Paterner'));
    	//on verifie si le type de traitement c'est la maternite
        if ($TypeTraitement==3) 
        {  
            $Diff = ($MontantCommande*$Affilier->ElseUniteMaternite)/100;
            $Diff = $Diff-$Affilier->UniteMaternite;
            if ($Diff>0){
                $ComptantAffilier =$Diff+(($MontantCommande*(100-$Affilier->ElseUniteMaternite))/100);
                $SAAT = $Affilier->UniteMaternite;
            }else{
                $ComptantAffilier = (($MontantCommande*(100-$Affilier->ElseUniteMaternite))/100);
                $SAAT = ($MontantCommande*$Affilier->ElseUniteMaternite)/100;
            }   
                
        }
             
        //on verifie si le type de traitement c'est l'hospitalisation
        elseif ($TypeTraitement==2){ 

            //CALCULONS LIMITES CHAMBRES D'ABORD
            $TotalConsomerChambre = Cart::TotalCartSejour($content);
            $Quantite = Cart::QuantityCartSejour($content);
            $TotalReserverChambre = ($Affilier->PCNuit * $Quantite);
            $DiffChambre = $TotalConsomerChambre-$TotalReserverChambre;

            //VERIFIONS S'IL A DEPASSE LIMITE GENERALE
            $MontantCommande = Cart::TotalCart($content);
            $S = (($MontantCommande*($Affilier->PlafondChambre))/100);
            $DiffG = $S-$Affilier->Hospitalisation;
            
            //ON VERIFIE SI IL Y A D'AUTRES ARTICLES APART HOSPITALISATION
            
            $Nbre =Cart::NbreItemHorsSejour($content);
            
            if($Nbre==0){
                 
                if($DiffChambre>0){
                    $ComptantAffilier = $DiffChambre;   
                }else{
                    $ComptantAffilier =(($MontantCommande*(100-$Affilier->PlafondChambre))/100);
                }
            }else{
                
                if($DiffG<0 || $DiffG==0){

                  	if ($DiffChambre>0) {

                        $ComptantAffilier =(($MontantCommande*(100-$Affilier->PlafondChambre))/100)+$DiffChambre;
                  	}
                 	else{

                	   	$ComptantAffilier =(($MontantCommande*(100-$Affilier->PlafondChambre))/100);
                	}
              }
              elseif($DiffG>0){

                    if($DiffChambre>0){

                        $ComptantAffilier =(($MontantCommande*(100-$Affilier->PlafondChambre))/100)+$DiffG;
                    } 
                    else{
                        $ComptantAffilier =$DiffG+(($MontantCommande*(100-$Affilier->PlafondChambre))/100);
                    } 
                }
            }
            $SAAT=$MontantCommande-$ComptantAffilier;
        }
             
        //on verifie si le type de traitement c'est l'achat de medicament
        elseif ($TypeTraitement==4){

            $Diff = ($MontantCommande*$Affilier->SoinsAmbilatoire)/100;
            $Diff = $Diff-$Affilier->Pharmacie;

            if ($Diff>0) {

                $ComptantAffilier =$Diff+(($MontantCommande*(100-$Affilier->SoinsAmbilatoire))/100);
                $SAAT = $Affilier->Pharmacie;
            }
            else{

                $ComptantAffilier = (($MontantCommande*(100-$Affilier->SoinsAmbilatoire))/100);
                $SAAT = ($MontantCommande*$Affilier->SoinsAmbilatoire)/100;
            }  
        }

        //on verifie si le type de traitement c'est l'ophtamologie
        elseif($TypeTraitement==5){

            $Diff = ($MontantCommande*$Affilier->SoinsAmbilatoire)/100;
            $Diff = $Diff-$Affilier->Lunette; 
            if ($Diff>0) {

                $ComptantAffilier =$Diff+(($MontantCommande*(100-$Affilier->SoinsAmbilatoire))/100);
                $SAAT = $Affilier->Lunette;
            }
            else{

                $ComptantAffilier = (($MontantCommande*(100-$Affilier->SoinsAmbilatoire))/100);
                $SAAT = ($MontantCommande*$Affilier->SoinsAmbilatoire)/100;
            }

               
        }

        //on verifie si le type de traitement c'est laboratoire
        elseif ($TypeTraitement==7) {

            $Diff = ($MontantCommande*$Affilier->SoinsAmbilatoire)/100;
            $Diff = $Diff-$Affilier->labo; 
            if ($Diff>0) {

                $ComptantAffilier =$Diff+(($MontantCommande*(100-$Affilier->SoinsAmbilatoire))/100);
                $SAAT = $Affilier->labo;
            }
            else{

                $ComptantAffilier = (($MontantCommande*(100-$Affilier->SoinsAmbilatoire))/100);
                $SAAT = ($MontantCommande*$Affilier->SoinsAmbilatoire)/100;
            }


                
        }

        //on verifie si le type de traitement c'est la kinesitherapie 
        elseif ($TypeTraitement==8) {

            $Diff = ($MontantCommande*$Affilier->SoinsAmbilatoire)/100;
            $Diff = $Diff-$Affilier->kinesie; 
            if ($Diff>0) 
            {
                $ComptantAffilier =$Diff+(($MontantCommande*(100-$Affilier->SoinsAmbilatoire))/100);
                $SAAT = $Affilier->kinesie;
            }
            else{
                $ComptantAffilier = (($MontantCommande*(100-$Affilier->SoinsAmbilatoire))/100);
                $SAAT = ($MontantCommande*$Affilier->SoinsAmbilatoire)/100;
            }  
              

            //on verifie si le type de traitement c'est la Reanimation 
        }
        elseif ($TypeTraitement==9) {

            $Diff = ($MontantCommande*$Affilier->PlafondChambre)/100;
            $Diff = $Diff-$Affilier->reanimation; 
            if ($Diff>0) 
            {
                $ComptantAffilier =$Diff+(($MontantCommande*(100-$Affilier->PlafondChambre))/100);
                $SAAT = $Affilier->reanimation;
            }
            else{
                $ComptantAffilier = (($MontantCommande*(100-$Affilier->PlafondChambre))/100);
                $SAAT = $MontantCommande-$ComptantAffilier;
            }  
              

           
        }
        
        //on verifie si le type de traitement c'est la Imagerie
        elseif ($TypeTraitement==10) {

            $Diff = ($MontantCommande*$Affilier->SoinsAmbilatoire)/100;
            $Diff = $Diff-$Affilier->imagerie; 
            if ($Diff>0) {

                $ComptantAffilier =$Diff+(($MontantCommande*(100-$Affilier->SoinsAmbilatoire))/100);
                $SAAT = $Affilier->imagerie;
            }
            else{
                $ComptantAffilier = (($MontantCommande*(100-$Affilier->SoinsAmbilatoire))/100);
                $SAAT = ($MontantCommande*$Affilier->SoinsAmbilatoire)/100;
            }    
        }

        //on verifie si le type de traitement c'est les dents
        elseif ($TypeTraitement==6) {

            $Diff = ($MontantCommande*$Affilier->SoinsAmbilatoire)/100;
            $Diff = $Diff-$Affilier->dents; 
            if ($Diff>0) 
            {
                $ComptantAffilier =$Diff+(($MontantCommande*(100-$Affilier->SoinsAmbilatoire))/100);
                $SAAT = $Affilier->dents;
            }
            else{
                $ComptantAffilier = (($MontantCommande*(100-$Affilier->SoinsAmbilatoire))/100);
                $SAAT = ($MontantCommande*$Affilier->SoinsAmbilatoire)/100;
            }  
        }

        //on verifie si le type de traitement c'est la Consultation
        elseif($TypeTraitement==1)
        { 
            $ComptantAffilier = (($MontantCommande*(100-$Affilier->SoinsAmbilatoire))/100);
            $SAAT = ($MontantCommande*$Affilier->SoinsAmbilatoire)/100;  
        }
       
      return  $response = $SAAT.','.$ComptantAffilier;
    
    }

    
    public function NbreCommande($facture){
        return $this::whereEtatAndFacture(0,$facture)->count('id');
    }


    public function MontantCommande($facture){
        return $this::whereEtatAndFacture(0,$facture)->sum('PT');
    }

    public function Attributionamountmonth($Month, $Insuranceamount, $Bill, $id){

        if (is_null($id)) {

          if ($Month == 1) {
             $Bill->update([
            'Janvier' => $Insuranceamount
              ]);
           }
           elseif ($Month == 2) {
            $Bill->update([
            'Fevrier' => $Insuranceamount
              ]);
            }
            elseif ($Month == 3) {
                $Bill->update([
            'Mars' => $Insuranceamount
              ]);
             }
             elseif ($Month == 4) {
                 $Bill->update([
            'Avril' => $Insuranceamount
              ]);
              }
              elseif ($Month == 5) {
                 $Bill->update([
            'Mai' => $Insuranceamount
              ]);
               }elseif ($Month == 6) {
                  $Bill->update([
            'Juin' => $Insuranceamount
              ]);
               }elseif ($Month == 7) {
                    $Bill->update([
            'Juillet' => $Insuranceamount
              ]);
               }elseif ($Month == 8) {
                  $Bill->update([
            'Aout' => $Insuranceamount
              ]);
               }elseif ($Month == 9) {
                 $Bill->update([
            'Semptembre' => $Insuranceamount
              ]);
               }elseif ($Month == 10) {
                 $Bill->update([
            
            'Octobre' => $Insuranceamount
              ]);
               }elseif ($Month == 11) {
                 $Bill->update([
            'Novembre' => $Insuranceamount
              ]);
               }elseif ($Month == 12) {
                 $Bill->update([
            'Decembre' => $Insuranceamount
              ]);
        }
             
        }else{

            $Bill->update([
            'Janvier' => 0,
            'Fevrier' => 0,
            'Mars' => 0,
            'Avril' => 0,
            'Mai' => 0,
            'Juin' => 0,
            'Juillet' => 0,
            'Aout' => 0,
            'Semptembre' => 0,
            'Octobre' => 0,
            'Novembre' => 0,
            'Decembre' => 0
              ]);

          if ($Month == 1) {
             $Bill->update([
            'Janvier' => $Insuranceamount
              ]);
           }
           elseif ($Month == 2) {
            $Bill->update([
            'Fevrier' => $Insuranceamount
              ]);
            }
            elseif ($Month == 3) {
                $Bill->update([
            'Mars' => $Insuranceamount
              ]);
             }
             elseif ($Month == 4) {
                 $Bill->update([
            'Avril' => $Insuranceamount
              ]);
              }
              elseif ($Month == 5) {
                 $Bill->update([
            'Mai' => $Insuranceamount
              ]);
               }elseif ($Month == 6) {
                  $Bill->update([
            'Juin' => $Insuranceamount
              ]);
               }elseif ($Month == 7) {
                    $Bill->update([
            'Juillet' => $Insuranceamount
              ]);
               }elseif ($Month == 8) {
                  $Bill->update([
            'Aout' => $Insuranceamount
              ]);
               }elseif ($Month == 9) {
                 $Bill->update([
            'Semptembre' => $Insuranceamount
              ]);
               }elseif ($Month == 10) {
                 $Bill->update([
            
            'Octobre' => $Insuranceamount
              ]);
               }elseif ($Month == 11) {
                 $Bill->update([
            'Novembre' => $Insuranceamount
              ]);
               }elseif ($Month == 12) {
                 $Bill->update([
            'Decembre' => $Insuranceamount
              ]);
            }

        }










    }

}
