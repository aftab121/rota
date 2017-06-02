@extends('layouts.home')
@section('title', 'Organization')
@section('content') 
<!-- Begin page -->
<div id="wrapper"> @include('elements.TopNav')
  @include('elements.sidebar')
<style>
.m-t-20
{
margin-top:20px;
}
.panel
{
border: 2px solid #4c5667;
width: 60px;
text-align: center;
}
.panel-inverse > .panel-heading
{
background-color: #4c5667;
color: #fff;
font-size: 16px;
font-weight: 600;
}
.panel .panel-body {
padding: 6px;
text-align: center;
font-size: 16px;
color: #545454;
font-weight: 600;
}
.panel-heading {
border-radius:0px;
padding: 6px 0px;
}
.media-left, .media > .pull-left {
padding-right: 25px;
}
.media {
    padding: 20px;
    border-bottom: 1px solid #e3e3e3;
   
    margin: 0;
}
#weekDays
{
display:inline-block;}
.no-roster {
    padding: 10px;
    line-height: 3;
    text-align: center;
    font-weight: bold;
    color: #616161;
}
</style>
<!-- ============================================================== --> 
<!-- Start right Content here --> 
<!-- ============================================================== -->


  <div class="content-page" style="margin-left:0px;"> 
    <!-- Start content -->
    <div class="content">
      <div class="container"> 
        <!-- Page-Title -->
        <div class="row">
          <div class="col-sm-12">
            <div class="page-header-2">
              <h4 class="page-title">Schedule</h4>
              <ol class="breadcrumb">
                <li> <a href="#">Home</a> </li>
                <li class="active"> Schedule </li>
              </ol>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-offset-3 col-md-6">
          <div class="card-box">
            <div class="row">
              <div class="col-md-9">
			    <div class="row">
				  <div class="col-md-12 all-btns"> 
						<button class="btn btn-sm btn-default decWeek" data-id = "-1" ><i class="fa fa-chevron-left"></i></button> 
						<div id="weekDays">
						<?php 
						$currentdate = date('M j');
						$endDate = date('M j',strtotime('-1 days'));
							$startDate = date('M j', strtotime("+1 days",strtotime($endDate)));
							$endDate = date('M j', strtotime("+6 days",strtotime($startDate)));
						?>
						<button class="btn btn-sm btn-default selectWeek" data-id ="0"><?php echo $startDate.' - '.$endDate;?></button>
						</div>
						<button class="btn btn-sm btn-default incWeek" data-id = "1"><i class="fa fa-chevron-right"></i></button>
				  </div>
				</div>
                
              </div>
              <div class="col-md-3">
                <button class="btn pull-right btn-sm btn-default selectWeek" data-id="0">Today</button>
              </div>
              </div>
               <div class="row" id="shiftLists">
              <div class="col-md-12 m-t-20">
			  <?php if(@$Shifts){
				  foreach($Shifts as $Shift):
				  ?>
                <div class="media">
                  <div class="media-left"> <a href="#">
                    <div class="panel panel-inverse">
                      <div class="panel-heading"><?php echo date('D',strtotime($Shift['shift_date'])); ?></div>
                      <div class="panel-body"><?php echo date('d',strtotime($Shift['shift_date'])); ?></div>
                    </div>
                    </a> </div>
                  <div class="media-body">
                    <h4 class="media-heading"><b> <i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $Shift['shift_start_time'].' - '.$Shift['shift_end_time']; ?></b></h4>
                    <p><i class="fa fa-user" aria-hidden="true"></i> <?php echo $Shift['position_name']; ?></p>
                    <p><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $Shift['location_name']; ?></p>
                  </div>
                </div>
			  <?php endforeach;
			  }else{?><div class="no-roster" ><div>There aren't any shifts this week.</div><div>If you are expecting to be rostered</div><div>try checking again later...</div></div>
			  <?php } ?>
			 </div>
            </div>
          </div></div>
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
<script type="text/javascript">
function refresh(current_back){
	current_back = parseInt(current_back);
	$.ajax({
		url: "{{ url('/employeeSchedule') }}",
		type: 'POST',
		data:{current_back:current_back},
		dataType: 'html',
		async: false,
		success: function(res){
			$('#shiftLists').html(res);
			$('#shift_currentback').val(current_back);
			
		}
	});
}
//refresh(0);
$(document).ready(function(){
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
});
</script>
<!-- ============================================================== --> 
<!-- End Right content here --> 
<!-- ============================================================== -->
</div>
<!-- END wrapper --> 
@stop 