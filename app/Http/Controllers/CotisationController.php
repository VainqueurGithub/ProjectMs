<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Affilier;
use App\Models\AyantDroit;
use App\Models\Cotisation;
use App\Models\Consomation;
use App\Models\Origine;
use App\Models\historiqueCotisationMontant;
use App\Models\Tauxcotisation;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use PDF;
class CotisationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
$beginMonth = date('Y-m');
$endMonth=$beginMonth."-31";
$beginMonth.="-01"; 
$Affiliers = Affilier::whereEtat(0)->get();
$Cotisations = DB::table('cotisations')
            ->select(DB::raw('*'))
            ->whereBetween('Datepayement',[$beginMonth, $endMonth])
            ->whereEtat(0)->get();
$NbreCot=Cotisation::where('Etat',0)->count();
        $table="";

         foreach($Cotisations as $cot){

            $id_Affilier=$cot->Affilier;
            $Affilier=Affilier::where('id',$id_Affilier)->first();

        if($Affilier->Etat==2)
        {
            $table.="
                    <tr class='odd gradeX' style='color:red;'>
                    <td>".$Affilier->Code."</td>
                        <td>".$Affilier->Nom.' '.$Affilier->Prenom."</td>
                         <td>".$cot->Mois."</td>
                         <td>".$cot->Annee."</td>
                        <td>".$cot->Montant."</td>
                         <td>".$cot->Datepayement."</td>
                        <td class='center f-icon'>
                         <a href='".route('Cotisations.edit',$cot->id)."'><i class='fas fa-edit'></i></a>
                            <form action='".route('Cotisations.destroy',$cot->id)."' method='POST' style='display:inline-block;'>
                                ".csrf_field()."
                                ".method_field('DELETE')."
                                <button><i class='fas fa-trash'></i>
                                    </button>
                            </form>
                        </td>
                    </tr>";
        }
        else
        {
            $table.="
                    <tr class='odd gradeX'>
                    <td>".$Affilier->Code."</td>
                        <td>".$Affilier->Nom.' '.$Affilier->Prenom."</td>
                         <td>".$cot->Mois."</td>
                         <td>".$cot->Annee."</td>
                        <td>".$cot->Montant."</td>
                        <td>".$cot->Datepayement."</td>
                        <td class='center f-icon'>
                           <a href='".route('Cotisations.edit',$cot->id)."'><i class='fas fa-edit'></i></a>
                            <form action='".route('Cotisations.destroy',$cot->id)."' method='POST' style='display:inline-block;'>
                                ".csrf_field()."
                                ".method_field('DELETE')."
                                <button><i class='fas fa-trash'></i>
                                    </button>
                                    
                                
                            </form>
                            
                        </td>
                    </tr>";
        }
            
                    }
        $tableListe=$table;
        return view('Cotisations.index', compact('tableListe'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $Cotisation = new Cotisation;
        $Affilier = new Affilier;
        $Affiliers = Affilier::whereEtat(0)->get();
        return view('Cotisations.create',compact('Affiliers', 'Affilier', 'Cotisation'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $this->validate($request, [
        'Affilier' => 'required', 
        'Mois' => 'required',
        'Montant' => 'required',
        'Annee' => 'required',
        'Datepayement'=>'required'
        ]);
        
        $Affilier = Affilier::findOrFail($request->Affilier);

        $CotisationDue = Cotisation::Taux_cotisation($request->Affilier,$request->Annee);
        
        //Trouver Le montant deja Cotisé Pour Ce Mois 
        $Montant = Cotisation::whereEtatAndAffilierAndMoisAndAnnee(0,$request->Affilier,$request->Mois,$request->Annee)->sum('Montant');
        $Montant +=$request->Montant;

        //ON VERIFIE S'IL Y A UN TAUX DE COTISATION  PARAMETRE POUR L'ANNE EN COURS
        
        if ($CotisationDue !="Not defined") {
           
        if ($Affilier->CotisationM >= $Montant) 
        {
           if ($request->Mois == 1) {
             Cotisation::create([
            'Affilier' =>$request->Affilier,
            'Mois' =>$request->Mois,
            'Montant' =>$request->Montant,
            'Janvier' => $request->Montant,
            'DateCreation' =>$request->Annee.'-'.$request->Mois.'-01',
            'Annee' =>$request->Annee,
            'Datepayement'=>$request->Datepayement
              ]);
           }
           elseif ($request->Mois == 2) {
            Cotisation::create([
            'Affilier' =>$request->Affilier,
            'Mois' =>$request->Mois,
            'Montant' =>$request->Montant,
            'Fevrier' => $request->Montant,
            'DateCreation' =>$request->Annee.'-'.$request->Mois.'-01',
            'Annee' =>$request->Annee,
            'Datepayement'=>$request->Datepayement
              ]);
            }
            elseif ($request->Mois == 3) {
            Cotisation::create([
            'Affilier' =>$request->Affilier,
            'Mois' =>$request->Mois,
            'Montant' =>$request->Montant,
            'Mars' => $request->Montant,
            'DateCreation' =>$request->Annee.'-'.$request->Mois.'-01',
            'Annee' =>$request->Annee,
            'Datepayement'=>$request->Datepayement
              ]);
            }
             elseif ($request->Mois == 4) {
            Cotisation::create([
            'Affilier' =>$request->Affilier,
            'Mois' =>$request->Mois,
            'Montant' =>$request->Montant,
            'Avril' => $request->Montant,
            'DateCreation' =>$request->Annee.'-'.$request->Mois.'-01',
            'Annee' =>$request->Annee,
            'Datepayement'=>$request->Datepayement
              ]);
            }
            elseif ($request->Mois == 5) {
            Cotisation::create([
            'Affilier' =>$request->Affilier,
            'Mois' =>$request->Mois,
            'Montant' =>$request->Montant,
            'Mai' => $request->Montant,
            'DateCreation' =>$request->Annee.'-'.$request->Mois.'-01',
            'Annee' =>$request->Annee,
            'Datepayement'=>$request->Datepayement
              ]);
            }
            elseif ($request->Mois == 6) {
            Cotisation::create([
            'Affilier' =>$request->Affilier,
            'Mois' =>$request->Mois,
            'Montant' =>$request->Montant,
            'Juin' => $request->Montant,
            'DateCreation' =>$request->Annee.'-'.$request->Mois.'-01',
            'Annee' =>$request->Annee,
            'Datepayement'=>$request->Datepayement
              ]);
            }
            elseif ($request->Mois == 7) {
            Cotisation::create([
            'Affilier' =>$request->Affilier,
            'Mois' =>$request->Mois,
            'Montant' =>$request->Montant,
            'Juillet' => $request->Montant,
            'DateCreation' =>$request->Annee.'-'.$request->Mois.'-01',
            'Annee' =>$request->Annee,
            'Datepayement'=>$request->Datepayement
              ]);
            }
            elseif ($request->Mois == 8) {
            Cotisation::create([
            'Affilier' =>$request->Affilier,
            'Mois' =>$request->Mois,
            'Montant' =>$request->Montant,
            'Aout' => $request->Montant,
            'DateCreation' =>$request->Annee.'-'.$request->Mois.'-01',
            'Annee' =>$request->Annee,
            'Datepayement'=>$request->Datepayement
              ]);
            }
            elseif ($request->Mois == 9) {
            Cotisation::create([
            'Affilier' =>$request->Affilier,
            'Mois' =>$request->Mois,
            'Montant' =>$request->Montant,
            'Semptembre' => $request->Montant,
            'DateCreation' =>$request->Annee.'-'.$request->Mois.'-01',
            'Annee' =>$request->Annee,
            'Datepayement'=>$request->Datepayement
              ]);
            }
            elseif ($request->Mois == 10) {
            Cotisation::create([
            'Affilier' =>$request->Affilier,
            'Mois' =>$request->Mois,
            'Montant' =>$request->Montant,
            'Octobre' => $request->Montant,
            'DateCreation' =>$request->Annee.'-'.$request->Mois.'-01',
            'Annee' =>$request->Annee,
            'Datepayement'=>$request->Datepayement
              ]);
            }
            elseif ($request->Mois == 11) {
            Cotisation::create([
            'Affilier' =>$request->Affilier,
            'Mois' =>$request->Mois,
            'Montant' =>$request->Montant,
            'Novembre' => $request->Montant,
            'DateCreation' =>$request->Annee.'-'.$request->Mois.'-01',
            'Annee' =>$request->Annee,
            'Datepayement'=>$request->Datepayement
              ]);
            }
            elseif ($request->Mois == 12) {
            Cotisation::create([
            'Affilier' =>$request->Affilier,
            'Mois' =>$request->Mois,
            'Montant' =>$request->Montant,
            'Decembre' => $request->Montant,
            'DateCreation' =>$request->Annee.'-'.$request->Mois.'-01',
            'Annee' =>$request->Annee,
            'Datepayement'=>$request->Datepayement
              ]);
            }
         }
        else
        {
         session()->flash('messageDelete', 'Vous avez depassé la cotisation mensuelle');
        }
       }
       else{
         session()->flash('messageDelete', 'Aucun taux de cotisation n\'a été parametré pour l\'année '.$request->Annee);
       }
        return redirect(route('Cotisations.index'));
    }    


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Cotisation = Cotisation::findOrFail($id);
        $Affilier = Affilier::findOrFail($Cotisation->Affilier);
        $Affiliers = Affilier::whereEtat(0)->get();
        return view('Cotisations.edit', compact('Cotisation', 'Affiliers', 'Affilier'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
        'Affilier' => 'required', 
        'Mois' => 'required',
        'Montant' => 'required',
        'Annee' => 'required',
        'Datepayement'=>'required'
        ]);

        //Trouver la Cotisation Mensuelle de L'Affilier
        $Affilier = Affilier::findOrFail($request->Affilier);

        //Trouver Le montant deja Cotisé
        $Montant = Cotisation::whereEtatAndAffilierAndMoisAndAnnee(0,$request->Affilier, $request->Mois, $request->Annee)->where('id', '!=', $id)->sum('Montant');
        $Montant +=$request->Montant;

            if ($Affilier->CotisationM>=$Montant) 
            {   
            $Cotisation = Cotisation::findOrFail($id);
            $Cotisation->update([
                'Affilier' =>$request->Affilier,
                'Mois' =>$request->Mois,
                'Annee' =>$request->Annee,
                'Montant' =>$request->Montant,
                'Janvier' =>0,
                'Fevrier' =>0,
                'Mars' =>0,
                'Avril' =>0,
                'Mai' =>0,
                'Juin' =>0,
                'Mai'=>0,
                'Juin'=>0,
                'Juillet' =>0,
                'Aout' =>0,
                'Semptembre' =>0,
                'Octobre' =>0,
                'Novembre' =>0,
                'Decembre' =>0,
                'Datepayement'=>$request->Datepayement

            ]);
        $Cotisation = Cotisation::findOrFail($id);

           if ($request->Mois == 1) {
             $Cotisation->update([
            'Janvier' => $request->Montant
              ]);
           }
           elseif ($request->Mois == 2) {
            $Cotisation->update([
            'Fevrier' => $request->Montant
              ]);
            }
            elseif ($request->Mois == 3) {
                $Cotisation->update([
            'Mars' => $request->Montant
              ]);
             }
             elseif ($request->Mois == 4) {
                 $Cotisation->update([
            'Avril' => $request->Montant
              ]);
              }
              elseif ($request->Mois == 5) {
                 $Cotisation->update([
            'Mai' => $request->Montant
              ]);
               }elseif ($request->Mois == 6) {
                  $Cotisation->update([
            'Juin' => $request->Montant
              ]);
               }elseif ($request->Mois == 7) {
                    $Cotisation->update([
            'Juillet' => $request->Montant
              ]);
               }elseif ($request->Mois == 8) {
                  $Cotisation->update([
            'Aout' => $request->Montant
              ]);
               }elseif ($request->Mois == 9) {
                 $Cotisation->update([
            'Semptembre' => $request->Montant
              ]);
               }elseif ($request->Mois == 10) {
                 $Cotisation->update([
            'Octobre' => $request->Montant
              ]);
               }elseif ($request->Mois == 11) {
                 $Cotisation->update([
            'Novembre' => $request->Montant
              ]);
               }elseif ($request->Mois == 12) {
                 $Cotisation->update([
            'Decembre' => $request->Montant
              ]);
               }
          }
        else
        {
            session()->flash('messageDelete', 'Vous avez depassé la cotisation mensuelle');
        }

        return redirect(route('Cotisations.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $Cotisation = Cotisation::findOrFail($id);
            $Cotisation->update([
                'Etat' =>1
            ]);

      session()->flash('messageDelete', 'Suppression effectuee');    
      return redirect(route('Cotisations.index'));        
    }

    public function SupprimerDefiniCot($id)
    {
       Cotisation::destroy($id);
      return redirect(route('CorbCotisation'));        
    }

    public function Journal()
    { 

     $Partenaires = Origine::whereEtat(0)->get(); 
     $Affiliers = Affilier::all();
$Cotisations = Cotisation::whereEtat(0)->groupBy('Affilier')->get();
$NbreCot=Cotisation::where('Etat',0)->count();
        $table="";
       $Somme = []; 
        if ($NbreCot > 0) {
         $comm = DB::table('cotisations')
                     ->join('affiliers', 'affiliers.id', '=', 'cotisations.Affilier')
                     ->select(DB::raw('sum(Janvier) as J,sum(Fevrier) as F, sum(Mars) as M, sum(Avril) as A, sum(Mai) as Ma, sum(Juin) as Ju, sum(Juillet) as Jui, sum(Aout) as Ao, sum(semptembre) as S, sum(Octobre) as O, sum(Novembre) as N, sum(Decembre) as D, Affilier, sum(Janvier+Fevrier+Mars+Avril+Mai+Juin+Juillet+Aout+semptembre+Octobre+Novembre+Decembre) as ST'))
                     ->where('cotisations.Etat',0)
                     //->where('affiliers.Etat',0)
                     ->groupBy('Affilier')
                     ->get();

          $Somme = DB::table('cotisations')
                     ->join('affiliers', 'affiliers.id', '=', 'cotisations.Affilier')
                     ->select(DB::raw('sum(Janvier) as J,sum(Fevrier) as F, sum(Mars) as M, sum(Avril) as A, sum(Mai) as Ma, sum(Juin) as Ju, sum(Juillet) as Jui, sum(Aout) as Ao, sum(semptembre) as S, sum(Octobre) as O, sum(Novembre) as N, sum(Decembre) as D, count(distinct(Affilier)) as AF, sum(Janvier+Fevrier+Mars+Avril+Mai+Juin+Juillet+Aout+semptembre+Octobre+Novembre+Decembre) as ST'))
                     ->where('cotisations.Etat',0)
                     //->where('affiliers.Etat',0)
                     ->get();           
         foreach($comm as $com){

            $id_Affilier=$com->Affilier;
            $Affilier=Affilier::where('id',$id_Affilier)->first();
         
         if ($Affilier->Etat==2) 
         {
             $table.="
                    <tr class='odd gradeX' style='color:red'>
                        <td>".$Affilier->Code."</td>
                        <td>".$Affilier->Nom.' '.$Affilier->Prenom."</td>
                         <td>".$com->J."</td>
                         <td>".$com->F."</td>
                        <td>".$com->M."</td>
                        <td>".$com->A."</td>
                        <td>".$com->Ma."</td>
                        <td>".$com->Ju."</td>
                        <td>".$com->Jui."</td>
                        <td>".$com->Ao."</td>
                        <td>".$com->S."</td>
                       <td>".$com->O."</td>
                       <td>".$com->N."</td>
                        <td>".$com->D."</td>
                        <td>".$com->ST."</td>
                    </tr>";
         }
         else
         {
            $table.="
                    <tr class='odd gradeX'>
                        <td>".$Affilier->Code."</td>
                        <td>".$Affilier->Nom.' '.$Affilier->Prenom."</td>
                         <td>".$com->J."</td>
                         <td>".$com->F."</td>
                        <td>".$com->M."</td>
                        <td>".$com->A."</td>
                        <td>".$com->Ma."</td>
                        <td>".$com->Ju."</td>
                        <td>".$com->Jui."</td>
                        <td>".$com->Ao."</td>
                        <td>".$com->S."</td>
                       <td>".$com->O."</td>
                       <td>".$com->N."</td>
                        <td>".$com->D."</td>
                        <td>".$com->ST."</td>
                    </tr>";
         }
                    }
                       # code...
        }
        $tableListe=$table;
        return view('Cotisations.Journal', compact('tableListe', 'Somme', 'Affiliers', 'Partenaires'));
    }

    public function PdfCreateCotisation(Request $request)
    {  
        $Somme = [];
        $Origine = '';
        $Debut = '';
        $Fin = '';
        $Individu = '';
        if (isset($request->Groupe) && !empty($request->Groupe) && isset($request->Debut) && !empty($request->Debut) && isset($request->Debut) && !empty($request->Fin)) 
        {
         $Origine = Origine::findOrFail($request->Groupe);
         $Debut = $request->Debut; 
         $Fin = $request->Fin;   
        $NbreCot=Cotisation::where('Etat',0)->count();
        $table="";
        if ($NbreCot > 0) {
         $comm = DB::table('cotisations')
                     ->join('affiliers', 'affiliers.id', '=', 'cotisations.Affilier')
                     ->select(DB::raw('sum(Janvier) as J,sum(Fevrier) as F, sum(Mars) as M, sum(Avril) as A, sum(Mai) as Ma, sum(Juin) as Ju, sum(Juillet) as Jui, sum(Aout) as Ao, sum(semptembre) as S, sum(Octobre) as O, sum(Novembre) as N, sum(Decembre) as D, Affilier, sum(Janvier+Fevrier+Mars+Avril+Mai+Juin+Juillet+Aout+semptembre+Octobre+Novembre+Decembre) as ST'))
                     ->whereOrigine($request->Groupe)
                     ->whereBetween('DateCreation',[$request->Debut, $request->Fin])
                      ->where('cotisations.Etat', 0)
                       //->where('affiliers.Etat', 0)
                     ->groupBy('Affilier')
                     ->get();

          $Somme = DB::table('cotisations')
                     ->join('affiliers', 'affiliers.id', '=', 'cotisations.Affilier')
                     ->select(DB::raw('sum(Janvier) as J,sum(Fevrier) as F, sum(Mars) as M, sum(Avril) as A, sum(Mai) as Ma, sum(Juin) as Ju, sum(Juillet) as Jui, sum(Aout) as Ao, sum(semptembre) as S, sum(Octobre) as O, sum(Novembre) as N, sum(Decembre) as D, count(distinct(Affilier)) as AF, sum(Janvier+Fevrier+Mars+Avril+Mai+Juin+Juillet+Aout+semptembre+Octobre+Novembre+Decembre) as ST'))
                     ->whereOrigine($request->Groupe)
                     ->whereBetween('DateCreation',[$request->Debut, $request->Fin])
                     ->where('cotisations.Etat', 0)
                     //->where('affiliers.Etat', 0)
                     ->get();           
         foreach($comm as $com){

            $id_Affilier=$com->Affilier;
            $Affilier=Affilier::where('id',$id_Affilier)->first();

            $table.="
                    <tr class='odd gradeX'>
                        <td>".$Affilier->Code."</td>
                        <td>".$Affilier->Nom.' '.$Affilier->Prenom."</td>
                         <td>".$com->J."</td>
                         <td>".$com->F."</td>
                        <td>".$com->M."</td>
                        <td>".$com->A."</td>
                        <td>".$com->Ma."</td>
                        <td>".$com->Ju."</td>
                        <td>".$com->Jui."</td>
                        <td>".$com->Ao."</td>
                        <td>".$com->S."</td>
                       <td>".$com->O."</td>
                       <td>".$com->N."</td>
                        <td>".$com->D."</td>
                        <td>".$com->ST."</td>
                    </tr>";
                    }
                       # code...
        }
        $tableListe=$table;
        $pdf = PDF::loadView('Cotisations.PdfCreateCotisation', compact('tableListe', 'Somme', 'Origine', 'Debut', 'Fin', 'Individu'))->setPaper('a3', 'Paysage');
         $fileName = 'Journal';
         return $pdf->stream($fileName . '.pdf');

        }
        elseif (isset($request->Individu) && !empty($request->Individu) && isset($request->Debut) && !empty($request->Debut) && isset($request->Fin) && !empty($request->Fin)) 
        {
        $Individu =Affilier::findOrFail($request->Individu);
         $Debut = $request->Debut; 
         $Fin = $request->Fin;   
        $NbreCot=Cotisation::where('Etat',0)->count();
        $table="";
        if ($NbreCot > 0) {
         $comm = DB::table('cotisations')
                     ->join('affiliers', 'affiliers.id', '=', 'cotisations.Affilier')
                     ->select(DB::raw('sum(Janvier) as J,sum(Fevrier) as F, sum(Mars) as M, sum(Avril) as A, sum(Mai) as Ma, sum(Juin) as Ju, sum(Juillet) as Jui, sum(Aout) as Ao, sum(semptembre) as S, sum(Octobre) as O, sum(Novembre) as N, sum(Decembre) as D, Affilier, sum(Janvier+Fevrier+Mars+Avril+Mai+Juin+Juillet+Aout+semptembre+Octobre+Novembre+Decembre) as ST'))
                      ->where('cotisations.Etat', 0)
                     //->where('affiliers.Etat', 0)
                     ->whereAffilier($request->Individu)
                     ->whereBetween('DateCreation',[$request->Debut, $request->Fin])
                     ->groupBy('Affilier')
                     ->get();

          $Somme = DB::table('cotisations')
                     ->join('affiliers', 'affiliers.id', '=', 'cotisations.Affilier')
                     ->select(DB::raw('sum(Janvier) as J,sum(Fevrier) as F, sum(Mars) as M, sum(Avril) as A, sum(Mai) as Ma, sum(Juin) as Ju, sum(Juillet) as Jui, sum(Aout) as Ao, sum(semptembre) as S, sum(Octobre) as O, sum(Novembre) as N, sum(Decembre) as D, count(distinct(Affilier)) as AF, sum(Janvier+Fevrier+Mars+Avril+Mai+Juin+Juillet+Aout+semptembre+Octobre+Novembre+Decembre) as ST'))
                      ->where('cotisations.Etat', 0)
                     //->where('affiliers.Etat', 0)
                     ->whereAffilier($request->Individu)
                     ->whereBetween('DateCreation',[$request->Debut, $request->Fin])
                     ->get();           
         foreach($comm as $com){

            $id_Affilier=$com->Affilier;
            $Affilier=Affilier::where('id',$id_Affilier)->first();

            $table.="
                    <tr class='odd gradeX'>
                        <td>".$Affilier->Code."</td>
                        <td>".$Affilier->Nom.' '.$Affilier->Prenom."</td>
                         <td>".$com->J."</td>
                         <td>".$com->F."</td>
                        <td>".$com->M."</td>
                        <td>".$com->A."</td>
                        <td>".$com->Ma."</td>
                        <td>".$com->Ju."</td>
                        <td>".$com->Jui."</td>
                        <td>".$com->Ao."</td>
                        <td>".$com->S."</td>
                       <td>".$com->O."</td>
                       <td>".$com->N."</td>
                        <td>".$com->D."</td>
                        <td>".$com->ST."</td>
                    </tr>";
                    }
                       # code...
        }
        $tableListe=$table;
        $pdf = PDF::loadView('Cotisations.PdfCreateCotisation', compact('tableListe', 'Somme', 'Individu', 'Debut', 'Fin', 'Origine'))->setPaper('a3', 'Paysage');
         $fileName = 'Journal';
         return $pdf->stream($fileName . '.pdf');

        }
        elseif (isset($request->Debut) && !empty($request->Debut) && isset($request->Fin) && !empty($request->Fin)) 
        {
        $Debut = $request->Debut; 
        $Fin = $request->Fin;   
        $NbreCot=Cotisation::where('Etat',0)->count();
        $table="";
        if ($NbreCot > 0) {
         $comm = DB::table('cotisations')
                     ->join('affiliers', 'affiliers.id', '=', 'cotisations.Affilier')
                     ->select(DB::raw('sum(Janvier) as J,sum(Fevrier) as F, sum(Mars) as M, sum(Avril) as A, sum(Mai) as Ma, sum(Juin) as Ju, sum(Juillet) as Jui, sum(Aout) as Ao, sum(semptembre) as S, sum(Octobre) as O, sum(Novembre) as N, sum(Decembre) as D, Affilier, sum(Janvier+Fevrier+Mars+Avril+Mai+Juin+Juillet+Aout+semptembre+Octobre+Novembre+Decembre) as ST'))
                      ->where('cotisations.Etat', 0)
                     //->where('affiliers.Etat', 0)
                     ->whereBetween('DateCreation',[$request->Debut, $request->Fin])
                     ->groupBy('Affilier')
                     ->get();

          $Somme = DB::table('cotisations')
                     ->join('affiliers', 'affiliers.id', '=', 'cotisations.Affilier')
                     ->select(DB::raw('sum(Janvier) as J,sum(Fevrier) as F, sum(Mars) as M, sum(Avril) as A, sum(Mai) as Ma, sum(Juin) as Ju, sum(Juillet) as Jui, sum(Aout) as Ao, sum(semptembre) as S, sum(Octobre) as O, sum(Novembre) as N, sum(Decembre) as D, count(distinct(Affilier)) as AF, sum(Janvier+Fevrier+Mars+Avril+Mai+Juin+Juillet+Aout+semptembre+Octobre+Novembre+Decembre) as ST'))
                     ->where('cotisations.Etat', 0)
                     //->where('affiliers.Etat', 0)
                     ->whereBetween('DateCreation',[$request->Debut, $request->Fin])
                     ->get();           
         foreach($comm as $com){

            $id_Affilier=$com->Affilier;
            $Affilier=Affilier::where('id',$id_Affilier)->first();

            $table.="
                    <tr class='odd gradeX'>
                        <td>".$Affilier->Code."</td>
                        <td>".$Affilier->Nom.' '.$Affilier->Prenom."</td>
                         <td>".$com->J."</td>
                         <td>".$com->F."</td>
                        <td>".$com->M."</td>
                        <td>".$com->A."</td>
                        <td>".$com->Ma."</td>
                        <td>".$com->Ju."</td>
                        <td>".$com->Jui."</td>
                        <td>".$com->Ao."</td>
                        <td>".$com->S."</td>
                       <td>".$com->O."</td>
                       <td>".$com->N."</td>
                        <td>".$com->D."</td>
                        <td>".$com->ST."</td>
                    </tr>";
                    }
                       # code...
        }
        $tableListe=$table;
        $pdf = PDF::loadView('Cotisations.PdfCreateCotisation', compact('tableListe', 'Somme', 'Debut', 'Fin', 'Origine', 'Individu'))->setPaper('a3', 'Paysage');
         $fileName = 'Journal';
         return $pdf->stream($fileName . '.pdf');
        }
    }

    public function CorbCotisation()
    {
        $Cotisations = Cotisation::whereEtat(1)->get();
        $table="";
         foreach($Cotisations as $cot){

            $id_Affilier=$cot->Affilier;
            $Affilier=Affilier::where('id',$id_Affilier)->first();

            $table.="
                    <tr class='odd gradeX'>
                    <td>".$Affilier->Code."</td>
                        <td>".$Affilier->Nom.' '.$Affilier->Prenom."</td>
                         <td>".$cot->Mois."</td>
                         <td>".$cot->Annee."</td>
                        <td>".$cot->Montant."</td>
                        <td class='center f-icon'>
                            <a href='".route('RestaureCot',$cot)."'><img src='".url('icons/icons8_Reset_24px.png')."'></a>
                            

                             <form action='".route('SupprimerDefiniCot',$cot)."' method='POST' style='display:inline-block;'>
                               ".csrf_field()."
                                ".method_field('DELETE')."
                                <button><i class='fa fas-trash'></i>
                                    </button>
                                    
                                
                            </form>
                            
                        </td>
                    </tr>";
                    }
        $tableListe=$table;
        return view('Cotisations.CorbCotisation', compact('tableListe'));
    }

    public function RestaureCot($id)
    {
       $Cotisation = Cotisation::findOrFail($id);
            $Cotisation->update([
                'Etat' =>0
            ]);

           return redirect(route('CorbCotisation')); 
    }

      public function research(Request $request){
        $Affilier=$request->get('affilie');
        $Affiliers=Affilier::where('Code','like','%'.$Affilier.'%')->where('Etat',0)->get();
        $allAffiliers="";
        foreach ($Affiliers as $Affilier) {
            $allAffiliers.="<option value='".$Affilier->id."'>".$Affilier->Code.'/'.$Affilier->Nom.'/'.$Affilier->Prenom."</option>";
        }
        echo $allAffiliers;
    }

    public function historiquecotisationM($affilier_id){
        $Historiques = historiqueCotisationMontant::whereAffilierId($affilier_id)->get();
        return view('Cotisations.show_amount_cotisation_history', compact('Historiques', 'affilier_id'));
    }

    public function changeAmountCotisation(Request $request){
         $toDay = date('Y-m-d');
         $Historique = historiqueCotisationMontant::findOrFail($request->Historique);
         $Historique->update([
            'fin'=>$toDay
         ]);

         $Affilier = Affilier::findOrFail($request->affilier);
         $Affilier->update([
            'CotisationM'=>$request->Montant
         ]);
          //AJOUT DU MONTANT DANS L'HISTORIQUE  
            historiqueCotisationMontant::create([
               'affilier_id'=>$request->affilier,
               'motant'=>$request->Montant
            ]);
            return back();
    }
}
