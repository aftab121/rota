<?php  namespace App\Http\Controllers;
use Mail;
use Session;
use Redirect;
use Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Routing\Redirector;
use Response;
use Request;
use App\Country;
use App\User;
use App\CompanyDetails;
use App\HolidayLists;
use App\Position;
use App\Location;
use App\StaffDateReminders;
use DB;
class HomeController extends Controller {
	
	public function index(){
		return view('home/login');
	} 
	public function reports(){
		return view('reports/index');
	}
	public function reports1(){
		return view('reports/index1');
	}
	public function changePassword(){
		//return $this->authorized();
		$response =array();
		$inputData =Input::all(); 
		$checkString = '';
		$verifyMessage = array();
		$password_link = User::where('email','=',Session::get('Users.email'))->where('status','!=',4)->first();
		if(!empty($inputData)){
			$userData = array(
			 'old_password'     => @$inputData['old_password'],
			 'password'     => @$inputData['password'],
			 'password_confirmation' => @$inputData['password_confirmation'],
			);
			$rules = array(
				'old_password'     => 'required|check_current_password:' .Session::get('Users.password'),
				'password'     => 'required|min:6|confirmed',
				'password_confirmation' => 'required|min:6',
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
			$pass = url('/ResetPassword').'/'.bin2hex('test'. base64_encode(str_replace('.','',uniqid('',true) )));
			if(@$password_link){
				$password_link->password = md5($inputData['password']);
				$password_link->password_link = '';
				if(@$password_link->save()){
					Session::set('Users.password',$password_link->password);
					$response =array(
						  'Status' => 'success',
						  'message' => 'Password changed successfully.!!'
						);
				}else{
					$response = array(
						  'Status' => 'danger',
						  'message' => "Password cannot reset. Please try again later !!"
						);
				}
			}else{
				$response = array(
						  'Status' => 'danger',
						  'message' => "Either user with this email is not registered or inactive."
						);
			}
			
		}
		return Response::json($response);die;
	} 
	
	    
	return view('home/changePassword')->with('verifyMessage',$verifyMessage);
	}
	
	public function ResetPassword($string){
		$response =array();
		$inputData =Input::all(); 
		$checkString = '';
		$verifyMessage = array();
		if(!empty($string)){
			$check =url('/ResetPassword').'/'.$string;
			$password_link = User::where('password_link','=',$check)->where('status','!=',4)->first();
			if(isset($password_link['password_link'])){
				$checkString = $password_link['password_link'];
			}
		}else{
			$verifyMessage = array(
						  'Status' => 'danger',
						  'message' => "Please go to forget password as verification url is incorrect !!"
						);
			
		}
		if(!empty($checkString)){
		if(!empty($inputData)){
			$userData = array(
			 'password'     => @$inputData['password'],
			 'password_confirmation' => @$inputData['password_confirmation'],
			);
			$rules = array(
				'password'     => 'required|min:6|confirmed',
				'password_confirmation' => 'required|min:6',
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
			$pass = url('/ResetPassword').'/'.bin2hex('test'. base64_encode(str_replace('.','',uniqid('',true) )));
			if(@$password_link){
				$password_link->password = md5($inputData['password']);
				$password_link->password_link = '';
				$password_link->status = 1;
				if(@$password_link->save()){
					$response =array(
						  'Status' => 'success',
						  'message' => 'Password changed successfully. Please login to continue !!'
						);
				}else{
					$response = array(
						  'Status' => 'danger',
						  'message' => "Password cannot reset. Please try again later !!"
						);
				}
			}else{
				$response = array(
						  'Status' => 'danger',
						  'message' => "Either user with this email is not registered or inactive."
						);
			}
			
		}
		return Response::json($response);die;
	} 
	
	    }else{
			$verifyMessage = array(
						  'Status' => 'danger',
						  'message' => "Please go to forget password and send mail as string expires !!"
						);
			
		}
	return view('home/resetPass')->with('verifyMessage',$verifyMessage);
	}
	public function forgetPassword(){
		$response =array();
		$inputData =Input::all(); 
		if(!empty($inputData)){
			$userData = array(
			  'email'  => @$inputData['email'],
			);
			$rules = array(
				
				'email'    => 'required|email',
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
			$pass = url('/ResetPassword').'/'.bin2hex('test'. base64_encode(str_replace('.','',uniqid('',true) )));
			$user = User::where('email','=', $inputData['email'])->where('status','!=',4)->first();
			if(@$user){
				@$user->password_link = $pass;
				if(@$user->save()){
					$response =array(
						  'Status' => 'success',
						  'message' => 'Password reset link send to your email'
						);
					$emailLink = @$pass;
					$emailBody = '';
					Mail::send('email.resetPassword', array('emailBody' => $emailBody, 'emailLink' => $emailLink), function($message)
					{
						$message->to(Input::get('email'), 'ROTA Support')->subject('ROTA Support - Reset password link.');
					});

				}else{
					$response = array(
						  'Status' => 'danger',
						  'message' => "Password cannot reset. PLease try later"
						);
				}
			}else{
				$response = array(
						  'Status' => 'danger',
						  'message' => "Either user with this email is not registered or inactive."
						);
			}
			
		}
		return Response::json($response);die;
	} 
	return view('home/forgetPass');
	}
	public function dashboard(){
		$var = Session::get('Users.type');//exit;
		if(Session::has('Users') == false){
			 return redirect('/Login');
		}else if($var==3){
			return redirect('/Employee');
		}
		return view('home/dashboard');
	} 

	public function company(){
		$var = Session::get('Users.type');
		if(Session::has('Users') == false){
			 return redirect('/Login');
		}else if($var==3){
			return redirect('/Employee');
		}
		$countries = Country::lists('country_name','country_id');
		$inputData = array();
		$inputData = Input::all(); 
		$CompanyDetails = CompanyDetails::where(array('id'=>Session::get('Users.company_id')))->first();
		if(!empty($inputData)){
			$userData = array(
			  'company_name' => @$inputData['company_name'],
			  'country_id'  => @$inputData['country_id'],
			  'starting_day'  => @$inputData['starting_day'],
			  'staff_timesheet' => empty(@$inputData['staff_timesheet'])?0:1,
			  'budget' =>  empty(@$inputData['budget'])?0:1,
			  'labor_cost' =>  empty(@$inputData['labor_cost'])?0:1,
			  'labor_hours'=>  empty(@$inputData['labor_hours'])?0:1,
			  'labor_adjustment'=>  empty(@$inputData['labor_adjustment'])?0:1,
			  'sales_per_hour'=>  empty(@$inputData['sales_per_hour'])?0:1,
			  'notes'=>  empty(@$inputData['notes'])?0:1,
			  'time_format'=>empty(@$inputData['time_format'])?'24':'12'
			);
			$rules = array(
				'company_name'=> 'required',
				'country_id' => 'required',
				'starting_day' => 'required',
				'budget'=> 'required',
				
			);
			$messages = array('country_id.required'=>'Please select Country Name.');
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
			  if(empty($CompanyDetails)){
				  //$userData['user_id'] = Session::get('Users.id');
				if(CompanyDetails::create($userData)){
					$response = array(
					'Status' => 'success',
				    'message' => 'Company Details inserted successfully.'
			        );
				}else{
					$response = array(
					'Status' => 'danger',
				    'message' => 'Something went wrong. Please insert try again later !!'
			        );
				}
			  }else{
				  $id = $CompanyDetails['id'];
				  if(CompanyDetails::where('id', $id)->update($userData)){
					$CompanyDetails = CompanyDetails::where('id','=',$id)->first();
					Session::put('CompanyDetails',$CompanyDetails->toArray());
					  $response = array(
					'Status' => 'success',
				    'message' => 'Company Details updated successfully.'
			        );
				  }else{
					  $response = array(
					'Status' => 'danger',
				    'message' => 'Something went wrong. Please update try again later !!'
			        );
				  }
				}
			}
			return Response::json($response);
			die;
		}
		$HolidayLists = HolidayLists::where(array('company_id'=>Session::get('Users.company_id')))->where('holiday_lists.status', '!=' ,4)->leftJoin('companydetails', 'companydetails.id', '=', 'holiday_lists.company_id')->leftJoin('countries', 'countries.country_id', '=', 'holiday_lists.country_id')->select('companydetails.company_name','countries.country_name','holiday_lists.*')->get();
		$StaffDateReminders = StaffDateReminders::where(array('company_id'=>Session::get('Users.company_id')))->where('staff_datereminders.status', '!=' ,4)->get();
		$CompanyDetails = CompanyDetails::where(array('id'=>Session::get('Users.company_id')))->first();
		return view('home/company')->with('countries',$countries)->with('CompanyDetails',$CompanyDetails)->with('HolidayLists',$HolidayLists)->with('StaffDateReminders',$StaffDateReminders);
	} 
	public function staff(){
		$var = Session::get('Users.type');//exit;
		if(Session::has('Users') == false){
			 return redirect('/Login');
		}else if($var==3){
			return redirect('/Employee');
		}
		$user_id = Session::get('Users.id');
		$company_id = Session::get('CompanyDetails.id');
		$Userlist = User::where('users.company_id','=',$company_id)->get();
		$PositionList = Position::where('positions.company_id','=',$company_id)->where('positions.status','!=',4)->get();
		$Locationlist = Location::where('locations.location_company_id','=',$company_id)->where('locations.status','!=',4)->get();
		return view('home/staff')->with('Userlists',$Userlist)->with('PositionList',$PositionList->toArray())->with('Locationlist',$Locationlist->toArray());
	}
	
	public function login($string =''){
		$verifyMessage = array();
		if (Session::has('Users') ==  true){
			return redirect('/dashboard');
		}
		
		if(!empty($string)){
			$User = User::where('users.tmp_link','=',Request::url())->first();
			if(isset($User->tmp_link)){
				$User->tmp_link = '';
				$User->status = 1;
				$User->save();
				if($User->status==1){
					$verifyMessage['status']="success";
					$verifyMessage['message'] = "Email verified successfully.Login to proceed.";
				}else{
					$verifyMessage['status']="danger";
					$verifyMessage['message'] ="Something went Wrong. Please try again later.";
				}
			}else{
				$verifyMessage['status']="danger";
				$verifyMessage['message'] = "This link expires for email verification. ";
			}
		}
		
		$inputData =Input::all();
		$retJson = array();
		if(!empty($inputData)){
			$userData = array(
			  'email'  => @$inputData['email'],
			  'password'     => @$inputData['password'],
			);
			$rules = array(
				'email'    => 'required|email',
				'password'     => 'required|min:6',
			);
			$validator = Validator::make($userData,$rules);
			if($validator->fails()){
				$errors = $validator->getMessageBag()->toArray();
				foreach($errors as $error){
					$erMsg = $error[0];
					break;
				}
				$response = array(
						  'Status' => 'danger',
						  'message' => $erMsg
						);
			}	
			else {
				$User = User::where('status', '=', 1)->where('password', '=', md5($userData['password']))->where('email', '=', $userData['email'])->first();
				//print_r($User);
				if (isset($User)){
					
					$users = $User->toArray();
					Session::put(['Users'=>$users]);
					$CompanyDetails = CompanyDetails::where('id','=',Session::get('Users.company_id'))->first();
					Session::put('CompanyDetails',$CompanyDetails->toArray());
					//print_r(Session::get('Users'));
					$response = array(
						  'Status' => 'success',
						  'message' =>'Logged in successfully!!'
						);
				}else{
					$response = array(
						  'Status' => 'danger',
						  'message' =>'Invalid Login Details!!'
						);
				}
			}
			return Response::json($response);die;
		}
		return view('home/login')->with('verifyMessage',$verifyMessage);
	}

	public function register(){
		if (Session::has('Users') ==  true){
			return redirect('/dashboard');
		}
		$response =array();
		$inputData = array();
		$inputData =Input::all(); 
		if(!empty($inputData)){
			$userData = array(
			  'firstname' => @$inputData['firstname'],
			  'lastname'  => @$inputData['lastname'],
			  'email'  => @$inputData['email'],
			  'password'     => @$inputData['password'],
			  'password_confirmation' => @$inputData['password_confirmation'],
			  'company_name' => @$inputData['company_name'],
			  'business_contact_no' => @$inputData['business_contact_no'],
			  'accept' => @$inputData['accept'],
			);
			$rules = array(
				'firstname'=> 'required',
				'lastname' => 'required',
				'email'    => 'required|email|unique:users,email,NULL,id,status,!4',
				'company_name' => 'required',
				'password'     => 'required|min:6|confirmed',
				'password_confirmation' => 'required|min:6',
				'business_contact_no' => 'required',
				'accept' => 'required',
			);
			$messages = array('accept.required'=>'Please accept terms & conditions.');
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
				$userData['password'] = md5($userData['password']);
				$userData['tmp_link'] =  url('/Login').'/'.md5(uniqid(rand(), true));
				$userData['status'] = 2;
			  if(User::create($userData)){ 
			    // Mail Send : Starts Here 
				
				Mail::send('email.register', array('tmp_link' => $userData['tmp_link']), function($message)
				{
					$message->to(Input::get('email'), Input::get('firstname'))->subject('Rota Support - Your email is registered.');
				});
			    // Mail Send : Ends Here 
				$response =array(
					'Status' => 'success',
				    'message' => 'Registered Successfully.Please check your mail to verify.'
			    );
			  }
			}
			echo json_encode($response);die;
		}
		return view('home/register')->with('response',$response)->with('inputData',$inputData);
	} 

}
