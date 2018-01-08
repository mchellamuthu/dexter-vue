<?php

namespace App\Http\Controllers\API;

use App\Message;
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
use App\Point;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $validation   = Validator::make($request->all(),[
        'userId'=>'required|exists:users,id',
        'msg_to'=>'required|exists:users,id',
        'classroom'=>'required|exists:class_rooms,id',
      ]);
      if ($validation->fails()) {
          return response()->json(['status'=>'OK','data'=>'','errors'=>$validation->messages()], 200);
      }
       $classroom = $request->classroom;
       $he = $request->msg_to;
       $me = $request->userId;
       // $classroom = '7bf4be30-f11c-11e7-b756-85a0d7e1efdb';
       $received = Message::where('class_room_id',$classroom)->where('msg_from',$he)->where('msg_to',$me);
       $send = Message::where('class_room_id',$classroom)->where('msg_to',$he)->where('msg_from',$me);
       $result = $received->union($send)->get();
       return response()->json(['status'=>'OK','data'=>$result,'errors'=>''], 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function send(Request $request)
    {
      $validation   = Validator::make($request->all(),[
        'userId'=>'required|exists:users,id',
        'receiver'=>'required',
        'institute_id'=>'required|exists:institutes,id',
        'classroom'=>'required|exists:class_rooms,id',
        'message'=>'required|string',
      ]);
      if ($validation->fails()) {
          return response()->json(['status'=>'OK','data'=>'','errors'=>$validation->messages()], 200);
      }
      $user_id = $request->userId;
      $institute_id = $request->institute_id;
      $user = User::findOrFail($user_id);
      $receiver = User::findOrFail($request->receiver);
      $classroom = ClassRoom::findOrFail($request->classroom);
      $sendMessage = Message::create([
        'institute_id'=>$institute_id,
        'class_room_id'=>$request->classroom,
        'msg_from'=>$request->userId,
        'msg_to'=>$request->receiver,
        'message'=>$request->message,
      ]);
      return response()->json(['status'=>'OK','data'=>$sendMessage,'errors'=>''], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        //
    }
}
