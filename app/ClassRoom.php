<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\SoftDeletes;

class ClassRoom extends Model
{
    use SoftDeletes;

    use Uuids;

    public $incrementing = false;

    protected $fillable = ['class_name', 'avatar', 'institute_id', 'class_teacher', 'status','section', 'user_id'];
    protected $hidden = ['skills','students','stories'];

    public function groups()
    {
        return $this->belongsToMany('App\ClassGroup', 'class_room_groups')->withTimestamps();
    }
    public function classroom_groups(){
      return $this->hasMany('App\ClassRoomGroups');
    }
    public function students(){
      return $this->hasMany('App\Student');
    }

    public function skills()
    {
      return $this->hasMany('App\Skill','class_room_id','id');
    }
    public function stories()
    {
       return $this->hasMany('App\Story','class_room_id','id')->whereDeletedAt(null);
    }

    public function teachers()
    {
      return $this->belongsToMany('App\User','my_class_rooms','class_id','user_id')->withPivot(['id','admin','user_id','institute_id','class_id','role','approved'])->withTimestamps();
    }
}
