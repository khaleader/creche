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


    public function monthly_bills($year,$month)
    {
      $bills =  Bill::whereRaw('EXTRACT(year from start) = ?', [$year])
          ->whereRaw('EXTRACT(month from start) = ?', [$month])
           ->where('user_id',\Auth::user()->id)
          ->orderBy('start','asc')->paginate(10);

        $count = Bill::whereRaw('EXTRACT(year from start) = ?', [$year])
           ->whereRaw('EXTRACT(month from start) = ?', [$month])
            ->where('user_id',\Auth::user()->id)
            ->count();
        return view('statistics.monthly_bills',compact('bills','count','month','year'));
    }



     // index attendances statistics
    public function monthly_absence($year,$month)
    {
        $count = Attendance::whereRaw('EXTRACT(year from start) = ?', [$year])
        ->whereRaw('EXTRACT(month from start) = ?', [$month])
            ->where('user_id',\Auth::user()->id)
            ->count();

        $att = Attendance::where('user_id',\Auth::user()->id)
            ->whereRaw('EXTRACT(year from start) = ?', [$year])
            ->whereRaw('EXTRACT(month from start) = ?', [$month])
            ->orderBy('start','desc')->paginate(10);
        return view('statistics.monthly_absence')->with(
            [
                'count'=>$count,
                'att'=>$att,
                'year'=> $year,
                'month'=>$month
            ]
        );
    }

     // trier en ajax raison d'absence maladie ou normale
    public function absence_raison()
    {
        if(\Request::ajax())
        {
           $month = \Input::get('month');
            $year = \Input::get('year');
           $status = \Input::get('status');
            $att = Attendance::where('user_id',\Auth::user()->id)
                ->whereRaw('EXTRACT(year from start) = ?', [$year])
                ->whereRaw('EXTRACT(month from start) = ?', [$month])
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
                    $text = 'Non Justifiée';
                } else{
                    $class = 'label-primary';
                    $text = 'Justifiée';
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
                              <!--  <a class="archive-att" href="'.action('StatisticsController@archive_att',[$t]).'"><i class="fa fa-archive liste_icons"></i>
                                </a>-->
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
    public function new_subscribers($year,$month) // index new subscribers
    {
        $count = Child::whereRaw('EXTRACT(year from created_at) = ?', [$year])
            ->whereRaw('EXTRACT(month from created_at) = ?', [$month])
            ->where('user_id',\Auth::user()->id)
            ->count();
       $children = Child::whereRaw('EXTRACT(year from created_at) = ?', [$year])
         ->whereRaw('EXTRACT(month from created_at) = ?', [$month])
        ->where('user_id',\Auth::user()->id)->orderBy('created_at','desc')->paginate(10);
        return view('statistics.new_subscribers',compact('children','count','year','month'));
    }


    public function trier_sexe()
    {
        if(\Request::ajax())
        {
           $year = \Input::get('year');
            $month = \Input::get('month');
            $sexe = \Input::get('sexe');
            $enfants = Child::where('user_id',\Auth::user()->id)
                ->whereRaw('EXTRACT(year from created_at) = ?', [$year])
                ->whereRaw('EXTRACT(month from created_at) = ?', [$month])
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
                        'sexe' => $user->sexe,
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
                        'sexe' => $utilisateur->sexe,
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



    public function getYearAndMonth()
    {
        if(\Request::ajax())
        {
            $year = \Input::get('year');
            $month = \Input::get('month');
            $monthtext = \Input::get('monthtext');

            //Absences selon le tri ajax

            $count_absence = Attendance::whereRaw('EXTRACT(month from start) = ?', [$month])
                ->whereRaw('EXTRACT(year from start) = ?', [$year])
                ->where('user_id',\Auth::user()->id)
                ->count();
            $count_abs_normale = Attendance::whereRaw('EXTRACT(month from start) = ?', [$month])
                ->whereRaw('EXTRACT(year from start) = ?', [$year])
                ->where('user_id',\Auth::user()->id)
                ->where('title','Normal')
                ->count();
            $count_abs_maladie = Attendance::whereRaw('EXTRACT(month from start) = ?', [$month])
                ->whereRaw('EXTRACT(year from start) = ?', [$year])
                ->where('title','Maladie')
                ->where('user_id',\Auth::user()->id)
                ->count();

            /* statistics new subscribers selon le tri ajax */
            $ns_number = Child::whereRaw('EXTRACT(month from created_at) = ?', [$month])
                ->whereRaw('EXTRACT(year from created_at) = ?', [$year])
                ->where('user_id',\Auth::user()->id)
                ->count();
            $garcons = Child::whereRaw('EXTRACT(month from created_at) = ?', [$month])
                ->whereRaw('EXTRACT(year from created_at) = ?', [$year])
                ->where('user_id',\Auth::user()->id)
                ->where('sexe','Garçon')
                ->count();
            $filles = Child::whereRaw('EXTRACT(month from created_at) = ?', [$month])
                ->whereRaw('EXTRACT(year from created_at) = ?', [$year])
                ->where('user_id',\Auth::user()->id)
                ->where('sexe','fille')
                ->count();



            /* bills par le trix ajax  */

            $count_bills =  Bill::whereRaw('EXTRACT(month from start) = ?', [$month])
                ->whereRaw('EXTRACT(year from start) = ?', [$year])
                ->where('user_id',\Auth::user()->id)
                ->count();
            $regled_bills =  Bill::whereRaw('EXTRACT(month from start) = ?', [$month])
                ->whereRaw('EXTRACT(year from start) = ?', [$year])
                ->where('user_id',\Auth::user()->id)
                ->where('status',1)
                ->count();
            $non_regled_bills =  Bill::whereRaw('EXTRACT(month from start) = ?', [$month])
                ->whereRaw('EXTRACT(year from start) = ?', [$year])
                ->where('user_id',\Auth::user()->id)
                ->where('status',0)
                ->count();


            // for counting bills
            $somme = Bill::whereRaw('EXTRACT(year from start) = ?', [$year])
               ->whereRaw('EXTRACT(month from start) = ?', [$month])
                ->where('user_id',\Auth::user()->id)
                ->sum('somme');
            $encaisse =  Bill::whereRaw('EXTRACT(year from start) = ?', [$year])
                ->whereRaw('EXTRACT(month from start) = ?', [$month])
                ->where('user_id',\Auth::user()->id)
                ->where('status',1)
                ->sum('somme');
            $reste =  Bill::whereRaw('EXTRACT(year from start) = ?', [$year])
                ->whereRaw('EXTRACT(month from start) = ?', [$month])
                ->where('user_id',\Auth::user()->id)
                ->where('status',0)
                ->sum('somme');



            echo ' <div class="row partie-up"> <div class="col-md-4">
            <section class="panel bloc">
                <div class="panel-body">
                    <a href="'. action('StatisticsController@monthly_absence',[$year,$month]) .'">
                        <div class="bloc_statistique"><img src="images/pointages.png" ><span class="count">
                        '.$count_absence .'</span><p>Cas d\'absence En '.$monthtext.' '.$year.'</p></div>
                        <div class="bloc_statistique_details">
                            <div class="bloc_statistique_d1">
                                <span class="count">'. $count_abs_normale .'</span><p>Justifiées</p>
                            </div>
                            <div class="bloc_statistique_d2">
                                <span class="count">'.  $count_abs_maladie .'</span><p>Non Justifiées</p>
                            </div>

                        </div>
                    </a>

                </div>
            </section>
        </div>
        <div class="col-md-4">
            <section class="panel bloc">
                <div class="panel-body">
                    <a href="'. action('StatisticsController@new_subscribers',[$year,$month]) .'">
                        <div class="bloc_statistique"><img src="images/inscription.png" >
                        <span class="count">'. $ns_number .'</span><p>Nouvelles inscriptions En '.$monthtext.' '.$year.'</p></div>
                        <div class="bloc_statistique_details">
                            <div class="bloc_statistique_d1">
                                <span class="count">'.$garcons.' </span><p>Garçons</p>
                            </div>
                            <div class="bloc_statistique_d2">
                                <span class="count">'. $filles .'</span><p>Filles</p>
                            </div>
                        </div>
                    </a>


                </div>
            </section>
        </div>
        <div class="col-md-4">
            <section class="panel bloc">
                <div class="panel-body">
                    <a href="'. action('StatisticsController@monthly_bills',[$year,$month]) .'">
                        <div class="bloc_statistique"><img src="images/factures.png" ><span class="count">
                        '. $count_bills.'</span><p>Factures générées En '.$monthtext.' '.$year.'</p></div>
                        <div class="bloc_statistique_details">
                            <div class="bloc_statistique_d1">
                                <span class="count">'.  $regled_bills .'</span><p>Réglées</p>
                            </div>
                            <div class="bloc_statistique_d2">
                                <span class="count">'. $non_regled_bills .'</span><p>Non réglées</p>
                            </div>

                        </div>
                    </a>


                </div>
            </section>
        </div>
        </div>
       <div class="row partie-down">
        <div class="col-md-4">
            <section class="panel bloc">
                <div class="panel-body">
                    <a href="#">
                        <div class="bloc_statistique"><img src="images/statistiques.png" >
                        <span class="count">'. $somme .' </span><p>Dhs total estimé En '.$monthtext.' '. $year .'</p></div>
                        <div class="bloc_statistique_details">
                            <div class="bloc_statistique_d1">
                                <span class="count">'. $encaisse .'</span><p>Dhs encaissé</p>
                            </div>
                            <div class="bloc_statistique_d2">
                                <span class="count">'. $reste .' </span><p>Dhs qui reste</p>
                            </div>

                        </div>
                    </a>

                </div>
            </section>
        </div>
    </div>
        ';


        }
    }

    public function statusindex()
    {
        if (\Request::ajax()) {
           $month = \Input::get('month');
            $year = \Input::get('year');
            $status = \Input::get('status');
            if ($status == 0) {
                $bills = Bill::whereRaw('EXTRACT(month from start) = ?', [$month])
                 ->whereRaw('EXTRACT(year from start) = ?', [$year])
                 ->where('status', 0)->where('user_id',\Auth::user()->id)->get();
                foreach ($bills as $bill) {
                    if($bill->child->photo)
                    {
                        $photo = asset('uploads/'.$bill->child->photo);
                    }else{
                        $photo = asset('images/'.'avatar4.jpg');
                    }

                    echo '  <tr>
                             <td><div class="minimal single-row">
                                    <div class="checkbox_liste ">
                                        <input value="'. $bill->id .'" type="checkbox"  name="select[]">
                                    </div>
                                </div></td>
                            <td>  ' . $bill->id . '</td>
                            <td><img class="avatar" src="'.$photo.'"></td>
                            <td>' . $bill->child->nom_enfant . '</td>
                            <td> ' . $bill->start->format('d-m-Y') . ' </td>
                            <td>  ' . $bill->somme . '  Dhs</td>
                            <td><span class="label label-danger label-mini">
                               Non réglée </span>
                            </td>
                          <!--  <td>
                                <a  href="' . '#'. '" class="actions_icons delete-bill">
                                    <i class="fa fa-trash-o liste_icons"></i></a>
                                <a class="archive-bill" href="' . '#' . '"><i class="fa fa-archive liste_icons"></i>
                                </a>
                            </td>-->

                            <td><a href="' . action('BillsController@details', [$bill->id]) . '"><div  class="btn_details">Détails</div></a></td>
                        </tr>';
                }

            } else {
                $bills = Bill::whereRaw('EXTRACT(month from start) = ?', [$month])
                    ->whereRaw('EXTRACT(year from start) = ?', [$year])
                  ->where('status', 1)->where('user_id',\Auth::user()->id)->get();
                foreach ($bills as $bill) {
                    if($bill->child->photo)
                        $photo =asset('uploads/'.$bill->child->photo);
                    else
                        $photo = asset('images/no_avatar.jpg');
                    echo '  <tr>
                                <td><div class="minimal single-row">
                                    <div class="checkbox_liste ">
                                        <input value="'. $bill->id .'" type="checkbox"  name="select[]">
                                    </div>
                                </div></td>
                            <td>  ' . $bill->id . '</td>
                            <td><img class="avatar" src="'.$photo.'"></td>
                            <td>' . $bill->child->nom_enfant . '</td>
                            <td> ' . $bill->start->format('d-m-Y') . ' </td>
                            <td>  ' . $bill->somme . '  Dhs</td>
                            <td><span class="label label-success label-mini">
                                réglée </span>
                            </td>
                           <!-- <td>
                                <a  href="' . '#' . '" class="actions_icons delete-bill">
                                    <i class="fa fa-trash-o liste_icons"></i></a>
                                <a class="archive-bill" href="' . '#' . '"><i class="fa fa-archive liste_icons"></i>
                                </a>
                            </td>-->

                            <td><a href="' . action('BillsController@details', [$bill->id]) . '"><div  class="btn_details">Détails</div></a></td>
                        </tr>';

                }
            }
        }
    }



}
