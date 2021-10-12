<?php

namespace App\Http\Controllers;
use App\Http\Requests\FormCodeJournauxRequest;
use Illuminate\Http\Request;
use App\Models\CodeJournaux;
use App\Models\CompteJournal;
use App\Http\Requests;
use DB;
class CodeJournauxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        $CodeJournaux = CodeJournaux::whereEtat(0)->get();
        return view('Comptabilite/CodeJournaux.index', compact('CodeJournaux'));
        
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
    public function store(FormCodeJournauxRequest $request)
    {  
        if (CodeJournaux::uniqueCode($request->Code)==true) {
            CodeJournaux::create([
            'Code'=>$request->Code,
            'Journal'=>$request->Journal
        ]);
      }
        return redirect(route('CodeJournaux.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Journal = $id;
        $ComptePrincipal = DB::table('compte_principals')
                          ->Leftjoin('compte_journals', 'compte_principals.id', '=', 'compte_journals.Compte')
                          ->select(DB::raw('compte_journals.Compte,compte_principals.id,compte_principals.NumeroCompte,compte_principals.Intitule,compte_journals.Journal,compte_journals.Etat'))
                          //->where('compte_journals.Journal', $id)
                          ->get();
                         // dump($ComptePrincipal);
       return view('Comptabilite/CodeJournaux.show', compact('ComptePrincipal', 'Journal'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $CodeJournal = CodeJournaux::findOrFail($id);
        return view('Comptabilite/CodeJournaux.edit', compact('CodeJournal'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FormCodeJournauxRequest $request, $id)
    {   
        $CodeJournaux = CodeJournaux::findOrFail($id);
        if (CodeJournaux::uniqueCodeUpdate($request->Code, $id)==true) {
            $CodeJournaux->update([
            'Code'=>$request->Code,
            'Journal'=>$request->Journal
        ]);
      }
        return redirect(route('CodeJournaux.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $CodeJournaux = CodeJournaux::findOrFail($id);
        
            $CodeJournaux->update([
            'Etat'=>1
        ]);
        return redirect(route('CodeJournaux.index'));
    }

    public function SettedAccountAsJournal($id){
        $Journal = $id;
        $ComptePrincipal = DB::table('compte_principals')
                          ->join('compte_journals', 'compte_principals.id', '=', 'compte_journals.Compte')
                          ->select(DB::raw('compte_journals.Compte,compte_principals.id,compte_principals.NumeroCompte,compte_principals.Intitule,compte_journals.Journal'))
                          ->where('compte_journals.Journal',$id)
                          ->where('compte_journals.etat',0)
                          ->get();

        $Nbre = DB::table('compte_principals')
                          ->join('compte_journals', 'compte_principals.id', '=', 'compte_journals.Compte')
                          ->select(DB::raw(''))
                          ->where('compte_journals.Journal',$id)
                          ->where('compte_journals.etat',0)
                          ->count('compte_principals.id');
                                            
        return view('Comptabilite/CodeJournaux.show1', compact('ComptePrincipal', 'Journal', 'Nbre'));
    }

    public function attachedJournal(Request $request){

        $comptes = $request['compte'];
        $i=0;
        
        $NbreJ = CompteJournal::whereJournal($request->Journal)->count('id');
        $ComptesJ = CompteJournal::whereJournal($request->Journal)->get();
     
     if ($request['compte']!=0) {
        for ($i=0; $i <count($request['compte']) ; $i++) { 
            $compte = (int)$comptes[$i];
         
         if($NbreJ>0){
             foreach ($ComptesJ as $CompteJ) {
                $Nbre = CompteJournal::whereJournalAndCompte($request->Journal,$compte)->count('id');
                if($Nbre>0){
                    $CompteToUpdate = CompteJournal::whereJournalAndCompte($request->Journal,$compte)->first();
                    $CompteToUpdate->update([
                    'etat'=>0
                    ]);
                }else{
                    CompteJournal::create([
                        'Compte'=>$compte,
                        'Journal'=>$request->Journal
                    ]);
                }
            } 
         }else{
            CompteJournal::create([
                        'Compte'=>$compte,
                        'Journal'=>$request->Journal
                    ]);
         }  
        } 
      }else{
        session()->flash('messageDelete', 'Aucun compte n\'a été attaché au journal');
      }
        return redirect(route('CodeJournaux.index'));   
    }

    public function dettacheJournal(Request $request){
          
        $comptes = $request['compte'];
        $i=0;
        if ($request['compte']!=0) {
        for ($i=0; $i <count($request['compte']) ; $i++) { 
            $compte = (int)$comptes[$i];
            $CompteJ = CompteJournal::whereJournalAndCompte($request->Journal,$compte)->first();
            $CompteJ->destroy($CompteJ->id);
        } 
        }else{
            session()->flash('messageDelete', 'Aucun compte n\'a été dettaché du journal');
        }
        return redirect(route('CodeJournaux.index'));   
    }
}
