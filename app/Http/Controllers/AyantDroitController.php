<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AyantsDroitsRequestForm;
use App\Http\Requests;
use App\Models\AyantDroit;
use App\Models\Affilier;
use App\Interfaces\IAffilie as IAffilie;
use App\Interfaces\IAyantDroit as IAyantDroit;
use Illuminate\Support\Facades\DB;
use App\Models\ExcelImport;
use App\Interfaces\IExcelImport as IExcelImport;
class AyantDroitController extends Controller
{

     public function __construct(IAffilie $Affilier,IAyantDroit $AyantDroit, IExcelImport $ExcelImport){
        $this->Affilier = $Affilier;
        $this->AyantDroit = $AyantDroit;
        $this->ExcelImport = $ExcelImport;
        $this->middleware('guest');
      }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {    set_time_limit(300); // Extends to 5 minutes.
         $AyantDroits= $this->AyantDroit->fetchAll();
        return view('AyantsDroit.index', compact('AyantDroits'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        set_time_limit(300); // Extends to 5 minutes.
        $AyantDroit = new AyantDroit;
        $Affilier = new Affilier;
        //Remplir le combobox Affilier
        $Affiliers = $this->Affilier->fetchtAll();
        return view('AyantsDroit.create', compact('Affiliers', 'AyantDroit', 'Affilier'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AyantsDroitsRequestForm $request)
    {
        
        $this->AyantDroit->saveData($request, null);
        session()->flash('message', 'Ayant Droit Crée avec success!');
        return back();
        //return redirect(route('AyantsDroit.index')); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {  
       set_time_limit(300); // Extends to 5 minutes.
       $AyantDroit = $this->AyantDroit->showData($id);
       $Affilier = $this->Affilier->showData($AyantDroit->Affilier);
       //$Affiliers = Affilier::whereEtat(0)->get();
       $AyantsDroit = $this->AyantDroit->selectayantdroitbyaffilier($AyantDroit->Affilier);
       return view('AyantsDroit.edit', compact('AyantDroit', 'AyantsDroit', 'Affilier'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AyantsDroitsRequestForm $request, $id)
    {
      
        $this->AyantDroit->saveData($request, $id);  
        session()->flash('message', 'Ayant Droit Modifié avec success!');
        //return redirect(route('AyantsDroit.index')); 
        return  back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $AyantDroit = $this->AyantDroit->showData($id);
        $AyantDroit->update([
            'Etat' => 1
        ]);
        session()->flash('messageDelete', 'Suppression Faite avec success!');
        //return redirect(route('AyantsDroit.index')); 
        return back();
    }

    public function CorbAyantD()
    {
       $table="";
        $NbreAyantDroit=AyantDroit::where('Etat',1)->count();

        if ($NbreAyantDroit > 0) {

         $AyantDroits=AyantDroit::where('Etat',1)->get();
         foreach($AyantDroits as $AyantDroit){

            $id_Affilier=$AyantDroit->Affilier;
            $Affilier=Affilier::where('id',$id_Affilier)->first();

            $table.="
                    <tr class='odd gradeX'>
                        <td>".$AyantDroit->id."</td>
                         <td>".$Affilier->Code."</td>
                         <td>".$AyantDroit->Nom."</td>
                        <td>".$AyantDroit->Prenom."</td>
                        <td>".' '."</td>  
                        <td class='center f-icon'>
                            <form action='".route('AyantsDroit.destroy',$AyantDroit)."' method='POST'>
                            <a href='".route('RestaureAyD',$AyantDroit)."'><img src='".url('icons/icons8_Reset_24px.png')."'></a>
                            <a href='".route('SupprimerDefinitivement',$AyantDroit)."'><img src='".url('icons/icons8_Multiply_26px.png')."'></a>
                             </form>
                            
                        </td>
                      
                    </tr>";
                    }
                       # code...
        }

        $tableListe=$table;
        return view('AyantsDroit.CorbAyantD', compact('tableListe'));  
    }

    public function RestaureAyD($id)
    {
        $AyantDroit = AyantDroit::findOrFail($id);
        $AyantDroit->update([
            'Etat' => 0
        ]); 

        return redirect(route('CorbAyantD')); 
    }

    public function SupprimerDefinitivement($id)
    {
        $AyantDroit = AyantDroit::findOrFail($id);
        $AyantDroit->update([
            'Etat' => 100
        ]);
        return redirect(route('CorbAyantD'));  
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


    public function uplodaAyantDroit(Request $request){
        
        $this->ExcelImport->uplodaAyantDroit($request);
        return back();
  }
}
