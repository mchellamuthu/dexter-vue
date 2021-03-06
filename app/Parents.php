<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parents extends Model
{
    use Uuids;
    public $incrementing = false;
    protected $fillable = ['user_id'];
    public function students()
    {
        return $this->belongsToMany('App\Student', 'parent_students')->withPivot(['status','class_room_id','institute_id'])->withTimestamps();
    }
}
