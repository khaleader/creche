<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class CategoryBill extends Model
{

    protected $fillable = [
      'age_de','age_a','prix','name','user_id'
    ];

    public static function getYear($date)
    {
            $old = Carbon::parse($date)->diff(Carbon::now())->format('%y');
            $cat = CategoryBill::where('user_id', Auth::user()->id)->get();
            foreach($cat as $c)
            {
                if($old >= $c->age_de && $old <= $c->age_a)
                {
                    return $c->prix;
                }
            }
    }
}
