<?php
namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\StudentGroup;
use App\User;
use App\Institute;
use App\Teacher;
use App\Student;
use App\ClassRoom;
use App\MyClassRoom;
use Validator;
use App\MyInstitute;
use Webpatser\Uuid\Uuid;

class StudentGroupController extends Controller
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
      $institute = MyInstitute::where(['institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true])->firstOrFail();
      $myclassroom = MyClassRoom::where(['class_id'=>$request->classroom,'institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true]);
      $studentGroups  = StudentGroup::where('class_room_id',$request->classroom)->where('user_id',$user_id)->get();
      return response()->json(['status'=>'OK','data'=>$studentGroups,'errors'=>''], 200);
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
          'group_name'=>'required|max:255',
          'classroom'=>'required|exists:class_rooms,id|max:36',
          'students.*'=>'required|exists:students,id|max:36',
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
        }
        $user_id = $request->userId;
        $institute_id = $request->institute_id;
        $institute = MyInstitute::where(['institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true])->firstOrFail();
        $myclassroom = MyClassRoom::where(['class_id'=>$request->classroom,'institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true]);
        $studentGroup = StudentGroup::create([
          'group_name'=>$request->group_name,
          'institute_id'=>$request->institute_id,
          'user_id'=>$request->userId,
          'class_room_id'=>$request->classroom,
        ]);
          // Add members to group table
        $studentGroup->students()->sync($request->students);
        $students = $studentGroup->students->map(function($item){
          return ['avatar'=>$item->avatar];
        });
        return response()->json(['status'=>'success','data'=>$studentGroup,'students'=>$students,'msg'=>'Class group was created successfully!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\StudentGroup  $studentGroup
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
      $validator = Validator::make($request->all(), [
        'userId'=>'required|exists:users,id',
        'institute_id'=>'required|exists:institutes,id',
        'group_name'=>'required|max:255',
        'classroom'=>'required|exists:class_rooms,id|max:36',
        'students.*'=>'required|exists:students,id|max:36',
      ]);
      if ($validator->fails()) {
          return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
      }
      $user_id = $request->userId;
      $institute_id = $request->institute_id;
      $institute = MyInstitute::where(['institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true])->firstOrFail();
      $myclassroom = MyClassRoom::where(['class_id'=>$request->classroom,'institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true]);
      $studentGroup = StudentGroup::create([
        'group_name'=>$request->group_name,
        'institute_id'=>$request->institute_id,
        'user_id'=>$request->userId,
        'class_room_id'=>$request->classroom,
      ]);
        // Add members to group table
      $studentGroup->students()->sync($request->students);
      $students = $studentGroup->students->map(function($item){
        return ['avatar'=>$item->avatar];
      });
      return response()->json(['status'=>'success','data'=>$studentGroup,'students'=>$students,'msg'=>'Class group was created successfully!']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StudentGroup  $studentGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(StudentGroup $studentGroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StudentGroup  $studentGroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
      $validator = Validator::make($request->all(), [
        'userId'=>'required|exists:users,id',
        'institute_id'=>'required|exists:institutes,id',
        'group_name'=>'required|max:255',
        'group'=>'required|exists:student_groups,id|max:36',
        'classroom'=>'required|exists:class_rooms,id|max:36',
        'students.*'=>'required|exists:students,id|max:36',
      ]);
      if ($validator->fails()) {
          return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
      }
      $user_id = $request->userId;
      $institute_id = $request->institute_id;
      $institute = MyInstitute::where(['institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true])->firstOrFail();
      $myclassroom = MyClassRoom::where(['class_id'=>$request->classroom,'institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true]);
      $studentGroup = StudentGroup::findOrFail($request->group);
      $studentGroup ->update([
        'group_name'=>$request->group_name,
        'institute_id'=>$request->institute_id,
        'user_id'=>$request->userId,
        'class_room_id'=>$request->classroom,
      ]);
        // Add members to group table
      $studentGroup->students()->sync($request->students);
      $students = $studentGroup->students->map(function($item){
        return ['avatar'=>$item->avatar];
      });
      return response()->json(['status'=>'success','data'=>$studentGroup,'students'=>$students,'msg'=>'Class group was created successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StudentGroup  $studentGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(StudentGroup $studentGroup)
    {
        //
    }
}
