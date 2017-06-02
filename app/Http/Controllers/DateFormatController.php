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
use App\HolidayLists;
use App\CompanyDetails;
use App\Location;
use App\Shift;
use App\Note;
use App\SalesPerDay;
use DB;
class DateFormatController extends Controller {
	public function DeleteWeekShifts(){
		$response = array();
		$inputData = array();
		$inputData = Input::all(); 
		$company_id = Session::get('CompanyDetails.id');
		if(!empty($inputData)){
			$flag = 0;
			$location_id = $inputData['location_id'];
			$start_date = date('Y-m-d',strtotime($inputData['current_delete_start_date']));
			$end_date = date('Y-m-d',strtotime($inputData['current_delete_end_date']));
			$shifts = Shift::where('location_id','=',$location_id)->where('shifts.status','!=',3)->where('shift_date','>=',$start_date)->where('shift_date','<=',$end_date)->get();
			if(!empty(@$shifts->toArray())){
				//print_r($shifts);
				$flag = 1;
				$shiftList = $shifts->toArray();
			foreach($shiftList as $deletedData){
				//print_r($deletedData);exit;
				$userData = array();
					$userData['status'] = 3;
					//echo $deletedData['id']; echo "==";
					if(Shift::where('id',@$deletedData['id'])->update($userData)){
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
					$editData['sales_per_hour'] =  ($total_hrs!=0)?(number_format(($result['sales_price']/$total_hrs),2)):0;
					$resultset = SalesPerDay::where('company_id','=',$company_id)->where('location_id','=',$location_id)->where('sales_shift_date','=',$shift_date)->update($editData);
					}
					// For Sales Calculation :End
					
				}
			
				}
			}
		}else{
			$flag = 2;
		}
				if($flag==1){
					$response =array( 'Status' => 'success', 'message' => 'Week Shift deleted successfully.');
				}elseif($flag==2){
					$response =array( 'Status' => 'success', 'message' => 'No Week Shifts to be deleted.');
				}else{
					 $response =array( 'Status' => 'danger', 'message' => 'Something went wrong.Please try again later.');
				}
		return json_encode($response);exit;
	}
}
	public function ShowWeek(){
		$response = array();
		$inputData =Input::all(); 
		if(!empty($inputData)){
			$company_id = Session::get('CompanyDetails.id');
			$response ='';
			$shift_currentweekStart = $inputData['shift_currentweekStart'];
			$start_date = date('M d',strtotime($shift_currentweekStart));
			$end_date = date('M d',strtotime('+6 days',strtotime($start_date)));
			$response['current_delete_weeks'] = $start_date.' - '.$end_date;
			$response['current_delete_start_date'] = date('Y-m-d',strtotime($start_date));
			$response['current_delete_end_date'] = date('Y-m-d',strtotime($end_date));
			return $response;die;
		}	
	}
	
	public function WeeklyTarget(){
		$response = array();
		$inputData =Input::all(); 
		if(!empty($inputData)){
			$company_id = Session::get('CompanyDetails.id');
			$company_percentage_growth = Session::get('CompanyDetails.percentage_growth');
		    $company_last_year_target = Session::get('CompanyDetails.last_year_target');
			$company_yearly_company_target = Session::get('CompanyDetails.yearly_company_target');
			$company_yearly_store_target = Session::get('CompanyDetails.yearly_store_target');
			$company_monthly_company_target = Session::get('CompanyDetails.monthly_company_target');
			$company_monthly_store_target = Session::get('CompanyDetails.monthly_store_target');
		    $current_company_target = $company_last_year_target+($company_last_year_target*($company_percentage_growth/100));
			$response ='';
			$location_id = $inputData['location_id'];
			$Location = Location::where('locations.location_id','=',$location_id)->where('locations.status','!=',4)->first();
			$staff_ids = $Location['staff_ids'];
			$current_back = $inputData['current_back'];
			$type_set = $inputData['type_set'];
			$days = ($current_back*7);
			$start_date = date('Y-m-d',strtotime($days.' days'));
			$end_date = date('Y-m-d',strtotime('+6 days',strtotime($start_date)));
			$total_shifts  = Shift::where('location_id','=',$location_id)->where('shifts.status','!=',3)->where('shift_date','>=',$start_date)->where('shift_date','<=',$end_date)->get();
			$filled_shifts = Shift::where('location_id','=',$location_id)->where('shifts.assigned_to','!=',0)->where('shifts.status','!=',3)->where('shifts.shift_date','>=',$start_date)->where('shifts.shift_date','<=',$end_date)->leftJoin('wages','wages.wage_user_id', '=', 'shifts.assigned_to')->select('shifts.*','wages.*')->get();
			$total_shifts  = count($total_shifts->toArray());
			$countfilled_shifts = count($filled_shifts->toArray());
			$total_hrs = 0;
			foreach($filled_shifts->toArray() as $fillShift){
				if(strtotime($fillShift['shift_start_time'])!==strtotime($fillShift['shift_end_time'])){
					$diff = strtotime($fillShift['shift_start_time']) - strtotime($fillShift['shift_end_time']);
					$diff = abs($diff)- $fillShift['meal_break']*60;
					$diff_in_hrs = $diff/3600;
					$total_hrs = $total_hrs + abs($diff_in_hrs);
				}
			}
			$response['total_shifts'] = $total_shifts;
			$total_hrs = number_format(abs($total_hrs),2);
			if($inputData['type_set']=='staff'){
				$UserTargetList = array();
				$position_id = $Location['position_ids'];
				$position_id = explode(',',$position_id);
				$PositionLists = Position::whereIn('id',$position_id)->select(DB::raw("replace(group_concat(staff_ids),',,',',') as staff_ids"))->get();
				$PositionLists = $PositionLists->toArray();
				
				if(!empty($PositionLists[0]['staff_ids'])){
					$PositionLists = explode(',',$PositionLists[0]['staff_ids']);
					$position_staff_ids =  array_filter($PositionLists, function($value) { return $value !== ''; });
				}
				
				$staff_ids =  explode(',',$staff_ids);
				$staff_ids = array_unique(array_merge($staff_ids, $position_staff_ids));
				$UserLists = User::where('users.status','!=',4)->where('company_id','=',$company_id)->whereIn('id',$staff_ids)->get();
				$UsersIds  = User::where('users.status','!=',4)->where('company_id','=',$company_id)->whereIn('id',$staff_ids)->select(DB::raw("replace(group_concat(id),',,',',') AS ids"))->get();
				$j=0;
				
				foreach($UserLists as $UserList){
					$user_id = $UserList['id'];
					$shifts = Shift::where('assigned_to','=',$user_id)->where('location_id','=',$location_id)->where('shifts.status','=',1)->where('shift_date','>=',$start_date)->where('shift_date','<=',$end_date)->leftJoin('users','users.id', '=', 'shifts.id')->leftJoin('positions','positions.id', '=', 'shifts.position_id')->leftJoin('wages','wages.wage_user_id', '=', 'shifts.assigned_to')->select('positions.position_name','users.firstname','users.lastname','shifts.*','wages.wage_id','wages.wage_user_id','wages.standard_rate','wages.saturday_rate','wages.sunday_rate','wages.holiday_rate','wages.overtime_rate','wages.yearly_rate')->get();
					$shifts = $shifts->toArray();
					$user_total_hrs = 0;
					foreach($shifts as $fillShift ){
						if(strtotime($fillShift['shift_start_time'])!==strtotime($fillShift['shift_end_time'])){
							$diff = strtotime($fillShift['shift_start_time']) - strtotime($fillShift['shift_end_time']);
							$diff = abs($diff)- $fillShift['meal_break']*60;
							$diff_in_hrs = $diff/3600;
							$user_total_hrs = $user_total_hrs + abs($diff_in_hrs);
						}
					}
					if($company_yearly_company_target==1){
						$UserTargetList[$j]['user_id'] = $user_id;
						$UserTargetList[$j]['name'] = $UserList['firstname'].' '.$UserList['lastname'];
						$UserTargetList[$j]['user_total_hrs'] = $user_total_hrs;
						$UserTargetList[$j]['user_total_hrs_percentage'] = number_format((($total_hrs>0)?(($user_total_hrs/$total_hrs)*100):0),2);
						if($total_hrs>0){
							$UserTargetList[$j]['user_week_target'] = number_format((($user_total_hrs/$total_hrs)*($current_company_target/52)),2);
						}else{
							$UserTargetList[$j]['user_week_target'] = 0;
						}
					}else if($company_yearly_store_target==1){
						$store_last_year_target = Session::get('CompanyDetails.store_last_year_target');
		    			$store_percentage_growth= Session::get('CompanyDetails.store_percentage_growth');
						$current_store_target = $store_last_year_target+($store_last_year_target*($store_percentage_growth/100));
						$UserTargetList[$j]['user_id'] = $user_id;
						$UserTargetList[$j]['name'] = $UserList['firstname'].' '.$UserList['lastname'];
						$UserTargetList[$j]['user_total_hrs'] = $user_total_hrs;
						$UserTargetList[$j]['user_total_hrs_percentage'] = number_format((($total_hrs>0)?(($user_total_hrs/$total_hrs)*100):0),2);
						if($total_hrs>0){
							$UserTargetList[$j]['user_week_target'] = number_format((($user_total_hrs/$total_hrs)*($current_store_target/52)),2);
						}else{
							$UserTargetList[$j]['user_week_target'] = 0;
						}
					}else if($company_monthly_company_target==1){
						$current_month = date('n');
						$company_last_month_target = Session::get('CompanyDetails.last_month_target_'.$current_month);
						$company_last_month_percentage_growth = Session::get('CompanyDetails.last_month_percentage_growth_'.$current_month);
						$Location = Location::where('locations.location_id','=',$location_id)->where('locations.status','!=',4)->first();
						$location_monthly_store_target = $Location['location_monthly_store_target_'.$current_month];
						$company_current_store_target = $company_last_month_target+($company_last_month_target*($company_last_month_percentage_growth/100));
						$company_current_store_target = $company_current_store_target+($company_current_store_target*($location_monthly_store_target/100));
						$UserTargetList[$j]['user_id'] = $user_id;
						$UserTargetList[$j]['name'] = $UserList['firstname'].' '.$UserList['lastname'];
						$UserTargetList[$j]['user_total_hrs'] = $user_total_hrs;
						$UserTargetList[$j]['user_total_hrs_percentage'] = number_format((($total_hrs>0)?(($user_total_hrs/$total_hrs)*100):0),2);
						if($total_hrs>0){
							$week = date('j')/7;
							$UserTargetList[$j]['user_week_target'] = number_format((($user_total_hrs/$total_hrs)*($company_current_store_target/$week)),2);
						}else{
							$UserTargetList[$j]['user_week_target'] = 0;
						}
					}else if($company_monthly_store_target==1){
						$current_month = date('n');
						$company_last_month_store_target = Session::get('CompanyDetails.last_month_store_target_'.$current_month);
						$company_last_month_store_percentage_growth = Session::get('CompanyDetails.last_month_store_percentage_growth_'.$current_month);
						$company_current_store_target = $company_last_month_store_target+($company_last_month_store_target*($company_last_month_store_percentage_growth/100));
						$UserTargetList[$j]['user_id'] = $user_id;
						$UserTargetList[$j]['name'] = $UserList['firstname'].' '.$UserList['lastname'];
						$UserTargetList[$j]['user_total_hrs'] = $user_total_hrs;
						$UserTargetList[$j]['user_total_hrs_percentage'] = number_format((($total_hrs>0)?(($user_total_hrs/$total_hrs)*100):0),2);
						if($total_hrs>0){
							$week = date('j')/7;
							$UserTargetList[$j]['user_week_target'] = number_format((($user_total_hrs/$total_hrs)*($company_current_store_target/$week)),2);
						}else{
							$UserTargetList[$j]['user_week_target'] = 0;
						}
					}
					$j++;
				}
			}
			return view('schedule/ajax/listWeeklyTarget')->with('UserTargetList',$UserTargetList); die;
		}
	}
	public function CopyWeekOption(){
		$response = array();
		$inputData =Input::all(); 
		if(!empty($inputData)){
			$company_id = Session::get('CompanyDetails.id');
			$response ='';
			$shift_currentweekStart = $inputData['shift_currentweekStart'];
			$response['copy_shift_from'] = $shift_currentweekStart;
			$start_date = date('M d',strtotime($shift_currentweekStart));
			$end_date = date('M d',strtotime('+6 days',strtotime($start_date)));
			
			$response['current_copy_weeks'] = $start_date.' - '.$end_date;
			$start_date = date('M d',strtotime('+7 days',strtotime($shift_currentweekStart)));
			$end_date = date('M d',strtotime('+6 days',strtotime($start_date)));
			$response['copy_weeks'] = '';
			for($i=0;$i<=6;$i++){
				$response['copy_weeks'].='<div class="col-md-6">
									<div class="emp-name copy_week_start_list ">
									  <label>
										<input name="copy_week_start[]" type="checkbox" value="'.$start_date.'" />
										'.$start_date.' - '.$end_date.'</label>
									</div>
								  </div>';
				$start_date = date('M d',strtotime('+1 days',strtotime($end_date)));
				$end_date = date('M d',strtotime('+6 days',strtotime($start_date)));
			}
			return $response;die;
		}
	}
	public function PublishOption(){
		$response = array();
		$inputData =Input::all(); 
		if(!empty($inputData)){
			$company_id = Session::get('CompanyDetails.id');
			$response ='';
			$location_id = $inputData['location_id'];
			$Location = Location::where('locations.location_id','=',$location_id)->where('locations.status','!=',4)->first();
			if(!empty($Location)){
			$Location = $Location->toArray();
			$position_staff_ids = array();
			$position_id = $Location['position_ids'];
			$staff_ids = $Location['staff_ids'];
			$position_id = explode(',',$position_id);
			$PositionLists = Position::whereIn('id',$position_id)->select(DB::raw('group_concat(staff_ids) as staff_ids'))->get();
			$PositionLists = $PositionLists->toArray();
			if(!empty($PositionLists[0]['staff_ids'])){
				$PositionLists = explode(',',$PositionLists[0]['staff_ids']);
				$position_staff_ids =  array_filter($PositionLists, function($value) { return $value !== ''; });
			}
			$staff_ids =  explode(',',$staff_ids);
			$staff_ids = array_unique(array_merge($staff_ids, $position_staff_ids));
			$PositionLists = Position::whereIn('id',$position_id)->get();
			$response['position']='';
			$response['staff']='';
			foreach($PositionLists as $Position):
				$Position_id = $Position['id'];
				$position_name = $Position['position_name'];
				$response['position'].='<div class="col-md-6">
									<div class="emp-name add_position_name_list ">
									  <label>
										<input name="publish_position_ids[]" type="checkbox" value="'.$Position_id.'" />
										'.$position_name.'</label>
									</div>
								  </div>';
			endforeach;
			$Users = User::where('company_id','=',$company_id)->whereIn('id',$staff_ids)->select('users.id','users.firstname','users.lastname')->get();
			$Users = $Users->toArray();
			
			foreach($Users as $User):
				$staff_id = $User['id'];
				$staff_name =  $User['firstname'].' '.$User['lastname'];
				$response['staff'].='<div class="col-md-6">
									 <div class="emp-name add_staff_name_list">
										 <label> <input name="publish_staff_ids[]" type="checkbox" value="'.$staff_id.'" />'.$staff_name.'</label>
									 </div>
								 </div>';
			endforeach;
			}
			return $response;die;
		}
	}
	
	public function salesPercentage(){
		$response = array();
		$inputData =Input::all(); 
		$company_id = Session::get('CompanyDetails.id');
		if(!empty($inputData)){
			$current_back = $inputData['current_back'];
			$location_id = $inputData['location_id'];
			$days = ($current_back*7)+$inputData['add_current_days'];
			$shift_date = date('Y-m-d',strtotime($days.' days'));
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
			$response['percentage_cost'] = ($inputData['sales_price']!=0)?(number_format((abs($total_cost)+ @@$inputData['labour_variation'])/$inputData['sales_price'],2)*100):0;
			$result = SalesPerDay::where('company_id','=',$company_id)->where('location_id','=',$location_id)->where('sales_shift_date','=',$shift_date)->get();
			$result = $result->toArray();
			
			if(!empty($result)){
				$editData['sales_percentage'] =  $response['percentage_cost'];
				$editData['sales_price'] =  $inputData['sales_price'];
				$editData['sales_per_hour'] =  ($total_hrs!=0)?(number_format(($inputData['sales_price']/$total_hrs),2)):0;
				$editData['labour_variation'] =  @@$inputData['labour_variation'];
				$resultset = SalesPerDay::where('company_id','=',$company_id)->where('location_id','=',$location_id)->where('sales_shift_date','=',$shift_date)->update($editData);
			
			}else{
				$addData = array();
				$addData['sales_percentage'] =  $response['percentage_cost'];
				$addData['sales_price'] =  $inputData['sales_price'];
				$addData['company_id'] =  $company_id;
				$addData['location_id'] =  $location_id;
				$addData['sales_per_hour'] =  ($total_hrs!=0)?(number_format(($inputData['sales_price']/$total_hrs),2)):0;
				$addData['labour_variation'] =  (@$inputData['labour_variation'])?@$inputData['labour_variation']:0;
				$addData['sales_shift_date'] =  $shift_date;
				$resultset = SalesPerDay::create($addData);
			}
			$response['sales_per_hour'] =  ($total_hrs!=0)?(number_format(($inputData['sales_price']/$total_hrs),2)):0;
			return Response::json($response);die;
		}
	}
	
	
	public function CopyWeekShifts(){
		$response = array();
		$inputData =Input::all(); 
		$company_id = Session::get('CompanyDetails.id');
		$flag = 0;
		if(!empty($inputData)){
			$copy_week_start = $inputData['copy_week_start'];
			$location_id = $inputData['location_id'];
			$copy_shift = $inputData['copy_shift_from'];
			foreach($copy_week_start as $copy_week){
				$start_date = date('Y-m-d',strtotime('-1 days',strtotime($copy_week)));
				$copy_shift_from = date('Y-m-d',strtotime('-1 days',strtotime($copy_shift)));
					for($i=1;$i<=6;$i++){
						//$copy_shift_from = date('Y-m-d',strtotime('-1 days',strtotime($copy_shift_from)));
						$current_day = date('D',strtotime('+1 days',strtotime($start_date)));
						$start_date = date('Y-m-d',strtotime('+1 days',strtotime($start_date)));//die;
						$week_day = date('D',strtotime($start_date));
						$copy_shift_from = date('Y-m-d',strtotime('+1 days',strtotime($copy_shift_from)));//die;
						if($current_day==$week_day){
							$ShiftList = Shift::where('shift_date','=',$copy_shift_from)->where('location_id','=',$location_id)->where('status','!=',3)->get();
							if(!empty(@$ShiftList->toArray())){
							$ShiftList = $ShiftList->toArray();
							foreach($ShiftList as $current_shifts){
								$addData = array();
								$addData['position_id'] = $current_shifts['position_id'];
								$addData['location_id'] = $current_shifts['location_id'];
								$addData['assigned_to'] = $current_shifts['assigned_to'];
								$assigned_to = $current_shifts['assigned_to'];
								$addData['assigned_by'] = Session::get('Users.id');
								$addData['company_id'] = $company_id;
								$shift_start_time= $start_date.' '.date('H:i:s',strtotime($current_shifts['shift_start_time']));
								$addData['shift_start_time'] = date('Y-m-d H:i:s',strtotime($shift_start_time));
								$shift_start_time= date('Y-m-d H:i:s',strtotime($shift_start_time));
								$shift_end_time=  $start_date.' '.date('H:i:s',strtotime($current_shifts['shift_end_time']));
								$addData['shift_end_time'] = date('Y-m-d H:i:s',strtotime($shift_end_time));
								$shift_end_time = date('Y-m-d H:i:s',strtotime($shift_end_time));
								$addData['meal_break'] = $current_shifts['meal_break'];
								$addData['end_option'] = $current_shifts['end_option'];
								$addData['notes'] = $current_shifts['notes'];
								$addData['visible'] = 0;
								$addData['shift_date'] = $start_date;
								$assigned_to = $addData['assigned_to'];
								$shift_date= date('Y-m-d',strtotime($start_date));;
								if(Shift::create($addData)){
									// For Conflict Shift : Starts
									//DB::enableQueryLog();
									$result = DB::select(DB::raw('select group_concat(id) as id_list from `shifts` where `assigned_to` = "'.$assigned_to.'" and `shifts`.`status` != 3 and `shifts`.`shift_date` = "'.$start_date.'" and (   (`shift_start_time` < "'.$shift_start_time.'" AND  `shift_end_time` > "'.$shift_start_time.'") 
  OR 
  (`shift_start_time` < "'.$shift_end_time.'" AND `shift_end_time` >="'.$shift_end_time.'") 
   OR 
  (`shift_start_time` = "'.$shift_start_time.'" AND `shift_end_time` ="'.$shift_end_time.'") 
)'));
						
//	dd(DB::getQueryLog());
									if(!empty($result))
									{
										$count_conflict = $result;
										//print_r($count_conflict[0]->id_list);echo "=====";
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
									}
									// For Conflict Shift : Ends 
									// For Sales Calculation : Start 
									$location_id =  $current_shifts['location_id'];
									$Sales = SalesPerDay::where('company_id','=',$company_id)->where('location_id','=',$location_id)->where('sales_shift_date','=',$shift_date)->first();
									if(!empty($Sales)){
									$result = $Sales->toArray();
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
								}
							}
							$flag = 1;
						 }else{
							 $flag=2;
						 }
						}
					}
			}
			if($flag==1){
				$response =array('Status' =>'success','message' => 'Week Shift copied successfully.');
			}elseif($flag==2){
				$response =array('Status' =>'success','message' => 'There are no shifts to be copied.');
			}else{
				$response =array('Status' => 'danger','message' => 'Something went wrong.Please try again later.');
			}
			return Response::json($response);die;
		}
	}
	public function CopyShifts(){
		$response = array();
		$inputData =Input::all(); 
		$company_id = Session::get('CompanyDetails.id');
		if(!empty($inputData)){
			$copy_days = $inputData['copy_days'];
			$shift_id = $inputData['copy_shift_id'];
			$current_shifts = Shift::where('id','=',$shift_id)->first();
			$addData = array();
			$inputData['copy_notes'] = empty(@$inputData['copy_notes'])?0:1;
			$flag=1;
			$current_shifts = $current_shifts->toArray();
			
			foreach($copy_days as $day){
				$day = date('Y-m-d',strtotime($day));
				$shift_start_time = $day.' '.date('H:i A',strtotime($current_shifts['shift_start_time']));
				$shift_end_time = $day.' '.date('H:i A',strtotime($current_shifts['shift_end_time']));
				$shift_start_time =  date('Y-m-d H:i:s',strtotime($shift_start_time));
				$shift_end_time = date('Y-m-d H:i:s',strtotime($shift_end_time));
				$addData = array();
				$addData['position_id'] = $current_shifts['position_id'];
				$addData['location_id'] = $current_shifts['location_id'];
				$addData['assigned_to'] = $current_shifts['assigned_to'];
				$addData['assigned_by'] = Session::get('Users.id');
				$addData['company_id'] = $company_id;
				$addData['shift_start_time'] = date('Y-m-d H:i:s',strtotime($shift_start_time));
				$addData['shift_end_time'] = date('Y-m-d H:i:s',strtotime($shift_end_time));
				$addData['meal_break'] = $current_shifts['meal_break'];
				$addData['end_option'] = $current_shifts['end_option'];
				if($inputData['copy_notes']==1)
				{	
					$addData['notes'] = $current_shifts['notes'];
					$addData['visible'] = $current_shifts['visible'];
				}
				$addData['end_option'] = $current_shifts['end_option'];
				$addData['shift_date'] = $day;
				$addData['status'] = $current_shifts['end_option'];
				$assigned_to = $addData['assigned_to'];
				if(Shift::create($addData)){
					// For Conflict Shift : Starts
					//DB::enableQueryLog();
					$result = DB::select(DB::raw('select group_concat(id) as id_list from `shifts` where `assigned_to` = "'.$assigned_to.'" and `shifts`.`status` != 3 and `shifts`.`shift_date` = "'.$day.'" and (   (`shift_start_time` < "'.$shift_start_time.'" AND  `shift_end_time` > "'.$shift_start_time.'") 
  OR 
  (`shift_start_time` < "'.$shift_end_time.'" AND `shift_end_time` >="'.$shift_end_time.'") 
   OR 
  (`shift_start_time` = "'.$shift_start_time.'" AND `shift_end_time` ="'.$shift_end_time.'") 
)'));
						
	//	dd(DB::getQueryLog());
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
					// For Conflict Shift : Ends 
					// For Sales Calculation : Start 
					$location_id =  $current_shifts['location_id'];
					$shift_date = $day;
					$Sales = SalesPerDay::where('company_id','=',$company_id)->where('location_id','=',$location_id)->where('sales_shift_date','=',$shift_date)->first();
					if(!empty($Sales)){
					$result = $Sales->toArray();
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
					$flag = 1;
				}
				
			}
			if($flag==1){
				$response =array( 'Status' => 'success', 'message' => 'Shift  copied successfully.');
			}else{
				$response =array( 'Status' => 'danger', 'message' => 'Something went wrong.Please try again later.');
			}
			return Response::json($response);die;
		}
	}
	public function WeeklyReport(){
		$response = array();
		$inputData =Input::all(); 
		$company_id = Session::get('CompanyDetails.id');
		if(!empty($inputData)){
			$current_back = $inputData['current_back'];
			$location_id = $inputData['location_id'];
			$type_set = $inputData['type_set'];
			$days = ($current_back*7);
			$start_date = date('Y-m-d',strtotime($days.' days'));
			$end_date = date('Y-m-d',strtotime('+6 days',strtotime($start_date)));
			$total_shifts = Shift::where('location_id','=',$location_id)->where('shifts.status','!=',3)->where('shift_date','>=',$start_date)->where('shift_date','<=',$end_date)->get();
			$filled_shifts = Shift::where('location_id','=',$location_id)->where('shifts.assigned_to','!=',0)->where('shifts.status','!=',3)->where('shifts.shift_date','>=',$start_date)->where('shifts.shift_date','<=',$end_date)->leftJoin('wages','wages.wage_user_id', '=', 'shifts.assigned_to')->select('shifts.*','wages.*')->get();
			$total_shifts = count($total_shifts->toArray());
			$countfilled_shifts = count($filled_shifts->toArray());
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
						 $total_cost =  $total_cost+ ($diff_in_hrs*$fillShift['sunday_rate']);
					}else{
						$total_cost =  $total_cost+ ($diff_in_hrs*$fillShift['standard_rate']);
					}
				}
			}
			$response['total_shifts'] = $total_shifts;
			$response['total_hrs'] = number_format(abs($total_hrs),2);
			$response['total_cost'] = number_format(abs($total_cost),2);
			$response['filled_shifts'] = count($filled_shifts->toArray());
			return Response::json($response);die;
		}
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
	public function StaffEditdetails(){
		$response = array();
		$inputData =Input::all(); 
		if(!empty($inputData)){
			$shift_id = $inputData['shift_id'];
			$shifts = Shift::where('shifts.id','=',$shift_id)->first();
			$response = $shifts->toArray();
			$response['shift_start_time'] = date('h:i A',strtotime($response['shift_start_time']));
			$response['shift_end_time'] = date('h:i A',strtotime($response['shift_end_time']));
			return Response::json($response);die;
		}
	}
	public function StaffOption(){
		$response = array();
		$inputData =Input::all(); 
		if(!empty($inputData)){
			$company_id = Session::get('CompanyDetails.id');
			$response ='';
			if(@$inputData['position_id']){
			$position_id = $inputData['position_id'];
			$PositionLists = Position::where('id','=',$position_id)->firstOrFail();
			$position_staff_ids = $PositionLists['staff_ids'];
			$position_staff_ids = explode(',',$position_staff_ids);
			$Users = User::where('company_id','=',$company_id)->whereIn('id',$position_staff_ids)->select('users.id','users.firstname','users.lastname')->get();
			$Users = $Users->toArray();
			
			foreach($Users as $User):
				$response.='<option value="'.$User['id'].'" >'.$User['firstname'].' '.$User['lastname'].'</option>';
			endforeach;
			}else{
				$user_id = $inputData['user_id'];
				$UserLists = User::where('users.status','!=',4)->where('users.company_id','=',$company_id)->where('users.id','=',$user_id)->firstOrFail();
				$positionIds = explode(',',$UserLists['position_ids']);
				$positionList = Position::where('company_id','=',$company_id)->whereIn('id',$positionIds)->select('positions.id','positions.position_name')->get();
				$positionList = $positionList->toArray();
				foreach($positionList as $position):
					$response.='<option value="'.$position['id'].'" >'.$position['position_name'].'</option>';
				endforeach;
			}
			return $response;die;
		}
	}
	public function selectWeek(){
		$response = array();
		$inputData =Input::all(); 
		if(!empty($inputData)){
			$unassignedshifts = array();
			$location_id = $inputData['location_id'];
			$company_id = Session::get('CompanyDetails.id');
			$Location = Location::where('locations.location_id','=',$location_id)->where('locations.status','!=',4)->first();
			$Locationlist = Location::where('locations.location_company_id','=',$company_id)->where('locations.status','!=',4)->get();
			$staff_ids = $Location['staff_ids'];
			$position_ids = $Location['position_ids'];
			$current_back = $inputData['current_back'];
			$unassignedshifts =  array();
			$days = ($current_back*7);
			$start_date = date('M d',strtotime('+'.$days.' days'));
			// For Notes 
			$start_date = date('Y-m-d',strtotime('+'.$days.' days'));
			$end_date = date('Y-m-d',strtotime('+6 days',strtotime($start_date)));
			$notes = Note::where('company_id','=',$company_id)->where('location_id','=',$location_id)->where('status','=',1)->where('note_date','>=',$start_date)->where('note_date','<=',$end_date)->get();
			$notes = $notes->toArray();
			// For Notes End
			// For Sales 
			$SalesPerDays = SalesPerDay::where('company_id','=',$company_id)->where('location_id','=',$location_id)->where('sales_shift_date','>=',$start_date)->where('sales_shift_date','<=',$end_date)->get();
			// For Sales End 
			$UserLists = array();
			$PositionLists = array();
			$position_ids = explode(',',$position_ids);
			$PositionLists = Position::where('positions.company_id','=',$company_id)->whereIn('positions.id',$position_ids)->get();
			$PositionLists =$PositionLists->toArray();
			$i=0;
			$unpublished_count = 0;
			foreach($PositionLists as $position){
				$position_id = $position['id'];
				$shifts = Shift::where('position_id','=',$position_id)->where('location_id','=',$location_id)->where('shifts.status','!=',3)->where('shift_date','>=',$start_date)->where('shift_date','<=',$end_date)->leftJoin('users','users.id', '=', 'shifts.assigned_to')->leftJoin('positions','positions.id', '=', 'shifts.position_id')->leftJoin('wages','wages.wage_user_id', '=', 'shifts.assigned_to')->select('positions.position_name','users.firstname','users.lastname','shifts.*','wages.wage_id','wages.wage_user_id','wages.standard_rate','wages.saturday_rate','wages.sunday_rate','wages.holiday_rate','wages.overtime_rate','wages.yearly_rate')->get();
				$PositionLists[$i]['Shift'] = $shifts->toArray();
				$shiftLList= $shifts->toArray();
				$unpublishedshifts = Shift::where('position_id','=',$position_id)->where('location_id','=',$location_id)->where('shift_date','>=',$start_date)->where('shift_date','<=',$end_date)->where('shifts.status','!=',3)->where('shifts.status','!=',1)->leftJoin('users','users.id', '=', 'shifts.assigned_to')->leftJoin('positions','positions.id', '=', 'shifts.position_id')->select('positions.position_name','users.firstname','users.lastname','shifts.*')->get();
				$unpublished_count =$unpublished_count + count($unpublishedshifts->toArray());
				$position_staff_ids = 	$position['staff_ids'];
				$position_staff_ids = explode(',',$position_staff_ids);
				$User = User::where('company_id','=',$company_id)->whereIn('id',$position_staff_ids)->select('users.id','users.firstname','users.lastname')->get();
				$PositionLists[$i]['User'] = $User->toArray();
				$i++;
			}
			if($inputData['type_set']=='staff'){
				$position_id = $Location['position_ids'];
				$position_id = explode(',',$position_id);
				$PositionLists = Position::whereIn('id',$position_id)->select(DB::raw("replace(group_concat(staff_ids),',,',',') as staff_ids"))->get();
				$PositionLists = $PositionLists->toArray();
				if(!empty($PositionLists[0]['staff_ids'])){
					$PositionLists = explode(',',$PositionLists[0]['staff_ids']);
					$position_staff_ids =  array_filter($PositionLists, function($value) { return $value !== ''; });
				}
				$staff_ids =  explode(',',$staff_ids);
				$staff_ids = array_unique(array_merge($staff_ids, $position_staff_ids));
				$UserLists = User::where('users.status','!=',4)->where('company_id','=',$company_id)->whereIn('id',$staff_ids)->get();
				$UsersIds  = User::where('users.status','!=',4)->where('company_id','=',$company_id)->whereIn('id',$staff_ids)->select(DB::raw("replace(group_concat(id),',,',',') AS ids"))->get();
				$j=0;
				foreach($UserLists as $UserList){
					$user_id = $UserList['id'];
					$shifts = Shift::where('assigned_to','=',$user_id)->where('location_id','=',$location_id)->where('shifts.status','!=',3)->where('shift_date','>=',$start_date)->where('shift_date','<=',$end_date)->leftJoin('users','users.id', '=', 'shifts.id')->leftJoin('positions','positions.id', '=', 'shifts.position_id')->leftJoin('wages','wages.wage_user_id', '=', 'shifts.assigned_to')->select('positions.position_name','users.firstname','users.lastname','shifts.*','wages.wage_id','wages.wage_user_id','wages.standard_rate','wages.saturday_rate','wages.sunday_rate','wages.holiday_rate','wages.overtime_rate','wages.yearly_rate')->get();
					$unpublishedshifts = Shift::where('assigned_to','=',$user_id)->where('location_id','=',$location_id)->where('shift_date','>=',$start_date)->where('shift_date','<=',$end_date)->where('shifts.status','!=',3)->where('shifts.status','!=',1)->get();
					$unpublished_count = $unpublished_count + count($unpublishedshifts->toArray());
					$UserLists[$j]['Shift'] = $shifts->toArray();
					$j++;
				}
				$unassignedshiftsLIST = Shift::where('assigned_to','=',0)->where('location_id','=',$location_id)->where('shifts.status','!=',3)->where('shift_date','>=',$start_date)->where('shift_date','<=',$end_date)->leftJoin('users','users.id', '=', 'shifts.id')->leftJoin('positions','positions.id', '=', 'shifts.position_id')->leftJoin('wages','wages.wage_user_id', '=', 'shifts.assigned_to')->select('positions.position_name','users.firstname','users.lastname','shifts.*','wages.wage_id','wages.wage_user_id','wages.standard_rate','wages.saturday_rate','wages.sunday_rate','wages.holiday_rate','wages.overtime_rate','wages.yearly_rate')->get();
				$unassignedshifts = $unassignedshiftsLIST->toArray();
			}
			$holidayList = HolidayLists::where('company_id','=',$company_id)->where('status','!=',4)->select('holiday_date')->get();
			$holidayList = $holidayList->toArray();
			$holiday_list = array_column($holidayList,'holiday_date');
			array_walk($holiday_list, function(&$items){
				$items = strtotime($items);
			});
			return view('schedule/ajax/tableView')->with('unassignedshifts',$unassignedshifts)->with('SalesPerDays',$SalesPerDays->toArray())->with('holiday_list',$holiday_list)->with('Locationlist',$Locationlist)->with('notes',$notes)->with('unpublished_count',$unpublished_count)->with('Location',$Location)->with('current_back',$inputData['current_back'])->with('UserLists',$UserLists)->with('start_date',$start_date)->with('PositionLists',$PositionLists);
		}
	}
}
