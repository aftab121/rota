@extends('layouts.home')
@section('title', 'Organization')
@section('content') 
<!-- Begin page -->
<style type="text/css">
	.form-control-custom
	{
		border: 1px solid #d4d4d4;
padding: 3px 8px;
border-radius: 3px;
	}
	.custom-tab-style strong
	{
	width: 110px;
display: inline-block;
	}
	.TextBoxesGroup
	{
	
	display:inline-block;}
	#TextBoxDiv1
	{
	
	display:inline-block;}
	#TextBoxDiv2{display:inline-block;}
</style>
<div id="wrapper"> @include('elements.TopNav')
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
              <h4 class="page-title">Staff</h4>
              <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li class="active">Staff</li>
              </ol>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3">
            <div class="store-location-list">
              <form>
                <div class="input-group m-b-10">
                  <input type="text"  class="form-control" name="searchStaff"  placeholder="Search...." style="height:40px;">
                  <div class="input-group-btn">
                    <button class="btn btn-default btn-block" type="button" id="searchStaff" ><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </form>
              <div class="store-list staff-all">
                <form  id="liclickForm">
                  {{csrf_field()}}
                  <ul id="userlists">
                    <?php if($Userlists):
					  foreach($Userlists as $user):
					 ?>
                    <?php $img = ($user['profile_pic'])?('profile/'.$user['profile_pic']):'noimage.png'; ?>
                    <li data-id ="{{ $user['id']}}" class="liStaffDiv<?php echo $user['id'];?> checked"><span class="liStaffNameDiv<?php echo $user['id'];?>"><span><img src="{{ asset('images/'.$img) }}" ></span><?php echo $user['firstname']." ".$user['lastname'];?></span><span style="float:right"><a href="#" data-id ="{{ $user['id']}}" class="liclick liclick_<?php echo $user['id'];?>"><i class="icon-pencil icons" style="color:green;" title="Edit"></i></a>&nbsp;&nbsp;<a href="#" class="deletemodelStaffShow"  data-toggle="modal"  data-target="#deleteStaffModal" data-user_id="<?php echo $user['id'];?>" title="Delete"><i class="icon-close icons" style="color:red;" ></i></a></span> </li>
                    <?php endforeach;
					 endif;?>
                  </ul>
                </form>
              </div>
            </div>
          </div>
         <div class="col-lg-9 col-md-9"><button type="button" class="btn pull-right btn-purple waves-effect waves-light" id="add_new"> <i class="fa fa-plus"></i> Add New</button></div>
          <div class="col-lg-9 col-md-9 content-height" id="add_user" >
            <div class="top-info"> <span> <i class="fa fa-user"></i> <span id="position_nameDiv">Add New </span> </span> </div>
            {!! Form::open(array('url' => '#','id'=>'Addform','class'=>'form-horizontal m-t-20')) !!}
            <ul class="nav nav-tabs">
              <li class="active"> <a href="#addl1" data-toggle="tab" aria-expanded="false" > <span class="visible-xs"><i class="fa fa-users" aria-hidden="true"></i></span> <span class="hidden-xs"><i class="fa fa-users" aria-hidden="true"></i> Employee Details</span> </a> </li>
              <li > <a href="#addl2" data-toggle="tab" aria-expanded="true" > <span class="visible-xs"><i class="fa fa-location-arrow" aria-hidden="true"></i></span> <span class="hidden-xs"><i class="fa fa-location-arrow" aria-hidden="true"></i> Locations </span> </a> </li>
              <li class=""> <a href="#addl3" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="fa fa-star" aria-hidden="true"></i></span>   <span class="hidden-xs"><i class="fa fa-star" aria-hidden="true"></i> Positions</span> </a> </li>
              <li class=""> <a href="#addl4" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-usd" aria-hidden="true"></i></span> <span class="hidden-xs"><i class="fa fa-usd" aria-hidden="true"></i>  Salary / Wage</span> </a> </li>
            </ul>
            <div class="tab-content clearfix">
              <div class="box-header with-border" id="addsuccess"></div>
              <div class="box-header with-border" id="addfailure"></div>
              <div class="tab-pane active" id="addl1">
                <div class="staff-profile">
                  <div class="col-md-4 col-sm-4 col-xs-6">
                    <div class="row">
                      <div class="staff-photo"> <img src="{{ asset('images/noimage.png')}}" alt="" />
                        <div class="upload-photo">
                          <div class="fileupload btn btn-purple btn-block waves-effect waves-light"> <span><i class="ion-upload m-r-5"></i>Upload</span> {!! Form::file('profile_pic', ['class' => 'upload','id'=>'profile-image']) !!} </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="profile-form">
                      <h4  class="header-title m-t-0 m-b-20 col-md-12"><strong>Personal Information</strong></h4>
                      <div  class="col-md-6 col-sm-6">
                        <div class="form-group">
                          <label>First Name</label>
                          {!! Form::text('firstname',@$inputData['firstname'],array('class'=>'form-control','placeholder'=>'Firstname')) !!} </div>
                      </div>
                      <div  class="col-md-6 col-sm-6">
                        <div class="form-group">
                          <label>Last Name</label>
                          {!! Form::text('lastname',@$inputData['lastname'],array('class'=>'form-control','placeholder'=>'Lastname')) !!} </div>
                      </div>
                      <div  class="col-md-6 col-sm-6">
                        <div class="form-group">
                          <label>Email address </label>
                          {!! Form::text('email',@$inputData['email'],array('class'=>'form-control','placeholder'=>'Email')) !!} </div>
                      </div>
                      <div  class="col-md-6 col-sm-6">
                        <div class="form-group">
                          <label>Contact No.</label>
                          {!! Form::text('business_contact_no',@$inputData['business_contact_no'],array('class'=>'form-control','placeholder'=>'Contact No.','maxlength'=>'12','onkeypress'=>'return isNumber(event)')) !!} </div>
                      </div>
					  <div class="col-md-6 col-sm-6">
					 <div class="form-group">
						<label>Joining Date</label>
						<div class="input-group">
						{!! Form::text('start_date_with_company',@$inputData['start_date_with_company'],array('class'=>'form-control','id'=>'datepicker-inline1','placeholder'=>'Joining Date')) !!}
						<span class="input-group-addon bg-custom b-0 text-white"><i class="icon-calender"></i></span>
						</div>
					 </div>
			     </div>
                      <div  class="col-md-6 col-sm-6">
                        <div class="form-group">
                          <label>Gender</label>
                          <div>
                            <div class="radio radio-info radio-inline">
                              <input id="inlineRadio1" value="1" name="gender" type="radio">
                              <label for="inlineRadio1"> Male</label>
                            </div>
                            <div class="radio radio-info radio-inline">
                              <input id="gender" value="2" name="gender" type="radio">
                              <label for="inlineRadio2">Female</label>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="clear"></div>
                  <hr>
                  <div class="row">
                    <div class="col-md-12">
                   <h4  class="header-title m-t-0 m-b-20 col-md-12"><strong>Access Privileges</strong></h4>
                    <div class="form-group col-md-12 col-sm-12">
                      <?php if(Session::get('Users.type')==1): ?>
                      <div class="radio radio-info radio-inline">
                        <input id="inlineRadio4"  name="type" value="1" checked="" type="radio">
                        <label for="inlineRadio4"> Administrator </label>
                      </div>
                      <div class="radio radio-info radio-inline">
                        <input id="inlineRadio5"  name="type" value="2" checked="" type="radio">
                        <label for="inlineRadio5"> Manager </label>
                      </div>
                      <?php endif; ?>
                      <div class="radio radio-info radio-inline">
                        <input id="inlineRadio6"  name="type" value="3" checked="" type="radio">
                        <label for="inlineRadio6"> Employee </label>
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                      <div class="form-group">
                        <label>Employee ID</label>
                        {!! Form::text('employee_id',@$inputData['employee_id'],array('class'=>'form-control','placeholder'=>'Employee ID')) !!} </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                      <div class="form-group">
                        <label>Date of Birth</label>
                        <div class="input-group"> {!! Form::text('dob',@$inputData['dob'],array('class'=>'form-control','id'=>'datepicker-inline','placeholder'=>'Date Of Birth')) !!} <span class="input-group-addon bg-custom b-0 text-white"><i class="icon-calender"></i></span> </div>
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                      <div class="form-group">
                        <label>Emergency Contact</label>
                        {!! Form::text('emergency_contact',@$inputData['emergency_contact'],array('class'=>'form-control','placeholder'=>'Emergency Contact')) !!} </div>
                    </div>
                    <div class="col-md-6  col-sm-6">
                      <div class="form-group">
                        <label>Emergency Number</label>
                        {!! Form::text('emergency_number',@$inputData['emergency_number'],array('class'=>'form-control','placeholder'=>'Emergency Number','onkeypress'=>'return isNumber(event)')) !!} </div>
                    </div>
					<div class="col-md-12  col-sm-12">
					 <div class="form-group">
						<label>Additional Notes</label>
						{!! Form::textarea('notes',@$inputData['notes'],array('class'=>'form-control','rows' =>4,'placeholder'=>'Additional Notes')) !!}
					  </div>
					</div>
					  <div class="m-t-20 col-md-12">
						<button type="submit" class="btn btn-success waves-effect waves-light">Save & Send Invitation</button>
					  </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="addl2">
                <div class="positions-tab">
                  <h4>Select the locations that can work at:</h4>
                  <div>
                    <button type="button"  class="btn btn-white btn-custom waves-effect" id="AddLocationSelectAll">Select All</button>
                    <button  type="button" class="btn btn-white btn-custom waves-effect" id="AddLocationClearAll">Clear All</button>
                  </div>
                  <div class="location-list">
                    <div class="row">
                      <div class="check-design">
                        <?php 
									 if($Locationlist):
									    foreach($Locationlist as $location):
									 ?>
                        <div class="col-md-4 col-sm-5">
                          <div class="emp-name add_location_name_list ">
                            <label>
                              <input name="location_ids[]" type="checkbox" value="<?php echo $location['location_id'];?>" />
                              <?php echo $location['location_name'];?></label>
                          </div>
                        </div>
                        <?php endforeach;
									 endif; ?>
                      </div>
                    </div>
                  </div>
				   <div class="m-t-20 col-md-12">
                <button type="submit" class="btn btn-success waves-effect waves-light">Save & Send Invitation</button>
              </div>
                </div>
              </div>
              <div class="tab-pane" id="addl3">
                <div class="positions-tab">
                  <h4>Select the Positions for Staff:</h4>
                  <div>
                    <button type="button"  class="btn btn-white btn-custom waves-effect" id="AddPositionSelectAll">Select All</button>
                    <button  type="button" class="btn btn-white btn-custom waves-effect" id="AddPositionClearAll">Clear All</button>
                  </div>
                  <div class="location-list">
                    <div class="row">
                      <div class="check-design">
                        <?php 
							 if(@$PositionList):
								foreach($PositionList as $Position):
							 ?>
                        <div class="col-md-4 col-sm-4">
                          <div class="emp-name add_position_name_list">
                            <label>
                              <input name="position_ids[]" type="checkbox" value="<?php echo $Position['id'];?>" />
                              <?php echo $Position['position_name'];?></label>
                          </div>
                        </div>
                        <?php endforeach;
							 endif; ?>
                      </div>
                    </div>
                  </div>
				   <div class="m-t-20 col-md-12">
						<button type="submit" class="btn btn-success waves-effect waves-light">Save & Send Invitation</button>
					  </div>
                </div>
              </div>
              <div class="tab-pane" id="addl4">
                <div class="staff-list-main">
                  <div class="box-header with-border" class="addsuccess">
                </div>
                <div class="box-header with-border" class="addfailure">
              </div>
              <h4>For budgeting, set how much gets paid:</h4>
              <div class="rate">
                <div class="row m-t-20">
                  <div class="col-lg-12">
                    <ul class="nav nav-tabs ">
                      <li class="active tab"> <a href="#home-21" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-home"></i></span> <span class="hidden-xs">Hourly Wage </span> </a> </li>
                      <li class="tab"> <a href="#profile-21" data-toggle="tab" aria-expanded="false"> <span class="visible-xs "><i class="fa fa-user"></i></span> <span class="hidden-xs ">Yearly Salary </span> </a> </li>
                    </ul>
                    <div class="tab-content" style="padding: 30px 15px;">
                      <div class="tab-pane active custom-tab-style" id="home-21">
                        <p><span><strong>Standard Rate:</strong> $
                          <button type="button" class="editable editable-click addButton" >Set Rate</button>
                          <span class='TextBoxesGroup' style="display:none;">{!! Form::text('standard_rate',@$inputData['standard_rate'],array('class'=>'form-control-custom','placeholder'=>'Standard Rate/per hour','onkeypress'=>'return isNumber(event)')) !!} </span> <span class="removeButton" style="display:none">
                          <input type='button' value='Remove' class="btn btn-danger " style="padding: 4px 12px;">
                          </span> </p>
                        <p><span><strong>Saturday Rate:</strong> </span>$
                          <button type="button" class="editable editable-click addButton" >Set Rate</button>
                          <span class='TextBoxesGroup' style="display:none;">{!! Form::text('saturday_rate',@$inputData['saturday_rate'],array('class'=>'form-control-custom','placeholder'=>'Saturday Rate/per hour','onkeypress'=>'return isNumber(event)')) !!} </span> <span class="removeButton" style="display:none">
                          <input type='button' value='Remove' class="btn btn-danger "  style="padding: 4px 12px;">
                          </span> </p>
                        <p><span><strong>Sunday Rate:</strong> </span>$
                          <button type="button" class="editable editable-click addButton" >Set Rate</button>
                          <span class='TextBoxesGroup' style="display:none;">{!! Form::text('sunday_rate',@$inputData['sunday_rate'],array('class'=>'form-control-custom','placeholder'=>'Sunday Rate/per hour','onkeypress'=>'return isNumber(event)')) !!} </span> <span class="removeButton" style="display:none">
                          <input type='button' value='Remove' class="btn btn-danger" style="padding: 4px 12px;">
                          </span> </p>
                        <p><span><strong>Holiday Rate:</strong> </span>$
                          <button type="button" class="editable editable-click addButton" >Set Rate</button>
                          <span class='TextBoxesGroup' style="display:none;"> {!! Form::text('holiday_rate',@$inputData['holiday_rate'],array('class'=>'form-control-custom','placeholder'=>'Holiday Rate/per hour','onkeypress'=>'return isNumber(event)')) !!} </span> <span class="removeButton" style="display:none">
                          <input type='button' value='Remove' class="btn btn-danger" style="padding: 4px 12px;">
                          </span> </p>
                        <p><span><strong>Overtime Rate:</strong> </span>$
                          <button type="button" class="editable editable-click addButton" >Set Rate</button>
                          <span class='TextBoxesGroup' style="display:none;"> {!! Form::text('overtime_rate',@$inputData['overtime_rate'],array('class'=>'form-control-custom','placeholder'=>'Overtime Rate/per hour','onkeypress'=>'return isNumber(event)')) !!} </span> <span class="removeButton" style="display:none">
                          <input type='button' value='Remove' class="btn btn-danger" style="padding: 4px 12px;">
                          </span> </p>
                      </div>
                      <div class="tab-pane  custom-tab-style" id="profile-21">
                        <p><strong>Yearly Rate:</strong> $
                          <button type="button" class="editable editable-click addButton" >Set Rate</button>
                          <span class='TextBoxesGroup' style="display:none;"> {!! Form::text('yearly_rate',@$inputData['yearly_rate'],array('class'=>'form-control-custom','placeholder'=>'Yearly Rate/per annum','onkeypress'=>'return isNumber(event)')) !!} </span> <span class="removeButton" style="display:none">
                          <input type='button' value='Remove' class="btn btn-danger " style="padding: 4px 12px;">
                          </span> </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="m-t-20 col-md-12">
                <button type="submit" class="btn btn-success waves-effect waves-light">Save & Send Invitation</button>
              </div>
            </div>
          </div>
        </div>
        {!! Form::close() !!} </div>
		<!-- Starts : Delete Staff-->
		<div class="modal fade" id="deleteStaffModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
		<div class="modal-content">
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close" > <span aria-hidden="true">&times;</span> </button>
		<h4 class="modal-title" id="myModalLabel">Confirm </h4>
		</div>
		{!! Form::open(array('url'=> '#','id'=>'DeleteStaffForm','class'=>'form-horizontal m-t-20')) !!}
		<div class="modal-body clearfix">
		<div class="row">
			<div class="positions-tab">
				<h4 id="successMessage">Are you sure you want to delete Staff ?</h4>
				<input type="hidden" name="user_id_todelete" id="user_id_todelete" value=""/>
			</div>
		</div>
		</div>
		<div class="modal-footer" >
		 <div id="btn_display">
			<button type="button" class="btn btn-danger" data-dismiss="modal" >Cancel</button>
			<button type="submit" class="btn btn-primary">Delete</button>
		 </div>
		 <div id="btn_display1" style="display:none;">
			 <button type="button" class="btn btn-danger" data-dismiss="modal" >OK</button>
		 </div>
		</div>
		{!! Form::close() !!}  
		</div>
		</div>
		</div>
		<!--Ends : Delete Staff-->
      <div class="col-lg-9 content-height"  id="edit_staff" > </div>
    </div>
  </div>
  <!-- container --> 
  
</div>
<!-- content --> 
<script>
            var resizefunc = [];
        </script> 
@include('elements.footer')
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('body').on('click','.deletemodelStaffShow', function(evt){
			var user_id = $(this).attr('data-user_id');
			$('#user_id_todelete').val(user_id);
			$('#btn_display1').hide();
			$('#btn_display').show();
			$('#successMessage').html('Are you sure you want to delete staff ?');
		});
		$('body').on('submit', '#DeleteStaffForm', function(evt){
		evt.preventDefault();
		var data = new FormData(this);
		var user_id_todelete = $('#user_id_todelete').val();
		evt.preventDefault();		
		$.ajax({
			url: "{{ url('Staff/DeleteStaff') }}",
			type: 'POST',
			data:data,
			dataType: 'json',
			cache: false,
			processData: false,
			contentType: false,
			async: false,
			success: function(res){
				$('#successMessage').text(res.message);
				$('.liStaffDiv'+user_id_todelete).remove();
				$('#AddFormDiv').show();
				$('#EditFormDiv').hide();
				$('#btn_display1').show();
				$('#btn_display').hide();
			}
		});
	});	
	$('body').on('click','#searchStaff', function(evt){
		var name = $('input[name="searchStaff"]').val();
		$.ajax({
			url: "{{ url('/StaffSearch') }}",
			type: 'POST',
			data:{name:name},
			dataType: 'html',
			async: false,
			success: function(res){
				$('#userlists').html(res);
			}
		});
	});
	//For Rates
	$("body").on('click','.addButton',function () {
		$(this).hide();
		$(this).siblings('body .TextBoxesGroup').show();
		$(this).siblings("body .removeButton").show();
    });
    $("body").on('click','.removeButton',function () {
		$(this).hide();
		$(this).siblings('body .TextBoxesGroup').find('.form-control').val('');
		$(this).siblings('body .editable').show();
		$(this).siblings('body .TextBoxesGroup').hide();
		$(this).siblings("body .removeButton").hide();
    });
	//Ends For Rates
	
	$('body #AddLocationSelectAll').click(function(){
		$('.add_location_name_list input').attr('checked', true);
		$('.add_location_name_list label').addClass("checked");
	});
	$('body #AddLocationClearAll').click(function(){
		$('.add_location_name_list input').attr('checked', false);
		$('.add_location_name_list label').removeClass("checked");
	});
	$('body').on('click','#EditLocationSelectAll',function(){
		$('.edit_location_name_list input').attr('checked', true);
		$('.edit_location_name_list label').addClass("checked");
	});
	$('body').on('click','#EditLocationClearAll',function(){
		$('.edit_location_name_list input').attr('checked', false);
		$('.edit_location_name_list label').removeClass("checked");
	});
	$('body #AddPositionSelectAll').click(function(){
		$('.add_position_name_list input').attr('checked', true);
		$('.add_position_name_list label').addClass("checked");
	});
	$('body #AddPositionClearAll').click(function(){
		$('.add_position_name_list input').attr('checked', false);
		$('.add_position_name_list label').removeClass("checked");
	});
	$('body').on('click','#EditPositionSelectAll',function(){
		$('.edit_position_name_list input').attr('checked', true);
		$('.edit_position_name_list label').addClass("checked");
	});
	$('body').on('click','#EditPositionClearAll',function(){
		$('.edit_position_name_list input').attr('checked', false);
		$('.edit_position_name_list label').removeClass("checked");
	});
		
	$('#add_new').on('click', function(evt){
		$('#add_user').show();
		$('#edit_staff').hide();
	});
	$('body').on('click','.liclick', function(evt){
		var id = $(this).attr('data-id');
		var token = $('#liclickForm input[name="_token"]').val();
		
		$.ajax({
			url: "{{ url('/EditStaffContent') }}",
			type: 'POST',
			data:{id:id,_token :token},
			dataType: 'html',
			success: function(res){
				$('#edit_staff').show();
				$('#edit_staff').html(res);
				$('body #editdatepicker1').datepicker({
                	autoclose: true,
                	todayHighlight: true
                });
				$('body #editdatepicker1').trigger('click');
				$('body #editdatepicker1').datepicker('refresh');
				$('body #editdatepicker').datepicker({
                	autoclose: true,
                	todayHighlight: true
                });
				$('#add_user').hide();
			}
		});
	});
	//Add New Staff
	$('body').on('submit', '#Addform', function(evt){
		var data = new FormData(this); 
		evt.preventDefault();
		$.ajax({
			url: "{{ url('/StaffAdd') }}",
			type: 'POST',
			data:data,
			dataType: 'json',
			cache: false,
			processData: false,
			contentType: false,
			async: false,
			success: function(res){
				if (res.Status=='success') {
					$('#addsuccess').html('<div class="alert alert-success  alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>' + res.message + '</span></div>');
					$('#userlists').prepend(res.li);
				} else {
					$('#addsuccess').html('');
				}
				if (res.Status=='danger') {
					$('#addfailure').html('<div class="alert alert-danger  alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>' + res.message + '</span></div>');
				} else {
					$('#addfailure').html('');
				}
			}
		});
	});
	$('body').on('submit', '#editform', function(evt){
		var data = new FormData(this); 
		evt.preventDefault();
		var hidden_id = $('body #hidden_id').val();
		$.ajax({
			url: "{{ url('/EditStaff') }}",
			type: 'POST',
			data:data,
			dataType: 'json',
			cache: false,
			processData: false,
			contentType: false,
			async: false,
			success: function(res){
				if (res.Status=='success'){
					$('#editsuccess').html('<div class="alert alert-success  alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>' + res.message + '</span></div>');
					$('body').find('.liStaffNameDiv'+hidden_id).html(res.li);
					$('body').find('#edit_image').attr("src",res.image_path);
				} else{
					$('#editsuccess').html('');
				}
				if (res.Status=='danger'){
					$('#editfailure').html('<div class="alert alert-danger  alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>' + res.message + '</span></div>');
				} else{
					$('#editfailure').html('');
				}
			}
		});
	});
	
});
function isNumber(evt) {
	evt = (evt) ? evt : window.event;
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	if (charCode > 31 && (charCode < 48 || charCode > 57)) {
		return false;
	}
	return true;
}
</script> 
<!-- ============================================================== --> 
<!-- End Right content here --> 
<!-- ============================================================== -->

</div>
<!-- END wrapper --> 

@stop 