<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\Matter;
use App\Room;
use App\Timesheet;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PlansController extends Controller
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
        if(Carbon::now()->isMonday())
        {
            $plans = Timesheet::where('user_id',\Auth::user()->id)
                ->where('matter_id','!=',0)
                ->where('dayname','lundi')->CurrentYear()->paginate(10);
            return view('plans.index',compact('plans'));
        }elseif(Carbon::now()->isTuesday())
        {
            $plans = Timesheet::where('user_id',\Auth::user()->id)
                ->where('matter_id','!=',0)
                ->where('dayname','mardi')->CurrentYear()->paginate(10);
            return view('plans.index',compact('plans'));
        }elseif(Carbon::now()->isWednesday())
        {
            $plans = Timesheet::where('user_id',\Auth::user()->id)
                ->where('matter_id','!=',0)
                ->where('dayname','mercredi')->CurrentYear()->paginate(10);
            return view('plans.index',compact('plans'));
        }elseif(Carbon::now()->isThursday())
        {
            $plans = Timesheet::where('user_id',\Auth::user()->id)
                ->where('matter_id','!=',0)
                ->where('dayname','jeudi')->CurrentYear()->paginate(10);
            return view('plans.index',compact('plans'));
        }elseif(Carbon::now()->isFriday())
        {
            $plans = Timesheet::where('user_id',\Auth::user()->id)
                ->where('matter_id','!=',0)
                ->where('dayname','vendredi')->CurrentYear()->paginate(10);
            return view('plans.index',compact('plans'));
        }elseif(Carbon::now()->isSaturday())
        {
            $plans = Timesheet::where('user_id',\Auth::user()->id)
                ->where('matter_id','!=',0)
                ->where('dayname','samedi')->CurrentYear()->paginate(10);
            return view('plans.index',compact('plans'));
        }else{
            $plans = Timesheet::where('user_id',\Auth::user()->id)->where('matter_id','!=',0)
                ->CurrentYear()->paginate(10);
            return view('plans.index',compact('plans'));
        }



    }



    public function trierparjour()
    {
        if(\Request::ajax())
        {
            $jour_text = \Input::get('jour_text');
           $plans = Timesheet::where('user_id',\Auth::user()->id)->CurrentYear()->where('dayname',$jour_text)
                ->where('matter_id','!=',0)->get();
            foreach ($plans as $plan) {
                echo '<tr>';
                        echo'    <td> '.Classroom::where('id',$plan->classroom_id)->first()->nom_classe .'</td>';

                              echo '  <td>
                                    '.Matter::where('id',$plan->matter_id)
                                ->first()->nom_matiere .'
                                </td>';

                         echo '   <td>';
                                foreach (Matter::where('id',$plan->matter_id)->first()->lesteachers  as $item)
                                    echo $item->nom_teacher;

                       echo  '</td>';

                           echo '<td>';
                         echo substr(Carbon::parse($plan->time)->toTimeString(),0,-3);
                             echo '</td>';
                               echo '<td>';


                                  $salle =Timesheet::where("classroom_id",$plan->classroom_id)
                                                  ->where("time",$plan->time)
                                                   ->where("user_id",\Auth::user()->id)
                                                    ->where("color","#525252")
                                                      ->CurrentYear()
                                                      ->where("dayname",$plan->dayname)
                                                    ->first();
                                    if($salle)
                                        echo \Auth::user()->rooms()->where('id',$salle->room_id)->first()->nom_salle;
                          echo '</td>';

                           echo '<td>';

                                $classroom = Classroom::where('id',$plan->classroom_id)->CurrentYear()->first();
                                foreach($classroom->lesNiveaux as $niveau)
                                {
                                  echo $niveau->niveau;
                                }
                                foreach($classroom->levels as $niveau)
                                {
                                    echo $niveau->niveau;
                                }
                          echo '</td>';
                           echo '<td>';

                                $classroom = Classroom::where('id',$plan->classroom_id)->CurrentYear()->first();
                                if($classroom->branches->isEmpty())
                                    {
                                     echo '--';
                                    }else{
                                    foreach($classroom->branches as $br)
                                    {
                                      echo $br->nom_branche;
                                    }
                                }
                            echo '</td>';
                       echo ' </tr>';
            }


        }
    }


    public function trierparsalle()
    {

        if(\Request::ajax())
        {
        $room_id = \Input::get('room_id');



            $plans = Timesheet::where('user_id',\Auth::user()->id)
                ->where('matter_id','!=',0)->get();



            foreach ($plans as $plan) {
                $salle = Timesheet::where("classroom_id", $plan->classroom_id)
                    ->where("time", $plan->time)
                    ->where("user_id", \Auth::user()->id)
                    ->where("color", "#525252")
                    ->where("dayname", $plan->dayname)
                    ->CurrentYear()
                    ->first();
                if($salle->room_id == $room_id)
                {
                        echo '<tr>';
                        echo '    <td> ' . Classroom::where('id', $plan->classroom_id)->CurrentYear()->first()->nom_classe . '</td>';

                        echo '  <td>
                                    ' . Matter::where('id', $plan->matter_id)
                                ->first()->nom_matiere . '
                                </td>';

                        echo '   <td>';
                        foreach (Matter::where('id', $plan->matter_id)->first()->lesteachers as $item)
                            echo $item->nom_teacher;

                        echo '</td>';

                        echo '<td>';
                        echo substr(Carbon::parse($plan->time)->toTimeString(), 0, -3);
                        echo '</td>';
                        echo '<td>';


                        $salle = Timesheet::where("classroom_id", $plan->classroom_id)
                            ->where("time", $plan->time)
                            ->where("user_id", \Auth::user()->id)
                            ->where("color", "#525252")
                            ->CurrentYear()
                            ->where("dayname", $plan->dayname)
                            ->first();
                        if ($salle)
                            echo \Auth::user()->rooms()->where('id',$salle->room_id)->first()->nom_salle;
                        echo '</td>';

                        echo '<td>';

                        $classroom = Classroom::where('id', $plan->classroom_id)->CurrentYear()->first();
                        foreach ($classroom->lesNiveaux as $niveau) {
                            echo $niveau->niveau;
                        }
                        foreach ($classroom->levels as $niveau) {
                            echo $niveau->niveau;
                        }
                        echo '</td>';
                        echo '<td>';

                        $classroom = Classroom::where('id', $plan->classroom_id)->CurrentYear()->first();
                        if ($classroom->branches->isEmpty()) {
                            echo '--';
                        } else {
                            foreach ($classroom->branches as $br) {
                                echo $br->nom_branche;
                            }
                        }
                        echo '</td>';
                        echo ' </tr>';

                }
            }


        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(\Request::ajax())
        {

        }
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
}
