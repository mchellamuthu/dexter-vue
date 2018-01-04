<?php

namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\DB;

use App\ClassGroup;
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
use Webpatser\Uuid\Uuid;

class ClassGroupController extends Controller
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
        $classgroups = ClassGroup::where('institute_id', $institute_id)->get();
        return response()->json(['status'=>'OK','data'=>$classgroups,'errors'=>''], 200);
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
          'classroom.*'=>'required|exists:class_rooms,id|max:36',
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
        }
        $user_id = $request->userId;
        $institute_id = $request->institute_id;
        // get random avatars for group icon
        $avatar = DB::table('class_avatars')->orderBy(DB::raw('RAND()'))->first();
        $institute = MyInstitute::where(['institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true])->firstOrFail();
        $teacher_group = ClassGroup::firstOrCreate(['class_group_name'=>$request->group_name,'institute_id'=>$institute_id,'user_id'=>$user_id,'avatar'=>$avatar->avatar]);
        // Add members to group table
        $teacher_group->classrooms()->sync($request->classroom);
        return response()->json(['status'=>'success','data'=>$teacher_group,'msg'=>'Class group was created successfully!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ClassGroup  $classGroup
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $validator = Validator::make($request->all(), [
          'userId'=>'required|exists:users,id',
          'institute_id'=>'required|exists:institutes,id',
          'group'=>'required|exists:class_groups,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
        }

        $user_id = $request->userId;
        $institute_id = $request->institute_id;
        $institute = MyInstitute::where(['institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true])->firstOrFail();
        $class_group = ClassGroup::where('id', $request->group)->where('institute_id', $institute_id)->firstOrFail();
        // return $class_group->group_classrooms;
        $group_members = $class_group->group_classrooms->map(function ($item) {
            return ['_id'=>$item->class_room_id,'class_name'=>$item->classroom->class_name,'section'=>$item->classroom->section,'avatar'=>$item->classroom->avatar];
        });
        return  response()->json(['status'=>'OK','data'=>$group_members,'errors'=>'','institute'=>$institute_id], 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ClassGroup  $classGroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'userId'=>'required|exists:users,id',
            'institute_id'=>'required|exists:institutes,id',
            'group_name'=>'required|max:255',
            'group'=>'required|exists:class_groups,id',
            'classroom.*'=>'required|exists:class_rooms,id|max:36',
          ]);
        if ($validator->fails()) {
            return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
        }

        $user_id = $request->userId;
        $institute_id = $request->institute_id;
        $institute = MyInstitute::where(['institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true])->firstOrFail();
        $class_group = ClassGroup::where('id', $request->group)->firstOrFail();
        $class_group->update(['class_group_name'=>$request->group_name]);
        // Add members to group table
        $class_group->classrooms()->sync($request->classroom);
        return response()->json(['status'=>'success','data'=>$class_group,'msg'=>'Class group was updated successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ClassGroup  $classGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'userId'=>'required|exists:users,id',
            'institute_id'=>'required|exists:institutes,id',
            'group'=>'required|exists:class_groups,id',
          ]);
        if ($validator->fails()) {
            return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
        }

        $user_id = $request->userId;
        $institute_id = $request->institute_id;
        $institute = MyInstitute::where(['institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true])->firstOrFail();
        $class_group = ClassGroup::where('id', $request->group)->firstOrFail();
        $class_group->classrooms()->detach();
        $class_group->delete();
        return response()->json(['status'=>'success','msg'=>'Class group was removed successfully!']);
    }
}
