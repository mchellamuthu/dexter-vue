<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Institute extends Model
{
  use Uuids;
  public $incrementing = false;

  protected $fillable = ['name', 'address', 'state', 'country', 'type', 'userId', 'avatar'];
}
