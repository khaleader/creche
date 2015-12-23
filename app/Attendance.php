<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{

protected $dates = ['start'];


    public function child()
    {
        return $this->belongsTo('App\Child');
    }
}
