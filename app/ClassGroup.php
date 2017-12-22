<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\SoftDeletes;

class ClassGroup extends Model
{
  use SoftDeletes;

  use Uuids;

  public $incrementing = false;

  protected $fillable = ['class_room_id', 'class_group_name', 'institute_id',  'user_id','avatar'];

  public function classrooms()
  {
      return $this->belongsToMany('App\ClassRoom', 'class_room_groups')->withTimestamps();
  }

  public function group_classrooms(){
    return $this->hasMany('App\ClassRoomGroups');
  }

}
