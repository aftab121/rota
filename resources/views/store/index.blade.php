@extends('layouts.home')
@section('title', 'Organization')
@section('content') 
<!-- Begin page -->
<div id="wrapper"> @include('elements.TopNav')
  @include('elements.sidebar') 
  <!-- ============================================================== --> 
  <!-- Start right Content here --> 
  <!-- ==
  ============================================================ -->
  <style>
  .input-group
  {
	  width:100%;
  }
  </style>
  <div class="content-page"> 
    <!-- Start content -->
    <div class="content">
      <div class="container"> 
        <!-- Page-Title -->
        <div class="row">
          <div class="col-sm-12">
            <div class="page-header-2">
              <h4 class="page-title">Location</h4>
              <ol class="breadcrumb">
                <li> <a href="#">Home</a> </li>
                <li class="active"> Location </li>
              </ol>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3 col-sm-3">
            <div class="store-location-list">
              <form>
                <div class="input-group m-b-10">
                  <input type="text"  class="form-control" name="searchLocation"  placeholder="Search...." style="height:40px;">
                  <div class="input-group-btn">
                    <button class="btn btn-default btn-block" type="button" id="searchLocation" ><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </form>
              <div class="store-list staff-all">
                <form  id="liclickForm">
                  {{csrf_field()}}
                  <ul id="userlists">
                    <?php if($Locationlist):
							  foreach($Locationlist as $Location):
							 ?>
                    <li data-id ="{{ $Location['location_id']}}" class="liclick liclick_<?php echo $Location['location_id'];?>"><?php echo $Location['location_name'];?> </li>
                    <?php endforeach;
							 endif;?>
                  </ul>
                </form>
              </div>
            </div>
          </div>
          <div class="col-md-9 col-sm-9">
            <button type="button" class="btn btn-purple pull-right waves-effect waves-light" id="addPosition"> <i class="fa fa-plus"></i> Add New</button>
          </div>
          <div class="col-md-9 content-height" id="AddFormDiv">
            <div class="top-info"> <span> <i class="fa fa-map-marker"></i> <span id="position_nameDiv">Add New </span> </span> </div>
            <div > {!! Form::open(array('url' => '#','id'=>'addLocationForm','class'=>'form-horizontal m-t-20')) !!}
              <ul class="nav nav-tabs">
                <li class="active"> <a href="#l1" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-cube" aria-hidden="true"></i></span> <span class="hidden-xs"><i class="fa fa-cube" aria-hidden="true"></i> Location Details</span> </a> </li>
                <li > <a href="#l2" data-toggle="tab" aria-expanded="true"> <span class="visible-xs"><i class="fa fa-map-marker" aria-hidden="true"></i></span> <span class="hidden-xs"><i class="fa fa-map-marker" aria-hidden="true"></i> Positions for this Location</span> </a> </li>
                <li class=""> <a href="#l3" data-toggle="tab" aria-expanded="false"><span class="visible-xs"> <i class="fa fa-location-arrow" aria-hidden="true"></i> </span><span class="hidden-xs"> <i class="fa fa-location-arrow" aria-hidden="true"></i> Employees who work at this Location </span> </a> </li>
              </ul>
              <div class="tab-content clearfix">
                <div class="box-header with-border" id="addsuccess"></div>
                <div class="box-header with-border" id="addfailure"></div>
                <div class="tab-pane active" id="l1">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="location-name" class="control-label">Location name</label>
                      <div> {!! Form::text('location_name',@$inputData['location_name'],array('class'=>'form-control','placeholder'=>'Location name')) !!} </div>
                    </div>
                  </div>
                  <div class="clear"></div>
                  <hr>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="location-name" class="control-label">Address</label>
                      <div> {!! Form::text('street_address',@$inputData['street_address'],array('class'=>'form-control','placeholder'=>'Address')) !!} </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="location-name" class="control-label">Country</label>
                      <div> {!! Form::select('country_id',$countries,@$CompanyDetails['country_id'],array('class'=>'form-control','placeholder'=>'Select Country'))!!} </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="location-name" class="control-label">State</label>
                      <div> {!! Form::text('state_name',@$inputData['state_name'],array('class'=>'form-control','placeholder'=>'State')) !!} </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="location-name" class="control-label">City</label>
                      <div> {!! Form::text('city',@$inputData['city'],array('class'=>'form-control','placeholder'=>'City')) !!} </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="location-name" class="control-label">Zip Code</label>
                      <div> {!! Form::text('zip_code',@$inputData['zip_code'],array('class'=>'form-control','placeholder'=>'Zip Code','onkeypress'=>'return isNumber(event)')) !!} </div>
                    </div>
                  </div>
                  <div class="clear"></div>
                  <hr>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Default Start Time</label>
                      <div class="input-group m-b-15">
                        <div class="bootstrap-timepicker"> {!! Form::text('default_start_time',@$inputData['default_start_time'],array('class'=>'form-control','id'=>'timepicker','placeholder'=>'Default Start Time')) !!} </div>
                        <span class="input-group-addon bg-custom b-0 text-white"><i class="glyphicon glyphicon-time"></i></span> </div>
                      <!-- input-group --> 
                      
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Default End Time</label>
                      <div class="input-group m-b-15">
                        <div class="bootstrap-timepicker"> {!! Form::text('default_end_time',@$inputData['default_end_time'],array('class'=>'form-control','id'=>'timepicker2','placeholder'=>'Default End Time')) !!} </div>
                        <span class="input-group-addon bg-custom b-0 text-white"><i class="glyphicon glyphicon-time"></i></span> </div>
                      <!-- input-group --> 
                      
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Default meal break</label>
                      <div class="input-group m-b-15">
                        <div class="bootstrap-timepicker"> {!! Form::number('default_meal_break',@$inputData['default_meal_break'],array('class'=>'form-control','min'=>10,'max'=>390,'step'=>20,'placeholder'=>'Default meal break')) !!} </div>
                      </div>
                      <!-- input-group --> 
                      
                    </div>
                  </div>
                </div>
                <div class="tab-pane" id="l2">
                  <div class="positions-tab">
                    <div class="row">
                      <div class="col-md-12">
                        <h4>Select the Positions at this Location:</h4>
                        <div>
                          <button type="button"  class="btn btn-white btn-custom waves-effect" id="AddPositionSelectAll">Select All</button>
                          <button  type="button" class="btn btn-white btn-custom waves-effect" id="AddPositionClearAll">Clear All</button>
                        </div>
                      </div>
                    </div>
                    <div class="location-list">
                      <div class="row">
                        <div class="check-design">
                          <?php 
									 if($Positionlist):
									    foreach($Positionlist as $Position):
									 ?>
                          <div class="col-md-4">
                            <div class="emp-name add_position_name_list ">
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
                  </div>
                </div>
                <div class="tab-pane" id="l3">
                  <div class="staff-list-main">
                    <div class="row">
                      <div class="col-md-12">
                        <h4>Select the staff that work in this location:</h4>
                        <div>
                          <button type="button" class="btn btn-white btn-custom waves-effect" id="AddStaffSelectAll">Select All</button>
                          <button type="button" class="btn btn-white btn-custom waves-effect"  id="AddStaffClearAll">Clear All</button>
                        </div>
                      </div>
                    </div>
                    <div class="staff-list">
                      <div class="row">
                        <div class="check-design">
                          <?php 
								 if($Stafflist):
									foreach($Stafflist as $Staff):
								 ?>
                          <div class="col-md-4">
                            <div class="emp-name add_staff_name_list ">
                              <label>
                                <input name="staff_ids[]" type="checkbox" value="<?php echo $Staff['id'];?>" />
                                <?php echo $Staff['firstname'].' '.$Staff['lastname'];?></label>
                            </div>
                          </div>
                          <?php endforeach;
								 endif; ?>
                        </div>
                        <div class="m-t-20 col-md-12">
                          <button type="submit" class="btn btn-success waves-effect waves-light">Save</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              {!! Form::close() !!} </div>
          </div>
          <div id="EditFormDiv"></div>
        </div>
      </div>
      <!-- container --> 
    </div>
    <!-- content --> 
    <script>
		var resizefunc = [];
		</script> 
    @include('elements.footer') 
    <script type="text/javascript">
	$('body').on('click','#searchLocation', function(evt){
		var name = $('input[name="searchLocation"]').val();
		$.ajax({
			url: "{{ url('Store/Search') }}",
			type: 'POST',
			data:{name:name},
			dataType: 'html',
			async: false,
			success: function(res){
				$('#userlists').html(res);
			}
		});
	});
	$('body').on('click','.liclick', function(evt){
		var id = $(this).attr('data-id');
		var token = $('#liclickForm input[name="_token"]').val();
		$.ajax({
			url: "{{ url('/Store/EditForm') }}",
			type: 'POST',
			data:{id:id,_token :token},
			dataType: 'html',
			success: function(res){
				$('#liclickForm li').text();
				$('#position_nameDiv').text($(this).text());
				$('#AddFormDiv').hide();
				$('#EditFormDiv').show();
				$('#EditFormDiv').html(res);
			}
		});
	});
	
	$(document).ready(function () {
		$('body #timepicker').timepicker({
			<?php if(Session::get('CompanyDetails.time_format')==12){?>
			defaultTIme : false
			<?php }else{?>
			showMeridian : false
			<?php } ?>
		});
		$('body #timepicker2').timepicker({
			<?php if(Session::get('CompanyDetails.time_format')==12){?>
			defaultTIme : false
			<?php }else{?>
			showMeridian : false
			<?php } ?>
		});	
		$('#addPosition').on('click', function(evt){
			$('#AddFormDiv').show();
			$('#position_nameDiv').text('Add New');
			$('#EditFormDiv').hide();
		});
		$('body').on('click','#EditStaffSelectAll',function(){
			$('.edit_staff_name_list input').attr('checked', true);
			$('.edit_staff_name_list label').addClass("checked");
		});
		$('body').on('click','#EditStaffClearAll',function(){
			$('.edit_staff_name_list input').attr('checked', false);
			$('.edit_staff_name_list label').removeClass("checked");
		});
		$('body').on('click','#EditPositionSelectAll',function(){
			$('.edit_position_name_list input').attr('checked', true);
			$('.edit_position_name_list label').addClass("checked");
		});
		$('body').on('click','#EditPositionClearAll',function(){
			$('.edit_position_name_list input').attr('checked', false);
			$('.edit_position_name_list label').removeClass("checked");
		});
		
		$('body #AddStaffSelectAll').click(function(){
			$('.add_staff_name_list input').attr('checked', true);
			$('.add_staff_name_list label').addClass("checked");
		});
		$('body #AddStaffClearAll').click(function(){
			$('.add_staff_name_list input').attr('checked', false);
			$('.add_staff_name_list label').removeClass("checked");
		});
		$('body #AddPositionSelectAll').click(function(){
			$('.add_position_name_list input').attr('checked', true);
			$('.add_position_name_list label').addClass("checked");
		});
		$('body #AddPositionClearAll').click(function(){
			$('.add_position_name_list input').attr('checked', false);
			$('.add_position_name_list label').removeClass("checked");
		});
		$('body').on('click','.emp-name input',function(){
			if($(this).is(":checked")) {
				$(this).parent().addClass("checked");
			} else {
				$(this).parent().removeClass("checked");
			}
		});
		$('body').on('submit', '#editPositionForm', function(evt){
			var data = new FormData(this); 
			evt.preventDefault();
			var hidden_id = $('#editPositionForm input[name="id"]').val();
			$.ajax({
				url: "{{ url('/Store/Edit') }}",
				type: 'POST',
				data:data,
				dataType: 'json',
				cache: false,
				processData: false,
				contentType: false,
				async: false,
				success: function(res){
					$('body').find('.liclick_'+hidden_id).html(res.li);
					if (res.Status=='success') {
						$('#editsuccess').html('<div class="row"><div class="col-md-12"><div class="alert alert-success  alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>' + res.message + '</span></div></div></div>');
					} else {
						$('#editsuccess').html('');
					}
					if (res.Status=='danger') {
						$('#editfailure').html('<div class="row"><div class="col-md-12"><div class="alert alert-danger  alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>' + res.message + '</span></div></div></div>');
					} else {
						$('#editfailure').html('');
					}
				}
			});
		});
		$('body').on('submit', '#addLocationForm', function(evt){
			var data = new FormData(this); 
			evt.preventDefault();
			$.ajax({
				url: "{{ url('/Store') }}",
				type: 'POST',
				data:data,
				dataType: 'json',
				cache: false,
				processData: false,
				contentType: false,
				async: false,
				success: function(res){
					console.log(res.li);
					$('#liclickForm ul').prepend(res.li);
					if (res.Status=='success') {
						$('#addsuccess').html('<div class="row"><div class="col-md-12"><div class="alert alert-success  alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>' + res.message + '</span></div></div></div>');
					} else {
						$('#addsuccess').html('');
					}
					if (res.Status=='danger') {
						$('#addfailure').html('<div class="row"><div class="col-md-12"><div class="alert alert-danger  alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>' + res.message + '</span></div></div></div>');
					} else {
						$('#addfailure').html('');
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
  </div>
  <!-- ============================================================== --> 
  <!-- End Right content here --> 
  <!-- ============================================================== --> 
</div>
<!-- END wrapper --> 
@stop 