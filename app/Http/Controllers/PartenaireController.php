<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Partenaire;
use App\Models\Affilier;
use App\Models\Origine;
use App\Models\AyantDroit;
use App\Models\AffilierPartenaire;
use App\Models\Consomation;
use App\Models\CompteSubdivisionnaire;
use PDF;
use Illuminate\Support\Facades\DB;

class PartenaireController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   

        $Partenaires = Partenaire::whereEtat(0)->get();
        $CompteSubdivisionnaires = CompteSubdivisionnaire::whereEtat(0)->get();
        return view('Partenaires.index', compact('Partenaires', 'CompteSubdivisionnaires'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {  
        $Partenaire =new Partenaire;
        return view('Partenaires.create', compact('Partenaire'));
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
          'Code' => 'required', 
          'Nom' => 'required',
          'Type' => 'required'
          
          ]);
        $CurrentYear = date('Y');
        //Verification de L'unicite du code

        $NbreCode = Partenaire::whereCode($request->Code)->count();
    if ($NbreCode == 0) 
    {  
        Partenaire::create([
            'Code' => $request->Code,
            'Partenaire' => $request->Nom,
            'Type' => $request->Type,
            'MotdePasse' => sha1(12345),
            'Annee' => $CurrentYear
        ]);

         session()->flash('message', 'Partenaire Crée avec success!');
    }
    else
    {
    session()->flash('messageDelete', 'Ce Code est deja Attribué');
    }
        return redirect(route('Partenaires.index')); 
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
        $Partenaire = Partenaire::findOrFail($id);
        return view('Partenaires.edit', compact('Partenaire'));
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
          'Code' => 'required', 
          'Nom' => 'required',
          'Type' => 'required'
          ]);
        //Verification de L'unicite du code
        $NbreCode = Partenaire::whereCode($request->Code)->where('id', '!=', $id)->count();
    if ($NbreCode == 0) 
    {  
        $Partenaire = Partenaire::findOrFail($id);
        $Partenaire->update([
            'Code' => $request->Code,
            'Partenaire' => $request->Nom,
            'Type' => $request->Type
        ]);

         session()->flash('message', 'Partenaire Modifié avec success!');
    }
    else
    {
    session()->flash('messageDelete', 'Ce Code est deja Attribué');
    }
        return redirect(route('Partenaires.index')); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $Partenaire = Partenaire::findOrFail($id);
        $Partenaire->update([
            'Etat' => 1
        ]);

         session()->flash('messageDelete', 'Partenaire Supprimé avec success!');
        return redirect(route('Partenaires.index')); 
    }

     public function Login()
     {
      return view('Login'); 
     }

     public function CorbPaterner()
     {
       $Partenaires = Partenaire::whereEtat(1)->get();
        return view('Partenaires.CorbPaterner', compact('Partenaires'));
     }

     public function RestaurePaterner($id)
     {
        $Partenaire = Partenaire::findOrFail($id);
        $Partenaire->update([
            'Etat' => 0
        ]);

        return redirect(route('CorbPaterner'));
     }

     public function ListeAffilier($Partenaire)
     {   set_time_limit(300);
        $Consomation = Consomation::findOrFail(1);
         $NbreAffP = AffilierPartenaire::whereEtatAndPartenaire(0,$Partenaire)->count();
         $Part = Partenaire::findOrFail($Partenaire);
         $AyaDrA="";
          $table = " ";
            if ($NbreAffP>0) 
            {    
        $AffilierPartenaires = DB::table('affilier_partenaires')
                     ->select(DB::raw('*'))
                    ->whereEtatAndPartenaire(0,$Partenaire)
                    ->groupBy('Affilier')
                    ->get();


         foreach($AffilierPartenaires as $AffilierPartenaire){

            $id_Affilier=$AffilierPartenaire->Affilier;
            $Aff=Affilier::where('id',$id_Affilier)->first();
            $Origine = Origine::findOrFail($Aff->Origine);
            $Partenaire = Partenaire::findOrFail($AffilierPartenaire->Partenaire);
            $Ticket = 100-$Aff->SoinsAmbilatoire;

            $AyantDroits = AyantDroit::whereEtatAndAffilier(0,$id_Affilier)->get();
            foreach ($AyantDroits as $AyantDroit) 
            {  
               if ($AyantDroit->Lien != 'Lui meme') 
               {
                  $AyaDrA.="
                 <ul><li>".$AyantDroit->Nom.' '.$AyantDroit->Prenom."</li></ul>";
               }   
            }
            $TAyaDrA=$AyaDrA;
            $AyaDrA="";
                   $table.="
                    <tr class='odd gradeX'>
                         <td>".$Aff->Code."</td>
                        <td>".$Aff->Nom.' '.$Aff->Prenom."</td>
                        <td>".$TAyaDrA."</td>
                        <td>".$Origine->Origine."</td>
                        <td>".$Aff->SoinsAmbilatoire.'%'."</td>
                        <td>".$Aff->PlafondChambre.'%  avec  '.$Aff->PCNuit.'FBU /Nuitée'."</td>
                        <td>".$Aff->UniteMaternite.' FBU '."</td>
                        <td>".$Aff->Pharmacie."</td>
                        <td>".$Aff->dents."</td>
                        <td>".$Aff->Lunette."</td>
        </tr>";                                        
        }        
     }
        $tableListe=$table;
        $pdf = PDF::loadView('Partenaires.ListeAffilier', compact('tableListe', 'Part', 'Consomation'))->setPaper('a3', 'Paysage');
         $fileName = 'ListeAffilier';
         return $pdf->stream($fileName . '.pdf');
  }

  //AJOUT UN COMPTE DE LA COMPTABILITE AU PARTENAIRE
  public function AttachAccount(Request $request){

       $Partenaire = Partenaire::findOrFail($request->partenaire);
        $Partenaire->update([
            'account' => $request->compte
        ]);

        session()->flash('message', 'Un compte comptable a été ajouté au partenaire'.$Partenaire->Partenaire);
        return redirect(route('Partenaires.index'));
  }       
}
