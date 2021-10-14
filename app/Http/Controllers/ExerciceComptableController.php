<?php

namespace App\Http\Controllers;
use\App\Http\Requests\ExerciceComptableRequest;
use Illuminate\Http\Request;
use App\Http\Requests;
use\App\Models\ExerciceComptable;
use\App\Models\ComptePrincipal;
use\App\Models\Repportage;
use App\Interfaces\IRepportage as IRepportage;
use\App\Models\CompteRepport;
use Illuminate\Support\Facades\DB;


class ExerciceComptableController extends Controller
{   

    public function __construct(IRepportage $Repportage){
        $this->Repportage = $Repportage;
        $this->middleware('guest');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $Ex = New ExerciceComptable;
        $Exercices = ExerciceComptable::whereEtat(0)->get();
        return view('Comptabilite/ExerciceComptable.index', compact('Exercices', 'Ex'));
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
    public function store(ExerciceComptableRequest $request)
    {  
       $NbreEx = ExerciceComptable::whereEtatAndCloturer(0,0)->count('id'); 
       if (ExerciceComptable::UniqueExercice($request->Debut,$request->Fin) == true) {

          if (ExerciceComptable::VerifyseparateurDecimalseparateurMilieu($request->SeparateurDecimal,$request->SeparateurMilieu)== true) {

            if (ExerciceComptable::VerifyNbreDecimal($request->NbreDecimal)== true ) {

                if ($NbreEx==0) {

                  ExerciceComptable::create([
                  'Debut'=>$request->Debut,
                  'Fin'=>$request->Fin,
                  'NbreDecimal'=>$request->NbreDecimal,
                  'separateurDecimal'=>$request->SeparateurDecimal,
                  'separateurMilieu'=>$request->SeparateurMilieu,
                  'Devise'=>$request->Devise,
                   ]);
                  $LastExercice = ExerciceComptable::whereEtat(0)->max('id');

                  //ON RECUPERE TOUS LES DONNEES A REPORTER
                  $Repportage = Repportage::whereReportedIn(0)->get();
                  //ON DEBUTER LE REPORTAGE DES DONNEES
                  foreach ($Repportage as $Repport) {
                      $Repport->update([
                        'reported_in'=>$LastExercice
                      ]);
                  }
                }else{
                  session()->flash('messageDelete', 'Un autre Exercice est ouvert, Veuillez le Cloturer!');
                }
            }else{
                session()->flash('messageDelete', ' Le nombre de decimal doit etre compris entre 0 a 9');
            }
        }else{
           session()->flash('messageDelete', ' Le separateur Milieu et decimal doivent prendre la valeur , ou .'); 
        } 
       
     }else{
          session()->flash('messageDelete', 'Cet Exercice Comptable Existe!');
     }  
    return view('welcome');
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
        $ExerciceComptable = ExerciceComptable::findOrFail($id);
        return view('Comptabilite/ExerciceComptable.edit', compact('ExerciceComptable'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ExerciceComptableRequest $request, $id)
    {   
        $ExerciceComptable = ExerciceComptable::findOrFail($id);
        $ExerciceComptable->update([
            'Debut'=>$request->Debut,
            'Fin'=>$request->Fin,
            'NbreDecimal'=>$request->NbreDecimal,
            'separateurDecimal'=>$request->SeparateurDecimal,
            'separateurMilieu'=>$request->separateurMilieu,
            'Devise'=>$request->Devise,
        ]);
        return redirect(route('ExerciceComptable.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $ExerciceComptable = ExerciceComptable::findOrFail($id);
         $ExerciceComptable->update([
            'Etat'=>1
         ]);

         return redirect(route('ExerciceComptable.index'));
    }

    //Cloturer et Reouverture L'exercice Comptable 
    public function CloseExercice(Request $request){
        $ExerciceComptable = ExerciceComptable::findOrFail($request->Exerciceid);
        $ComptePrincipals = DB::table('types')
                           ->join('compte_principals', 'compte_principals.TypeCompte', '=' , 'types.id')
                           ->select(DB::raw('compte_principals.id'))
                           ->where('types.Type_Compte', 1)
                           ->where('compte_principals.resultat_exercice', 0)
                           ->get();

            // CLOTURE DES COMPTES DU BILAN
            foreach($ComptePrincipals as $ComptePrincipal){
                $SOLDE = $this->Repportage->cloturergrandlivre($ComptePrincipal->id);
                if ($SOLDE<0) {
                    $SOLDE*=-1;
                    Repportage::create([
                    'exercice_id'=>session()->get('ExerciceComptableId'),
                    'compte_id'=>$ComptePrincipal->id,
                    'montant'=>$SOLDE,
                    'type_mvt'=>2
                   ]);
                }else{
                   Repportage::create([
                    'exercice_id'=>session()->get('ExerciceComptableId'),
                    'compte_id'=>$ComptePrincipal->id,
                    'montant'=>$SOLDE,
                    'type_mvt'=>1
                   ]);
                }
            }

            //CLOTURE DES COMPTES DE RESULTAT

            $SOLDE = $this->Repportage->cloturerchargeetproduit($request);
            $account = $this->Repportage->resultatexercicerepportedaccount($SOLDE);
            if ($SOLDE<0) {
                    $SOLDE*=-1;
                    Repportage::create([
                    'exercice_id'=>session()->get('ExerciceComptableId'),
                    'compte_id'=>$account->id,
                    'comptesubd_id'=>$account->subdId,
                    'montant'=>$SOLDE,
                    'type_mvt'=>2
                   ]);
                }else{
                   Repportage::create([
                    'exercice_id'=>session()->get('ExerciceComptableId'),
                    'compte_id'=>$account->id,
                    'comptesubd_id'=>$account->subdId,
                    'montant'=>$SOLDE,
                    'type_mvt'=>1
                   ]);
                }

                $ExerciceComptable->update([
                   'Cloturer'=>1,
                   'Editorial_mode'=>1
                ]);
        return redirect(route('ExerciceComptable.index'));
    }


    public function ReouvrirExercice($Exerciceid){
          $NbreEx = ExerciceComptable::whereEtatAndCloturer(0,0)->count('id');  
          $ExerciceComptable = ExerciceComptable::findOrFail($Exerciceid);
         //On verifie s'il y a un autre exercice ouvert
           if ($NbreEx==0) {
                $ExerciceComptable->update([
               'Cloturer'=>0
             ]);

             //Creation de la nouvelle session contenant l'Exercice reouverte
            $Exercice = ExerciceComptable::whereEtatAndCloturer(0,0)->first(); 
            session()->put('ExerciceComptableId', $Exercice->id);
            session()->put('ExerciceComptableDebut', $Exercice->Debut);
            session()->put('ExerciceComptableFin', $Exercice->Fin);
               
            }else{
            session()->flash('messageDelete', 'Un autre Exercice est ouvert, Veuillez le Cloturer!');
            }   
         return redirect(route('ExerciceComptable.index'));
    }
}
