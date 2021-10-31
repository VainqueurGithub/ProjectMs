<?php

namespace App\Http\Controllers;
use App\Http\Requests\changerprixformrequest;
use App\Http\Requests\MedicamentRequest;
use App\Http\Requests\ImportFromRequest;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Historiquemedicaments;
use App\Models\Partenaire;
use App\Models\Consomation;
use App\Models\Facture;
use App\Models\medicamentsservice;
use App\Models\MedicamentPartenaire;
use PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Excel;
use App\Interfaces\IMedicamentservice as IMedicamentservice;
use App\Models\ExcelImport;
use App\Interfaces\IExcelImport as IExcelImport;

class medicamentsserviceController extends Controller
{  


     public function __construct(IMedicamentservice $medicamentsservice, IExcelImport $ExcelImport){
        $this->ExcelImport = $ExcelImport;
        $this->medicamentsservice = $medicamentsservice;
        $this->middleware('guest');
      }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
      $results = $this->medicamentsservice->fetchtAll();
      return view('Medicaments.index', compact('results'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $medicament = new medicamentsservice;
        $Partenaire = new Partenaire;
        $Partenaires = Partenaire::whereEtat(0)->get();
        return view('Medicaments.create', compact('Partenaires', 'medicament', 'Partenaire'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MedicamentRequest $request)
    {  
        $this->medicamentsservice->savedata($request, null);
        return redirect(route('Medicaments.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        $results = $this->medicamentsservice->showData($id);
        return view('Medicaments.show', compact('results', 'id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $medicament = medicamentsservice::findOrFail($id);
        $Partenaires = Partenaire::whereEtat(0)->get();
        return view('Medicaments.edit', compact('medicament', 'Partenaires'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MedicamentRequest $request, $id)
    {  
      $this->medicamentsservice->savedata($request, $id);
      return redirect(route('Medicaments.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $this->medicamentsservice->deleteData($id);
    }

    //Changer le Prix du Medicament

    public function ChangerPrix($Medicament){
        $medicament =MedicamentPartenaire::findOrFail($Medicament);
        return view('Medicaments.ChangerPrix', compact('medicament'));
    }

    //Sauvegarder le Changement du Prix

    public function ChangerPrixStore(changerprixformrequest $request, $Medicament){
        $this->medicamentsservice->ChangerPrixStore($request, $Medicament);
        return redirect(route('Medicaments.index'));
    }


    public function research(Request $request){
        $medicament=$request->get('medicament');
        if(session()->get('Profil')=='Partenaire'){
           $Medicaments=MedicamentPartenaire::where('code','like','%'.$medicament.'%')->where('partenaire', session()->get('id'))->get();
        }else{
           $NbreFacture = Facture::whereAuteurAndAuteurtype(session()->get('id'), session()->get('Profil'))->max('id'); 
           if($NbreFacture > 0){
              $Facture = Facture::findOrFail($NbreFacture);
              $Medicaments= MedicamentPartenaire::where('code','like','%'.$medicament.'%')->where('partenaire', $Facture->Partenaire)->get();
           }else{
            $Medicaments = new MedicamentPartenaire;
           }
        }
    
        $allMedicaments="";
        foreach ($Medicaments as $Medicament) {
            //$Libelle = medicamentsservice::findOrFail($medicament->medicament);
            $allMedicaments.="<option value='".$Medicament->id."'>".$Medicament->designation.'/ '.$Medicament->prix.' FBU'."</option>";
        }
        echo $allMedicaments;
    } 

    //Imprimer la liste medicaments et Services
    public function PdfAllMedicaments(){
           $medicamentsservice =DB::table('medicamentsservices')
         ->select(DB::raw('medicamentsservices.propriete,medicamentsservices.id, medicamentsservices.created_at'))
         ->get();
      
       $table = '';
        foreach($medicamentsservice as $medicament){
            $table.="
                    <tr class='odd gradeX'>
                        <td>".$medicament->id."</td>
                         <td>".$medicament->propriete."</td>
                         <td>".$medicament->created_at."</td>
                    </tr>";
                    }
        $tableListe=$table;
         $pdf = PDF::loadView('Medicaments.ListingPdf', compact('tableListe'))->setPaper('a4', 'Paysage');
         $fileName = 'Listing Medicaments';
         return $pdf->stream($fileName . '.pdf');
    }

    public function Historique($Med){
       
       $results = DB::table('medicament_partenaires')
       ->join('historiquemedicaments', 'historiquemedicaments.Medicament', '=', 'medicament_partenaires.id')
       ->select(DB::raw('medicament_partenaires.code, historiquemedicaments.Prix, historiquemedicaments.Debut, historiquemedicaments.Fin'))
       ->where('historiquemedicaments.Medicament', $Med)
       ->get();
        $medicaments = MedicamentPartenaire::findOrFail($Med);
        return view('Medicaments.Historique', compact('results', 'medicaments'));
    }

    public function Getimport($Partenaire){
      $Services = DB::table('medicamentsservices')
      ->Rightjoin('medicament_partenaires', 'medicament_partenaires.medicament', '=', 'medicamentsservices.id')
      ->join('partenaires', 'medicament_partenaires.partenaire', '=', 'partenaires.id')
      ->select(DB::raw('medicament_partenaires.prix, medicament_partenaires.code, medicament_partenaires.designation, medicamentsservices.propriete, medicament_partenaires.id'))
      ->where('medicament_partenaires.partenaire', $Partenaire)
      ->get();

      $table = '';

      foreach ($Services as $Service) 
      {
          $table .= "<tr>
            <td>".$Service->id."</td>
            <td>".$Service->propriete."</td>
            <td>".$Service->designation."</td>
            <td>".$Service->code."</td>
            <td>".$Service->prix."</td>
            <td><a  href='".route('Categorize', $Service->id)."' style='display: none;'><i class='fa fa-plus'></i>
                </a></td>
          </tr>";
      }
      $tableListe = $table;
      return view('Excel.importMedicament', compact('Partenaire','tableListe'));
    }

    public function PostImport(Request $request){  

       $this->ExcelImport->uploadService($request);
        return back();
       
       if (isset($request->hidden_field)) {
           $error = '';
           $total_line = '';

           if (is_null($request->services)) {
              $error = 'Please select a file';
           }else{
              $this->ExcelImport->uploadService($request);
           }

           if ($error='')
           {
              $output = array(
                'error' => $error
              );
           }
           else{
              $output = array(
                'success' => true,
                'total_line' => ($total_line - 1)
              );
           }
       }
       
       echo json_encode($output);
   }

   //Importation des medication cote SAAT

public function ImporterFile(Request $request){ 
set_time_limit(0);      
$extensions = array("xls","xlsx","xlm","xla","xlc","xlt","xlw", "csv");
$result = array($request->file('services')->getClientOriginalExtension());

//On verifie l'extension du fichier
if(in_array($result[0],$extensions)){
     // Do something when Succeeded 

        $data = Excel::load(Input::file('services'), function($reader) {})->get();
        if(!empty($data) && $data->count()){
        foreach ($data->toArray() as $key => $value) {
           
      //On verifie si toutes les colonnes de notre fichier sont remplies sauf Partenaire
        if (!empty($value['propriete'])) {
          //Verification de doublons  
          $Nbre = medicamentsservice::wherePropriete($value['propriete'])->count('id');
          //Cas des doublons, on fait la mise a jour
          if ($Nbre >0) {
        
            $medicament = medicamentsservice::wherePropriete($value['propriete'])->first();  
            $medicament->update([
                'propriete'=>$value['propriete']
            ]); 
          }
          //Cas contraire on fait l'insertion
          else{
            medicamentsservice::create([
                'propriete'=>$value['propriete']
            ]);
        }
        session()->flash('message', 'Fichier chargé completement avec success, '. $data->count().' Enregistrements ont été ajoutés');     
      }    
    }
    }else{
       session()->flash('messageDelete', 'Une erreur s\'est produit lors du chargement');
    }
  }
else{
   session()->flash('messageDelete', 'Verifier L\'extension de votre fichier');
}
  return back(); 
}   

   public function ExportMedicament(){
      //$customer = Client::get()->toArray();
      $Medicament = medicamentsservice::whereEtat(0)->get(['id as medicament', 'propriete as Appelation']);              
      $Medicament= json_decode( json_encode($Medicament), true);    
       Excel::create('Export Data',function($excel) use($Medicament){
        $excel->sheet('Sheet 1', function($sheet) use($Medicament){
          $sheet->fromArray($Medicament);
        });
      })->export('xlsx');  
   }

   public function ExportExcelMedicament($Partenaire){
       //$customer = Client::get()->toArray();
      $Medicament =DB::table('medicamentsservices')
                  ->join('medicament_partenaires', 'medicament_partenaires.medicament', '=', 'medicamentsservices.id')
                  ->select(DB::raw('medicamentsservices.propriete as Appelation_SAAT, medicament_partenaires.designation, medicament_partenaires.code, medicament_partenaires.prix'))
                  ->where('medicament_partenaires.partenaire', $Partenaire)
                  ->get();    
      $Partenaire = Partenaire::findOrFail($Partenaire);
      $Medicament= json_decode( json_encode($Medicament), true);    
       Excel::create('TARIFICATION '.$Partenaire->Partenaire,function($excel) use($Medicament){
        $excel->sheet('Sheet 1', function($sheet) use($Medicament){
          $sheet->fromArray($Medicament);
        });
      })->export('xlsx');  
   }

   public function Categorize($id){
      $Medicaments = medicamentsservice::whereEtat(0)->get();
      return view('MedicamentPartenaire.create', compact('id', 'Medicaments'));
      //return view('Medicaments.Historique', compact('tableListe', 'medicaments'));
   }

   public function DefCategorie(Request $request){
    $this->validate($request, [
            'Categorise' => 'required', 
            'medicament' => 'required'
            ]);
     $Med = MedicamentPartenaire::findOrFail($request->medicament);
     $id = $Med->partenaire;
     $Med->update([
        'medicament'=>$request->Categorise
     ]);
     return redirect(route('Getimport', compact('id')));
   }
}


