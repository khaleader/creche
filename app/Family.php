<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Family extends Model
{
    protected $guarded =['id'];
protected  $dates = ['deleted_at'];


use SoftDeletes;



    public function scopeCurrentYear($query)
    {
        $query->where('school_year_id',SchoolYear::getSchoolYearId());
    }

    public function children()
    {
        return $this->hasMany('App\Child')->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
