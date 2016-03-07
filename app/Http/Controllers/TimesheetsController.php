<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\Timesheet;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TimesheetsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {

        $tsheets = Classroom::where('user_id',\Auth::user()->id)->paginate(10);
        return view('timesheets.index',compact('tsheets'));
    }

    public function edit($id)
    {
      $ts = Timesheet::where('user_id',\Auth::user()->id)->where('classroom_id',$id)->first();
      $cr =  Classroom::where('user_id',\Auth::user()->id)->where('id',$id)->first();
        return view('timesheets.edit',compact('ts','cr'));
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

    public function delete($id)
    {
        $lev = Classroom::where('user_id',\Auth::user()->id)->where('id',$id)->first();
        $lev->timesheets()->delete();
        $lev->delete();
        return redirect('timesheets')->with('success',"la classe et l'emploi du temps ont bien été supprimé");
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
                $b->timesheets()->delete();
                $b->delete();

            }
        }
    }


    public function trierparbranche()
    {
        if(\Request::ajax())
        {
            $br = \Input::get('branche');
            $branches = Classroom::where('user_id', \Auth::user()->id)->where('branche', $br)->get();
            foreach ($branches as $ts) {
          echo '   <tr>
                            <td><div class="minimal single-row">
                                    <div class="checkbox_liste ">
                                        <input type="checkbox"  value="'. $ts->id .'" name="select[]">

                                    </div>
                                </div></td>
                            <td>'. $ts->nom_classe .'</td>
                            <td>'. $ts->branche .'</td>
                            <td>
                                <a href="'. action('TimesheetsController@delete',[$ts]) .'" class="actions_icons delete-ts">
                                    <i class="fa fa-trash-o liste_icons"></i></a>
                                <a href="#"><i class="fa fa-archive liste_icons"></i>
                                </a>
                            </td>
                            <td><a href="'. action('TimesheetsController@edit',[$ts]) .'">
                                    <div  class="btn_details">Détails</div></a></td>

                        </tr>';
            }
        }
    }


}
