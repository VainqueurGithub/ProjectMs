<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\CompteSubdivisionnaire;
use App\Models\User;
use App\Models\guichets;
class GuichetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $guichets = DB::table('guichets')
                  ->join('users', 'users.id', '=', 'guichets.user_id')
                  ->join('compte_subdivisionnaires', 'compte_subdivisionnaires.id', '=', 'guichets.comptesubd_id')
                  ->join('sous_comptes', 'sous_comptes.id', '=', 'guichets.souscompte_id')
                  ->select(DB::raw('compte_subdivisionnaires.NumeroCompte as csubd, sous_comptes.NumeroCompte scompte,guichets.id, users.name'))
                  ->get();
        $Users = User::all();
        $CompteSubdivisionnaires = CompteSubdivisionnaire::whereEtat(0)->get();         
        return view('guichets.index', compact('guichets', 'CompteSubdivisionnaires', 'Users'));
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
       guichets::create([
           'user_id'=>$request->user,
           'comptesubd_id'=>$request->guichet,
           'souscompte_id'=>$request->sc_compte1
       ]);
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
