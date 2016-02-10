<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{


    protected $guarded =['id'];
    public function classroom()
    {
        return $this->belongsTo('App\Classroom');
    }
}
