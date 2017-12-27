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
    protected $hidden = ['students','user','points','institute'];
    public function students()
    {
        return $this->belongsToMany('App\Student', 'student_group_members')->withTimestamps();
    }
    public function institute()
    {
        return $this->belongsTo('App\Institute', 'institute_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
    public function points()
    {
        return $this->hasMany('App\Point', 'student_group_id', 'id');
    }
}
