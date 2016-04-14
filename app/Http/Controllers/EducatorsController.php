<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\Teacher;
use DB;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;

class EducatorsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
       $cr = Classroom::find(8);
      /*  DB::table('classroom_matter_teacher')->insert([
           'classroom_id'=> 8,
            'matter_id' => 12,
            'teacher_id' => 3

        ]);
        foreach($cr->teachers as $mat)
        {
            dd($mat->nom_teacher);
        }*/
     return view('educators.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'teacher' =>$request->teacher,
            'matiere' =>$request->matiere,
            'classe' =>$request->classe,


        ], [
            'teacher' => 'required',
            'matiere' => 'required',
            'classe' => 'required',
        ],
            [
                'teacher.required' => "le prof est requis",
                'matiere.required' => 'la matiere est requis',
                'classe.required' => 'la classe est requis',

            ]);
        if($validator->passes())
        {
            foreach($request->teacher as $t)
            {
                $array =  explode(',',$t);
                $check =  DB::table('classroom_matter_teacher')
                    ->where('classroom_id',$request->classe)
                    ->where('teacher_id',$array[0])
                    ->where('matter_id',$array[1])
                    ->where('user_id',\Auth::user()->id)
                    ->first();
                if(!$check)
                {
                    DB::table('classroom_matter_teacher')->insert([
                        'classroom_id'=> $request->classe,
                        'teacher_id' => $array[0],
                        'matter_id' => $array[1],
                        'user_id' => \Auth::user()->id
                    ]);
                }

            }
            return redirect()->back()->with('success',"Répartition Réussie");
        }else{
            return redirect()->back()->withErrors($validator);
        }





    }

    public function enregistrer(Request $request)
    {
             //dd($request->all());
               $validator = Validator::make([
            $request->all(),

        ],[
            'teacher' => 'integer',

        ],
            [
                'teacher.integer' => "Le professeur est requis",
            ]);
        if($validator->passes() && !is_null($request->matter))
        {
           $yes = DB::table('classroom_matter')->where('classroom_id',$request->cr)
                ->where('matter_id',$request->matter)->first();
            if(!$yes)
            {
                DB::table('classroom_matter')->insert([
                   'classroom_id' => $request->cr,
                    'matter_id'=> $request->matter
                ]);

            }



            $check =  DB::table('classroom_matter_teacher')
                ->where('classroom_id',$request->cr)
                ->where('teacher_id',$request->teacher)
                ->where('matter_id',$request->matter)
                ->where('user_id',\Auth::user()->id)
                ->first();
            if(!$check)
            {
                DB::table('classroom_matter_teacher')->insert([
                    'classroom_id'=> $request->cr,
                    'teacher_id' => $request->teacher,
                    'matter_id' => $request->matter,
                    'user_id' => \Auth::user()->id
                ]);


            }else{
                return redirect()->back()->withErrors(['dèja enregsitré']);
            }
            return redirect()->back();
        }else{
            return redirect()->back()->withErrors(['vous devez choisir un professeur']);
        }



    }

    public function getmatters()
    {
        if(\Request::ajax()) {
            $value = \Input::get('value');
           $teacher = Teacher::where('user_id',\Auth::user()->id)
               ->where('id',$value)->first();
            foreach ($teacher->matters as $item) {
                echo '<option value="'.$item->id.'">'.$item->nom_matiere.'</option>';
           }

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
        //
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


    public function getmatieres()
    {
        if(\Request::ajax())
        {
          $value =  \Input::get('value');
           $cr = Classroom::where('user_id',\Auth::user()->id)->where('id',$value)->first();
            foreach($cr->matters as $m)
            {
   echo '   <div class="form_champ">
                    <label for="cname" class="control-label col-lg-3">'.$m->nom_matiere.'</label>
                    <input type="hidden" value="'.$m->id.'" name="matiere[]">
                    <div class="form_ajout">
                        <select  name="teacher[]" class="form_ajout_input prof">
                        ';
                           foreach($m->teachers as $t)
                           {
                               echo '<option value="'.$t->id.','.$m->id.'">'.$t->nom_teacher.'</option>';
                           }


                 echo  '</select>

                    </div>
                </div>';
            }



        }
    }


}
