<?php

namespace App\Http\Controllers;
use\App\Http\Requests\FormRequestCompteJournal;
use Illuminate\Http\Request;
use App\Models\CompteJournal;
use App\Models\CodeJournaux;
use App\Models\ComptePrincipal;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
class CompteJournalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   $ComptePrincipal = ComptePrincipal::whereEtat(0)->get();
        $CodeJournaux = CodeJournaux::whereEtat(0)->get();
        $CompteJournals =DB::table('compte_journals')
                        ->join('compte_principals', 'compte_principals.id', '=', 'compte_journals.compte') 
                        ->join('code_journauxes', 'code_journauxes.id', '=', 'compte_journals.Journal')
                        ->select(DB::raw('code_journauxes.Journal,compte_principals.Intitule,compte_journals.id'))
                        ->where('compte_principals.Etat', 0)
                        ->where('code_journauxes.Etat', 0)
                        ->get();
        $table='';                
        foreach($CompteJournals as $CompJourn)
        {
            $table.="
            <tr>
            <td>".$CompJourn->Journal."</td>
            <td>".$CompJourn->Intitule."</td>
            <td>
               <a href='".route('CompteJournal.edit', $CompJourn->id)."'><i class='fas fa-edit'></i></a>
                         <form action='".route('CompteJournal.destroy', $CompJourn->id)."' method='POST' style='display: inline-block;' onsubmit='return confirm('Etez -vous sur de cette Operation ?')'>
                    ".csrf_field()."
                    ".method_field('DELETE')."
                    
                    <button onclick='return confirm('Etez -vous sur de cette Operation ?') ><i class='fas fa-trash'></i>
                    </button>
                </form>
            </td>
            </tr>";
        }
        $tableListe = $table;
        return view('Comptabilite/CompteJournal.index', compact('tableListe','CodeJournaux', 'ComptePrincipal'));
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
    public function store(FormRequestCompteJournal $request)
    {  
       if (CompteJournal::UniqueInsert($request->Compte,$request->Journal)==true) {
            CompteJournal::create([
            'Compte'=>$request->Compte,
            'Journal'=>$request->Journal
        ]);
        } 
        return redirect(route('CompteJournal.index'));
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
        $CompteJournal = CompteJournal::findOrFail($id);
        $CodeJournal = CodeJournaux::find($CompteJournal->Journal);
        $Compte = ComptePrincipal::findOrFail($CompteJournal->Compte);
        $CodeJournaux = CodeJournaux::whereEtat(0)->get();
        $Comptes = ComptePrincipal::whereEtat(0)->get();

        return view('Comptabilite/CompteJournal.edit', compact('CodeJournal', 'Compte', 'CodeJournaux', 'Comptes', 'CompteJournal'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FormRequestCompteJournal $request, $id)
    {   
      if (CompteJournal::UniqueUpdate($request->Compte,$request->Journal,$id)==true){
          $CompteJournal = CompteJournal::findOrFail($id);
        $CompteJournal->update([
            'Compte'=>$request->Compte,
            'Journal'=>$request->Journal
        ]);
      }
        return redirect(route('CompteJournal.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $CompteJournal = CompteJournal::findOrFail($id);
       $CompteJournal->destroy($id); 
        return redirect(route('CompteJournal.index'));
    }

    public function AddACount($id){
        $ComptePrincipal = ComptePrincipal::whereEtat(0)->get();
        return view('CompteJournal.create', compact('ComptePrincipal','id'));
    }
}
