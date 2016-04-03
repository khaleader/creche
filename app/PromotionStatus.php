<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromotionStatus extends Model
{


    public static function fillStatusesFirst()
    {
        if(\Auth::user()->isAdmin())
        {
            $status =  PromotionStatus::where('user_id',\Auth::user()->id)->first();
            if(!$status)
            {
                $newStatus = new PromotionStatus();
                $newStatus->global =0;
                $newStatus->bloc1 =0;
                $newStatus->bloc2 =0;
                $newStatus->user_id =\Auth::user()->id;
                $newStatus->save();
            }
        }

    }


}
