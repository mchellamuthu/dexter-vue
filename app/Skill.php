<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use Uuids;
    public $incrementing = false;
    protected $fillable = ['user_id','institute_id','icon','class_room_id','point_weight','skill_name','type'];

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
}
