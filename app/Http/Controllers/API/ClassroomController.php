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

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $institute = Institute::where(['id'=>$request->institute_id,'userId'=>$user_id])->firstOrFail();
        $avatar_img = $request->avatar;
        $classroom = ClassRoom::create([
          'class_name'=>$request->class_name,
          'avatar'=>$avatar_img,
          'section'=>$request->grade,
          'institute_id'=>$request->institute_id,
          'user_id'=>$user_id
      ]);
        return  response()->json(['status'=>'OK','data'=>$classroom,'errors'=>'','institute'=>$request->institute_id], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ClassRoom  $classRoom
     * @return \Illuminate\Http\Response
     */
    public function show(ClassRoom $classRoom)
    {
        //
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
        $institute = Institute::where(['id'=>$institute_id,'userId'=>$user_id])->firstOrFail();
        $ClassRoom = ClassRoom::where('id', $request->classroom)->firstOrFail();
        $avatar_img = $request->avatar;
        $classroom_up = $ClassRoom->update([
        'class_name'=>$request->class_name,
        'avatar'=>$avatar_img,
        'section'=>$request->grade,
        'user_id'=>$user_id
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
        $institute = Institute::where(['id'=>$institute_id,'userId'=>$user_id])->firstOrFail();
        $ClassRoom = ClassRoom::where('id', $request->classroom)->firstOrFail();
        // $ClassRoom->groups()->detach();
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
        $institute = Institute::where(['id'=>$institute_id,'userId'=>$user_id])->firstOrFail();
        $ClassRoom = ClassRoom::onlyTrashed()->where('id', $request->classroom)->firstOrFail();
        $ClassRoom->restore();
        return response()->json(['status'=>'success','msg'=>'Classroom was restored successfully!']);
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
        $institute = Institute::where(['id'=>$institute_id,'userId'=>$user_id])->firstOrFail();
        $ClassRoom = ClassRoom::onlyTrashed()->where('institute_id', $request->institute_id)->get();
        return response()->json(['status'=>'success','data'=>$ClassRoom,'msg'=>'Classroom was restored successfully!']);
    }
}
