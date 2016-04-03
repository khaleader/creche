<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{

    protected $guarded =['id'];

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



    public function branches()
    {
        return $this->belongsToMany(Branch::class,'branch_classroom_level');
    }


    public function levels()
    {
        return $this->belongsToMany(Level::class,'branch_classroom_level');
    }


    // only for primaire and collège and maternelle
    public function lesNiveaux()
    {
        return $this->belongsToMany(Level::class);
    }

    // only for creche
    public function grades()
    {
        return $this->belongsToMany(Grade::class);
    }



    public function scopeCurrentYear($query)
    {
        $query->where('school_year_id',SchoolYear::getSchoolYearId());
    }












}
