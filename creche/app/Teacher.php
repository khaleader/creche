<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teacher extends Model
{
use SoftDeletes;

    protected $dates = ['date_naissance','deleted_at'];

}
