<?php namespace App\Http\Controllers;
use Mail;
use Session;
use Redirect;
use Validator;
use Illuminate\Support\Facades\Input;
use Response;
use App\Blog;
use App\User;
use App\HolidayLists;
use App\Country;
use App\Position;
use App\Wages;
use App\Location;
use App\CompanyDetails;
use DB;
class AccountController extends Controller {
	 public function dashboard(){
		
		return view('account/dashboard');
	}

	
    public function index(){
		$var = Session::get('Users.type');//exit;
		if(Session::has('Users') == false){
			 return redirect('/Login');
		}else if($var==3){
			return redirect('/Employee');
		}
		return view('account/index');
	}
	
	public function HolidayEditForm(){
		
		$inputData = Input::all(); 
		$HolidayData = array();
		if(!empty($inputData)){
			$user_id = Session::get('Users.id');
			$search = array('company_id'=>Session::get('Users.company_id'),'id'=>$inputData['holiday_id']);
			
			$HolidayData = HolidayLists::where($search)->first();
		}
		$countries = Country::lists('country_name','country_id');
		return view('home/ajaxHolidayEditForm')->with('HolidayData',$HolidayData)->with('countries',$countries);
	}
	public function Holidaydelete(){
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
			$holidayUpdate['status'] = 4;
			if(HolidayLists::where('id',@$inputData['holiday_id'])->update($holidayUpdate)){ 
			$response =array(
				'Status' => 'success',
				'message' => 'Holiday deleted successfully.'
			);
		  }
		  return json_encode($response);exit;
		}
		
	}
	public function HolidaySearch(){
		$inputData = Input::all(); 
		if(!empty($inputData)){
			$user_id = Session::get('Users.id');
			$search = array('company_id'=>Session::get('Users.company_id'));
			if(!empty($inputData['country_id'])){
			
				$search = array_merge($search,array('holiday_lists.country_id'=>$inputData['country_id']));
			}
			if(!empty($inputData['year'])){
				 $search = array_merge($search,array('holiday_lists.year'=>$inputData['year']));
			}
			//print_r($search);
			$HolidayLists = HolidayLists::where($search)->where('holiday_lists.status', '!=' ,4)->leftJoin('companydetails', 'companydetails.id', '=', 'holiday_lists.company_id')->leftJoin('countries', 'countries.country_id', '=', 'holiday_lists.country_id')->select('companydetails.company_name','countries.country_name','holiday_lists.*')->get();
		}
		return view('home/ajaxHolidayList')->with('HolidayLists',$HolidayLists->toArray());
	}
	public function EditStaffContent(){
		
		$inputData = Input::all(); 
		$company_id = Session::get('CompanyDetails.id');
		if(!empty($inputData)){
			$Userlist = User::where('users.id','=',$inputData['id'])->first();
		}
		$PositionList = Position::where('positions.company_id','=',$company_id)->where('positions.status','!=',4)->get();
		$Locationlist = Location::where('locations.location_company_id','=',$company_id)->where('locations.status','!=',4)->get();
		$Wages = Wages::where('wage_user_id','=',$inputData['id'])->first();
		return view('home/ajaxEditStaff')->with('wages',$Wages)->with('inputData',$Userlist)->with('PositionList',$PositionList->toArray())->with('Locationlist',$Locationlist->toArray());
	}
	public function StaffSearch(){
		$inputData = Input::all(); 
		if(!empty($inputData)){
			$company_id = Session::get('CompanyDetails.id');
			if(!empty($inputData['name'])){
				$string = $inputData['name'];
			}
			$Users = User::where('users.status', '!=' ,4)->where('company_id','=',$company_id)->where('firstname', 'LIKE', "%$string%")->get();
		}
		return view('home/ajaxStaff/ajaxStaffList')->with('Userlists',$Users->toArray());
	}
	
	public function EditStaff(){
		$var = Session::get('Users.type');//exit;
		if(Session::has('Users') == false){
			 return redirect('/Login');
		}else if($var==3){
			return redirect('/Employee');
		}
		$response = array();
		$inputData = array();
		$inputData = Input::all(); 
		$id = @$inputData['hidden_id'];
		if(!empty($inputData)){
			$Users = User::find($id);
			$email_id=@$inputData['email'];
			$userData = array(
			  'firstname' => @$inputData['firstname'],
			  'lastname'  => @$inputData['lastname'],
			  'email'  => @$inputData['email'],
			  'business_contact_no' => @$inputData['business_contact_no'],
			  'gender' => @$inputData['gender'],
			  'type' => @$inputData['type'],
			  'employee_id'=> @$inputData['employee_id'],
			  'emergency_contact'=> @$inputData['emergency_contact'],
			  'emergency_number'=> @$inputData['emergency_number'],
			  'dob'=> @$inputData['dob'],
			  'profile_pic'=> @$inputData['profile_pic'],
			  'previlege_id'  => @$inputData['previlege_id'],
			  'position_ids' => @$inputData['position_ids'],
			  'location_ids' => @$inputData['location_ids'],
			  'start_date_with_company' => @$inputData['start_date_with_company'],
			  'notes'=> @$inputData['notes'],
			);
			$rules = array(
				'firstname'=> 'required',
				'lastname' => 'required',
				'email'    => 'required|email|unique:users,email,'.$id.',id,status,!4',
				'business_contact_no' => 'required',
				'gender'   => 'required',
				'start_date_with_company' => 'required',
				'employee_id'=> 'required',
				'dob'=>  'required',
				'profile_pic' => 'mimes:jpeg,jpg,png,gif|max:10000',
				'emergency_contact'=>  'required',
				'emergency_number'=>  'required',
				'type' => 'required',
				'location_ids' =>'required',
				'position_ids' =>'required',
			);
			$messages = array('start_date_with_company.required'=>'Please choose Joining Date.','type.required'=>'Please choose access permission.','location_ids.required'=>'Please select atleast one location.','position_ids.required'=>'Please select atleast one position.');
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
				 //save to DB user details
				$destinationPath = '';
				$filename        = '';
			    $response = DB::transaction(function($inputData) use ($id,$inputData,$userData,$Users){
				if (Input::hasFile('profile_pic')) {
					$file            = Input::file('profile_pic');
					$destinationPath = public_path().'/images/profile';
					$filename        = time() . '_' . $file->getClientOriginalName();
					$filename = str_replace(' ','_',$filename);
					$uploadSuccess   = $file->move($destinationPath, $filename);
					$userData['profile_pic'] = $filename;
				}else{
					$userData['profile_pic'] = $inputData['profile_pic_old'];
				}
				$userData['position_ids'] = implode(',',@$inputData['position_ids']);
				$userData['location_ids'] = implode(',',@$inputData['location_ids']);
				if($Users['status']==2){
					// Mail Send : Starts Here 
					$pass = url('/ResetPassword').'/'.bin2hex('test'. base64_encode(str_replace('.','',uniqid('',true) )));
					$emailLink = @$pass;
					$emailBody = '';
					Mail::send('email.resetPassword', array('emailBody' => $emailBody, 'emailLink' => $emailLink), function($message)
					{
						$message->to(Input::get('email'),'ROTA Support')->subject('ROTA Support - Reset password link and Activate.');
					});
					// Mail Send : Ends Here 
					$userData['password_link'] = $pass;
				}
				$userData['type'] = (Session::get('Users.type')==1)?$userData['type']:$Users['type'];
				$userData['email'] = (Session::get('Users.type')==1)?$userData['email']:$Users['email'];
			  if(User::where('id', $id)->update($userData)){ 
			        $wages = array();
					$wagesList = Wages::where('wage_user_id', $id)->first();
					if(!empty($wagesList))
					{
						$wages['standard_rate'] = $inputData['standard_rate'];
						$wages['saturday_rate'] = $inputData['saturday_rate'];
						$wages['sunday_rate'] = $inputData['sunday_rate'];
						$wages['overtime_rate'] = $inputData['overtime_rate'];
						$wages['holiday_rate'] = $inputData['holiday_rate'];
						$wages['yearly_rate'] = $inputData['yearly_rate'];
						Wages::where('wage_user_id', $id)->update($wages);
					}else{
						$wages['wage_user_id'] = $id;
						$wages['standard_rate'] = $inputData['standard_rate'];
						$wages['saturday_rate'] = $inputData['saturday_rate'];
						$wages['sunday_rate'] = $inputData['sunday_rate'];
						$wages['overtime_rate'] = $inputData['overtime_rate'];
						$wages['holiday_rate'] = $inputData['holiday_rate'];
						$wages['yearly_rate'] = $inputData['yearly_rate'];
						Wages::create($wages);
					}
					$img = ($userData['profile_pic'])?('profile/'.$userData['profile_pic']):'noimage.png';
					$li = "<span><img src='".asset('images/'.$img)."' ></span>".$userData['firstname'].' '.$userData['lastname'];
					$image_path= asset('images/'.$img);
					 
					$response =array(
						'image_path'=>$image_path,
						 'li' =>$li,
						'Status' => 'success',
						'message' => 'Staff updated successfully.'
					);
			  }
			   return $response;
				});
			}
			return Response::json($response);die;
		}
	} 
	public function addStaff(){
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
			  'firstname' => @$inputData['firstname'],
			  'lastname'  => @$inputData['lastname'],
			  'email'  => @$inputData['email'],
			  'business_contact_no' => @$inputData['business_contact_no'],
			  'gender' => @$inputData['gender'],
			  'type' => @$inputData['type'],
			  'employee_id'=> @$inputData['employee_id'],
			  'emergency_contact'=> @$inputData['emergency_contact'],
			  'emergency_number'=> @$inputData['emergency_number'],
			  'dob'=> @$inputData['dob'],
			  'profile_pic'=> @$inputData['profile_pic'],
			  'previlege_id'  => @$inputData['previlege_id'],
			  'position_ids' => @$inputData['position_ids'],
			  'location_ids' => @$inputData['location_ids'],
			  'start_date_with_company' => @$inputData['start_date_with_company'],
			  'notes'=> @$inputData['notes'],
			);
			$rules = array(
				'firstname'=> 'required',
				'lastname' => 'required',
				'email'    => 'required|email|unique:users,email,NULL,id,status,!4',
				'business_contact_no' => 'required',
				'gender'   => 'required',
				'start_date_with_company' =>'required',
				'employee_id'=> 'required',
				'dob'=>  'required',
				'profile_pic' => 'mimes:jpeg,jpg,png,gif|required|max:10000',
				'emergency_contact'=>  'required',
				'emergency_number'=>  'required',
				'type' => 'required',
				'location_ids' =>'required',
				'position_ids' =>'required',
			);
			$messages = array('start_date_with_company.required'=>'Please choose Joining Date.','type.required'=>'Please choose access permission.','location_ids.required'=>'Please select atleast one location.','position_ids.required'=>'Please select atleast one position.');
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
				 //save to DB user details
				$destinationPath = '';
				$filename        = '';
				if (Input::hasFile('profile_pic') ) {
					$file            = Input::file('profile_pic');
					$destinationPath = public_path().'/images/profile';
					$filename        = time() . '_' . $file->getClientOriginalName();
					$filename = str_replace(' ','_',$filename);
					$uploadSuccess   = $file->move($destinationPath, $filename);
					$userData['profile_pic'] = $filename;
				}
				$pass = url('/ResetPassword').'/'.bin2hex('test'. base64_encode(str_replace('.','',uniqid('',true) )));
				$userData['dob'] = date('Y-m-d',strtotime(@$inputData['dob']));
				$userData['status'] = 2;
				$userData['created_by'] = Session::get('Users.id');
				$userData['company_id'] = Session::get('CompanyDetails.id');
				$userData['password_link'] = $pass;
				$userData['position_ids'] = implode(',',@$userData['position_ids']);
				$userData['location_ids'] = implode(',',@$userData['location_ids']);
				$userData['type'] = (Session::get('Users.type')==1)?$userData['type']:3;
			  if($user = User::create($userData)){ 
				$wages = array();
				$last_id =$user->id ;
				$wages['wage_user_id'] = $last_id;
				$wages['standard_rate'] = $inputData['standard_rate'];
				$wages['saturday_rate'] = $inputData['saturday_rate'];
				$wages['sunday_rate'] = $inputData['sunday_rate'];
				$wages['overtime_rate'] = $inputData['overtime_rate'];
				$wages['holiday_rate'] = $inputData['holiday_rate'];
				$wages['yearly_rate'] = $inputData['yearly_rate'];
				Wages::create($wages);
			    // Mail Send : Starts Here 
				$emailLink = @$pass;
				$img = ($user['profile_pic'])?('profile/'.$userData['profile_pic']):'noimage.png';
				$li = "<li data-id =".$user->id." class='liclick'><span><img src='".asset('images/'.$img)."' ></span>".$user['firstname'].' '.$user['lastname']."</li>";
				$emailBody = '';
				Mail::send('email.resetPassword', array('emailBody' => $emailBody, 'emailLink' => $emailLink),function($message){
					$message->to(Input::get('email'),'ROTA Support')->subject('ROTA Support - Reset password link.');
				});
			    // Mail Send : Ends Here 
				$response =array(
					'li' =>$li,
					'Status' => 'success',
				    'message' => 'Staff added successfully. Mail sended to set password.'
			    );
			  }else{
				  $response = array(
					'Status' => 'danger',
				    'message' => 'Something went wrong.Please try again later.'
			    );
			  }
			  
				
			}
			return json_encode($response);exit;
		}
	} 
    public function Holiday($id= ''){
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
			
			  'country_id' => @$inputData['country_id'],
			  'holiday_name' => @$inputData['holiday_name'],
			  'holiday_date' => @$inputData['holiday_date'],
			  'year'=> @$inputData['year'],
			);
			$rules = array(
				'country_id' => 'required',
				'year' => 'required',
				'holiday_name' => 'required',
				'holiday_date' => 'required',
			);
			$messages = array('holiday_name.required'=> 'Description is required .','country_id.required'=> 'Country name is required .');
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
				$userData['holiday_date'] = date('Y-m-d',strtotime($userData['holiday_date']));
				$userData['holiday_list_user_id'] = Session::get('Users.id');
				$userData['company_id'] = Session::get('CompanyDetails.id');
			    if(HolidayLists::create($userData)){ 
				$response =array(
					'Status' => 'success',
				    'message' => 'Holiday added successfully.'
			    );
			  }
			}
			return json_encode($response);exit;
		}
	} 
    public function HolidayUpdate($id = ''){
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
			
			  'country_id' => @$inputData['country_id'],
			  'holiday_name' => @$inputData['holiday_name'],
			  'holiday_date' => @$inputData['holiday_date'],
			  'year'=> @$inputData['year'],
			);
			$rules = array(
				'country_id' => 'required',
				'year' => 'required',
				'holiday_name' => 'required',
				'holiday_date' => 'required',
			);
			$messages = array('holiday_name.required'=> 'Description is required .','country_id.required'=> 'Country name is required .');
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
				
				$holidayUpdate['holiday_name'] = @$inputData['holiday_name'];
				$holidayUpdate['year'] = @$inputData['year'];
				$holidayUpdate['country_id'] = @$inputData['country_id'];
				$holidayUpdate['holiday_date'] = date('Y-m-d',strtotime($userData['holiday_date']));
			    if(HolidayLists::where('id',@$inputData['id'])->update($holidayUpdate)){ 
				$response =array(
					'Status' => 'success',
				    'message' => 'Holiday updated successfully.'
			    );
			  }
			}
			return json_encode($response);exit;
		}
	}
}
