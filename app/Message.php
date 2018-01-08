<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use Uuids;

    public $incrementing = false;

    protected $fillable = [
      'institute_id',
      'class_room_id',
      'msg_from',
      'msg_to',
      'message',
      'received_at',
      'read_at',
    ];

    public function sender()
    {
        return $this->belongsTo('App\User','msg_from','id');
    }

    public function receiver()
    {
        return $this->belongsTo('App\User','msg_to','id');
    }

    public function classroom()
    {
        return $this->belongsTo('App\ClassRoom','class_room_id','id');
    }




}
