<?php

namespace App\Http\Controllers;
use App\Models\MedicamentPartenaire;
use Cart;
use App\Models\AyantDroit;
use App\Models\Partenaire;
use App\Models\Service;
use App\Models\Facture;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        if(session()->get('Profil')=="User"){
            $Type = "U";
        }else{
            $Type = "P";
        }

        $content = Cart::getContent()->where('adherant', session()->get('Aff'))->where('prestation', session()->get('service'))->where('user', session()->get('id').$Type)->where('Paterner', session()->get('Paterner'));
        $total = Cart::TotalCart($content);
        return view('cart.index', compact('content', 'total'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        if(session()->get('Profil')=="User"){
            $Type = "U";
        }else{
            $Type = "P";
        }
       
        $Aff = $request->Affilier;
        $service = $request->Service;
        $request->Propriete;
        $product = MedicamentPartenaire::findOrFail($request->Propriete);
        $content = Cart::getContent()->where('prestation', session()->get('service'))->where('user', session()->get('id').$Type)->where('Paterner', session()->get('Paterner'));
        $quantite= $request->quantite;
        if (is_numeric($product->prix) && is_numeric($request->Quantite)) {
        Cart::add([
            'id' => $request->Propriete,
            'price' => $product->prix,
            'quantity' => $request->Quantite,
            'code'=> $product->code,
            'name' => $product->designation,
            'sejour' => $request->Sejour,
            'prixtotal'=> $product->prix*$request->Quantite,
            'adherant' =>session()->get('Aff'),
            'prestation' => session()->get('service'),
            'user'=>session()->get('id').$Type,
            'Paterner'=>session()->get('Paterner'),
            'attributes' => [],
            'associatedModel' => $product,
        ]);

           session()->flash('message', 'Une prestation ajoutée dans votre panier');
        }
        $Prestation = Service::findOrFail($service);
        $AyantDroits = AyantDroit::whereAffilierAndEtat($Aff,0)->get();
        $Partenaires = Partenaire::whereEtat(0)->get();

        if(session()->get('Profil')=='Partenaire'){
           $Medicaments=MedicamentPartenaire::wherePartenaire(session()->get('id'))->get();
        }else{
           $Medicaments= MedicamentPartenaire::wherePartenaire(5)->get();
        }
        $sejourExist=Cart::sejourExist($Type);

        $content = Cart::getContent()->where('prestation', session()->get('service'))->where('user', session()->get('id').$Type)->where('Paterner', session()->get('Paterner'));

        $total = Cart::TotalCart($content);
        $totalQuant = Cart::getContent()->where('adherant', session()->get('Aff'))->where('prestation', session()->get('service'))->where('user', session()->get('id').$Type)->where('Paterner', session()->get('Paterner'))->count();
       return view('Prestation.create', compact('Aff', 'AyantDroits', 'Partenaires', 'Prestation', 'Medicaments', 'content', 'total', 'sejourExist', 'totalQuant'));
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
            Cart::remove($id);
            return redirect(route('panier.index')); 
    }
}
