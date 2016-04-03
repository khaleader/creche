<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class PromotionExceptional extends Model
{
   protected $dates = ['start','end'];


// check if exists and it's active
public static function checkExceptionalPromotion()
{
   $pro_exc = PromotionExceptional::where('user_id',\Auth::user()->id)->where('active',1)->first();
   if($pro_exc)
   {
      return true;
   }else{
      return false;
   }
}


// check if current time is between the start and end
   public static function checkExcTimeOfPromotionIfExpired()
   {
      $pro_exc = PromotionExceptional::where('user_id',\Auth::user()->id)->where('active',1)->first();
      if($pro_exc)
      {
         if(Carbon::now()->between($pro_exc->start,$pro_exc->end))
         {
            return true;
         }else{
            return false;
         }
      }
   }


 // whether price is set or price is not set
   public static function checkExcPriceandReturnIt()
   {
      $pro_exc = PromotionExceptional::where('user_id',\Auth::user()->id)->where('active',1)->first();
      if($pro_exc)
      {
         if($pro_exc->price && $pro_exc->price > 0)
         {
            return $pro_exc->price;
         }else{
               return 'no';
         }
      }
   }

   public static function countAccordingTo($type,$priceLevel,$reduction)
   {

      $reductionTotal = $reduction * $type;
      return  ($priceLevel * $type) - $reductionTotal;
   }





}