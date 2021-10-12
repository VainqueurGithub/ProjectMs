<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AffilierFormRequest extends Request
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
        'Code' => 'required', 
        'Nom' => 'required',
        'Prenom' => 'required',
        'Origine' => 'required',
        'DateEntree' => 'required | date',
        'Cotisation' => 'required | numeric',
        'SA' => 'required | numeric', 
        'HPC' => 'required |numeric',
        'HPCN' => 'required |numeric',
        'Maternite' => 'required |numeric',
        'MaterniteP' => 'required |numeric',
        'Pharmacie' => 'required |numeric',
        'Medicament' => 'required |numeric',
        'Lunette' => 'required |numeric',
        'dents' => 'required |numeric',
        'Hospitalisation'=>'required |numeric',
        'Imagerie'=>'required |numeric',
        'Reanimation'=>'required |numeric',
        'Kinesitherapie'=>'required |numeric',
        'Laboratoire'=>'required |numeric',
        'Piece' => 'required',
        'DateNaiss' => 'required |numeric',
        'Telephone' => 'max:15|min:6',
        'gender' => 'required'
        ];
    }
}
