<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Family extends Model
{

protected  $dates = ['deleted_at'];


use SoftDeletes;


    public function children()
    {
        return $this->hasMany('App\Child')->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
