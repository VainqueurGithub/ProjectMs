<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ServiceFormRequest;
use App\Http\Requests;
use App\Models\Affilier;
use App\Models\Partenaire;
use App\Models\AyantDroit;
use App\Models\Origine;
use App\Models\AffilierPartenaire;
use App\Models\Service;
use App\Models\ServiceAffilier;
use Illuminate\Support\Facades\DB;
use PDF;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $Services = Service::whereEtat(0)->get();
         return view('Services.index', compact('Services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $Service = new Service;
        $Traitement='';
        return view('Services.create', compact('Service','Traitement'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceFormRequest $request)
    {
        $NbreService = Service::whereServiceAndTraitement($request->Service,$request->Couverture)->count('id');
        if ($NbreService == 0) 
        {
             Service::create([
            'Service' => $request->Service,
            'Traitement' =>$request->Couverture]);
        }else{ session()->flash('messageDelete', 'Ce Service existe deja');} 

        return redirect(route('Services.index')); 
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
        $Service = Service::findOrFail($id);
        if($Service->Traitement == 1) {
             $Traitement = 'Soins Ambulatoire (Consultation uniquement)';
        }elseif($Service->Traitement == 2) {
           $Traitement = 'Hospitalisation';
        }elseif($Service->Traitement == 3) {
            $Traitement = 'Maternité';
        }elseif($Service->Traitement == 4){
            $Traitement = 'Soins Ambulatoire Medicament';
        }elseif($Service->Traitement == 5){
            $Traitement = 'Soins Ambulatoire Lunette';
        }elseif ($Service->Traitement == 6) {
            $Traitement = 'Soins Ambulatoire Dent';
        }elseif ($Service->Traitement == 7) {
           $Traitement = 'Soins Ambulatoire Laboratoire';
        }elseif ($Service->Traitement == 8) {
            $Traitement = 'Soins Ambulatoire Kinesitherapie';
        }elseif ($Service->Traitement == 9) {
            $Traitement = 'Soins Ambulatoire Reanimation';
        }elseif ($Service->Traitement == 10) {
            $Traitement = 'Soins Ambulatoire Imagerie Medicale';
        }
        
        return view('Services.edit', compact('Service', 'Traitement'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ServiceFormRequest $request, $id)
    {
        
        $NbreService = Service::whereServiceAndTraitement($request->Service,$request->Couverture)->where('id', '!=', $id)->count('id');
        $Service = Service::findOrFail($id);
        if ($NbreService == 0) 
        {
             $Service->update([
            'Service' => $request->Service,
            'Traitement' =>$request->Couverture]);
        }else{ session()->flash('messageDelete', 'Ce Service existe deja');} 

        return redirect(route('Services.index')); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Service = Service::findOrFail($id);
       
             $Service->update([
            'Etat' => 1]);
        return redirect(route('Services.index')); 
    }

    public function AttacherAff($Service)
    {
      $Origines = Origine::whereEtat(0)->get();
      $Affiliers = Affilier::whereEtat(0)->get();

      $NbreAff = ServiceAffilier::whereEtatAndService(0, $Service)->count();  
        $table="";
        if ($NbreAff > 0) {

         $AffService =ServiceAffilier::whereEtatAndService(0, $Service)->get();
         foreach($AffService as $AffSer){
         $AffilierServ = Affilier::whereId($AffSer->Affilier)->first();
           $table.="
                    <tr class='odd gradeX'>
                        <td>".$AffilierServ->Code."</td>
                        <td>".$AffilierServ->Nom."</td>
                        <td>".$AffilierServ->Prenom."</td>
                    <td>
                    <a href='".route('Affiliers.edit', $AffSer)."'><img src='".url('icons/icons8_Edit_26px.png')."' width='20px' height='20px'>
                    </a>

                    <form action='".route('Affiliers.destroy', $AffSer)."' method='POST' style='display: inline-block;' onsubmit='return confirm('Etez -vous sur de cette Operation ?')'>
                    ".csrf_field()."
                    ".method_field('DELETE')."
                    
                    <button><img src='".url('icons/icons8_Delete_52px.png')."' width='20px' height='20px'>
                    </button>
                </form>
            </td>
        </tr>"; 
        }
      }    
    $tableListe=$table;  
      return view('Services.AttacherAff',compact('Origines', 'Affiliers', 'Service', 'tableListe'));
    }

    public function AttacherAffStore(Request $request)
    {   
        $Service = $request->Service;
        if (isset($request->Origine) && !empty($request->Origine)) 
        {
           $Affiliers = DB::table('affiliers')
                     ->join('origines', 'origines.id', '=', 'affiliers.Origine')
                     ->select(DB::raw('affiliers.id, affiliers.Etat'))
                     ->where('affiliers.Etat',0)
                     ->where('affiliers.Origine',$request->Origine)
                     ->get(); 
            foreach ($Affiliers as $Aff) 
            {  
                $NbreSerAff = ServiceAffilier::whereServiceAndAffilier($request->Service,$Aff->id)->count('id');
                if ($NbreSerAff==0) 
                {
                     ServiceAffilier::create([
                    'service' => $request->Service,
                   'Affilier' =>$Aff->id]);
                }
            }         
        }elseif (isset($request->Affilier) && !empty($request->Affilier)) {
            
            $NbreSerAff = ServiceAffilier::whereServiceAndAffilier($request->Service,$request->Affilier)->count('id');
                if ($NbreSerAff==0) 
                {
                     ServiceAffilier::create([
                    'service' => $request->Service,
                   'Affilier' =>$request->Affilier]);
                }
        }

        return redirect(route('AttacherAff', compact('Service')));
    }

}
