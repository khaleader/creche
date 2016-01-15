<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{



    public function classroom()
    {
        return $this->belongsTo('App\Classroom');
    }
}
