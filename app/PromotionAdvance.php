<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromotionAdvance extends Model
{



    public static function checkAdvancePromotion()
    {
        $pro_adv = PromotionAdvance::where('user_id',\Auth::user()->id)->where('active',1)->first();

        if($pro_adv && $pro_adv->active == 1)
        {
           return true;
        }else{
            return false;
        }
    }

    // get the price or return false;
    public static function checkAdvIfPriceIsSet($type)
    {
        $pro_adv = PromotionAdvance::where('user_id',\Auth::user()->id)->where('active',1)
            ->where('type',$type)->first();
        if($pro_adv && $pro_adv->prix > 0)
        {
            return $pro_adv->prix;
        }else{
            return false;
        }

    }


    public static function countAccordingTo($reduction,$priceOfLevel,$type)
    {
       $reductionTotal = $reduction * $type;
       return  ($priceOfLevel * $type) - $reductionTotal;
    }



}
