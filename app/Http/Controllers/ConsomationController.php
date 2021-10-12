<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Consomation;
class ConsomationController extends Controller
{
    public function ChangerAdresse()
    {
       $Consomation = Consomation::findOrFail(1);
       return view('Consomations.edit', compact('Consomation'));
    }

    public function ModifierAdresse(Request $request, $id)
    {
    	$this->validate($request, [
        'Adresse' => 'required'
        ]);
        
        $Consomation = Consomation::findOrFail($id);

        $Consomation->update([
          'Adresse' => $request->Adresse
        ]);

        return redirect(route('ChangerAdresse'));

    }
}
