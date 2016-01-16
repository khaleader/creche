<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Matter extends Model
{

    protected $fillable = ['nom_matiere','code_matiere','color','user_id'];

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

    public function teachers()
    {
        return $this->belongsToMany('App\Teacher');
    }

}
