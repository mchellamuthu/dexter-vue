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

class StaffController extends Controller
{
    public function __construct()
    {
    }
    public function create(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'institute_id'=>'required|exists:institutes,id',
            'fname.*'=>'required|string|max:255',
            'lname.*'=>'required|string|max:255',
            'email.*' => 'required|string|email|max:255',
            'userId'=>'required|exists:users,id',
            'avatar.*'=>'required|exists:user_avatars,avatar',
        ]);
        // print_r($request->all());
        if ($validation->passes()) {
            $user_id = $request->userId;
            $institute_id = $request->institute_id;
            $institute = Institute::where(['id'=>$institute_id,'user_id'=>$user_id])->firstOrFail();
            foreach ($request->input('fname') as $key => $name) {
                $first_name = $request->input('fname')[$key];
                $last_name = $request->input('lname')[$key];
                $email = $request->input('email')[$key];
                $avatar = $request->input('avatar')[$key];

                if (User::where('email', $email)->count() > 0) {
                    $user = User::where('email', $email)->first();
                } else {
                    $user = User::insert(['first_name'=>$first_name,'last_name'=>$last_name,'email'=>$email,'active_token'=>'']);
                }
                if (Teacher::where(['user_id'=>$user->id,'institute_id'=>$institute_id])->count()===0) {
                    $data_set[] = ['user_id'=>$user->id,'avatar'=>$avatar,'institute_id'=>$id];
                }
            }
            if (!empty($data_set)) {
                $Myclassroom = Teacher::insert($data_set);
                return response()->json(['status'=>'success','msg'=>'Teacher has been added']);
            } else {
                return response()->json(['status'=>'failed','msg'=>'failed']);
            }
        }
        return response()->json(['status'=>'failed']);
    }

    public function createGroup(Request $request)
    {
        $validator = Validator::make($request->all(), [
          // 'institute_id'=>'required|exists:institutes,id',
          // 'userId'=>'required|exists:users,id',
          // 'staff.*'=>'required|exists:teachers,id',
          'group_name'=>'required|string|max:255',
      ]);
        if ($validator->fails()) {
            return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
        }
        $user_id = $request->userId;
        $institute_id = $request->institute_id;
        $institute = Institute::where(['id'=>$institute_id,'userId'=>$user_id])->firstOrFail();
        $teacher_group = TeacherGroup::firstOrCreate(['group_name'=>$request->group_name,'institute_id'=>$institute_id,'user_id'=>$user_id]);
        // Add members to group table
        $teacher_group->members()->sync($request->staff);
        return response()->json(['status'=>'success','msg'=>'Staff group was created successfully!']);
    }

    public function updateGroup(Request $request)
    {
        $validator = Validator::make($request->all(), [
          'userId'=>'required|exists:users,id',
          'staff.*'=>'required|exists:users,id',
          'group_name'=>'required|string|max:255',
          'group'=>'required|exists:teacher_groups,id',
      ]);
        if ($validator->fails()) {
            return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
        }
        $user_id = $request->userId;
        $teacher_group = TeacherGroup::where('id', $request->group)->firstOrFail();
        $teacher_group->update(['group_name'=>$request->group_name]);
        // Add members to group table
        $teacher_group->members()->sync($request->staff);
        return response()->json(['status'=>'success','msg'=>'Staff group was updated successfully!']);
    }



    public function removeGroup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'userId'=>'required|exists:users,id',
            'institute_id'=>'required|exists:institutes,id',
            'group'=>'required|exists:teacher_groups,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
        }
        $user_id = $request->userId;
        $institute_id = $request->institute_id;
        $institute = Institute::where(['id'=>$institute_id,'userId'=>$user_id])->firstOrFail();
        $group = TeacherGroup::where('id', $request->group)->firstOrFail();
        $group->members()->detach();
        $group->delete();
        return response()->json(['status'=>'success','msg'=>'Staff group was removed successfully!']);
    }

    public function getAllGroups(Request $request)
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
        $groups = $institute->groups;
        return response()->json(['status'=>'OK','data'=>$groups,'errors'=>'','institute'=>$institute_id], 200);
    }

    public function getAll(Request $request)
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
        $staffs = $institute->staffs;
        return response()->json(['status'=>'OK','data'=>$staffs,'errors'=>'','institute'=>$institute_id], 200);
    }
    public function getGroupMembers(Request $request)
    {
        $validator = Validator::make($request->all(), [
        'userId'=>'required|exists:users,id',
        'institute_id'=>'required|exists:institutes,id',
        'group'=>'required|exists:teacher_groups,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
        }
        $user_id = $request->userId;
        $institute_id = $request->institute_id;
        $group_id = $request->group;
        $institute = Institute::where(['id'=>$institute_id,'userId'=>$user_id])->firstOrFail();
        $group = TeacherGroup::where('id', $group_id)->firstOrFail();
        // Get All group members with name
        $group_members = $group->group_members->map(function ($item) {
            return ['_id'=>$item->teacher_id,'first_name'=>$item->teacher->user->first_name,'last_name'=>$item->teacher->user->last_name,'title'=>$item->teacher->user->title,'avatar'=>$item->teacher->avatar];
        });
        return  response()->json(['status'=>'OK','data'=>$group_members,'errors'=>'','institute'=>$institute_id], 200);
    }
}