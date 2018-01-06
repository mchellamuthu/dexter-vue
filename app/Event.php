<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
  use Uuids;
  /**
   * Indicates if the IDs are auto-incrementing.
   *
   * @var bool
   */
  public $incrementing = false;
  protected $fillable = [
    'title',
    'description',
    'start',
    'end',
    'icon',
    'user_id',
    'institute_id',
    'textColor','color',
    'url',
  ];
  protected $hidden = ['user','created_at','updated_at'];
  public function user()
  {
      return $this->belongsTo(App\User::class);
  }
}
