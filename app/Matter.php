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

}
