<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\Child;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;




class AttendancesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('Famille',['only'=> ['showef','indexef']]);
        $this->middleware('admin',['except'=> ['showef','indexef']]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $children = \Auth::user()->children()->paginate(10);
        return view('attendances.index',compact('children'));
    }

    public function attbyalph()
    {

        if(\Request::ajax())
        {
            $caracter = \Input::get('caracter');
            $enfants =   Child::where('nom_enfant', 'LIKE', $caracter .'%')->where('user_id',\Auth::user()->id)->get();
            foreach($enfants as $enfant)
            {
                if($enfant->photo)
                    $photo = asset('uploads/'.$enfant->photo);
                else
                    $photo = asset('images/avatar4.jpg');
                echo '   <tr>
                            <td><div class="minimal single-row">
                                    <div class="checkbox_liste ">
                                        <input type="checkbox" value=" '.$enfant->id.' " >

                                    </div>
                                </div></td>
                            <td><img class="avatar" src=" '. $photo .'"></td>
                            <td>'.  $enfant->nom_enfant .'</td>
                            <td>15-09-2015 </td>
                          <!--  <td>
                                <a href="#" class="actions_icons">
                                    <i class="fa fa-trash-o liste_icons"></i></a>
                                <a href="#"><i class="fa fa-archive liste_icons"></i>
                                </a>
                            </td>-->

                            <td><a href="'.  action('AttendancesController@show',[$enfant->id])  .'"><div  class="btn_details">Détails</div></a></td>
                        </tr>';
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

        $child = Child::where('user_id',\Auth::user()->id)->where('id',$id)->first();
        if(!empty($child))
        {
            if($child->user_id == \Auth::user()->id)
            {
                $events = Attendance::where('child_id',$child->id)->get();
                foreach($events as $ev)
                {
                    if($ev['title'] == 'Normal' && $ev['child_id'] == $id)
                    {
                        $ev['title'] = 'Justifiée';

                    }elseif($ev['title'] == 'Maladie' && $ev['child_id'] == $id){
                        $ev['title'] = 'Non Justifiée';
                    }else{
                        $ev['title'] = 'Retard';
                    }
                    $ev['allDay'] = false;
                }

               // $events =array_unique($events);
              //  $events =  $child->attendances;//->whereLoose('deleted_at',null);
                    $resultat = json_encode($events);

                    $resultat = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', $resultat);


                return view('attendances.show')->with(['child'=>$child,'resultat'=>$resultat]);
            }
        }else{
           return  response('Unauthorized.', 401);
        }




    }

    public function indexef()
    {
       $children = Child::where('f_id',\Auth::user()->id)->get();
        return view('attendances.indexef',compact('children'));
    }


    // show for families registred

    public function showef($id)
    {
        $data='';
        foreach(Auth::user()->enfants as $enfant)
        {
            $data .=$enfant->id.',';
        }
        $data = explode(',',substr($data,0,-1));
        foreach($data as $d)
        {
            if($d == $id)
            {
                $child = Child::findOrFail($id);
                $events = Attendance::where('child_id',$child->id)->get();
                foreach($events as $ev)
                {
                    if($ev['title'] == 'Normal')
                    {
                        $ev['title'] = 'Justifiée';

                    }elseif($ev['title'] == 'Maladie' ){
                        $ev['title'] = 'Non Justifiée';
                    }else{
                        $ev['title'] = 'Retard';
                    }
                    $ev['allDay'] = false;
                }
              //  $events =  $child->attendances;
                $resultat = json_encode($events);
                $resultat = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', $resultat);
                return view('attendances.showef')->with(['child'=>$child,'resultat'=>$resultat]);

            }
        }
        return  response('Unauthorized.', 401);





        // $events = Attendance::where('child_id','=',$child->id)->get();

    }

    public  function  pointage()
    {
        if(\Request::ajax())
        {
            $tab = \Input::all();
            $title = $tab['title'];
            $start = $tab['start'];
            $end = $tab['end'];
            $color = $tab['color'];
            $allDay = $tab['allDay'];
            $child_id = $tab['child_id'];

            $event = new Attendance();
            $event->title = $title;
            $event->start = $start;
            $event->end = $end;
            $event->color = $color;
            $event->allDay = $allDay;
            $event->child_id = $child_id;
            $event->user_id = \Auth::user()->id;
            $event->save();

            $child =Child::findOrFail($child_id);

        }
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

    public function delatt()
    {
        $tab =  \Input::all();
           $obj = Attendance::findOrFail($tab['id']);
           $obj->delete();
           if($obj->trashed())
           {
               $att =  Attendance::onlyTrashed()->findOrFail($tab['id']);
               $att->forceDelete();
           }
       }


    public function absenceToday()
    {
        $abstoday = Attendance::whereRaw('EXTRACT(year from start) = ?', [Carbon::now()->year])
           ->whereRaw('EXTRACT(month from start) = ?', [Carbon::now()->month])
            ->whereRaw('EXTRACT(day from start) = ?', [Carbon::now()->day])
            ->where('user_id',\Auth::user()->id)
            ->paginate(10);
        $count = Attendance::whereRaw('EXTRACT(year from start) = ?', [Carbon::now()->year])
        ->whereRaw('EXTRACT(month from start) = ?', [Carbon::now()->month])
            ->whereRaw('EXTRACT(day from start) = ?', [Carbon::now()->day])
            ->where('user_id',\Auth::user()->id)
            ->groupBy('child_id')
            ->get()->count();
        return view('attendances.absenceToday',compact('abstoday','count'));
    }


    public function absence_raison_today()
    {
        if(\Request::ajax()) {
            $status = \Input::get('status');
            $att = Attendance::where('user_id', \Auth::user()->id)
                ->where('title', $status)
                ->whereRaw('EXTRACT(year from start) = ?', [Carbon::now()->year])
                ->whereRaw('EXTRACT(month from start) = ?', [Carbon::now()->month])
                ->whereRaw('EXTRACT(day from start) = ?', [Carbon::now()->day])
                ->orderBy('start', 'desc')->get();

            foreach ($att as $t) {
                if ($t->child->photo)
                    $photo = asset('uploads/' . $t->child->photo);
                else
                    $photo = asset('images/no_avatar.jpg');
                if ($t->title == 'Maladie') {
                    $class = 'label-info';
                    $text = 'Non Justifiée';
                } else {
                    $class = 'label-primary';
                    $text = 'Justifiée';
                }
                echo '  <tr>
                            <td><div class="minimal single-row">
                                    <div class="checkbox_liste">
                                        <input type="checkbox" value="' . $t->id . '"  name="select[]">

                                    </div>
                                </div></td>
                            <td><img class="avatar"
                                     src="' . $photo . '"></td>
                            <td>' . ucwords($t->child->nom_enfant) . '</td>
                            <td>' . Carbon::parse($t->start)->format('d-m-Y') . '</td>


                                <td><span class="label ' . $class . ' label-mini">' . $text . '</span></td>

                            <td>
                                <a href="' . action('StatisticsController@delete_att', [$t]) . '" class="actions_icons delete-att">
                                    <i class="fa fa-trash-o liste_icons"></i></a>
                              <!--  <a class="archive-att" href="' . action('StatisticsController@archive_att', [$t]) . '"><i class="fa fa-archive liste_icons"></i>
                                </a>-->
                            </td>

                            <td><a href="' . action('AttendancesController@show', [$t->child->id]) . '"><div  class="btn_details">Détails</div></a></td>
                        </tr>';
            }


        }

    }



}
