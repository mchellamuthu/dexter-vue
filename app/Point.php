<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    use Uuids;
    public $incrementing = false;
    protected $fillable = ['user_id','institute_id','class_room_id','point','skill_name','type','student_id'];

    public function classroom()
    {
        return $this->belongsTo('App\ClassRoom', 'class_room_id', 'id');
    }
    public function institute()
    {
        return $this->belongsTo('App\Institute', 'institute_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
    public function student()
    {
        return $this->belongsTo('App\Student', 'student_id', 'id');
    }
}
