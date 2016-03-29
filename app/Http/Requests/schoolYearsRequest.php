<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class schoolYearsRequest extends Request
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
            'champ1start'=>'required',
            'champ1end'=>'required',
            'champ2start'=>'required',
            'champ2end'=>'required',
            'champ3start'=>'required_if:TrimSemis,Trim',
            'champ3end'=>'required_if:TrimSemis,Trim',

        ];
    }

    public function messages()
    {
        return [
            'champ1start.required'=>'la date de départ de trimestre 1 est requis',
            'champ1end.required'=>'la date de fin de trimestre 1 est requis',
            'champ2start.required'=>'la date de départ de trimestre 2 est requis',
            'champ2end.required'=>'la date de fin de trimestre 2 est requis',
            'champ3start.required_if'=>'la date de départ de trimestre 3 est requis',
            'champ3end.required_if'=>'la date de fin de trimestre 3 est requis',

        ];
    }


}
