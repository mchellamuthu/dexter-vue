<?php

namespace App\Http\Controllers\API;

use App\Institute;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\User;
use App\JoinRquest;
// use Auth;
class InstituteController extends Controller
{

    public function __construct()
    {
      // $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validator =   Validator::make($request->all(), [
        'name' => 'required|max:255',
        'address' => 'required|max:500',
        'state' => 'required|max:150',
        'country' => 'required|max:150',
        'type' => 'required|max:150',
        'userId'=>'required|max:150',
        'avatar'=>'required|max:30',
        ]);

        // then, if it fails, return the error messages in JSON format
        if ($validator->fails()) {
            return response()->json(['status'=>'OK','data'=>'','errors'=>$validator->messages()], 200);
        }
        $institute = Institute::create([
            'name'=>$request->name,
            'address'=>$request->address,
            'state'=>$request->state,
            'country'=>$request->country,
            'type'=>$request->type,
            'userId'=>$request->userId,
            'avatar'=>$request->avatar,
      ]);
        if ($institute) {
            return response()->json(['status'=>'OK','data'=>$institute,'errors'=>'']);
        }

        return response()->json(['status'=>'failed','data'=>'','errors'=>'error occured try again later']);
    }

    /**
     * get information about institute by id
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function info($id,Request $request)
    {
      $institute  = Institute::where('id',$id)->firstOrFail();
      return response()->json(['status'=>'OK','data'=>$institute],200);
    }
    /**
     * Search institutes from database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $keyword = $request->query;
        $records  = Institute::SearchByKeyword($keyword)->get();
        if($records->count() > 0) {
            return response()->json(['status'=>'OK','data'=>$records,'msg'=>'success']);
        }
        return response()->json(['status'=>'error','data'=>'','msg'=>'no records found']);
    }

    /**
     * Send a join request to institute
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function joinRequest(Request $request)
    {
      $user = User::where('id',$request->user_id)->firstOrFail();
      $institute = Institute::where('id',$request->institute_id)->firstOrFail();
      Institute::updateOrCreate(
        ['user_id'=>$request->user_id],
        ['institute_id'=>$request->institute_id]
      );
      return reponse()->json(['status'=>'OK','msg'=>'Request was send successfull!'],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Institute  $institute
     * @return \Illuminate\Http\Response
     */
    public function show(Institute $institute)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Institute  $institute
     * @return \Illuminate\Http\Response
     */
    public function edit(Institute $institute)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Institute  $institute
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Institute $institute)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Institute  $institute
     * @return \Illuminate\Http\Response
     */
    public function destroy(Institute $institute)
    {
        //
    }
}
