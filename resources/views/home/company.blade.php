@extends('layouts.home')
@section('title', 'Organization')
@section('content')
<!-- Begin page -->
<div id="wrapper">
@include('elements.TopNav')


@include('elements.sidebar')

<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="content-page">
	<!-- Start content -->
	<div class="content">
		<div class="container">
			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<div class="page-header-2">
						<h4 class="page-title">Company</h4>
						<ol class="breadcrumb">
							<li>
								<a href="#">Home</a>
							</li>
							
							<li class="active">
								Company
							</li>
						</ol>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<ul class="nav nav-tabs">
					  <li  class="active"> <a href="#home" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-cog" aria-hidden="true"></i></span> <span class="hidden-xs"><i class="fa fa-cog" aria-hidden="true"></i> Company Settings</span> </a> </li>
					  <li> <a href="#profile" data-toggle="tab" aria-expanded="true"> <span class="visible-xs"><i class="fa fa-hand-peace-o" aria-hidden="true"></i></span> <span class="hidden-xs"><i class="fa fa-hand-peace-o" aria-hidden="true"></i> Holiday</span> </a> </li>
					  <li class=""> <a href="#messages" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-calendar" aria-hidden="true"></i></span> <span class="hidden-xs"><i class="fa fa-calendar" aria-hidden="true"></i> Staff date/ Reminders</span> </a> </li>
					</ul>
					<div class="tab-content">
					   <div class="tab-pane active" id="home">
						<div class="row">
						{!! Form::open(array('url' => '#','id'=>'Companyform','class'=>'form-horizontal m-t-20')) !!}          
						  
						  <div class="card-box clearfix">
						     <div class="box-header with-border" id="Companysuccess"></div>
							 <div class="box-header with-border" id="Companyfailure"></div>
							<div class="col-md-7">                    
								<div class="form-group">
									<label class="col-md-3 control-label">Company Name</label>
									<div class="col-md-9">
									   {!! Form::text('company_name',@$CompanyDetails['company_name'],array('class'=>'form-control','placeholder'=>'Company Name')) !!}
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label" for="example-email">Country</label>
									<div class="col-md-9">
									{!! Form::select('country_id',$countries,@$CompanyDetails['country_id'],array('class'=>'form-control','placeholder'=>'Select Country'))!!}
									</div>
								</div>
								<div class="form-group" >
									<label class="col-md-3 control-label">Starting day of week</label>
									<div class="col-md-9">
									 <select class="form-control" name="starting_day">
									  <option value="">Select Week Start</option>
									  <option value="01" <?php echo (@$CompanyDetails['starting_day']=='01')?'selected':'';?>>Sunday</option>
									  <option value="02" <?php echo (@$CompanyDetails['starting_day']=='02')?'selected':'';?>>Monday</option>
									  <option value="03" <?php echo (@$CompanyDetails['starting_day']=='03')?'selected':'';?>>Tuesday</option>
									  <option value="04" <?php echo (@$CompanyDetails['starting_day']=='04')?'selected':'';?>>Wednesday</option>
									  <option value="05" <?php echo (@$CompanyDetails['starting_day']=='05')?'selected':'';?>>Thursday</option>
									  <option value="06" <?php echo (@$CompanyDetails['starting_day']=='06')?'selected':'';?>>Friday</option>
									  <option value="07" <?php echo (@$CompanyDetails['starting_day']=='07')?'selected':'';?>>Saturday</option>
									 </select>
									</div>
								</div>
									
							</div>
							<div class="card-gray">
								<div class="card-header">
								   <h4 class="d-inline">Staff Timesheet</h4>
								   <div class="pull-right">
										 <input type="checkbox" <?php echo (@$CompanyDetails['staff_timesheet']=='1')?'checked':'';?> name="staff_timesheet" data-toggle="toggle" data-on="on" data-off="off" data-onstyle="success" data-offstyle="danger"> 
								   </div>
								</div>
								<div class="card-body">
								   <h4>Allow staff-submitted timesheet entries</h4>
								</div>
							</div>
							<div class="card-gray">
								  <div class="card-header">
								  <h4 class="d-inline">Budgeting</h4>
								   <div class="pull-right">
										 <input type="checkbox" name="budget"  <?php echo (@$CompanyDetails['budget']=='1')?'checked':'';?> id="budget" data-toggle="toggle" data-on="on" data-off="off" data-onstyle="success" data-offstyle="danger"> 
								   </div>
								   </div>
								   
								   <div class="card-body" id="budget_div"  style="display:<?php echo (@$CompanyDetails['budget']=='1')?'block':'none';?>;">
									 <h4  class="m-b-20">Display Sales versus Labour budget calculations</h4>
									 <div class="col-md-6">
										<div class="row m-b-15">
										<div class="col-md-6 col-sm-6 col-xs-6">Labor Cost</div>
										 <div class="col-md-6 col-sm-6 col-xs-6">
										  <input type="checkbox" name="labor_cost" <?php echo (@$CompanyDetails['labor_cost']=='1')?'checked':'';?> data-toggle="toggle" data-on="on" data-off="off" data-onstyle="success" data-offstyle="danger"> </div>
									 </div>
									  <div class="row m-b-15">
										<div class="col-md-6 col-sm-6 col-xs-6">Labor Hours</div>
										 <div class="col-md-6 col-sm-6 col-xs-6">
										  <input type="checkbox" name="labor_hours" <?php echo (@$CompanyDetails['labor_hours']=='1')?'checked':'';?> data-toggle="toggle" data-on="on" data-off="off" data-onstyle="success" data-offstyle="danger"> </div>
									 </div>
									   <div class="row m-b-15">
										<div class="col-md-6 col-sm-6 col-xs-6">Labor Adjustment</div>
										 <div class="col-md-6 col-sm-6 col-xs-6">
										  <input type="checkbox" name="labor_adjustment" <?php echo (@$CompanyDetails['labor_adjustment']=='1')?'checked':'';?> data-toggle="toggle" data-on="on" data-off="off" data-onstyle="success" data-offstyle="danger"> </div>
									 </div>
										<div class="row m-b-15">
										<div class="col-md-6 col-sm-6 col-xs-6">Sales Per Hour</div>
										 <div class="col-md-6 col-sm-6 col-xs-6">
										  <input type="checkbox" name="sales_per_hour" <?php echo (@$CompanyDetails['sales_per_hour']=='1')?'checked':'';?> data-toggle="toggle" data-on="on" data-off="off" data-onstyle="success" data-offstyle="danger"> </div>
									 </div>
									 </div>
									 
								   </div>
								   
							</div>
							<div class="card-gray">
							  <div class="card-header">
							  <h4 class="d-inline">Notes</h4>
							   <div class="pull-right">
									 <input type="checkbox" name="notes"  <?php echo (@$CompanyDetails['notes']=='1')?'checked':'';?> data-toggle="toggle" data-on="on" data-off="off" data-onstyle="success" data-offstyle="danger"> 
							   </div>
							   </div>
							   <div class="card-body">
								 <h4>Allow notes to be attached to shifts or the calendar</h4>
							   </div>
							</div>
							<div class="card-gray">
							  <div class="card-header">
							  <h4 class="d-inline">Time Format( 12 hour )</h4>
							   <div class="pull-right">
									 <input type="checkbox" name="time_format"  <?php echo (@$CompanyDetails['time_format']=='12')?'checked':'';?> data-toggle="toggle" data-on="on" data-off="off" data-onstyle="success" data-offstyle="danger"> 
							   </div>
							  
							   </div>
							</div>
							<div class="form-group m-b-30" >
									<div class="col-md-9" style="z-index:-1;">
										<input  type="submit" value="Save" class="btn btn-primary">
									</div>
							</div>
						  </div>
						  {!! Form::close() !!}
						</div>
						
					  </div>
  
   <div class="tab-pane  clearfix" id="profile">
	<div class="row">  
	 <div class="col-md-12">
			
	 <div class="add-btn clearfix">
	 <button type="button" class="btn btn-purple waves-effect waves-light" id="addHoliday"> <i class="fa fa-plus"></i>  Add Holiday</button>
	 </div>
	</div>
	 
	 </div>
	 <div class="row">
     <div class="col-md-12">
	  <div class="card-box clearfix" id="addHolidayform" style="display:none;">
	   <div class="box-header with-border" id="Holidaysuccess"></div>
	   <div class="box-header with-border" id="Holidayfailure"></div>
	  <div class="row"> <div class="col-md-3"></div>
	  <div class="col-md-6" >
		 <div  id="AddHolidayForm">
		  {!! Form::open(array('url' => '#','id'=>'Holidayform','class'=>'form-horizontal m-t-20')) !!} 
		  
		  <div class="form-group">
				<label class="col-md-3 control-label" for="example-email">Country</label>
				<div class="col-md-9">
					{!! Form::select('country_id',$countries,null,array('class'=>'form-control','placeholder'=>'Select Country'))!!}
				</div>
		  </div>
		  <div class="form-group" >
	<label class="col-md-3 control-label">Year</label>
	<div class="col-md-9">
		<select name="year" class="form-control">
		<?php $year=date('Y');
		$count = $year+5;
		for($year;$year<=$count;$year++){ ?>
			 <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
		<?php } ?>
		</select>

	
	</div>
	</div>
		  <div class="form-group clearfix">
			 
			  <label  class="col-md-3 control-label">Description</label>
			   <div class="col-md-9">
			    {!! Form::text('holiday_name',null,array('class'=>'form-control','placeholder'=>'Description')) !!}
			 
			  </div>
		  </div>
		  
		  <div class="form-group clearfix">
		
			  <label class="col-md-3 control-label">Date</label>
			   <div class="col-md-9">
			<div class="input-group">
			    {!! Form::text('holiday_date',null,array('class'=>'form-control','placeholder'=>'mm/dd/YYYY','id'=>'datepicker-autoclose')) !!}
				<span class="input-group-addon bg-custom b-0 text-white"><i class="icon-calender"></i></span>
			</div>
			
			  </div>
		  </div>
		  
		  <div class="form-group">
			  <div class="col-md-offset-3 col-md-9">
			 <button type="submit" class="btn btn-success waves-effect waves-light">Save</button>
			 </div>
		  </div>
		  
		  {!! Form::close() !!} 
		  
		  </div>
		  </div>
	  </div></div>
	  <div class="card-box clearfix"  id="editHolidayForm" >
	  </div>
		 
		 <div class="card-box clearfix">
			{!! Form::open(array('url' => '#','id'=>'HolidaySearch','class'=>'form-horizontal m-t-20')) !!} 	
            <div class="row">
		    <div class="col-md-8">      
             	<div class="row">	
			<div class="col-md-6">
			
				<div class="form-group">
				<label class="col-md-3 control-label" for="example-email">Country</label>
				<div class="col-md-9">
					{!! Form::select('country_id',$countries,null,array('class'=>'form-control','placeholder'=>'Select Country'))!!}
				</div>
				</div>
			
			</div> 
            <div class="col-md-6">
		
			<div class="form-group" >
	<label class="col-md-3 control-label">Year</label>
	<div class="col-md-9">
		<select name="year" class="form-control">
		<option value="">Select Year </option>
		<?php $year=date('Y');
		$count = $year+5;
		for($year;$year<=$count;$year++){ ?>
			 <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
		<?php } ?>
		</select>

	
	</div>
	</div>
		
	</div>
	 </div>
	</div>
	        <div class="col-md-4"> 
	      <div class="form-group col-md-4">
			 <button type="submit" class="btn btn-success waves-effect waves-light">Search</button>
		  </div>
	 </div>
     </div>
	 {!! Form::close() !!} 
		
		    <div class="box-header with-border" id="delHolidaysuccess"></div>
			<div class="box-header with-border" id="delHolidayfailure"></div>
			<div class="table-responsive full-width" id="dynamicHoliday">
			   
				 <table class="table table-bordered"  id="datatable">
					<thead>
					  <tr>
					    <th>Country Name</th>
					    <th>Year</th>
						<th>Description</th>
						<th>Date</th>
						<th>Action</th>
					  </tr>
					</thead>
					<tbody >
					  <?php if(@$HolidayLists): 
					  foreach($HolidayLists as $HolidayList):
					  ?>
					  <tr >
						<td id="tdcountry_name_{{$HolidayList['id']}}">{{$HolidayList['country_name']}}</td>
						<td id="tdyear_{{$HolidayList['id']}}">{{$HolidayList['year']}}</td>
						<td id="tdholiday_name_{{$HolidayList['id']}}">{{$HolidayList['holiday_name']}}</td>
						<td id="tdholiday_date_{{$HolidayList['id']}}">{{$HolidayList['holiday_date']}}</td>
						<td><button class="btn btn-icon waves-effect waves-light btn-success" id="editHoliday" onclick="editHoliday({{$HolidayList['id']}})"> <i class="fa fa-pencil"></i> </button> 
<button class="btn btn-icon waves-effect waves-light btn-danger"  id="deleteHoliday" onclick="deleteHoliday({{$HolidayList['id']}})"> <i class="fa fa-remove"></i> </button>
</td>
					  </tr>
					  <?php endforeach;
					  else:?> 
					  <tr >
						<td colspan="5" ><div style="text-align:center" class="alert alert-danger">No Record Found !!</div></td></tr>
					  <?php endif;?>
					  
					</tbody>
				  </table>
				  
			</div>
		   
			
		 </div>
		 
		 
		 
	  </div> </div> 
      </div>
	 
	
<div class="tab-pane" id="messages">
	<div class="row">
    <div class="col-md-12">
		<div class="add-btn">
			<button type="button" class="btn btn-purple waves-effect waves-light" id="showAddReminder"> <i class="fa fa-plus"></i>Add New Type of Date</button>
		</div>
		<div class="card-box clearfix" id="editReminderForm" style="display:none;">
		</div>
		<div class="card-box clearfix" id="AddReminderForm" style="display:none;">
			<div class="col-md-12">
				<div  id="Staffsuccess"></div>
				<div  id="Stafffailure"></div>
			</div>
			<div class="col-md-7 col-md-offset-2">
			
					{!! Form::open(array('url' => '#','id'=>'AddReminder','class'=>'form-horizontal m-t-20 m-b-20')) !!} 
					<div class="form-group clearfix">
						
							<label class="col-md-3 control-label">Date Name</label>
							<div class="col-md-9">
								{!! Form::text('date_name',null,array('class'=>'form-control','placeholder'=>'Enter Name for date type')) !!}
							</div>
						</div>
					<div class="form-group clearfix">
					  
							<label class="col-md-3 control-label">Set Reminder</label>
                            	<div class="col-md-9">    
							<div class="radio radio-info radio-inline">
								<input id="setReminder" value="1" name="setReminder" type="radio">
								<label for="inlineRadio1"> Yes</label>
							</div> 
							<div class="radio radio-info radio-inline">
								<input id="setReminder1" value="0" name="setReminder" type="radio">
								<label for="inlineRadio2">No</label>
							
						</div></div>
					</div>
					<div class="form-group clearfix" id="days_toggle">
						
							<label class="col-md-3 control-label">Days in Advance</label>
							<div class="col-md-9">
								{!! Form::number('days_advance',null,array('class'=>'form-control','min'=>'0','max'=>'100','placeholder'=>'Enter No. of Days in Advance')) !!}
							</div>
						
					</div>
					<div class="col-md-offset-3 col-md-9">
						<button type="submit" class="btn btn-success waves-effect waves-light">Save</button>
					</div>
					{!! Form::close() !!} 
				
			</div>
		</div>
        </div>
        </div>
        <div class="row">
    <div class="col-md-12">
		<div class="card-box" id="dynamicStaff">
		    <div class="box-header with-border" id="delStaffsuccess"></div>
			<div class="box-header with-border" id="delStafffailure"></div>
			<div class="table-responsive" >
			<table class="table table-bordered"  id="datatable2">
				<thead>
					<tr>
						<th>Date Name</th>
						<th>Set Reminder</th>
						<th># of Days in Advance</th>
						<th>Action</th>
					</tr>
				</thead>
			<tbody>
			    <?php if(@$StaffDateReminders): 
				  foreach($StaffDateReminders as $StaffDateReminder):
				  ?>
				  <tr >
					<td id="tddate_name_{{$StaffDateReminder['id']}}">{{$StaffDateReminder['date_name']}}</td>
					<td id="tdset_reminders_{{$StaffDateReminder['id']}}"><?php echo ($StaffDateReminder['set_reminders']==1)?'Yes':'No'; ?></td>
					<td id="tddays_advance_{{$StaffDateReminder['id']}}">{{$StaffDateReminder['days_advance']}}</td>
					<td><button class="btn btn-icon waves-effect waves-light btn-success" id="editReminder" onclick="editReminder({{$StaffDateReminder['id']}})"> <i class="fa fa-pencil"></i> </button> 
<button class="btn btn-icon waves-effect waves-light btn-danger"  id="deleteReminder" onclick="deleteReminder({{$StaffDateReminder['id']}})"> <i class="fa fa-remove"></i> </button>
</td>
				  </tr>
				  <?php endforeach;
				  else:?> 
				  <tr >
					<td colspan="4" ><div style="text-align:center" class="alert alert-danger">No Record Found !!</div></td></tr>
				  <?php endif;?>
			</tbody>
			</table>
			</div>
		</div>
	</div>
</div>
</div>
</div>
</div>
</div>
</div>  
</div> <!-- container -->
</div> <!-- content -->
<script>
	var resizefunc = [];
</script>
@include('elements.footer')
</div>
<script type="text/javascript">

function refreshStaff(){
	$.ajax({
					url: "{{ url('/StaffReminder') }}",
					type: 'POST',
					dataType: 'html',
					cache: false,
					processData: false,
					contentType: false,
					async: false,
					success: function(res){
						$('#dynamicStaff').html(res);
					}
	});
}
function deleteReminder(reminder_id){
	$('#AddReminderForm').hide();
	$('#editReminderForm').hide();
	$.ajax({
		url: "{{ url('/deleteReminder') }}",
		type: 'POST',
		data:{reminder_id:reminder_id},
		dataType: 'json',
		async: false,
		success: function(res){
			refreshStaff();
			if (res.Status=='success') {
				$('body #delStaffsuccess').html('<div class="row"><div class="col-md-12"><div class="alert alert-success  alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>' + res.message + '</span></div></div></div>');
			} else {
				$('body #delStaffsuccess').html('');
			}
			if (res.Status=='danger') {
				$('body #delStafffailure').html('<div class="row"><div class="col-md-12"><div class="alert alert-danger  alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>' + res.message + '</span></div></div></div>');
			} else {
				$('body #delStafffailure').html('');
			}
		}
	});
}
function deleteHoliday(holiday_id){
	$('#addHolidayform').hide();
	$('#editHolidayForm').hide();
	$.ajax({
		url: "{{ url('/Holidaydelete') }}",
		type: 'POST',
		data:{holiday_id:holiday_id},
		dataType: 'json',
		async: false,
		success: function(res){
			
			if (res.Status=='success') {
				$('body #delHolidaysuccess').html('<div class="row"><div class="col-md-12"><div class="alert alert-success  alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>' + res.message + '</span></div></div></div>');
			} else {
				$('body #delHolidaysuccess').html('');
			}
			if (res.Status=='danger') {
				$('body #delHolidayfailure').html('<div class="row"><div class="col-md-12"><div class="alert alert-danger  alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>' + res.message + '</span></div></div></div>');
			} else {
				$('body #delHolidayfailure').html('');
			}
		}
	});
}
function editHoliday(holiday_id){
	$('#addHolidayform').hide();
	$.ajax({
		url: "{{ url('/HolidayEditForm') }}",
		type: 'POST',
		data:{holiday_id:holiday_id},
		dataType: 'html',
		async: false,
		success: function(res){
			$('#editHolidayForm').html(res);
		}
	});
	
}
function editReminder(reminder_id){
	$('#AddReminderForm').hide();
	$.ajax({
		url: "{{ url('/ReminderEditForm') }}",
		type: 'POST',
		data:{reminder_id:reminder_id},
		dataType: 'html',
		async: false,
		success: function(res){
			$('#editReminderForm').show();
			$('#editReminderForm').html(res);
		}
	});
	
}
$(document).ready(function(){
	 $('body #editdatepicker').datepicker();
	 $('body #editdatepicker-autoclose').datepicker({
		autoclose: true,
		todayHighlight: true
	});
	$('#showAddReminder').on('click', function(evt){
		$('#editReminderForm').hide();
		$('#AddReminderForm').toggle(500);
	});
	$('input[type=radio][name=editsetReminder]').change(function() {
		var val = $('input[name=editsetReminder]:checked').val();
		if(val==1)
		{$('#editdays_toggle').show();
	    }else{
			$('#editdays_toggle').hide();
		}
	});
	$('body input[type=radio][name=setReminder]').change(function() {
		console.log($('input[name=setReminder]').val());
		var val = $('input[name=setReminder]:checked').val();
		if(val==1)
		{$('#days_toggle').show();
	    }else{
			$('#days_toggle').hide();
		}
	});
	$('body').on('submit', '#EditReminder', function(evt){
		var data = new FormData(this); 
		var current_id = $(this).find('input[name="id"]').val();
		evt.preventDefault();
		$.ajax({
			url: "{{ url('/ReminderUpdate') }}",
			type: 'POST',
			data:data,
			dataType: 'json',
			cache: false,
			processData: false,
			contentType: false,
			async: false,
			success: function(res){
				$('body #tddate_name_'+current_id ).html($('#EditReminder input[name="date_name"]').val());
				var set_reminders = ($('#EditReminder input[name="set_reminders"]:checked').val() == 1) ? "Yes" : "No";
				$('body #tdset_reminders_'+current_id ).html(set_reminders);
				$('body #tddays_advance_'+current_id ).html($('#EditReminder input[name="days_advance"]').val());
				if (res.Status=='success') {
					$('body #editStaffsuccess').html('<div class="row"><div class="col-md-12"><div class="alert alert-success  alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>' + res.message + '</span></div></div></div>');
				} else {
					$('body #editStaffsuccess').html('');
				}
				if (res.Status=='danger') {
					$('body #editStafffailure').html('<div class="row"><div class="col-md-12"><div class="alert alert-danger  alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>' + res.message + '</span></div></div></div>');
				} else {
					$('body #editStafffailure').html('');
				}
			}
		});
	});
    	
	$('body').on('submit', '#editHoliday', function(evt){
		var data = new FormData(this); 
		var current_id = $(this).find('input[name="id"]').val();
		evt.preventDefault();
		$.ajax({
			url: "{{ url('/HolidayUpdate') }}",
			type: 'POST',
			data:data,
			dataType: 'json',
			cache: false,
			processData: false,
			contentType: false,
			async: false,
			success: function(res){
				$('body #tdcountry_name_'+current_id ).html($('#editHoliday #editcountry_name option:selected').text());
				$('body #tdyear_'+current_id ).html($('#editHoliday #edityear option:selected').text());
				$('body #tdholiday_name_'+current_id ).html($('#editHoliday input[name="holiday_name"]').val());
				$('body #tdholiday_date_'+current_id ).html($('#editHoliday input[name="holiday_date"]').val());
				if (res.Status=='success') {
					$('body #Holidayeditsuccess').html('<div class="row"><div class="col-md-12"><div class="alert alert-success  alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>' + res.message + '</span></div></div></div>');
				} else {
					$('body #Holidayeditsuccess').html('');
				}
				if (res.Status=='danger') {
					$('body #Holidayeditfailure').html('<div class="row"><div class="col-md-12"><div class="alert alert-danger  alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>' + res.message + '</span></div></div></div>');
				} else {
					$('body #Holidayeditfailure').html('');
				}
			}
		});
	});
    $('#addHoliday').on('click', function(evt){
		$('#addHolidayform').toggle(500);
	});
	$('#budget').on('change', function(evt){
		if(this.checked){
			$('#budget_div').show(500);
		}else{
			$('#budget_div').find('.toggle').addClass('btn-danger off').removeClass('btn-success');
			$('#budget_div').hide(500);
		}
	});
	
	$('body').on('submit', '#HolidaySearch', function(evt){
		var data = new FormData(this); 
		evt.preventDefault();
		$.ajax({
			url: "{{ url('/HolidaySearch') }}",
			type: 'POST',
			data:data,
			dataType: 'html',
			cache: false,
			processData: false,
			contentType: false,
			async: false,
			success: function(res){
				$('#dynamicHoliday').html(res);
			}
		});
	});
	$('body').on('submit', '#AddReminder', function(evt){
		var data = new FormData(this); 
		//var data = $(this).serialize();
		evt.preventDefault();
		$.ajax({
			url: "{{ url('/addStaffReminder') }}",
			type: 'POST',
			data:data,
			dataType: 'json',
			cache: false,
			processData: false,
			contentType: false,
			async: false,
			success: function(res){
				refreshStaff();
				if (res.Status=='success') {
					$('#Staffsuccess').html('<div class="row"><div class="col-md-12"><div class="alert alert-success  alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>' + res.message + '</span></div></div></div>');
				} else {
					$('#Staffsuccess').html('');
				}
				if (res.Status=='danger') {
					$('#Stafffailure').html('<div class="row"><div class="col-md-12"><div class="alert alert-danger  alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>' + res.message + '</span></div></div></div>');
				} else {
					$('#Stafffailure').html('');
				}
			}
		});
	});
	$('body').on('submit', '#Holidayform', function(evt){
		var data = new FormData(this); 
		//var data = $(this).serialize();
		evt.preventDefault();
		$.ajax({
			url: "{{ url('/Holiday') }}",
			type: 'POST',
			data:data,
			dataType: 'json',
			cache: false,
			processData: false,
			contentType: false,
			async: false,
			success: function(res){
				if (res.Status=='success') {
					$('#Holidaysuccess').html('<div class="row"><div class="col-md-12"><div class="alert alert-success  alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>' + res.message + '</span></div></div></div>');
				} else {
					$('#Holidaysuccess').html('');
				}
				if (res.Status=='danger') {
					$('#Holidayfailure').html('<div class="row"><div class="col-md-12"><div class="alert alert-danger  alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>' + res.message + '</span></div></div></div>');
				} else {
					$('#Holidayfailure').html('');
				}
			}
		});
	});
	$('body').on('submit', '#Companyform', function(evt){
		var data = new FormData(this); 
		evt.preventDefault();
		var hidden_id = $('body #hidden_id').val();
		$.ajax({
			url: "{{ url('/Company') }}",
			type: 'POST',
			data:data,
			dataType: 'json',
			cache: false,
			processData: false,
			contentType: false,
			async: false,
			success: function(res){
				if (res.Status=='success') {
					$('#Companysuccess').html('<div class="row"><div class="col-md-12"><div class="alert alert-success  alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>' + res.message + '</span></div></div></div>');
				} else {
					$('#Companysuccess').html('');
				}
				if (res.Status=='danger') {
					$('#Companyfailure').html('<div class="row"><div class="col-md-12"><div class="alert alert-danger  alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>' + res.message + '</span></div></div></div>');
				} else {
					$('#Companyfailure').html('');
				}
			}
		});
	});
    
	
});
 $(function(){

	$('#datatable').dataTable();
	$('#datatable2').dataTable();
	  
  });
</script>
<!-- ============================================================== -->
<!-- End Right content here -->
<!-- ============================================================== -->
</div>
<!-- END wrapper -->
@stop
