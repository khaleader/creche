<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{

protected $fillable = ['nom_branche','code_branche','user_id'];

    public function user()
    {
        $this->belongsTo('App\User');
    }
}
