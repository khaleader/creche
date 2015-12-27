<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bill extends Model
{
use SoftDeletes;


    protected $dates = ['start','end'];




    public function child()
    {
        return $this->belongsTo('App\Child')->withTrashed();
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }




}
