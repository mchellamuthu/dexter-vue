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
use App\Attendance;
class AttendanceController extends Controller
{

  public function store(Request $request)
  {
    // dd($request->student['id'  ]);
    $validator = Validator::make($request->all(), [
      'institute_id'=>'required|exists:institutes,id',
      'userId'=>'required|exists:users,id',
      'classroom'=>'required|exists:class_rooms,id',
      'student[id].*'=>'required|exists:students,id',
      'student[status].*'=>'required|in:Absent,Present,Late,Leave Early'
  ]);
    if ($validator->fails()) {
        return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
    }
    $user_id = $request->userId;
    $institute_id = $request->institute_id;
    // $institute = MyInstitute::where(['institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true])->firstOrFail();
    $myclassroom = MyClassRoom::where(['class_id'=>$request->classroom,'institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true]);
    $attendance = Attendance::firstOrCreate(['date'=>date('Y-m-d'),'class_room_id'=>$request->classroom],['institute_id'=>$request->institute_id,'user_id'=>$request->userId]);
    $students = $request->student['id'];
    $sync_data = [];
    for ($i=0; $i < count($students); $i++) {
      $sync_data[$students[$i]] = ['date'=>date('Y-m-d'),'status'=>$request->student['status'][$i]];
    }
    $attendance->students()->sync($sync_data);

    return response()->json(['status'=>'success','data'=>$attendance,'msg'=>'Attendance was saved successfully!']);

  }

  public function GetAttendance(Request $request)
  {
    // dd($request->student['id'  ]);
    $validator = Validator::make($request->all(), [
      'institute_id'=>'required|exists:institutes,id',
      'userId'=>'required|exists:users,id',
      'classroom'=>'required|exists:class_rooms,id',

  ]);
    if ($validator->fails()) {
        return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
    }
    $user_id = $request->userId;
    $institute_id = $request->institute_id;
    $myclassroom = MyClassRoom::where(['class_id'=>$request->classroom,'institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true]);
    $attendance = Attendance::where(['date'=>date('Y-m-d'),'class_room_id'=>$request->classroom,'institute_id'=>$request->institute_id])->firstOrFail();
  }
}
