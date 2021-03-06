<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MyClassRoom extends Model
{
  use SoftDeletes;
  use Uuids;
  public $incrementing = false;
  protected $fillable = ['user_id','institute_id','class_id','role','admin','teacher_id','parent_id','student_id','approved'];

  public function user()
  {
    return $this->belongsTo('App\User','user_id','id');
  }

  public function institute()
  {
    return $this->belongsTo('App\Institute','institute_id','id');
  }
  public function classroom()
  {
    return $this->belongsTo('App\ClassRoom','class_id','id');
  }


}
