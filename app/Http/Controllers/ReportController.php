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
use App\Shift;
use App\Location;
use App\Wages;
use App\Note;
use Dompdf\Dompdf;
use App\StaffDateReminders;
use DB;
use PDF;
class ReportController extends Controller {
	
	public function reports(){
		$var = Session::get('Users.type');//exit;
		if(Session::has('Users') == false){
			 return redirect('/Login');
		}else if($var==3){
			return redirect('/Employee');
		}	
		$company_id = Session::get('CompanyDetails.id');
		$Locationlist = Location::where('locations.location_company_id','=',$company_id)->where('locations.status','!=',4)->get();
		return view('reports/index')->with('Locationlist',$Locationlist->toArray());
	}
	public function getData(){
		$company_id = Session::get('CompanyDetails.id');
		$inputData = array();
		$inputData = Input::all(); 
		$Locationlist = Location::where('locations.location_company_id','=',$company_id)->where('locations.status','!=',4)->get();
		if(!empty($inputData)){
			//print_r($inputData); die;
			$userData = array(
			  'roster_by' => @$inputData['roster_by'],
			);
			$rules = array(
				'roster_by' => 'required',
			);
			$messages =array('roster_by.required'=>'Please select Roster by .');
			$validator = Validator::make($userData,$rules,$messages);
			if($validator->fails()){
				$errors = $validator->getMessageBag()->toArray();
				foreach($errors as $error){
					$erMsg = $error[0];
					break;
				}
				$response =array('Status' => 'danger','message' => $erMsg);
			}	
			else {
				$current_back = $inputData['currentback'];
				$days = ($current_back*7);
				$UserLists = array();
				$start_date = date('Y-m-d',strtotime('+'.$days.' days'));
				$end_date = date('Y-m-d',strtotime('+6 days',strtotime($start_date)));
				$PositionLists =array();
				$roster_by = $inputData['roster_by'];
				$location_id = $inputData['location_id'];
				$Location = Location::where('locations.location_id','=',$location_id)->where('locations.status','!=',4)->select('locations.*',DB::raw("replace(group_concat(staff_ids),',,',',') as staff_ids"))->first();
				$positions_ids = @$Location['position_ids'];
				$location_name = @$Location['location_name'];
				$PositionData =array();
				$notesData  = array();
				$UserData = array();
				$Location = Location::where('locations.location_id','=',$location_id)->where('locations.status','!=',4)->select(DB::raw("replace(group_concat(staff_ids),',,',',') as staff_ids"))->first();
				if($roster_by=='by_emp_multipleWeek'){ 
					$UserLists = User::where('users.status','!=',4)->where('company_id','=',$company_id)->get();
					$UsersIds  = User::where('users.status','!=',4)->where('company_id','=',$company_id)->select(DB::raw("replace(group_concat(id),',,',',') AS ids"))->get();
					$no_of_weeks = $inputData['no_of_weeks'];
					for($i=1;$i<=$no_of_weeks;$i++){
						$UserData[$i]['startWeek'] = $start_date;
						if(@$inputData['publish']==1){
							$j=0;
							foreach($UserLists as $UserList){
								$UserData[$i]['Users'][$j] = $UserList->toArray();
								$user_id = $UserList['id'];
								$shifts = Shift::where('assigned_to','=',$user_id)->where('shifts.status','=',1)->where('shifts.shift_date','>=',$start_date)->where('shift_date','<=',$end_date)->leftJoin('users','users.id', '=', 'shifts.id')->leftJoin('locations','locations.location_id', '=', 'shifts.location_id')->leftJoin('positions','positions.id', '=', 'shifts.position_id')->leftJoin('wages','wages.wage_user_id', '=', 'shifts.assigned_to')->select('positions.position_name','users.firstname','users.lastname','shifts.*','wages.wage_id','wages.wage_user_id','location.location_name','wages.standard_rate','wages.saturday_rate','wages.sunday_rate','wages.holiday_rate','wages.overtime_rate','wages.yearly_rate')->get();
								$UserData[$i]['Users'][$j]['Shift'] = @$shifts->toArray();
								$j++;
							}
						}else{
							$j=0;
							foreach($UserLists as $UserList){
								$UserData[$i]['Users'][$j] = $UserList->toArray();
								$user_id = $UserList['id'];
								$shifts = Shift::where('shifts.assigned_to','=',$user_id)->where('shifts.status','!=',3)->where('shifts.shift_date','>=',$start_date)->where('shifts.shift_date','<=',$end_date)->leftJoin('users','users.id', '=', 'shifts.id')->leftJoin('locations','locations.location_id', '=', 'shifts.location_id')->leftJoin('positions','positions.id', '=', 'shifts.position_id')->leftJoin('wages','wages.wage_user_id', '=', 'shifts.assigned_to')->select('*')->get();
								$UserData[$i]['Users'][$j]['Shift'] = @$shifts->toArray();
								$j++;
							}
						}
						$start_date = date('Y-m-d',strtotime('+7 days'));
						$end_date = date('Y-m-d',strtotime('+6 days',strtotime($start_date)));
					}
					$notesData  = array();
					if(@$inputData['notes']==1){
						$notesData = Note::where('company_id','=',$company_id)->where('location_id','=',$location_id)->where('note_date','>=',$start_date)->where('note_date','<=',$end_date)->where('status','=',1)->get();
					}	
				}elseif($roster_by=='by_emp_locations'){
					$UserLists = User::where('users.status','!=',4)->where('company_id','=',$company_id)->get();
					$UsersIds  = User::where('users.status','!=',4)->where('company_id','=',$company_id)->select(DB::raw("replace(group_concat(id),',,',',') AS ids"))->get();					
					if(@$inputData['publish']==1){
						$j=0;
						foreach($UserLists as $UserList){
							$user_id = $UserList['id'];
							$shifts = Shift::where('assigned_to','=',$user_id)->where('shifts.status','=',1)->where('shift_date','>=',$start_date)->where('shift_date','<=',$end_date)->leftJoin('users','users.id', '=', 'shifts.id')->leftJoin('locations','locations.location_id', '=', 'shifts.location_id')->leftJoin('positions','positions.id', '=', 'shifts.position_id')->leftJoin('wages','wages.wage_user_id', '=', 'shifts.assigned_to')->select('positions.position_name','users.firstname','users.lastname','shifts.*','wages.wage_id','wages.wage_user_id','location.location_name','wages.standard_rate','wages.saturday_rate','wages.sunday_rate','wages.holiday_rate','wages.overtime_rate','wages.yearly_rate')->get();
							$UserLists[$j]['Shift'] = @$shifts->toArray();
							$j++;
						}
					}else{
						$j=0;
						foreach($UserLists as $UserList){
							$user_id = $UserList['id'];
							$shifts = Shift::where('shifts.assigned_to','=',$user_id)->where('shifts.status','!=',3)->where('shifts.shift_date','>=',$start_date)->where('shifts.shift_date','<=',$end_date)->leftJoin('users','users.id', '=', 'shifts.id')->leftJoin('locations','locations.location_id', '=', 'shifts.location_id')->leftJoin('positions','positions.id', '=', 'shifts.position_id')->leftJoin('wages','wages.wage_user_id', '=', 'shifts.assigned_to')->select('*')->get();
							$UserLists[$j]['Shift'] = @$shifts->toArray();
							$j++;
						}
					}
					$notesData  = array();
					if(@$inputData['notes']==1){
						$notesData = Note::where('company_id','=',$company_id)->where('location_id','=',$location_id)->where('note_date','>=',$start_date)->where('note_date','<=',$end_date)->where('status','=',1)->get();
					}	
				}elseif($inputData['roster_by']=='by_emp_position'){
					$position_ids = explode(',',$positions_ids);
					$i=0;
					foreach($position_ids as $position_id){
						$PositionData[$i]['position_id'] = $position_id;
						$position_name = Position::where('id','=',$position_id)->select('position_name')->first();
						$PositionData[$i]['position_name'] = $position_name['position_name'];
						if(@$inputData['publish']==1){
							$shifts = Shift::where('position_id','=',$position_id)->where('shifts.status','=',1)->where('shift_date','>=',$start_date)->where('shift_date','<=',$end_date)->leftJoin('users','users.id', '=', 'shifts.assigned_to')->leftJoin('positions','positions.id', '=', 'shifts.position_id')->leftJoin('wages','wages.wage_user_id', '=', 'shifts.assigned_to')->select('positions.position_name','users.firstname','users.lastname','shifts.*','wages.wage_id','wages.wage_user_id','wages.standard_rate','wages.saturday_rate','wages.sunday_rate','wages.holiday_rate','wages.overtime_rate','wages.yearly_rate')->get();
						}else{
							$shifts = Shift::where('position_id','=',$position_id)->where('shifts.status','!=',3)->where('shift_date','>=',$start_date)->where('shift_date','<=',$end_date)->leftJoin('users','users.id', '=', 'shifts.assigned_to')->leftJoin('positions','positions.id', '=', 'shifts.position_id')->leftJoin('wages','wages.wage_user_id', '=', 'shifts.assigned_to')->select('positions.position_name','users.firstname','users.lastname','shifts.*','wages.wage_id','wages.wage_user_id','wages.standard_rate','wages.saturday_rate','wages.sunday_rate','wages.holiday_rate','wages.overtime_rate','wages.yearly_rate')->get();
						}
						$PositionData[$i]['Shift'] = $shifts->toArray();
						$i++;
					}
					if(@$inputData['notes']==1){
						$notesData = Note::where('company_id','=',$company_id)->where('location_id','=',$location_id)->where('note_date','>=',$start_date)->where('note_date','<=',$end_date)->where('status','=',1)->get();
					}	
				}else if($inputData['roster_by']=='by_employee'||$inputData['roster_by']=='by_emp_condensed'||$inputData['roster_by']=='by_emp_enhanced'||$roster_by=='by_emp_locations'){
					$notes = array();
					$position_staff_ids =  array();
					$Location = @$Location->toArray();
					$position_id = @$Location['position_ids'];
					$position_id = explode(',',$position_id);
					$staff_ids =@$Location['staff_ids'];
					$PositionLists = Position::whereIn('id',$position_id)->select(DB::raw("replace(group_concat(staff_ids),',,',',') as staff_ids"))->get();
					$PositionLists = $PositionLists->toArray();
					if(!empty($PositionLists[0]['staff_ids'])){
						$PositionLists = explode(',',$PositionLists[0]['staff_ids']);
						$position_staff_ids =  array_filter($PositionLists,function($value){ return $value !== ''; });
					}
					$staff_ids =  explode(',',$staff_ids);
					$staff_ids = array_unique(array_merge($staff_ids, $position_staff_ids));
					$UserLists = User::where('users.status','!=',4)->where('company_id','=',$company_id)->whereIn('id',$staff_ids)->get();
					$UsersIds  = User::where('users.status','!=',4)->where('company_id','=',$company_id)->whereIn('id',$staff_ids)->select(DB::raw("replace(group_concat(id),',,',',') AS ids"))->get();
					if(@$inputData['publish']==1){
						$j=0;
						foreach($UserLists as $UserList){
							$user_id = $UserList['id'];
							$shifts = Shift::where('assigned_to','=',$user_id)->where('location_id','=',$location_id)->where('shifts.status','=',1)->where('shift_date','>=',$start_date)->where('shift_date','<=',$end_date)->leftJoin('users','users.id', '=', 'shifts.id')->leftJoin('positions','positions.id', '=', 'shifts.position_id')->leftJoin('wages','wages.wage_user_id', '=', 'shifts.assigned_to')->select('positions.position_name','users.firstname','users.lastname','shifts.*','wages.wage_id','wages.wage_user_id','wages.standard_rate','wages.saturday_rate','wages.sunday_rate','wages.holiday_rate','wages.overtime_rate','wages.yearly_rate')->get();
							$UserLists[$j]['Shift'] = @$shifts->toArray();
							$j++;
						}
					}else{
						$j=0;
						foreach($UserLists as $UserList){
							$user_id = $UserList['id'];
							$shifts = Shift::where('assigned_to','=',$user_id)->where('location_id','=',$location_id)->where('shifts.status','!=',3)->where('shift_date','>=',$start_date)->where('shift_date','<=',$end_date)->leftJoin('users','users.id', '=', 'shifts.id')->leftJoin('positions','positions.id', '=', 'shifts.position_id')->leftJoin('wages','wages.wage_user_id', '=', 'shifts.assigned_to')->select('positions.position_name','users.firstname','users.lastname','shifts.*','wages.wage_id','wages.wage_user_id','wages.standard_rate','wages.saturday_rate','wages.sunday_rate','wages.holiday_rate','wages.overtime_rate','wages.yearly_rate')->get();
							$UserLists[$j]['Shift'] = @$shifts->toArray();
							$j++;
						}
					}
					$notesData  = array();
					if(@$inputData['notes']==1){
						$notesData = Note::where('company_id','=',$company_id)->where('location_id','=',$location_id)->where('note_date','>=',$start_date)->where('note_date','<=',$end_date)->where('status','=',1)->get();
					}	
				}
			}
			if($inputData['roster_by']=='by_emp_condensed'){
				$fontSize= "11px;";			
			}else{
				$fontSize= "";	
			}
			//echo "<pre>";
		//print_r($UserData);die;
			return view('reports/ajax/ajaxReport')->with('UserData',@$UserData)->with('location_name',@$location_name)->with('PositionData',@$PositionData)->with('roster_by',@$inputData['roster_by'])->with('UserLists',@$UserLists)->with('fontSize',@$fontSize)->with('notesData',@$notesData)->with('start_date',@$start_date)->with('end_date',@$end_date)->with('publish',@$inputData['publish'])->with('notes',@$inputData['notes']);	die;
		}
		return view('reports/index')->with('Locationlist',@$Locationlist->toArray());
	}
	public function printReport(){
		$dompdf = new Dompdf();
		$inputData =  Input::all(); 
		//print_r($inputData);die;
		$dompdf->loadHtml($inputData['data']);
		// (Optional) Setup the paper size and orientation
		$dompdf->setPaper('A4', 'landscape');

		// Render the HTML as PDF
		$dompdf->render();

		// Output the generated PDF to Browser
		return $dompdf->stream('reports.pdf');
		//return view('reports/index');
	}
	

}
