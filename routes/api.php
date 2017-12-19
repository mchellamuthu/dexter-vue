<?php
use Illuminate\Http\Request;

Route::post('/institute/search','API\InstituteController@search');
Route::post('/institute/create','API\InstituteController@create');
Route::post('/institute/{id}/info','API\InstituteController@info');
Route::post('/institute/{id}/request','API\InstituteController@sendRequest');

// Staffs Routes
Route::post('/institute/{id}/staffs/import','API\StaffController@importStaffs');
Route::delete('/institute/{id}/staff/{staff}','API\StaffController@StaffDelete');
Route::get('/institute/{id}/staffs/groups','API\StaffController@getStaffGroups');

// Staff Groups routes
Route::post('/staff/groups','API\StaffController@createGroup');
Route::put('/staff/groups','API\StaffController@updateGroup');
Route::delete('/staff/groups/','API\StaffController@removeGroup');
Route::post('/staff/allGroups','API\StaffController@getAllGroups');
Route::post('/staff/all','API\StaffController@getAll');
Route::post('/staff/groups/members','API\StaffController@getGroupMembers');


// Classroom routes
Route::apiResource('classrooms', 'API\ClassroomController');
// ClassGroups routes
Route::apiResource('classgroups', 'API\ClassGroupController');
