<?php

namespace App\Http\Controllers;

use App\Bill;
use App\Child;
use App\Events\ReglerBillEvent;
use App\SchoolYear;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;
use URL;

class BillsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function __construct()
    {
       $this->middleware('Famille',[
           'only'=>['showef','indexef','detailsef','filterByYearef','filterByMonthef','statusindexef']]);
        $this->middleware('auth');
        $this->middleware('admin',
            ['except'=>
                ['showef','indexef','detailsef','filterByYearef','filterByMonthef','statusindexef']]);

    }



    public function index()
    {

        $bills =\Auth::user()->bills()->CurrentYear()->orderBy('start','desc')->paginate(10);
        return view('bills.index', compact('bills'));
    }

    public function indexnr()
    {
        $bills =\Auth::user()->bills()->CurrentYear()->where('status',0)->paginate(10);
        return view('bills.indexnr', compact('bills'));
    }

    public function checkpassofregler()
    {
        if(\Request::ajax())
        {
            $pass =\Input::get('pass');
            if(isset($pass) && !empty($pass))
            {
                $user = \Auth::user()->teachers()->
                whereIn('fonction',['rh','Administrateur'])->whereNotNull('pass')->get();
                foreach ($user as $item) {
                    if($item->pass == $pass)
                    {
                        echo  'oui';
                        break;
                    }
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $child = Child::findOrFail($id);
        if(!empty($child))
        {
            if($child->user_id == \Auth::user()->id)
            {
                return view('bills.show', compact('child'));
            }
        }else{
           app:abort(404);
        }
    }

    // factures details
    public function details($id)
    {
        $bill = Bill::where('user_id',\Auth::user()->id)->where('id',$id)->first();
        return view('bills.details', compact('bill'));
    }

    public function detailsef($id)
    {
        $bill = Bill::where('f_id',\Auth::user()->id)->where('id',$id)->first();
        return view('bills.detailsef', compact('bill'));
    }

    // factures print

    public function imprimer($id)
    {
        $bill = Bill::findOrFail($id);
        return view('bills.print', compact('bill'));
    }

    // regler factures checboxes
    public function regler()
    {
        if (\Request::ajax()) {
            $numbers = substr(\Input::get('regler'), 0, -1);
            $ids = explode(',', $numbers);
            $ids = array_unique($ids);
            foreach ($ids as $id) {
                $bills = Bill::findOrFail($id);
                if($bills->child->Family->responsable == 1)
                    $resp =$bills->child->Family->nom_pere;
                else
                    $resp =$bills->child->Family->nom_mere;
        \Event::fire(new ReglerBillEvent(
                 $resp,
                 $bills->start->format('d-m-Y'),
                 $bills->child->nom_enfant,
                 $bills->id,
                 $bills->somme,
                 \Auth::user()->name,
                 $bills->child->Family->email_responsable,
                 $bills->child->Family->responsable
              ));
                $bills->status = 1;
                $bills->mode = \Input::get('mode');
                $bills->save();

            }
        }

    }

    // non regler factures checkboxes
    public function nonregler()
    {
        if (\Request::ajax()) {
            $numbers = substr(\Input::get('nonregler'), 0, -1);
            $ids = explode(',', $numbers);
            $ids = array_unique($ids);
            foreach ($ids as $id) {
                $bills = Bill::findOrFail($id);
                $bills->status = 0;
                $bills->save();
                echo 'oui non regle';
            }
        }
    }

    // filter status bills/show
    public function status()
    {
        if (\Request::ajax()) {
            $status = \Input::get('status');
            if ($status == 0) {

                $child = Child::findOrFail(\Input::get('id'));
                if($child->user_id == \Auth::user()->id)
                {
                    foreach ($child->bills as $bills) {
                        if ($bills->status == 0 && !$bills->deleted_at) {
                            echo ' <tr>
                            <td><div class="minimal single-row">
                                    <div class="checkbox_liste ">
                                        <input value="' . $bills->id . '" type="checkbox"  name="select[]">

                                    </div>
                                </div></td>
                            <td>' . $bills->id . ' </td>
                            <td>' . $bills->start->format('d-m-Y') . ' </td>
                            <td>' . $bills->somme . ' Dhs</td>
                            <td>
                            <span class="label label-danger  label-mini">
                                   Non Réglée </span>
                            </td>
                            <!--<td>
                                <a href="' .'#' . '" class="actions_icons delete-bill">
                                    <i class="fa fa-trash-o liste_icons"></i></a>
                                <a class="archive-bill"  href="' . '#' . '"><i class="fa fa-archive liste_icons"></i>
                                </a>
                            </td>-->
                            <td><a href="' . action('BillsController@details', [$bills->id]) . '"><div  class="btn_details">Détails</div></a></td>
                        </tr> ';
                        }
                    }
                }


            } else {
                $child = Child::findOrFail(\Input::get('id'));
                if($child->user_id == \Auth::user()->id)
                {
                    foreach ($child->bills as $bills) {
                        if ($bills->status == 1 && !$bills->deleted_at) {
                            echo ' <tr>
                            <td><div class="minimal single-row">
                                    <div class="checkbox_liste ">
                                        <input value="' . $bills->id . '" type="checkbox"  name="select[]">

                                    </div>
                                </div></td>
                            <td>' . $bills->id . ' </td>
                            <td>' . $bills->start->format('d-m-Y') . ' </td>
                            <td>' . $bills->somme . ' Dhs</td>
                            <td>
                            <span class="label label-success label-mini">
                                   Réglée </span>
                            </td>
                           <!-- <td>
                                <a href="' . '#' . '" class="actions_icons delete-bill">
                                    <i class="fa fa-trash-o liste_icons"></i></a>
                                <a class="archive-bill" href="' . '#'. '"><i class="fa fa-archive liste_icons"></i>
                                </a>
                            </td>-->
                            <td><a href="' . action('BillsController@details', [$bills->id]) . '"><div  class="btn_details">Détails</div></a></td>
                        </tr> ';
                        }
                    }
                }



            }
        }
    }


    public function statusindex()
    {
        if (\Request::ajax()) {
            $status = \Input::get('status');
            if ($status == 0) {
                $bills = Bill::where('status', 0)
                    ->where('user_id',\Auth::user()->id)
                    ->CurrentYear()
                    ->get();
                foreach ($bills as $bill) {
                      if($bill->child->photo)
                      {
                          $photo = asset('uploads/'.$bill->child->photo);
                      }else{
                          $photo = asset('images/'.'avatar4.jpg');
                      }

                    echo '  <tr>
                             <td class="no-print"><div class="minimal single-row">
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

                            <td class="no-print"><a href="' . action('BillsController@details', [$bill->id]) . '"><div  class="btn_details">Détails</div></a></td>
                        </tr>';
                }

            } else {
                $bills = Bill::where('status', 1)->where('user_id',\Auth::user()->id)->get();
                foreach ($bills as $bill) {
                    if($bill->child->photo)
                        $photo =asset('uploads/'.$bill->child->photo);
                    else
                    $photo = asset('images/no_avatar.jpg');
                    echo '  <tr>
                                <td class="no-print"><div class="minimal single-row">
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

                            <td class="no-print"><a href="' . action('BillsController@details', [$bill->id]) . '"><div  class="btn_details">Détails</div></a></td>
                        </tr>';

                }
            }
        }
    }


    // filter by month
    public function month()
    {
        if (\Request::ajax()) {
            $mois = \Input::get('month');
            $child = Child::findOrFail(\Input::get('id'));
            if($child->user_id == \Auth::user()->id)
            {
                foreach ($child->bills as $b) {
                    if ($b->status == 0 && !$b->deleted_at) {
                        $class = 'label-danger';
                        $message = 'Non Réglée';
                    } else {
                        $class = 'label-success';
                        $message = 'Réglée';
                    }
                    if ($b->start->month == $mois && !$b->deleted_at) {

                        echo ' <tr>
                            <td class="no-print"><div class="minimal single-row">
                                    <div class="checkbox_liste ">
                                        <input value="' . $b->id . '" type="checkbox"  name="select[]">

                                    </div>
                                </div></td>
                            <td>' . $b->id . ' </td>
                            <td>' . $b->start->format('d-m-Y') . ' </td>
                            <td>' . $b->somme . ' Dhs</td>
                            <td>
                            <span class="label ' . $class . ' label-mini">
                                   ' . $message . ' </span>
                            </td>
                            <!--<td>
                                <a href="' . '#'. '" class="actions_icons delete-bill">
                                    <i class="fa fa-trash-o liste_icons"></i></a>
                                <a class="archive-bill" href="' . '#' . '"><i class="fa fa-archive liste_icons"></i>
                                </a>
                            </td>-->
                            <td class="no-print"><a href="' . action('BillsController@details', [$b->id]) . '"><div  class="btn_details">Détails</div></a></td>
                        </tr> ';
                    }
                }
            }




        }
    }



    public function filterByYear()
    {
        if (\Request::ajax()) {
            $year = \Input::get('year');
            $bills = Bill::whereRaw('EXTRACT(year from start) = ?', [$year])
                ->where('user_id',\Auth::user()->id)
                ->get();
            foreach ($bills as $bill) {
                if ($bill->status == 0) {
                    $class = "label-danger";
                    $message = "Non réglée";
                } else {
                    $class = "label-success";
                    $message = "réglée";
                }
                if($bill->child->photo)
                    $photo = asset('uploads/'.$bill->child->photo);
                else
                    $photo = asset('images/no_avatar.jpg');

                echo '  <tr>
                                <td class="no-print"><div class="minimal single-row">
                                    <div class="checkbox_liste ">
                                        <input value="'. $bill->id .'" type="checkbox"  name="select[]">
                                    </div>
                                </div></td>
                            <td>  ' . $bill->id . '</td>
                            <td><img class="avatar" src="'.$photo.'"></td>
                            <td>' . $bill->child->nom_enfant . '</td>
                            <td> ' . $bill->start->format('d-m-Y') . ' </td>
                            <td>  ' . $bill->somme . '  Dhs</td>
                            <td><span class="label ' . $class . ' label-mini">
                               ' . $message . ' </span>
                            </td>
                           <!-- <td>
                                <a  href="' . '#' . '" class="actions_icons delete-bill">
                                    <i class="fa fa-trash-o liste_icons"></i></a>
                                <a class="archive-bill" href="' . '#' . '"><i class="fa fa-archive liste_icons"></i>
                                </a>
                            </td>-->

                            <td class="no-print"><a href="' . action('BillsController@details', [$bill->id]) . '"><div  class="btn_details">Détails</div></a></td>
                        </tr>';


            }


        }
    }


    public function monthindex()
    {
        if (\Request::ajax()) {
            $mois = \Input::get('month');
            $bills = Bill::whereRaw('EXTRACT(month from start) = ?', [$mois])
                ->where('user_id',\Auth::user()->id)
                ->CurrentYear()
                ->get();
            foreach ($bills as $bill) {
                if ($bill->status == 0) {
                    $class = "label-danger";
                    $message = "Non réglée";
                } else {
                    $class = "label-success";
                    $message = "réglée";
                }
                if($bill->child->photo)
                 $photo = asset('uploads/'.$bill->child->photo);
                else
                    $photo = asset('images/no_avatar.jpg');

                echo '  <tr>
                                <td class="no-print"><div class="minimal single-row">
                                    <div class="checkbox_liste ">
                                        <input value="'. $bill->id .'" type="checkbox"  name="select[]">
                                    </div>
                                </div></td>
                            <td>  ' . $bill->id . '</td>
                            <td><img class="avatar" src="'.$photo.'"></td>
                            <td>' . $bill->child->nom_enfant . '</td>
                            <td> ' . $bill->start->format('d-m-Y') . ' </td>
                            <td>  ' . $bill->somme . '  Dhs</td>
                            <td><span class="label ' . $class . ' label-mini">
                               ' . $message . ' </span>
                            </td>
                          <!--  <td>
                                <a  href="' . '#' . '" class="actions_icons delete-bill">
                                    <i class="fa fa-trash-o liste_icons"></i></a>
                                <a class="archive-bill" href="' . '#' . '"><i class="fa fa-archive liste_icons"></i>
                                </a>
                            </td>-->

                            <td class="no-print"><a href="' . action('BillsController@details', [$bill->id]) . '"><div  class="btn_details">Détails</div></a></td>
                        </tr>';


            }


        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    // delete a bill
    public function delete($id)
    {
        $bill = Bill::findOrFail($id);
        $bill->delete();
        if ($bill->trashed()) {
            Bill::onlyTrashed()->findOrFail($id)->forceDelete();
        }
        return redirect()->back()->with('success', "La Facture a bien été supprimée");
    }

    // archive a bill
    public function archive($id)
    {
        $bill = Bill::findOrFail($id);
        $bill->delete();
        if ($bill->trashed()) {
            return redirect()->back()->with('success', "La Facture a bien été archivé");
        }

    }


    // search for a child instantly in bills/index
    public function searchinst()
    {

        if (\Request::ajax()) {
           $terms =   ucfirst(\Input::get('terms'));
          $child = Child::where('nom_enfant', 'LIKE','%'. $terms .'%')
              ->where('user_id',\Auth::user()->id)
              ->CurrentYear()
              ->get();
            if($child->count())
            {
              foreach($child as $c)
              {
                  foreach ($c->bills as $bill) {
                      if ($bill->status == 0 && !$bill->deleted_at) {
                          $class = 'label-danger';
                          $message = 'Non Réglée';
                      } else {
                          $class = 'label-success';
                          $message = 'Réglée';
                      }
                      if(!empty($bill->child->photo))
                      {
                          $photo = asset('uploads/'.$bill->child->photo);
                      }   else{
                          $photo = asset('images/avatar4.jpg');
                      }
                      echo '  <tr >
                                <td class="no-print"><div class="minimal single-row">
                                    <div class="checkbox_liste ">
                                        <input value="'. $bill->id .'" type="checkbox"  name="select[]">
                                    </div>
                                </div></td>
                            <td>  ' . $bill->id . '</td>
                            <td><img class="avatar" src="'.$photo.'"></td>
                            <td>' . $bill->child->nom_enfant . '</td>
                            <td> ' . $bill->start->format('d-m-Y') . ' </td>
                            <td>  ' . $bill->somme . '  Dhs</td>
                            <td><span class="label ' . $class . ' label-mini">
                               ' . $message . ' </span>
                            </td>
                           <!-- <td>
                                <a  href="' . '#' . '" class="actions_icons delete-bill">
                                    <i class="fa fa-trash-o liste_icons"></i></a>
                                <a class="archive-bill" href="' . '#' . '"><i class="fa fa-archive liste_icons"></i>
                                </a>
                            </td>-->

                            <td class="no-print"><a href="' . action('BillsController@details', [$bill->id]) . '"><div  class="btn_details">Détails</div></a></td>
                        </tr>';

                  }
              }
            }
            else{
                 $children =  Child::where('user_id',\Auth::user()->id)->get();
                  foreach($children as $child)
                  {
                      foreach ($child->bills as $bill) {
                          if ($bill->status == 0 && !$bill->deleted_at) {
                              $class = 'label-danger';
                              $message = 'Non Réglée';
                          } else {
                              $class = 'label-success';
                              $message = 'Réglée';
                          }
                          if(!empty($bill->child->photo))
                          {
                              $photo = asset('uploads/'.$bill->child->photo);
                          }   else{
                              $photo = asset('images/avatar4.jpg');
                          }

                          echo '  <tr>
                                   <td class="no-print"><div class="minimal single-row">
                                    <div class="checkbox_liste ">
                                        <input value="'. $bill->id .'" type="checkbox"  name="select[]">
                                    </div>
                                </div></td>
                            <td>  ' . $bill->id . '</td>
                            <td><img class="avatar" src="'.$photo.'"></td>
                            <td>' . $bill->child->nom_enfant . '</td>
                            <td> ' . $bill->start->format('d-m-Y') . ' </td>
                            <td>  ' . $bill->somme . '  Dhs</td>
                            <td><span class="label ' . $class . ' label-mini">
                               ' . $message . ' </span>
                            </td>
                           <!-- <td>
                                <a  href="' . '#' . '" class="actions_icons delete-bill">
                                    <i class="fa fa-trash-o liste_icons"></i></a>
                                <a class="archive-bill" href="' . '#'. '"><i class="fa fa-archive liste_icons"></i>
                                </a>
                            </td>-->

                            <td class="no-print"> <a href="' . '#' . '"><div  class="btn_details">Détails</div></a></td>
                        </tr>';

                      }

                  }


            }

        }


    }


/********************************* Compte Famille  **************************/
    // only famille account

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
                return view('bills.showef',compact('child'));
            }
        }
        return  response('Unauthorized.', 401);
    }



    public function indexef()
    {
        $data='';
        foreach(Auth::user()->enfants as $enfant)
        {
            $data .=$enfant->id.',';
        }
        $data = explode(',',substr($data,0,-1));
       $enfant = Child::where('f_id',\Auth::user()->id)->get();
        return view('bills.indexef',compact('enfant'));
       /* foreach($data as $d)
        {

                $child = Child::where('id',$d)->get();


        }
        return  response('Unauthorized.', 401);*/
    }


    public function filterByYearef()
    {
        if (\Request::ajax()) {
            $year = \Input::get('year');

            $bills = Bill::whereRaw('EXTRACT(year from start) = ?', [$year])
                ->where('f_id',\Auth::user()->id)
                ->get();
            foreach ($bills as $bill) {
                if ($bill->status == 0) {
                    $class = "label-danger";
                    $message = "Non réglée";
                } else {
                    $class = "label-success";
                    $message = "réglée";
                }
                if($bill->child->photo)
                    $photo = asset('uploads/'.$bill->child->photo);
                else
                    $photo = asset('images/no_avatar.jpg');

                echo '              <tr>
                                    <td><div class="minimal single-row">
                                        </div></td>
                                    <td>'. $bill->id .'</td>
                                    <td>'. $bill->start->format('d-m-Y') .'</td>
                                    <td>'. $bill->somme .' Dhs</td>
                                    <td><span class="label '. $class .' label-mini">
                                   '. $message .'   </span>
                                    </td>
                                    <td>   '. $bill->child->nom_enfant  .'</td>

                                    <td><a href="'.  action('BillsController@detailsef',[$bill->id]) .'"><div  class="btn_details">Détails</div></a></td>
                                </tr>';


            }


        }
    }



    public function filterByMonthef()
    {
        if (\Request::ajax()) {
            $month = \Input::get('month');

            $bills = Bill::whereRaw('EXTRACT(month from start) = ?', [$month])
                ->where('f_id',\Auth::user()->id)
                ->get();
            foreach ($bills as $bill) {
                if ($bill->status == 0) {
                    $class = "label-danger";
                    $message = "Non réglée";
                } else {
                    $class = "label-success";
                    $message = "réglée";
                }
                if($bill->child->photo)
                    $photo = asset('uploads/'.$bill->child->photo);
                else
                    $photo = asset('images/no_avatar.jpg');

                echo '     <tr>
                                    <td><div class="minimal single-row">
                                        </div></td>
                                    <td>'. $bill->id .'</td>
                                    <td>'. $bill->start->format('d-m-Y') .'</td>
                                    <td>'. $bill->somme .' Dhs</td>
                                    <td><span class="label '. $class .' label-mini">
                                   '. $message .'   </span>
                                    </td>
                                    <td>   '. $bill->child->nom_enfant  .'</td>

                                    <td><a href="'.  action('BillsController@detailsef',[$bill->id]) .'"><div  class="btn_details">Détails</div></a></td>
                                </tr>';


            }


        }
    }





    public function statusindexef()
    {
        if (\Request::ajax()) {
            $status = \Input::get('status');
            if ($status == 0) {
                $bills = Bill::where('status', 0)->where('f_id',\Auth::user()->id)->get();
                foreach ($bills as $bill) {
                    if ($bill->status == 0) {
                        $class = "label-danger";
                        $message = "Non réglée";
                    } else {
                        $class = "label-success";
                        $message = "réglée";
                    }
                    if($bill->child->photo)
                    {
                        $photo = asset('uploads/'.$bill->child->photo);
                    }else{
                        $photo = asset('images/'.'avatar4.jpg');
                    }

                    echo '     <tr>
                                    <td><div class="minimal single-row">
                                        </div></td>
                                    <td>'. $bill->id .'</td>
                                    <td>'. $bill->start->format('d-m-Y') .'</td>
                                    <td>'. $bill->somme .' Dhs</td>
                                    <td><span class="label '. $class .' label-mini">
                                   '. $message .'   </span>
                                    </td>
                                    <td>   '. $bill->child->nom_enfant  .'</td>

                                    <td><a href="'.  action('BillsController@detailsef',[$bill->id]) .'"><div  class="btn_details">Détails</div></a></td>
                                </tr>';
                }

            } else {
                $bills = Bill::where('status', 1)->where('f_id',\Auth::user()->id)->get();
                foreach ($bills as $bill) {
                    if ($bill->status == 0) {
                        $class = "label-danger";
                        $message = "Non réglée";
                    } else {
                        $class = "label-success";
                        $message = "réglée";
                    }
                    if($bill->child->photo)
                        $photo =asset('uploads/'.$bill->child->photo);
                    else
                        $photo = asset('images/no_avatar.jpg');

                    echo '     <tr>
                                    <td><div class="minimal single-row">
                                        </div></td>
                                    <td>'. $bill->id .'</td>
                                    <td>'. $bill->start->format('d-m-Y') .'</td>
                                    <td>'. $bill->somme .' Dhs</td>
                                    <td><span class="label '. $class .' label-mini">
                                   '. $message .'   </span>
                                    </td>
                                    <td>   '. $bill->child->nom_enfant  .'</td>

                                    <td><a href="'.  action('BillsController@detailsef',[$bill->id]) .'"><div  class="btn_details">Détails</div></a></td>
                                </tr>';
                }
            }
        }
    }

    /*****************Export excel and pdf **************************
     * @param $ids
     */

          public function exportExcel($ids =null)
          {
             $ids =  explode(',',substr($ids,0,-1));
               $ids =   array_unique($ids);

                  $model = Bill::whereIn('id',$ids)->where('user_id', \Auth::user()->id)->get(['id', 'child_id', 'start', 'somme', 'status']);
                  Excel::create('La liste des Factures', function ($excel) use ($model) {
                      $excel->sheet('La liste des Factures', function ($sheet) use ($model) {
                          foreach ($model as $bill) {
                              if ($bill->status == 0) {

                                  $bill->status = 'Non Réglée';
                              } else {
                                  $bill->status = 'Réglée';
                              }
                              $bill->child_id = Child::where('id', $bill->child_id)->first()->nom_enfant;

                          }

                          $sheet->setWidth('A', 20);
                          $sheet->setWidth('B', 20);
                          $sheet->setWidth('C', 20);
                          $sheet->setWidth('D', 20);
                          $sheet->setWidth('E', 20);
                          $sheet->fromModel($model);
                          $sheet->setStyle(array(
                              'font' => array(
                                  'name' => 'Calibri',
                                  'size' => 13,
                              )
                          ));
                          $sheet->setAllBorders('thin');
                          $sheet->cells('A1:E1', function ($cells) {
                              $cells->setBackground('#97efee');

                              $cells->setFont(array(
                                  'family' => 'Calibri',
                                  'size' => '14',
                                  'bold' => true
                              ));
                          });
                          $sheet->row(1, array(
                              'Num De Facture', 'Nom de l\'élève', 'Date', 'Montant', 'Statut'
                          ));

                      });
                  })->export('xls');

              }
            public function exportPdf($ids = null)
            {
                $ids =  explode(',',substr($ids,0,-1));
                $ids =   array_unique($ids);


                    $model = Bill::whereIn('id',$ids)->where('user_id', \Auth::user()->id)->get(['id','child_id','start','somme','status']);
                    Excel::create('La liste des Factures', function ($excel) use ($model,$ids) {
                        $excel->sheet('La liste des Factures', function ($sheet) use ($model,$ids) {
                            foreach ($model as $bill) {
                                $bill->date = $bill->start->toDateString();

                                if ($bill->status == 0) {

                                    $bill->status = 'Non Réglée';
                                } else {
                                    $bill->status = 'Réglée';
                                }
                                $bill->child_id = Child::where('id',$bill->child_id)->first()->nom_enfant;
                                unset($bill->start);
                            }

                            $sheet->setWidth('A',15);
                            $sheet->setWidth('B',15);
                            $sheet->setWidth('C',15);
                            $sheet->setWidth('D',15);
                            $sheet->setWidth('E',15);
                            $sheet->fromModel($model);





                            $sheet->setAllBorders('thin');
                            $sheet->setFontFamily('OpenSans');
                            $sheet->setFontSize(13);
                            $sheet->setFontBold(false);
                            $sheet->setAllBorders('thin');

                            for($i = 1; $i <= count($ids) +1 ; $i++)
                            {
                                $sheet->row($i,function($rows){
                                    $rows->setFontColor('#556b7b');
                                    $rows->setAlignment('center');
                                });
                            }


                            $sheet->cells('A1:E1',function($cells){
                                $cells->setBackground('#e9f1f3');
                                $cells->setFontColor('#556b7b');

                                $cells->setFont(array(
                                    'family'     => 'OpenSans',
                                    'size'       => '15',
                                    'bold'       =>  true,
                                ));
                            });
                            $sheet->row(1, array(
                                'Num De Facture',  'Nom de l\'élève',  'Somme', 'Statut','Date'
                            ));

                        });
                    })->export('pdf');

            }








}