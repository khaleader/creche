<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Matter extends Model
{

    protected $fillable = ['nom_matiere','code_matiere','user_id'];

    public function user()
    {
        $this->belongsTo('App\User');
    }

    public function classrooms()
    {
        return $this->belongsToMany('App\Classroom');
    }

    public function branch()
    {
        return $this->belongsTo('App\Branch');
    }

}
