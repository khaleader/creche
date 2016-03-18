<?php

namespace App\Http\Controllers;

use App\Timesheet;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PlansController extends Controller
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
        if(Carbon::now()->isMonday())
        {
            $plans = Timesheet::where('user_id',\Auth::user()->id)
                ->where('matter_id','!=',0)
                ->where('dayname','lundi')->paginate(10);
            return view('plans.index',compact('plans'));
        }elseif(Carbon::now()->isTuesday())
        {
            $plans = Timesheet::where('user_id',\Auth::user()->id)
                ->where('matter_id','!=',0)
                ->where('dayname','mardi')->paginate(10);
            return view('plans.index',compact('plans'));
        }elseif(Carbon::now()->isWednesday())
        {
            $plans = Timesheet::where('user_id',\Auth::user()->id)
                ->where('matter_id','!=',0)
                ->where('dayname','mercredi')->paginate(10);
            return view('plans.index',compact('plans'));
        }elseif(Carbon::now()->isThursday())
        {
            $plans = Timesheet::where('user_id',\Auth::user()->id)
                ->where('matter_id','!=',0)
                ->where('dayname','jeudi')->paginate(10);
            return view('plans.index',compact('plans'));
        }elseif(Carbon::now()->isFriday())
        {
            $plans = Timesheet::where('user_id',\Auth::user()->id)
                ->where('matter_id','!=',0)
                ->where('dayname','vendredi')->paginate(10);
            return view('plans.index',compact('plans'));
        }elseif(Carbon::now()->isSaturday())
        {
            $plans = Timesheet::where('user_id',\Auth::user()->id)
                ->where('matter_id','!=',0)
                ->where('dayname','samedi')->paginate(10);
            return view('plans.index',compact('plans'));
        }else{
            $plans = Timesheet::where('user_id',\Auth::user()->id)->paginate(10);
            return view('plans.index',compact('plans'));
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
