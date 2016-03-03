<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
 protected $guarded =['id'];
 public $timestamps = false;




 public function branches()
 {
  return $this->belongsToMany(Branch::class,'branch_classroom_level');
 }

 public function classrooms()
 {
  return $this->belongsToMany(Classroom::class,'branch_classroom_level');
 }

 public function children()
 {
  return $this->belongsToMany(Child::class);
 }

}
