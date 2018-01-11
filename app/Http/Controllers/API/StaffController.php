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
use Webpatser\Uuid\Uuid;

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
        if ($validation->passes()) {
            $user_id = $request->userId;
            $institute_id = $request->institute_id;
            $institute = MyInstitute::where(['institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true])->firstOrFail();
            foreach ($request->input('fname') as $key => $name) {
                $first_name = $request->input('fname')[$key];
                $last_name = $request->input('lname')[$key];
                $email = $request->input('email')[$key];
                $avatar = $request->input('avatar')[$key];
                $user  = User::firstOrCreate(['email'=>$email], ['first_name'=>$first_name,'last_name'=>$last_name]);
                $teacher[]  = Teacher::firstOrCreate(['user_id'=>$user->id,'institute_id'=>$institute_id], ['avatar'=>$avatar]);
            }
            if (!empty($teacher)) {
                $teacher = collect($teacher);
                $teachers = $teacher->map(function ($row) {
                    return ['_id'=>$row->id,'user'=>$row->user->id,'avatar'=>$row->avatar,'first_name'=>$row->user->first_name,'last_name'=>$row->user->last_name];
                });
                return response()->json(['status'=>'success','data'=>$teachers,'msg'=>'Teacher has been added']);
            } else {
                return response()->json(['status'=>'failed','msg'=>'failed']);
            }
        }
        return response()->json(['status'=>'failed']);
    }

    public function createGroup(Request $request)
    {
        $validator = Validator::make($request->all(), [
          'institute_id'=>'required|exists:institutes,id',
          'userId'=>'required|exists:users,id',
          'staff.*'=>'required|exists:teachers,id',
          'group_name'=>'required|string|max:255',
      ]);
        if ($validator->fails()) {
            return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
        }
        $user_id = $request->userId;
        $institute_id = $request->institute_id;
        $institute = MyInstitute::where(['institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true])->firstOrFail();
        $teacher_group = TeacherGroup::firstOrCreate(['group_name'=>$request->group_name,'institute_id'=>$institute_id,'user_id'=>$user_id]);
        // Add members to group table
        $teacher_group->members()->sync($request->staff);
        return response()->json(['status'=>'success','data'=>$teacher_group,'msg'=>'Staff group was created successfully!']);
    }

    public function updateGroup(Request $request)
    {
        $validator = Validator::make($request->all(), [
          'userId'=>'required|exists:users,id',
          'staff.*'=>'required|exists:teachers,id',
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
        return response()->json(['status'=>'success','data'=>$teacher_group,'msg'=>'Staff group was updated successfully!']);
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
        $institute = MyInstitute::where(['institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true])->firstOrFail();
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
        $institute = MyInstitute::where(['institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true])->firstOrFail();
        $groups = $institute->institute->groups;
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
        $institute = MyInstitute::where(['institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true])->firstOrFail();
        $staffs = $institute->institute->staffs;
        $staff_data  = $staffs->map(function ($item) {
            return [
              '_id'=>$item->id,
              'first_name'=>$item->user->first_name,
              'last_name'=>$item->user->last_name,
              'full_name'=>$item->user->full_name,
              'email'=>$item->user->email,
              'user'=>$item->user->id,
              'avatar'=>$item->avatar,
              ];
        });
        return response()->json(['status'=>'OK','data'=>$staff_data,'errors'=>'','institute'=>$institute_id], 200);
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
        $institute = MyInstitute::where(['institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true])->firstOrFail();
        $group = TeacherGroup::where('id', $group_id)->firstOrFail();
        // Get All group members with name
        $group_members = $group->group_members->map(function ($item) {
            return ['_id'=>$item->teacher_id,'first_name'=>$item->teacher->user->first_name,'last_name'=>$item->teacher->user->last_name,'title'=>$item->teacher->user->title,'avatar'=>$item->teacher->avatar];
        });
        return  response()->json(['status'=>'OK','data'=>$group_members,'errors'=>'','institute'=>$institute_id], 200);
    }

    public function removeStaff(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'userId'=>'required|exists:users,id',
            'institute_id'=>'required|exists:institutes,id',
            'staff'=>'required|exists:teachers,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
        }
        $user_id = $request->userId;
        $institute_id = $request->institute_id;
        $staff_id = $request->staff;
        $institute = MyInstitute::where(['institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true])->firstOrFail();
        $staff = Teacher::where('id', $staff_id)->firstOrFail();
        $classrooms = MyClassRoom::where('user_id',$staff->user_id)->where('institute_id',$request->institute_id);
        $classrooms->delete();
        $staff->groups()->detach();
        $staff->delete();
        return response()->json(['status'=>'success','msg'=>'Staff was removed successfully!']);
    }
    public function updateStaff(Request $request)
    {
        $validator = Validator::make($request->all(), [
          'userId'=>'required|exists:users,id',
          'institute_id'=>'required|exists:institutes,id',
          'staff'=>'required|exists:teachers,id',
          'staff_first_name'=>'required|string|max:255',
          'staff_last_name'=>'required|string|max:255',
          'staff_avatar'=>'required|exists:user_avatars,avatar',
          'staff_title'=>'required|string|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
        }
        $user_id = $request->userId;
        $institute_id = $request->institute_id;
        $staff_id = $request->staff;
        $staff_first_name = $request->staff_first_name;
        $staff_last_name = $request->staff_last_name;
        $staff_avatar = $request->staff_avatar;
        $staff_title = $request->staff_title;

        $institute = MyInstitute::where(['institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true])->firstOrFail();

        $staff = Teacher::where('id', $staff_id)->firstOrFail();
        $user = User::where(['id'=>$staff->user_id])->firstOrFail();
        $user->update([
          'first_name' => $staff_first_name,
          'last_name' => $staff_last_name,
          'title' => $title,
        ]);
        $staff->update([
          'avatar'=>$staff_avatar,
        ]);
        return response()->json(['status'=>'success','msg'=>'Staff was removed successfully!']);
    }
}
