<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
  use SoftDeletes;

  use Uuids;

  public $incrementing = false;
  protected $fillable = ['user_id','institute_id','avatar','class_room_id'];

  public function user()
  {
    return $this->belongsTo('App\User','user_id','id');
  }

  public function classroom(){
    return $this->belongsTo('App\ClassRoom','class_room_id','id');
  }
}
