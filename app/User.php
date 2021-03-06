<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use Uuids;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->title} {$this->first_name} {$this->last_name}";
    }
    // public function getIdAttribute($value)
    // {
    //     return  Crypt::encryptString($value);
    // }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title','avatar','first_name','last_name', 'email', 'password','username','role','api_token','activation_token','active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','activation_token'
    ];


    public function my_institute()
    {
      return $this->hasOne('App\MyInstitute');
    }

    public function classrooms(){
      return $this->hasMany('App\MyClassRoom');
    }

    public function inbox()
    {
      return $this->hasMany('App\Message','msg_to','id');
    }

    public function send()
    {
      return $this->hasMany('App\Message','msg_from','id');
    }

    public function parent(){
      return $this->hasOne('App\Parents','user_id','id');
    }

    public function assignedclassrooms()
    {
      return $this->belongsToMany('App\ClassRoom','my_class_rooms','user_id','class_id')->withPivot(['id','user_id','institute_id','class_id','role','approved','admin'])->withTimestamps();

    }

}
