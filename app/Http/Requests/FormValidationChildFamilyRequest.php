<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class FormValidationChildFamilyRequest extends Request
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
            'nom_enfant'=>'required|min:3',
            'date_naissance'=>'required',
            'photo'=>'image',
            'nom_pere'=>'required|min:3',
            'nom_mere'=>'required|min:3',
            'email_responsable'=>'required|email|unique:families,email_responsable',
            'adresse'=>'required',
            'numero_fixe'=>'required',
            'numero_portable'=>'required',
            'cin'=>'required|alpha_num'
        ];
    }

    public function messages()
    {
        return [
          'nom_enfant.required' => 'Le Nom de L\'enfant est obligatoire',
           'date_naissance.required' => 'La Date de Naissance est Obligatoire',
            'photo.required' => 'La Photo de L\'enfant est obligatoire',
           'nom_pere.required' => 'Le Nom du Père est obligatoire',
            'nom_mere.required' => 'Le Nom de Mère est obligatoire',
            'email_responsable.required'=> "Le champ Email est obligatoire",
            'email_responsable.unique' => 'Cet Email est dèja pris',
            'email_responsable.email' => 'Ce Champs doit Etre de Type Email',
            'adresse.required' => "L'adresse est obligatoire",
            'numero_fixe.required' => 'Le Numero fixe est obligatoire',
            'numero_portable.required' => "Le Numero Portable est obligatoire",
            'cin.required' => "Le Numéro CIN est obligatoire"
        ];
    }



}
