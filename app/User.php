<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];





    public function isAdmin()
    {
        if($this->type == 'ecole')
        {
            return true;
        }else{
            return false;
        }
    }


    public function isFamily()
    {
        if($this->type == 'famille')
        {
            return true;
        }else{
            return false;
        }
    }

    public function isOblivius()
    {
        if($this->type == 'oblivius')
        {
            return true;
        }else{
            return false;
        }
    }


        public function families()
        {
            return $this->hasMany('App\Family');
        }
        public function bills()
        {
            return $this->hasMany('App\Bill');
        }

        public function children()
        {
            return $this->hasMany('App\Child');
        }
        public function attendances()
        {
            return $this->hasMany('App\Attendance');
        }



       public function enfants()
       {
           return $this->hasMany('App\Child','f_id');
       }

       public function teachers()
       {
           return $this->hasMany('App\Teacher');
       }

    public function categoryBills()
    {
        return $this->hasMany('App\CategoryBill');
    }

    public function transport()
    {
        return $this->hasOne('App\Transport');
    }


    public function matters()
    {
        return $this->hasMany('App\Matter.php');
    }

    public function branches()
    {
        return $this->hasMany('App\Branch.php');
    }
    public function rooms()
    {
        return $this->hasMany('App\Room.php');
    }
    public function classrooms()
    {
        return $this->hasMany('App\Classroom.php');
    }

}
