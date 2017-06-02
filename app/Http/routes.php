<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Validator::extend('check_current_password', function($field,$value,$parameters){
 //return true if field value is foo
 if(md5($value) === Session::get('Users.password')){
	 return true;
 }
 return false;
 
});
Route::group(['middleware' => ['web']], function () {

	Route::match(['get', 'post'],'/','HomeController@login');
	Route::match(['get', 'post'],'/Company','HomeController@company');
	Route::match(['get', 'post'],'/ForgetPassword','HomeController@forgetPassword');
	Route::match(['get', 'post'],'/ResetPassword/{string}','HomeController@ResetPassword');
	Route::match(['get', 'post'],'/changePassword','HomeController@changePassword');
	
	Route::match(['get', 'post'],'/Staff','HomeController@staff');
	Route::post('/StaffAdd','AccountController@addStaff');
	Route::post('/EditStaffContent','AccountController@EditStaffContent');
	Route::post('/Holiday/{string}','AccountController@Holiday');
	Route::post('/HolidaySearch','AccountController@HolidaySearch');
	Route::post('/HolidayEditForm','AccountController@HolidayEditForm');
	Route::post('/HolidayUpdate','AccountController@HolidayUpdate');
	Route::post('/Holidaydelete','AccountController@Holidaydelete');
	Route::post('/Holiday','AccountController@Holiday');
	// For Staff DateReminder 
	Route::post('/deleteReminder','StaffReminderController@deleteReminder');
	Route::post('/ReminderEditForm','StaffReminderController@ReminderEditForm');
	Route::post('/ReminderUpdate','StaffReminderController@ReminderUpdate');
	Route::post('/addStaffReminder','StaffReminderController@addStaffReminder');
	Route::post('/StaffReminder','StaffReminderController@StaffReminder');
	Route::post('/StaffSearch','AccountController@StaffSearch');
	// Ends : For Staff DateReminder
	// For Date 
	Route::post('/decWeek','DateFormatController@decWeek');
	Route::post('/incWeek','DateFormatController@incWeek');
	Route::post('/selectWeek','DateFormatController@selectWeek');
	Route::post('/StaffOption','DateFormatController@StaffOption');
	Route::post('/StaffEditdetails','DateFormatController@StaffEditdetails');
	Route::post('/salesPercentage','DateFormatController@salesPercentage');
	Route::post('/CopyShifts','DateFormatController@CopyShifts');
	Route::post('/CopyWeekShifts','DateFormatController@CopyWeekShifts');
	Route::post('/DeleteWeekShifts','DateFormatController@DeleteWeekShifts');
	Route::post('/ShowWeek','DateFormatController@ShowWeek');
	Route::post('/CopyWeekOption','DateFormatController@CopyWeekOption');
	
	Route::post('/PublishOption','DateFormatController@PublishOption');
	// Ends : Date 
	// For Employee 
	
	Route::match(['get', 'post'],'/Employee','EmployeeController@index');
	//Ends Here For Employee
	// Starts : For Store 
	Route::match(['get', 'post'],'/Store','StoreController@index');
	Route::match(['get', 'post'],'Store/Search','StoreController@searchList');
	Route::match(['get', 'post'],'Store/EditForm','StoreController@EditForm');
	Route::match(['get', 'post'],'Store/Edit','StoreController@edit');
	// Ends : For Store 
	Route::match(['get', 'post'],'/Schedule','ScheduleController@index');
	Route::match(['get', 'post'],'/AddShift','ScheduleController@AddShift');
	Route::match(['get', 'post'],'/EditShift','ScheduleController@EditShift');
	Route::match(['get', 'post'],'/DeleteShift','ScheduleController@DeleteShift');
	Route::match(['get', 'post'],'/WeeklyReport','DateFormatController@WeeklyReport');
	
	Route::match(['get', 'post'],'/Schedule1','ScheduleController@index1');
	Route::match(['get', 'post'],'/Reports','HomeController@reports');
	Route::match(['get', 'post'],'/Reports1','HomeController@reports1');
	Route::match(['get', 'post'],'/publishShift','ScheduleController@publishShift');
	Route::match(['get', 'post'],'/publishShift','ScheduleController@publishShift');
	Route::match(['get', 'post'],'/addNotesByDate','ScheduleController@addNotesByDate');
	Route::match(['get', 'post'],'/employeeSchedule','EmployeeController@employeeSchedule');
	
	// Starts : For Position 
	
	Route::match(['get', 'post'],'Position/Search','PositionController@searchList');
	Route::match(['get', 'post'],'/Position','PositionController@index');
	Route::match(['get', 'post'],'/Position/EditForm','PositionController@EditForm');
	Route::match(['get', 'post'],'/Position/Edit','PositionController@edit');
	// Ends : For Position
	Route::match(['get', 'post'],'/EditStaff','AccountController@EditStaff');
	Route::match(['get', 'post'],'/Login','HomeController@login');
	Route::match(['get', 'post'],'/Login/{string}','HomeController@login');
	Route::match(['get', 'post'],'/Register','HomeController@register');
	Route::match(['get', 'post'],'/dashboard','HomeController@dashboard');
	// For Logout
	Route::get('/Logout', function() {
	 		Session::forget('Users');
			return redirect('/Login');
	});
    
	/**********************Admin Starts****************************/
	Route::match(['get', 'post'],'/admin','AdminController@index');
	Route::match(['get', 'post'],'/admin/dashboard','AdminController@dashboard');
	Route::match(['get', 'post'],'/admin/ChangePassword','AdminController@changepassword');
	
	// Event Category 
	Route::match(['get', 'post'],'/admin/addEventCategory','AdminController@addEventCategory');
	Route::match(['get', 'post'],'/admin/editEventCategory/{id}','AdminController@editEventCategory');
	Route::match(['get', 'post'],'/admin/viewEventCategory','AdminController@viewEventCategory');
	Route::match(['get', 'post'],'/admin/statusEventCategory/{status}/{id}','AdminController@statusEventCategory');
	// Event Module 
	Route::match(['get', 'post'],'/admin/addEvent','AdminController@addEvent');
	Route::match(['get', 'post'],'/admin/editEvent/{id}','AdminController@editEvent');
	Route::match(['get', 'post'],'/admin/viewEvent','AdminController@viewEvent');
	Route::match(['get', 'post'],'/admin/statusEvent/{status}/{id}','AdminController@statusEvent');
	// Blog Module 
	Route::match(['get', 'post'],'/admin/addblog','AdminController@addblog');
	Route::match(['get', 'post'],'/admin/editblog/{id}','AdminController@editblog');
	Route::match(['get', 'post'],'/admin/viewblog','AdminController@viewblog');
	Route::match(['get', 'post'],'/admin/statusblog/{status}/{id}','AdminController@statusblog');
	
	// User Module 
	Route::match(['get', 'post'],'/admin/addUser','AdminController@addUser');
	Route::match(['get', 'post'],'/admin/editUser/{id}','AdminController@editUser');
	Route::match(['get', 'post'],'/admin/viewUser','AdminController@viewUser');
	Route::match(['get', 'post'],'/admin/statusUser/{status}/{id}','AdminController@statusUser');
	/**********************Admin Ends****************************/
	// For Logout
	Route::get('/admin/Logout', function() {
	 		Session::forget('Admin');
			return redirect('/admin');
	});
});


//Route::get('/Api', 'ApiController@index');


Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
