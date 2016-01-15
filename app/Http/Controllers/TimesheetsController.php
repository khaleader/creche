<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\Timesheet;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TimesheetsController extends Controller
{



    public function index()
    {

        $tsheets = Classroom::where('user_id',\Auth::user()->id)->paginate(10);
        return view('timesheets.index',compact('tsheets'));
    }

    public function edit($id)
    {
      $ts = Timesheet::where('user_id',\Auth::user()->id)->where('classroom_id',$id)->first();
        return view('timesheets.edit',compact('ts'));
    }

    public function enregistrer()
    {
        if(\Request::ajax())
        {

            $color =\Input::get('color');
          $time =  \Input::get('time');
            $dayname =  \Input::get('dayname');
           $cr_id = \Input::get('cr_id');
           $mat = \Input::get('matiere');



           if($dayname ==  'lundi')
           {
              $ts = new Timesheet();
               $ts->lundi = $dayname;
               $ts->classroom_id = $cr_id;
               $ts->user_id = \Auth::user()->id;
               $ts->time = $time;
               $ts->matiere = $mat;
               $ts->color = $color;
               $ts->save();
           }elseif($dayname ==  'mardi'){
               $ts = new Timesheet();
               $ts->mardi = $dayname;
               $ts->classroom_id = $cr_id;
               $ts->user_id = \Auth::user()->id;
               $ts->time = $time;
               $ts->matiere = $mat;
               $ts->color = $color;
               $ts->save();
           }
           elseif($dayname ==  'mercredi'){
               $ts = new Timesheet();
               $ts->mercredi = $dayname;
               $ts->classroom_id = $cr_id;
               $ts->user_id = \Auth::user()->id;
               $ts->time = $time;
               $ts->matiere = $mat;
               $ts->color = $color;
               $ts->save();
           }
           elseif($dayname ==  'jeudi'){
               $ts = new Timesheet();
               $ts->jeudi = $dayname;
               $ts->classroom_id = $cr_id;
               $ts->user_id = \Auth::user()->id;
               $ts->time = $time;
               $ts->matiere = $mat;
               $ts->color = $color;
               $ts->save();
           }
           elseif($dayname ==  'vendredi'){
               $ts = new Timesheet();
               $ts->vendredi = $dayname;
               $ts->classroom_id = $cr_id;
               $ts->user_id = \Auth::user()->id;
               $ts->time = $time;
               $ts->matiere = $mat;
               $ts->color = $color;
               $ts->save();
           }
           elseif($dayname ==  'samedi'){
               $ts = new Timesheet();
               $ts->samedi = $dayname;
               $ts->classroom_id = $cr_id;
               $ts->user_id = \Auth::user()->id;
               $ts->time = $time;
               $ts->matiere = $mat;
               $ts->color = $color;
               $ts->save();
           }

        }
    }

    public function del()
    {
        if(\Request::ajax())
        {
          $id =   \Input::get('id');
           $ok = Timesheet::where('user_id',\Auth::user()->id)->where('id',$id)->first();
            $ok->delete();
        }
    }


}
