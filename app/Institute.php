<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Institute extends Model
{
  use Uuids;
  public $incrementing = false;

  protected $fillable = ['name', 'address', 'state', 'country','city', 'type', 'userId', 'avatar'];

  public function scopeSearchByKeyword($query, $keyword)
  {
      if ($keyword!='') {
          $query->where(function ($query) use ($keyword) {
              $query->where("name", "LIKE", "%$keyword%")
                  ->orWhere("city", "LIKE", "%$keyword%")
                  ->orWhere("state", "LIKE", "%$keyword%")
                  ->orWhere("country", "LIKE", "%$keyword%");
          });
      }
      return $query;
  }

  public function groups()
  {
    return $this->hasMany('App\TeacherGroup');
  }
  public function classrooms()
  {
    return $this->hasMany('App\ClassRoom');
  }
  public function shared()
  {
    return $this->hasMany('App\MyInstitute');
  }
  public function staffs()
  {
    return $this->hasMany('App\Teacher');
  }
}
