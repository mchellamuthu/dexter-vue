<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Validator;

class MyClassRoom extends Model
{
  use SoftDeletes;
  use Uuids;
  public $incrementing = false;
  protected $fillable = ['user_id','institute_id','class_id','role','teacher_id','parent_id','student_id'];
}
