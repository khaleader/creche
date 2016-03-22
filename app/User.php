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
    protected $guarded =['id'];
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

    public $dates = ['created_at'];





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
        return $this->hasMany('App\Matter');
    }

    public function branches()
    {
        return $this->hasMany('App\Branch');
    }
    public function rooms()
    {
        return $this->hasMany('App\Room');
    }
    public function classrooms()
    {
        return $this->hasMany('App\Classroom');
    }


/************** only for schools user_id **************/

    public function lesgamins() // only for school user_id children
    {
        return $this->hasMany(Child::class,'user_id')->withTrashed();
    }

    public function lesfamilles() // school family user_id
    {
        return $this->hasMany(Family::class,'user_id')->withTrashed();
    }

    public function lesfactures() // bill user_id
    {
        return $this->hasMany(Bill::class,'user_id')->withTrashed();
    }

    public function lespointages() // attendances user_id
    {
        return $this->hasMany(Attendance::class,'user_id')->withTrashed();
    }

    public function lesteachers()
    {
        return $this->hasMany(Teacher::class,'user_id')->withTrashed();

    }

    public function lescategoriesbills() // category_bills user_id
    {
        return $this->hasMany(CategoryBill::class,'user_id');
    }


    public function letransport()
    {
        return $this->hasOne(Transport::class,'user_id');
    }

    public function lesmatieres()
    {
        return $this->hasMany(Matter::class,'user_id');

    }

    public function lesbranches()
    {
        return $this->hasMany(Branch::class,'user_id');
    }
    public function lesrooms()
    {
        return $this->hasMany(Room::class,'user_id');
    }
    public function lesclassrooms()
    {
        return $this->hasMany(Classroom::class,'user_id');
    }

    public function leslevels()
    {
        return $this->hasMany(Level::class,'user_id');
    }

    public function lestimesheets()
    {
        return $this->hasMany(Timesheet::class,'user_id');
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }


    public function buses()
    {
        return $this->hasMany(Bus::class);
    }



}
