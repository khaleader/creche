<?php

namespace App\Http\Controllers;

use App\Matter;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;


class MattersController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }



    public function index()
    {
        $matters = Matter::where('user_id',\Auth::user()->id)->paginate(10);
       return view('matters.index',compact('matters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('matters.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make([

            'nom_matiere' =>$request->nom_matiere,
            'code_matiere' =>$request->code_matiere,
             'color' => $request->color
        ],[
            'nom_matiere' => 'required',
            'code_matiere'=> 'required',
            'color' => 'required'
        ],
            [
                'nom_matiere.required' => "le nom de la matière est requis",
                'code_matiere.required' => "le Code de la matière est requis",
                'color.required' => 'la couleur de la matière est requis'
            ]);


        if($validator->passes())
        {

            Matter::create([
                'nom_matiere'=> $request->nom_matiere,
                'code_matiere' => $request->code_matiere,
                'color' => '#'.$request->color,
                'user_id'=>\Auth::user()->id
            ]);

            return redirect()->back()->with('success','Informations bien enregistrées');
        }else{
            return redirect()->back()->withErrors($validator);
        }



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $matiere = Matter::where('user_id',\Auth::user()->id)->where('id',$id)->first();
        return view('matters.show',compact('matiere'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $matter =  Matter::where('user_id',\Auth::user()->id)->where('id',$id)->first();
        return view('matters.edit',compact('matter'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'nom_matiere' => 'required',
            'code_matiere'=> 'required',
            'color' => 'required'
        ],
            [
                'nom_matiere.required' => "le nom de la matière est requis",
                'code_matiere.required' => "le Code de la matière est requis",
                'color.required' => 'la couleur de la matière est requis'
            ]
            );
        if($validator->passes())
        {

            $l =  Matter::where('user_id',\Auth::user()->id)->where('id',$id)->first();
            $l->nom_matiere = $request->nom_matiere;
                $l->code_matiere = $request->code_matiere;
                $l->color = '#'.$request->color;
                $l->user_id =\Auth::user()->id;
                 $l->save();
            $l->save();
            return redirect()->back()->with('success','Les Informations Ont bien été Enregistrés');
        }else{
            return redirect()->back()->withErrors($validator);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function delete($id)
    {
        $cr = Matter::where('user_id',\Auth::user()->id)->where('id',$id)->first();
        $cr->delete();
        return redirect('matters')->with('success',"la Matière a bien été supprimé");
    }
    public function supprimer()
    {
        if(\Request::ajax())
        {
            $numbers = substr( \Input::get('boxes'),0,-1);
            $ids = explode(',',$numbers);
            $ids = array_unique($ids);
            foreach($ids as $id)
            {
                $b =   Matter::where('user_id',\Auth::user()->id)->where('id',$id)->first();
                $b->delete();
            }
        }
    }
}
