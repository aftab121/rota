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
.panel-custom h2
{
	font-size: 17px;
    color: #fff;
    margin: 0;
    text-transform: Capitalize;
}

.nav-tabs > li.active > a, .nav-tabs > li.active > a:focus, .nav-tabs > li.active > a:hover, .tabs-vertical > li.active > a, .tabs-vertical > li.active > a:focus, .tabs-vertical > li.active > a:hover
{
color:#fff !important;}
.nav.nav-tabs > li > a:hover, .nav.tabs-vertical > li > a:hover {
 color: #fff !important; 
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
          <div class="col-md-3 col-sm-12">
            <div class="panel panel-color panel-custom">
              <div class="panel-heading">
                <h3 style="cursor:pointer;" class="panel-title"  data-toggle="modal" data-target="#myModal1"><i class="fa fa-chevron-circle-down" aria-hidden="true"></i> Publish & Notify</h3>
              </div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-md-12">
                    <p class="text-uppercase label-p">Select location</p>
                    <select name="location_id" id="location_id" class="form-control">
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
                    <div>
                      <button  class="btn btn-white active employee_btn" >Employees</button>
                      <button class="btn btn-white active position_btn">Position</button>
                    </div>
                    <input type="hidden" name="type_set" id="type_set" value=""/>
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
                        <td>0</td>
                      </tr>
                      <tr>
                        <td>Filled Shifts</td>
                        <td>0</td>
                      </tr>
                      <tr>
                        <td>Filled Hours</td>
                        <td>0</td>
                      </tr>
                      <tr>
                        <td>Total cost</td>
                        <td>$ 0</td>
                      </tr>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="budget-left">
              <div class="col-md-12"> Sales </div>
              <div class="col-md-12"> Labour cost </div>
              <div class="col-md-12"> Labour Hour </div>
              <div class="col-md-12"> Sales Per Hour </div>
              <div class="col-md-12"> Labour Variation * </div>
              <div class="col-md-12"> Labour percentage * </div>
            </div>
          </div>
          <!-- publish and notify modal-->
          <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel">Publish for Location</h4>
                </div>
                <div class="modal-body">
                  <div> 
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                      <li role="presentation" class="active"><a href="#home" class="btn btn-default default-tab-style"  aria-controls="home" role="tab" data-toggle="tab">Publish by person</a></li>
                      <li role="presentation"><a href="#profile" class="btn btn-default default-tab-style"  aria-controls="profile" role="tab" data-toggle="tab">Publish by position</a></li>
                    </ul>
                    
                    <!-- Tab panes -->
                    <div class="tab-content padd-15">
                      <div role="tabpanel" class="tab-pane active" id="home">
                        <div class="positions-tab">
                          <div class="row">
                            <div class="col-md-12">
                              <div>
                                <button type="button"  class="btn btn-white btn-custom waves-effect" id="AddPositionSelectAll">Select All</button>
                                <button  type="button" class="btn btn-white btn-custom waves-effect" id="AddPositionClearAll">Clear All</button>
                              </div>
                            </div>
                          </div>
                          <div class="location-list">
                            <div class="row">
                              <div class="check-design">
                                <div class="col-md-6  col-sm-12">
                                  <div class="emp-name add_staff_name_list ">
                                    <label>
                                      <input name="staff_ids[]" type="checkbox" />
                                      komal singh </label>
                                  </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                  <div class="emp-name add_staff_name_list ">
                                    <label>
                                      <input name="staff_ids[]" type="checkbox" />
                                      Hashir Faizy </label>
                                  </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                  <div class="emp-name add_staff_name_list ">
                                    <label>
                                      <input name="staff_ids[]" type="checkbox" />
                                      Afsana Saleem </label>
                                  </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                  <div class="emp-name add_staff_name_list ">
                                    <label>
                                      <input name="staff_ids[]" type="checkbox" />
                                      Tquqeer Ahemad </label>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div role="tabpanel" class="tab-pane" id="profile">...</div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary">Submit</button>
                </div>
              </div>
            </div>
          </div>
          <!-- publish and notify modal-->
          <div class="col-md-9">
            <div class="row">
              <div class="col-md-12 all-btns">
                <button class="btn btn-sm btn-default decWeek" data-id = "-1" ><i class="fa fa-chevron-left"></i></button>
                <!---->
                <div  id="weekDays">
                  <?php 
					$currentdate = date('M j');
					$endDate = date('M j',strtotime('-1 days'));
					for($i= 0;$i<=4;$i++){ 
						$startDate = date('M j', strtotime("+1 days",strtotime($endDate)));
						$endDate = date('M j', strtotime("+6 days",strtotime($startDate)));
					?>
                  <button class="btn btn-sm btn-default selectWeek" data-id ="<?php echo $i; ?>"><?php echo $startDate.' - '.$endDate;?></button>
                  <?php }?>
                </div>
                <button class="btn btn-sm btn-default incWeek" data-id = "5"><i class="fa fa-chevron-right"></i></button>
              </div>
            </div>
            <div class="row">
              <input id="shift_currentback" name="shift_currentback" type="hidden" value="" class="form-control" >
              <div class="col-md-12" id="tableView"> </div>
            </div>
          </div>
        </div>
      </div>
      <!-- container --> 
      
    </div>
  </div>
  <!-- content --> 
  <script>
  var resizefunc = [];
</script> 
  @include('elements.footer') </div>
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
			$('#shift_currentback').val(current_back);
			$("#myModal").removeClass("in");
			$(".modal-backdrop").remove();
			$("#myModal").hide();
			$("#myEditModal").removeClass("in");
			$(".modal-backdrop").remove();
			$("#myEditModal").hide();
		}
	});
}
refresh(0);
$(document).ready(function(){
	$('body').on('click','.employee_btn', function(evt){
		$('#type_set').val('staff');
		var current_back = $('#current_back').val();
		refresh(current_back);
	});
	$('body').on('click','.position_btn', function(evt){
		$('#type_set').val('position');
		var current_back = $('#current_back').val();
		refresh(current_back);
	});
    $('body').on('click','.selectWeek', function(evt){
		var current_back = $(this).attr('data-id');
		refresh(current_back);
	});
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
	$('body').on('submit', '#EditShiftForm', function(evt){
		var data = new FormData(this); 
		evt.preventDefault();
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
				setTimeout(function () { refresh(shift_currentback); }, 2000);
			}
		});
	});
	$('body').on('submit', '#AddShiftForm', function(evt){
		var data = new FormData(this); 
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
				setTimeout(function () { refresh(shift_currentback); }, 2000);
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
		$('body').on('click','.EditmodelShow', function(evt){
			var position_id = $(this).attr('data-position_id');
			$('#shift_position_id').val(position_id);
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