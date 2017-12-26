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
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function classroom()
    {
        return $this->belongsTo('App\ClassRoom', 'class_room_id', 'id');
    }

    public function groups()
    {
        return $this->belongsToMany('App\TeacherGroup', 'teacher_group_members')->withTimestamps();
    }

    public function points()
    {
        return $this->hasMany('App\Point', 'student_id', 'id');
    }
    public function attendances()
    {
      return $this->belongsToMany('Attendance','users_attendance')->withTimestamps();
    }

    protected $hidden = [
        'points','attendances'
    ];
}
