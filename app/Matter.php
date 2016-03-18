<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Matter extends Model
{
    protected $guarded =['id'];
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

    public function lesteachers()
    {
        return $this->belongsToMany(Teacher::class,'classroom_matter_teacher');
    }

    public function rooms()
    {
        return $this->belongsToMany(Room::class);
    }

}
