<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JoinRquest extends Model
{
  use SoftDeletes;

  use Uuids;

  public $incrementing = false;
  protected $fillable = ['user_id','institute_id'];
  public function institute()
  {
    return $this->belongsTo(Institute::class);
  }
  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
