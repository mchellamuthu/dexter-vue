<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAttendance extends Model
{
  protected $primaryKey = null;
  public $incrementing = false;
  protected $table = 'users_attendance';
  protected $fillable = ['date','student_id','attendance_id'];
  public function attendance()
  {
    return $this->belongsTo('App\Attendance','attendance_id','id');
  }

  public function student()
  {
    return $this->belongsTo('App\Student','student_id','id');
  }
}
