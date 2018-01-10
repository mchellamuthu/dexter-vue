<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class StudentStory extends Model
{
    use Uuids;
    public $incrementing = false;
    protected $fillable = ['story_id','student_id','class_room_id','student_group_id'];

    public function story()
    {
      return $this->belongsTo('App\Story','story_id','id');
    }
    public function student()
    {
      return $this->belongsTo('App\Student');
    }
    public function classroom()
    {
      return $this->belongsTo('App\ClassRoom');
    }

    public function group()
    {
      return $this->belongsTo('App\StudentGroup');
    }
}
