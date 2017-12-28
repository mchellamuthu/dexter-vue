<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Institute;
use App\Teacher;
use App\ClassRoom;
use App\MyClassRoom;
use App\TeacherGroup;
use App\TeacherGroupMember;
use Validator;
use App\MyInstitute;
class ClassroomController extends Controller
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
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
        }
        $user_id = $request->userId;
        $institute_id = $request->institute_id;
        $institute = MyInstitute::where(['institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true])->firstOrFail();
        $user = User::findOrFail($user_id);
        $classrooms = $user->classrooms->map(function($item){
          if ($item->user_id===$item->classroom->user_id) {
            //check MyClassRoom is shared with others
            $myclass = MyClassRoom::where('class_id',$item->classroom->id)->where('user_id','!=',$item->user_id)->where('role','Teacher')->get();
            if ($myclass->count() > 0) {
              $shared = true;
            }else{
              $shared = false;
            }
          }else{
            $shared = true;
          }
          return [
            '_id'=>$item->classroom->id,
            'name'=>$item->classroom->class_name,
            'avatar'=>$item->classroom->avatar,
            'section'=>$item->classroom->section,
            'shared'=>$shared,
            'students'=>$item->classroom->students->count()
            ];
        });
        return response()->json(['status'=>'OK','data'=>$classrooms,'errors'=>''], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
        'userId'=>'required|exists:users,id',
        'institute_id'=>'required|exists:institutes,id',
          'class_name'=>'required|max:255',
          'avatar'=>'required|exists:class_avatars,avatar',
          'grade'=>'required|in:Pre-School,Kindergarten,1st Grade,2nd Grade,3rd Grade,4th Grade,5th Grade,6th Grade,7th Grade,8th Grade,9th Grade,10th Grade,11th Grade,12th Grade,Other,First Year,Second Year,Third Year,Fourth Year,Fifth Year',
      ]);
        if ($validator->fails()) {
            return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
        }
        $user_id = $request->userId;
        $institute = MyInstitute::where(['institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true])->firstOrFail();
        $avatar_img = $request->avatar;
        $classroom = ClassRoom::create([
          'class_name'=>$request->class_name,
          'avatar'=>$avatar_img,
          'section'=>$request->grade,
          'institute_id'=>$request->institute_id,
          'user_id'=>$user_id
      ]);
      $MyClassRoom = MyClassRoom::create(
        ['user_id'=>$request->userId,
        'class_id'=>$classroom->id,
        'role'=>'Teacher',
        'approved'=>true,
        'institute_id'=>$request->institute_id]
      );
        return  response()->json(['status'=>'OK','data'=>$classroom,'errors'=>'','institute'=>$request->institute_id], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
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
      // CHECK INSTITUTE
      $institute = MyInstitute::where(['institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true])->firstOrFail();
      // CHECK MY CLASSROOM
      $classroom = MyClassRoom::where(['class_id'=>$request->classroom,'user_id'=>$user_id,'approved'=>true])->firstOrFail();
      // GET ALL STUDENTS FROM CLASSROOM
      $students = $classroom->classroom->students->map(function($item){
        return [
          '_id'=>$item->id,
          'first_name'=>$item->user->first_name,
          'last_name'=>$item->user->last_name,
          'title'=>$item->user->title,
          'email'=>$item->user->email,
          'roll_no'=>$item->rollno,
          'avatar'=>$item->avatar,
        ];
      });
      //RESPONSE  DATA
      $classroom_data = [
        'class_room'=> [
          '_id'=>$classroom->classroom->id,
          'class_name'=>$classroom->classroom->class_name,
          'avatar'=>$classroom->avatar,
          'section'=>$classroom->section,
        ],
        'students'=>$students,
      ];
      return response()->json(['status'=>'OK','data'=>$classroom_data,'errors'=>$validator->messages()], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ClassRoom  $classRoom
     * @return \Illuminate\Http\Response
     */
    public function edit(ClassRoom $classRoom)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ClassRoom  $classRoom
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
          'userId'=>'required|exists:users,id',
          'institute_id'=>'required|exists:institutes,id',
          'classroom'=>'required|exists:class_rooms,id',
          'class_name'=>'required|max:255',
          'avatar'=>'required|exists:class_avatars,avatar',
          'grade'=>'required|in:Pre-School,Kindergarten,1st Grade,2nd Grade,3rd Grade,4th Grade,5th Grade,6th Grade,7th Grade,8th Grade,9th Grade,10th Grade,11th Grade,12th Grade,Other,First Year,Second Year,Third Year,Fourth Year,Fifth Year',
      ]);
        if ($validator->fails()) {
            return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
        }
        $user_id = $request->userId;
        $institute_id = $request->institute_id;
        $institute = MyInstitute::where(['institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true])->firstOrFail();
        $myclassroom = MyClassRoom::where(['institute_id'=>$request->institute_id,'user_id'=>$user_id,'class_id'=>$request->classroom,'approved'=>true])->firstOrFail();
        $ClassRoom = ClassRoom::where('id', $request->classroom)->firstOrFail();
        $avatar_img = $request->avatar;
        $classroom_up = $ClassRoom->update([
        'class_name'=>$request->class_name,
        'avatar'=>$avatar_img,
        'section'=>$request->grade,
        ]);
        return  response()->json(['status'=>'OK','data'=>$classroom_up,'errors'=>'','institute'=>$request->institute_id], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
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
        $ClassRoom = MyClassRoom::where('class_id', $request->classroom)->where('user_id',$user_id)->where('approved',true)->firstOrFail();
        $ClassRoom->delete();
        return response()->json(['status'=>'success','msg'=>'Classroom was archieved successfully!']);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request)
    {
        $validator = Validator::make($request->all(), [
        'userId'=>'required|exists:users,id',
        'institute_id'=>'required|exists:institutes,id',
         'classroom'=>'required|exists:class_rooms,id',
        // 'classroom'=>'required|exists:class_rooms,id',
    ]);
        if ($validator->fails()) {
            return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
        }
        $user_id = $request->userId;
        $institute_id = $request->institute_id;
        $institute = MyInstitute::where(['institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true])->firstOrFail();
        $ClassRoom = MyClassRoom::onlyTrashed()->where('class_id', $request->classroom)->firstOrFail();
        $ClassRoom->restore();
        return response()->json(['status'=>'success','data'=>$ClassRoom,'msg'=>'Classroom was restored successfully!']);
    }

    /**
     * Get All archieved classrooms
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function archievedClassrooms(Request $request)
    {
        $validator = Validator::make($request->all(), [
        'userId'=>'required|exists:users,id',
        'institute_id'=>'required|exists:institutes,id',
          ]);
        if ($validator->fails()) {
            return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
        }
        $user_id = $request->userId;
        $institute_id = $request->institute_id;
        $institute = MyInstitute::where(['institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true])->firstOrFail();
        $ClassRoom = ClassRoom::onlyTrashed()->where('institute_id', $request->institute_id)->get();
        return response()->json(['status'=>'success','data'=>$ClassRoom,'msg'=>'Classroom was restored successfully!']);
    }
}
