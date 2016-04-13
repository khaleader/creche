<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


class PriceBill extends Model
{



    public static function assignPrice($level_id,$transport_status,$reductionPrix=null)
    {
       $currentYear = \Auth::user()->schoolyears()->where('current',1)->first();
        if($currentYear->type == 'Semis')
        {
            if(Carbon::now()->between($currentYear->startch1,$currentYear->endch2))
            {
                if($transport_status == 0)
                {
                    $price = \Auth::user()->pricebills()->where('niveau',$level_id)->first();
                    if($price->prix > 0 && is_null($reductionPrix))
                    {
                        return $price->prix;
                    }else{
                         return $price->prix - $reductionPrix;
                    }

                }else{
                    if (Transport::where('user_id', \Auth::user()->id)->exists()) {
                        $price = \Auth::user()->pricebills()->where('niveau',$level_id)->first();
                        if($price->prix > 0  && is_null($reductionPrix))
                        {
                            return $price->prix + Transport::where('user_id', \Auth::user()->id)->first()->somme;
                        }else{
                            return ($price->prix + Transport::where('user_id', \Auth::user()->id)->first()->somme) - $reductionPrix;

                        }
                    }

                }
            }
        }else{
            if(Carbon::now()->between($currentYear->startch1,$currentYear->endch3))
            {
                if($transport_status == 0)
                {
                    $price = \Auth::user()->pricebills()->where('niveau',$level_id)->first();
                    if($price->prix > 0 && is_null($reductionPrix))
                    {
                        return $price->prix;
                    }else{
                       return $price->prix - $reductionPrix;
                    }
                }else{
                    if (Transport::where('user_id', \Auth::user()->id)->exists()) {
                        $price = \Auth::user()->pricebills()->where('niveau',$level_id)->first();
                        if($price->prix > 0 && is_null($reductionPrix))
                        {
                            return $price->prix + Transport::where('user_id', \Auth::user()->id)->first()->somme;
                        }else{
                           return  ($price->prix + Transport::where('user_id', \Auth::user()->id)->first()->somme) - $reductionPrix;
                        }
                    }

                }
            }
        }
    }


    public static function countWhenNoPromotion($type,$priceNormal)
    {
          return $type * $priceNormal;
    }

    public static function countWhenNoPromotionButReduction($type,$priceNormal,$reduction)
    {
        $total_reduction = $type * $reduction;
        return  ($priceNormal * $type) - $total_reduction;
    }


    public static function getNiveauPrice($niveau)
    {

       if(\Auth::user()->pricebills()->where('niveau',$niveau)->first())
        {
        $price=\Auth::user()->pricebills()->where('niveau',$niveau)->first();
        return $price->prix;
        }


    }


    public function schoolYear()
    {
        return $this->belongsTo(SchoolYear::class);
    }


}
