  <style>
 .back
 {
	 background:#fff;
	 padding:20px 8px;
 }
.back .btn {
    border-radius: 0;
    outline: none !important;
    margin-right: 5px;
}
.back .btn:hover
{
border: 1px solid #5fbeaa !important;
background: #fff !important;
color: #5fbeaa !important;
}
.print-style
{
	border:2px solid #ccc;
	padding:20px 0px;
	text-align:center;
	margin:20px 0px;
	height:600px;
}
.print-date-tym
{
    text-align: left;
    font-size: <?php echo ($fontSize!='')?$fontSize:'13px';?>;
    text-transform: capitalize;
    color: #959595;
}
td,th
{
padding:8px;
font-size:<?php echo ($fontSize!='')?$fontSize:'13px';?>
	  text-align:left;}
	  
 .uppercase
 {
 text-transform: uppercase;
color: #3e3e3e;
font-weight: 600;
font-size: 18px;
border-bottom: 1px solid #eaeaea;
padding: 10px 0px;}
	  
#weekDays
{
display:inline-block;}
	  .days-info 
	  {
	  border-bottom:1px solid #ccc;}
	  .days-info p span
	  {
	  display:block;}
  </style>
  
<div class="row">
<div class="col-md-12">
  <div class="btn-group" role="group" aria-label="...">
	<button type="button" class="btn btn-default back_menu"><i class="fa fa-bars" aria-hidden="true"></i></button>
	<div class="btn-group" role="group">
	  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Export <span class="caret"></span> </button>
	  <ul class="dropdown-menu">
		<li><a href="{{ url('/printReport') }}" >Pdf</a></li>
	  </ul>
	</div>
	<!--<button type="button" class="btn btn-default"><i class="fa fa-search" aria-hidden="true"></i> Toggle zoom</button>-->
  </div>
</div>
</div>
<div class="row print-style ">
	<div class="col-md-12 ">
	  <p class="print-date-tym"> Printed : <?php echo date("jS F Y h:i A");?></p>
	  <table width="100%" border="0" cellspacing="5" cellpadding="5">
		<tr>
		  <td><h3 style="text-align:center;"><?php echo Session::get('CompanyDetails.company_name'); ?> - <?php echo date("jS F Y ",strtotime($start_date));?> - <?php echo date("jS F Y ",strtotime($end_date));?><?php echo ($publish==1)?'(published)':'';?></h3></td>
		
		  </tr>
		<?php if(empty($UserLists)){?>
		<tr>
		  <td><h4 style="color:red;">Oops, we could not find any <?php echo ($publish==1)?'published':'';?> shifts for this week</h4>
			<p>Try returning to the schedule </p></td>
		</tr>
	   <?php }?>
		  
	  </table>
	 <?php if(!empty($UserLists)){ ?>
	  <table width="100%" border="1"  cellpadding="7">
		<tr>
		  <td><strong>Name</strong></td>
		<?php  $total_hours=array();
								  for($i=0;$i<7;$i++){ $total_hours[$i]=0; echo '<td><strong>'; 
								  echo  date("jS F Y ",strtotime("+$i days",strtotime($start_date))); 
								  echo "</strong></td>"; } ?>
			<?php if($roster_by=='by_emp_enhanced'||$roster_by=='by_emp_locations'){ ?><td><strong>Total Hours</strong></td><?php }?>
		</tr>
		  
		 <?php foreach($UserLists as $User){ ?>
		<tr>
		  <td><?php echo $User['firstname'].' '.$User['lastname'];?></td>
		
	<?php $total_hrs_users = 0; for($i=0;$i<7;$i++){ 
	$currentDate= date("Y-m-d ",strtotime("+$i days",strtotime($start_date))); ?>
	<td>
	<?php  if(!empty($User['Shift'])){ ?> 
			
	<?php $total_hrs[$i] =0;
	foreach($User['Shift'] as $shift){
		?><?php if(strtotime($shift['shift_date'])==strtotime($currentDate)){
			if(strtotime($shift['shift_start_time'])!==strtotime($shift['shift_end_time'])){
					$diff = strtotime($shift['shift_start_time']) - strtotime($shift['shift_end_time']);
					$diff = abs($diff)- $shift['meal_break']*60;
					$diff_in_hrs = $diff/3600;
						
					$total_hrs_users = $total_hrs_users + abs($diff_in_hrs);
					$total_hours[$i] = $total_hours[$i]+abs($diff_in_hrs);
				}
		?>
			<div class="time-div clearfix" > <span class="pull-left"><?php echo date('h:i A',strtotime($shift['shift_start_time'])).' - '.date('h:i A',strtotime($shift['shift_end_time'])); ?><?php echo ($roster_by=='by_emp_enhanced'||$roster_by=='by_emp_locations')?('( '.$diff_in_hrs.' hrs )'):'';?></span><br>
            <span class="pull-left"><?php echo $shift['position_name']; ?></span>
			<span class="pull-left"><?php echo $shift['position_name']; ?></span>
          </div>
			<?php  } }?>
			 
		  <?php } else{?>
			&nbsp;
			  <?php } ?></td>
		  <?php } ?><?php if($roster_by=='by_emp_enhanced'||$roster_by=='by_emp_locations'){ ?>
		 <td><?php echo ($total_hrs_users!=0)?($total_hrs_users):'';?></td>
		  
			<?php } ?></tr>
		  <?php } ?><?php if($roster_by=='by_emp_enhanced'||$roster_by=='by_emp_locations'){ ?>
		  <tr>
			  <td><strong>Total Hours</strong></td>
		  <?php  for($i=0;$i<7;$i++){  ?><td><?php echo ($total_hours[$i]!=0)?($total_hours[$i]):'';?></td>
		  
		  <?php }?></tr>
		  <?php } ?>
	  </table>
	 <?php } ?>
	</div>

    <?php //print_r($notesData);die;
	if(!empty($notesData)){?>
<div class="col-md-12" style="text-align:left;margin-top:10px;"> 
<h3>Notes :</h3> 
	<?php foreach($notesData as $note){
	$showDate = date("jS F Y ",strtotime($note['note_date'])); ?>
	<div class="days-info">
		<p><span style="font-style:italic;"> <b><?php echo $showDate;?></b></span>
			<span>&nbsp;&nbsp;<?php echo $note['notes'];?></span>
		</p>
	</div>
	
	<?php  }  ?>
</div>
	<?php } ?>
	 </div>