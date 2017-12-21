<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
  use SoftDeletes;

  use Uuids;

  public $incrementing = false;
  protected $fillable = ['user_id','institute_id'];
}
