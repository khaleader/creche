<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ajouterEnfantRequest extends Request
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
            'nom_enfant'=> 'required',
            'date_naissance'=>'required',
            'photo'=>'image',
            'pere' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'nom_enfant.required' => 'Le Nom de L\'enfant est obligatoire',
            'date_naissance.required' => 'La Date de Naissance est Obligatoire',
            'photo.required' => 'La Photo de L\'enfant est obligatoire',
            'pere.integer' => 'vous devez Choisir Un Parent',
            'mere.integer' => 'vous devez Choisir Un Parent',

        ];
    }

}
