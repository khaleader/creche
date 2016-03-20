<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\Grade;
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
        $grade =  Grade::where('user_id',\Auth::user()->id)->first();
        if(!$grade)
        {
            $creche = new Grade();
            $creche->name = 'Crèche';
            $creche->user_id = \Auth::user()->id;
            $creche->save();

            $mater = new Grade();
            $mater->name = 'Maternelle';
            $mater->user_id = \Auth::user()->id;
            $mater->save();
            $sc = new Grade();

            $sc = new Grade();
            $sc->name = 'Primaire';
            $sc->user_id = \Auth::user()->id;
            $sc->save();

            $col = new Grade();
            $col->name = 'Collège';
            $col->user_id = \Auth::user()->id;
            $col->save();

            $lyc = new Grade();
            $lyc->name = 'Lycée';
            $lyc->user_id = \Auth::user()->id;
            $lyc->save();

        }
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
            'count' => $count
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
