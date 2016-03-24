<?php

namespace App\Http\Controllers;

use App\Occasion;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class OccasionsController extends Controller
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
        //
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
        if(\Auth::user()->id == $id)
        {
            $occ = Occasion::where('user_id',\Auth::user()->id)->get();
            foreach($occ as $ev)
            {

                $ev['allDay'] = false;
            }
            $resultat = json_encode($occ);

            $resultat = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', $resultat);
            return view('occasions.show',compact('resultat'));
        }else{
            return redirect()->back();
        }

    }

    public function delOcc()
    {
        $tab =  \Input::all();
        $obj = Occasion::findOrFail($tab['id']);
        $obj->delete();

    }



    public function insertOcc(Request $request)
    {

            $tab = \Input::all();
            $title = $tab['title'];
            $start = str_replace('/','-',$tab['start']);
            $end = str_replace('/','-',$tab['end']);
            $color = $tab['optionsCategory'];



            $event = new Occasion();
            $event->title = $title;
            $event->start = $start;
            $event->end =$end;
            $event->color = $color;
            $event->allDay = false;
            $event->user_id = \Auth::user()->id;
            $event->save();
        return redirect()->back();

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
