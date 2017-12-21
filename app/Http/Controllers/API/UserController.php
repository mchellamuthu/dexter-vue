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

class UserController extends Controller
{
  /**
   * get all info for authenticated user
   * @Method POST
   * @userId Send authenticated user's id
   * @return \Illuminate\Http\Response JSON
   */
    public function getUserinfo(Request $request)
    {
        $validator = Validator::make($request->all(), [
      'userId'=>'required|exists:users,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
        }
        $user_id = $request->userId;
        $user = User::where('id', $user_id)->firstOrFail();
        $users = User::where('id', $user_id)->get();
        $user_data = $users->map(function ($item) {
            if ($item->my_institute!==null) {
                $institute_data = [
            '_id'=> $item->my_institute->institute_id,
            'approved'=> $item->my_institute->approved,
            'institute_name'=> $item->my_institute->institute->name,
            'institute_address'=> $item->my_institute->institute->address,
            'institute_city'=> $item->my_institute->institute->city,
            'institute_state'=> $item->my_institute->institute->state,
            'institute_country'=> $item->my_institute->institute->country,
            'institute_type'=> $item->my_institute->institute->type,
            'institute_avatar'=> $item->my_institute->institute->avatar,];
            } else {
                $institute_data =null;
            }
            return [
            '_id'=>$item->id,
            'title'=>$item->title,
            'first_name'=>$item->first_name,
            'last_name'=>$item->last_name,
            'full_name'=>$item->full_name,
            'email'=>$item->email,
            'api_token'=>$item->api_token,
            'avatar'=>$item->avatar,
            'role'=>$item->role,
            'institute'=>$institute_data

        ];
        });
        return response()->json(['status'=>'OK','data'=>$user_data,'errors'=>''], 200);
    }
}
