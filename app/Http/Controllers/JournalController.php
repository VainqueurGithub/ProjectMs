<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use\App\Http\Requests\JournalRequest;
use App\Http\Requests;
use\App\Models\CompteSubdivisionnaire;
use Illuminate\Support\Facades\DB;
use PDF;
use\App\Models\ExerciceComptable;
use\App\Models\SousCompte;
use\App\Models\Repportage;
use\App\Models\ComptePrincipal;
use\App\Models\Journal;
use\App\Models\CodeJournaux;
use\App\Models\soldeJournalier;
use\App\Models\Type;
use Carbon\Carbon;
class JournalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $periode = date('Y-m-d');
        $CompteSubdivisionnaires = CompteSubdivisionnaire::whereEtat(0)->get();
        $NewJournal = New Journal;
        $Journals =DB::table('journals')
                  ->join('compte_subdivisionnaires', 'journals.Compte', '=', 'compte_subdivisionnaires.id')
                  ->Leftjoin('sous_comptes', 'journals.Sous_compte', '=', 'sous_comptes.id') 
                  ->select(DB::raw('journals.id, journals.DateOperation, journals.Ordre, journals.MD, journals.MC,compte_subdivisionnaires.NumeroCompte,journals.Libelle,journals.TypeMvt,journals.Piece, journals.DateOperation,sous_comptes.NumeroCompte as SC'))
                  ->where('journals.Etat', 0)
                  ->where('journals.Exercice', session()->get('ExerciceComptableId'))
                  ->where('journals.DateOperation', $periode)
                  ->get();

        $MD = Journal::whereEtatAndExerciceAndDateoperation(0,session()->get('ExerciceComptableId'), $periode)->sum('MD');
        $MC = Journal::whereEtatAndExerciceAndDateoperation(0,session()->get('ExerciceComptableId'), $periode)->sum('MC');

        $MD = number_format($MD,session()->get('ExerciceNbreDecimal'),session()->get('ExerciceSeparateurDecimal'),session()->get('ExerciceseparateurMilieu')).' '.session()->get('ExerciceDevise');
        $MC = number_format($MC,session()->get('ExerciceNbreDecimal'),session()->get('ExerciceSeparateurDecimal'),session()->get('ExerciceseparateurMilieu')).' '.session()->get('ExerciceDevise'); 

        return view("Comptabilite/Journal.index", compact('NewJournal', 'Journals', 'MD', 'MC','CompteSubdivisionnaires'));
    }
  

      //Impression du Journal sur PDF

    public function JournalPdf(Request $request){
      $Compte_m="";
    if(isset($request->SubAcount) && !empty($request->SubAcount)){

        $Compte_mouv = CompteSubdivisionnaire::findOrFail($request->SubAcount);
        $Compte_m.=' COMPTE SUBD. : '.$Compte_mouv->NumeroCompte.' / '.$Compte_mouv->Intitule;

    } elseif (isset($request->Acount) && !empty($request->Acount)) {

        $Compte_mouv = ComptePrincipal::findOrFail($request->Acount);
        $Compte_m.=' COMPTE PRINCIPAL : '.$Compte_mouv->NumeroCompte.' / '.$Compte_mouv->Intitule;

    } elseif (isset($request->Journal) && !empty($request->Journal)) {

        $Compte_mouv = CodeJournaux::findOrFail($request->Journal);
        $Compte_m.=' JOURNAL : '.$Compte_mouv->Code.' / '.$Compte_mouv->Journal;

    } elseif (isset($request->SAcount) && !empty($request->SAcount)) {

        $Compte_mouv = SousCompte::findOrFail($request->SAcount);
        $Compte_m.=' SOUS COMPTE : '.$Compte_mouv->NumeroCompte.' / '.$Compte_mouv->Intitule;

    }else{
      $Compte_m.='JOURNAL GENERAL : tous les comptes';
    }

    $Exe = ExerciceComptable::findOrFail(session()->get('ExerciceComptableId'));
    
    //Cas de L'impression selon un trie /Debut
      if (isset($request->Rapport)) 
      {  
         //Trie selon le compte subdivisionnaire et la date /Debut
         if(isset($request->SAcount) && !empty($request->SAcount) && isset($request->Debut) && !empty($request->Debut) && isset($request->Fin) && !empty($request->Fin)) {
           $Debut = $request->Debut;
           $Fin = $request->Fin;
           
           //On recupere le montant repporté le jour precedent
           $MontantRepport = soldeJournalier::whereSouscompteAndRepporterau($request->SAcount, $request->Debut)->sum('montant');
          
           //Requetes qui recupere Tous les mouvemnts du comptes au cours de la periode precise. 
             $Journals =DB::table('journals')
                  ->join('sous_comptes', 'sous_comptes.id', '=', 'journals.Sous_compte')
                  ->select(DB::raw('journals.id, journals.DateOperation, journals.Ordre, journals.MD, journals.MC,sous_comptes.NumeroCompte,sous_comptes.Intitule,journals.TypeMvt,journals.Piece, journals.Libelle'))
                  ->where('sous_comptes.id', $request->SAcount)
                  ->whereBetween('journals.DateOperation',[$Debut, $Fin])
                  ->where('journals.Exercice',session()->get('ExerciceComptableId'))
                  ->where('journals.Etat', 0)->get();

            //Requetes qui recupere la somme de debit des  mouvemnts du comptes au cours de la periode precise.
              $MD =DB::table('journals')
                  ->join('sous_comptes', 'sous_comptes.id', '=', 'journals.Sous_compte')
                  ->select(DB::raw('*')) 
                  ->where('journals.Etat', 0)
                  ->where('sous_comptes.id', $request->SAcount)
                  ->whereBetween('journals.DateOperation',[$Debut, $Fin])
                  ->where('journals.Exercice',session()->get('ExerciceComptableId'))
                  ->sum('MD');

            //Requetes qui recupere la somme de credit des  mouvemnts du comptes au cours de l'annee precise.
              $MC = DB::table('journals')
                  ->join('sous_comptes', 'sous_comptes.id', '=', 'journals.Sous_compte')
                  ->select(DB::raw('*')) 
                  ->where('journals.Etat', 0)
                  ->where('sous_comptes.id', $request->SAcount)
                  ->whereBetween('journals.DateOperation',[$Debut, $Fin])
                  ->where('journals.Exercice',session()->get('ExerciceComptableId'))
                  ->sum('MC');
         //Trie selon le sous compte et la date /Fin    
         }

         //Trie selon le compte subdivisionnaire et la date /Debut
         elseif(isset($request->SubAcount) && !empty($request->SubAcount) && isset($request->Debut) && !empty($request->Debut) && isset($request->Fin) && !empty($request->Fin)) {
           $Debut = $request->Debut;
           $Fin = $request->Fin;
           
           //On recupere le montant repporté le jour precedent
           $MontantRepport = soldeJournalier::whereComptesudbAndRepporterau($request->SubAcount, $request->Debut)->sum('montant');
          
           //Requetes qui recupere Tous les mouvemnts du comptes au cours de la periode precise. 
             $Journals =DB::table('journals')
                  ->join('compte_subdivisionnaires', 'journals.Compte', '=', 'compte_subdivisionnaires.id') 
                  ->select(DB::raw('journals.id, journals.DateOperation, journals.Ordre, journals.MD, journals.MC,compte_subdivisionnaires.NumeroCompte,compte_subdivisionnaires.Intitule,journals.TypeMvt,journals.Piece, journals.Libelle'))
                  ->where('compte_subdivisionnaires.id', $request->SubAcount)
                  ->whereBetween('journals.DateOperation',[$Debut, $Fin])
                  ->where('journals.Exercice',session()->get('ExerciceComptableId'))
                  ->where('journals.Etat', 0)->get();

            //Requetes qui recupere la somme de debit des  mouvemnts du comptes au cours de la periode precise.
              $MD =DB::table('journals')
                  ->join('compte_subdivisionnaires', 'compte_subdivisionnaires.id', '=', 'journals.Compte')
                  ->select(DB::raw('*')) 
                  ->where('journals.Etat', 0)
                  ->where('compte_subdivisionnaires.id', $request->SubAcount)
                  ->whereBetween('journals.DateOperation',[$Debut, $Fin])
                  ->where('journals.Exercice',session()->get('ExerciceComptableId'))
                  ->sum('MD');

            //Requetes qui recupere la somme de credit des  mouvemnts du comptes au cours de l'annee precise.
              $MC = DB::table('journals')
                  ->join('compte_subdivisionnaires', 'compte_subdivisionnaires.id', '=', 'journals.Compte')
                  ->select(DB::raw('*')) 
                  ->where('journals.Etat', 0)
                  ->where('compte_subdivisionnaires.id', $request->SubAcount)
                  ->whereBetween('journals.DateOperation',[$Debut, $Fin])
                  ->where('journals.Exercice',session()->get('ExerciceComptableId'))
                  ->sum('MC');
         //Trie selon le sous compte et la date /Fin    
         }

         //Trie selon le compte et la date /Debut
         elseif(isset($request->Acount) && !empty($request->Acount) && isset($request->Debut) && !empty($request->Debut) && isset($request->Fin) && !empty($request->Fin)){

           $Debut = $request->Debut;
           $Fin = $request->Fin;

           //Requetes qui recupere Tous les mouvemnts du comptes au cours de l'annee precise.
            $MontantRepport = soldeJournalier::whereComptesudbAndRepporterau($request->Acount, $request->Debut)->sum('montant');
            
             $Journals =DB::table('journals')
                  ->join('compte_subdivisionnaires', 'journals.Compte', '=', 'compte_subdivisionnaires.id')
                  ->join('compte_principals', 'compte_principals.id', '=', 'compte_subdivisionnaires.ComptePricipal')
                  ->select(DB::raw('journals.id, journals.DateOperation, journals.Ordre, journals.MD, journals.MC,compte_subdivisionnaires.NumeroCompte,compte_subdivisionnaires.Intitule,journals.TypeMvt,journals.Piece, journals.Libelle'))
                  ->where('compte_principals.id', $request->Acount)
                  ->whereBetween('journals.DateOperation',[$Debut, $Fin])
                  ->where('journals.Exercice',session()->get('ExerciceComptableId'))
                  ->where('journals.Etat', 0)->get();
            
            //Requetes qui recupere la somme de debit des  mouvemnts du compte au cours de l'annee precise.
              $MD =DB::table('journals')
                  ->join('compte_subdivisionnaires', 'compte_subdivisionnaires.id', '=', 'journals.Compte')
                  ->join('compte_principals', 'compte_principals.id', '=', 'compte_subdivisionnaires.ComptePricipal')
                  ->select(DB::raw('*')) 
                  ->where('journals.Etat', 0)
                  ->where('compte_principals.id', $request->Acount)
                  ->whereBetween('journals.DateOperation',[$Debut, $Fin])
                  ->where('journals.Exercice',session()->get('ExerciceComptableId'))
                  ->sum('MD');
            
            //Requetes qui recupere la somme de credit des  mouvemnts du compte au cours de l'annee precise.
              $MC = DB::table('journals')
                  ->join('compte_subdivisionnaires', 'compte_subdivisionnaires.id', '=', 'journals.Compte')
                  ->join('compte_principals', 'compte_principals.id', '=', 'compte_subdivisionnaires.ComptePricipal')
                  ->select(DB::raw('*')) 
                  ->where('journals.Etat', 0)
                  ->where('compte_principals.id', $request->Acount)
                  ->whereBetween('journals.DateOperation',[$Debut, $Fin])
                  ->where('journals.Exercice',session()->get('ExerciceComptableId'))
                  ->sum('MC');

          //Trie selon le compte et la date /Finn      
         }
         //Trie selon le Journal et la date /Debut
         elseif(isset($request->Journal) && !empty($request->Journal) && isset($request->Debut) && !empty($request->Debut) && isset($request->Fin) && !empty($request->Fin)){

           $Debut = $request->Debut;
           $Fin = $request->Fin;
            
             $MontantRepport = 0;

           //Requetes qui recupere Tous les mouvemnts du comptes au cours de l'annee precise.
             $Journals =DB::table('journals')
                  ->join('compte_subdivisionnaires', 'journals.Compte', '=', 'compte_subdivisionnaires.id')
                  ->join('compte_principals', 'compte_principals.id', '=', 'compte_subdivisionnaires.ComptePricipal')
                  ->join('compte_journals', 'compte_journals.Compte', '=', 'compte_principals.id')
                  ->join('code_journauxes', 'code_journauxes.id', '=', 'compte_journals.Journal')
                  ->select(DB::raw('journals.id, journals.DateOperation, journals.Ordre, journals.MD, journals.MC,compte_subdivisionnaires.NumeroCompte,compte_subdivisionnaires.Intitule,journals.TypeMvt,journals.Piece, journals.Libelle'))
                  ->where('code_journauxes.id', $request->Journal)
                  ->whereBetween('journals.DateOperation',[$Debut, $Fin])
                  ->where('journals.Exercice',session()->get('ExerciceComptableId'))
                  ->where('journals.Etat', 0)->get();
            
            //Requetes qui recupere la somme de debit des  mouvemnts du compte au cours de l'annee precise.
              $MD =DB::table('journals')
                  ->join('compte_subdivisionnaires', 'compte_subdivisionnaires.id', '=', 'journals.Compte')
                  ->join('compte_principals', 'compte_principals.id', '=', 'compte_subdivisionnaires.ComptePricipal')
                  ->join('compte_journals', 'compte_journals.Compte', '=', 'compte_principals.id')
                  ->join('code_journauxes', 'code_journauxes.id', '=', 'compte_journals.Journal')
                  ->select(DB::raw('*')) 
                  ->where('journals.Etat', 0)
                  ->where('code_journauxes.id', $request->Journal)
                  ->whereBetween('journals.DateOperation',[$Debut, $Fin])
                  ->where('journals.Exercice',session()->get('ExerciceComptableId'))
                  ->sum('MD');
            
            //Requetes qui recupere la somme de credit des  mouvemnts du compte au cours de l'annee precise.
              $MC = DB::table('journals')
                  ->join('compte_subdivisionnaires', 'compte_subdivisionnaires.id', '=', 'journals.Compte')
                  ->join('compte_principals', 'compte_principals.id', '=', 'compte_subdivisionnaires.ComptePricipal')
                  ->join('compte_journals', 'compte_journals.Compte', '=', 'compte_principals.id')
                  ->join('code_journauxes', 'code_journauxes.id', '=', 'compte_journals.Journal')
                  ->select(DB::raw('*')) 
                  ->where('journals.Etat', 0)
                  ->where('code_journauxes.id', $request->Journal)
                  ->whereBetween('journals.DateOperation',[$Debut, $Fin])
                  ->where('journals.Exercice',session()->get('ExerciceComptableId'))
                  ->sum('MC');

          //Trie selon le Journal et la date /Fin        
         }
          //Cas Trie /Fin
        } 
        //Debut Cas du Non tri
         else{
          $MontantRepport = 0;
         $Journals =DB::table('journals')
                  ->join('compte_subdivisionnaires', 'journals.Compte', '=', 'compte_subdivisionnaires.id') 
                  ->select(DB::raw('journals.id, journals.DateOperation, journals.Ordre, journals.MD, journals.MC,compte_subdivisionnaires.NumeroCompte,compte_subdivisionnaires.Intitule,journals.TypeMvt,journals.Piece, journals.Libelle'))
                  ->where('journals.Exercice',session()->get('ExerciceComptableId'))
                  ->where('journals.Etat', 0)->get();
              
        $MD = Journal::whereEtatAndExercice(0,session()->get('ExerciceComptableId'))->sum('MD');
        $MC = Journal::whereEtatAndExercice(0,session()->get('ExerciceComptableId'))->sum('MC');

        // Fin cas non tri
      }
        $table ="";
        $table.="
           <tr>
             <td colspan='6'>A NOUVEAU</td>
             <td colspan='2'>". number_format($MontantRepport,$Exe->NbreDecimal,$Exe->separateurDecimal,$Exe->separateurMilieu).' '.$Exe->Devise."</td>
            </tr>";
        foreach ($Journals as $Journal) {
           if ($Journal->TypeMvt ==1) 
           { 
            $table.="
            <tr>
             <td>".$Journal->DateOperation."</td>
             <td>".$Journal->Ordre."</td>
             <td>".$Journal->NumeroCompte."</td>
             <td></td>
             <td>".$Journal->Intitule."</td>
             <td>".$Journal->Libelle."</td>
             <td>". number_format($Journal->MD,$Exe->NbreDecimal,$Exe->separateurDecimal,$Exe->separateurMilieu).' '.$Exe->Devise."</td>
            <td>".number_format($Journal->MC,$Exe->NbreDecimal,$Exe->separateurDecimal,$Exe->separateurMilieu).' '.$Exe->Devise."</td>
            </tr>";
           }
           elseif ($Journal->TypeMvt ==2) {
            $table.="<tr>
             <td>".$Journal->DateOperation."</td>
             <td>".$Journal->id."</td>
             <td></td>
             <td>".$Journal->NumeroCompte."</td>
             <td>".$Journal->Intitule."</td>
             <td>".$Journal->Libelle."</td>
             <td>".number_format($Journal->MD,$Exe->NbreDecimal,$Exe->separateurDecimal,$Exe->separateurMilieu).' '.$Exe->Devise."</td>
            <td>".number_format($Journal->MC,$Exe->NbreDecimal,$Exe->separateurDecimal,$Exe->separateurMilieu).' '.$Exe->Devise."</td>
            </tr>";
             }  
        }
        $tableListe = $table;
        $SOLDE = $MD-$MC;
        $MD = number_format($MD,$Exe->NbreDecimal,$Exe->separateurDecimal,$Exe->separateurMilieu).' '.$Exe->Devise;
        $MC = number_format($MC,$Exe->NbreDecimal,$Exe->separateurDecimal,$Exe->separateurMilieu).' '.$Exe->Devise;
        
        $SOLDE = number_format($MontantRepport+$SOLDE,$Exe->NbreDecimal,$Exe->separateurDecimal,$Exe->separateurMilieu).' '.$Exe->Devise;
        $pdf = PDF::loadView('Comptabilite/Journal.JournalPdf', compact('tableListe', 'MD', 'MC','Compte_m', 'Debut', 'Fin', 'SOLDE'))->setPaper('a2', 'Paysage');
         $fileName = 'Facture';
         return $pdf->stream($fileName . '.pdf');  
   }  
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JournalRequest $request)
    {  
       if (Journal::UniqueFillfieldAcountNumber($request->CD,$request->CC) == true) {

        if (Journal::UniqueFillfieldAmount($request->MD,$request->MC) ==true) {
            if (Journal::matchingSetting($request->CD,$request->MD,$request->CC,$request->MC)) {


           if (isset($request->CD) AND !empty($request->CD)) {
               Journal::create([
            //'Ordre'=>$request->Ordre,
            'Compte'=>$request->CD,
            'TypeMvt'=>1,
            'Sous_compte'=>$request->sc_compte1,
            'DateOperation'=>$request->DateOperation,
            'Piece'=>$request->Piece,
            'MD'=>$request->MD,
            'MC'=>$request->MC,
            'Libelle'=>$request->Libelle,
            'Exercice'=>session()->get('ExerciceComptableId')
              ]);
           }else{
                
             Journal::create([
            //'Ordre'=>$request->Ordre,
            'Compte'=>$request->CC,
            'TypeMvt'=>2,
            'Sous_compte'=>$request->sc_compte1,
            'DateOperation'=>$request->DateOperation,
            'Piece'=>$request->Piece,
            'MD'=>$request->MD,
            'MC'=>$request->MC,
            'Libelle'=>$request->Libelle,
            'Exercice'=>session()->get('ExerciceComptableId')
              ]);
           }
          
          Journal::changeeditorialmode(session()->get('ExerciceComptableId'));
            }else{
               session()->flash('messageDelete', 'Veuillez Respecter la correspondance des données!');
            }
        }else{
               session()->flash('messageDelete', 'Remplissez soit le Montant Debit soit le Montant Credit!');
            } 
        }else{
               session()->flash('messageDelete', 'Remplissez soit le Compte Debit soit le Compte Credit!');
            }

        return redirect(route('Journal.index')); 
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
      $CompteSubdD = new CompteSubdivisionnaire;
      $CompteSubdC = new CompteSubdivisionnaire;
      $NewJournal = Journal::findOrFail($id);
      $CompteSubdivisionnaires = CompteSubdivisionnaire::whereEtat(0)->get();
      $CompteSubd = CompteSubdivisionnaire::findOrFail($NewJournal->Compte);
      
      $Nbresousc = SousCompte::whereId($NewJournal->Sous_compte)->count('id');
      if ($Nbresousc==0) {
        $Sousc = new SousCompte;
      }else{
        $Sousc = SousCompte::findOrFail($NewJournal->Sous_compte);
      }
      if ($NewJournal->TypeMvt==1) {
        $CompteSubdD = $CompteSubd;
      }else if($NewJournal->TypeMvt==2){
        $CompteSubdC = $CompteSubd;
      }
      $CD = CompteSubdivisionnaire::findOrFail($NewJournal->Compte);
      return view("Comptabilite/Journal.edit", compact('NewJournal', 'CD', 'CompteSubdivisionnaires', 'CompteSubdD', 'CompteSubdC', 'Sousc'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(JournalRequest $request, $id)
    { 
       $Journal = Journal::findOrFail($id);
       if (Journal::UniqueFillfieldAcountNumber($request->CD,$request->CC) == true) {
        if (Journal::UniqueFillfieldAmount($request->MD,$request->MC) ==true) {
            if (Journal::matchingSetting($request->CD,$request->MD,$request->CC,$request->MC)) {

            if (isset($request->CD) AND !empty($request->CD)) {
               $Journal->update([
            //'Ordre'=>$request->Ordre,
            'Compte'=>$request->CD,
            'TypeMvt'=>1,
            'Sous_compte'=>$request->sc_compte1,
            'DateOperation'=>$request->DateOperation,
            'Piece'=>$request->Piece,
            'MD'=>$request->MD,
            'MC'=>$request->MC,
            'Libelle'=>$request->Libelle
            //'Exercice'=>session()->get('ExerciceComptableId')
              ]);
           }else{
                
             $Journal->update([
            //'Ordre'=>$request->Ordre,
            'Compte'=>$request->CC,
            'TypeMvt'=>2,
            'Sous_compte'=>$request->sc_compte1,
            'DateOperation'=>$request->DateOperation,
            'Piece'=>$request->Piece,
            'MD'=>$request->MD,
            'MC'=>$request->MC,
            'Libelle'=>$request->Libelle,
            //'Exercice'=>session()->get('ExerciceComptableId')
              ]);
           } 
           
            }else{
               session()->flash('messageDelete', 'Veuillez Respecter la correspondance des données!');
            }
        }else{
               session()->flash('messageDelete', 'Remplissez soit le Montant Debit soit le Montant Credit!');
            } 
        }else{
               session()->flash('messageDelete', 'Remplissez soit le Compte Debit soit le Compte Credit!');
            }

        return redirect(route('Journal.index')); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Journal::destroy($id);
         return redirect(route('Journal.index'));
    }


    //Affichage de tous les journaux
    public function PlanComptable()
    {
        $Comptes = ComptePrincipal::whereEtat(0)->get();
       
            $table="";

            foreach ($Comptes as $Compte) 
            { 
                
                $table.="<tr style='background-color:silver; font-weight:bold;'>
                  <td>".$Compte->NumeroCompte."</td>
                  <td>".$Compte->Intitule."</td>
                </tr>";
                $SComptes = CompteSubdivisionnaire::whereEtatAndComptepricipal(0,$Compte->id)->get();
                foreach ($SComptes as $SCompte) 
               {
                $table.="<tr style='background-color:white;'>
                  <td><button style='border:none;cursor:pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this);' value=".$SCompte->id." return false;'>".$SCompte->NumeroCompte."</button></td>
                  <td>".$SCompte->Intitule."</td>
                </tr>";
               }
            }
        $tableListe = $table;
        return view("Comptabilite/Journal.PlanComptable", compact("tableListe"));    
    }

    public function Balance()
    {
        $Comptes = ComptePrincipal::whereEtat(0)->get();
        $Types = Type::whereEtat(0)->get();
        $SComptes = CompteSubdivisionnaire::whereEtat(0)->get();
        return view("Comptabilite.Balance", compact('SComptes', 'Comptes', 'Types'));
    }

    public function research(Request $request){
        $Compte=$request->get('NumeroCompte');
        $SComptes=CompteSubdivisionnaire::where('NumeroCompte','like','%'.$Compte.'%')->where('Etat',0)->get();
        $AllSComptes="";
        foreach ($SComptes as $SCompte) {
            $AllSComptes.="<option value='".$SCompte->id."'>".$SCompte->NumeroCompte.'/'.$SCompte->Intitule."</option>";
        }
        echo $AllSComptes;
    }

        public function research1(Request $request){
        $Compte=$request->get('NumeroCompte');
        $SComptes=CompteSubdivisionnaire::where('NumeroCompte','like','%'.$Compte.'%')->where('Etat',0)->get();
        $AllSComptes="";
        foreach ($SComptes as $SCompte) {
            $AllSComptes.="<option value='".$SCompte->id."'>".$SCompte->NumeroCompte.'/'.$SCompte->Intitule."</option>";
        }
        echo $AllSComptes;
    }

    public function research2(Request $request){
        $Compte=$request->get('NumeroCompte');
        $SComptes=CompteSubdivisionnaire::where('NumeroCompte','like','%'.$Compte.'%')->where('Etat',0)->get();
        $AllSComptes="";
        foreach ($SComptes as $SCompte) {
            $AllSComptes.="<option value='".$SCompte->id."'>".$SCompte->NumeroCompte.'/'.$SCompte->Intitule."</option>";
        }
        echo $AllSComptes;
    }

    public function research3(Request $request){
        $Compte=$request->get('NumeroCompte');
        $SComptes=ComptePrincipal::where('NumeroCompte','like','%'.$Compte.'%')->where('Etat',0)->get();
        $AllSComptes="";
        foreach ($SComptes as $SCompte) {
            $AllSComptes.="<option value='".$SCompte->id."'>".$SCompte->NumeroCompte.'/'.$SCompte->Intitule."</option>";
        }
        echo $AllSComptes;
    }

     public function research4(Request $request){
        $Journal=$request->get('Journal');
        $Journals=CodeJournaux::where('Code','like','%'.$Journal.'%')->where('Etat',0)->get();
        $AllJournals="";
        foreach ($Journals as $Journal) {
            $AllJournals.="<option value='".$Journal->id."'>".$Journal->Code.'/'.$Journal->Journal."</option>";
        }
        echo $AllJournals;
    }


    //Function for generating Grand Livre According to user Request
    public function AfficherGdLivre(Request $request){
      $Exercices = ExerciceComptable::whereEtat(0)->get();
       // RETRIEVING ALL THE MAIN ACOUNTS FROM DATA BASE
      $SOLDEGEND = 0;
      $SOLDEGENC = 0;

      $Comptes = DB::table('types')
                ->join('compte_principals', 'compte_principals.TypeCompte', '=', 'types.id')
                ->leftJoin('compte_subdivisionnaires', 'compte_subdivisionnaires.ComptePricipal', '=', 'compte_principals.id')
                ->select(DB::raw('compte_principals.id, compte_principals.NumeroCompte, compte_principals.Intitule'))
                ->GroupBy('compte_principals.id')
                ->get();

     if (isset($request->Exercice)) {
          $Exe =$request->Exercice;
          $ExerciceComptab = ExerciceComptable::findOrFail($request->Exercice);
      }else{
          $Exe =session()->get('ExerciceComptableId');
      }
    
    

       $table="";
       foreach ($Comptes as $Compte) {
        $SOLDE = 0; 
            $table.="
                <tbody>
                  <tr style='text-align:center;font-weight:bold;background-color:silver;'>
                    <td colspan='4'>".'Compte '.$Compte->NumeroCompte.' '.$Compte->Intitule."</td>
                  </tr>";

            $Report =DB::table('compte_principals')
              ->join('repportages', 'repportages.compte_id', '=', 'compte_principals.id')
              ->select(DB::raw('repportages.created_at,sum(repportages.montant) as montant, repportages.type_mvt'))
              ->where('compte_principals.id', $Compte->id)
              ->whereReportedIn($Exe)
              ->groupBy('compte_principals.id')
              ->first();

            $GrandLivres = DB::table('types')
              ->join('compte_principals', 'compte_principals.TypeCompte', '=', 'types.id')
              ->join('compte_subdivisionnaires', 'compte_subdivisionnaires.ComptePricipal', '=', 'compte_principals.id')
              ->join('journals', 'journals.Compte', '=', 'compte_subdivisionnaires.id')
              ->select(DB::raw('journals.DateOperation, journals.MD, journals.MC, compte_subdivisionnaires.Intitule,journals.TypeMvt,compte_subdivisionnaires.id'))
              ->where('journals.Exercice',$Exe)
              ->where('compte_subdivisionnaires.ComptePricipal', $Compte->id)
              ->get();  
             
            if (!is_null($Report)) {
                $SOLDE = $Report->montant;
                if ($Report->type_mvt==1) {
                  $SOLDEGEND+=$Report->montant;
                  $table.="
                    <tr style='background-color:white;'>
                      <td>".Carbon::parse($Report->created_at)->format('d-m-Y')."</td>
                      <td>REPPORT A NOUVEAU</td>
                      <td>".number_format($Report->montant,session()->get('ExerciceNbreDecimal'),session()->get('ExerciceSeparateurDecimal'),session()->get('ExerciceseparateurMilieu')).' '.session()->get('ExerciceDevise')."</td>
                      <td></td>
                    </tr>";
                }else{
                  $SOLDEGENC+=$Report->montant;
                  $table.="
                    <tr style='background-color:white;'>
                      <td>".Carbon::parse($Report->created_at)->format('d-m-Y')."</td>
                      <td>REPPORT A NOUVEAU</td>
                      <td></td>
                      <td>".number_format($Report->montant,session()->get('ExerciceNbreDecimal'),session()->get('ExerciceSeparateurDecimal'),session()->get('ExerciceseparateurMilieu')).' '.session()->get('ExerciceDevise')."</td>
                    </tr>";
                }
             } 

            foreach ($GrandLivres as $GrandLivre) {   

                if ($GrandLivre->TypeMvt==1) {
                  $SOLDE+=$GrandLivre->MD;
                  $SOLDEGEND+=$GrandLivre->MD;
                     $table.="
                <tr style='background-color:white;'>
                  <td>".$GrandLivre->DateOperation."</td>
                  <td>".$GrandLivre->Intitule."</td>
                  <td>".number_format($GrandLivre->MD,session()->get('ExerciceNbreDecimal'),session()->get('ExerciceSeparateurDecimal'),session()->get('ExerciceseparateurMilieu')).' '.session()->get('ExerciceDevise')."</td>
                  <td></td>
                </tr>";
                }elseif ($GrandLivre->TypeMvt==2) {
                  $SOLDE+=$GrandLivre->MC;
                  $SOLDEGENC+=$GrandLivre->MC;
                     $table.="
                <tr style='background-color:white;'>
                  <td>".$GrandLivre->DateOperation."</td>
                  <td>".$GrandLivre->Intitule."</td>
                  <td></td>
                  <td>".number_format($GrandLivre->MC,session()->get('ExerciceNbreDecimal'),session()->get('ExerciceSeparateurDecimal'),session()->get('ExerciceseparateurMilieu')).' '.session()->get('ExerciceDevise')."</td>
                </tr>";
                }
            }

              $table.="<tr style='background-color:white;'>
                  <td colspan='3'> SOLDE </td>
                  <td>".number_format($SOLDE,session()->get('ExerciceNbreDecimal'),session()->get('ExerciceSeparateurDecimal'),session()->get('ExerciceseparateurMilieu')).' '.session()->get('ExerciceDevise')."</td>
                </tr>";              
       }          
      
       $table.="
                <tr style='background-color:white;'>
                  <td colspan='2'>SOLDE GENERAL</td>
                  <td>".number_format($SOLDEGEND,session()->get('ExerciceNbreDecimal'),session()->get('ExerciceSeparateurDecimal'),session()->get('ExerciceseparateurMilieu')).' '.session()->get('ExerciceDevise')."</td>
                  <td>".number_format($SOLDEGENC,session()->get('ExerciceNbreDecimal'),session()->get('ExerciceSeparateurDecimal'),session()->get('ExerciceseparateurMilieu')).' '.session()->get('ExerciceDevise')."</td>
                </tr>";
    
            $tableListe = $table;

      if (isset($request->Exercice)) {
          $pdf = PDF::loadView('Comptabilite.GrandLivrePdf', compact('tableListe', 'ExerciceComptab'))->setPaper('a3', 'Paysage');
            $fileName = 'Facture';
             return $pdf->stream($fileName . '.pdf');
      }else{
          return view("Comptabilite.AfficherGdLivre", compact('tableListe', 'Exercices'));
      }
    }

    public function AfficherBalance(Request $request){
      
      $Exercices = ExerciceComptable::whereEtat(0)->get();
      // RETRIEVING ALL THE MAIN ACOUNTS FROM DATA BASE
      $TOTALRNVD = 0;
      $TOTALRNVC = 0;

      $TOTALMVTD = 0;
      $TOTALMVTC = 0;

      $SOLDE = 0;

      $Comptes = DB::table('types')
                ->join('compte_principals', 'compte_principals.TypeCompte', '=', 'types.id')
                ->leftJoin('compte_subdivisionnaires', 'compte_subdivisionnaires.ComptePricipal', '=', 'compte_principals.id')
                ->leftJoin('journals', 'journals.Compte', '=', 'compte_subdivisionnaires.id')
                ->select(DB::raw('compte_principals.id, compte_principals.NumeroCompte, compte_principals.Intitule, sum(journals.MD) as MD, sum(journals.MC) as MC'))
                ->GroupBy('compte_principals.id')
                ->get();

     if (isset($request->Exercice)) {
          $Exe =$request->Exercice;
          $ExerciceComptab = ExerciceComptable::findOrFail($request->Exercice);
      }else{
          $Exe =session()->get('ExerciceComptableId');
      }
    
    

       $table="";
       foreach ($Comptes as $Compte) {

        $ReportD =DB::table('compte_principals')
              ->join('repportages', 'repportages.compte_id', '=', 'compte_principals.id')
              ->select(DB::raw(''))
              ->where('compte_principals.id', $Compte->id)
              ->whereReportedIn($Exe)
              ->where('repportages.type_mvt', 1)
              ->groupBy('compte_principals.id')
              ->sum('montant');

        $ReportC =DB::table('compte_principals')
              ->join('repportages', 'repportages.compte_id', '=', 'compte_principals.id')
              ->select(DB::raw(''))
              ->where('compte_principals.id', $Compte->id)
              ->whereReportedIn($Exe)
              ->where('repportages.type_mvt', 2)
              ->groupBy('compte_principals.id')
              ->sum('montant'); 

        $TOTALRNVD+=$ReportD;
        $TOTALRNVC+=$ReportC;

        $TOTALMVTD+= $Compte->MD;
        $TOTALMVTC+= $Compte->MC;

        $SOLDE = ($ReportD-$ReportC)+($Compte->MD-$Compte->MC); 
             $table.="<tr style='background-color:white;text-align:center;'>
                   <td>".$Compte->NumeroCompte."</td>
                   <td>".$Compte->Intitule."</td>
                    <td style='background-color:silver'>".number_format($ReportD,session()->get('ExerciceNbreDecimal'),session()->get('ExerciceSeparateurDecimal'),session()->get('ExerciceseparateurMilieu')).' '.session()->get('ExerciceDevise')."</td>

                     <td style='background-color:silver'>".number_format($ReportC,session()->get('ExerciceNbreDecimal'),session()->get('ExerciceSeparateurDecimal'),session()->get('ExerciceseparateurMilieu')).' '.session()->get('ExerciceDevise')."</td>

                   <td>".number_format($Compte->MD,session()->get('ExerciceNbreDecimal'),session()->get('ExerciceSeparateurDecimal'),session()->get('ExerciceseparateurMilieu')).' '.session()->get('ExerciceDevise')."</td>

                   <td>".number_format($Compte->MC,session()->get('ExerciceNbreDecimal'),session()->get('ExerciceSeparateurDecimal'),session()->get('ExerciceseparateurMilieu')).' '.session()->get('ExerciceDevise')."</td>";

                  if ($SOLDE>0) {
                    $table.="
                       <td>".number_format($SOLDE,session()->get('ExerciceNbreDecimal'),session()->get('ExerciceSeparateurDecimal'),session()->get('ExerciceseparateurMilieu')).' '.session()->get('ExerciceDevise')."</td>

                       <td>".number_format(0,session()->get('ExerciceNbreDecimal'),session()->get('ExerciceSeparateurDecimal'),session()->get('ExerciceseparateurMilieu')).' '.session()->get('ExerciceDevise')."</td>
                     </tr>";
                  }else if($SOLDE<0){
                     $SOLDE*=-1;
                     $table.="
                       <td>".number_format(0,session()->get('ExerciceNbreDecimal'),session()->get('ExerciceSeparateurDecimal'),session()->get('ExerciceseparateurMilieu')).' '.session()->get('ExerciceDevise')."</td>

                       <td>".number_format($SOLDE,session()->get('ExerciceNbreDecimal'),session()->get('ExerciceSeparateurDecimal'),session()->get('ExerciceseparateurMilieu')).' '.session()->get('ExerciceDevise')."</td>
                     </tr>";
                  }else{
                    $table.="
                      <td>".number_format(0,session()->get('ExerciceNbreDecimal'),session()->get('ExerciceSeparateurDecimal'),session()->get('ExerciceseparateurMilieu')).' '.session()->get('ExerciceDevise')."</td>

                       <td>".number_format(0,session()->get('ExerciceNbreDecimal'),session()->get('ExerciceSeparateurDecimal'),session()->get('ExerciceseparateurMilieu')).' '.session()->get('ExerciceDevise')."</td>
                     </tr>";
                  }
          }


          $table.="<tr>
              <td colspan='2'>TOTAL BALANCE</td>

              <td>".number_format($TOTALRNVD,session()->get('ExerciceNbreDecimal'),session()->get('ExerciceSeparateurDecimal'),session()->get('ExerciceseparateurMilieu')).' '.session()->get('ExerciceDevise')."</td>

              <td>".number_format($TOTALRNVC,session()->get('ExerciceNbreDecimal'),session()->get('ExerciceSeparateurDecimal'),session()->get('ExerciceseparateurMilieu')).' '.session()->get('ExerciceDevise')."</td>

              <td>".number_format($TOTALMVTD,session()->get('ExerciceNbreDecimal'),session()->get('ExerciceSeparateurDecimal'),session()->get('ExerciceseparateurMilieu')).' '.session()->get('ExerciceDevise')."</td>

              <td>".number_format($TOTALMVTC,session()->get('ExerciceNbreDecimal'),session()->get('ExerciceSeparateurDecimal'),session()->get('ExerciceseparateurMilieu')).' '.session()->get('ExerciceDevise')."</td>

              <td>".number_format($TOTALRNVD+$TOTALMVTD,session()->get('ExerciceNbreDecimal'),session()->get('ExerciceSeparateurDecimal'),session()->get('ExerciceseparateurMilieu')).' '.session()->get('ExerciceDevise')."</td>

              <td>".number_format($TOTALRNVC+$TOTALMVTC,session()->get('ExerciceNbreDecimal'),session()->get('ExerciceSeparateurDecimal'),session()->get('ExerciceseparateurMilieu')).' '.session()->get('ExerciceDevise')."</td>
            </tr>";
       $tableListe = $table;

        if (isset($request->Exercice)) {
            $pdf = PDF::loadView('Comptabilite.BalancePdf', compact('tableListe', 'ExerciceComptab'))->setPaper('a3', 'Paysage');
            $fileName = 'Facture';
             return $pdf->stream($fileName . '.pdf');
        }else{
            return view("Comptabilite.AfficherBalance", compact('tableListe', 'Exercices'));
        }

                  
    }

    public function CompteResultat(){
        $Exercices = ExerciceComptable::whereEtat(0)->get();
        $ComptesResultats = DB::table('types')
            ->join('compte_principals', 'compte_principals.TypeCompte', '=', 'types.id')
            ->leftJoin('compte_subdivisionnaires', 'compte_subdivisionnaires.ComptePricipal', '=', 'compte_principals.id')
            ->leftJoin('journals', 'journals.Compte', '=', 'compte_subdivisionnaires.id')
            ->select(DB::raw(' sum(journals.MD) as MD, sum(journals.MC) as MC, compte_subdivisionnaires.Intitule, compte_subdivisionnaires.NumeroCompte, Types.Class, compte_principals.Appartenance'))
            ->where('types.Type_Compte', 2)
            ->GroupBy('compte_subdivisionnaires.NumeroCompte')
            ->get();

// CALCUL RESULTAT FINANCIER
// ON CALCUL LE TOTAUX DEBIT ET CREDIT POUR CHARGE FINANCIER
    $TotalCFMD = DB::table('types')
            ->join('compte_principals', 'compte_principals.TypeCompte', '=', 'types.id')
            ->join('compte_subdivisionnaires', 'compte_subdivisionnaires.ComptePricipal', '=', 'compte_principals.id')
            ->join('journals', 'journals.Compte', '=', 'compte_subdivisionnaires.id')
            ->select(DB::raw('*'))
            ->where('compte_principals.Appartenance', 'financier')
            ->where('types.Class', 6)
            ->where('journals.Exercice', session()->get('ExerciceComptableId'))
            ->sum('MD');  

    $TotalCFMC = DB::table('types')
            ->join('compte_principals', 'compte_principals.TypeCompte', '=', 'types.id')
            ->join('compte_subdivisionnaires', 'compte_subdivisionnaires.ComptePricipal', '=', 'compte_principals.id')
            ->join('journals', 'journals.Compte', '=', 'compte_subdivisionnaires.id')
            ->select(DB::raw('*'))
            ->where('compte_principals.Appartenance', 'financier')
            ->where('types.Class', 6)
            ->where('journals.Exercice', session()->get('ExerciceComptableId'))
            ->sum('MC');

    $SOLDECF = $TotalCFMD - $TotalCFMC;

    // ON CALCUL LE TOTAUX DEBIT ET CREDIT POUR PRODUITS FINANCIER
    $TotalPFMD = DB::table('types')
            ->join('compte_principals', 'compte_principals.TypeCompte', '=', 'types.id')
            ->join('compte_subdivisionnaires', 'compte_subdivisionnaires.ComptePricipal', '=', 'compte_principals.id')
            ->join('journals', 'journals.Compte', '=', 'compte_subdivisionnaires.id')
            ->select(DB::raw('*'))
            ->where('compte_principals.Appartenance', 'financier')
            ->where('types.Class', 7)
            ->where('journals.Exercice', session()->get('ExerciceComptableId'))
            ->sum('MD');  

    $TotalPFMC = DB::table('types')
            ->join('compte_principals', 'compte_principals.TypeCompte', '=', 'types.id')
            ->join('compte_subdivisionnaires', 'compte_subdivisionnaires.ComptePricipal', '=', 'compte_principals.id')
            ->join('journals', 'journals.Compte', '=', 'compte_subdivisionnaires.id')
            ->select(DB::raw('*'))
            ->where('compte_principals.Appartenance', 'financier')
            ->where('types.Class', 7)
            ->where('journals.Exercice', session()->get('ExerciceComptableId'))
            ->sum('MC');  

    $SOLDEPF = $TotalPFMD - $TotalPFMC;
    $RESULTATFINANCIER = $SOLDEPF - $SOLDECF;

     
     // CALCUL RESULTAT D'EXPLOITATION
    // ON CALCUL LE TOTAUX DEBIT ET CREDIT POUR CHARGE EXPLOITATION
    $TotalCEMD = DB::table('types')
            ->join('compte_principals', 'compte_principals.TypeCompte', '=', 'types.id')
            ->join('compte_subdivisionnaires', 'compte_subdivisionnaires.ComptePricipal', '=', 'compte_principals.id')
            ->join('journals', 'journals.Compte', '=', 'compte_subdivisionnaires.id')
            ->select(DB::raw('*'))
            ->where('compte_principals.Appartenance', 'exploitation')
            ->where('types.Class', 6)
            ->where('journals.Exercice', session()->get('ExerciceComptableId'))
            ->sum('MD');  

    $TotalCEMC = DB::table('types')
            ->join('compte_principals', 'compte_principals.TypeCompte', '=', 'types.id')
            ->join('compte_subdivisionnaires', 'compte_subdivisionnaires.ComptePricipal', '=', 'compte_principals.id')
            ->join('journals', 'journals.Compte', '=', 'compte_subdivisionnaires.id')
            ->select(DB::raw('*'))
            ->where('compte_principals.Appartenance', 'exploitation')
            ->where('types.Class', 6)
            ->where('journals.Exercice', session()->get('ExerciceComptableId'))
            ->sum('MC');

    $SOLDECE = $TotalCEMD - $TotalCEMC;

    // ON CALCUL LE TOTAUX DEBIT ET CREDIT POUR PRODUITS EXPLOITATION
    $TotalPEMD = DB::table('types')
            ->join('compte_principals', 'compte_principals.TypeCompte', '=', 'types.id')
            ->join('compte_subdivisionnaires', 'compte_subdivisionnaires.ComptePricipal', '=', 'compte_principals.id')
            ->join('journals', 'journals.Compte', '=', 'compte_subdivisionnaires.id')
            ->select(DB::raw('*'))
            ->where('compte_principals.Appartenance', 'exploitation')
            ->where('types.Class', 7)
            ->where('journals.Exercice', session()->get('ExerciceComptableId'))
            ->sum('MD');  

    $TotalPEMC = DB::table('types')
            ->join('compte_principals', 'compte_principals.TypeCompte', '=', 'types.id')
            ->join('compte_subdivisionnaires', 'compte_subdivisionnaires.ComptePricipal', '=', 'compte_principals.id')
            ->join('journals', 'journals.Compte', '=', 'compte_subdivisionnaires.id')
            ->select(DB::raw('*'))
            ->where('compte_principals.Appartenance', 'exploitation')
            ->where('types.Class', 7)
            ->where('journals.Exercice', session()->get('ExerciceComptableId'))
            ->sum('MC');  

    $SOLDEPE = $TotalPEMD - $TotalPEMC;
    $RESULTATEXPLOITATION = $SOLDEPE - $SOLDECE;

    // CALCUL DE RESULTAT EXCEPTIONNEL
    // ON CALCUL LE TOTAUX DEBIT ET CREDIT POUR CHARGE EXCEPTIONNEL
    $TotalCEXMD = DB::table('types')
            ->join('compte_principals', 'compte_principals.TypeCompte', '=', 'types.id')
            ->join('compte_subdivisionnaires', 'compte_subdivisionnaires.ComptePricipal', '=', 'compte_principals.id')
            ->join('journals', 'journals.Compte', '=', 'compte_subdivisionnaires.id')
            ->select(DB::raw('*'))
            ->where('compte_principals.Appartenance', 'exceptionnel')
            ->where('types.Class', 6)
            ->where('journals.Exercice', session()->get('ExerciceComptableId'))
            ->sum('MD');  

    $TotalCEXMC = DB::table('types')
            ->join('compte_principals', 'compte_principals.TypeCompte', '=', 'types.id')
            ->join('compte_subdivisionnaires', 'compte_subdivisionnaires.ComptePricipal', '=', 'compte_principals.id')
            ->join('journals', 'journals.Compte', '=', 'compte_subdivisionnaires.id')
            ->select(DB::raw('*'))
            ->where('compte_principals.Appartenance', 'exceptionnel')
            ->where('types.Class', 6)
            ->where('journals.Exercice', session()->get('ExerciceComptableId'))
            ->sum('MC');

    $SOLDECEX = $TotalCEXMD - $TotalCEXMC;

    // ON CALCUL LE TOTAUX DEBIT ET CREDIT POUR PRODUITS EXCEPTIONNEL
    $TotalPEXMD = DB::table('types')
            ->join('compte_principals', 'compte_principals.TypeCompte', '=', 'types.id')
            ->join('compte_subdivisionnaires', 'compte_subdivisionnaires.ComptePricipal', '=', 'compte_principals.id')
            ->join('journals', 'journals.Compte', '=', 'compte_subdivisionnaires.id')
            ->select(DB::raw('*'))
            ->where('compte_principals.Appartenance', 'exceptionnel')
            ->where('types.Class', 7)
            ->where('journals.Exercice', session()->get('ExerciceComptableId'))
            ->sum('MD');  

    $TotalPEXMC = DB::table('types')
            ->join('compte_principals', 'compte_principals.TypeCompte', '=', 'types.id')
            ->join('compte_subdivisionnaires', 'compte_subdivisionnaires.ComptePricipal', '=', 'compte_principals.id')
            ->join('journals', 'journals.Compte', '=', 'compte_subdivisionnaires.id')
            ->select(DB::raw('*'))
            ->where('compte_principals.Appartenance', 'exceptionnel')
            ->where('types.Class', 7)
            ->where('journals.Exercice', session()->get('ExerciceComptableId'))
            ->sum('MC');  

    $SOLDEPEX = $TotalPEXMD - $TotalPEXMC;
    $RESULTATEXCEPTIONNEL = $SOLDEPEX - $SOLDECEX;
    $RESULTAT = $RESULTATFINANCIER + $RESULTATEXPLOITATION + $RESULTATEXCEPTIONNEL;
        return view("Comptabilite.CompteResultat", compact('ComptesResultats','SOLDECF', 'SOLDEPF', 'RESULTAT','SOLDECE', 'SOLDEPE','SOLDECEX', 'SOLDEPEX', 'Exercices'));   
    }

       public function ResultatPdf(Request $request){
        $Exercices = ExerciceComptable::whereEtat(0)->get();
        $ComptesResultats = DB::table('types')
            ->join('compte_principals', 'compte_principals.TypeCompte', '=', 'types.id')
            ->leftJoin('compte_subdivisionnaires', 'compte_subdivisionnaires.ComptePricipal', '=', 'compte_principals.id')
            ->leftJoin('journals', 'journals.Compte', '=', 'compte_subdivisionnaires.id')
            ->select(DB::raw(' sum(journals.MD) as MD, sum(journals.MC) as MC, compte_subdivisionnaires.Intitule, compte_subdivisionnaires.NumeroCompte, Types.Class, compte_principals.Appartenance'))
            ->where('types.Type_Compte', 2)
            ->GroupBy('compte_subdivisionnaires.NumeroCompte')
            ->get();

// CALCUL RESULTAT FINANCIER
// ON CALCUL LE TOTAUX DEBIT ET CREDIT POUR CHARGE FINANCIER
    $TotalCFMD = DB::table('types')
            ->join('compte_principals', 'compte_principals.TypeCompte', '=', 'types.id')
            ->join('compte_subdivisionnaires', 'compte_subdivisionnaires.ComptePricipal', '=', 'compte_principals.id')
            ->join('journals', 'journals.Compte', '=', 'compte_subdivisionnaires.id')
            ->select(DB::raw('*'))
            ->where('compte_principals.Appartenance', 'financier')
            ->where('types.Class', 6)
            ->where('journals.Exercice', $request->Exercice)
            ->sum('MD');  

    $TotalCFMC = DB::table('types')
            ->join('compte_principals', 'compte_principals.TypeCompte', '=', 'types.id')
            ->join('compte_subdivisionnaires', 'compte_subdivisionnaires.ComptePricipal', '=', 'compte_principals.id')
            ->join('journals', 'journals.Compte', '=', 'compte_subdivisionnaires.id')
            ->select(DB::raw('*'))
            ->where('compte_principals.Appartenance', 'financier')
            ->where('types.Class', 6)
            ->where('journals.Exercice', $request->Exercice)
            ->sum('MC');

    $SOLDECF = $TotalCFMD - $TotalCFMC;

    // ON CALCUL LE TOTAUX DEBIT ET CREDIT POUR PRODUITS FINANCIER
    $TotalPFMD = DB::table('types')
            ->join('compte_principals', 'compte_principals.TypeCompte', '=', 'types.id')
            ->join('compte_subdivisionnaires', 'compte_subdivisionnaires.ComptePricipal', '=', 'compte_principals.id')
            ->join('journals', 'journals.Compte', '=', 'compte_subdivisionnaires.id')
            ->select(DB::raw('*'))
            ->where('compte_principals.Appartenance', 'financier')
            ->where('types.Class', 7)
            ->where('journals.Exercice', $request->Exercice)
            ->sum('MD');  

    $TotalPFMC = DB::table('types')
            ->join('compte_principals', 'compte_principals.TypeCompte', '=', 'types.id')
            ->join('compte_subdivisionnaires', 'compte_subdivisionnaires.ComptePricipal', '=', 'compte_principals.id')
            ->join('journals', 'journals.Compte', '=', 'compte_subdivisionnaires.id')
            ->select(DB::raw('*'))
            ->where('compte_principals.Appartenance', 'financier')
            ->where('types.Class', 7)
            ->where('journals.Exercice', $request->Exercice)
            ->sum('MC');  

    $SOLDEPF = $TotalPFMD - $TotalPFMC;
    $RESULTATFINANCIER = $SOLDEPF - $SOLDECF;

     
     // CALCUL RESULTAT D'EXPLOITATION
    // ON CALCUL LE TOTAUX DEBIT ET CREDIT POUR CHARGE EXPLOITATION
    $TotalCEMD = DB::table('types')
            ->join('compte_principals', 'compte_principals.TypeCompte', '=', 'types.id')
            ->join('compte_subdivisionnaires', 'compte_subdivisionnaires.ComptePricipal', '=', 'compte_principals.id')
            ->join('journals', 'journals.Compte', '=', 'compte_subdivisionnaires.id')
            ->select(DB::raw('*'))
            ->where('compte_principals.Appartenance', 'exploitation')
            ->where('types.Class', 6)
            ->where('journals.Exercice', $request->Exercice)
            ->sum('MD');  

    $TotalCEMC = DB::table('types')
            ->join('compte_principals', 'compte_principals.TypeCompte', '=', 'types.id')
            ->join('compte_subdivisionnaires', 'compte_subdivisionnaires.ComptePricipal', '=', 'compte_principals.id')
            ->join('journals', 'journals.Compte', '=', 'compte_subdivisionnaires.id')
            ->select(DB::raw('*'))
            ->where('compte_principals.Appartenance', 'exploitation')
            ->where('types.Class', 6)
            ->where('journals.Exercice', $request->Exercice)
            ->sum('MC');

    $SOLDECE = $TotalCEMD - $TotalCEMC;

    // ON CALCUL LE TOTAUX DEBIT ET CREDIT POUR PRODUITS EXPLOITATION
    $TotalPEMD = DB::table('types')
            ->join('compte_principals', 'compte_principals.TypeCompte', '=', 'types.id')
            ->join('compte_subdivisionnaires', 'compte_subdivisionnaires.ComptePricipal', '=', 'compte_principals.id')
            ->join('journals', 'journals.Compte', '=', 'compte_subdivisionnaires.id')
            ->select(DB::raw('*'))
            ->where('compte_principals.Appartenance', 'exploitation')
            ->where('types.Class', 7)
            ->where('journals.Exercice', $request->Exercice)
            ->sum('MD');  

    $TotalPEMC = DB::table('types')
            ->join('compte_principals', 'compte_principals.TypeCompte', '=', 'types.id')
            ->join('compte_subdivisionnaires', 'compte_subdivisionnaires.ComptePricipal', '=', 'compte_principals.id')
            ->join('journals', 'journals.Compte', '=', 'compte_subdivisionnaires.id')
            ->select(DB::raw('*'))
            ->where('compte_principals.Appartenance', 'exploitation')
            ->where('types.Class', 7)
            ->where('journals.Exercice', $request->Exercice)
            ->sum('MC');  

    $SOLDEPE = $TotalPEMD - $TotalPEMC;
    $RESULTATEXPLOITATION = $SOLDEPE - $SOLDECE;

    // CALCUL DE RESULTAT EXCEPTIONNEL
    // ON CALCUL LE TOTAUX DEBIT ET CREDIT POUR CHARGE EXCEPTIONNEL
    $TotalCEXMD = DB::table('types')
            ->join('compte_principals', 'compte_principals.TypeCompte', '=', 'types.id')
            ->join('compte_subdivisionnaires', 'compte_subdivisionnaires.ComptePricipal', '=', 'compte_principals.id')
            ->join('journals', 'journals.Compte', '=', 'compte_subdivisionnaires.id')
            ->select(DB::raw('*'))
            ->where('compte_principals.Appartenance', 'exceptionnel')
            ->where('types.Class', 6)
            ->where('journals.Exercice', $request->Exercice)
            ->sum('MD');  

    $TotalCEXMC = DB::table('types')
            ->join('compte_principals', 'compte_principals.TypeCompte', '=', 'types.id')
            ->join('compte_subdivisionnaires', 'compte_subdivisionnaires.ComptePricipal', '=', 'compte_principals.id')
            ->join('journals', 'journals.Compte', '=', 'compte_subdivisionnaires.id')
            ->select(DB::raw('*'))
            ->where('compte_principals.Appartenance', 'exceptionnel')
            ->where('types.Class', 6)
            ->where('journals.Exercice', session()->get('ExerciceComptableId'))
            ->sum('MC');

    $SOLDECEX = $TotalCEXMD - $TotalCEXMC;

    // ON CALCUL LE TOTAUX DEBIT ET CREDIT POUR PRODUITS EXCEPTIONNEL
    $TotalPEXMD = DB::table('types')
            ->join('compte_principals', 'compte_principals.TypeCompte', '=', 'types.id')
            ->join('compte_subdivisionnaires', 'compte_subdivisionnaires.ComptePricipal', '=', 'compte_principals.id')
            ->join('journals', 'journals.Compte', '=', 'compte_subdivisionnaires.id')
            ->select(DB::raw('*'))
            ->where('compte_principals.Appartenance', 'exceptionnel')
            ->where('types.Class', 7)
            ->where('journals.Exercice', $request->Exercice)
            ->sum('MD');  

    $TotalPEXMC = DB::table('types')
            ->join('compte_principals', 'compte_principals.TypeCompte', '=', 'types.id')
            ->join('compte_subdivisionnaires', 'compte_subdivisionnaires.ComptePricipal', '=', 'compte_principals.id')
            ->join('journals', 'journals.Compte', '=', 'compte_subdivisionnaires.id')
            ->select(DB::raw('*'))
            ->where('compte_principals.Appartenance', 'exceptionnel')
            ->where('types.Class', 7)
            ->where('journals.Exercice', $request->Exercice)
            ->sum('MC'); 

    $PERIODE = ExerciceComptable::findOrFail($request->Exercice);
    $SOLDEPEX = $TotalPEXMD - $TotalPEXMC;
    $RESULTATEXCEPTIONNEL = $SOLDEPEX - $SOLDECEX;
    $RESULTAT = $RESULTATFINANCIER + $RESULTATEXPLOITATION + $RESULTATEXCEPTIONNEL;
        $pdf = PDF::loadView('Comptabilite.ResultatPdf', compact('ComptesResultats','SOLDECF', 'SOLDEPF', 'RESULTAT','SOLDECE', 'SOLDEPE','SOLDECEX', 'SOLDEPEX', 'Exercices', 'PERIODE'))->setPaper('a3', 'Paysage');
            $fileName = 'Facture';
        return $pdf->stream($fileName . '.pdf');  
    }

    public function Bilan(){
        $TActif = 0;
        $TPassif = 0;
        $Exercices = ExerciceComptable::whereEtat(0)->get();
        $table1="<tr style='background-color:silver;text-align:center;font-weight:bolder'><th style='font-weight:bolder' colspan='2'>ACTIF</th></tr>";
        $table2="<tr style='background-color:silver;text-align:center;font-weight:bolder'><th style='font-weight:bolder' colspan='2'>PASSIF</th></tr>";

        // JE VAIS RECUPERER TOUS LES COMPTES PRINCIPALES DU PLAN COMPTABLE
         $Comptes = DB::table('types')
                ->join('compte_principals', 'types.id', '=', 'compte_principals.TypeCompte')
                ->select(DB::raw('compte_principals.id, compte_principals.NumeroCompte, compte_principals.Intitule, compte_principals.Categorie'))
                //->where('types.Etat',0)
                ->where('types.Type_Compte',1)
                //->where('compte_principals.Etat',0)
                ->get();

          //AVEC CETTE ITERATION, ON VA CHERCHER LE SOLDE REPORTE POUR L'EXERCICE ANTERIEUR ET LE SOLDE DANS LE JOURNAL POUR CE COMPTE POUR CETTE ANNEE
          foreach ($Comptes as $Compte) {

            //SOLDE DE REPPORT
              $MontantRD = Repportage::whereEtatAndCompteIdAndReportedInAndTypeMvt(0,$Compte->id,session()->get('ExerciceComptableId'),1)->sum('montant');
              $MontantRC = Repportage::whereEtatAndCompteIdAndReportedInAndTypeMvt(0,$Compte->id,session()->get('ExerciceComptableId'),2)->sum('montant');

              //SOLDE DU JOURNAL
              $MontantMD = DB::table('compte_principals')
            ->join('compte_subdivisionnaires', 'compte_subdivisionnaires.ComptePricipal', '=', 'compte_principals.id')
            ->Join('journals', 'journals.Compte', '=', 'compte_subdivisionnaires.id')
            ->select(DB::raw('*'))
            ->where('journals.Exercice', session()->get('ExerciceComptableId'))
            ->where('journals.Etat', 0)
            ->where('compte_principals.id', $Compte->id)
            ->GroupBy('compte_principals.id')->sum('journals.MD');


             $MontantMC = DB::table('compte_principals')
            ->join('compte_subdivisionnaires', 'compte_subdivisionnaires.ComptePricipal', '=', 'compte_principals.id')
            ->Join('journals', 'journals.Compte', '=', 'compte_subdivisionnaires.id')
            ->select(DB::raw('*'))
            ->where('journals.Exercice', session()->get('ExerciceComptableId'))
            ->where('journals.Etat', 0)
            ->where('compte_principals.id', $Compte->id)
            ->GroupBy('compte_principals.id')->sum('journals.MC');


           // ON INSCRIT LES LES SOLDE DANS LA PARTIE ACTIF DU BILAN
            if ($Compte->Categorie=="Actif") {

              $Diff=($MontantMD-$MontantMC)+($MontantRD-$MontantRC);
              
              if ($Diff<0) {
                $Diff*=-1;
              }

              $table1.="<tr style='background-color:white;'>
                <td>".$Compte->Intitule."</td>
                <td><button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this); return false;' value=".session()->get('ExerciceComptableId').'*'.$Compte->id.">".number_format($Diff,session()->get('ExerciceNbreDecimal'),session()->get('ExerciceSeparateurDecimal'),session()->get('ExerciceseparateurMilieu')).' '.session()->get('ExerciceDevise')."</td></button></tr>";

                $TActif += $Diff;
            }

            // ON INSCRIT LES LES SOLDE DANS LA PARTIE PASSIF DU BILAN
            else if($Compte->Categorie=="Passif"){
                $Diff=($MontantMD-$MontantMC)+($MontantRD-$MontantRC);
                if ($Diff<0) {
                $Diff*=-1;
              }

                $table2.="<tr style='background-color:white;'>
                <td>".$Compte->Intitule."</td>
                <td><button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this); return false;' value=".session()->get('ExerciceComptableId').'*'.$Compte->id.">".number_format($Diff,session()->get('ExerciceNbreDecimal'),session()->get('ExerciceSeparateurDecimal'),session()->get('ExerciceseparateurMilieu')).' '.session()->get('ExerciceDevise')."</td></button></tr>";

                $TPassif +=$Diff;
              }  
          }

         $Resultat = $TActif - $TPassif;

         if ($Resultat>0) {
           $TPassif+=$Resultat;
         }else{
            $TPassif+=$Resultat;
         }

         $table1.="<tr style='background-color:silver;text-align:center;font-weight:bolder'><th style='font-weight:bolder'>TOTAL ACTIF</th> <th style='font-weight:bolder'>".number_format($TActif,session()->get('ExerciceNbreDecimal'),session()->get('ExerciceSeparateurDecimal'),session()->get('ExerciceseparateurMilieu')).' '.session()->get('ExerciceDevise')."</th></tr>";

            $table2.="
            <tr style='background-color:white;font-weight:bolder'><th style='font-weight:bolder'>Excédent</th> <th style='font-weight:bolder'>".number_format($Resultat,session()->get('ExerciceNbreDecimal'),session()->get('ExerciceSeparateurDecimal'),session()->get('ExerciceseparateurMilieu')).' '.session()->get('ExerciceDevise')."</th></tr>

            <tr style='background-color:silver;text-align:center;font-weight:bolder'><th style='font-weight:bolder'>TOTAL PASSIF</th> <th style='font-weight:bolder'>".number_format($TPassif,session()->get('ExerciceNbreDecimal'),session()->get('ExerciceSeparateurDecimal'),session()->get('ExerciceseparateurMilieu')).' '.session()->get('ExerciceDevise')."</th></tr>";
            $tableListe = $table1.$table2; 
        return view("Comptabilite.Bilan", compact('Exercices', 'tableListe'));      
    }

    public function BilanPdf(Request $request)
    {   
        $TActif = 0;
        $TPassif = 0;
        $Exercices = ExerciceComptable::whereEtat(0)->get();
        $table1="<tr style='background-color:silver;text-align:center;font-weight:bolder'><th style='font-weight:bolder' colspan='2'>ACTIF</th></tr>";
        $table2="<tr style='background-color:silver;text-align:center;font-weight:bolder'><th style='font-weight:bolder' colspan='2'>PASSIF</th></tr>";
        $TActif=0;
        $TPassif=0;

        // JE VAIS RECUPERER TOUS LES COMPTES PRINCIPALES DU BILAN
         $Comptes = DB::table('types')
                ->join('compte_principals', 'types.id', '=', 'compte_principals.TypeCompte')
                ->select(DB::raw('compte_principals.id, compte_principals.NumeroCompte, compte_principals.Intitule, compte_principals.Categorie'))
                //->where('types.Etat',0)
                ->where('types.Type_Compte',1)
                //->where('compte_principals.Etat',0)
                ->get();

          //AVEC CETTE ITERATION, ON VA CHERCHER LE SOLDE REPORTE POUR L'EXERCICE ANTERIEUR ET LE SOLDE DANS LE JOURNAL POUR CE COMPTE POUR CETTE ANNEE
          foreach ($Comptes as $Compte) {

            //SOLDE DE REPPORT
               $MontantRD = Repportage::whereEtatAndCompteIdAndReportedInAndTypeMvt(0,$Compte->id,$request->Exercice,1)->sum('montant');
              $MontantRC = Repportage::whereEtatAndCompteIdAndReportedInAndTypeMvt(0,$Compte->id,$request->Exercice,2)->sum('montant');

              //SOLDE DU JOURNAL
              $MontantMD = DB::table('compte_principals')
            ->join('compte_subdivisionnaires', 'compte_subdivisionnaires.ComptePricipal', '=', 'compte_principals.id')
            ->Join('journals', 'journals.Compte', '=', 'compte_subdivisionnaires.id')
            ->select(DB::raw('*'))
            ->where('journals.Exercice', $request->Exercice)
            ->where('journals.Etat', 0)
            ->where('compte_principals.id', $Compte->id)
            ->GroupBy('compte_principals.id')->sum('journals.MD');


             $MontantMC = DB::table('compte_principals')
            ->join('compte_subdivisionnaires', 'compte_subdivisionnaires.ComptePricipal', '=', 'compte_principals.id')
            ->Join('journals', 'journals.Compte', '=', 'compte_subdivisionnaires.id')
            ->select(DB::raw('*'))
            ->where('journals.Exercice', $request->Exercice)
            ->where('journals.Etat', 0)
            ->where('compte_principals.id', $Compte->id)
            ->GroupBy('compte_principals.id')->sum('journals.MC');


           // ON INSCRIT LES LES SOLDE DANS LA PARTIE ACTIF DU BILAN
            if ($Compte->Categorie=="Actif") {
              
              $Diff=($MontantMD-$MontantMC)+($MontantRD-$MontantRC);
              if ($Diff<0) {
                $Diff*=-1;
              }
              $table1.="<tr style='background-color:white;'>
                <td>".$Compte->Intitule."</td>
                <td><button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this); return false;' value=".session()->get('ExerciceComptableId').'*'.$Compte->id.">".number_format($Diff,session()->get('ExerciceNbreDecimal'),session()->get('ExerciceSeparateurDecimal'),session()->get('ExerciceseparateurMilieu')).' '.session()->get('ExerciceDevise')."</td></button></tr>";

                $TActif += $Diff;
            }

            // ON INSCRIT LES LES SOLDE DANS LA PARTIE PASSIF DU BILAN
            else if($Compte->Categorie=="Passif"){
                $Diff=($MontantMD-$MontantMC)+($MontantRD-$MontantRC);
                if ($Diff<0) {
                $Diff*=-1;
              }
                $table2.="<tr style='background-color:white;'>
                <td>".$Compte->Intitule."</td>
                <td><button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this); return false;' value=".session()->get('ExerciceComptableId').'*'.$Compte->id.">".number_format($Diff,session()->get('ExerciceNbreDecimal'),session()->get('ExerciceSeparateurDecimal'),session()->get('ExerciceseparateurMilieu')).' '.session()->get('ExerciceDevise')."</td></button></tr>";

                $TPassif +=$Diff;
              }  
          }

         $Resultat = $TActif - $TPassif;

         if ($Resultat>0) {
           $TPassif+=$Resultat;
         }else{
            $TPassif+=$Resultat;
         }

         $table1.="<tr style='background-color:silver;text-align:center;font-weight:bolder'><th style='font-weight:bolder'>TOTAL ACTIF</th> <th style='font-weight:bolder'>".number_format($TActif,session()->get('ExerciceNbreDecimal'),session()->get('ExerciceSeparateurDecimal'),session()->get('ExerciceseparateurMilieu')).' '.session()->get('ExerciceDevise')."</th></tr>";

            $table2.="
            <tr style='background-color:white;font-weight:bolder'><th style='font-weight:bolder'>Excédent</th> <th style='font-weight:bolder'>".number_format($Resultat,session()->get('ExerciceNbreDecimal'),session()->get('ExerciceSeparateurDecimal'),session()->get('ExerciceseparateurMilieu')).' '.session()->get('ExerciceDevise')."</th></tr>

            <tr style='background-color:silver;text-align:center;font-weight:bolder'><th style='font-weight:bolder'>TOTAL PASSIF</th> <th style='font-weight:bolder'>".number_format($TPassif,session()->get('ExerciceNbreDecimal'),session()->get('ExerciceSeparateurDecimal'),session()->get('ExerciceseparateurMilieu')).' '.session()->get('ExerciceDevise')."</th></tr>";
            $tableListe = $table1.$table2; 
            $ExerciceComptab = ExerciceComptable::findOrFail($request->Exercice);
        //return view("Comptabilite.Bilan", compact('Exercices', 'tableListe'));  
        $pdf = PDF::loadView('Comptabilite.BilanPdf', compact('tableListe', 'ExerciceComptab'))->setPaper('a3', 'Paysage');
            $fileName = 'Facture';
        return $pdf->stream($fileName . '.pdf');

    }  

    public function details_bilan($periode, $compte){
          $Exe = ExerciceComptable::findOrFail($periode);
           //Requetes qui recupere Tous les mouvemnts du comptes au cours de l'annee precise.
             $Journals =DB::table('journals')
                  ->join('compte_subdivisionnaires', 'journals.Compte', '=', 'compte_subdivisionnaires.id')
                  ->join('compte_principals', 'compte_principals.id', '=', 'compte_subdivisionnaires.ComptePricipal')
                  ->select(DB::raw('journals.id, journals.DateOperation, journals.Ordre, journals.MD, journals.MC,compte_subdivisionnaires.NumeroCompte,compte_subdivisionnaires.Intitule,journals.TypeMvt,journals.Piece, journals.Libelle'))
                  ->where('compte_principals.id', $compte)
                  ->where('journals.Exercice',$periode)
                  ->where('journals.Etat', 0)->get();

             $Report = DB::table('repportages')
                  ->join('exercice_comptables', 'exercice_comptables.id', '=', 'repportages.reported_in')
                  ->join('compte_principals', 'compte_principals.id', '=', 'repportages.compte_id')
                  ->select(DB::raw('repportages.exercice_id, repportages.montant, repportages.reported_in, exercice_comptables.Debut, exercice_comptables.Fin, repportages.type_mvt'))
                  ->where('compte_principals.id', $compte)
                  ->where('repportages.reported_in',$periode)
                  ->where('repportages.Etat', 0)->first();   
            
            //Requetes qui recupere la somme de debit des  mouvemnts du compte au cours de l'annee precise.
              $MD =DB::table('journals')
                  ->join('compte_subdivisionnaires', 'compte_subdivisionnaires.id', '=', 'journals.Compte')
                  ->join('compte_principals', 'compte_principals.id', '=', 'compte_subdivisionnaires.ComptePricipal')
                  ->select(DB::raw('*')) 
                  ->where('journals.Etat', 0)
                 ->where('compte_principals.id', $compte)
                  ->where('journals.Exercice',$periode)
                  ->sum('MD');
            
            //Requetes qui recupere la somme de credit des  mouvemnts du compte au cours de l'annee precise.
              $MC = DB::table('journals')
                  ->join('compte_subdivisionnaires', 'compte_subdivisionnaires.id', '=', 'journals.Compte')
                  ->join('compte_principals', 'compte_principals.id', '=', 'compte_subdivisionnaires.ComptePricipal')
                  ->select(DB::raw('*')) 
                  ->where('journals.Etat', 0)
                 ->where('compte_principals.id', $compte)
                  ->where('journals.Exercice',$periode)
                  ->sum('MC');

              $table ="";

                foreach ($Journals as $Journal) {
                  if ($Journal->TypeMvt ==1) { 
                    $table.="
                      <tr>
                        <td>".$Journal->DateOperation."</td>
                        <td>".$Journal->Ordre."</td>
                        <td>".$Journal->NumeroCompte."</td>
                        <td></td>
                        <td>".$Journal->Intitule."</td>
                        <td>".$Journal->Libelle."</td>
                        <td>". number_format($Journal->MD,$Exe->NbreDecimal,$Exe->separateurDecimal,$Exe->separateurMilieu).' '.$Exe->Devise."</td>
                        <td>".number_format($Journal->MC,$Exe->NbreDecimal,$Exe->separateurDecimal,$Exe->separateurMilieu).' '.$Exe->Devise."</td>
                      </tr>";
                  }
                  elseif ($Journal->TypeMvt ==2) {
                    $table.="
                      <tr>
                        <td>".$Journal->DateOperation."</td>
                        <td>".$Journal->id."</td>
                        <td></td>
                        <td>".$Journal->NumeroCompte."</td>
                        <td>".$Journal->Intitule."</td>
                        <td>".$Journal->Libelle."</td>
                        <td>".number_format($Journal->MD,$Exe->NbreDecimal,$Exe->separateurDecimal,$Exe->separateurMilieu).' '.$Exe->Devise."</td>
                        <td>".number_format($Journal->MC,$Exe->NbreDecimal,$Exe->separateurDecimal,$Exe->separateurMilieu).' '.$Exe->Devise."</td>
                      </tr>";
                  }  
        }
        $tableListe = $table;
        if (is_null($Report)) {
           $SOLDE = $MD-$MC+0;
           $Reports = 0;
           $type_mvt = 1;
        }else{
          $SOLDE = $MD-$MC+$Report->montant;
          $Reports = $Report->montant;
          $type_mvt = $Report->type_mvt;
        }
        
        $MD = number_format($MD,$Exe->NbreDecimal,$Exe->separateurDecimal,$Exe->separateurMilieu).' '.$Exe->Devise;
        $MC = number_format($MC,$Exe->NbreDecimal,$Exe->separateurDecimal,$Exe->separateurMilieu).' '.$Exe->Devise;
        
        $SOLDE = number_format($SOLDE,$Exe->NbreDecimal,$Exe->separateurDecimal,$Exe->separateurMilieu).' '.$Exe->Devise;
        $Reports = number_format($Reports,$Exe->NbreDecimal,$Exe->separateurDecimal,$Exe->separateurMilieu).' '.$Exe->Devise;       
       return view('Comptabilite.detail_bilan', compact('Journals', 'MC', 'MD', 'SOLDE', 'tableListe', 'Reports', 'type_mvt'));
    }

    public function update_result_configuration(Request $request){

      $product_nbre = Type::whereClassAndEtat($request->produit,0)->count('id');
      $charge_nbre = Type::whereClassAndEtat($request->charge,0)->count('id');
      
      if ($product_nbre!=0 AND $charge_nbre!=0) {
            $product = Type::whereClassAndEtat($request->produit,0)->first();
            $charge = Type::whereClassAndEtat($request->charge,0)->first();
            $product->update([
              'charge_product'=>2
            ]);

            $charge->update([
              'charge_product'=>1
            ]);

      }else{
        session()->flash('messageDelete', 'Certains parametres manquent pour le compte de Résultat');
      }
      return redirect(route('configuration')); 
    }
}       

