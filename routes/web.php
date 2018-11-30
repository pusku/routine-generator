<?php

//Landing Page
Route::get('/',[
    'uses' => 'HomeController@index',
    'as' => '/'
]);

//Routes of Room
Route::get('/rooms',[
    'uses' => 'RoomController@index',
    'as' => 'rooms'
]);
Route::post('/room/add',[
    'uses' => 'RoomController@insertRoom',
    'as' => 'addRoom'
]);
Route::get('/deleteroom/{id}', 'RoomController@deleteRoom')->name('deleteRoom');
Route::get('/editroom/{id}', 'RoomController@editRoom')->name('editRoom');
Route::post('/updateroom/{id}', 'RoomController@updateRoom')->name('updateRoom');

// Routes of Teacher
Route::get('/teachers',[
    'uses' => 'TeacherController@index',
    'as' => 'teachers'
]);
Route::post('/teacher/add',[
    'uses' => 'TeacherController@insertTeacher',
    'as' => 'addTeacher'
]);
Route::get('/deleteteacher/{id}', 'TeacherController@deleteTeacher')->name('deleteTeacher');
Route::get('/editteacher/{id}', 'TeacherController@editTeacher')->name('editTeacher');
Route::post('/updateteacher/{id}', 'TeacherController@updateTeacher')->name('updateTeacher');

// Routes of Courses
Route::get('/courses',[
    'uses' => 'CourseController@index',
    'as' => 'courses'
]);
Route::post('/course/add',[
    'uses' => 'CourseController@insertCourse',
    'as' => 'addCourse'
]);
Route::get('/deletecourse/{id}', 'CourseController@deleteCourse')->name('deleteCourse');
Route::get('/editcourse/{id}', 'CourseController@editCourse')->name('editCourse');
Route::post('/updatecourse/{id}', 'CourseController@updateCourse')->name('updateCourse');

// Routes of Time Slots
Route::get('/slots',[
    'uses' => 'SlotController@index',
    'as' => 'slots'
]);
Route::post('/slot/add',[
    'uses' => 'SlotController@insertSlot',
    'as' => 'addSlot'
]);
Route::get('/deleteslot/{id}', 'SlotController@deleteSlot')->name('deleteSlot');
Route::get('/editslot/{id}', 'SlotController@editSlot')->name('editSlot');
Route::post('/updateslot/{id}', 'SlotController@updateSlot')->name('updateSlot');

//Sections
Route::get('/sections',[
    'uses' => 'SectionController@index',
    'as' => 'sections'
]);
Route::post('/section/add',[
    'uses' => 'SectionController@insertSection',
    'as' => 'addSection'
]);
Route::get('/deletesection/{id}', 'SectionController@deleteSection')->name('deleteSection');
Route::get('/editsection/{id}', 'SectionController@editSection')->name('editSection');
Route::post('/updatesection/{id}', 'SectionController@updateSection')->name('updateSection');

//Days
Route::get('/days',[
    'uses' => 'DayController@index',
    'as' => 'days'
]);
Route::post('/day/add',[
    'uses' => 'DayController@insertDay',
    'as' => 'addDay'
]);
Route::get('/deleteday/{id}', 'DayController@deleteDay')->name('deleteDay');
Route::get('/editday/{id}', 'DayController@editDay')->name('editDay');
Route::post('/updateday/{id}', 'DayController@updateDay')->name('updateDay');

//Assign teacher to course
// Route::get('/days',[
//     'uses' => 'AssignTeacherController@index',
//     'as' => 'assignTeacher'
// ]);
// Route::post('/day/add',[
//     'uses' => 'DayController@insertDay',
//     'as' => 'addDay'
// ]);
// Route::get('/deleteday/{id}', 'DayController@deleteDay')->name('deleteDay');
// Route::get('/editday/{id}', 'DayController@editDay')->name('editDay');
// Route::post('/updateday/{id}', 'DayController@updateDay')->name('updateDay');
