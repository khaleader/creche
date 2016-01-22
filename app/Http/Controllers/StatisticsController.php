<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\Bill;
use App\Child;
use App\Family;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Mail;

class StatisticsController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest',['only'=>'forgetpass']);
        $this->middleware('auth',['except'=>'forgetpass']);
        $this->middleware('admin',['except'=> 'forgetpass']);
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
            ->where('title','Normal')
            ->count();
        $count_abs_maladie = Attendance::whereRaw('EXTRACT(month from start) = ?', [Carbon::now()->month])
            ->where('title','Maladie')
            ->where('user_id',\Auth::user()->id)
            ->count();

        /* statistics new subscribers */
        $ns_number = Child::whereRaw('EXTRACT(month from created_at) = ?', [Carbon::now()->month])
            ->where('user_id',\Auth::user()->id)
            ->count();
        $garcons = Child::whereRaw('EXTRACT(month from created_at) = ?', [Carbon::now()->month])
            ->where('user_id',\Auth::user()->id)
            ->where('sexe','Garçon')
            ->count();
        $filles = Child::whereRaw('EXTRACT(month from created_at) = ?', [Carbon::now()->month])
            ->where('user_id',\Auth::user()->id)
            ->where('sexe','fille')
            ->count();

        /* bills */

            $count_bills =  Bill::whereRaw('EXTRACT(month from start) = ?', [Carbon::now()->month])
                  ->where('user_id',\Auth::user()->id)
                  ->count();
            $regled_bills =  Bill::whereRaw('EXTRACT(month from start) = ?', [Carbon::now()->month])
            ->where('user_id',\Auth::user()->id)
            ->where('status',1)
            ->count();
             $non_regled_bills =  Bill::whereRaw('EXTRACT(month from start) = ?', [Carbon::now()->month])
            ->where('user_id',\Auth::user()->id)
            ->where('status',0)
            ->count();


            $somme =  Bill::whereRaw('EXTRACT(month from start) = ?', [Carbon::now()->month])
             ->where('user_id',\Auth::user()->id)
              ->sum('somme');
           $encaisse =  Bill::whereRaw('EXTRACT(month from start) = ?', [Carbon::now()->month])
            ->where('user_id',\Auth::user()->id)
               ->where('status',1)
                ->sum('somme');
           $reste =  Bill::whereRaw('EXTRACT(month from start) = ?', [Carbon::now()->month])
               ->where('user_id',\Auth::user()->id)
               ->where('status',0)
               ->sum('somme');




        return view('statistics.index')->with(
            [
                'count_absence'=>$count_absence,
                'count_abs_normale' => $count_abs_normale,
                'count_abs_maladie' => $count_abs_maladie,
                'ns_number' =>$ns_number,
                'garcons' => $garcons,
                'filles' => $filles,
                'count_bills' => $count_bills,
                'regled_bills' => $regled_bills,
                'non_regled_bills' => $non_regled_bills,
                'somme' =>$somme,
                'encaisse' =>$encaisse,
                'reste' =>$reste




            ]
        );
    }


    public function gestion()
    {
        return view('statistics.gestion');
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
      $bills =  Bill::whereRaw('EXTRACT(month from start) = ?', [Carbon::now()->month])
        ->where('user_id',\Auth::user()->id)->orderBy('start','asc')->paginate(10);

        $count = Bill::whereRaw('EXTRACT(month from start) = ?', [Carbon::now()->month])
            ->where('user_id',\Auth::user()->id)
            ->count();
        return view('statistics.monthly_bills',compact('bills','count'));
    }



     // index attendances statistics
    public function monthly_absence()
    {
        $count = Attendance::whereRaw('EXTRACT(year from start) = ?', [Carbon::now()->year])
        ->whereRaw('EXTRACT(month from start) = ?', [Carbon::now()->month])
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
                    $text = 'Normal';
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
                                <a href="'.action('StatisticsController@delete_att',[$t]).'" class="actions_icons delete-att">
                                    <i class="fa fa-trash-o liste_icons"></i></a>
                                <a class="archive-att" href="'.action('StatisticsController@archive_att',[$t]).'"><i class="fa fa-archive liste_icons"></i>
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




    /*          new subscribers             */
    public function new_subscribers() // index new subscribers
    {
        $count = Child::whereRaw('EXTRACT(month from created_at) = ?', [Carbon::now()->month])
            ->where('user_id',\Auth::user()->id)->count();
       $children = Child::whereRaw('EXTRACT(month from created_at) = ?', [Carbon::now()->month])
        ->where('user_id',\Auth::user()->id)->orderBy('created_at','desc')->paginate(10);
        return view('statistics.new_subscribers',compact('children','count'));
    }


    public function trier_sexe()
    {
        if(\Request::ajax())
        {
            $sexe = \Input::get('sexe');
            $enfants = Child::where('user_id',\Auth::user()->id)
                ->where('sexe',$sexe)
                ->orderBy('created_at','desc')->get();

            foreach($enfants as $enfant)
            {
                foreach($enfant->bills as $e)
                {
                    if($e->status == 1)
                        $class = 'label-success';
                    else
                        $class = 'label-danger';
                }
                if($enfant->photo)
                    $photo =  asset('uploads/'.$enfant->photo);
                else
                    $photo =  asset('images/no_avatar.jpg');

                echo ' <tr>
                            <td><div class="minimal single-row">
                                    <div class="checkbox_liste ">
                                        <input type="checkbox" name="select[]" value="'.$enfant->id.'">

                                    </div>
                                </div></td>
                            <td><img class="avatar" src=" '. $photo .' "></td>
                            <td>'. $enfant->nom_enfant .'</td>
                            <td>'.  $enfant->date_naissance->format('d-m-Y') .' </td>
                            <td><span class="label '.$class.' label-mini"><i class="fa fa-money"></i></span></td>
                            <td>
                                <a href=" '.action('ChildrenController@delete',[$enfant]).' " class="actions_icons delete-child">
                                    <i class="fa fa-trash-o liste_icons"></i></a>
                                <a class="archive-child" href="'.action('ChildrenController@archive',[$enfant]).'"><i class="fa fa-archive liste_icons"></i>
                                </a>
                            </td>

                            <td><a href="'. action('ChildrenController@show',[$enfant->id]).'"><div  class="btn_details">Détails</div></a></td>
                        </tr>';
            }




        }
    }


    // forget pass login page

    public function forgetpass()
    {
        if(\Request::ajax())
        {

            $cin =  \Input::get('cin');
            if(isset($cin) && !empty($cin))
            {
              $lacarte =  Family::where('cin',$cin)->first();
                if($lacarte)
                {
                    $pass_without =  str_random(6);
                     $user =   User::where('email',$lacarte->email_responsable)->first();
                    $user->password = \Hash::make($pass_without);
                    $user->save();
                    $info = [
                        'email' => $user->email,
                        'new_password'=> $pass_without,
                        'name' => $user->nom_responsable,
                        'ecole' => $user->name,
                        'responsable' => $lacarte->responsable,
                        'date' => Carbon::now()->toDateString()

                    ];
                    Mail::queue('emails.forgetpass',$info,function($message) use ($info){

                        $message->to($info['email'],'ok')->from('creche@gmail.com')->subject('Bienvenue  !');

                    });
                    echo 'Votre Nouveau mot de pass a bien été envoyé à votre email';
                   }else{
                    echo 'Le Numéro de Cin fourni est Incorrect';
                    }



            }else{

             $email = \Input::get('email');
              $email = User::where('email',$email)->whereIn('type',['famille','ecole'])->first();
             if($email)
             {
                if($email->type == 'famille')
                {
                    echo 'famille';
                }elseif($email->type == 'ecole'){
                   $utilisateur = User::where('email',$email->email)->where('type','ecole')->first();
                    $pass_without =  str_random(6);
                    $utilisateur->password = \Hash::make($pass_without);
                    $utilisateur->save();
                    $infor = [
                        'email' => $utilisateur->email,
                        'new_password'=> $pass_without,
                        'name' => $utilisateur->nom_responsable,
                        'ecole' => $utilisateur->name,
                        'date' => Carbon::now()->toDateString()

                    ];
                    Mail::queue('emails.forgetpass',$infor,function($message) use ($infor){

                        $message->to($infor['email'],'ok')->from('creche@gmail.com')->subject('Bienvenue  !');

                    });
                    echo 'Votre Nouveau mot de pass a bien été envoyé à votre email';

                }

              /*  Mail::send('emails.school',$info,function($message){

                    $message->to($this->email,'ok')->from('creche@gmail.com')->subject('Bienvenue  !');

                });*/
            }else{
                       echo 'cet Email est incorrect';
            }

            }
        }
    }



}
