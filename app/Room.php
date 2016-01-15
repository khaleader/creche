<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{

    protected $fillable = ['nom_salle','capacite_salle','color','user_id'];


    public function user()
    {
        $this->belongsTo('App\User');
    }
}
