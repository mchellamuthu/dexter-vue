<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParentInvite extends Model
{
    use Uuids;
    public $incrementing = false;
    protected $fillable = ['user_id','class_room_id','student_id','parents_id','code','expired_at'];
    protected $hidden = ['user','student','parents','classroom'];

    public function user()
    {
      return $this->belongsTo('App\User','user_id','id');
    }
    public function student()
    {
      return $this->belongsTo('App\Student','student_id','id');
    }
    public function parents()
    {
      return $this->belongsTo('App\Parents','parents_id','id');
    }
    public function classroom()
    {
      return $this->belongsTo('App\ClassRoom','class_room_id','id');
    }
}
