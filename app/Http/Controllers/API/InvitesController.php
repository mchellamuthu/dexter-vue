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
use App\ParentInvite;
use App\StudentInvite;
class InvitesController extends Controller
{

  public function DownloadInvites()
  {
    $validator = Validator::make($request->all(), [
    'userId'=>'required|exists:users,id',
    'classroom'=>'required|exists:class_rooms,id',
    'type'=>'required|in:Parent,Student',
  ]);
    if ($validator->fails()) {
        return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
    }

    $userId = $request->userId;


  }



  public function downloadParentsCode($classroom){
    
  }
  public function downloadStudentsCode($classroom){

  }
}
