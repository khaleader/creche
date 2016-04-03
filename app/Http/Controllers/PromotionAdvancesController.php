<?php

namespace App\Http\Controllers;

use App\PromotionAdvance;
use App\PromotionExceptional;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PromotionAdvancesController extends Controller
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

       $insert = PromotionAdvance::where('user_id',\Auth::user()->id)->where('type',$request->type_adv)->first();
        if($insert)
        {
            $insert->prix = $request->prix_adv;
            $insert->type = intval($request->type_adv);
            $insert->active =1;
            $insert->save();
        }else{
            $adv = new PromotionAdvance();
            $adv->type = intval($request->type_adv);
            $adv->prix =  $request->prix_adv;
            $adv->user_id = \Auth::user()->id;
            $adv->active = 1;
            $adv->save();
        }

        $pro_adv = PromotionAdvance::where('user_id',\Auth::user()->id)->get();

        if(!$pro_adv->isEmpty())
        {
            foreach ($pro_adv as $item) {
                $pv = PromotionAdvance::where('user_id',\Auth::user()->id)->where('id',$item->id)->first();
                $pv->active = 1;
                $pv->save();
            }

        }

        $pro_exc = PromotionExceptional::where('user_id',\Auth::user()->id)->first();
        if($pro_exc)
        {
            $pro_exc->active =0;
            $pro_exc->save();
        }

       return redirect()->back()->with('success','Bien Enregistrée');

    }

    public function showPriceOfPromotion()
    {
        if(\Request::ajax())
        {
            $type_valeur =  \Input::get('type_valeur');
            $checkPrice =  PromotionAdvance::where('user_id',\Auth::user()->id)
                ->where('type',$type_valeur)
                ->first();
            if($checkPrice)
            {
                echo json_encode($checkPrice);
                die();
            }else{
                $tab = [
                    'prix'=> '',

                ];
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
