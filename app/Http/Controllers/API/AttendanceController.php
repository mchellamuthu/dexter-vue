<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Institute;
use App\Teacher;
use App\ClassRoom;
use App\MyClassRoom;
use App\Student;
use Validator;
use App\MyInstitute;
use App\Attendance;
use Carbon\Carbon;
use DatePeriod;
use DateTime;
use DateInterval;

class AttendanceController extends Controller
{
    public function store(Request $request)
    {
        // dd($request->student['id'  ]);
        $validator = Validator::make($request->all(), [
      'institute_id'=>'required|exists:institutes,id',
      'userId'=>'required|exists:users,id',
      'classroom'=>'required|exists:class_rooms,id',
      'student[id].*'=>'required|exists:students,id',
      'student[status].*'=>'required|in:Absent,Present,Late,Leave_Early'
  ]);
        if ($validator->fails()) {
            return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
        }
        $user_id = $request->userId;
        $institute_id = $request->institute_id;
        // $institute = MyInstitute::where(['institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true])->firstOrFail();
        $myclassroom = MyClassRoom::where(['class_id'=>$request->classroom,'institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true]);
        $attendance = Attendance::firstOrCreate(['date'=>date('Y-m-d'),'class_room_id'=>$request->classroom], ['institute_id'=>$request->institute_id,'user_id'=>$request->userId]);
        $students = $request->input('student[id]');
        $sync_data = [];
        for ($i=0; $i < count($students); $i++) {
            $sync_data[$students[$i]] = ['date'=>date('Y-m-d'),'status'=>$request->input('student[status]')[$i]];
        }
        $attendance->students()->sync($sync_data);

        return response()->json(['status'=>'success','data'=>$attendance,'msg'=>'Attendance was saved successfully!']);
    }

    public function GetAttendance(Request $request)
    {
        // dd($request->student['id'  ]);
        $validator = Validator::make($request->all(), [
      'institute_id'=>'required|exists:institutes,id',
      'userId'=>'required|exists:users,id',
      'classroom'=>'required|exists:class_rooms,id',
      'date'=>'required|date',
  ]);
        if ($validator->fails()) {
            return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
        }
        $user_id = $request->userId;
        $institute_id = $request->institute_id;
        $myclassroom = MyClassRoom::where(['class_id'=>$request->classroom,'institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true]);
        $attendance = Attendance::where(['date'=>$request->date,'class_room_id'=>$request->classroom,'institute_id'=>$request->institute_id])->first();
        if (empty($attendance)) {
            return response()->json(['status'=>'OK','data'=>'0','errors'=>''], 200);
        }
        $records =  $attendance->students_list->map(function ($row) {
            return [
          '_id'=>$row->student_id,
          'user'=>$row->student->user->id,
          'first_name'=>$row->student->user->first_name,
          'last_name'=>$row->student->user->last_name,
          'status'=>$row->status,
          'avatar'=>$row->student->avatar,
        ];
        });
        return response()->json(['status'=>'OK','data'=>$records,'errors'=>''], 200);
    }
    public function AttendanceByDates(Request $request)
    {
        // dd($request->student['id'  ]);
        $validator = Validator::make($request->all(), [
      'institute_id'=>'required|exists:institutes,id',
      'userId'=>'required|exists:users,id',
      'classroom'=>'required|exists:class_rooms,id',
      'start_date'=>'required|date',
      'end_date'=>'required|date',
  ]);
        if ($validator->fails()) {
            return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
        }
        $user_id = $request->userId;
        $institute_id = $request->institute_id;
        $myclassroom = MyClassRoom::where(['class_id'=>$request->classroom,'institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true]);
        $attendance = Attendance::where(['class_room_id'=>$request->classroom,'institute_id'=>$request->institute_id])->whereBetween('date', [$request->start_date,$request->end_date])->first();
        if (empty($attendance)) {
            return response()->json(['status'=>'OK','data'=>'0','errors'=>''], 200);
        }
        $records =  $attendance->students_list->map(function ($row) {
            return [
          '_id'=>$row->student_id,
          'user'=>$row->student->user->id,
          'first_name'=>$row->student->user->first_name,
          'last_name'=>$row->student->user->last_name,
          'status'=>$row->status,
          'avatar'=>$row->student->avatar,
        ];
        });
        return response()->json(['status'=>'OK','data'=>$records,'errors'=>''], 200);
    }

    public function getDatesFromRange(Request $request)
    {
        // dd($request->student['id'  ]);
        $validator = Validator::make($request->all(), [
      'institute_id'=>'required|exists:institutes,id',
      'userId'=>'required|exists:users,id',
      'classroom'=>'required|exists:class_rooms,id',
      'start_date'=>'required|date',
      'end_date'=>'required|date',
  ]);
        if ($validator->fails()) {
            return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
        }
        $user_id = $request->userId;
        $institute_id = $request->institute_id;
        $myclassroom = MyClassRoom::where(['class_id'=>$request->classroom,'institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true]);
        $start_date =     new DateTime($request->start_date);
        $end_date =     new DateTime($request->end_date);
        $end_date->modify("+1 day");
        $period = new DatePeriod(
      $start_date,
     new DateInterval('P1D'),
     $end_date
    );
        $data = [];
        foreach ($period as $key => $value) {
            $date = $value->format('Y-m-d');
            $attendance = Attendance::where(['class_room_id'=>$request->classroom,'institute_id'=>$request->institute_id])->whereDate('date', $date)->first();
            if (!empty($attendance)) {
                $records =  $attendance->students_list->map(function ($row) {
                    return [
                '_id'=>$row->student_id,
                'user'=>$row->student->user->id,
                'first_name'=>$row->student->user->first_name,
                'last_name'=>$row->student->user->last_name,
                'status'=>$row->status,
                'avatar'=>$row->student->avatar,
              ];
                });
            } else {
                $records = [];
            }

            $data[] = ['date'=>$date,'records'=>$records];
        }
        return response()->json(['status'=>'OK','data'=>$data,'errors'=>''], 200);
    }
    public function getStudentAttendances(Request $request)
    {
        // dd($request->student['id'  ]);
        $validator = Validator::make($request->all(), [
      'student'=>'required|exists:students,id',
      'userId'=>'required|exists:users,id',
      'classroom'=>'required|exists:class_rooms,id',
      'start_date'=>'required|date',
      'end_date'=>'required|date',
  ]);
        if ($validator->fails()) {
            return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
        }
        $user_id = $request->userId;
        $myclassroom = MyClassRoom::where(['class_id'=>$request->classroom])->first();
        $start_date =     new DateTime($request->start_date);
        $end_date =     new DateTime($request->end_date);
        $end_date->modify("+1 day");
        $period = new DatePeriod(
      $start_date,
     new DateInterval('P1D'),
     $end_date
    );
        $data = [];
        foreach ($period as $key => $value) {
            $date = $value->format('Y-m-d');
            $attendance = Attendance::where(['class_room_id'=>$request->classroom])->whereDate('date', $date)->first();
            if (!empty($attendance)) {
              $att_records = $attendance->students_list->where('student_id',$request->student);
                $records =  $att_records->map(function ($row) {
                    return [
                '_id'=>$row->student_id,
                'user'=>$row->student->user->id,
                'first_name'=>$row->student->user->first_name,
                'last_name'=>$row->student->user->last_name,
                'status'=>$row->status,
                'avatar'=>$row->student->avatar,
              ];
                });
            } else {
                $records = [];
            }

            $data[] = ['date'=>$date,'records'=>$records];
        }
        return response()->json(['status'=>'OK','data'=>$data,'errors'=>''], 200);
    }
}
