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
use DateTime;

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

    public function ClassRoomPoints(Request $request)
    {
      $validator = Validator::make($request->all(), [
      'userId'=>'required|exists:users,id',
      'institute_id'=>'required|exists:institutes,id',
      'classroom'=>'required|exists:class_rooms,id',
      'students.*'=>'required|exists:students,id',
      'skill'=>'required|exists:skills,id',
    ]);
      if ($validator->fails()) {
          return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
      }
      $user_id = $request->userId;
      $institute_id = $request->institute_id;
      $institute = MyInstitute::where(['institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true])->firstOrFail();
      $myclassroom =  MyClassRoom::where(['class_id'=>$request->classroom,'institute_id'=>$institute_id,'approved'=>true])->firstOrFail();
      $classroom =  ClassRoom::where(['id'=>$request->classroom,'institute_id'=>$institute_id])->firstOrFail();
      $Skill = Skill::where(['id'=>$request->skill,'class_room_id'=>$request->classroom])->firstOrFail();
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
      $students = $classroom->students->map(function($row){
          return ['_id'=>$row->id,'avatar'=>$row->avatar,'first_name'=>$row->user->first_name,'last_name'=>$row->user->last_name,'user_id'=>$row->user_id,'points'=>$row->points->sum('point')];
      });
      return response()->json(['status'=>'OK','data'=>$students,'errors'=>''], 200);
    }

    // $student   =  Student::where(['id'=>$request->student,'class_room_id'=>$request->classroom,'institute_id'=>$institute_id])->firstOrFail();

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
        'student_group_id'=>$request->group,
        'type'=>$Skill->type,
      ]);
      foreach ($studentGroups->students as $student) {
        $points = Point::create([
          'skill_name'=>$Skill->skill_name,
          'point'=>$Skill->point_weight,
          'class_room_id'=>$request->classroom,
          'institute_id'=>$request->institute_id,
          'user_id'=>$request->userId,
          'student_id'=>$student->id,
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
      'start_date'=>'required|date',
      'end_date'=>'required|date',
    ]);
    if ($validator->fails()) {
        return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
    }
      $user_id = $request->userId;
      $institute_id = $request->institute_id;
      $institute = MyInstitute::where(['institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true])->firstOrFail();
      $classroom =  MyClassRoom::where(['class_id'=>$request->classroom,'institute_id'=>$institute_id,'approved'=>true])->firstOrFail();
      $student   =  Student::where(['id'=>$request->student,'class_room_id'=>$request->classroom,'institute_id'=>$institute_id])->firstOrFail();
      $positive = $student->points->whereBetween('created_at',[$request->start_date,$request->end_date])->where('type','Positive')->sum('point');
      $negative = $student->points->whereBetween('created_at',[$request->start_date,$request->end_date])->where('type','Negative')->sum('point');
      $total_points = $student->points->whereBetween('created_at',[$request->start_date,$request->end_date])->sum('point');
      $points = [
        'Positive'=>$positive,
        'Negative'=>$negative,
        'total_points'=>$total_points
      ];
      return response()->json(['status'=>'OK','data'=>$points,'errors'=>'']);

    }

    public function getStudentPoints(Request $request)
    {
      $validator = Validator::make($request->all(), [
      'userId'=>'required|exists:users,id',
      'institute_id'=>'required|exists:institutes,id',
      'classroom'=>'required|exists:class_rooms,id',
      'student'=>'required|exists:students,id',
      'start_date'=>'required|date',
      'end_date'=>'required|date',
    ]);
    if ($validator->fails()) {
        return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
    }

      $user_id = $request->userId;
      $institute_id = $request->institute_id;
      $start_date =     new DateTime($request->start_date);
      $end_date =     new DateTime($request->end_date);
      $end_date->modify("+1 day");
      $classroom =  MyClassRoom::where(['class_id'=>$request->classroom,'institute_id'=>$institute_id,'approved'=>true])->firstOrFail();
      $student   =  Student::where(['id'=>$request->student,'class_room_id'=>$request->classroom,'institute_id'=>$institute_id])->firstOrFail();
      $history = $student->points->whereBetween('created_at',[$start_date,$end_date]);
      return response()->json(['status'=>'OK','data'=>$history,'errors'=>'']);
    }

    public function getClassRoomPoints(Request $request)
    {
      $validator = Validator::make($request->all(), [
      'userId'=>'required|exists:users,id',
      'institute_id'=>'required|exists:institutes,id',
      'classroom'=>'required|exists:class_rooms,id',
      'start_date'=>'required|date',
      'end_date'=>'required|date',
    ]);
    if ($validator->fails()) {
        return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
    }

      $user_id = $request->userId;
      $institute_id = $request->institute_id;
      $start_date =     new DateTime($request->start_date);
      $end_date =     new DateTime($request->end_date);
      $end_date->modify("+1 day");
      $classroom =  MyClassRoom::where(['class_id'=>$request->classroom,'institute_id'=>$institute_id,'approved'=>true])->firstOrFail();
      $history = Point::whereBetween('created_at',[$start_date,$end_date])->get();
      if ($history->count() > 0) {
        $records = $history->map(function($item){
          return [
            '_id'=>$item->id,
            'skill_name'=>$item->skill_name,
            'student_first_name'=>$item->student->user->first_name,
            'student_last_name'=>$item->student->user->last_name,
            'type'=>$item->type,
            'teacher_first_name'=>$item->user->first_name,
            'teacher_last_name'=>$item->user->last_name,
            'added_at'=>(string)$item->created_at,
            'point'=>$item->point,
          ];
        });
      }else{
        $records = [];
      }
      return response()->json(['status'=>'OK','data'=>$records,'errors'=>'']);
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
