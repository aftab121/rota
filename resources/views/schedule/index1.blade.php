@extends('layouts.home')
@section('title', 'Organization')
@section('content') 
<!-- Begin page -->
<div id="wrapper"> @include('elements.TopNav')
  @include('elements.sidebar') 
  <!-- ============================================================== --> 
  <!-- Start right Content here --> 
  <!-- ============================================================== -->
   <style type="text/css">
  .panel-custom > .panel-heading:hover {
    background-color: #37a595;
}
  .label-p
  {
    font-size: 13px;
    font-weight:600;
    margin: 8px 0px !important;
  }
  .weekly-report tr td
  {
font-size:13px;
text-transform: uppercase;
border-bottom:1px solid #eee;
padding:6px 0px;
  }
  .all-btns a
  {
   
    
    padding:6px 12px;
    margin-right:2px;
    text-transform: capitalize;
    
  }
.table-head th{
	vertical-align: middle !important;
	border-bottom: 2px solid #b7b7b7 !important;
	background: #c5c5c5;
	color: #4b4b4b;
	text-align: center;
	text-transform: uppercase;
 }
   .table-head td{
  text-align: center;
}

  .table-head span a{
    text-decoration: none;
	padding-left: 10px;
	cursor: pointer;
	color:#5fbeaa;
	font-weight:600;
  }
  .card-box
  {
    padding:0px;
    border-radius:0px;
  }
  .form-group {
	text-align: left;
}
.modal-dialog {
    width: 500px;
    margin: 30px auto;
}

#weekDays
{
	display:inline-block;
}
.default-tab-style
{
	padding-left:10px !important;
	padding-right:10px !important;
	line-height:35px !important;
}
.nav-tabs > li.active > a, .nav-tabs > li.active > a:focus, .nav-tabs > li.active > a:hover, .tabs-vertical > li.active > a, .tabs-vertical > li.active > a:focus, .tabs-vertical > li.active > a:hover
{
	color:#fff !important;
}
.nav.nav-tabs > li > a:hover, .nav.tabs-vertical > li > a:hover {
 color: #fff !important; 
}
#count_unpublished{
	font-size: 17px;
	color: rgb(255, 255, 255);
  margin:0px;
}
.weekly-report tr td{
  padding:2px 0px;
}
#location_id.form-control
{
  height:30px;
  padding: 0px 12px;
}
.budget-left .col-md-12 {
    width: 100%;
    padding: 8px 15px;
    border: 1px solid #e6e6e6;
    background: #fff;
    border-bottom: 0;
}
.modal-open {
    overflow: auto;
}
    </style>
  <div class="content-page" style="margin-left:0px;"> 
    <!-- Start content -->
    <div class="content">
      <div class="container"> 
        
        <!-- Page-Title -->
        <!--<div class="row">
          <div class="col-sm-12">
            <div class="page-header-2">
              <h4 class="page-title">Schedule</h4>
              <ol class="breadcrumb">
                <li> <a href="#">Home</a> </li>
                <li class="active"> Schedule </li>
              </ol>
            </div>
          </div>
        </div>-->
        <div class="row custom-calendar">
          <div class="col-md-3">
            <div class="panel panel-color panel-custom">
              <div class="panel-heading" style="padding:3px 15px;">
                <h3 style="cursor:pointer;" class="panel-title publish_shift_class"  data-toggle="modal"  data-target="#myModal1"><i class="fa fa-chevron-circle-down" aria-hidden="true"></i> Publish & Notify</h3>
				  <h2 id="count_unpublished"></h2>
              </div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-md-12">
                    <p class="text-uppercase label-p">Select location</p>
                    <select name="location_id" id="location_id" class="form-control main_location_id">
					  <?php foreach($Locationlist as $Location): ?>
                      <option value="<?php echo $Location['location_id'];?>" ><?php echo $Location['location_name'];?></option>
					  <?php endforeach; ?>
                    </select>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <p class="text-uppercase label-p">Schedule by</p>
                    <!-- Nav tabs -->
                    <div> <button  class="btn btn-default employee_btn" >Employees</button> <button class="btn btn-white btn-default position_btn" style="background-color: #3f9583 !important;">Position</button> </div>
                    <input type="hidden" name="type_set" id="type_set" value="position"/>
					<input type="hidden" name="current_back" id="current_back" value="0"/>
                    <!-- Tab panes --> 
                    
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <p class="text-uppercase label-p">Weekly report</p>
                    <table width="100%" border="0" cellspacing="0" cellpadding="7" class="weekly-report">
                      <tr>
                        <td>Total shifts</td>
                        <td id="total_shifts">0</td>
                      </tr>
                      <tr>
                        <td>Filled Shifts</td>
                        <td id="filled_shifts">0</td>
                      </tr>
                      <tr>
                        <td>Filled Hours</td>
                        <td id="total_hrs">0</td>
                      </tr>
                      <tr>
                        <td>Total cost</td>
                        <td id="total_cost">$ 0</td>
                      </tr>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="budget-left long_screen_budget">
            <div class="col-md-12">
            Sales
            </div>
             <?php $show_labor_hours = Session::get('CompanyDetails.labor_hours');
	 if($show_labor_hours==1){?><div class="col-md-12">
            Labour Hours
            </div>
            <?php } $show_labor_cost = Session::get('CompanyDetails.labor_cost');
	 if($show_labor_cost==1){?> <div class="col-md-12">
            Labour Cost
            </div>
	 <?php }$show_sales_per_hour = Session::get('CompanyDetails.sales_per_hour');
		 if($show_sales_per_hour==1){?><div class="col-md-12">
            Sales Per Hour
            </div>
		 <?php } $show_labor_adjustment = Session::get('CompanyDetails.labor_adjustment');
		 if($show_labor_adjustment==1){?> <div class="col-md-12">
            Labour Variation *
            </div>
		 <?php } ?>
            <div class="col-md-12">
            Labour percentage *
            </div>
             </div>
          </div>
		  <!--Copy Shift to week-->
<div class="modal fade" id="myCopyWeekModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="refreshDiv();"> <span aria-hidden="true">&times;</span> </button>
        <h4 class="modal-title" id="myModalLabel">Copy Shift of <strong><span id="copy_week_title"></span></strong> Week</h4>
      </div>
      {!! Form::open(array('url'=> '#','id'=>'CopyWeekForm','class'=>'form-horizontal m-t-20')) !!}
      <div class="modal-body clearfix">
        <div class="row">
          <div class="col-md-12" id="weeksuccess"></div>
          <div class="col-md-12" id="weekfailure"></div>
        </div>
		
        <div class="row">
			<div class="positions-tab">
			    <h4>Select the week(s) you would like to copy the schedule to:</h4>
				<div class="row">
				  <div class="col-md-12">
					<div>
					  <button type="button" class="btn btn-white btn-custom waves-effect" id="AddCopyWeekSelectAll">Select All</button>
					  <button type="button" class="btn btn-white btn-custom waves-effect" id="AddCopyWeekClearAll">Clear All</button>
					</div>
				  </div>
				</div>
				<div class="location-list">
				  <div class="row">
					<div class="check-design copy_week_show">
					  	 
					</div>
				  </div>
				</div>
				<input type="hidden" name="copy_shift_from" id="copy_shift_from" value=""/>
			</div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="refreshDiv();">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      {!! Form::close() !!} </div>
  </div>
</div>
		<!--Ends : Copy Shift to week-->
		  <!-- publish and notify modal-->
          <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" onclick="refreshDiv();"  aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel">Publish for Location</h4>
                </div>
                <div class="modal-body">
                  <div> 
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                      <li role="presentation" class="active"><a href="#home" class="btn btn-default default-tab-style"  aria-controls="home" role="tab" data-toggle="tab">Publish by Position</a></li>
                      <li role="presentation"><a href="#profile" class="btn btn-default default-tab-style"  aria-controls="profile" role="tab" data-toggle="tab">Publish by Staff</a></li>
                    </ul>
                    
                    <!-- Tab panes -->
                    <div class="tab-content padd-15">
						<div class="box-header with-border" id="publishsuccess"></div>
						<div class="box-header with-border" id="publishfailure"></div>
                    <div role="tabpanel" class="tab-pane active" id="home">
					 {!! Form::open(array('url' => '#','id'=>'publish_position_ids','class'=>'form-horizontal m-t-20')) !!} 
                        <div class="positions-tab">
							<div class="row">
							  <div class="col-md-12">
								<div>
								  <button type="button" class="btn btn-white btn-custom waves-effect" id="AddPositionSelectAll">Select All</button>
								  <button type="button" class="btn btn-white btn-custom waves-effect" id="AddPositionClearAll">Clear All</button>
								</div>
							  </div>
							</div>
							<div class="location-list">
							  <div class="row">
								<div class="check-design position_list_show">
								  <?php 
											 if($Positionlist):
												foreach($Positionlist as $Position):
											 ?>
								  <div class="col-md-6">
									<div class="emp-name add_position_name_list ">
									  <label>
										<input name="publish_position_ids[]" type="checkbox" value="<?php echo $Position['id'];?>" />
										<?php echo $Position['position_name'];?></label>
									</div>
								  </div>
								  <?php endforeach; endif; ?>
											 
								</div>
								<input name="publish_position" type="hidden" value="position" />
							  </div>
							</div>
					    </div>
						<div class="modal-footer" style="margin-top:20px;">
						  <button type="button" class="btn btn-danger" onclick="refreshDiv();" data-dismiss="modal">Close</button>
						  <button type="submit" id="submit_by_position" class="btn btn-primary">Submit</button>
						</div>
						{!! Form::close() !!}
				  </div>
                      <div role="tabpanel" class="tab-pane" id="profile"><div class="staff-list-main">
					        {!! Form::open(array('url' => '#','id'=>'publish_staff_ids','class'=>'form-horizontal m-t-20')) !!} 
							 <div>
								<button type="button" class="btn btn-white btn-custom waves-effect" id="AddStaffSelectAll">Select All</button>
								<button type="button" class="btn btn-white btn-custom waves-effect"  id="AddStaffClearAll">Clear All</button>
							 </div>
							 
							 <div class="staff-list">
								 <div class="row">
							 <div class="check-design staff_list_show" >
								 <?php 
								 if($Stafflist):
									foreach($Stafflist as $Staff):
								 ?>
								 <div class="col-md-6">
									 <div class="emp-name add_staff_name_list">
										 <label> <input name="publish_staff_ids[]" type="checkbox" value="<?php echo $Staff['id'];?>" /><?php echo $Staff['firstname'].' '.$Staff['lastname'];?></label>
									 </div>
								 </div>
								 <?php endforeach;
								 endif; ?>
								 
							 </div>
							 <input name="publish_position" type="hidden" value="staff" />
							</div>   
						  </div>
						 </div><div class="modal-footer" style="margin-top:20px;">
                  <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="refreshDiv();">Close</button>
                  <button type="submit"  id="submit_by_staff" class="btn btn-primary">Submit</button>
                </div>
				{!! Form::close() !!}
				</div>
                    </div>
                  </div>
                </div>
                
              </div>
            </div>
          </div>
          <!-- publish and notify modal -->
          <div class="col-md-9">
            <div class="row">
              <div class="col-md-12 all-btns"> 
					<?php 
					$currentdate = date('M j');
					$endDate = date('M j',strtotime('-1 days'));
					$startDate = date('M j', strtotime("+1 days",strtotime($endDate)));
					$endDate = date('M j', strtotime("+6 days",strtotime($startDate)));
					?>
					 <input id="shift_currentweek" name="shift_currentweek" type="hidden" value="<?php echo date('Y-m-d');?>" class="form-control" >
					<button class="btn btn-sm btn-default decWeek" data-id = "-1" ><i class="fa fa-chevron-left"></i></button> 
					<div  id="weekDays">
					<?php 
					for($i= 0;$i<=4;$i++){ 
						
					?>
					<button class="btn btn-sm btn-default selectWeek" style="<?php echo ($i==0)?'background-color: #3f9583 !important;':'';?>" data-id ="<?php echo $i; ?>"><?php echo $startDate.' - '.$endDate;?></button>
					<?php   $startDate = date('M j', strtotime("+1 days",strtotime($endDate)));
							$endDate = date('M j', strtotime("+6 days",strtotime($startDate)));
					}?>
					</div>
					<button class="btn btn-sm btn-default incWeek" data-id = "5"><i class="fa fa-chevron-right"></i></button>
					<button class="btn btn-sm btn-default delete_week_btn"  aria-hidden="true"  data-toggle="modal"  data-target="#deleteWeekModal" title="Delete Week Shifts"><i class="fa fa-trash"></i></button>
					<?php $show_budget = Session::get('CompanyDetails.budget'); if($show_budget==1){?><button class="btn btn-sm btn-default show_budget">Show Budget</button><?php } ?>
					<button class="btn btn-sm btn-default copy_week_btn"  aria-hidden="true"  data-toggle="modal"  data-target="#myCopyWeekModal">Copy Week</button>
			 </div>
            </div>
            <div class="row">
			  <input id="shift_currentback" name="shift_currentback" type="hidden" value="" class="form-control" >
			  
              <div class="col-md-12" id="tableView">
 </div>
        </div>
      </div>
    </div>
  </div>
  <!-- container --> 
  <!--Starts : Delete Week Shift -->
<div class="modal fade" id="deleteWeekModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="refreshDiv();"> <span aria-hidden="true">&times;</span> </button>
        <h4 class="modal-title" id="myModalLabel">Delete all Shifts of <strong><span id="delete_week_title"></span></strong> Week</h4>
      </div>
      {!! Form::open(array('url'=> '#','id'=>'DeleteWeekForm','class'=>'form-horizontal m-t-20')) !!}
      <div class="modal-body clearfix">
        <div class="row">
          <div class="col-md-12" id="deleteweeksuccess"></div>
          <div class="col-md-12" id="deleteweekfailure"></div>
        </div>
		
        <div class="row">
			<div class="positions-tab">
			    <h4>Are you sure you want to delete all shifts of this week ?</h4>
				
				<input type="hidden" name="current_delete_start_date" id="current_delete_start_date" value=""/>
				<input type="hidden" name="current_delete_end_date" id="current_delete_end_date" value=""/>
			</div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="refreshDiv();">Cancel</button>
        <button type="submit" class="btn btn-primary">Delete</button>
      </div>
      {!! Form::close() !!} </div>
  </div>
</div>
		<!--Ends : Delete Week Shift -->
</div>
</div>
<!-- content --> 
<script>
  var resizefunc   = [];
</script> 
@include('elements.footer')
</div>
<script>
jQuery(document).ready(function() {
jQuery('body #Edittimepicker').timepicker({
	<?php if(Session::get('CompanyDetails.time_format')==12){?>
	defaultTIme : false
	<?php }else{?>
	showMeridian : false
	<?php } ?>
});

jQuery('body #Edittimepicker2').timepicker({
	<?php if(Session::get('CompanyDetails.time_format')==12){?>
	defaultTIme : false
	<?php }else{?>
	showMeridian : false
	<?php } ?>
});
});
</script>
<script type="text/javascript" src="http://www.datejs.com/build/date.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('body').on('change','#Edittimepicker2', function(evt){
			var date_diff= (new Date($('#Edittimepicker2').val()) - new Date($('#Edittimepicker').val())) / 1000 / 60 / 60;
			var d1 = Date.parse($('#Edittimepicker').val());
			var d2 = Date.parse($('#Edittimepicker2').val());
		});
		// For Delete Week Shifts 
		$('body').on('click','.delete_week_btn', function(evt){
			var shift_currentweekStart = $('#shift_currentweekStart').val();
			$.ajax({
				url: "{{ url('/ShowWeek') }}",
				type: 'POST',
				data:{shift_currentweekStart:shift_currentweekStart},
				dataType: 'json',
				async:false,
				success: function(res){
					$('#delete_week_title').html(res.current_delete_weeks);
					$('#current_delete_start_date').val(res.current_delete_start_date);
					$('#current_delete_end_date').val(res.current_delete_end_date);
				}
			});
		});
		$('body').on('click','.copy_week_btn', function(evt){
			var shift_currentweekStart = $('#shift_currentweekStart').val();
			var location = $('.main_location_id').val();	
			var currentback = $('#shift_currentback').val();
			$.ajax({
				url: "{{ url('/CopyWeekOption') }}",
				type: 'POST',
				data:{shift_currentweekStart:shift_currentweekStart},
				dataType: 'json',
				async:false,
				success: function(res){
					$('.copy_week_show').html(res.copy_weeks);
					$('#copy_week_title').html(res.current_copy_weeks);
					$('#copy_shift_from').val(res.copy_shift_from);
					
				}
			});
		});
	});
</script>
<script>
function refresh(current_back){
	var location_id = $('#location_id').val();
	var type_set = $('#type_set').val();
	current_back = parseInt(current_back);
	$.ajax({
		url: "{{ url('/selectWeek') }}",
		type: 'POST',
		data:{current_back:current_back,location_id:location_id,type_set:type_set},
		dataType: 'html',
		async: false,
		success: function(res){
			$('#tableView').html(res);
			//console.log(row);
			$('#shift_currentback').val(current_back);
			$('#current_back').val(current_back);
			$("#myModal").removeClass("in");
			$(".modal-backdrop").remove();
			$("#myModal").hide();
			$("#myEditModal").removeClass("in");
			$(".modal-backdrop").remove();
			var unpublished_count = $('body #unpublished_count').val();
			$('#count_unpublished').html(unpublished_count+ ' shifts unpublished');
			$("#myEditModal").hide();
			$('.long_screen_budget').hide();
			$('.budget_access').hide();
		},
		complete: function(){
                $("body tr:odd").each(function(i, tr) {
					var row = $(this);
					row.insertAfter(row.next());
				});
            }
	});
}
function weeklyReport(current_back){
	var location_id = $('#location_id').val();
	var type_set = $('#type_set').val();
	current_back = parseInt(current_back);
	$.ajax({
		url: "{{ url('/WeeklyReport') }}",
		type: 'POST',
		data:{current_back:current_back,location_id:location_id,type_set:type_set},
		dataType: 'json',
		async: false,
		success: function(res){
			$('#total_shifts').text(res.total_shifts);
			$('#total_hrs').text(res.total_hrs);
			$('#total_cost').text(res.total_cost);
			$('#filled_shifts').text(res.filled_shifts);
		}
	});
}
weeklyReport(0);
refresh(0);
$(document).ready(function(){
	$('body').on('change','.main_location_id', function(evt){
			var current_back = $('#current_back').val();
			refresh(0);
			weeklyReport(0);
	});
	$('body').on('click','.employee_btn', function(evt){
		$('#type_set').val('staff');
		var current_back = $('#current_back').val();
		console.log(current_back);
		 $('.position_btn,.employee_btn').attr('style', 'background-color: #5fbeaa !important');
		 $(this).attr('style', 'background-color: #3f9583 !important');
		refresh(current_back);
		weeklyReport(current_back);
	});
	$('body').on('click','.position_btn', function(evt){
		$('#type_set').val('position');
		
		 $('.position_btn,.employee_btn').attr('style', 'background-color: #5fbeaa !important');
		 $(this).attr('style', 'background-color: #3f9583 !important');
		var current_back = $('#current_back').val();
		console.log(current_back);
		refresh(current_back);
		weeklyReport(current_back);
	});
    $('body').on('click','.selectWeek', function(evt){
		var current_back = $(this).attr('data-id');
		refresh(current_back);
		 $('.selectWeek,.decWeek,.incWeek').attr('style', 'background-color: #5fbeaa !important');
		 $(this).attr('style', 'background-color: #3f9583 !important');
		weeklyReport(current_back);
	});
	$('body').on('submit', '#publish_position_ids,#publish_staff_ids', function(evt){
			var data = new FormData(this); 
			var current_back = $('#shift_currentback').val();
			data.append('current_back', current_back);
			evt.preventDefault();
			$.ajax({
				url: "{{ url('/publishShift') }}",
				type: 'POST',
				data:data,
				dataType: 'json',
				cache: false,
				processData: false,
				contentType: false,
				async: false,
				success: function(res){
					
					if (res.Status=='success') {
						$('#publishsuccess').html('<div class="row"><div class="col-md-12"><div class="alert alert-success  alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>' + res.message + '</span></div></div></div>');
					} else {
						$('#publishsuccess').html('');
					}
					if (res.Status=='danger') {
						$('#publishfailure').html('<div class="row"><div class="col-md-12"><div class="alert alert-danger  alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>' + res.message + '</span></div></div></div>');
					} else {
						$('#publishfailure').html('');
					}
				}
			});
		});
    // For date Notes
	$('body').on('click','.adddatenotes', function(evt){
			var note_date = $(this).attr('data-note_date');
			$('#add_note_note_date').val(note_date);
			var note_date1 = $(this).attr('data-date_format');
			$('.title_note').html(note_date1);
	});
	// For Copy Shift : Starts Here
	$('body').on('click','.copy_shift_model', function(evt){
			var position_name = $(this).attr('data-position_name');
			$('#copy_position').html(position_name);
			var shift_start_time = $(this).attr('data-shift_start_time');
			var shift_end_time = $(this).attr('data-shift_end_time');
			$('#copy_time').html(shift_start_time+' - '+shift_end_time);
			var meal_break = $(this).attr('data-meal_break');
			$('#copy_meal').html(meal_break+' minutes ');
			var date_index = $(this).attr('data-date_index');
			$('.class'+date_index).addClass('shift-active');
			$('.class'+date_index).css('margin-top','0px');
			var copy_shift_id = $(this).attr('data-shift_id');
			$('#copy_shift_id').val(copy_shift_id);
			
	});
	$('body').on('submit', '#copyShifts', function(evt){
			var data = new FormData(this); 
			evt.preventDefault();
			$.ajax({
				url: "{{ url('/CopyShifts') }}",
				type: 'POST',
				data:data,
				dataType: 'json',
				cache: false,
				processData: false,
				contentType: false,
				async: false,
				success: function(res){
					
					if (res.Status=='success') {
						$('body .copyShiftsuccess').html('<div class="row"><div class="col-md-12"><div class="alert alert-success  alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>' + res.message + '</span></div></div></div>');
					} else {
						$('body .copyShiftsuccess').html('');
					}
					if (res.Status=='danger') {
						$('body .copyShiftfailure').html('<div class="row"><div class="col-md-12"><div class="alert alert-danger  alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>' + res.message + '</span></div></div></div>');
					} else {
						$('body .copyShiftfailure').html('');
					}
				}
			});
		});
	// For Copy Shift : Ends 
	$('body').on('click','.editdatenotes', function(evt){
			var edit_notes = $(this).attr('data-edit_notes');
			$('#edit_notes').val(edit_notes);
			var note_date = $(this).attr('data-note_date');
			$('#edit_note_note_date').val(note_date);
			var note_date1 = $(this).attr('data-date_format');
			$('.edit_title_note').html(note_date1);
		});
	$('body').on('submit', '#AddDateNotes,#editDateNotes', function(evt){
			var data = new FormData(this); 
			evt.preventDefault();
			$.ajax({
				url: "{{ url('/addNotesByDate') }}",
				type: 'POST',
				data:data,
				dataType: 'json',
				cache: false,
				processData: false,
				contentType: false,
				async: false,
				success: function(res){
					
					if (res.Status=='success') {
						$('body .addNotesuccess').html('<div class="row"><div class="col-md-12"><div class="alert alert-success  alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>' + res.message + '</span></div></div></div>');
					} else {
						$('body .addNotesuccess').html('');
					}
					if (res.Status=='danger') {
						$('body .addNotefailure').html('<div class="row"><div class="col-md-12"><div class="alert alert-danger  alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>' + res.message + '</span></div></div></div>');
					} else {
						$('body .addNotefailure').html('');
					}
				}
			});
		});
	// For date Notes : Ends Here 
	$('body').on('click','.decWeek', function(evt){
		var current_back = $(this).attr('data-id');
		current_back = parseInt(current_back);
		$.ajax({
			url: "{{ url('/decWeek') }}",
			type: 'POST',
			data:{current_back:current_back},
			dataType: 'json',
			async: false,
			success: function(res){
			var nth = current_back-1;
				$('#weekDays').prepend('<button class="btn btn-sm btn-default selectWeek" data-id = "'+current_back+'" >'+res+'</button>');
				$('body #weekDays button:last-child').remove();
				$('.decWeek').attr('data-id', nth);
				var last = $('body .selectWeek:last-child').attr('data-id');
				$('.incWeek').attr('data-id',parseInt(last)+1);
				
			}
		});
	});
	$('body').on('click','.incWeek', function(evt){
		var current_back = $(this).attr('data-id');
		current_back = parseInt(current_back);
		$.ajax({
			url: "{{ url('/incWeek') }}",
			type: 'POST',
			data:{current_back:current_back},
			dataType: 'json',
			async: false,
			success: function(res){
				var nth = current_back+1;
				$('#weekDays').append('<button class="btn btn-sm btn-default selectWeek" data-id = "'+current_back+'" >'+res+'</button>');
				$('.incWeek').attr('data-id', nth);
				$('#weekDays button:first-child').remove();
				var current  = $('body .selectWeek:first-child').attr('data-id');
				$('.decWeek').attr('data-id',parseInt(current)-1);
			}
		});
	});
	
	$('body').on('input','.sales,.labour_variation', function(evt){
		var current_id = $(this).attr('id');
		var myClass = $(this).attr("class");
		var myClass = myClass.split('form-control ');
		if(myClass[1]=='sales'){
			var array = current_id.split('sales');
			var sales_price = $(this).val();
			var labour_variation = $('#labour_variation'+array[1]).val();
		}
		if(myClass[1]=='labour_variation'){
			var array = current_id.split('labour_variation');
			var labour_variation = $(this).val();
			var sales_price = $('#sales'+array[1]).val();
		}
		add_current_days = array[1];
		var location = $('#location_id').val();
		var shift_currentback = $('#shift_currentback').val();
		current_back = parseInt(shift_currentback);
		$.ajax({
			url: "{{ url('/salesPercentage') }}",
			type: 'POST',
			data:{current_back:current_back,sales_price:sales_price,location_id:location,add_current_days: add_current_days,labour_variation:labour_variation},
			dataType: 'json',
			async: false,
			success: function(res){
				$('#salesperHour'+add_current_days).text('$ '+res.sales_per_hour);
				$('#percentage_calculate'+add_current_days).text(res.percentage_cost+' %');
			}
		});
	});
	$('body').on('submit', '#EditShiftForm', function(evt){
		var data = new FormData(this); 
		evt.preventDefault();
		var type_set = $('#type_set').val();
		data.append('type_set',type_set);
		$.ajax({
			url: "{{ url('/EditShift') }}",
			type: 'POST',
			data:data,
			dataType: 'json',
			cache: false,
			processData: false,
			contentType: false,
			async: false,
			success: function(res){
				if (res.Status=='success') {
					$('#editsuccess').html('<div class="row"><div class="col-md-12"><div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>' + res.message + '</span></div></div></div>');
				} else {
					$('#editsuccess').html('');
				}
				if (res.Status=='danger') {
					$('#editfailure').html('<div class="row"><div class="col-md-12"><div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>' + res.message + '</span></div></div></div>');
				} else {
					$('#editfailure').html('');
				}
				var shift_currentback = $('#shift_currentback').val();
				setTimeout(function () { refresh(shift_currentback); weeklyReport(shift_currentback);}, 1500);
			}
		});
	});
	$('body').on('submit', '#AddShiftForm', function(evt){
		var data = new FormData(this); 
		var type_set = $('#type_set').val();
		data.append('type_set',type_set);
		evt.preventDefault();
		$.ajax({
			url: "{{ url('/AddShift') }}",
			type: 'POST',
			data:data,
			dataType: 'json',
			cache: false,
			processData: false,
			contentType: false,
			async: false,
			success: function(res){
				if (res.Status=='success') {
					$('#addsuccess').html('<div class="row"><div class="col-md-12"><div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>' + res.message + '</span></div></div></div>');
				} else {
					$('#addsuccess').html('');
				}
				if (res.Status=='danger') {
					$('#addfailure').html('<div class="row"><div class="col-md-12"><div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>' + res.message + '</span></div></div></div>');
				} else {
					$('#addfailure').html('');
				}
				var shift_currentback = $('#shift_currentback').val();
				setTimeout(function () { refresh(shift_currentback); weeklyReport(shift_currentback);}, 1500);
			}
		});
	});
	
	$('body').on('submit', '#CopyWeekForm', function(evt){
		var data = new FormData(this);
		var location = $('.main_location_id').val();	
		data.append('location_id', location);
		evt.preventDefault();
		$.ajax({
			url: "{{ url('/CopyWeekShifts') }}",
			type: 'POST',
			data:data,
			dataType: 'json',
			cache: false,
			processData: false,
			contentType: false,
			async: false,
			success: function(res){
				if (res.Status=='success') {
					$('#weeksuccess').html('<div class="row"><div class="col-md-12"><div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>' + res.message + '</span></div></div></div>');
				} else {
					$('#weeksuccess').html('');
				}
				if (res.Status=='danger') {
					$('#weekfailure').html('<div class="row"><div class="col-md-12"><div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>' + res.message + '</span></div></div></div>');
				} else {
					$('#weekfailure').html('');
				}
				var shift_currentback = $('#shift_currentback').val();
				//setTimeout(function () { refresh(shift_currentback);weeklyReport(shift_currentback); }, 2000);
			}
		});
	});

	$('body').on('submit', '#DeleteWeekForm', function(evt){
		evt.preventDefault();
		
		var data = new FormData(this);
		var location = $('.main_location_id').val();	
		data.append('location_id', location);
		evt.preventDefault();		
		$.ajax({
			url: "{{ url('/DeleteWeekShifts') }}",
			type: 'POST',
			data:data,
			dataType: 'json',
			cache: false,
			processData: false,
			contentType: false,
			async: false,
			success: function(res){
				if (res.Status=='success') {
					$('#deleteweeksuccess').html('<div class="row"><div class="col-md-12"><div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>' + res.message + '</span></div></div></div>');
				} else {
					$('#deleteweeksuccess').html('');
				}
				if (res.Status=='danger') {
					$('#deleteweekfailure').html('<div class="row"><div class="col-md-12"><div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>' + res.message + '</span></div></div></div>');
				} else {
					$('#deleteweekfailure').html('');
				}
				
			}
		});
	});

	
});
function refreshDiv(){
		var shift_currentback = $('#shift_currentback').val();
		refresh(shift_currentback);
	}
</script>
 <script type="text/javascript">
	$(document).ready(function(){
		
		$('body #AddCopyWeekSelectAll').click(function(){
			$('.copy_week_start_list input').attr('checked', true);
			$('.copy_week_start_list label').addClass("checked");
		});
		$('body #AddCopyWeekClearAll').click(function(){
			$('.copy_week_start_list input').attr('checked', false);
			$('.copy_week_start_list label').removeClass("checked");
		});
		$('body #AddPositionSelectAll').click(function(){
			$('.add_position_name_list input').attr('checked', true);
			$('.add_position_name_list label').addClass("checked");
		});
		$('body #AddPositionClearAll').click(function(){
			$('.add_position_name_list input').attr('checked', false);
			$('.add_position_name_list label').removeClass("checked");
		});
		$('body #AddLocationSelectAll').click(function(){
			$('.add_location_name_list input').attr('checked', true);
			$('.add_location_name_list label').addClass("checked");
		});
		$('body #AddLocationClearAll').click(function(){
			$('.add_location_name_list input').attr('checked', false);
			$('.add_location_name_list label').removeClass("checked");
		});
		$('body #AddStaffSelectAll').click(function(){
			$('.add_staff_name_list input').attr('checked', true);
			$('.add_staff_name_list label').addClass("checked");
		});
		$('body #AddStaffClearAll').click(function(){
			$('.add_staff_name_list input').attr('checked', false);
			$('.add_staff_name_list label').removeClass("checked");
		});
		$('body').on('click','.show_budget', function(evt){
			console.log($( window ).width());
			if($( window ).width()<768){
				$('.budget_access').toggle();
			}else{
				$('.long_screen_budget').toggle();
			}
			$('.sales_table').toggle();
			$('#beforeBudget').toggle();
			$('#beforeBudget1').toggle();
			$('.afterBudget').toggle();
			
		});
		$('body').on('change','#Edittimepicker2', function(evt){
			var date_diff= (new Date($('#Edittimepicker2').val()) - new Date($('#Edittimepicker').val())) / 1000 / 60 / 60;
			var d1 = Date.parse($('#Edittimepicker').val());
			var d2 = Date.parse($('#Edittimepicker2').val());
		});
		$('body').on('click','.modelShowUsers', function(evt){
			var location = $(this).attr('data-location_id');
			$('#shift_location_id').val(location);
			var user_id = $(this).attr('data-user_id');
			$('#shift_user_id').val(user_id);
			$.ajax({
				url: "{{ url('/StaffOption') }}",
				type: 'POST',
				data:{user_id:user_id},
				dataType: 'html',
				async:false,
				success: function(res){
					if($('#position_id_list').length){
						$('#position_id_list').html(res);
					 } else{
						$('#assigned_to_list').html(res);
					 } 
				}
			});
			var date = $(this).attr('data-date'); 
			$('#shift_date').val(date);
			var meal_break = $(this).attr('data-meal_break'); 
			$('#meal_break').val(meal_break);
			var end_time = $(this).attr('data-end_time');
			$('#Edittimepicker2').val(end_time);							
			var start_time = $(this).attr('data-start_time'); 
			$('#Edittimepicker').val(start_time);
		});
		$('body').on('click','.EditmodelUserShow', function(evt){
			var user_id = $(this).attr('data-user_id');
			$('#shift_user_id').val(user_id);
			var shift_id = $(this).attr('data-shift_id');
			$('#shift_id').val(shift_id);
			$.ajax({
				url: "{{ url('/StaffOption') }}",
				type: 'POST',
				data:{user_id:user_id},
				dataType: 'html',
				async:false,
				success: function(res){
					if($('#edit_position_id_list').length){
						$('#edit_position_id_list').html(res);
					 } else{
						$('#edit_assigned_to_list').html(res);
					 } 
				}
			});
			$.ajax({
				url: "{{ url('/StaffEditdetails') }}",
				type: 'POST',
				data:{shift_id:shift_id},
				dataType: 'json',
				async:false,
				success: function(res){
					$('#shift_editlocation_id').val(res.location_id);
					$('#shift_editposition_id').val(res.position_id);
					$('#Edittimepicker').val(res.shift_start_time);
					$('#Edittimepicker2').val(res.shift_end_time);
					$('#editmeal_break').val(res.meal_break);
					$("#editend_option option[value='"+res.end_option+"']").prop("selected", true);
					$("#edit_assigned_to_list option[value='"+res.assigned_to+"']").prop("selected", true);
					$('#shift_editdate').val(res.shift_date);
				}
			});
			
		});
		$('body').on('click','.EditmodelShow', function(evt){
			var position_id = $(this).attr('data-position_id');
			$('#shift_position_id').val(position_id);
			var visible = $(this).attr('data-visible');
			if(visible==1){
				$('#shift_visible').attr('checked','checked');
			}
			var notes = $(this).attr('data-notes');
			$('#shift_notes').val(notes);
			var shift_id = $(this).attr('data-shift_id');
			$('#shift_id').val(shift_id);
			$.ajax({
				url: "{{ url('/StaffOption') }}",
				type: 'POST',
				data:{position_id:position_id},
				dataType: 'html',
				async:false,
				success: function(res){
					$('#edit_assigned_to_list').html(res);
				}
			});
			$.ajax({
				url: "{{ url('/StaffEditdetails') }}",
				type: 'POST',
				data:{shift_id:shift_id},
				dataType: 'json',
				async:false,
				success: function(res){
					console.log(res);
					$('#shift_editlocation_id').val(res.location_id);
					$('#shift_editposition_id').val(res.position_id);
					$('#Edittimepicker').val(res.shift_start_time);
					$('#Edittimepicker2').val(res.shift_end_time);
					$('#editmeal_break').val(res.meal_break);
					$("#editend_option option[value='"+res.end_option+"']").prop("selected", true);
					$("#edit_assigned_to_list option[value='"+res.assigned_to+"']").prop("selected", true);
					$('#shift_editdate').val(res.shift_date);
				}
			});
			
		});
		
		//publish_shift_class
		$('body').on('click','.publish_shift_class', function(evt){
			var location_id = $('.main_location_id').val();
			$.ajax({
				url: "{{ url('/PublishOption') }}",
				type: 'POST',
				data:{location_id:location_id},
				dataType: 'json',
				async:false,
				success: function(res){
					$('.staff_list_show').html(res.staff);
					$('.position_list_show').html(res.position);
				}
			});
			var date = $(this).attr('data-date'); 
			$('#shift_date').val(date);
			var meal_break = $(this).attr('data-meal_break'); 
			$('#meal_break').val(meal_break);
			var end_time = $(this).attr('data-end_time');
			$('#Edittimepicker2').val(end_time);							
			var start_time = $(this).attr('data-start_time'); 
			$('#Edittimepicker').val(start_time);
		});
		
		$('body').on('click','.modelShow', function(evt){
			var location = $(this).attr('data-location_id');
			$('#shift_location_id').val(location);
			var position_id = $(this).attr('data-position_id');
			$('#shift_position_id').val(position_id);
			$.ajax({
				url: "{{ url('/StaffOption') }}",
				type: 'POST',
				data:{position_id:position_id},
				dataType: 'html',
				async:false,
				success: function(res){
					if($('#position_id_list').length){
						$('#position_id_list').html(res);
					 } else{
						$('#assigned_to_list').html(res);
					 } 
				}
			});
			var date = $(this).attr('data-date'); 
			$('#shift_date').val(date);
			var meal_break = $(this).attr('data-meal_break'); 
			$('#meal_break').val(meal_break);
			var end_time = $(this).attr('data-end_time');
			$('#Edittimepicker2').val(end_time);							
			var start_time = $(this).attr('data-start_time'); 
			$('#Edittimepicker').val(start_time);
		});
		
		$('body').on('click','.deletemodelUserShow', function(evt){
			var shift_id = $(this).attr('data-shift_id');
			
			$.ajax({
				url: "{{ url('/DeleteShift') }}",
				type: 'POST',
				data:{shift_id:shift_id},
				dataType: 'html',
				async:false,
				success: function(res){
					refreshDiv(); 
					var current_back = $('#shift_currentback').val();
					weeklyReport(current_back);
				}
			});
		});
	});
</script>
<!-- ============================================================== --> 
<!-- End Right content here --> 
<!-- ============================================================== -->
</div>
<!-- END wrapper --> 
@stop 