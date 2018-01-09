<?php

namespace App\Http\Controllers\API;

use App\Story;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Institute;
use App\Teacher;
use App\ClassRoom;
use App\MyClassRoom;
use App\Student;
use Validator;
use App\StudentGroup;
use App\StudentStory;
use App\MyInstitute;
use App\Like;

class StoriesController extends Controller
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
        'classroom'=>'required|exists:class_rooms,id',
    ]);
        if ($validator->fails()) {
            return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
        }
        $user_id = $request->userId;
        $institute_id = $request->institute_id;
        // $institute = MyInstitute::where(['institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true])->firstOrFail();
        /*$myclassroom = MyClassRoom::where(['class_id'=>$request->classroom,'institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true]);*/
        $classroom = ClassRoom::where(['id'=>$request->classroom,'institute_id'=>$request->institute_id])->firstOrFail();

        $stories = $classroom->stories->map(function ($item){
          $user = request()->input('userId');
          $likes = $item->likes->where('user_id',$user)->count();
          if ($likes > 0) {
            $liked =true;
          }else{
            $liked =false;
          }
            return [
            'id'=>$item->id,
            'body'=>$item->body,
            'created'=>(string) $item->created_at,
            'poster'=>$item->poster,
            'likes'=>$item->likes->count(),
            'comments'=>$item->comments,
            'liked'=>$liked,
            ];
        });
        return response()->json(['status'=>'OK','data'=>$stories,'errors'=>''], 200);
    }

    public function parentStories(Request $request)
    {
        $validator = Validator::make($request->all(), [
        'institute_id'=>'required|exists:institutes,id',
        'userId'=>'required|exists:users,id',
        'classrooms.*'=>'required|exists:class_rooms,id',
    ]);
        if ($validator->fails()) {
            return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
        }
        $user_id = $request->userId;
        $institute_id = $request->institute_id;
        // $institute = MyInstitute::where(['institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true])->firstOrFail();
        /*$myclassroom = MyClassRoom::where(['class_id'=>$request->classroom,'institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true]);*/
        // $classroom = ClassRoom::where(['id'=>$request->classroom,'institute_id'=>$request->institute_id])->firstOrFail();
        $story =  Story::whereIn('class_room_id',$request->classrooms)->get();
        if ($story->count() > 0) {
          # code...
          $stories = $story->map(function ($item){
            $user = request()->input('userId');
            $likes = $item->likes->where('user_id',$user)->count();
            if ($likes > 0) {
              $liked =true;
            }else{
              $liked =false;
            }
            return [
              'id'=>$item->id,
              'body'=>$item->body,
              'created'=>(string) $item->created_at,
              'poster'=>$item->poster,
              'likes'=>$item->likes->count(),
              'comments'=>$item->comments,
              'liked'=>$liked,
            ];
          });
        }else{
          $stories = '';
        }
        return response()->json(['status'=>'OK','data'=>$stories,'errors'=>''], 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
        'institute_id'=>'required|exists:institutes,id',
        'userId'=>'required|exists:users,id',
        'classroom'=>'required|exists:class_rooms,id',
        'body'=>'required|string',
        'student'=>'exists:students,id',
        'group'=>'exists:student_groups,id'
    ]);
        if ($validator->fails()) {
            return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
        }
        $user_id = $request->userId;
        $institute_id = $request->institute_id;
        // $institute = MyInstitute::where(['institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true])->firstOrFail();
        $myclassroom = MyClassRoom::where(['class_id'=>$request->classroom,'institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true]);
        $classroom = ClassRoom::where(['id'=>$request->classroom,'institute_id'=>$request->institute_id])->firstOrFail();

        $story = Story::create([
        'institute_id'=>$institute_id,
        'user_id'=>$user_id,
        'class_room_id'=>$request->classroom,
        'body'=>$request->body,
      ]);
        if (!empty($request->poster)) {
            $story->poster = $request->poster;
            $story->save();
        }
        if (!empty($request->group)) {
            $story->student_group_id = $request->group;
            $student_group  = StudentGroup::where(['id'=>$request->group,'class_room_id'=>$request->classroom])->firstOrFail();
            foreach ($student_group->students as $student) {
                StudentStory::create([
            'story_id'=>$story->id,
            'student_id'=>$student,
            'class_room_id'=>$request->classroom,
            'student_group_id'=>$request->student_group_id,
          ]);
            }
            $story->save();
        }
        return response()->json(['status'=>'OK','data'=>$story,'errors'=>''], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Story  $story
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $validator = Validator::make($request->all(), [
        'institute_id'=>'required|exists:institutes,id',
        'userId'=>'required|exists:users,id',
        'classroom'=>'required|exists:class_rooms,id',
        'story'=>'required|exists:stories,id',
    ]);
        if ($validator->fails()) {
            return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
        }
        $user_id = $request->userId;
        $institute_id = $request->institute_id;
        // $institute = MyInstitute::where(['institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true])->firstOrFail();
        $myclassroom = MyClassRoom::where(['class_id'=>$request->classroom,'institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true]);
        $classroom = ClassRoom::where(['id'=>$request->classroom,'institute_id'=>$request->institute_id])->firstOrFail();
        $story = Story::where(['id'=>$request->story,'class_room_id'=>$request->class_room_id])->firstOrFail();
        return response()->json(['status'=>'OK','data'=>$story,'errors'=>''], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Story  $story
     * @return \Illuminate\Http\Response
     */
    public function GroupStories(Request $request)
    {
        $validator = Validator::make($request->all(), [
        'institute_id'=>'required|exists:institutes,id',
        'userId'=>'required|exists:users,id',
        'classroom'=>'required|exists:class_rooms,id',
        'group'=>'required|exists:student_groups,id',
    ]);
        if ($validator->fails()) {
            return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
        }
        $user_id = $request->userId;
        $institute_id = $request->institute_id;
        // $institute = MyInstitute::where(['institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true])->firstOrFail();
        $myclassroom = MyClassRoom::where(['class_id'=>$request->classroom,'institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true]);
        $classroom = ClassRoom::where(['id'=>$request->classroom,'institute_id'=>$request->institute_id])->firstOrFail();
        $studentGroup = StudentGroup::where(['id'=>$request->group,'class_room_id'=>$request->classroom])->firstOrFail();
        $stories = $studentGroup->stories;
        return response()->json(['status'=>'OK','data'=>$stories,'errors'=>''], 200);
    }
    public function classStories(Request $request)
    {
        $validator = Validator::make($request->all(), [
        'institute_id'=>'required|exists:institutes,id',
        'userId'=>'required|exists:users,id',
        'classroom'=>'required|exists:class_rooms,id',
        'group'=>'required|exists:student_groups,id',
    ]);
        if ($validator->fails()) {
            return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
        }
        $user_id = $request->userId;
        $institute_id = $request->institute_id;
        // $institute = MyInstitute::where(['institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true])->firstOrFail();
        $myclassroom = MyClassRoom::where(['class_id'=>$request->classroom,'institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true]);
        $classroom = ClassRoom::where(['id'=>$request->classroom,'institute_id'=>$request->institute_id])->firstOrFail();
        $studentGroup = StudentGroup::where(['id'=>$request->group,'class_room_id'=>$request->classroom])->firstOrFail();
        $stories = $studentGroup->stories;
        return response()->json(['status'=>'OK','data'=>$stories,'errors'=>''], 200);
    }


    public function likeStory(Request $request)
    {
      $validator = Validator::make($request->all(), [
      'institute_id'=>'required|exists:institutes,id',
      'userId'=>'required|exists:users,id',
      'classroom'=>'required|exists:class_rooms,id',
      'story'=>'required|exists:stories,id',
  ]);
      if ($validator->fails()) {
          return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
      }
      $user_id = $request->userId;
      $institute_id = $request->institute_id;
      $story_id = $request->story;
      // $institute = MyInstitute::where(['institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true])->firstOrFail();
      // $myclassroom = MyClassRoom::where(['class_id'=>$request->classroom,'institute_id'=>$request->institute_id]);
      $classroom = ClassRoom::where(['id'=>$request->classroom,'institute_id'=>$request->institute_id])->firstOrFail();
      $post = Story::where(['id'=>$story_id,'class_room_id'=>$request->classroom])->firstOrFail();

        $like = Like::withTrashed()->where(['user_id'=>$user_id,'story_id'=>$story_id])->first();
        if (is_null($like)) {
            Like::create(['user_id'=>$user_id,'story_id'=>$story_id]);
            $status = 'Liked';
        } else {
            if (is_null($like->deleted_at)) {
                $like->delete();
                $status = 'Unlike';
            } else {
                $like->restore();
                $status = 'Liked';
            }
        }
        $count = $post->likes->count();
        return response()->json(['status'=>'OK','data'=>$status,'count'=>$count]);
    }

    public function commentStory(Request $request)
    {
      $validator = Validator::make($request->all(), [
      'institute_id'=>'required|exists:institutes,id',
      'userId'=>'required|exists:users,id',
      'classroom'=>'required|exists:class_rooms,id',
      'story'=>'required|exists:stories,id',
      'comment'=>'required|string',
  ]);
      if ($validator->fails()) {
          return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
      }
      $user_id = $request->userId;
      $institute_id = $request->institute_id;
      $story_id = $request->story;
      // $institute = MyInstitute::where(['institute_id'=>$request->institute_id,'user_id'=>$user_id,'approved'=>true])->firstOrFail();
      // $myclassroom = MyClassRoom::where(['class_id'=>$request->classroom,'institute_id'=>$request->institute_id]);
      $classroom = ClassRoom::where(['id'=>$request->classroom,'institute_id'=>$request->institute_id])->firstOrFail();
      $post = Story::where(['id'=>$story_id,'class_room_id'=>$request->classroom])->firstOrFail();
      $comment = $request->comment;
      $post->comments()->create(['user_id'=>$user_id,'body'=>$comment]);
      return response()->json(['status'=>'OK','data'=>$comment]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
        'userId'=>'required|exists:users,id',
        'classroom'=>'required|exists:class_rooms,id',
        'story'=>'required|exists:stories,id',
        'body'=>'required|string',

    ]);
        if ($validator->fails()) {
            return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
        }
        $user_id = $request->userId;
        $classroom = ClassRoom::where(['id'=>$request->classroom])->firstOrFail();
        $story = Story::where(['id'=>$request->story,'user_id'=>$user_id,'class_room_id'=>$request->classroom])->firstOrFail();
        $story->body = $request->body;
        if (!empty($request->poster)) {
            $story->poster = $request->poster;
        }
        $story->save();
        $story = collect([$story]);
        // return $story;
        $stories = $story->map(function ($item){
          $user = request()->input('userId');
          $likes = $item->likes->where('user_id',$user)->count();
          if ($likes > 0) {
            $liked =true;
          }else{
            $liked =false;
          }
            return [
            'id'=>$item->id,
            'body'=>$item->body,
            'created'=>(string) $item->created_at,
            'poster'=>$item->poster,
            'likes'=>$item->likes->count(),
            'comments'=>$item->comments,
            'liked'=>$liked,
            ];
        });
        return response()->json(['status'=>'OK','data'=>$stories,'errors'=>''], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Story  $story
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
        'userId'=>'required|exists:users,id',
        'classroom'=>'required|exists:class_rooms,id',
        'story'=>'required|exists:stories,id',

    ]);
        if ($validator->fails()) {
            return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
        }
        $user_id = $request->userId;
        $classroom = ClassRoom::where(['id'=>$request->classroom])->firstOrFail();
        $story = Story::where(['id'=>$request->story,'user_id'=>$user_id,'class_room_id'=>$request->classroom])->firstOrFail();
        $story->forceDelete();
        return response()->json(['status'=>'OK','data'=>'','errors'=>''], 200);
    }
}
