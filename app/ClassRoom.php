<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\SoftDeletes;

class ClassRoom extends Model
{
    use SoftDeletes;

    use Uuids;

    public $incrementing = false;

    protected $fillable = ['class_name', 'avatar', 'institute_id', 'class_teacher', 'status', 'user_id'];
}
