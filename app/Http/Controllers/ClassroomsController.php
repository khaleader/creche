<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Classroom;
use App\Matter;
use App\Timesheet;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;

class ClassroomsController extends Controller
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
        $classrooms = Classroom::where('user_id',\Auth::user()->id)->paginate(10);
        $branches = Branch::where('user_id',\Auth::user()->id)->get();
        return view('classrooms.index')->with([
            'classrooms' => $classrooms,
            'branches' => $branches
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $matieres = Matter::where('user_id',\Auth::user()->id)->get();
        return view('classrooms.create',compact('matieres'));
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
            $request->all(),
            'nom_classe' =>$request->nom_classe,
            'code_classe' =>$request->code_classe,
            'capacite_classe' =>$request->capacite_classe,
            'niveau' =>$request->niveau,
            'branche' => $request->branche


        ],[
            'nom_classe' => 'required',
            'code_classe'=> 'required',
            'capacite_classe' => 'required|integer',

        ],
            [
                'nom_classe.required' => "le nom de la classe est requis",
                'code_classe.required' => "le Code de la classe est requis",
                'capacite_classe.required' => "la capacité de la classe est requis",
                'capacite_classe.integer' => "la capacité de la classe doit etre un nombre entier",
            ]);


        if($validator->passes())
        {

             $cr = new Classroom();
            $cr->nom_classe = $request->nom_classe;
            $cr->code_classe = $request->code_classe;
            $cr->capacite_classe = $request->capacite_classe;
            $cr->niveau = $request->niveau;
            $cr->branche = $request->branche;
            $cr->user_id = \Auth::user()->id;
            $cr->save();

           $ts = new Timesheet();
            $ts->user_id = \Auth::user()->id;
            $ts->classroom_id  = $cr->id;
            $ts->save();

           if($cr)
            {
                if(isset($request->select))
                {
                    $classe =  Classroom::where('user_id',\Auth::user()->id)->where('id',$cr->id)->first();
                    $classe->matters()->sync($request->select);
                }

            }



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
        $cr = Classroom::where('user_id',\Auth::user()->id)->where('id',$id)->first();
        return view('classrooms.show',compact('cr'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
       $cr = Classroom::where('user_id',\Auth::user()->id)->where('id',$id)->first();
        $cr->delete();
        return redirect('classrooms')->with('success',"la classe a bien été supprimé");
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
                $b =   Classroom::where('user_id',\Auth::user()->id)->where('id',$id)->first();
                $b->delete();

            }
        }
    }

    public function trierparbranche()
    {
        if(\Request::ajax())
        {
          $br =  \Input::get('branche');
           $branches = Classroom::where('user_id',\Auth::user()->id)->where('branche',$br)->get();
            foreach ($branches as $branch) {
                echo '         <tr>
                            <td><div class="minimal single-row">
                                    <div class="checkbox_liste ">
                                        <input type="checkbox"  value="'.$branch->id.' " name="select[]">

                                    </div>
                                </div></td>
                            <td> '.$branch->nom_classe.' </td>
                            <td> '. $branch->code_classe .'</td>
                            <td> '. $branch->capacite_classe.'  élèves</td>
                            <td> '. $branch->niveau .'</td>
                            <td>'. $branch->branche .'</td>

                            <td>
                                <a href="'.  action('ClassroomsController@delete',[$branch]) .'" class="actions_icons delete-classe">
                                    <i class="fa fa-trash-o liste_icons"></i></a>
                                <a href="#"><i class="fa fa-archive liste_icons"></i>
                                </a>
                            </td>

                            <td><a href=""><div  class="btn_details">Détails</div></a></td>
                        </tr>';
            }
        }
    }


}
