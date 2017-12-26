<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Attendance extends Model
{
    use Uuids;
    public $incrementing = false;
    protected $fillable = ['user_id','institute_id','class_room_id','date'];

    public function students()
    {
      return $this->belongsToMany('App\Student','users_attendance')->withTimestamps();
    }
}
