<?php

namespace App\Http\Controllers;

use App\PromotionAdvance;
use App\PromotionExceptional;
use App\PromotionStatus;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PromotionStatusesController extends Controller
{



    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }




    public function checkglobal()
    {
        if(\Request::ajax())
        {
          $global_status =PromotionStatus::where('user_id',\Auth::user()->id)->first();
            if($global_status->global == 0)
            {
                echo 'off';
            }else{
                echo 'on';
            }
        }
    }

    public function setGlobal()
    {
        if(\Request::ajax())
        {
            $getGlobal =\Input::get('getGlobal');
            $global_status =PromotionStatus::where('user_id',\Auth::user()->id)->first();
            if($getGlobal == 1)
            {
              $global_status->bloc1 =1;
                $global_status->bloc2 = 0;
                $global_status->global = 1;
                $global_status->save();

                // adv
                $pro_adv = PromotionAdvance::where('user_id',\Auth::user()->id)->get();
                if(!$pro_adv->isEmpty())
                {
                    foreach ($pro_adv as $item) {
                        $pv = PromotionAdvance::where('user_id',\Auth::user()->id)->where('id',$item->id)->first();
                        $pv->active = 1;
                        $pv->save();
                    }
                }
                // exc
                $pro_exc = PromotionExceptional::where('user_id',\Auth::user()->id)->first();
                if($pro_exc)
                {
                    $pro_exc->active = 0;
                    $pro_exc->save();
                }


            }else{
                $global_status->bloc1 =0;
                $global_status->bloc2 =0;
                $global_status->global = 0;
                $global_status->save();


                // adv
                $pro_adv = PromotionAdvance::where('user_id',\Auth::user()->id)->get();
                if(!$pro_adv->isEmpty())
                {
                    foreach ($pro_adv as $item) {
                        $pv = PromotionAdvance::where('user_id',\Auth::user()->id)->where('id',$item->id)->first();
                        $pv->active = 0;
                        $pv->save();
                    }
                }
                // exc
                $pro_exc = PromotionExceptional::where('user_id',\Auth::user()->id)->first();
                if($pro_exc)
                {
                    $pro_exc->active = 0;
                    $pro_exc->save();
                }

            }





        }
    }

    public function setbloc1()
    {
        if(\Request::ajax())
        {
            $bloc1_status =\Input::get('bloc1status');
            $global_status =PromotionStatus::where('user_id',\Auth::user()->id)->first();
            if($bloc1_status == 1)
            {
                $global_status->bloc1 = 1;
                $global_status->bloc2= 0;
                $global_status->save();
                // adv
                $pro_adv = PromotionAdvance::where('user_id',\Auth::user()->id)->get();
                if(!$pro_adv->isEmpty())
                {
                    foreach ($pro_adv as $item) {
                        $pv = PromotionAdvance::where('user_id',\Auth::user()->id)->where('id',$item->id)->first();
                        $pv->active = 1;
                        $pv->save();
                    }
                }
                // exc
                $pro_exc = PromotionExceptional::where('user_id',\Auth::user()->id)->first();
                if($pro_exc)
                {
                    $pro_exc->active = 0;
                    $pro_exc->save();
                }



            }else{
                $global_status->bloc1 = 0;
                $global_status->bloc2= 1;
                $global_status->save();
            }

        }
    }

    public function setbloc2()
    {
        if(\Request::ajax())
        {
            $bloc2_status =\Input::get('bloc2status');
            $global_status =PromotionStatus::where('user_id',\Auth::user()->id)->first();
            if($bloc2_status == 1)
            {
                $global_status->bloc1 = 0;
                $global_status->bloc2= 1;
                $global_status->save();

                // adv
                $pro_adv = PromotionAdvance::where('user_id',\Auth::user()->id)->get();
                if(!$pro_adv->isEmpty())
                {
                    foreach ($pro_adv as $item) {
                        $pv = PromotionAdvance::where('user_id',\Auth::user()->id)->where('id',$item->id)->first();
                        $pv->active = 0;
                        $pv->save();
                    }
                }
                // exc
                $pro_exc = PromotionExceptional::where('user_id',\Auth::user()->id)->first();
                if($pro_exc)
                {
                    $pro_exc->active = 1;
                    $pro_exc->save();
                }

            }else{
                $global_status->bloc1 = 1;
                $global_status->bloc2= 0;
                $global_status->save();
            }

        }
    }


    public function resetallblocks()
    {
        $global_status = PromotionStatus::where('user_id',\Auth::user()->id)->first();
        $global_status->global =0;
        $global_status->bloc1 =0;
        $global_status->bloc2 =0;
        $global_status->save();


    }



    public function checkbloc1()
    {
     if(\Request::ajax())
     {
         $global_status = PromotionStatus::where('user_id',\Auth::user()->id)->first();
         if($global_status->bloc1 == 1)
         {
             echo 'on';
         }
     }
    }
    public function checkbloc2()
    {
        if(\Request::ajax())
        {
            $global_status = PromotionStatus::where('user_id',\Auth::user()->id)->first();
            if($global_status->bloc2 == 1)
            {
                echo 'on';
            }
        }
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
