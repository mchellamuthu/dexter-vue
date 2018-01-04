<?php

namespace App\Http\Controllers\API;


use App\User;
use App\Institute;
use App\ClassRoom;
use App\MyClassRoom;
use Validator;
use App\MyInstitute;
use App\Skill;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $validator = Validator::make($request->all(), [
        'institute_id'=>'required|exists:institutes,id',
        'userId'=>'required|exists:users,id',
        'class_room'=>'required|exists:class_rooms,id',
    ]);
      if ($validator->fails()) {
          return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
      }
      $user_id = $request->userId;
      $institute_id = $request->institute_id;
      $institute = MyInstitute::where(['institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true])->firstOrFail();
      $myclassroom = MyClassRoom::where(['class_id'=>$request->class_room,'institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true])->firstOrFail();
      $classroom = ClassRoom::where(['id'=>$request->class_room,'institute_id'=>$request->institute_id,'user_id'=>$user_id])->firstOrFail();
      $skills = $classroom->skills;
      return response()->json(['status'=>'OK','data'=>['classroom'=>$classroom,'skills'=>$skills],'errors'=>'']);
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
        'institute_id'=>'required|exists:institutes,id',
        'userId'=>'required|exists:users,id',
        'class_room'=>'required|exists:class_rooms,id',
        'name'=>'required|string|max:255',
        'points'=>'required|integer|max:11',
        'icon'=>'required|exists:skill_icons,avatar',
        'type'=>'required|in:Positive,Negative'
      ]);
      if ($validator->fails()) {
          return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
      }
      $user_id = $request->userId;
      $institute_id = $request->institute_id;
      $institute = MyInstitute::where(['institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true])->firstOrFail();
      $myclassroom = MyClassRoom::where(['class_id'=>$request->class_room,'institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true])->firstOrFail();
      $classroom = ClassRoom::where(['id'=>$request->class_room,'institute_id'=>$request->institute_id])->firstOrFail();
      // $skills = $classroom->skills;
      $skill = Skill::create([
        'skill_name'=>$request->name,
        'icon'=>$request->icon,
        'point_weight'=>$request->points,
        'type'=>$request->type,
        'class_room_id'=>$request->class_room,
        'institute_id'=>$request->institute_id,
        'user_id'=>$request->userId,
      ]);
      return response()->json(['status'=>'OK','data'=>['classroom'=>$classroom,'skill'=>$skill],'errors'=>'']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Skill  $skill
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
      $validator = Validator::make($request->all(), [
        'institute_id'=>'required|exists:institutes,id',
        'userId'=>'required|exists:users,id',
        'class_room'=>'required|exists:class_rooms,id',
        'skill'=>'required|exists:skills,id'
    ]);
      if ($validator->fails()) {
          return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
      }
      $user_id = $request->userId;
      $institute_id = $request->institute_id;
      $institute = MyInstitute::where(['institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true])->firstOrFail();
      $myclassroom = MyClassRoom::where(['class_id'=>$request->class_room,'institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true])->firstOrFail();
      $classroom = ClassRoom::where(['id'=>$request->class_room,'institute_id'=>$request->institute_id])->firstOrFail();
      $skill = Skill::where(['id'=>$request->skill,'institute_id'=>$request->institute_id,'class_room_id'=>$request->class_room])->firstOrFail();
      return response()->json(['status'=>'OK','data'=>['classroom'=>$classroom,'skill'=>$skill],'errors'=>'']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Skill  $skill
     * @return \Illuminate\Http\Response
     */
    public function edit(Skill $skill)
    {
        //
    }

    /**$skill
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
      $validator = Validator::make($request->all(), [
        'institute_id'=>'required|exists:institutes,id',
        'userId'=>'required|exists:users,id',
        'class_room'=>'required|exists:class_rooms,id',
        'skill'=>'required|exists:skills,id',
        'name'=>'required|string|max:255',
        'points'=>'required|integer|max:11',
        'icon'=>'required|exists:skill_icons,avatar',
        'type'=>'required|in:Positive,Negative'
    ]);
      if ($validator->fails()) {
          return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
      }
      $user_id = $request->userId;
      $institute_id = $request->institute_id;
      $institute = MyInstitute::where(['institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true])->firstOrFail();
      $myclassroom = MyClassRoom::where(['class_id'=>$request->class_room,'institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true])->firstOrFail();
      $classroom = ClassRoom::where(['id'=>$request->class_room,'institute_id'=>$request->institute_id])->firstOrFail();
      $skill = Skill::where(['id'=>$request->skill,'institute_id'=>$request->institute_id,'class_room_id'=>$request->class_room])->firstOrFail();
      $skill->update([
        'skill_name'=>$request->name,
        'icon'=>$request->icon,
        'point_weight'=>$request->points,
        'type'=>$request->type,
      ]);
      return response()->json(['status'=>'OK','data'=>['classroom'=>$classroom,'skill'=>$skill],'errors'=>'']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Skill  $skill
     * @return \Illuminate\Http\Response
     */
    public function destroy(Skill $skill)
    {
      $validator = Validator::make($request->all(), [
        'institute_id'=>'required|exists:institutes,id',
        'userId'=>'required|exists:users,id',
        'class_room'=>'required|exists:class_rooms,id',
        'skill'=>'required|exists:skills,id'
    ]);
      if ($validator->fails()) {
          return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
      }
      $user_id = $request->userId;
      $institute_id = $request->institute_id;
      $institute = MyInstitute::where(['institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true])->firstOrFail();
      $myclassroom = MyClassRoom::where(['class_id'=>$request->class_room,'institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true])->firstOrFail();
      $classroom = ClassRoom::where(['id'=>$request->class_room,'institute_id'=>$request->institute_id])->firstOrFail();
      $skill = Skill::where(['id'=>$request->skill,'institute_id'=>$request->institute_id,'class_room_id'=>$request->class_room])->firstOrFail();
      $skill->delete();
      return response()->json(['status'=>'OK','data'=>$classroom,'errors'=>'','msg'=>'Skill was removed successfully']);
    }
}
