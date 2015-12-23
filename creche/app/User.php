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

}
