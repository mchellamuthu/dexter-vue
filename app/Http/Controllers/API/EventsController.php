<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Event;
use App\User;
use App\Http\Resources\EventsCollection;
use App\Http\Resources\EventResource;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id,Request $request)
    {
      $validator = Validator::make($request->all(), [
        'userId'=>'required|exists:users,id',
      ]);
      if ($validator->fails()) {
          return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
      }
      $user_id = $request->userId;
      $institute_id = $id;
      $institute = MyInstitute::where(['institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true])->firstOrFail();
      $events = Event::where('institute_id')->get();
      if ($events->count() > 0) {
        return response()->json(['status'=>'OK','data'=>new EventsCollection($events),'errors'=>''], 200);
      }
      return response()->json(['status'=>'OK','data'=>'No Events Found','errors'=>''], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id,Request $request)
    {
      $validator = Validator::make($request->all(), [
        'userId'=>'required|exists:users,id',
        'title'=>'required|string|max:255',
        'description'=>'required|string1',
        'start'=>'required|date_format:Y-m-d H:i:s',
        'end'=>'required|date_format:Y-m-d H:i:s',
        'color'=>'required',
        'textColor'=>'required',
      ]);
      if ($validator->fails()) {
          return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
      }
      $user_id = $request->userId;
      $institute_id = $id;
      $institute = MyInstitute::where(['institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true])->firstOrFail();
      $event = Event::create([
      'title'=>$request->title,
      'description'=>$request->description,
      'start'=> $request->start,
      'end'=> $request->end,
      'user_id'=>$user_id,
      'color'=> $request->color,
      'textColor'=> $request->textColor,
      'url'=> $request->url,
      'icon'=> $request->icon,
      'institute_id'=> $institute_id,
    ]);
      return response()->json(['status'=>'OK','data'=>new EventResource($event),'errors'=>''], 200);
    }
    public function update($id,Request $request)
    {
      $validator = Validator::make($request->all(), [
        'userId'=>'required|exists:users,id',
        'title'=>'required|string|max:255',
        'description'=>'required|string1',
        'start'=>'required|date_format:Y-m-d H:i:s',
        'end'=>'required|date_format:Y-m-d H:i:s',
        'color'=>'required',
        'textColor'=>'required',
      ]);
      if ($validator->fails()) {
          return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
      }
      $user_id = $request->userId;
      // $institute_id = $id;
      // $institute = MyInstitute::where(['institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true])->firstOrFail();
      $event = Event::where(['id'=>$id,'user_id'=>$user_id])->firstOrFail();
      $event->update([
      'title'=>$request->title,
      'description'=>$request->description,
      'start'=> $request->start,
      'end'=> $request->end,
      'color'=> $request->color,
      'textColor'=> $request->textColor,
      'url'=> $request->url,
      'icon'=> $request->icon,
    ]);
      return response()->json(['status'=>'OK','data'=>new EventResource($event),'errors'=>''], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,Request $request)
    {
      $validator = Validator::make($request->all(), [
        'userId'=>'required|exists:users,id',
      ]);
      if ($validator->fails()) {
          return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
      }
      $user_id = $request->userId;
      $event = Event::where(['id'=>$id,'user_id'=>$user_id])->firstOrFail();
      $event->delete();
      return response()->json(['status'=>'OK','data'=>'deleted successfully','errors'=>''], 200);
    }
}
