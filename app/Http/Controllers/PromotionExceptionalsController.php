<?php

namespace App\Http\Controllers;

use App\PromotionAdvance;
use App\PromotionExceptional;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PromotionExceptionalsController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }



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
        $pro_exc = PromotionExceptional::where('user_id',\Auth::user()->id)->first();
        if($pro_exc)
        {
            $pro_exc->start = Carbon::parse($request->start);
            $pro_exc->end = Carbon::parse($request->end);
            $pro_exc->user_id = \Auth::user()->id;
            $pro_exc->price = $request->prix_exc;
            $pro_exc->active = 1;
            $pro_exc->save();
        }else{
            $pro_exc = new PromotionExceptional();
            $pro_exc->start = Carbon::parse($request->start);
            $pro_exc->end = Carbon::parse($request->end);
            $pro_exc->price = $request->prix_exc;
            $pro_exc->user_id = \Auth::user()->id;
            $pro_exc->active = 1;
            $pro_exc->save();
        }
            // make promotion in advance not current
            $pro_adv = PromotionAdvance::where('user_id',\Auth::user()->id)->get();
            if(!$pro_adv->isEmpty())
            {
                foreach ($pro_adv as $item) {
                    $pv = PromotionAdvance::where('user_id',\Auth::user()->id)->where('id',$item->id)->first();
                    $pv->active = 0;
                    $pv->save();
                }

            }
        return redirect()->back()->with('success','Bien Enregistrée');

    }


    public function getData()
    {
        if(\Request::ajax())
        {
            $user_id =  \Input::get('user_id');
            $checkPrice =  PromotionExceptional::where('user_id',$user_id)
                ->first();
            if($checkPrice)
            {
                echo json_encode($checkPrice);
                die();
            }else{
                $tab = [];
                echo json_encode($tab);
                die();
            }
        }
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
