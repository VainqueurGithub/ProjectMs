<?php

namespace App\Http\Controllers;
use App\Models\mouvement_affiliers;
use App\Models\Affilier;
use App\Models\AyantDroit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class mouvement_affiliersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {   
       $Annee = Carbon::createFromDate($request->datemvt)->format('Y');
       $Mois = Carbon::createFromDate($request->datemvt)->format('m');

       switch ($Mois) {
          case 1:
             mouvement_affiliers::create([
            'beneficiaire_id'=>$request->beneficiaire,
            'type_beneficiaire'=>$request->beneficiaire_type,
            'type_mvt'=>$request->mvt_affilier,
            'date_mvt'=>$request->datemvt,
            'motif'=>$request->motif,
            'annee'=>$Annee,
            'mois'=>$Mois,
            'Janvier'=>1
             ]);
          break;

          case 2:
             mouvement_affiliers::create([
            'beneficiaire_id'=>$request->beneficiaire,
            'type_beneficiaire'=>$request->beneficiaire_type,
            'type_mvt'=>$request->mvt_affilier,
            'date_mvt'=>$request->datemvt,
            'motif'=>$request->motif,
            'annee'=>$Annee,
            'mois'=>$Mois,
            'Fevrier'=>1
             ]);
          break;

          case 3:
             mouvement_affiliers::create([
            'beneficiaire_id'=>$request->beneficiaire,
            'type_beneficiaire'=>$request->beneficiaire_type,
            'type_mvt'=>$request->mvt_affilier,
            'date_mvt'=>$request->datemvt,
            'motif'=>$request->motif,
            'annee'=>$Annee,
            'mois'=>$Mois,
            'Mars'=>1
             ]);
          break;

          case 4:
             mouvement_affiliers::create([
            'beneficiaire_id'=>$request->beneficiaire,
            'type_beneficiaire'=>$request->beneficiaire_type,
            'type_mvt'=>$request->mvt_affilier,
            'date_mvt'=>$request->datemvt,
            'motif'=>$request->motif,
            'annee'=>$Annee,
            'mois'=>$Mois,
            'Avril'=>1
             ]);
          break;

          case 5:
             mouvement_affiliers::create([
            'beneficiaire_id'=>$request->beneficiaire,
            'type_beneficiaire'=>$request->beneficiaire_type,
            'type_mvt'=>$request->mvt_affilier,
            'date_mvt'=>$request->datemvt,
            'motif'=>$request->motif,
            'annee'=>$Annee,
            'mois'=>$Mois,
            'Mai'=>1
             ]);
          break;

          case 6:
             mouvement_affiliers::create([
            'beneficiaire_id'=>$request->beneficiaire,
            'type_beneficiaire'=>$request->beneficiaire_type,
            'type_mvt'=>$request->mvt_affilier,
            'date_mvt'=>$request->datemvt,
            'motif'=>$request->motif,
            'annee'=>$Annee,
            'mois'=>$Mois,
            'Juin'=>1
             ]);
          break;

          case 7:
             mouvement_affiliers::create([
            'beneficiaire_id'=>$request->beneficiaire,
            'type_beneficiaire'=>$request->beneficiaire_type,
            'type_mvt'=>$request->mvt_affilier,
            'date_mvt'=>$request->datemvt,
            'motif'=>$request->motif,
            'annee'=>$Annee,
            'mois'=>$Mois,
            'Juillet'=>1
             ]);
          break;

          case 8:
             mouvement_affiliers::create([
            'beneficiaire_id'=>$request->beneficiaire,
            'type_beneficiaire'=>$request->beneficiaire_type,
            'type_mvt'=>$request->mvt_affilier,
            'date_mvt'=>$request->datemvt,
            'motif'=>$request->motif,
            'annee'=>$Annee,
            'mois'=>$Mois,
            'Aout'=>1
             ]);
          break;

          case 9:
             mouvement_affiliers::create([
            'beneficiaire_id'=>$request->beneficiaire,
            'type_beneficiaire'=>$request->beneficiaire_type,
            'type_mvt'=>$request->mvt_affilier,
            'date_mvt'=>$request->datemvt,
            'motif'=>$request->motif,
            'annee'=>$Annee,
            'mois'=>$Mois,
            'Septembre'=>1
             ]);
          break;

          case 10:
             mouvement_affiliers::create([
            'beneficiaire_id'=>$request->beneficiaire,
            'type_beneficiaire'=>$request->beneficiaire_type,
            'type_mvt'=>$request->mvt_affilier,
            'date_mvt'=>$request->datemvt,
            'motif'=>$request->motif,
            'annee'=>$Annee,
            'mois'=>$Mois,
            'Octobre'=>1
             ]);
          break;

          case 11:
             mouvement_affiliers::create([
            'beneficiaire_id'=>$request->beneficiaire,
            'type_beneficiaire'=>$request->beneficiaire_type,
            'type_mvt'=>$request->mvt_affilier,
            'date_mvt'=>$request->datemvt,
            'motif'=>$request->motif,
            'annee'=>$Annee,
            'mois'=>$Mois,
            'Novembre'=>1
             ]);
          break;
          case 12:
             mouvement_affiliers::create([
            'beneficiaire_id'=>$request->beneficiaire,
            'type_beneficiaire'=>$request->beneficiaire_type,
            'type_mvt'=>$request->mvt_affilier,
            'date_mvt'=>$request->datemvt,
            'motif'=>$request->motif,
            'annee'=>$Annee,
            'mois'=>$Mois,
            'Decembre'=>1
             ]);
          break;
      default:
    }
        mouvement_affiliers::getStatus($request->beneficiaire,$request->beneficiaire_type);
        if ($request->beneficiaire_type==2) {
           return back();
        }else{
           return redirect(route('Affiliers.index')); 
        }
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function details_mvt($periode, $type_beneficiaire, $type_mvt){

        if($type_beneficiaire==1){
            $beneficiaires = DB::table('mouvent_beneficiaires')
                       ->join('affiliers', 'affiliers.id', '=', 'mouvent_beneficiaires.beneficiaire_id')
                       ->select(DB::raw('affiliers.Code,affiliers.Nom,affiliers.Prenom'))
                       ->where('mouvent_beneficiaires.type_beneficiaire',$type_beneficiaire)
                       ->where('mouvent_beneficiaires.type_mvt',$type_mvt)
                       ->where('mouvent_beneficiaires.date_mvt',$periode)
                       ->groupBy('affiliers.id')
                       ->get();
        }else{
            $beneficiaires = DB::table('mouvent_beneficiaires')
                       ->join('ayant_droits', 'ayant_droits.id', '=', 'mouvent_beneficiaires.beneficiaire_id')
                       ->select(DB::raw('ayant_droits.Code,ayant_droits.Nom,ayant_droits.Prenom'))
                       ->where('mouvent_beneficiaires.type_beneficiaire',$type_beneficiaire)
                       ->where('mouvent_beneficiaires.type_mvt',$type_mvt)
                       ->where('mouvent_beneficiaires.date_mvt',$periode)
                       ->groupBy('ayant_droits.id')
                       ->get();
        }
        
        return view('mouvement.show', compact('beneficiaires'));               
    }

    public function details_mvt_suivi($periode, $moi, $type_beneficiaire, $type_mvt){
        if($type_beneficiaire==1){
            if ($moi==1) {
                $beneficiaires = DB::table('mouvent_beneficiaires')
                       ->join('affiliers', 'affiliers.id', '=', 'mouvent_beneficiaires.beneficiaire_id')
                       ->select(DB::raw('affiliers.Code,affiliers.Nom,affiliers.Prenom'))
                       ->where('mouvent_beneficiaires.type_beneficiaire',$type_beneficiaire)
                       ->where('mouvent_beneficiaires.type_mvt',$type_mvt)
                       ->where('mouvent_beneficiaires.annee',$periode)
                        ->where('mouvent_beneficiaires.Janvier',1)
                       ->groupBy('affiliers.id')
                       ->get();
            }elseif ($moi==2) {
                $beneficiaires = DB::table('mouvent_beneficiaires')
                       ->join('affiliers', 'affiliers.id', '=', 'mouvent_beneficiaires.beneficiaire_id')
                       ->select(DB::raw('affiliers.Code,affiliers.Nom,affiliers.Prenom'))
                       ->where('mouvent_beneficiaires.type_beneficiaire',$type_beneficiaire)
                       ->where('mouvent_beneficiaires.type_mvt',$type_mvt)
                       ->where('mouvent_beneficiaires.annee',$periode)
                        ->where('mouvent_beneficiaires.Fevrier',1)
                       ->groupBy('affiliers.id')
                       ->get();
            }elseif ($moi==3) {
                $beneficiaires = DB::table('mouvent_beneficiaires')
                       ->join('affiliers', 'affiliers.id', '=', 'mouvent_beneficiaires.beneficiaire_id')
                       ->select(DB::raw('affiliers.Code,affiliers.Nom,affiliers.Prenom'))
                       ->where('mouvent_beneficiaires.type_beneficiaire',$type_beneficiaire)
                       ->where('mouvent_beneficiaires.type_mvt',$type_mvt)
                       ->where('mouvent_beneficiaires.annee',$periode)
                        ->where('mouvent_beneficiaires.Mars',1)
                       ->groupBy('affiliers.id')
                       ->get();
            }elseif ($moi==4) {
                $beneficiaires = DB::table('mouvent_beneficiaires')
                       ->join('affiliers', 'affiliers.id', '=', 'mouvent_beneficiaires.beneficiaire_id')
                       ->select(DB::raw('affiliers.Code,affiliers.Nom,affiliers.Prenom'))
                       ->where('mouvent_beneficiaires.type_beneficiaire',$type_beneficiaire)
                       ->where('mouvent_beneficiaires.type_mvt',$type_mvt)
                       ->where('mouvent_beneficiaires.annee',$periode)
                        ->where('mouvent_beneficiaires.Avril',1)
                       ->groupBy('affiliers.id')
                       ->get();
            }elseif ($moi==5) {
                $beneficiaires = DB::table('mouvent_beneficiaires')
                       ->join('affiliers', 'affiliers.id', '=', 'mouvent_beneficiaires.beneficiaire_id')
                       ->select(DB::raw('affiliers.Code,affiliers.Nom,affiliers.Prenom'))
                       ->where('mouvent_beneficiaires.type_beneficiaire',$type_beneficiaire)
                       ->where('mouvent_beneficiaires.type_mvt',$type_mvt)
                       ->where('mouvent_beneficiaires.annee',$periode)
                        ->where('mouvent_beneficiaires.Mai',1)
                       ->groupBy('affiliers.id')
                       ->get();
            }elseif ($moi==6) {
                $beneficiaires = DB::table('mouvent_beneficiaires')
                       ->join('affiliers', 'affiliers.id', '=', 'mouvent_beneficiaires.beneficiaire_id')
                       ->select(DB::raw('affiliers.Code,affiliers.Nom,affiliers.Prenom'))
                       ->where('mouvent_beneficiaires.type_beneficiaire',$type_beneficiaire)
                       ->where('mouvent_beneficiaires.type_mvt',$type_mvt)
                       ->where('mouvent_beneficiaires.annee',$periode)
                        ->where('mouvent_beneficiaires.Juin',1)
                       ->groupBy('affiliers.id')
                       ->get();
            }elseif ($moi==7) {
                $beneficiaires = DB::table('mouvent_beneficiaires')
                       ->join('affiliers', 'affiliers.id', '=', 'mouvent_beneficiaires.beneficiaire_id')
                       ->select(DB::raw('affiliers.Code,affiliers.Nom,affiliers.Prenom'))
                       ->where('mouvent_beneficiaires.type_beneficiaire',$type_beneficiaire)
                       ->where('mouvent_beneficiaires.type_mvt',$type_mvt)
                       ->where('mouvent_beneficiaires.annee',$periode)
                        ->where('mouvent_beneficiaires.Juillet',1)
                       ->groupBy('affiliers.id')
                       ->get();
            }elseif ($moi==8) {
                $beneficiaires = DB::table('mouvent_beneficiaires')
                       ->join('affiliers', 'affiliers.id', '=', 'mouvent_beneficiaires.beneficiaire_id')
                       ->select(DB::raw('affiliers.Code,affiliers.Nom,affiliers.Prenom'))
                       ->where('mouvent_beneficiaires.type_beneficiaire',$type_beneficiaire)
                       ->where('mouvent_beneficiaires.type_mvt',$type_mvt)
                       ->where('mouvent_beneficiaires.annee',$periode)
                        ->where('mouvent_beneficiaires.Aout',1)
                       ->groupBy('affiliers.id')
                       ->get();
            }elseif ($moi==9) {
                $beneficiaires = DB::table('mouvent_beneficiaires')
                       ->join('affiliers', 'affiliers.id', '=', 'mouvent_beneficiaires.beneficiaire_id')
                       ->select(DB::raw('affiliers.Code,affiliers.Nom,affiliers.Prenom'))
                       ->where('mouvent_beneficiaires.type_beneficiaire',$type_beneficiaire)
                       ->where('mouvent_beneficiaires.type_mvt',$type_mvt)
                       ->where('mouvent_beneficiaires.annee',$periode)
                        ->where('mouvent_beneficiaires.Septembre',1)
                       ->groupBy('affiliers.id')
                       ->get();
            }elseif ($moi==10) {
                $beneficiaires = DB::table('mouvent_beneficiaires')
                       ->join('affiliers', 'affiliers.id', '=', 'mouvent_beneficiaires.beneficiaire_id')
                       ->select(DB::raw('affiliers.Code,affiliers.Nom,affiliers.Prenom'))
                       ->where('mouvent_beneficiaires.type_beneficiaire',$type_beneficiaire)
                       ->where('mouvent_beneficiaires.type_mvt',$type_mvt)
                       ->where('mouvent_beneficiaires.annee',$periode)
                        ->where('mouvent_beneficiaires.Octobre',1)
                       ->groupBy('affiliers.id')
                       ->get();
            }elseif ($moi==11) {
                $beneficiaires = DB::table('mouvent_beneficiaires')
                       ->join('affiliers', 'affiliers.id', '=', 'mouvent_beneficiaires.beneficiaire_id')
                       ->select(DB::raw('affiliers.Code,affiliers.Nom,affiliers.Prenom'))
                       ->where('mouvent_beneficiaires.type_beneficiaire',$type_beneficiaire)
                       ->where('mouvent_beneficiaires.type_mvt',$type_mvt)
                       ->where('mouvent_beneficiaires.annee',$periode)
                        ->where('mouvent_beneficiaires.Novembre',1)
                       ->groupBy('affiliers.id')
                       ->get();
            }elseif ($moi==12) {
                $beneficiaires = DB::table('mouvent_beneficiaires')
                       ->join('affiliers', 'affiliers.id', '=', 'mouvent_beneficiaires.beneficiaire_id')
                       ->select(DB::raw('affiliers.Code,affiliers.Nom,affiliers.Prenom'))
                       ->where('mouvent_beneficiaires.type_beneficiaire',$type_beneficiaire)
                       ->where('mouvent_beneficiaires.type_mvt',$type_mvt)
                       ->where('mouvent_beneficiaires.annee',$periode)
                        ->where('mouvent_beneficiaires.Decembre',1)
                       ->groupBy('affiliers.id')
                       ->get();
            }
            
        }else{
            if ($moi==1) {
                $beneficiaires = DB::table('mouvent_beneficiaires')
                       ->join('ayant_droits', 'ayant_droits.id', '=', 'mouvent_beneficiaires.beneficiaire_id')
                       ->select(DB::raw('ayant_droits.Code,ayant_droits.Nom,ayant_droits.Prenom'))
                       ->where('mouvent_beneficiaires.type_beneficiaire',$type_beneficiaire)
                       ->where('mouvent_beneficiaires.type_mvt',$type_mvt)
                       ->where('mouvent_beneficiaires.annee',$periode)
                       ->where('mouvent_beneficiaires.Janvier',1)
                       ->groupBy('ayant_droits.id')
                       ->get();
            }elseif ($moi==2) {
                $beneficiaires = DB::table('mouvent_beneficiaires')
                       ->join('ayant_droits', 'ayant_droits.id', '=', 'mouvent_beneficiaires.beneficiaire_id')
                       ->select(DB::raw('ayant_droits.Code,ayant_droits.Nom,ayant_droits.Prenom'))
                       ->where('mouvent_beneficiaires.type_beneficiaire',$type_beneficiaire)
                       ->where('mouvent_beneficiaires.type_mvt',$type_mvt)
                       ->where('mouvent_beneficiaires.annee',$periode)
                       ->where('mouvent_beneficiaires.Fevrier',1)
                       ->groupBy('ayant_droits.id')
                       ->get();
            }elseif ($moi==3) {
                $beneficiaires = DB::table('mouvent_beneficiaires')
                       ->join('ayant_droits', 'ayant_droits.id', '=', 'mouvent_beneficiaires.beneficiaire_id')
                       ->select(DB::raw('ayant_droits.Code,ayant_droits.Nom,ayant_droits.Prenom'))
                       ->where('mouvent_beneficiaires.type_beneficiaire',$type_beneficiaire)
                       ->where('mouvent_beneficiaires.type_mvt',$type_mvt)
                       ->where('mouvent_beneficiaires.annee',$periode)
                       ->where('mouvent_beneficiaires.Mars',1)
                       ->groupBy('ayant_droits.id')
                       ->get();
            }elseif ($moi==4) {
                $beneficiaires = DB::table('mouvent_beneficiaires')
                       ->join('ayant_droits', 'ayant_droits.id', '=', 'mouvent_beneficiaires.beneficiaire_id')
                       ->select(DB::raw('ayant_droits.Code,ayant_droits.Nom,ayant_droits.Prenom'))
                       ->where('mouvent_beneficiaires.type_beneficiaire',$type_beneficiaire)
                       ->where('mouvent_beneficiaires.type_mvt',$type_mvt)
                       ->where('mouvent_beneficiaires.annee',$periode)
                       ->where('mouvent_beneficiaires.Avril',1)
                       ->groupBy('ayant_droits.id')
                       ->get();
            }elseif ($moi==5) {
                $beneficiaires = DB::table('mouvent_beneficiaires')
                       ->join('ayant_droits', 'ayant_droits.id', '=', 'mouvent_beneficiaires.beneficiaire_id')
                       ->select(DB::raw('ayant_droits.Code,ayant_droits.Nom,ayant_droits.Prenom'))
                       ->where('mouvent_beneficiaires.type_beneficiaire',$type_beneficiaire)
                       ->where('mouvent_beneficiaires.type_mvt',$type_mvt)
                       ->where('mouvent_beneficiaires.annee',$periode)
                       ->where('mouvent_beneficiaires.Mai',1)
                       ->groupBy('ayant_droits.id')
                       ->get();
            }elseif ($moi==6) {
                $beneficiaires = DB::table('mouvent_beneficiaires')
                       ->join('ayant_droits', 'ayant_droits.id', '=', 'mouvent_beneficiaires.beneficiaire_id')
                       ->select(DB::raw('ayant_droits.Code,ayant_droits.Nom,ayant_droits.Prenom'))
                       ->where('mouvent_beneficiaires.type_beneficiaire',$type_beneficiaire)
                       ->where('mouvent_beneficiaires.type_mvt',$type_mvt)
                       ->where('mouvent_beneficiaires.annee',$periode)
                       ->where('mouvent_beneficiaires.Juin',1)
                       ->groupBy('ayant_droits.id')
                       ->get();
            }elseif ($moi==7) {
                $beneficiaires = DB::table('mouvent_beneficiaires')
                       ->join('ayant_droits', 'ayant_droits.id', '=', 'mouvent_beneficiaires.beneficiaire_id')
                       ->select(DB::raw('ayant_droits.Code,ayant_droits.Nom,ayant_droits.Prenom'))
                       ->where('mouvent_beneficiaires.type_beneficiaire',$type_beneficiaire)
                       ->where('mouvent_beneficiaires.type_mvt',$type_mvt)
                       ->where('mouvent_beneficiaires.annee',$periode)
                       ->where('mouvent_beneficiaires.Juillet',1)
                       ->groupBy('ayant_droits.id')
                       ->get();
            }elseif ($moi==8) {
                $beneficiaires = DB::table('mouvent_beneficiaires')
                       ->join('ayant_droits', 'ayant_droits.id', '=', 'mouvent_beneficiaires.beneficiaire_id')
                       ->select(DB::raw('ayant_droits.Code,ayant_droits.Nom,ayant_droits.Prenom'))
                       ->where('mouvent_beneficiaires.type_beneficiaire',$type_beneficiaire)
                       ->where('mouvent_beneficiaires.type_mvt',$type_mvt)
                       ->where('mouvent_beneficiaires.annee',$periode)
                       ->where('mouvent_beneficiaires.Aout',1)
                       ->groupBy('ayant_droits.id')
                       ->get();
            }elseif ($moi==9) {
                $beneficiaires = DB::table('mouvent_beneficiaires')
                       ->join('ayant_droits', 'ayant_droits.id', '=', 'mouvent_beneficiaires.beneficiaire_id')
                       ->select(DB::raw('ayant_droits.Code,ayant_droits.Nom,ayant_droits.Prenom'))
                       ->where('mouvent_beneficiaires.type_beneficiaire',$type_beneficiaire)
                       ->where('mouvent_beneficiaires.type_mvt',$type_mvt)
                       ->where('mouvent_beneficiaires.annee',$periode)
                       ->where('mouvent_beneficiaires.Septembre',1)
                       ->groupBy('ayant_droits.id')
                       ->get();
            }elseif ($moi==10) {
                $beneficiaires = DB::table('mouvent_beneficiaires')
                       ->join('ayant_droits', 'ayant_droits.id', '=', 'mouvent_beneficiaires.beneficiaire_id')
                       ->select(DB::raw('ayant_droits.Code,ayant_droits.Nom,ayant_droits.Prenom'))
                       ->where('mouvent_beneficiaires.type_beneficiaire',$type_beneficiaire)
                       ->where('mouvent_beneficiaires.type_mvt',$type_mvt)
                       ->where('mouvent_beneficiaires.annee',$periode)
                       ->where('mouvent_beneficiaires.Octobre',1)
                       ->groupBy('ayant_droits.id')
                       ->get();
            }elseif ($moi==11) {
                $beneficiaires = DB::table('mouvent_beneficiaires')
                       ->join('ayant_droits', 'ayant_droits.id', '=', 'mouvent_beneficiaires.beneficiaire_id')
                       ->select(DB::raw('ayant_droits.Code,ayant_droits.Nom,ayant_droits.Prenom'))
                       ->where('mouvent_beneficiaires.type_beneficiaire',$type_beneficiaire)
                       ->where('mouvent_beneficiaires.type_mvt',$type_mvt)
                       ->where('mouvent_beneficiaires.annee',$periode)
                       ->where('mouvent_beneficiaires.Novembre',1)
                       ->groupBy('ayant_droits.id')
                       ->get();
            }elseif ($moi==12) {
                $beneficiaires = DB::table('mouvent_beneficiaires')
                       ->join('ayant_droits', 'ayant_droits.id', '=', 'mouvent_beneficiaires.beneficiaire_id')
                       ->select(DB::raw('ayant_droits.Code,ayant_droits.Nom,ayant_droits.Prenom'))
                       ->where('mouvent_beneficiaires.type_beneficiaire',$type_beneficiaire)
                       ->where('mouvent_beneficiaires.type_mvt',$type_mvt)
                       ->where('mouvent_beneficiaires.annee',$periode)
                       ->where('mouvent_beneficiaires.Decembre',1)
                       ->groupBy('ayant_droits.id')
                       ->get();
            }
        }
        return view('mouvement.show', compact('beneficiaires'));
    }
}
