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
Route::post('/staffs/create','API\StaffController@create');
Route::post('/staffs/delete','API\StaffController@removeStaff');
Route::post('/staffs/update','API\StaffController@updateStaff');
Route::get('/staffs/groups','API\StaffController@getStaffGroups');

// Staff Groups routes
Route::post('/staff/groups','API\StaffController@createGroup');
Route::put('/staff/groups','API\StaffController@updateGroup');
Route::post('/staff/groups/delete','API\StaffController@removeGroup');
Route::post('/staff/allGroups','API\StaffController@getAllGroups');
Route::post('/staff/all','API\StaffController@getAll');
Route::post('/staff/groups/members','API\StaffController@getGroupMembers');


// Classroom routes
Route::post('/classroom/create','API\ClassroomController@store');
Route::post('/classroom/remove','API\ClassroomController@destroy');
Route::put('/classroom/update','API\ClassroomController@update');
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
Route::post('/StudentsAll','API\StudentController@index');
Route::post('/StudentsAdd','API\StudentController@store');
Route::post('/StudentInfo','API\StudentController@show');
Route::post('/StudentDelete','API\StudentController@destroy');
Route::post('/StudentUpdate','API\StudentController@update');


// STUDENT GROUPS
Route::post('/CreateStudentGroup','API\StudentGroupController@store');
Route::post('/StudentGroups','API\StudentGroupController@index');
Route::post('/StudentGroupInfo','API\StudentGroupController@show');
Route::post('/StudentGroup/delete','API\StudentGroupController@destroy');
Route::put('/StudentGroup/update','API\StudentGroupController@update');

// STUDENT POINTS
Route::post('/skills/create','API\SkillController@store');
Route::post('/skills/delete','API\SkillController@destroy');
Route::put('/skills/update','API\SkillController@update');
Route::get('/skills','API\SkillController@index');
Route::get('/skillInfo','API\SkillController@show');

Route::post('/studentPoints','API\PointsController@store');
Route::post('/classroomPoints','API\PointsController@ClassRoomPoints');
Route::post('/groupPoints','API\PointsController@groupPoints');
Route::get('/getStudentPoints','API\PointsController@getStudentPoints');
Route::get('/getClassRoomPoints','API\PointsController@getClassRoomPoints');
// STUDENT ATTENDANCE
Route::post('/attendance','API\AttendanceController@store');
Route::get('/getAttendance','API\AttendanceController@GetAttendance');
Route::get('/attendance','API\AttendanceController@getDatesFromRange');

//Class Stories
Route::get('/stories','API\StoriesController@index');
Route::post('/stories/create','API\StoriesController@create');
Route::get('/stories/info','API\StoriesController@show');
Route::post('/stories/update','API\StoriesController@update');
Route::post('/stories/delete','API\StoriesController@destroy');
Route::post('/likeStory','API\StoriesController@likeStory');
Route::post('/commentStory','API\StoriesController@commentStory');
Route::get('/GroupStories','API\StoriesController@GroupStories');


// Parent Invite
Route::post('/inviteParent','API\ParentsController@Invite');

/**
 * Message Routes
 */

Route::post('/sendMessage', 'API\MessageController@send');
Route::get('/getMessage', 'API\MessageController@index');
Route::get('/inviteTeacher', 'API\ClassroomController@inviteteachers');
Route::get('/getAllteachers', 'API\ClassroomController@getteachers');
