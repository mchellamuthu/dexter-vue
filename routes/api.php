<?php
use Illuminate\Http\Request;

// Avatars Routes
Route::post('/avatars','API\AvatarController@getall');

Route::post('/institute/search','API\InstituteController@search');
Route::post('/institute/create','API\InstituteController@create');
Route::post('/institute/info','API\InstituteController@info');
Route::post('/institute/join','API\InstituteController@sendRequest');

// Staffs Routes
Route::post('/staffs','API\StaffController@create');
Route::delete('/staffs','API\StaffController@StaffDelete');
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
