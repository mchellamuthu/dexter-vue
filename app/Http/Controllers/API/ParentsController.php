<?php

namespace App\Http\Controllers\API;

use App\Parents;
use App\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Institute;
use App\Teacher;
use App\ClassRoom;
use App\MyClassRoom;
use Validator;
use App\MyInstitute;
// use App\ParentInvite;
class ParentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $validator = Validator::make($request->all(), [
      'userId'=>'required|exists:users,id',
      'institute_id'=>'required|exists:institutes,id',
      'classroom'=>'required|exists:class_rooms,id',
    ]);
      if ($validator->fails()) {
          return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
      }
      $user_id = $request->userId;
      $institute_id = $request->institute_id;
      $Parents = Parents::where('user_id',$request->userId)->firstOrFail();
      $parent_info = $Parents->students;
      return response()->json(['status'=>'OK','data'=>$Parents,'errors'=>''], 200);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function Invite(Request $request)
    {
      $validator = Validator::make($request->all(), [
      'userId'=>'required|exists:users,id',
      'institute_id'=>'required|exists:institutes,id',
      'classroom'=>'required|exists:class_rooms,id',
      'student'=>'required|exists:students,id',
      'email'=>'required|string|email',
    ]);
      if ($validator->fails()) {
          return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
      }
      $user_id = $request->userId;
      $institute_id = $request->institute_id;
      $email = $request->email;
      $classroom =  ClassRoom::where(['id'=>$request->classroom,'institute_id'=>$institute_id])->firstOrFail();
      $user  = User::firstOrCreate(['email'=>$email]);
      $parents = Parents::firstOrCreate(['user_id'=>$user->id]);
      $student   =  Student::where(['id'=>$request->student,'class_room_id'=>$request->classroom])->firstOrFail();
      $code = 'P'.strtoupper(substr(uniqid(),0,6));
      $sync_data = [$request->student=>['status'=>'Invite_Send','parent_code'=>$code,'class_room_id'=>$request->classroom,'institute_id'=>$request->institute_id]];
      $parents->students()->sync($sync_data);
      // Generate Code

      // $InviteCode = ParentInvite::updateOrCreate([
      //   'parents_id'=>$parents->id,
      //   'student_id'=>$request->student,
      //   'class_room_id'=>$request->classroom,
      //   'user_id'=>$request->user_id,
      //   'code'=>$code,
      // ]);
      //
      $parents_list =  $student->parents->map(function($item){
          return [
          '_id'=>$item->id,
          'user'=>$item->user,
          'status'=>$item->pivot->status
          ];
      });
      return response()->json(['status'=>'OK','data'=>$parents_list,'errors'=>''], 200);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Parents  $parents
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
      dd($request->all());
      $validator = Validator::make($request->all(), [
      'userId'=>'required|exists:users,id',
      'parents'=>'required|exists:parents,id',
    ]);
      if ($validator->fails()) {
          return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
      }
      $user_id = $request->userId;
      $parents = Parents::where('id',$request->parents)->firstOrFail();
      return response()->json(['status'=>'OK','data'=>'','errors'=>''], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Parents  $parents
     * @return \Illuminate\Http\Response
     */
    public function edit(Parents $parents)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Parents  $parents
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Parents $parents)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Parents  $parents
     * @return \Illuminate\Http\Response
     */
    public function destroy(Parents $parents)
    {
        //
    }
}
