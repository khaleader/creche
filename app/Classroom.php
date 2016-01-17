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

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class,'classroom_matter_teacher');
    }
    public function matieres()
    {
        return $this->belongsToMany(Matter::class,'classroom_matter_teacher');
    }

    public function children()
    {
        return $this->belongsToMany(Child::class);
    }












}
