<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Validator;
use App\Teacher;
use App\MyClassRoom;
use App\ClassRoom;

class TeacherController extends Controller
{
  public function assign(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'institute_id'=>'required|exists:institutes,id',
    'userId'=>'required|exists:users,id',
    'teacher'=>'required|exists:teachers,id',
    'classrooms.*'=>'required|exists:class_room,id',
    ]);
    if ($validator->fails()) {
        return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
    }
    $userId = $request->userId;
    $user = User::findOrFail($userId);
    $teacher = Teacher::findOrFail($request->teacher);
    $classrooms = MyClassRoom::where('user_id',$teacher->user_id)->where('institute_id',$request->institute_id)->where('admin','!=',$teacher->user_id);
    $classrooms->delete();
    foreach ($request->classrooms as $classroom) {
      $MyClassRoom = MyClassRoom::create(
        ['user_id'=>$teacher->user_id,
        'class_id'=>$classroom,
        'role'=>'Teacher',
        'approved'=>true,
        'institute_id'=>$request->institute_id]
      );
    }
    return response()->json(['status'=>'OK','msg'=>'Class rooms assigned successfully','errors'=>''], 200);
  }


}
