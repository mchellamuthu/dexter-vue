<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentCode extends Model
{
    use Uuids;
    public $incrementing =false;
    protected $fillable = ['user_id','student_id','class_room_id','code'];

    public function user()
    {
      return $this->belongsTo('App\User','user_id','id');
    }
    public function student()
    {
      return $this->belongsTo('App\Student','student_id','id');
    }

    public function classroom()
    {
      return $this->belongsTo('App\ClassRoom','class_room_id','id');
    }


}
