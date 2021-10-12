<?php

namespace App\Http\Controllers;
use App\Models\Depreciationtype;
use App\Models\biens;
use App\Models\CompteSubdivisionnaire;
use Illuminate\Http\Request;

class depreciationtypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $Types = Depreciationtype::whereEtat(0)->get();
        return  view('depreciations/Types.index', compact('Types'));
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
        if (Depreciationtype::uniqueType($request->Type)==true) {
            Depreciationtype::create([
            'Type'=>$request->Type
            ]);
        }else{
          session()->flash('messageDelete', 'Ce type des immobiliers existe dans MS');
        }
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        $Type = $id;
        $Scomptes = CompteSubdivisionnaire::whereEtat(0)->get();
        $Biens = biens::whereTypeAndEtat($id,0)->get();
        return  view('depreciations/Types.show', compact('Biens', 'Type', 'Scomptes'));
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
        $Depreciationtype = Depreciationtype::findOrFail($id);
        $Depreciationtype->update([
            'Etat'=>1
        ]);

        return back();
    }

    public function depreciationtypeupdate(Request $request){
        $Depreciationtype = Depreciationtype::findOrFail($request->typeImmo);
        $Depreciationtype->update([
            'Type'=>$request->Type
        ]);

        return back();
    }
}
