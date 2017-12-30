<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    protected $fillable = ['user_id','body','story_id'];

    public function user()
    {
        return $this->belongsTo('App\User', 'id', 'user_id');
    }
    public function story()
    {
        return $this->belongsTo('App\Story', 'id', 'story_id');
    }
}
