<?php

namespace App\Http\Controllers;

use App\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class StatisticsController extends Controller
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
        $count_absence = Attendance::whereRaw('EXTRACT(month from start) = ?', [Carbon::now()->month])
            ->where('user_id',\Auth::user()->id)
            ->count();
        $count_abs_normale = Attendance::whereRaw('EXTRACT(month from start) = ?', [Carbon::now()->month])
            ->where('user_id',\Auth::user()->id)
            ->where('title','Normale')
            ->count();
        $count_abs_maladie = Attendance::whereRaw('EXTRACT(month from start) = ?', [Carbon::now()->month])
            ->where('title','Maladie')
            ->where('user_id',\Auth::user()->id)
            ->count();




        return view('statistics.index')->with(
            [
                'count_absence'=>$count_absence,
                'count_abs_normale' => $count_abs_normale,
                'count_abs_maladie' => $count_abs_maladie

            ]
        );
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


    public function monthly_bills()
    {

        return view('statistics.monthly_bills');
    }



     // index attendances statistics
    public function monthly_absence()
    {
        $count = Attendance::whereRaw('EXTRACT(month from start) = ?', [Carbon::now()->month])
            ->where('user_id',\Auth::user()->id)
            ->count();

        $att = Attendance::where('user_id',\Auth::user()->id)->orderBy('start','desc')->paginate(10);
        return view('statistics.monthly_absence')->with(['count'=>$count,'att'=>$att]);
    }

     // trier en ajax raison d'absence maladie ou normale
    public function absence_raison()
    {
        if(\Request::ajax())
        {
           $status = \Input::get('status');
            $att = Attendance::where('user_id',\Auth::user()->id)
                ->where('title',$status)
                ->orderBy('start','desc')->get();

            foreach($att as $t)
            {
                if($t->child->photo)
                    $photo = asset('uploads/'.$t->child->photo);
                else
                    $photo = asset('images/no_avatar.jpg');
                if($t->title == 'Maladie')
                {
                    $class = 'label-info';
                    $text = 'Maladie';
                } else{
                    $class = 'label-primary';
                    $text = 'Normale';
                }
                echo '  <tr>
                            <td><div class="minimal single-row">
                                    <div class="checkbox_liste">
                                        <input type="checkbox" value="'. $t->id .'"  name="select[]">

                                    </div>
                                </div></td>
                            <td><img class="avatar"
                                     src="'.$photo.'"></td>
                            <td>'.  ucwords($t->child->nom_enfant) .'</td>
                            <td>'.  Carbon::parse($t->start)->format('d-m-Y') .'</td>


                                <td><span class="label '.$class.' label-mini">'.$text.'</span></td>

                            <td>
                                <a href="'.action('StatisticsController@delete_att',[$t]).'" class="actions_icons">
                                    <i class="fa fa-trash-o liste_icons"></i></a>
                                <a href="'.action('StatisticsController@archive_att',[$t]).'"><i class="fa fa-archive liste_icons"></i>
                                </a>
                            </td>

                            <td><a href="'.  action('AttendancesController@show',[$t->child->id]) .'"><div  class="btn_details">Détails</div></a></td>
                        </tr>';
            }



        }
    }
      // supprimer en ajax attendance
    public function supprimer_att()
    {
        if(\Request::ajax())
        {
            $numbers = substr( \Input::get('boxes'),0,-1);
            $ids = explode(',',$numbers);
            $ids = array_unique($ids);

            foreach($ids as $id)
            {
               $att = Attendance::findOrFail($id);
                $att->delete();
                if($att->trashed())
                {
                    $c=  Attendance::onlyTrashed()->findOrFail($id);
                    $c->forceDelete();
                }
            }



        }
    }
      //archiver en ajax attendance
    public function archiver_att()
    {
        if(\Request::ajax())
        {
            $numbers = substr( \Input::get('boxesarchives'),0,-1);
            $ids = explode(',',$numbers);
            $ids = array_unique($ids);
           foreach($ids as $id)
            {
              $att =  Attendance::findOrFail($id);
                $att->delete();
                if($att->trashed())
                {
                    echo 'oui attendance trashed';
                }
            }

        }
    }

    // supprimer par bouton click att
    public function delete_att($id)
    {
        $att =Attendance::findOrFail($id);
        $att->delete();
        if($att->trashed())
        {
            $c = Attendance::onlyTrashed()->findOrFail($id);
            $c->forceDelete();
        }
        return redirect()->back()->with('success',"l'opération de suppression a été effectué avec succès");
    }
    // archiver par bouton click att
    public function archive_att($id)
    {

        $att =Attendance::findOrFail($id);
        $att->delete();
        if($att->trashed())
        {
            return redirect()->back()->with('success',"l'opération d'archivage a été effectué avec succès");
        }

    }


    public function new_subscribers()
    {
        return view('statistics.new_subscribers');
    }


}
