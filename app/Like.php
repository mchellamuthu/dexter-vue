<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Like extends Model
{
  use SoftDeletes;
  protected $fillable = ['user_id','story_id'];

  public function story()
  {
      return $this->belongsTo('App\Story');
  }
  public function user()
  {
      return $this->belongsTo('App\User');
  }
}
