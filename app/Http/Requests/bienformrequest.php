<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class bienformrequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'Type'=>'required',
            'Nom'=>'required|max:100',
            'Dateacquis'=>'required',
            'Moyen'=>'required',
            'Misservice'=>'required',
            'Montant'=>'required',
            'Duree'=>'required|numeric',
            'Methode'=>'required'
        ];
    }
}
