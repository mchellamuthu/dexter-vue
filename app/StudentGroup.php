<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentGroup extends Model
{
  use SoftDeletes;
  use Uuids;
  public $incrementing = false;
  protected $fillable = ['user_id','institute_id','avatar','class_room_id','group_name'];
  protected $hidden = ['students'];
  public function students()
  {
      return $this->belongsToMany('App\Student', 'student_group_members')->withTimestamps();
  }

}
