<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\Child;
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
                            <td>
                                <a href="#" class="actions_icons">
                                    <i class="fa fa-trash-o liste_icons"></i></a>
                                <a href="#"><i class="fa fa-archive liste_icons"></i>
                                </a>
                            </td>

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



}
