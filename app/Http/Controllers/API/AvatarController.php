<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Validator;

class AvatarController extends Controller
{
    public function __construct()
    {
    }

    public function getall(Request $request)
    {
        $validator = Validator::make($request->all(), [
        'userId'=>'required|exists:users,id',
        'type'=>'required|in:Classroom,Institute,Students,Skills'
      ]);
        if ($validator->fails()) {
            return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
        }
        if ($request->type=="Classroom" or $request->type=="Institute") {
            $data = DB::table('class_avatars')->get();
        } elseif ($request->type=="Student") {
            $data = DB::table('user_avatars')->get();
        } elseif ($request->type=="Skills") {
            $data = DB::table('skill_icons')->get();
        } else {
            return response()->json(['status'=>'OK','data'=>'','errors'=>'invalid request'], 200);
        }

        return response()->json(['status'=>'OK','data'=>$data,'errors'=>''], 200);
    }
}
