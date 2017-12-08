<?php

use Illuminate\Http\Request;
use App\User;
use App\Institute;
use App\ClassRoom;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/users', function()
{
    return User::all();
});
Route::post('/user', function(Request $request)
{
    $userid = $request->userid;
    return User::find($userid);
});
Route::get('/institutes', function()
{
    return Institute::all();
});
Route::post('/institute', function(Request $request)
{
    $instituteId = $request->instituteId;
    return Institute::find($instituteId);
});
Route::post('/classrooms', function(Request $request)
{
    $instituteId = $request->instituteId;
    return ClassRoom::where('institute_id',$instituteId)->get();
});
Route::post('/classid', function(Request $request)
{
  return $request->all();
});
