<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teacher extends Model
{
use SoftDeletes;
    protected $guarded =['id'];
    protected $dates = ['date_naissance','deleted_at'];


    public function matters()
    {
        return $this->belongsToMany('App\Matter');
    }

    public function lesmatters()
    {
        return $this->belongsToMany(Matter::class,'classroom_matter_teacher');
    }

}
