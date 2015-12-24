<?php

namespace App\Http\Controllers;

use App\Bill;
use App\Child;
use App\Events\ReglerBillEvent;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class BillsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function __construct()
    {
       $this->middleware('Famille',['only'=>['showef']]);
        $this->middleware('auth');
        $this->middleware('admin',['except'=>['showef']]);

    }



    public function index()
    {
        $bills =\Auth::user()->bills()->paginate(10);
        return view('bills.index', compact('bills'));
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
        $bill = Bill::findOrFail($id);
        return view('bills.details', compact('bill'));
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
                 $bills->child->Family->email_responsable
              ));
                $bills->status = 1;
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
                            <td>
                                <a href="' .'#' . '" class="actions_icons delete-bill">
                                    <i class="fa fa-trash-o liste_icons"></i></a>
                                <a class="archive-bill"  href="' . '#' . '"><i class="fa fa-archive liste_icons"></i>
                                </a>
                            </td>
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
                            <td>
                                <a href="' . action('BillsController@delete', [$bills->id]) . '" class="actions_icons delete-bill">
                                    <i class="fa fa-trash-o liste_icons"></i></a>
                                <a class="archive-bill" href="' . action('BillsController@archive', [$bills->id]) . '"><i class="fa fa-archive liste_icons"></i>
                                </a>
                            </td>
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
                $bills = Bill::where('status', 0)->where('user_id',\Auth::user()->id)->get();
                foreach ($bills as $bill) {
                      if($bill->child->photo)
                      {
                          $photo = asset('uploads/'.$bill->child->photo);
                      }else{
                          $photo = asset('images/'.'avatar4.jpg');
                      }

                    echo '  <tr>
                            <td>  ' . $bill->id . '</td>
                            <td><img class="avatar" src="'.$photo.'"></td>
                            <td>' . $bill->child->nom_enfant . '</td>
                            <td> ' . $bill->start->format('d-m-Y') . ' </td>
                            <td>  ' . $bill->somme . '  Dhs</td>
                            <td><span class="label label-danger label-mini">
                               Non réglée </span>
                            </td>
                            <td>
                                <a  href="' . '#'. '" class="actions_icons delete-bill">
                                    <i class="fa fa-trash-o liste_icons"></i></a>
                                <a class="archive-bill" href="' . '#' . '"><i class="fa fa-archive liste_icons"></i>
                                </a>
                            </td>

                            <td><a href="' . action('BillsController@details', [$bill->id]) . '"><div  class="btn_details">Détails</div></a></td>
                        </tr>';
                }

            } else {
                $bills = Bill::where('status', 1)->where('user_id',\Auth::user()->id)->get();
                foreach ($bills as $bill) {
                    $photo = asset('uploads/'.$bill->child->photo);
                    echo '  <tr>
                            <td>  ' . $bill->id . '</td>
                            <td><img class="avatar" src="'.$photo.'"></td>
                            <td>' . $bill->child->nom_enfant . '</td>
                            <td> ' . $bill->start->format('d-m-Y') . ' </td>
                            <td>  ' . $bill->somme . '  Dhs</td>
                            <td><span class="label label-success label-mini">
                                réglée </span>
                            </td>
                            <td>
                                <a  href="' . action('BillsController@delete', [$bill->id]) . '" class="actions_icons delete-bill">
                                    <i class="fa fa-trash-o liste_icons"></i></a>
                                <a class="archive-bill" href="' . action('BillsController@archive', [$bill->id]) . '"><i class="fa fa-archive liste_icons"></i>
                                </a>
                            </td>

                            <td><a href="' . action('BillsController@details', [$bill->id]) . '"><div  class="btn_details">Détails</div></a></td>
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
                            <td><div class="minimal single-row">
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
                            <td>
                                <a href="' . '#'. '" class="actions_icons delete-bill">
                                    <i class="fa fa-trash-o liste_icons"></i></a>
                                <a class="archive-bill" href="' . '#' . '"><i class="fa fa-archive liste_icons"></i>
                                </a>
                            </td>
                            <td><a href="' . action('BillsController@details', [$b->id]) . '"><div  class="btn_details">Détails</div></a></td>
                        </tr> ';
                    }
                }
            }




        }
    }


    public function monthindex()
    {
        if (\Request::ajax()) {
            $mois = \Input::get('month');
            $bills = Bill::whereRaw('EXTRACT(month from start) = ?', [$mois])
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
                            <td>  ' . $bill->id . '</td>
                            <td><img class="avatar" src="'.$photo.'"></td>
                            <td>' . $bill->child->nom_enfant . '</td>
                            <td> ' . $bill->start->format('d-m-Y') . ' </td>
                            <td>  ' . $bill->somme . '  Dhs</td>
                            <td><span class="label ' . $class . ' label-mini">
                               ' . $message . ' </span>
                            </td>
                            <td>
                                <a  href="' . '#' . '" class="actions_icons delete-bill">
                                    <i class="fa fa-trash-o liste_icons"></i></a>
                                <a class="archive-bill" href="' . '#' . '"><i class="fa fa-archive liste_icons"></i>
                                </a>
                            </td>

                            <td><a href="' . action('BillsController@details', [$bill->id]) . '"><div  class="btn_details">Détails</div></a></td>
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
                      if($bill->child->photo)
                      $photo = asset('uploads/'.$bill->child->photo);
                      else
                        $photo = asset('images/'.'avatar4.jpg');
                      echo '  <tr>
                            <td>  ' . $bill->id . '</td>
                            <td><img class="avatar" src="'.$photo.'"></td>
                            <td>' . $bill->child->nom_enfant . '</td>
                            <td> ' . $bill->start->format('d-m-Y') . ' </td>
                            <td>  ' . $bill->somme . '  Dhs</td>
                            <td><span class="label ' . $class . ' label-mini">
                               ' . $message . ' </span>
                            </td>
                            <td>
                                <a  href="' . action('BillsController@delete', [$bill->id]) . '" class="actions_icons delete-bill">
                                    <i class="fa fa-trash-o liste_icons"></i></a>
                                <a class="archive-bill" href="' . action('BillsController@archive', [$bill->id]) . '"><i class="fa fa-archive liste_icons"></i>
                                </a>
                            </td>

                            <td><a href="' . action('BillsController@details', [$bill->id]) . '"><div  class="btn_details">Détails</div></a></td>
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
                          $photo = asset('uploads/'.$bill->child->photo);
                          echo '  <tr>
                            <td>  ' . $bill->id . '</td>
                            <td><img class="avatar" src="'.$photo.'"></td>
                            <td>' . $bill->child->nom_enfant . '</td>
                            <td> ' . $bill->start->format('d-m-Y') . ' </td>
                            <td>  ' . $bill->somme . '  Dhs</td>
                            <td><span class="label ' . $class . ' label-mini">
                               ' . $message . ' </span>
                            </td>
                            <td>
                                <a  href="' . action('BillsController@delete', [$bill->id]) . '" class="actions_icons delete-bill">
                                    <i class="fa fa-trash-o liste_icons"></i></a>
                                <a class="archive-bill" href="' . action('BillsController@archive', [$bill->id]) . '"><i class="fa fa-archive liste_icons"></i>
                                </a>
                            </td>

                            <td><a href="' . action('BillsController@details', [$bill->id]) . '"><div  class="btn_details">Détails</div></a></td>
                        </tr>';

                      }

                  }


            }

        }


    }



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

}