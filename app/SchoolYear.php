<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolYear extends Model
{

protected $dates = ['startch1','endch1','startch2','endch2','startch3','endch3'];




    public function bills()
    {
        return $this->hasMany(Bill::class);
    }

}
