<?php
use Illuminate\Http\Request;
// Avatars Routes

/**
 * avatars get all avatars
 * @Method POST
 * @userId Send authenticated user's id
 * @type Send which type of avatar should be in Classroom,Institute,Student,Skills
 * @return \Illuminate\Http\Response JSON
 */
Route::post('/avatars','API\AvatarController@getall');

/**
 * get all info for authenticated user
 * @Method POST
 * @userId Send authenticated user's id
 * @return \Illuminate\Http\Response JSON
 */
Route::post('/UserInfo','API\UserController@getUserinfo');

/**
 * Get all institute list and search by keyword
 * @Method POST
 * @userId Send authenticated user's id
 * @keyword Send query for search
 * @return \Illuminate\Http\Response JSON
 */
Route::post('/institute/search','API\InstituteController@search');

Route::post('/institute/create','API\InstituteController@create');
Route::post('/institute/info','API\InstituteController@info');
Route::post('/institute/join','API\InstituteController@joinRequest');

// Staffs Routes
Route::post('/staffs','API\StaffController@create');
Route::post('/staffs','API\StaffController@removeStaff');
Route::post('/staffs','API\StaffController@updateStaff');
Route::get('/staffs/groups','API\StaffController@getStaffGroups');

// Staff Groups routes
Route::post('/staff/groups','API\StaffController@createGroup');
Route::post('/staff/groups','API\StaffController@updateGroup');
Route::post('/staff/groups/','API\StaffController@removeGroup');
Route::post('/staff/allGroups','API\StaffController@getAllGroups');
Route::post('/staff/all','API\StaffController@getAll');
Route::post('/staff/groups/members','API\StaffController@getGroupMembers');


// Classroom routes
Route::post('/classroom/create','API\ClassroomController@store');
Route::post('/classroom/remove','API\ClassroomController@destroy');
Route::post('/classroom/update','API\ClassroomController@update');
Route::post('/classroom/restore','API\ClassroomController@restore');
Route::post('/classroom/getArchieved','API\ClassroomController@archievedClassrooms');
Route::post('/classrooms','API\ClassroomController@index');
Route::post('/classroom/info','API\ClassroomController@show');


// ClassGroup routes
Route::post('/classgroup/create','API\ClassGroupController@store');
Route::post('/classgroup/getMembers','API\ClassGroupController@show');
Route::post('/classgroup/allGroups','API\ClassGroupController@index');
Route::post('/classgroup/update','API\ClassGroupController@update');
Route::post('/classgroup/delete','API\ClassGroupController@destroy');

// Student ROUTES
Route::post('/StudentsAdd','API\StudentController@store');
Route::post('/StudentInfo','API\StudentController@show');
Route::post('/StudentDelete','API\StudentController@destroy');
Route::post('/StudentUpdate','API\StudentController@update');

// STUDENT GROUPS
Route::post('/CreateStudentGroup','API\StudentGroupController@store');
Route::post('/StudentGroupInfo','API\StudentGroupController@info');
Route::delete('/StudentGroup/{group}/delete','API\StudentGroupController@destroy');
Route::put('/StudentGroup/{group}/update','API\StudentGroupController@update');

// STUDENT POINTS
Route::post('/skills/{classroom}/create','API\SkillsController@create');
Route::delete('/skills/{classroom}/delete','API\SkillsController@destroy');
Route::put('/skills/{classroom}/update','API\SkillsController@update');
Route::get('/skills/{classroom}','API\SkillsController@index');

// STUDENT ATTENDANCE
Route::post('/attendance','API\AttendanceController@create');
Route::put('/attendanceUpdate','API\AttendanceController@update');
Route::post('/getAttendance','API\AttendanceController@index');
