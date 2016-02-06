<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AddSchoolRequest extends Request
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
            'type' => 'required|integer',
            'nom_ecole' => 'required',
            'nom_responsable' =>'required',
            'sexe' => 'required',
            'tel_fix' =>'required',
            'tel_por' =>'required',
            'email_ecole' =>'required|email|unique:users,email',
            'ecole_adresse' =>'required',
            'ecole_ville' =>'required',
            'country' =>'alpha',

        ];
    }

    public function messages()
    {
        return [
            'type.integer'=> 'vous devez choisir le type',
            'nom_ecole.required'=> 'vous devez saisir un nom pour L\'ecole',
            'nom_responsable.required'=> 'vous devez saisir un nom de responsable',
            'tel_fix.required'=> 'vous devez saisir Le numéro de téléphone fixe',
            'tel_por.required'=> 'vous devez saisir Le numéro de téléphone portable',
            'email_ecole.required'=> 'vous devez saisir l\'email',
            'ecole_adresse.required'=> 'vous devez saisir l\'adresse de L\'ecole',
            'ecole_ville.required'=> 'vous devez saisir la ville de L\'ecole',
            'country.required'=> 'vous devez chosir le pays',
            'country.alpha' => 'vous devez choisir le pays'


        ];
    }
}
