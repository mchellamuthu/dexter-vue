<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeacherGroupMember extends Model
{
    use SoftDeletes;
    protected $primaryKey = null;
    public $incrementing = false;
    protected $fillable = ['teacher_group_id','teacher_id'];


    public function group()
    {
        return $this->belongsTo('App\TeacherGroup');
    }
    public function teacher()
    {
        return $this->belongsTo('App\Teacher');
    }
}
