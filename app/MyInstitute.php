<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MyInstitute extends Model
{
  use SoftDeletes;
  use Uuids;
  public $incrementing = false;
  protected $fillable = ['institute_id','user_id','approved'];

  public function user()
  {
    return $this->belongsTo('App\User','user_id','id');
  }
  public function institute()
  {
    return $this->belongsTo('App\Institute','institute_id','id');
  }

}
