<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Story extends Model
{
    use SoftDeletes;
    use Uuids;
    public $incrementing = false;
    protected $fillable = ['user_id','institute_id','class_room_id','student_group_id','title','body','poster'];
    protected $hidden = ['classroom','institute','user','group','students'];

    public function classroom()
    {
        return $this->belongsTo('App\ClassRoom');
    }

    public function institute()
    {
        return $this->belongsTo('App\Institute');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function students()
    {
        return $this->hasMany('App\StudentStory');

    }
    public function group()
    {
        return $this->belongsTo('App\StudentGroup');

    }




}
