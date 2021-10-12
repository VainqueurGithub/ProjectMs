<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ReportageFormRequest extends Request
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
            'Montant'=>'numeric|required',
            'Compte'=>'numeric|required',
            'Categorie'=>'required|numeric|min:1|max:2'
        ];
    }
}
