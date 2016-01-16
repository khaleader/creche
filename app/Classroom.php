<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{



    public function user()
    {
       return $this->belongsTo('App\User');
    }


    public function matters()
    {
        return $this->belongsToMany('App\Matter');
    }

    public function timesheets()
    {
        return $this->hasMany('App\Timesheet');
    }

    public function child()
    {
        return $this->belongsTo('App\Child');
    }











}
