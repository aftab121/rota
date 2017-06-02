<?php namespace App\Http\Controllers;
use Mail;
use Session;
use Redirect;
use Validator;
use Illuminate\Support\Facades\Input;
use Response;
use App\User;
use App\Position;
use App\Country;
use App\CompanyDetails;
use App\Location;
use App\Shift;
use DB;
class StoreController extends Controller {
	
	public function searchList(){
		$var = Session::get('Users.type');//exit;
		if(Session::has('Users') == false){
			 return redirect('/Login');
		}else if($var==3){
			return redirect('/Employee');
		}
		$inputData = Input::all(); 
		$Position = array();
		if(!empty($inputData)){
			$string = $inputData['name'];
			$company_id = Session::get('CompanyDetails.id');
			$Locationlist = Location::where('locations.location_company_id','=',$company_id)->where('locations.status','!=',4)->where('location_name', 'LIKE', "%$string%")->orderBy('location_id', 'desc')->get();
		}
		return view('store/ajax/List')->with('Locationlist',$Locationlist->toArray());
	}
	public function EditForm(){
		$var = Session::get('Users.type');//exit;
		if(Session::has('Users') == false){
			 return redirect('/Login');
		}else if($var==3){
			return redirect('/Employee');
		}
		$inputData = Input::all(); 
		$Position = array();
		if(!empty($inputData)){
			$user_id = Session::get('Users.id');
			$company_id = Session::get('CompanyDetails.id');
			$search = array('location_id'=>$inputData['id']);
			$Location= Location::where('locations.location_company_id','=',$company_id)->where($search)->where('locations.status','!=',4)->first();
			
		}
		$countries = Country::lists('country_name','country_id');
		$Stafflist = User::where('users.type','=',3)->where('users.company_id','=',$company_id)->get();
		$PositionList = Position::where('positions.company_id','=',$company_id)->where('positions.status','!=',4)->get();
		return view('store/ajax/EditForm')->with('countries',$countries->toArray())->with('PositionList',$PositionList->toArray())->with('Location',$Location->toArray())->with('Stafflist',$Stafflist->toArray());
	}
	public function edit(){
		$var = Session::get('Users.type');//exit;
		if(Session::has('Users') == false){
			 return redirect('/Login');
		}else if($var==3){
			return redirect('/Employee');
		}
		$user_id = Session::get('Users.id');
		$company_id = Session::get('CompanyDetails.id');
		$response = array();
		$inputData = array();
		$inputData = Input::all(); 
		if(!empty($inputData)){
			$userData = array(
			  'location_name' => @$inputData['location_name'],
			   'street_address' => @$inputData['street_address'],
			   'country_id' => @$inputData['country_id'],
			   'state_name' => @$inputData['state_name'],
			   'city' => @$inputData['city'],
			   'zip_code' => @$inputData['zip_code'],   
			   'default_start_time' => @$inputData['default_start_time'],   
			   'default_end_time' => @$inputData['default_end_time'],  
			   'default_meal_break' => @$inputData['default_meal_break'],  
			   'position_ids' => @$inputData['position_ids'],
			  'staff_ids' => @$inputData['staff_ids'],
			);
			$rules = array(
				'location_name' => 'required',
			);
			$messages = array('location_name.required'=>'The Location name is required.');
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
				$userData['position_ids'] = (!empty(@$inputData['position_ids']))?implode(',',@$inputData['position_ids']):'';
				$userData['staff_ids'] =  (!empty(@$inputData['staff_ids']))?implode(',',@$inputData['staff_ids']):'';
				$userData['location_company_id'] = Session::get('CompanyDetails.id');
				$userData['location_user_id'] = Session::get('Users.id');
			    if(Location::where('location_id',@$inputData['id'])->update($userData)){ 
				$response =array(
				    'li' => @$inputData['location_name'],
					'Status' => 'success',
				    'message' => 'Location updated successfully.'
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
	}
	public function index(){
		$var = Session::get('Users.type');//exit;
		if(Session::has('Users') == false){
			 return redirect('/Login');
		}else if($var==3){
			return redirect('/Employee');
		}
		$user_id = Session::get('Users.id');
		$company_id = Session::get('CompanyDetails.id');
		$response = array();
		$inputData = array();
		$inputData = Input::all(); 
		if(!empty($inputData)){
			$userData = array(
			  'location_name' => @$inputData['location_name'],
			   'street_address' => @$inputData['street_address'],
			   'country_id' => @$inputData['country_id'],
			   'state_name' => @$inputData['state_name'],
			   'city' => @$inputData['city'],
			   'zip_code' => @$inputData['zip_code'],   
			   'default_start_time' => @$inputData['default_start_time'],   
			   'default_end_time' => @$inputData['default_end_time'],  
			   'default_meal_break' => @$inputData['default_meal_break'],  
			  'position_ids' => @$inputData['position_ids'],
			  'staff_ids' => @$inputData['staff_ids'],
			);
			$rules = array(
				'location_name' => 'required',
			);
			$messages = array('location_name.required'=>'The Location name is required.','position_ids.required'=>'Please select atleast one position.','staff_ids.required'=>'Please select atleast one staff member.');
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
				
				$userData['position_ids'] = (!empty(@$inputData['position_ids']))?implode(',',@$inputData['position_ids']):'';
				$userData['staff_ids'] =  (!empty(@$inputData['staff_ids']))?implode(',',@$inputData['staff_ids']):'';
				$userData['location_company_id'] = Session::get('CompanyDetails.id');
				$userData['location_user_id'] = Session::get('Users.id');
				$userData['status'] = 1;
			    if($location_id = Location::create($userData)->location_id){ 
				$location =@$inputData['location_name'];
				$li ='<li data-id ="'.$location_id.'" class="liDiv_'.$location_id.'"><span class="liLocationNameDiv'.$location_id.'">  '.$location.'</span><span style="float:right"><a href="#" data-id ='.$location_id.'" class="liclick liclick_'.$location_id.'"><i class="icon-pencil icons" style="color:green;" title="Edit"></i></a>&nbsp;&nbsp;<a href="#" class="deletemodelLocationShow"  data-toggle="modal"  data-target="#deleteLocationModal" data-location_id="'.$location_id.'" title="Delete"><i class="icon-close icons" style="color:red;" ></i></a></span></li>';
				$response =array(
				    'li'=>$li,
					'Status' => 'success',
				    'message' => 'Location added successfully.'
			    );
			  }
			}
			return json_encode($response);exit;
		}
		$Stafflist = User::where('users.type','=',3)->where('users.company_id','=',$company_id)->get();
		$Positionlist = Position::where('positions.company_id','=',$company_id)->where('positions.status','!=',4)->get();
		$Locationlist = Location::where('locations.location_company_id','=',$company_id)->where('locations.status','!=',4)->orderBy('location_id', 'desc')->get();
		$countries = Country::lists('country_name','country_id');
		return view('store/index')->with('countries',$countries->toArray())->with('Locationlist',$Locationlist->toArray())->with('Stafflist',$Stafflist->toArray())->with('Positionlist',$Positionlist->toArray());
	}
	public function DeleteLocation(){
		$var = Session::get('Users.type');
		$inputData = Input::all(); 
		$PositionData = array();
		$response =array();
		if(!empty($inputData)){
		  $PositionData['status'] = 4;
		  $start_date = date('Y-m-d');
		  $shiftsCount = 0;
		  $shiftsCount = Shift::where('location_id','=',$inputData['location_id_todelete'])->where('shifts.status','!=',3)->where('shift_date','>=',$start_date)->get();
		  $shiftsCount = count($shiftsCount);
		  if($shiftsCount==0){
			  if(Location::where('location_id',@$inputData['location_id_todelete'])->update($PositionData)){ 
				$response = array('Status' => 'success','message' => 'Location deleted successfully.');
			  }
		  }else{
		  		$response = array('Status' => 'success','message' => 'Location has shifts assigned to it.It cannot be deleted.');
		  }
		  return json_encode($response);exit;
		}
		
	}
}
