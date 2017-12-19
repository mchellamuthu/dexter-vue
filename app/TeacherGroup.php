<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeacherGroup extends Model
{
    use SoftDeletes;
    use Uuids;
    public $incrementing = false;
    protected $fillable = ['user_id','institute_id','group_name'];

    public function members()
    {
        return $this->belongsToMany('App\Teacher', 'teacher_group_members')->withTimestamps();
    }
    public function group_members()
    {
      return $this->hasMany('App\TeacherGroupMember');
    }
    public function institute()
    {
        return $this->belongsTo('App\Institute')->withTimestamps();
    }
}
