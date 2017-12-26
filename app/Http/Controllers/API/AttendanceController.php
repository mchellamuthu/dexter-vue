<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Institute;
use App\Teacher;
use App\ClassRoom;
use App\MyClassRoom;
use App\Student;
use Validator;
use App\MyInstitute;

class AttendanceController extends Controller
{

  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'institute_id'=>'required|exists:institutes,id',
      'userId'=>'required|exists:users,id',
      'class_room'=>'required|exists:class_rooms,id',
      'skill'=>'required|exists:skills,id'
  ]);
    if ($validator->fails()) {
        return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
    }
  }
}
