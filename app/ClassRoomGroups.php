<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassRoomGroups extends Model
{
    use SoftDeletes;
    protected $primaryKey = null;
    public $incrementing = false;
    protected $fillable = ['class_room_id','class_group_id'];


    public function class_group()
    {
        return $this->belongsTo('App\ClassGroup','class_group_id','id');
    }
    public function classroom()
    {
        return $this->belongsTo('App\ClassRoom','class_room_id','id');
    }
}
