<?php

  

namespace App\Http\Controllers\Auth;

  
use App\Models\ExerciceComptable;
use App\Models\Parametre;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Session;

use App\Models\User;

use Hash;

  

class AuthController extends Controller

{

    /**

     * Write code on Method

     *

     * @return response()

     */

    public function index()

    {

        return view('auth.main_login');

    }  

      

    /**

     * Write code on Method

     *

     * @return response()

     */

    public function registration()

    {

        return view('auth.registration');

    }

      

    /**

     * Write code on Method

     *

     * @return response()

     */

    public function postLogin(Request $request)

    {

        $request->validate([

            'email' => 'required',

            'password' => 'required',

        ]);

   

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            //ON VERIFIE S'IL Y A UN EXERCICE OUVERT
            $NbreExercice = ExerciceComptable::whereEtatAndCloturer(0,0)->count('id'); 
            if ($NbreExercice>0) { // CAS OU IL Y A UN EXERCICE OUVERT
                $Exercice = ExerciceComptable::whereEtatAndCloturer(0,0)->first();
            }else{ // CAS OU IL N'Y A PAS 
                $Exercice = new ExerciceComptable;
            }
                
            $request->session()->put('ExerciceDevise', $Exercice->Devise);
            $request->session()->put('ExerciceNbreDecimal', $Exercice->NbreDecimal);
            $request->session()->put('ExerciceSeparateurDecimal', $Exercice->separateurDecimal);
            $request->session()->put('ExerciceseparateurMilieu', $Exercice->separateurMilieu);
            $request->session()->put('ExerciceComptableId', $Exercice->id);
            $request->session()->put('ExerciceComptableDebut', $Exercice->Debut);
            $request->session()->put('ExerciceComptableFin', $Exercice->Fin);

            //Recuperer les informations generales de L'entreprise
            $NbreInfo = Parametre::where('entete', '!=', '')->where('footer', '!=', null)->count('id');
            if($NbreInfo > 0){
                    
            $InfoGeneral = Parametre::where('entete', '!=', '')->where('footer', '!=', null)->first();
                 
            $request->session()->put('Nom_Societe', $InfoGeneral->nom_societe);
            $request->session()->put('Nif', $InfoGeneral->nif);
            $request->session()->put('email', $InfoGeneral->email);
            $request->session()->put('Telephone', $InfoGeneral->telephone);
            $request->session()->put('Adresse', $InfoGeneral->adresse);
            $request->session()->put('BqnomUn', $InfoGeneral->bq_nom_un);
            $request->session()->put('BqnumUn', $InfoGeneral->bq_num_un);
            $request->session()->put('BqnomDeux', $InfoGeneral->bq_nom_deux);
            $request->session()->put('BqnumDeux', $InfoGeneral->bq_num_deux);
            $request->session()->put('Headerfile', $InfoGeneral->entete);
            $request->session()->put('Footerfile', $InfoGeneral->footer);
                    
            }else{
                //   $InfoGeneral = InfoGeneral::where('entete', '!=', '')->where('entete', '!=', null)->first();
                 
                $request->session()->put('Nom_Societe', "");
                $request->session()->put('Nif', "");
                $request->session()->put('email', "");
                $request->session()->put('Telephone', "");
                $request->session()->put('Adresse', "");
                $request->session()->put('BqnomUn', "");
                $request->session()->put('BqnumUn', "");
                $request->session()->put('BqnomDeux', "");
                $request->session()->put('BqnumDeux', "");
                $request->session()->put('Headerfile', "");
                $request->session()->put('Footerfile', "");
            }

            $ToDay = Date("Y-m");
            $CurrentYear = Date("Y");
            $request->session()->put('yearcurrent', $CurrentYear);
            $request->session()->put('periodbeg', $ToDay."-01");
            $request->session()->put('periodend', $ToDay."-31");
            return redirect(route('TableauDeBord'));

        }

        return redirect("login")->withSuccess('Oppes! You have entered invalid credentials');
    }

      

    /**

     * Write code on Method

     *

     * @return response()

     */

    public function postRegistration(Request $request)

    {  

        $request->validate([

            'name' => 'required',

            'email' => 'required|email|unique:users',

            'password' => 'required|min:6',

        ]);

           

        $data = $request->all();

        $check = $this->create($data);
            $ToDay = Date("Y-m");
            $CurrentYear = Date("Y");
            $request->session()->put('yearcurrent', $CurrentYear);
            $request->session()->put('periodbeg', $ToDay."-01");
            $request->session()->put('periodend', $ToDay."-31");
            return redirect(route('TableauDeBord'));

    }

    

    /**

     * Write code on Method

     *

     * @return response()

     */

    public function dashboard()

    {

        if(Auth::check()){

            return view('TableauDeBord');

        }

  

        return redirect("login")->withSuccess('Opps! You do not have access');

    }

    

    /**

     * Write code on Method

     *

     * @return response()

     */

    public function create(array $data)

    {

      return User::create([

        'name' => $data['name'],

        'email' => $data['email'],

        'password' => Hash::make($data['password'])

      ]);

    }

    

    /**

     * Write code on Method

     *

     * @return response()

     */

    public function logout() {

        Session::flush();

        Auth::logout();

  

        return Redirect('login');

    }

}