<?php

namespace App\Http\Controllers\API;

use App\Point;
use App\Skill;
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
use App\StudentGroup;
use App\GroupPoint;
class PointsController extends Controller
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
      'classroom'=>'required|exists:class_rooms,id',
      'student'=>'required|exists:students,id',
      'skill'=>'required|exists:skills,id',
    ]);
      if ($validator->fails()) {
          return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
      }
      $user_id = $request->userId;
      $institute_id = $request->institute_id;
      $institute = MyInstitute::where(['institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true])->firstOrFail();
      $classroom =  MyClassRoom::where(['class_id'=>$request->classroom,'institute_id'=>$institute_id,'approved'=>true])->firstOrFail();
      $student   =  Student::where(['id'=>$request->student,'class_room_id'=>$request->classroom,'institute_id'=>$institute_id])->firstOrFail();
      $Skill = Skill::where(['id'=>$request->skill,'class_room_id'=>$request->classroom])->firstOrFail();
      $points = Point::create([
        'skill_name'=>$Skill->skill_name,
        'point'=>$Skill->point_weight,
        'class_room_id'=>$request->classroom,
        'institute_id'=>$request->institute_id,
        'user_id'=>$request->userId,
        'student_id'=>$request->student,
        'type'=>$Skill->type,
      ]);
      return response()->json(['status'=>'OK','data'=>$student,'points'=>$points,'errors'=>''], 200);
    }

    /**
     * Group Points
     *
     * @param \Illuminate\Http\Request
     */
    public function groupPoints(Request $request)
    {
      $validator = Validator::make($request->all(), [
      'userId'=>'required|exists:users,id',
      'institute_id'=>'required|exists:institutes,id',
      'classroom'=>'required|exists:class_rooms,id',
      'students.*'=>'required|exists:students,id',
      'skill'=>'required|exists:skills,id',
      'group'=>'required|exists:student_groups,id',
    ]);
      if ($validator->fails()) {
          return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
      }
      $user_id = $request->userId;
      $institute_id = $request->institute_id;
      $institute = MyInstitute::where(['institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true])->firstOrFail();
      $myclassroom = MyClassRoom::where(['class_id'=>$request->classroom,'institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true]);
      $studentGroups  = StudentGroup::where('class_room_id',$request->classroom)->where('id',$request->group)->firstOrFail();
      $Skill = Skill::where(['id'=>$request->skill,'class_room_id'=>$request->classroom])->firstOrFail();
      $group_points = GroupPoint::create([
        'skill_name'=>$Skill->skill_name,
        'point'=>$Skill->point_weight,
        'class_room_id'=>$request->classroom,
        'institute_id'=>$request->institute_id,
        'user_id'=>$request->userId,
        'student_id'=>$request->student,
        'type'=>$Skill->type,
      ]);
      foreach ($request->students as $student) {
        $points = Point::create([
          'skill_name'=>$Skill->skill_name,
          'point'=>$Skill->point_weight,
          'class_room_id'=>$request->classroom,
          'institute_id'=>$request->institute_id,
          'user_id'=>$request->userId,
          'student_id'=>$student,
          'type'=>$Skill->type,
        ]);
      }
      $studentGroup  = StudentGroup::where('class_room_id',$request->classroom)->where('id',$request->group)->firstOrFail();
      $students = $studentGroup->students->map(function($item){
        return ['avatar'=>$item->avatar];
      });
        return response()->json(['status'=>'OK','data'=>$studentGroup,'points'=>$studentGroup->points->sum('point'),'students'=>$students,'errors'=>''], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getPointsByDate(Request $request)
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
      $classroom =  MyClassRoom::where(['class_id'=>$request->classroom,'institute_id'=>$institute_id,'approved'=>true])->firstOrFail();
     

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Point  $point
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Point $point)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Point  $point
     * @return \Illuminate\Http\Response
     */
    public function destroy(Point $point)
    {
        //
    }
}
