<?php  namespace App\Http\Controllers;
use Mail;
use Session;
use Redirect;
use Validator;
use Illuminate\Support\Facades\Input;
use Response;
use Request;
use App\Country;
use App\User;
use App\CompanyDetails;
use App\HolidayLists;
use App\Position;
use App\Location;
use App\Shift;
use App\StaffDateReminders;
use DB;
class EmployeeController extends Controller {
	
	public function index(){
		$var = Session::get('Users.type');//exit;
		if(Session::has('Users') == false){
			 return redirect('/Login');
		}else if($var==1||$var==2){
			return redirect('/Company');
		}
		$id = Session::get('Users.id');
		$response = array();
		$inputData = Input::all(); 
		if(!empty($inputData)){
			$userData = array(
			  'firstname' => @$inputData['firstname'],
			  'lastname' => @$inputData['lastname'],
			  'email' => @$inputData['email'],
			  'business_contact_no' => @$inputData['business_contact_no'],
			);
			$rules = array(
				'firstname'=> 'required',
				'email'    => 'required|email|unique:users,email,'.$id.',id,status,!4',
			);
			$validator = Validator::make($userData,$rules);
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
				
			  if(User::where('id',@$id)->update($userData)){ 
					Session::set('Users.firstname',$userData['firstname']);
					Session::set('Users.lastname',$userData['lastname']);
					Session::set('Users.email',$userData['email']);
					Session::set('Users.business_contact_no',$userData['business_contact_no']);
					$response =array(
					   'firstname' =>$userData['firstname'],
					    'lastname' =>$userData['lastname'],
					   'Status' => 'success',
						'message' => 'Profile updated successfully.'
					);
			  }else{
				  $response =array(
					'Status' => 'danger',
				    'message' => 'Something went wrong.Please try again later.'
			    );
			  }
			}
			return json_encode($response);exit;
		}
		$Data = User::where('id','=',$id)->first();
		//print_r(Session::get('Users'));exit;
		return view('employee/index')->with('inputData',$Data);
	} 

	
	public function decWeek(){
		$response = array();
		$inputData =Input::all(); 
		if(!empty($inputData)){
			$current_back = $inputData['current_back'];
			$days = ($current_back*7);
			$start_date = date('M d',strtotime($days.' days'));
			$end_date = date('M d',strtotime('+6 days',strtotime($start_date)));
			$response = $start_date.' - '.$end_date;
			return Response::json($response);die;
		}
	}
	public function incWeek(){
		$response = array();
		$inputData =Input::all(); 
		if(!empty($inputData)){
			$current_back = $inputData['current_back'];
			$days = ($current_back*7);
			$start_date = date('M d',strtotime('+'.$days.' days'));
			$end_date = date('M d',strtotime('+6 days',strtotime($start_date)));
			$response = $start_date.' - '.$end_date;
			return Response::json($response);die;
		}
	}
	public function employeeSchedule(){
		$var = Session::get('Users.type');//exit;
		$user_id = Session::get('Users.id');//exit;
		//print_r($user_id);exit;
		if(Session::has('Users') == false){
			 return redirect('/Login');
		}else if($var==1||$var==2){
			return redirect('/dashboard');
		}
		$current_back = 0;
		$days = ($current_back*7);
		$start_date = date('Y-m-d',strtotime('+'.$days.' days'));
		$end_date = date('Y-m-d',strtotime('+6 days',strtotime($start_date)));
		$inputData =Input::all(); 
		$shifts = Shift::where('shifts.assigned_to','=',$user_id)->where('shifts.status','=',1)->where('shift_date','>=',$start_date)->where('shift_date','<=',$end_date)->leftJoin('locations','locations.location_id', '=', 'shifts.location_id')->leftJoin('positions','positions.id', '=', 'shifts.position_id')->select('locations.location_name','positions.position_name','shifts.*')->orderBy('shifts.shift_date', 'asc')->get();
		$shifts = $shifts->toArray();
		//print_r($shifts);
		if(!empty($inputData)){
			$current_back = $inputData['current_back'];
			$days = ($current_back*7);
			$start_date = date('Y-m-d',strtotime('+'.$days.' days'));
			$end_date = date('Y-m-d',strtotime('+6 days',strtotime($start_date)));
			$shifts = Shift::where('shifts.assigned_to','=',$user_id)->where('shifts.status','=',1)->where('shift_date','>=',$start_date)->where('shift_date','<=',$end_date)->leftJoin('locations','locations.location_id', '=', 'shifts.location_id')->leftJoin('positions','positions.id', '=', 'shifts.position_id')->select('locations.location_name','positions.position_name','shifts.*')->orderBy('shifts.shift_date', 'asc')->get();
			$shifts = $shifts->toArray();
			//print_r($shifts);die;
			return view('schedule/ajax/employeeSchedule')->with('Shifts',$shifts);
		}else{
			return view('schedule/employeeSchedule')->with('Shifts',$shifts);
		}
		
	}
}
