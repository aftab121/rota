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
use App\Note;
use App\SalesPerDay;
use App\HolidayLists;
use DB;
class ScheduleController extends Controller {
	public function index(){
		$var = Session::get('Users.type');
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
		$Stafflist = User::where('users.type','=',3)->where('users.company_id','=',$company_id)->get();
		$Positionlist = Position::where('positions.company_id','=',$company_id)->where('positions.status','!=',4)->get();
		$Locationlist = Location::where('locations.location_company_id','=',$company_id)->where('locations.status','!=',4)->get();
		return view('schedule/index1')->with('Locationlist',$Locationlist->toArray())->with('Stafflist',$Stafflist->toArray())->with('Positionlist',$Positionlist->toArray());
	}
	public function index1(){
		$var = Session::get('Users.type');
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
		$Stafflist = User::where('users.type','=',3)->where('users.company_id','=',$company_id)->get();
		$Positionlist = Position::where('positions.company_id','=',$company_id)->where('positions.status','!=',4)->get();
		$Locationlist = Location::where('locations.location_company_id','=',$company_id)->where('locations.status','!=',4)->get();
		return view('schedule/index')->with('Locationlist',$Locationlist->toArray())->with('Stafflist',$Stafflist->toArray())->with('Positionlist',$Positionlist->toArray());
	}
	public function addNotesByDate(){
		$response = array();
		$inputData = array();
		$inputData = Input::all(); 
		$company_id = Session::get('CompanyDetails.id');
		if(!empty($inputData)){
			$userData = array(
			  'notes' => @$inputData['notes'],
			  'location_ids' => @$inputData['location_ids'],
			  'note_date' => @$inputData['note_date'],
			);
			$rules = array(
				'notes' => 'required',
				'location_ids' => 'required',
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
				$result = DB::transaction(function() use($userData){
					$addData = array();
					$addData['company_id'] = Session::get('CompanyDetails.id');
					$addData['created_by'] = Session::get('Users.id');
					$addData['notes'] = $userData['notes'];
					$addData['note_date'] = $userData['note_date'];
					$notes = Note::where('company_id','=',$addData['company_id'])->whereIn('location_id',$userData['location_ids'])->where('note_date','=',$userData['note_date'])->where('status','=',1)->delete();
					foreach($userData['location_ids'] as $location_id){
						$addData['location_id'] = $location_id;
						Note::create($addData);
					}
					return 1;
				});
			    if($result==1){ 
					$response = array( 'Status' => 'success', 'message' => 'Notes added successfully.');
				}else{
					 $response =array( 'Status' => 'danger', 'message' => 'Something went wrong.Please try again later.');
				}
			}
			return json_encode($response);exit;
		}
	}
	public function publishShift(){
		$response = array();
		$inputData = array();
		$inputData = Input::all(); 
		$company_id = Session::get('CompanyDetails.id');
		if(!empty($inputData)){
			if($inputData['publish_position']=='staff')
			{	$searchData = array('assigned_to' => @$inputData['publish_staff_ids']);
			}else{
				$searchData = array('position_id' => @$inputData['publish_position_ids']);
			}
			if($inputData['publish_position']=='staff')
			{	$rules = array('assigned_to' => 'required');
			}else{
				$rules = array('position_id' => 'required');
			}
			$messages = array('position_id.required' => 'Please Select Position ','assigned_to.required' => 'Please Select Staff. ');
			$validator = Validator::make($searchData,$rules,$messages);
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
				$current_back = $inputData['current_back'];
				$days = ($current_back*7);
				$start_date = date('Y-m-d',strtotime($days.' days'));
				$end_date = date('Y-m-d',strtotime('+6 days',strtotime($start_date)));
				$userData['status'] = 1;
				if($inputData['publish_position']=='staff')
				{	
					$result = Shift::whereIn('assigned_to',$searchData['assigned_to'])->where('shifts.status','!=',1)->where('shifts.status','!=',3)->where('shift_date','>=',$start_date)->where('shift_date','<=',$end_date)->update($userData);
				}else{
					$result = Shift::whereIn('position_id',$searchData['position_id'])->where('shifts.status','!=',1)->where('shifts.status','!=',3)->where('shift_date','>=',$start_date)->where('shift_date','<=',$end_date)->update($userData);
				}
				 if($result){ 
					$response = array( 'Status' => 'success', 'message' => 'Shift published successfully.');
				}else{
					$response =array( 'Status' => 'danger', 'message' => 'Something went wrong.Please try again later.');
				}
			}
			return json_encode($response);exit;
		}
	}
	public function AddShift(){
		$response = array();
		$inputData = array();
		$inputData = Input::all(); 
		$company_id = Session::get('CompanyDetails.id');
		if(!empty($inputData)){
			$userData = array(
			  'location_id' => @$inputData['location_id'],
			  'shift_date' => @$inputData['shift_date'],
			  'shift_start_time' => @$inputData['shift_start_time'],
			  'shift_end_time' => @$inputData['shift_end_time'],
			  'meal_break' => @$inputData['meal_break'],
			  'end_option' => @$inputData['end_option'],
			  'notes' => @$inputData['notes'],
			  'position_id' => @$inputData['position_id'],
				 'assigned_to' => @$inputData['assigned_to'],
			  'visible' => empty(@$inputData['visible'])?0:1,
			);
			if(@$inputData['type_set']=='staff'){
			$rules = array(
				'location_id' => 'required',
				'shift_start_time' => 'required',
				'shift_end_time' => 'required',
				'position_id' => 'required',
			);
				$messages =array('position_id.required'=>'Position assignment is required.');
			}else{
				$rules = array(
				'location_id' => 'required',
				'shift_start_time' => 'required',
				'shift_end_time' => 'required',
				'assigned_to' => 'required',
			);
				$messages =array('assigned_to.required'=>'Staff Member assignment is required.');
			}
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
				$userData['assigned_by'] = Session::get('Users.id');
				$userData['company_id'] = Session::get('CompanyDetails.id');
				$userData['status'] = 0;
				$flag = 0;
				$shift_date = @$inputData['shift_date'];
				$shift_start_time = date('Y-m-d ').@$inputData['shift_start_time'];
				$shift_end_time = date('Y-m-d ').@$inputData['shift_end_time'];
				$shift_start_time = date('Y-m-d H:i:s',strtotime($shift_start_time));
				$shift_end_time = date('Y-m-d H:i:s',strtotime($shift_end_time));
				$userData['shift_start_time'] =$shift_start_time;
					$userData['shift_end_time'] =$shift_end_time;
				if(@$inputData['position_id']){
					$userData['assigned_to'] =  $inputData['shift_user_id'];
					
					/*foreach($inputData['position_id'] as $post_id){
						$PositionLists = Position::where('positions.company_id','=',$company_id)->where('id','=',$post_id)->first();
						$Positions = $PositionLists->toArray();*/
						$userData['position_id'] = $inputData['position_id'];
						if($shift = Shift::create($userData)){ 
						
							$result = DB::select(DB::raw('select group_concat(id) as id_list from `shifts` 
where `assigned_to` = "'.$userData['assigned_to'].'" 
and `shifts`.`status` != 3 and `shifts`.`shift_date` = "'.$shift_date.'"
and (   (`shift_start_time` < "'.$shift_start_time.'" AND  `shift_end_time` > "'.$shift_start_time.'") 
  OR 
  (`shift_start_time` < "'.$shift_end_time.'" AND `shift_end_time` >="'.$shift_end_time.'") 
  OR 
  (`shift_start_time` = "'.$shift_start_time.'" AND `shift_end_time` ="'.$shift_end_time.'") 
)'));
						
			//dd(DB::getQueryLog());
			$count_conflict = $result;
			if(isset($count_conflict[0]->id_list))
			{ 
				$shift_ids = explode(',',$count_conflict[0]->id_list);	
				if(count($shift_ids)>1){
					$update['is_conflict']= 1;
					$resultset = Shift::whereIn('id',$shift_ids)->update($update);
				}else{
					$update['is_conflict']= 0;
					$resultset = Shift::whereIn('id',$shift_ids)->update($update);
				}
			}
							$flag = 1;
						}
					
				}elseif(@$inputData['assigned_to']){
					
					$userData['position_id'] = $inputData['shift_position_id'];
					/*foreach($inputData['assigned_to'] as $post_id){
						$UserLists = User::where('company_id','=',$company_id)->where('id','=',$post_id)->first();
						$UserList = $UserLists->toArray();*/
						$userData['assigned_to'] = $inputData['assigned_to'];
						
						if($shift = Shift::create($userData)){ 
						$result = DB::select(DB::raw('select group_concat(id) as id_list from `shifts` 
where `assigned_to` = "'.$inputData['assigned_to'].'" 
and `shifts`.`status` != 3 and `shifts`.`shift_date` = "'.$shift_date.'"
and (   (`shift_start_time` < "'.$shift_start_time.'" AND  `shift_end_time` > "'.$shift_start_time.'") 
  OR 
  (`shift_start_time` < "'.$shift_end_time.'" AND `shift_end_time` >="'.$shift_end_time.'") 
   OR 
  (`shift_start_time` = "'.$shift_start_time.'" AND `shift_end_time` ="'.$shift_end_time.'") 
)'));
						
			//dd(DB::getQueryLog());
			$count_conflict = $result;
			if(isset($count_conflict[0]->id_list))
			{ 
				$shift_ids = explode(',',$count_conflict[0]->id_list);	
				if(count($shift_ids)>1){
					$update['is_conflict']= 1;
					$resultset = Shift::whereIn('id',$shift_ids)->update($update);
				}else{
					$update['is_conflict']= 0;
					$resultset = Shift::whereIn('id',$shift_ids)->update($update);
				}
			}	
			$flag = 1;	
					}
				}else{
					if($shift = Shift::create($userData)){ 
					$result = DB::select(DB::raw('select group_concat(id) as id_list from `shifts` 
where `shifts`.`status` != 3 and `shifts`.`shift_date` = "'.$shift_date.'"
and (   (`shift_start_time` < "'.$shift_start_time.'" AND  `shift_end_time` > "'.$shift_start_time.'") 
  OR 
  (`shift_start_time` < "'.$shift_end_time.'" AND `shift_end_time` >="'.$shift_end_time.'") 
   OR 
  (`shift_start_time` = "'.$shift_start_time.'" AND `shift_end_time` ="'.$shift_end_time.'") 
)'));
						
			//dd(DB::getQueryLog());
			$count_conflict = $result;
			if(isset($count_conflict[0]->id_list))
			{ 
				$shift_ids = explode(',',$count_conflict[0]->id_list);	
				if(count($shift_ids)>1){
					$update['is_conflict']= 1;
					$resultset = Shift::whereIn('id',$shift_ids)->update($update);
				}else{
					$update['is_conflict']= 0;
					$resultset = Shift::whereIn('id',$shift_ids)->update($update);
				}
			}
						$flag = 1;
					}
				}
			    if($flag==1){
					// For Sales Calculation :Start 
					$location_id = $inputData['location_id'];
					$shift_date = $inputData['shift_date'];
					$result = SalesPerDay::where('company_id','=',$company_id)->where('location_id','=',$location_id)->where('sales_shift_date','=',$shift_date)->first();
					
					
					if(!empty($result)){
					$result = $result->toArray();
					$filled_shifts = Shift::where('location_id','=',$location_id)->where('shifts.assigned_to','!=',0)->where('shifts.status','!=',3)->where('shifts.shift_date','=',$shift_date)->leftJoin('wages','wages.wage_user_id','=','shifts.assigned_to')->select('shifts.*','wages.*')->get();
					$total_hrs =0;
					$holidayList = HolidayLists::where('company_id','=',$company_id)->where('status','!=',4)->select('holiday_date')->get();
					$holidayList = $holidayList->toArray();
					$holiday_list = array_column($holidayList,'holiday_date');
					
					array_walk($holiday_list, function(&$items){
						$items = strtotime($items);
					});
					$total_cost = 0;
					foreach($filled_shifts->toArray() as $fillShift ){
						
						if(strtotime($fillShift['shift_start_time'])!==strtotime($fillShift['shift_end_time'])){
							$diff = strtotime($fillShift['shift_start_time']) - strtotime($fillShift['shift_end_time']);
							$diff = abs($diff)- $fillShift['meal_break']*60;
							$diff_in_hrs = $diff/3600;
							$total_hrs = $total_hrs + abs($diff_in_hrs);
							if(in_array(strtotime($fillShift['shift_date']),$holiday_list)){ // holiday Rate
								 $total_cost =  $total_cost+ ($diff_in_hrs*$fillShift['holiday_rate']);
							}elseif(date('w', strtotime($fillShift['shift_date'])) == 6){//saturday
								 $total_cost =  $total_cost+ ($diff_in_hrs*$fillShift['saturday_rate']);
							}elseif(date('w', strtotime($fillShift['shift_date'])) == 0){//sunday
								 $total_cost =  $total_cost + ($diff_in_hrs*$fillShift['sunday_rate']);
							}else{
								$total_cost =  $total_cost + ($diff_in_hrs*$fillShift['standard_rate']);
							}
						}
					}
					
					$percentage_cost = ($result['sales_price']!=0)?(number_format((abs($total_cost)+ $result['labour_variation'])/$result['sales_price'],2)*100):0;
					$editData =array();
					$editData['sales_percentage'] =  $percentage_cost;
					$editData['sales_per_hour'] =  ($total_hrs!=0)?(number_format(($result['sales_price']/$total_hrs),2)):0;
					$resultset = SalesPerDay::where('company_id','=',$company_id)->where('location_id','=',$location_id)->where('sales_shift_date','=',$shift_date)->update($editData);
					}
					// For Sales Calculation :End 
					$response =array( 'Status' => 'success', 'message' => 'Shift added successfully.');
				}else{
					 $response =array( 'Status' => 'danger', 'message' => 'Something went wrong.Please try again later.');
				}
			}
			return json_encode($response);exit;
		}
	}
	public function EditShift(){
		$response = array();
		$inputData = array();
		$inputData = Input::all(); 
		$company_id = Session::get('CompanyDetails.id');
		if(!empty($inputData)){
			$userData = array(
			  'location_id' => @$inputData['location_id'],
			  'position_id' => @$inputData['shift_position_id'],
			  'shift_date' => @$inputData['shift_date'],
			  'shift_start_time' => @$inputData['shift_start_time'],
			  'shift_end_time' => @$inputData['shift_end_time'],
			  'meal_break' => @$inputData['meal_break'],
			  'end_option' => @$inputData['end_option'],
			  'notes' => @$inputData['notes'],
			  'position_id' => @$inputData['position_id'],
			  'assigned_to' => @$inputData['assigned_to'],
			  'visible' => empty(@$inputData['visible'])?0:1,
			);
			
			if(@$inputData['type_set']=='staff'){
			$rules = array(
				'location_id' => 'required',
				'shift_start_time' => 'required',
				'shift_end_time' => 'required',
				'position_id' => 'required',
			);
				$messages =array('position_id.required'=>'Position assignment is required.');
			}else{
				$rules = array(
				'location_id' => 'required',
				'shift_start_time' => 'required',
				'shift_end_time' => 'required',
				'assigned_to' => 'required',
			);
				$messages =array('assigned_to.required'=>'Staff Member assignment is required.');
			}
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
				$userData['assigned_by'] = Session::get('Users.id');
				$userData['company_id'] = Session::get('CompanyDetails.id');
				$flag = 0;
				$shift_date = @$inputData['shift_date'];
				 $shift_start_time = date('Y-m-d ').@$inputData['shift_start_time'];
				$shift_end_time = date('Y-m-d ').@$inputData['shift_end_time'];
				$shift_start_time = date('Y-m-d H:i:s',strtotime($shift_start_time));
				$shift_end_time = date('Y-m-d H:i:s',strtotime($shift_end_time));
				$userData['shift_start_time'] =$shift_start_time;
					$userData['shift_end_time'] =$shift_end_time;
				if(@$inputData['type_set']=='staff'){
					$userData['assigned_to'] =  $inputData['shift_user_id'];
					/*foreach($inputData['shift_editposition_id'] as $post_id){
						$PositionLists = Position::where('positions.company_id','=',$company_id)->where('id','=',$post_id)->first();
						$Positions = $PositionLists->toArray();*/
						$userData['position_id'] = $inputData['position_id'];
						$userData['is_conflict'] = 0;
						if(Shift::where('id',@$inputData['shift_id'])->update($userData)){ 
													$result = DB::select(DB::raw('select group_concat(id) as id_list from `shifts` 
where `assigned_to` = "'.$inputData['shift_user_id'].'" 
and `shifts`.`status` != 3 and `shifts`.`shift_date` = "'.$shift_date.'"
and (   (`shift_start_time` < "'.$shift_start_time.'" AND  `shift_end_time` > "'.$shift_start_time.'") 
  OR 
  (`shift_start_time` < "'.$shift_end_time.'" AND `shift_end_time` >="'.$shift_end_time.'") 
   OR 
  (`shift_start_time` = "'.$shift_start_time.'" AND `shift_end_time` ="'.$shift_end_time.'") 
)'));
						

						
			//dd(DB::getQueryLog());
			$count_conflict = $result;
			if(isset($count_conflict[0]->id_list))
			{ 
				$shift_ids = explode(',',$count_conflict[0]->id_list);	
				if(count($shift_ids)>1){
					$update['is_conflict']= 1;
					$resultset = Shift::whereIn('id',$shift_ids)->update($update);
				}else{
					$update['is_conflict']= 0;
					$resultset = Shift::whereIn('id',$shift_ids)->update($update);
				}
			}
							$flag = 1;
						}
					
				}elseif(@$inputData['type_set']=='position'){
					$userData['position_id'] = $inputData['shift_position_id'];
					/*foreach($inputData['assigned_to'] as $post_id){
						$UserLists = User::where('company_id','=',$company_id)->where('id','=',$post_id)->first();
						$UserList = $UserLists->toArray();*/
						$userData['assigned_to'] = $inputData['assigned_to'];
						if(Shift::where('id',@$inputData['shift_id'])->update($userData)){
													$result = DB::select(DB::raw('select group_concat(id) as id_list from `shifts` 
where `assigned_to` = "'.$inputData['assigned_to'].'" 
and `shifts`.`status` != 3 and `shifts`.`shift_date` = "'.$shift_date.'"
and (   (`shift_start_time` < "'.$shift_start_time.'" AND  `shift_end_time` > "'.$shift_start_time.'") 
  OR 
  (`shift_start_time` < "'.$shift_end_time.'" AND `shift_end_time` >="'.$shift_end_time.'") 
   OR 
  (`shift_start_time` = "'.$shift_start_time.'" AND `shift_end_time` ="'.$shift_end_time.'") 
)'));
						

						
			//dd(DB::getQueryLog());
			$count_conflict = $result;
			if(isset($count_conflict[0]->id_list))
			{ 
				$shift_ids = explode(',',$count_conflict[0]->id_list);	
				if(count($shift_ids)>1){
					$update['is_conflict']= 1;
					$resultset = Shift::whereIn('id',$shift_ids)->update($update);
				}else{
					$update['is_conflict']= 0;
					$resultset = Shift::whereIn('id',$shift_ids)->update($update);
				}
			}
							$flag = 1;
						}
				//	}
				}else{
				//	shift_position_id
					if(Shift::where('id',@$inputData['shift_id'])->update($userData)){ 
					    						$result = DB::select(DB::raw('select group_concat(id) as id_list from `shifts` 
where  `shifts`.`status` != 3 and `shifts`.`shift_date` = "'.$shift_date.'"
and (   (`shift_start_time` < "'.$shift_start_time.'" AND  `shift_end_time` > "'.$shift_start_time.'") 
  OR 
  (`shift_start_time` < "'.$shift_end_time.'" AND `shift_end_time` >="'.$shift_end_time.'") 
   OR 
  (`shift_start_time` = "'.$shift_start_time.'" AND `shift_end_time` ="'.$shift_end_time.'") 
)'));
						

						
			//dd(DB::getQueryLog());
			$count_conflict = $result;
			if(isset($count_conflict[0]->id_list))
			{ 
				$shift_ids = explode(',',$count_conflict[0]->id_list);	
				if(count($shift_ids)>1){
					$update['is_conflict']= 1;
					$resultset = Shift::whereIn('id',$shift_ids)->update($update);
				}else{
					$update['is_conflict']= 0;
					$resultset = Shift::whereIn('id',$shift_ids)->update($update);
				}
			}
						$flag = 1;
					}
				}
			    if($flag==1){ 
					// For Sales Calculation :Start 
					$location_id = $inputData['location_id'];
					$shift_date = $inputData['shift_date'];
					$result = SalesPerDay::where('company_id','=',$company_id)->where('location_id','=',$location_id)->where('sales_shift_date','=',$shift_date)->first();
					
					if(!empty($result)){
					$result = $result->toArray();
					$filled_shifts = Shift::where('location_id','=',$location_id)->where('shifts.assigned_to','!=',0)->where('shifts.status','!=',3)->where('shifts.shift_date','=',$shift_date)->leftJoin('wages','wages.wage_user_id','=','shifts.assigned_to')->select('shifts.*','wages.*')->get();
					$total_hrs =0;
					$holidayList = HolidayLists::where('company_id','=',$company_id)->where('status','!=',4)->select('holiday_date')->get();
					$holidayList = $holidayList->toArray();
					$holiday_list = array_column($holidayList,'holiday_date');
					
					array_walk($holiday_list, function(&$items){
						$items = strtotime($items);
					});
					$total_cost = 0;
					foreach($filled_shifts->toArray() as $fillShift ){
						
						if(strtotime($fillShift['shift_start_time'])!==strtotime($fillShift['shift_end_time'])){
							$diff = strtotime($fillShift['shift_start_time']) - strtotime($fillShift['shift_end_time']);
							$diff = abs($diff)- $fillShift['meal_break']*60;
							$diff_in_hrs = $diff/3600;
							$total_hrs = $total_hrs + abs($diff_in_hrs);
							if(in_array(strtotime($fillShift['shift_date']),$holiday_list)){ // holiday Rate
								 $total_cost =  $total_cost+ ($diff_in_hrs*$fillShift['holiday_rate']);
							}elseif(date('w', strtotime($fillShift['shift_date'])) == 6){//saturday
								 $total_cost =  $total_cost+ ($diff_in_hrs*$fillShift['saturday_rate']);
							}elseif(date('w', strtotime($fillShift['shift_date'])) == 0){//sunday
								 $total_cost =  $total_cost + ($diff_in_hrs*$fillShift['sunday_rate']);
							}else{
								$total_cost =  $total_cost + ($diff_in_hrs*$fillShift['standard_rate']);
							}
						}
					}
					
					$percentage_cost = ($result['sales_price']!=0)?(number_format((abs($total_cost)+ $result['labour_variation'])/$result['sales_price'],2)*100):0;
					$editData =array();
					$editData['sales_percentage'] =  $percentage_cost;
					$editData['sales_per_hour'] =  ($total_hrs!=0)?(number_format(($result['sales_price']/$total_hrs),2)):0;
					$resultset = SalesPerDay::where('company_id','=',$company_id)->where('location_id','=',$location_id)->where('sales_shift_date','=',$shift_date)->update($editData);
					}
					// For Sales Calculation :End
					$response =array( 'Status' => 'success', 'message' => 'Shift updated successfully.');
				}else{
					 $response =array( 'Status' => 'danger', 'message' => 'Something went wrong.Please try again later.');
				}
			}
			return json_encode($response);exit;
		}
	}
	public function DeleteShift(){
		$response = array();
		$inputData = array();
		$inputData = Input::all(); 
		$company_id = Session::get('CompanyDetails.id');
		if(!empty($inputData)){
				if(@$inputData['shift_id']){
					$userData['status'] = 3;
					if(Shift::where('id',@$inputData['shift_id'])->update($userData)){
						$deletedData = Shift::where('id',@$inputData['shift_id'])->first();
						$shift_date = $deletedData['shift_date'];
						$location_id = $deletedData['location_id'];
						$shift_start_time = $deletedData['shift_start_time'];
						$shift_end_time = $deletedData['shift_end_time'];
						$assigned_to = $deletedData['assigned_to'];
						$result = DB::select(DB::raw('select group_concat(id) as id_list from `shifts` 
where  `shifts`.`assigned_to` = "'.$assigned_to.'" and `shifts`.`status` != 3 and `shifts`.`shift_date` = "'.$shift_date.'"
and (   (`shift_start_time` < "'.$shift_start_time.'" AND  `shift_end_time` > "'.$shift_start_time.'") 
  OR 
  (`shift_start_time` < "'.$shift_end_time.'" AND `shift_end_time` >="'.$shift_end_time.'") 
   OR 
  (`shift_start_time` = "'.$shift_start_time.'" AND `shift_end_time` ="'.$shift_end_time.'") 
)'));
						

			$count_conflict = $result;
			if(isset($count_conflict[0]->id_list))
			{ 
				$shift_ids = explode(',',$count_conflict[0]->id_list);	
				if(count($shift_ids)>1){
					$update['is_conflict']= 1;
					$resultset = Shift::whereIn('id',$shift_ids)->update($update);
				}else{
					$update['is_conflict']= 0;
					$resultset = Shift::whereIn('id',$shift_ids)->update($update);
				}
			}
						$flag = 1;
					}
				}
			    if($flag==1){
					// For Sales Calculation :Start 
					$shift_date = $deletedData['shift_date'];
					$result = SalesPerDay::where('company_id','=',$company_id)->where('location_id','=',$location_id)->where('sales_shift_date','=',$shift_date)->first();
					
					if(!empty($result)){
					$result = $result->toArray();
					$filled_shifts = Shift::where('location_id','=',$location_id)->where('shifts.assigned_to','!=',0)->where('shifts.status','!=',3)->where('shifts.shift_date','=',$shift_date)->leftJoin('wages','wages.wage_user_id','=','shifts.assigned_to')->select('shifts.*','wages.*')->get();
					$total_hrs =0;
					$holidayList = HolidayLists::where('company_id','=',$company_id)->where('status','!=',4)->select('holiday_date')->get();
					$holidayList = $holidayList->toArray();
					$holiday_list = array_column($holidayList,'holiday_date');
					
					array_walk($holiday_list, function(&$items){
						$items = strtotime($items);
					});
					$total_cost = 0;
					foreach($filled_shifts->toArray() as $fillShift ){
						
						if(strtotime($fillShift['shift_start_time'])!==strtotime($fillShift['shift_end_time'])){
							$diff = strtotime($fillShift['shift_start_time']) - strtotime($fillShift['shift_end_time']);
							$diff = abs($diff)- $fillShift['meal_break']*60;
							$diff_in_hrs = $diff/3600;
							$total_hrs = $total_hrs + abs($diff_in_hrs);
							if(in_array(strtotime($fillShift['shift_date']),$holiday_list)){ // holiday Rate
								 $total_cost =  $total_cost+ ($diff_in_hrs*$fillShift['holiday_rate']);
							}elseif(date('w', strtotime($fillShift['shift_date'])) == 6){//saturday
								 $total_cost =  $total_cost+ ($diff_in_hrs*$fillShift['saturday_rate']);
							}elseif(date('w', strtotime($fillShift['shift_date'])) == 0){//sunday
								 $total_cost =  $total_cost + ($diff_in_hrs*$fillShift['sunday_rate']);
							}else{
								$total_cost =  $total_cost + ($diff_in_hrs*$fillShift['standard_rate']);
							}
						}
					}
					
					$percentage_cost = ($result['sales_price']!=0)?(number_format((abs($total_cost)+ $result['labour_variation'])/$result['sales_price'],2)*100):0;
					$editData =array();
					$editData['sales_percentage'] =  $percentage_cost;
					$editData['sales_per_hour'] =  number_format(($result['sales_price']/$total_hrs),2);
					$resultset = SalesPerDay::where('company_id','=',$company_id)->where('location_id','=',$location_id)->where('sales_shift_date','=',$shift_date)->update($editData);
					}
					// For Sales Calculation :End
					$response =array( 'Status' => 'success', 'message' => 'Shift deleted successfully.');
				}else{
					 $response =array( 'Status' => 'danger', 'message' => 'Something went wrong.Please try again later.');
				}
			
			return json_encode($response);exit;
		}
	}
}
