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
							<h4 class="page-title">Position</h4>
							<ol class="breadcrumb">
								<li>
									<a href="#">Home</a>
								</li>
								<li class="active">
									Position
								</li>
							</ol>
						</div>
					</div>
				</div>
				<div class="row">
				  <div class="col-md-3">
					  <div class="store-location-list">
						  <form>
							<div class="input-group m-b-10">
							  <input type="text"  class="form-control" name="searchPosition" placeholder="Search..." style="height:40px;">
							  <div class="input-group-btn">
								<button class="btn btn-default btn-block" type="button" id="searchPosition" ><i class="fa fa-search"></i></button>
							  </div>
							</div>
						  </form>
						  
						  <div class="store-list staff-all">
							<form id="liclickForm">
								{{csrf_field()}} 
							 <ul id="userlists">
							 <?php if($Positionlist):
							  foreach($Positionlist as $Position):
							 ?>
							 <li class="liDiv_<?php echo $Position['id'];?>"><span class="liPositionNameDiv<?php echo $Position['id'];?>"><?php echo $Position['position_name'];?></span><span style="float:right"><a href="#" data-id ="{{ $Position['id']}}" class="liclick liclick_<?php echo $Position['id'];?>"><i class="icon-pencil icons" style="color:green;"></i></a>&nbsp;&nbsp;<a href="#" class="deletemodelPositionShow"  data-toggle="modal"  data-target="#deletePositionModal" data-position_id="<?php echo $Position['id'];?>"><i class="icon-close icons" style="color:red;"></i></a></span></li>
							 <?php endforeach;
							 endif;?>
							 </ul>
						  </form>
						  </div>
					  </div>
				  </div>
				<div class="col-lg-9">
					
					
					<button type="button" class="btn btn-purple waves-effect waves-light pull-right" id="addPosition"> <i class="fa fa-plus"></i>  Add New</button></div>
				  <div class="col-lg-9 content-height" id="AddFormDiv">
						<div class="top-info">
						 <span> <i class="fa fa-star"></i> <span id="position_nameDiv">Add New </span> </span>
						 
					    </div>
						<div >
						{!! Form::open(array('url' =>'#','id'=>'addPositionForm','class'=>'form-horizontal m-t-20')) !!} 
						<ul class="nav nav-tabs">
						  <li class="active"> <a href = "#l1" data-toggle = "tab" aria-expanded = "false"> <span class="visible-xs"><i class="fa fa-star" aria-hidden="true"></i></span> <span class="hidden-xs"><i class="fa fa-star" aria-hidden="true"></i> Position Details</span> </a> </li>
						  <li > <a href = "#l2" data-toggle="tab" aria-expanded = "true"> <span class="visible-xs"><i class="fa fa-location-arrow" aria-hidden="true"></i></span> <span class="hidden-xs"><i class="fa fa-map-marker" aria-hidden="true"></i> Locations for this position</span> </a> </li>
						  <li class=""> <a href="#l3" data-toggle = "tab" aria-expanded = "false"><span class="visible-xs"><i class="fa fa-users" aria-hidden="true"></i></span> <span class="hidden-xs"> <i class="fa fa-users" aria-hidden="true"></i>  Employees in the X position </span> </a> </li>
						</ul>
				    
					<div class="tab-content clearfix">
					  <div class="box-header with-border" id="addsuccess"></div>
					  <div class="box-header with-border" id="addfailure"></div>
					  <div class="tab-pane active" id="l1">
					    <div class="positions-tab">
						  <div class="form-group">
							  <div class="row">
							<label for="location-name" class="control-label col-md-12 col-sm-12">Position name</label>
							<div class="col-md-6 col-sm-6">
							  {!! Form::text('position_name',@$inputData['position_name'],array('class'=>'form-control','placeholder'=>'Position name')) !!}
							</div>
							</div>
						  </div>
						</div>
					  </div>
					  <div class="tab-pane" id="l2">
					   <div class="positions-tab">
						   <h4>Select the locations that have the Manager position:</h4>
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
									 <div class="col-md-4 col-sm-4">
										 <div class="emp-name add_location_name_list ">
											 <label> <input name="location_ids[]" type="checkbox" value="<?php echo $location['location_id'];?>" /><?php echo $location['location_name'];?></label>
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
							 <h4>Select the staff that can work in the Manager position:</h4>
							 <div>
								<button type="button" class="btn btn-white btn-custom waves-effect" id="AddStaffSelectAll">Select All</button>
								<button type="button" class="btn btn-white btn-custom waves-effect"  id="AddStaffClearAll">Clear All</button>
							 </div>
							 <div class="staff-list">
								 <div class="row">
							 <div class="check-design">
								 <?php 
								 if($Stafflist):
									foreach($Stafflist as $Staff):
								 ?>
								 <div class="col-md-4 col-sm-4">
									 <div class="emp-name add_staff_name_list ">
										 <label> <input name="staff_ids[]" type="checkbox" value="<?php echo $Staff['id'];?>" /><?php echo $Staff['firstname'].' '.$Staff['lastname'];?></label>
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
				    {!! Form::close() !!}
					 </div>
				  </div>
<!--Starts : Delete Position -->
<div class="modal fade" id="deletePositionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" > <span aria-hidden="true">&times;</span> </button>
        <h4 class="modal-title" id="myModalLabel">Confirm </h4>
      </div>
      {!! Form::open(array('url'=> '#','id'=>'DeletePositionsForm','class'=>'form-horizontal m-t-20')) !!}
      <div class="modal-body clearfix">
        <div class="row">
			<div class="positions-tab">
				<h4 id="successMessage">Are you sure you want to delete Position <span id= "span_position_title"></span> ?</h4>
				<input type="hidden" name="positon_id_todelete" id="positon_id_todelete" value=""/>
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
  <!--Ends : Delete Position-->
				  <div id="EditFormDiv"></div>
				</div>
			</div> <!-- container -->
		</div> <!-- content -->
		<script>
		var resizefunc = [];
		</script>
		@include('elements.footer')
	<script type="text/javascript">
	$('body').on('click','#searchPosition', function(evt){
		var name = $('input[name="searchPosition"]').val();
		$.ajax({
			url: "{{ url('Position/Search') }}",
			type: 'POST',
			data:{name:name},
			dataType: 'html',
			async: false,
			success: function(res){
				$('#userlists').html(res);
			}
		});
	});
	$('body').on('click','#searchPosition', function(evt){
		var name = $('input[name="searchPosition"]').val();
		$.ajax({
			url: "{{ url('Position/Search') }}",
			type: 'POST',
			data:{name:name},
			dataType: 'html',
			async: false,
			success: function(res){
				$('#userlists').html(res);
			}
		});
	});
	$('body').on('submit', '#DeletePositionsForm', function(evt){
		evt.preventDefault();
		var data = new FormData(this);
		var positon_id_todelete = $('#positon_id_todelete').val();
		evt.preventDefault();		
		$.ajax({
			url: "{{ url('/DeletePositions') }}",
			type: 'POST',
			data:data,
			dataType: 'json',
			cache: false,
			processData: false,
			contentType: false,
			async: false,
			success: function(res){
				$('#successMessage').text(res.message);
				$('.liDiv_'+positon_id_todelete).remove();
				//$('#deletePositionModal').modal('hide');
				//$('#deleteMessagePositionModal').modal('show');
				$('#btn_display1').show();
				$('#btn_display').hide();
			}
		});
	});	
	$('body').on('click','.liclick', function(evt){
		var id = $(this).attr('data-id');
		var token = $('#liclickForm input[name="_token"]').val();
		$.ajax({
			url: "{{ url('/Position/EditForm') }}",
			type: 'POST',
			data:{id:id,_token :token},
			dataType: 'html',
			success: function(res){
				$('#liclickForm li').text()
				$('#position_nameDiv').text($(this).text());
				$('#AddFormDiv').hide();
				$('#EditFormDiv').show();
				$('#EditFormDiv').html(res);
			}
		});
	});
	
	$(document).ready(function () {
		$('body').on('click','.deletemodelPositionShow', function(evt){
			var position_id = $(this).attr('data-position_id');
			$('#positon_id_todelete').val(position_id);
			$('#btn_display1').hide();
			$('#btn_display').show();
			$('#successMessage').html('Are you sure you want to delete Position ?');
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
		$('body').on('click','#EditLocationSelectAll',function(){
			$('.edit_location_name_list input').attr('checked', true);
			$('.edit_location_name_list label').addClass("checked");
		});
		$('body').on('click','#EditLocationClearAll',function(){
			$('.edit_location_name_list input').attr('checked', false);
			$('.edit_location_name_list label').removeClass("checked");
		});
		
		$('body #AddStaffSelectAll').click(function(){
			console.log($('.add_location_name_list input'));
			$('.add_staff_name_list input').attr('checked', true);
			$('.add_staff_name_list label').addClass("checked");
		});
		$('body #AddStaffClearAll').click(function(){
			$('.add_staff_name_list input').attr('checked', false);
			$('.add_staff_name_list label').removeClass("checked");
		});
		$('body #AddLocationSelectAll').click(function(){
			$('.add_location_name_list input').attr('checked', true);
			$('.add_location_name_list label').addClass("checked");
		});
		$('body #AddLocationClearAll').click(function(){
			$('.add_location_name_list input').attr('checked', false);
			$('.add_location_name_list label').removeClass("checked");
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
				url: "{{ url('/Position/Edit') }}",
				type: 'POST',
				data:data,
				dataType: 'json',
				cache: false,
				processData: false,
				contentType: false,
				async: false,
				success: function(res){
					$('body').find('.liPositionNameDiv'+hidden_id).html(res.li);
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
		$('body').on('submit', '#addPositionForm', function(evt){
			var data = new FormData(this); 
			evt.preventDefault();
			$.ajax({
				url: "{{ url('/Position') }}",
				type: 'POST',
				data:data,
				dataType: 'json',
				cache: false,
				processData: false,
				contentType: false,
				async: false,
				success: function(res){
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
	</script>
	</div>
	<!-- ============================================================== -->
	<!-- End Right content here -->
	<!-- ============================================================== -->
</div>
<!-- END wrapper -->
@stop
