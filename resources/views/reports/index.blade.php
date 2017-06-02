@extends('layouts.home')
@section('title', 'Organization')
@section('content') 
<!-- Begin page -->
<div id="wrapper"> @include('elements.TopNav')
  @include('elements.sidebar') 
  
  <!-- ============================================================== --> 
  <!-- Start right Content here --> 
  <!-- ============================================================== -->
<style>

 .report-list ul li
 {
 list-style:none;
 border-bottom:1px solid #e4e4e4;
 padding: 14px 15px;
 }
 .report-list ul li:hover
 {
	 background:#5fbeaa;
	 color:#fff;
 }
 .report-list
 {
 max-height: 450px;
overflow: auto;
height: 450px;
 }
 .report-list ul
 {
 padding-left:0px;}
  .report-list ul li p
 {
 margin:0px;}
#weekDays
{
display:inline-block;}
	.active_li{
		background: #5fbeaa;
		color: #fff;
	}
  </style>
  <div class="content-page" style="margin-left:0px;"> 
    <!-- Start content -->
    <div class="content">
      <div class="container"> 
        <!-- Page-Title -->
        <div class="row">
          <div class="col-sm-12">
            <div class="page-header-2">
              <h4 class="page-title">Reports</h4>
              <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li class="active">Reports</li>
              </ol>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="back clearfix">
            <div class="col-md-8 col-sm-8 roster"  >
              <h4 class="uppercase">Roster reports</h4>
              <div class="report-list">
              <ul>
                <li class="liClick" data-id="by_employee" >
                  <p><b>Roster By Employee</b></p>
                  <p><i>Generate roster by employee</i></p>
                </li>
                <li class="liClick employee" data-id="by_emp_condensed" >
                  <p><b>Roster By Employee (Condensed)</b></p>
                  <p><i>Generate roster by employee (portrait with smaller type)</i></p>
                </li>
                <li class="liClick" data-id="by_emp_enhanced" >
                  <p><b>Roster By Employee (Enhanced)</b></p>
                  <p><i>Generate roster by employee (landscape with calculated hours)</i></p>
                </li>
			     <li class="liClick" data-id="by_emp_locations">
                  <p><b>Roster By Employee (Multiple Locations)</b></p>
                  <p><i>Generate roster by employee across all locations (landscape with calculated hours)</i></p>
                </li>
                <li class="liClick" data-id="by_emp_position">
                  <p><b>Schedule By Position</b></p>
                  <p><i>(Generate roster by position)</i></p>
                </li>
                <li class="liClick" data-id="by_emp_multipleWeek">
                  <p><b>Employee Schedule(Multi-Week)</b></p>
                  <p><i>(Generate a listing of all availability grouped by employee)</i></p>
                </li>
              </ul>
              </div>
            </div>
			  <div class="col-md-8 col-sm-8 rosterReport" style="display:none;padding-left: 0;"></div>
            <div class="col-md-4 col-sm-4">
              <h4 class="uppercase m-b-20">Report Options</h4>
			 {!! Form::open(array('url'=> '#','id'=>'SearchForm','class'=>'form-horizontal m-t-20')) !!}
              <div class="row location_select" >
                <div class="col-md-12">
                  <div class="form-group clearfix">
                    <label>Locations</label>
                    <select name="location_id" id="location_id" class="form-control main_location_id">
					  <?php foreach($Locationlist as $Location): ?>
                      <option value="<?php echo $Location['location_id'];?>" ><?php echo $Location['location_name'];?></option>
					  <?php endforeach; ?>
                    </select>
                  </div>
                </div>
              </div>
			  <div class="row no_ofWeeks" style="display:none;">
                <div class="col-md-12">
                  <div class="form-group clearfix">
                    <label>Number of weeks *</label>
                    <input id="no_of_weeks" name="no_of_weeks" type="text" value="1" step="1" class="form-control" >
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Starting week</label>
                    <div>
                      <?php 
						$currentdate = date('M j');
						$endDate = date('M j',strtotime('-1 days'));
						$startDate = date('M j', strtotime("+1 days",strtotime($endDate)));
						$endDate = date('M j', strtotime("+6 days",strtotime($startDate)));
					  ?>
						<button type="button" class="btn btn-sm btn-default decWeek" data-id = "-1"><i class="fa fa-chevron-left"></i></button> 
						<div  id="weekDays">
						<button class="btn btn-sm btn-default selectWeek" data-id ="0"><?php echo $startDate.' - '.$endDate;?></button>
						</div>
						<input id="currentback" name="currentback" type="hidden" value="0" class="form-control" >
						<button type="button" class="btn btn-sm btn-default incWeek" data-id = "1"><i class="fa fa-chevron-right"></i></button>
						<input id="roster_by" name="roster_by" type="hidden" value="employee" class="form-control" >
                    </div>
                  </div>
                </div>
              </div>
              <div class="row location_select">
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Options</label>
                    <div>
                      <label>
                        <input type="checkbox" id="publish_shift" name="publish_shift">
                        Published shifts only </label>
                    </div>
                    <div>
                      <label>
                        <input type="checkbox" id="daily_notes" name="daily_notes">
                        Show daily notes </label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <button type="submit" class="btn col-md-12 btn-sm btn-default">Generate Report&nbsp;<i class="fa fa-chevron-right"></i></button>
                  </div>
                </div>
              </div>
			   {!! Form::close() !!}
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

<!-- ============================================================== --> 
<!-- End Right content here --> 
<!-- ============================================================== -->
<script type="text/javascript">
	$(document).ready(function(){
	
		$('body').on('click', '.back_menu', function(evt){
			$('.roster').css('display','block');
			$('.rosterReport').css('display','none');
		});
		$('body').on('click', '.printPdf', function(evt){
			evt.preventDefault();
			var data=$('.scroll-div1').html(); 
			
			$.ajax({
				url: "{{ url('/printReport') }}",
				type: 'POST',
				data:{data : data},
				
				success: function(res){
				
				}
			});
		});
		$('body').on('submit', '#SearchForm', function(evt){
			var data= new FormData(this); 
			if($('#publish_shift').prop("checked")==true){
				data.append('publish',1);		
			}else{
				data.append('publish',0);		
			}
			if($('#daily_notes').prop("checked")==true){
				data.append('notes',1);		
			}else{
				data.append('notes',0);		
			}
			evt.preventDefault();
			$.ajax({
				url: "{{ url('/GetData') }}",
				type: 'POST',
				data:data,
				dataType: 'html',
				cache: false,
				processData: false,
				contentType: false,
				async: false,
				success: function(res){
					$('.roster').css('display','none');
					$('.rosterReport').css('display','block');
					$('.rosterReport').html(res);
					
				}
			});
		});
		$('body').on('click','.liClick',function(evt){
			var liclick = $(this).attr('data-id');
			$('.liClick').removeClass('active_li');
			$(this).addClass('active_li');
			$('#roster_by').val(liclick);
			if(liclick=='by_emp_multipleWeek'){
				$('.no_ofWeeks').css('display','block');
				$('.location_select').css('display','none');
			}else{
				$('.no_ofWeeks').css('display','none');
				$('.location_select').css('display','block');
			}
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
					$('#currentback').attr('data-id', nth);
					$('#currentback').val(current_back);
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
					$('#currentback').val(current_back);
					var current  = $('body .selectWeek:first-child').attr('data-id');
					$('.decWeek').attr('data-id',parseInt(current)-1);
				}
			});
		});
	});
</script>
<!-- END wrapper --> 
@stop 