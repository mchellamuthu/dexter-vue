<?php
use Illuminate\Http\Request;

// Avatars Routes
Route::post('/avatars','API\AvatarController@getall');
Route::post('/UserInfo','API\UserController@getUserinfo');

Route::post('/institute/search','API\InstituteController@search');
Route::post('/institute/create','API\InstituteController@create');
Route::post('/institute/info','API\InstituteController@info');
Route::post('/institute/join','API\InstituteController@sendRequest');

// Staffs Routes
Route::post('/staffs','API\StaffController@create');
Route::delete('/staffs','API\StaffController@removeStaff');
Route::put('/staffs','API\StaffController@updateStaff');
Route::get('/staffs/groups','API\StaffController@getStaffGroups');

// Staff Groups routes
Route::post('/staff/groups','API\StaffController@createGroup');
Route::put('/staff/groups','API\StaffController@updateGroup');
Route::delete('/staff/groups/','API\StaffController@removeGroup');
Route::post('/staff/allGroups','API\StaffController@getAllGroups');
Route::post('/staff/all','API\StaffController@getAll');
Route::post('/staff/groups/members','API\StaffController@getGroupMembers');


// Classroom routes
Route::post('/classroom/create','API\ClassroomController@store');
Route::delete('/classroom/remove','API\ClassroomController@destroy');
Route::put('/classroom/update','API\ClassroomController@update');
Route::post('/classroom/restore','API\ClassroomController@restore');
Route::post('/classroom/getArchieved','API\ClassroomController@archievedClassrooms');


// ClassGroup routes
Route::post('/classgroup/create','API\ClassGroupController@store');
Route::post('/classgroup/getMembers','API\ClassGroupController@show');
Route::post('/classgroup/allGroups','API\ClassGroupController@index');
