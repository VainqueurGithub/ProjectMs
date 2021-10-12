<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class JournalRequest extends Request
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
            //'Ordre'=>'numeric|required',
            // 'CD'=>'sometimes|required|numeric',
            // 'CC'=>'sometimes|required|numeric',
            'DateOperation'=>'required',
            'Libelle'=>'required',
            'MC'=>'numeric | min:0',
            'MD'=>'numeric | min:0'
        ];
    }
}
