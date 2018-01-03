<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parents extends Model
{
    use Uuids;
    public $incrementing = false;
    protected $fillable = ['user_id','institute_id'];
    public function students()
    {
        return $this->belongsToMany('Student', 'parent_students')->withTimestamps();
    }
}
