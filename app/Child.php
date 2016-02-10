<?php

namespace App;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Child extends Model
{

use SoftDeletes;
    protected $guarded =['id'];
protected $dates = ['date_naissance','deleted_at'];


    public function setDateNaissanceAttribute($date)
    {
        return $this->attributes['date_naissance'] = Carbon::parse($date)->toDateString();
    }

    public function Family()
    {
        return $this->belongsTo('App\Family')->withTrashed();
    }

    public function attendances()
    {
        return $this->hasMany('App\Attendance')->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function bills()
    {
        return $this->hasMany('App\Bill')->withTrashed();
    }

    public function utilisateur()
    {
        return $this->belongsTo('App\User');
    }


    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class);
    }
}
