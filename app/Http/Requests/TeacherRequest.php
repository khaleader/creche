<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Input;

class TeacherRequest extends Request
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


        return[
            'nom_teacher'=> 'required',
            //'date_naissance'=> 'required',
            'fonction'=> 'onlyfonctions',
            'poste' => 'required_if:fonction,professeur|integer',
            'sexe'=> 'required',
            'email'=> 'required|unique:teachers,email',
          //  'num_fix'=> 'required',
            'num_portable'=> 'required',
           // 'adresse'=> 'required',
            'cin'=> 'required|unique:teachers,cin',
           // 'salaire'=> 'required',
        ];

    }

    public function messages()
    {
        return [
            'nom_teacher.required'=> 'Le Nom est requis',
             'date_naissance.required'=> 'Le date de naissance est requis',
            'poste.required_if'=> 'La matière est requis',
            'poste.integer' => 'vous devez choisir une matière',
            'sexe.required'=> 'Le sexe est requis',
            'email.required'=> 'L\'email  est requis',
            'num_fix.required'=> 'Le Numéro de fixe est requis',
            'num_portable.required'=> 'Le Numéro de portable est requis',
            'adresse.required'=> 'L\'adresse est requis',
            'cin.required'=> 'Le Numéro de Cin est requis',
            'salaire.required'=> 'Le salaire est requis',
            'email.unique'=> 'Cet Email est dèja pris',
            'fonction.onlyfonctions' => 'Vous devez préciser la fonction'


        ];
    }
}
