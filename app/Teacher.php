<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teacher extends Model
{
    use SoftDeletes;
    use Uuids;
    public $incrementing = false;
    protected $fillable = ['user_id','institute_id','avatar'];
    public function groups()
    {
        return $this->belongsToMany('App\TeacherGroup', 'teacher_group_members')->withTimestamps();
    }

    public function institute()
    {
        return $this->belongsTo('App\Institute');
    }

    public function teacher_groups()
    {
      return $this->hasMany('App\TeacherGroupMember');
    }
    public function user()
    {
      return $this->belongsTo('App\User');
    }
}
