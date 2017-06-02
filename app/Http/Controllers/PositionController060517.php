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
use App\Shift;
use App\CompanyDetails;
use App\Location;
use DB;
class PositionController extends Controller {
	
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
			$Positionlist = Position::where('positions.company_id','=',$company_id)->where('position_name', 'LIKE', "%$string%")->where('positions.status','!=',4)->get();
		}
		return view('position/ajax/List')->with('Positionlist',$Positionlist->toArray());
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
			$search = array('id'=>$inputData['id']);
			$Position = Position::where('positions.company_id','=',$company_id)->where($search)->where('positions.status','!=',4)->first();
		}
		$Stafflist = User::where('users.created_by','=',$user_id)->where('users.type','=',2)->where('users.company_id','=',$company_id)->get();
		$Locationlist = Location::where('locations.location_company_id','=',$company_id)->where('locations.status','!=',4)->get();
		return view('position/ajax/EditForm')->with('Position',$Position->toArray())->with('Locationlist',$Locationlist->toArray())->with('Stafflist',$Stafflist->toArray());
	}
	public function DeletePositions(){
		$var = Session::get('Users.type');
		$inputData = Input::all(); 
		$PositionData = array();
		$response =array();
		if(!empty($inputData)){
		  $PositionData['status'] = 4;
		  $start_date = date('Y-m-d');
		  $shiftsCount = 0;
		  $shiftsCount = Shift::where('position_id','=',$inputData['positon_id_todelete'])->where('shifts.status','!=',3)->where('shift_date','>=',$start_date)->get();
		  $shiftsCount = count($shiftsCount);
		  if($shiftsCount==0){
			  if(Position::where('id',@$inputData['positon_id_todelete'])->update($PositionData)){ 
				$response = array('Status' => 'success','message' => 'Position deleted successfully.');
			  }
		  }else{
		  		$response = array('Status' => 'success','message' => 'Position has shifts assigned to it.It cannot be deleted .');
		  }
		  return json_encode($response);exit;
		}
		
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
			  'position_name' => @$inputData['position_name'],
			  'location_ids' => @$inputData['location_ids'],
			  'staff_ids' => @$inputData['staff_ids'],
			);
			$rules = array(
				'position_name' => 'required',
			);
			$messages = array('position_name.required'=>'The Position name is required.','location_ids.required'=>'Please select atleast one location.','staff_ids.required'=>'Please select atleast one staff member.');
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
				$userData['location_ids'] = (!empty(@$inputData['location_ids']))?implode(',',@$inputData['location_ids']):'';
				$userData['staff_ids'] =  (!empty(@$inputData['staff_ids']))?implode(',',@$inputData['staff_ids']):'';
				$userData['position_user_id'] = Session::get('Users.id');
				$userData['company_id'] = Session::get('CompanyDetails.id');
				$userData['status'] = 1;
			    if(Position::where('id',@$inputData['id'])->update($userData)){ 
				$response =array(
				    'li' => @$inputData['position_name'],
					'Status' => 'success',
				    'message' => 'Position updated successfully.'
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
			  'position_name' => @$inputData['position_name'],
			  'location_ids' => @$inputData['location_ids'],
			  'staff_ids' => @$inputData['staff_ids'],
			);
			$rules = array(
				'position_name' => 'required',
			);
			$messages = array('position_name.required'=>'The Position name is required.','location_ids.required'=>'Please select atleast one location.','staff_ids.required'=>'Please select atleast one staff member.');
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
				$userData['location_ids'] = (!empty(@$inputData['location_ids']))?implode(',',@$inputData['location_ids']):'';
				$userData['staff_ids'] =  (!empty(@$inputData['staff_ids']))?implode(',',@$inputData['staff_ids']):'';
				$userData['position_user_id'] = Session::get('Users.id');
				$userData['company_id'] = Session::get('CompanyDetails.id');
				$userData['status'] = 1;
			    if(Position::create($userData)){ 
				$response =array(
					'Status' => 'success',
				    'message' => 'Position added successfully.'
			    );
			  }
			}
			return json_encode($response);exit;
		}
		$Stafflist = User::where('users.created_by','=',$user_id)->where('users.type','=',2)->where('users.company_id','=',$company_id)->get();
		$Positionlist = Position::where('positions.company_id','=',$company_id)->where('positions.status','!=',4)->get();
		$Locationlist = Location::where('locations.location_company_id','=',$company_id)->where('locations.status','!=',4)->get();
		return view('position/index')->with('Locationlist',$Locationlist->toArray())->with('Stafflist',$Stafflist->toArray())->with('Positionlist',$Positionlist->toArray());
	}
}
