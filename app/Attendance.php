<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Attendance extends Model
{
    use Uuids;
    public $incrementing = false;
    protected $fillable = ['user_id','institute_id','avatar','class_room_id','group_name'];

}
