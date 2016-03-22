<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
use SoftDeletes;

 protected $guarded =['id'];
protected $dates = ['start','end','deleted_at'];


    public function child()
    {
        return $this->belongsTo('App\Child')->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
