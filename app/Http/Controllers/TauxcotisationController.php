<?php

namespace App\Http\Controllers;
use App\Models\Tauxcotisation;
use App\Models\Cotisation;
use Illuminate\Http\Request;

class TauxcotisationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $ThisYear = date('Y');
        $Tauxcotisations = Tauxcotisation::whereParamAnnee($ThisYear)->get();
        $TauxUsed = Cotisation::whereAnnee($ThisYear)->count('id');
        return view('TauxCotisation.index', compact('Tauxcotisations', 'TauxUsed'));
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
    {       $ThisYear = date('Y');
        $Nbre = Tauxcotisation::whereParamAnnee($ThisYear)->count('id');

        //ON CONTROLE A CE QU'IL N'Y AI PAS ++ TAUX DE COTISATION POUR UNE ANNEE.
        if ($Nbre==0) {
            if ($request->action==0) {
                Tauxcotisation::create([
                    'param_taux'=>$request->action,
                    'param1'=>$request->MontantForfaitaire,
                    'param_annee'=>$ThisYear
                ]);
            }elseif($request->action==1){
                Tauxcotisation::create([
                    'param_taux'=>$request->action,
                    'param1'=>$request->MontantPersonneCharge,
                    'param2'=>$request->MontantBeneficiaire,
                    'param_annee'=>$ThisYear
                ]);
            }elseif ($request->action==2) {
                Tauxcotisation::create([
                    'param_taux'=>$request->action,
                    'param1'=>$request->Pourcentage,
                    'param_annee'=>$ThisYear
                ]);
            }
        }else{
           session()->flash('messageDelete', 'Un taux de cotisation est déjà appliqué pour l\'année '.$ThisYear);
        }
        return redirect()->back();
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
}
