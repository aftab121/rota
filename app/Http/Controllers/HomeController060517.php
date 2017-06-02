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
		$company_id = Session::get('Users.company_id');
		$CompanyDetails = CompanyDetails::where(array('id'=>Session::get('Users.company_id')))->first();
		$Locationlist = Location::where('locations.location_company_id','=',$company_id)->where('locations.status','!=',4)->orderBy('location_id', 'desc')->get();
		if(!empty($inputData)){
		
			$yearly_company_target = (@$inputData['yearly_company_target']==1)?1:0;
			$yearly_store_target = (@$inputData['yearly_store_target']==1)?1:0;
			$monthly_company_target = (@$inputData['monthly_company_target']==1)?1:0;
			$monthly_store_target = (@$inputData['monthly_store_target']==1)?1:0;
			//print_r(@$yearly_company_target); echo "==";
			//print_r(@$yearly_store_target); echo "==";
			//print_r(@$monthly_company_target); echo "==";
			//print_r(@$monthly_store_target); echo "==";die;
			if($yearly_company_target==1){
				$userData = array(
				  'company_name' => @$inputData['company_name'],
				  'country_id'  => @$inputData['country_id'],
				  'yearly_company_target'  => $yearly_company_target,
				  'yearly_store_target'  => $yearly_store_target,
				  'monthly_company_target'  => $monthly_company_target,
				  'monthly_store_target'  => $monthly_store_target,
				  'starting_day'  => @$inputData['starting_day'],
				  'last_year_target'  => @$inputData['last_year_target'],
				  'percentage_growth'  => @$inputData['percentage_growth'],
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
					'last_year_target'=> 'required',
					'percentage_growth'=> 'required',
					'budget'=> 'required',
				);
			}
			elseif($yearly_store_target==1){
				$userData = array(
				  'company_name' => @$inputData['company_name'],
				  'country_id'  => @$inputData['country_id'],
				  'yearly_store_target'    => $yearly_store_target,
				  'yearly_company_target'  => $yearly_company_target,
				  'monthly_company_target' => $monthly_company_target,
				   'monthly_store_target'  => $monthly_store_target,
				  'starting_day'  => @$inputData['starting_day'],
				  'store_last_year_target'  => @$inputData['store_last_year_target'],
				  'store_percentage_growth'  => @$inputData['store_percentage_growth'],
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
					'store_last_year_target'=> 'required',
					'store_percentage_growth'=> 'required',
					'budget'=> 'required',
				);
			}
			elseif($monthly_company_target==1){
				$userData = array(
				  'company_name'=> @$inputData['company_name'],
				  'country_id'  => @$inputData['country_id'],
				  'starting_day'=> @$inputData['starting_day'],
				  'yearly_store_target'  => $yearly_store_target,
				  'monthly_company_target'  => $monthly_company_target,
				  'yearly_company_target'  => $yearly_company_target,
				  'monthly_store_target'  => $monthly_store_target,
				  'last_month_target_1'  => @$inputData['last_month_target_1'],
				  'last_month_percentage_growth_1' => @$inputData['last_month_percentage_growth_1'],
				  'last_month_target_2'  => @$inputData['last_month_target_2'],
				  'last_month_percentage_growth_2' => @$inputData['last_month_percentage_growth_2'],
				  'last_month_target_3'  => @$inputData['last_month_target_3'],
				  'last_month_percentage_growth_3' => @$inputData['last_month_percentage_growth_3'],
				  'last_month_target_4'  => @$inputData['last_month_target_4'],
				  'last_month_percentage_growth_4' => @$inputData['last_month_percentage_growth_4'],
				  'last_month_target_5'  => @$inputData['last_month_target_5'],
				  'last_month_percentage_growth_5' => @$inputData['last_month_percentage_growth_5'],
				  'last_month_target_6'  => @$inputData['last_month_target_6'],
				  'last_month_percentage_growth_6' => @$inputData['last_month_percentage_growth_6'],
				  'last_month_target_7'  => @$inputData['last_month_target_7'],
				  'last_month_percentage_growth_7' => @$inputData['last_month_percentage_growth_7'],
				  'last_month_target_8'  => @$inputData['last_month_target_8'],
				  'last_month_percentage_growth_8' => @$inputData['last_month_percentage_growth_8'],
				  'last_month_target_9'  => @$inputData['last_month_target_9'],
				  'last_month_percentage_growth_9' => @$inputData['last_month_percentage_growth_9'],
				  'last_month_target_10'  => @$inputData['last_month_target_10'],
				  'last_month_percentage_growth_10' => @$inputData['last_month_percentage_growth_10'],
				  'last_month_target_11'  => @$inputData['last_month_target_11'],
				  'last_month_percentage_growth_11' => @$inputData['last_month_percentage_growth_11'],
				  'last_month_target_12'  => @$inputData['last_month_target_12'],
				  'last_month_percentage_growth_12' => @$inputData['last_month_percentage_growth_12'],
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
			}
				elseif($monthly_store_target==1){
				$userData = array(
				  'company_name'=> @$inputData['company_name'],
				  'country_id'  => @$inputData['country_id'],
				  'yearly_store_target'  => $yearly_store_target,
				  'monthly_store_target'  => $monthly_store_target,
				  'monthly_company_target'  => $monthly_company_target,
				  'yearly_company_target'  => $yearly_company_target,
				  'starting_day'=> @$inputData['starting_day'],
				  'last_month_store_target_1'  => @$inputData['last_month_store_target_1'],
				  'last_month_store_percentage_growth_1' => @$inputData['last_month_store_percentage_growth_1'],
				  'last_month_store_target_2'  => @$inputData['last_month_store_target_2'],
				  'last_month_store_percentage_growth_2' => @$inputData['last_month_store_percentage_growth_2'],
				  'last_month_store_target_3'  => @$inputData['last_month_store_target_3'],
				  'last_month_store_percentage_growth_3' => @$inputData['last_month_store_percentage_growth_3'],
				  'last_month_store_target_4'  => @$inputData['last_month_store_target_4'],
				  'last_month_store_percentage_growth_4' => @$inputData['last_month_store_percentage_growth_4'],
				  'last_month_store_target_5'  => @$inputData['last_month_store_target_5'],
				  'last_month_store_percentage_growth_5' => @$inputData['last_month_store_percentage_growth_5'],
				  'last_month_store_target_6'  => @$inputData['last_month_store_target_6'],
				  'last_month_store_percentage_growth_6' => @$inputData['last_month_store_percentage_growth_6'],
				  'last_month_store_target_7'  => @$inputData['last_month_store_target_7'],
				  'last_month_store_percentage_growth_7' => @$inputData['last_month_store_percentage_growth_7'],
				  'last_month_store_target_8'  => @$inputData['last_month_store_target_8'],
				  'last_month_store_percentage_growth_8' => @$inputData['last_month_store_percentage_growth_8'],
				  'last_month_store_target_9'  => @$inputData['last_month_store_target_9'],
				  'last_month_store_percentage_growth_9' => @$inputData['last_month_store_percentage_growth_9'],
				  'last_month_store_target_10'  => @$inputData['last_month_store_target_10'],
				  'last_month_store_percentage_growth_10' => @$inputData['last_month_store_percentage_growth_10'],
				  'last_month_store_target_11'  => @$inputData['last_month_store_target_11'],
				  'last_month_store_percentage_growth_11' => @$inputData['last_month_store_percentage_growth_11'],
				  'last_month_store_target_12'  => @$inputData['last_month_store_target_12'],
				  'last_month_store_percentage_growth_12' => @$inputData['last_month_store_percentage_growth_12'],
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
			}
			$messages = array('country_id.required'=>'Please select Country Name.');
			$validator = Validator::make($userData,$rules,$messages);
			$remainder =0;
			// For location Percentage sum is equal to 100 
			$total = 0;
			$total_count = array();
			$total_count['location_monthly_store_target'] = 0;
			if($yearly_company_target==1){
				
				foreach($Locationlist as $location){
					$location_id = $location['location_id'];
					$total = $total+ $inputData['location_percentage_'.$location_id];
				}
				
			}elseif($monthly_company_target==1){
				foreach($Locationlist as $location){
					$location_id = $location['location_id'];
					for($j=1;$j<=12;$j++){
						$total_count['location_monthly_store_target']= $total_count['location_monthly_store_target']+$inputData['location_monthly_store_target_'.$j.$location_id];
						$total = $total+$inputData['location_monthly_store_target_'.$j.$location_id];
					}
				}
				$remainder = $total%100;
			}
			//print_r($remainder);die;
			if(($remainder>0)&&($monthly_company_target==1)){
				$response =array(
					  'Status' => 'danger',
					  'message' => 'Location Percentage growth for every month should be 100%.'
					);
			}elseif(($total!=100)&&($yearly_company_target==1)){
				$response =array(
					  'Status' => 'danger',
					  'message' => 'Location Percentage growth should be 100%.'
					);
			}elseif($validator->fails()){

			$errors = $validator->getMessageBag()->toArray();
			foreach($errors as $error){
				$erMsg = $error[0];
				break;
			}
			$response =array(
					  'Status' => 'danger',
					  'message' => $erMsg
					);
				
			}else{
			
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
				//print_r($userData);die;
				  //rint_r($id);
				 //B::enableQueryLog();
//ser = CompanyDetails::where('id',$id)->update($userData);
//ery = DB::getQueryLog();
//uery = end($query);
//int_r($query);die;
				
				  if(CompanyDetails::where('id', $id)->update($userData)){
					if($yearly_company_target==1){  
						 foreach($Locationlist as $location){
							$location_id = $location['location_id'];
							Location::where('location_id', $location_id)->update(array('location_target_percentage'=>$inputData['location_percentage_'.$location_id]));	 
						}
					}elseif($monthly_company_target==1){  
						
						foreach($Locationlist as $location){
							$location_id = $location['location_id'];
							$location_monthly_store_target = array();
							for($j=1;$j<=12;$j++){
								$location_monthly_store_target['location_monthly_store_target_'.$j] = $inputData['location_monthly_store_target_'.$j.'_'.$location_id];
								//print_r($inputData['location_monthly_store_target_'.$j.'_'.$location_id]);
							}
							Location::where('location_id', $location_id)->update($location_monthly_store_target);	 
						}
					}
					  
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
		return view('home/company')->with('countries',$countries)->with('Locationlist',$Locationlist)->with('CompanyDetails',$CompanyDetails)->with('HolidayLists',$HolidayLists)->with('StaffDateReminders',$StaffDateReminders);
	} 
	public function company1(){
		$var = Session::get('Users.type');
		if(Session::has('Users') == false){
			 return redirect('/Login');
		}else if($var==3){
			return redirect('/Employee');
		}
		
		$countries = Country::lists('country_name','country_id');
		$inputData = array();
		$inputData = Input::all(); 
		$company_id = Session::get('Users.company_id');
		$CompanyDetails = CompanyDetails::where(array('id'=>Session::get('Users.company_id')))->first();
		$Locationlist = Location::where('locations.location_company_id','=',$company_id)->where('locations.status','!=',4)->orderBy('location_id', 'desc')->get();
		if(!empty($inputData)){
			$userData = array(
			  'company_name' => @$inputData['company_name'],
			  'country_id'  => @$inputData['country_id'],
			  'starting_day'  => @$inputData['starting_day'],
			  'last_year_target'  => @$inputData['last_year_target'],
			  'percentage_growth'  => @$inputData['percentage_growth'],
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
				'last_year_target'=> 'required',
				'percentage_growth'=> 'required',
				'budget'=> 'required',
			);
			$messages = array('country_id.required'=>'Please select Country Name.');
			$validator = Validator::make($userData,$rules);
			// For location Percentage sum is equal to 100 
			$total =0;
			foreach($Locationlist as $location){
				$location_id = $location['location_id'];
			    $total = $total+ $inputData['location_percentage_'.$location_id];
			}
			if($total!=100){
					$response =array(
						  'Status' => 'danger',
						  'message' => 'Location Percentage growth should be 100%.'
						);
			}
			elseif($validator->fails()){
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
					 foreach($Locationlist as $location){
						$location_id = $location['location_id'];
						Location::where('location_id', $location_id)->update(array('location_target_percentage'=>$inputData['location_percentage_'.$location_id]));	 
			    	}
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
		return view('home/company1')->with('countries',$countries)->with('Locationlist',$Locationlist)->with('CompanyDetails',$CompanyDetails)->with('HolidayLists',$HolidayLists)->with('StaffDateReminders',$StaffDateReminders);
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
				$response = array( 'Status' => 'danger',
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
					$CompanyDetails = !empty($CompanyDetails)?@$CompanyDetails->toArray():'';
					Session::put('CompanyDetails',@$CompanyDetails);
					//print_r(Session::get('Users'));
					$response = array(
						  'Status' => 'success',
						  'message' =>'Logged in successfully!!'
						);
				}else{
					$response = array('Status' => 'danger','message' =>'Invalid Login Details!!');
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
