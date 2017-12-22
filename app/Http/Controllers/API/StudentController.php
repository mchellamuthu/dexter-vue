<?php

namespace App\Http\Controllers\API;

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
class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
    * @param  \Illuminate\Http\Request  $request
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
      $institute = MyInstitute::where(['institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true])->firstOrFail();
      $classroom =  ClassRoom::where(['id'=>$request->classroom,'institute_id'=>$institute_id])->firstOrFail();
      return response()->json(['status'=>'OK','data'=>'','errors'=>''], 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $validation = Validator::make($request->all(),[
          'fname.*'=>'required|string|max:255',
          'lname.*'=>'required|string|max:255',
          'email.*' => 'required|string|email|max:255',
          'avatar.*'=>'required|exists:user_avatars,avatar',
          'userId'=>'required|exists:users,id',
          'institute_id'=>'required|exists:institutes,id',
          'classroom'=>'required|exists:class_rooms,id',
      ]);
      // print_r($request->all());
      if ($validator->fails()) {
          return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
      }

          $user_id = $request->userId;
          $institute_id = $request->institute_id;
          $institute = MyInstitute::where(['institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true])->firstOrFail();
          $classroom = ClassRoom::where(['id'=>$request->classroom,'user_id'=>$user_id])->firstOrFail();

          foreach ($request->input('fname') as $key => $name) {
              $first_name = $request->input('fname')[$key];
              $last_name = $request->input('lname')[$key];
              $roll_no = $request->input('rollno')[$key];
              $email = $request->input('email')[$key];
              $avatar = $request->input('avatar')[$key];
              $mobileno = $request->input('mobile')[$key];
              $user  = User::firstOrCreate(['email'=>$email,'rollno'=>$roll_no],['first_name'=>$first_name,'last_name'=>$last_name]);
              $student = Student::firstOrCreate(['user_id'=>$user->id,'institute_id'=>$institute_id,'class_room_id'=>$request->classroom],['avatar'=>$avatar]);
          }
          if (!empty($student)) {
              return response()->json(['status'=>'success','msg'=>'Students has been added']);
          }else{
              return response()->json(['status'=>'failed','msg'=>'failed']);
          }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
      $validator = Validator::make($request->all(), [
        'userId'=>'required|exists:users,id',
        'institute_id'=>'required|exists:institutes,id',
        'classroom'=>'required|exists:class_rooms,id',
        'student'=>'required|exists:students,id',
      ]);
      if ($validator->fails()) {
          return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
      }
      $user_id = $request->userId;
      $institute_id = $request->institute_id;
      $institute = MyInstitute::where(['institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true])->firstOrFail();
      $classroom =  ClassRoom::where(['id'=>$request->classroom,'institute_id'=>$institute_id])->firstOrFail();
      $student   =  Student::where(['id'=>$request->student,'class_room_id'=>$request->classroom,'institute_id'=>$institute_id])->firstOrFail();
      $user = $student->user;
      return response()->json(['status'=>'OK','data'=>$student,'errors'=>''], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        //
    }
}
