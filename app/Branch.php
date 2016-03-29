<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $guarded =['id'];
protected $fillable = ['nom_branche','code_branche','user_id'];

    public function user()
    {
        $this->belongsTo('App\User');
    }

    public function matters()
    {
        return $this->hasMany('App\Matter');
    }


    public function levels()
    {
        return $this->belongsToMany(Level::class,'branch_classroom_level');
    }

    public function children()
    {
        return $this->belongsToMany(Child::class);
    }

    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class,'branch_classroom_level');
    }


    // on create school we link levels and branches
    public function onlevels()
    {
        return $this->belongsToMany(Level::class);
    }

}
