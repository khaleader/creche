<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    protected $guarded =['id'];
   protected $fillable = [
     'somme',
       'user_id'
   ];




    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
