<?php namespace App\Http\Controllers;
use Mail;
use Session;
use Redirect;
use Validator;
use Illuminate\Support\Facades\Input;
use Response;
use App\Blog;
use App\User;
use App\StaffDateReminders;
use App\Country;
use App\CompanyDetails;
use DB;
class StaffReminderController extends Controller {
	
	public function ReminderEditForm(){
		$var = Session::get('Users.type');//exit;
		if(Session::has('Users') == false){
			 return redirect('/Login');
		}else if($var==3){
			return redirect('/Employee');
		}
		$inputData = Input::all(); 
		$HolidayData = array();
		if(!empty($inputData)){
			$user_id = Session::get('Users.id');
			$search = array('id'=>Session::get('Users.id'),'id'=>$inputData['reminder_id']);
			$StaffDateReminders = StaffDateReminders::where($search)->first();
		}
		return view('home/ajaxStaff/ajaxReminderEditForm')->with('StaffDateReminders',$StaffDateReminders->toArray());
	}
	public function deleteReminder(){
		$var = Session::get('Users.type');//exit;
		if(Session::has('Users') == false){
			 return redirect('/Login');
		}else if($var==3){
			return redirect('/Employee');
		}
		$inputData = Input::all(); 
		$HolidayData = array();
		$response =array();
		if(!empty($inputData)){
			$StaffDateUpdate['status'] = 4;
			if(StaffDateReminders::where('id',@$inputData['reminder_id'])->update($StaffDateUpdate)){ 
			$response =array(
				'Status' => 'success',
				'message' => 'Staff Date/Reminder deleted successfully.'
			);
		  }
		  return json_encode($response);exit;
		}
		
	}
	public function StaffReminder(){
		$var = Session::get('Users.type');//exit;
		if(Session::has('Users') == false){
			 return redirect('/Login');
		}else if($var==3){
			return redirect('/Employee');
		}
		$user_id = Session::get('Users.id');
		$search = array('staff_datereminders_user_id'=>Session::get('Users.id'));
		$StaffDateReminders = StaffDateReminders::where($search)->where('staff_datereminders.status', '!=' ,4)->get();
		return view('home/ajaxStaff/ajaxStaffReminderList')->with('StaffDateReminders',$StaffDateReminders->toArray());
	}
	
    public function addStaffReminder(){
		$var = Session::get('Users.type');//exit;
		if(Session::has('Users') == false){
			 return redirect('/Login');
		}else if($var==3){
			return redirect('/Employee');
		}
		$response = array();
		$inputData = array();
		$inputData = Input::all(); 
		if(!empty($inputData)){
			$userData = array(
			  'date_name' => @$inputData['date_name'],
			  'set_reminders' => @$inputData['setReminder'],
			  'days_advance' => @$inputData['days_advance'],
			);
			$rules = array(
				'date_name' => 'required',
				'set_reminders' => 'required',
				'days_advance' => 'required_if:set_reminders,1',
			);
			$messages = array('days_advance.required_if'=>'The days in advance field is required.');
			$validator = Validator::make($userData,$rules,$messages);
			if($validator->fails()){
				$errors = $validator->getMessageBag()->toArray();
				foreach($errors as $error){
					$erMsg = $error[0];
					break;
				}
				$response =array(
				
						  'Status' => 'danger',
						  'message' => $erMsg
						);
			}	
			else {
				$userData['days_advance'] = ($userData['set_reminders']==1)?$userData['days_advance']:0;
				$userData['staff_datereminders_user_id'] = Session::get('Users.id');
				$userData['company_id'] = Session::get('CompanyDetails.id');
			    if(StaffDateReminders::create($userData)){ 
				$response =array(
					'Status' => 'success',
				    'message' => 'Staff Date/Reminder added successfully.'
			    );
			  }
			}
			return json_encode($response);exit;
		}
	} 
    public function ReminderUpdate($id = ''){
		$var = Session::get('Users.type');//exit;
		if(Session::has('Users') == false){
			 return redirect('/Login');
		}else if($var==3){
			return redirect('/Employee');
		}
		$response = array();
		$inputData = array();
		$inputData = Input::all();
		
		if(!empty($inputData)){
			
			$userData = array(
			  'date_name' => @$inputData['date_name'],
			  'set_reminders' => @$inputData['editsetReminder'],
			  'days_advance' => @$inputData['days_advance'],
			);
			$rules = array(
				'date_name' => 'required',
				'set_reminders' => 'required',
				'days_advance' => 'required_if:set_reminders,1',
			);
			$messages = array('days_advance.required_if'=>'The days in advance field is required.');
			$validator = Validator::make($userData,$rules,$messages);
			if($validator->fails()){
				$errors = $validator->getMessageBag()->toArray();
				foreach($errors as $error){
					$erMsg = $error[0];
					break;
				}
				$response =array(
				
						  'Status' => 'danger',
						  'message' => $erMsg
						);
			}	
			else {
				$userData['days_advance'] = ($userData['set_reminders']==1)?$userData['days_advance']:0;
			    if(StaffDateReminders::where('id',@$inputData['id'])->update($userData)){ 
				$response =array(
					'Status' => 'success',
				    'message' => 'Staff Date/Reminders updated successfully.'
			    );
			  }
			}
			return json_encode($response);exit;
		}
	}
}
