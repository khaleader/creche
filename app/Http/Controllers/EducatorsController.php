<?php

namespace App\Http\Controllers;

use App\Classroom;
use DB;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class EducatorsController extends Controller
{
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
         // 1 of teacher
        // 2 of matiere
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
        return redirect()->back();



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
                        <select name="teacher[]" class="form_ajout_input">
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
