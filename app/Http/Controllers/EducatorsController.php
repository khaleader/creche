<?php

namespace App\Http\Controllers;

use App\Classroom;
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
        //
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
                    <div class="form_ajout">
                        <select class="form_ajout_input" placeholder="Choisissez un professeur">
                        ';
                           foreach($m->teachers as $t)
                           {
                               echo '<option>'.$t->nom_teacher.'</option>';
                           }


                 echo  '</select>

                    </div>
                </div>';
            }



        }
    }


}
