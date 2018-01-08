<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Institute;
use App\Teacher;
use App\ClassRoom;
use App\MyClassRoom;
use Validator;
use App\MyInstitute;
use App\Student;
use App\Parents;
use App\StudentCode;
use PDF;
class InvitesController extends Controller
{

  public function DownloadInvites(Request $request)
  {
    $validator = Validator::make($request->all(), [
    'userId'=>'required|exists:users,id',
    'classroom'=>'required|exists:class_rooms,id',
  ]);
    if ($validator->fails()) {
        return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
    }

    $userId = $request->userId;
    $classroom =  MyClassRoom::where(['class_id'=>$request->classroom,'approved'=>true])->firstOrFail();
    $codes = StudentCode::where('class_room_id',$request->classroom)->get();
    $data['codes'] = $codes->map(function($item){
        return  [
          'student_first_name'=>$item->student->user->first_name,
          'student_last_name'=>$item->student->user->last_name,
          'class_room'=>$item->classroom->class_name,
          'code'=>$item->code,
      ];
    });
    $pdf = PDF::loadView('pdf', $data);
    return $pdf->download('invites.pdf');

  }



  public function downloadParentsCode($classroom){

  }
  public function downloadStudentsCode($classroom){

  }
}
