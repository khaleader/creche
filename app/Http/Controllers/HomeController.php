<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\Bill;
use App\Child;
use App\Grade;
use App\PriceBill;
use App\PromotionStatus;
use App\SchoolYear;
use App\Transport;
use App\User;
use Carbon\Carbon;
use Google_Client;
use Google_Service_Gmail;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('type','ecole')->get();
        foreach($users as $user)
        {
            $sc = SchoolYear::where('user_id',$user->id)->where('current',1)->first();
            if($sc->type == 'Semis' && Carbon::now()->between($sc->startch1,$sc->endch2))
            {
                foreach($user->children as $child)
                {
                    foreach($child->bills as $bill) {
                        $getChild = Bill::where('child_id', $bill->child_id)
                            ->where('reduction', 0)
                            ->where('school_year_id', $sc->id)
                            ->where('nbrMois',6)
                            ->orderBy('id','desc')
                            ->first();
                        if ($getChild) {
                            if (Carbon::now() >= $getChild->end) {
                                $last_bill = Bill::where('child_id', $getChild->child_id)
                                    ->where('reduction', 0)
                                    ->where('school_year_id', $sc->id)
                                    ->where('nbrMois', 1)
                                    ->orderBy('id', 'desc')
                                    ->first();
                                if (!$last_bill && Carbon::now() > $getChild->end) {
                                    $facture = new Bill();
                                    $facture->start = $getChild->end->toDateString();
                                    $facture->end = $getChild->end->addMonths(1)->toDateString();
                                    $facture->status = 0;
                                    $facture->user_id = $getChild->user_id;
                                    $facture->nbrMois = 1;
                                    $facture->reductionPrix = null;
                                    $facture->school_year_id = $getChild->school_year_id;
                                    $facture->reduction = 0;
                                    $enfant = Child::where('user_id', $getChild->user_id)->where('id', $getChild->child_id)->first();
                                    $taman = '';
                                    if ($getChild->reduction == 0) {
                                        if ($enfant->transport == 1) {
                                            foreach ($enfant->levels as $level) {
                                                $getPriceOfLevel = PriceBill::where('niveau', $level->id)
                                                    ->where('user_id', $getChild->user_id)->first();
                                                $taman = $getPriceOfLevel->prix;
                                            }

                                            $total_transport = Transport::where('user_id', $getChild->user_id)->first()->somme * 1;
                                            $prix_finale = ($taman * 1) + $total_transport;
                                            $facture->somme = $prix_finale;

                                        } elseif ($enfant->transport == 0) {

                                            foreach ($enfant->levels as $level) {
                                                $getPriceOfLevel = PriceBill::where('niveau', $level->id)
                                                    ->where('user_id', $getChild->user_id)->first();
                                                $taman = $getPriceOfLevel->prix;
                                            }
                                            $prix_finale = $taman * 1;
                                            $facture->somme = $prix_finale;
                                        }
                                    }
                                    $facture->child_id = $getChild->child_id;
                                    $facture->f_id = $getChild->f_id;
                                    $facture->save();
                                    break;

                                }
                            }
                        }

                    }
                }








            }elseif($sc->type == 'Trim' && Carbon::now()->between($sc->startch1,$sc->endch3))
            {
                foreach($user->children as $child)
                {
                    foreach($child->bills as $bill)
                    {
                        $getChild = Bill::where('child_id',$bill->child_id)
                            ->where('reduction',0)
                            ->where('school_year_id',$sc->id)
                            ->where('nbrMois',6)
                            ->orderBy('id','desc')
                            ->first();

                        if($getChild) {
                            if(Carbon::now() >= $getChild->end) {
                                $last_bill = Bill::where('child_id', $getChild->child_id)
                                    ->where('reduction', 0)
                                    ->where('school_year_id', $sc->id)
                                    ->where('nbrMois', 1)
                                    ->orderBy('id', 'desc')
                                    ->first();
                                if (!$last_bill && Carbon::now() > $getChild->end) {
                                    $facture = new Bill();
                                    $facture->start = $getChild->end->toDateString();
                                    $facture->end = $getChild->end->addMonths(1)->toDateString();
                                    $facture->status = 0;
                                    $facture->user_id = $getChild->user_id;
                                    $facture->nbrMois = 1;
                                    $facture->reductionPrix = null;
                                    $facture->school_year_id = $getChild->school_year_id;
                                    $facture->reduction = 0;
                                    $enfant = Child::where('user_id', $getChild->user_id)->where('id', $getChild->child_id)->first();
                                    $taman = '';
                                    if ($getChild->reduction == 0) {
                                        if ($enfant->transport == 1) {
                                            foreach ($enfant->levels as $level) {
                                                $getPriceOfLevel = PriceBill::where('niveau', $level->id)
                                                    ->where('user_id', $getChild->user_id)->first();
                                                $taman = $getPriceOfLevel->prix;
                                            }
                                            $total_transport = Transport::where('user_id', $getChild->user_id)->first()->somme * 1;
                                            $prix_finale = ($taman * 1) + $total_transport;
                                            $facture->somme = $prix_finale;

                                        } elseif ($enfant->transport == 0) {

                                            foreach ($enfant->levels as $level) {
                                                $getPriceOfLevel = PriceBill::where('niveau', $level->id)
                                                    ->where('user_id', $getChild->user_id)->first();
                                                $taman = $getPriceOfLevel->prix;
                                            }
                                            $prix_finale = $taman * 1;
                                            $facture->somme = $prix_finale;

                                        }
                                    }
                                    $facture->child_id = $getChild->child_id;
                                    $facture->f_id = $getChild->f_id;
                                    $facture->save();
                                    break;
                                }
                            }
                        }
                    }
                }
            }

        }


        $aboutfacture = SchoolYear::checkNextMonth();
       PromotionStatus::fillStatusesFirst();
      Grade::AddGradesAndLevels(\Auth::user()->id);

        $client = new Google_Client();
        $client->setClientId('548520090024-i8jmtdmdi5ijvj3mn2sbqe2u3a431gh6.apps.googleusercontent.com');
        $client->setClientSecret('IX-SilXd0ctCrKUX1a5oP9is');
        $client->setRedirectUri('http://laravel.dev:8000/schools/boite');
        $client->addScope('https://mail.google.com');
        $service = new Google_Service_Gmail($client);

        $count =Attendance::whereRaw('EXTRACT(year from start) = ?', [Carbon::now()->year])
            ->whereRaw('EXTRACT(month from start) = ?', [Carbon::now()->month])
            ->whereRaw('EXTRACT(day from start) = ?', [Carbon::now()->day])
            ->where('user_id',\Auth::user()->id)
            ->groupBy('child_id')
            ->get();
           $count = $count->count();




        return view('index')->with([
            'client'=> $client,
            'service'=> $service,
            'count' => $count,
            'aboutfacture' => $aboutfacture
        ]);

    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function help()
    {
        return view('help');
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
}
