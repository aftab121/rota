<style>
.switch {
	position: relative;
	display: inline-block;
	width: 54px;
	height: 25px;
}
.switch input {
	display: none;
}
.slider {
	position: absolute;
	cursor: pointer;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
	background-color: #ccc;
	-webkit-transition: .4s;
	transition: .4s;
}
.slider:before {
	position: absolute;
	content: "";
	height: 25px;
	width: 26px;
	left: 0px;
	bottom: 0px;
	background-color: white;
	-webkit-transition: .4s;
	transition: .4s;
}
input:checked + .slider {
	background-color: #2196F3;
}
input:focus + .slider {
	box-shadow: 0 0 1px #2196F3;
}
input:checked + .slider:before {
	-webkit-transform: translateX(26px);
	-ms-transform: translateX(26px);
	transform: translateX(26px);
}
/* Rounded sliders */
.slider.round {
	border-radius: 34px;
}
.on-off {
	margin-top: 25px;
	float: right;
}
.slider.round:before {
	border-radius: 50%;
}
.custom .emp-name {
	display: inline-block;
	float: left;
}
.emp-name label.btn-default {
	padding: 8px 18px;
	border-radius: 0px;
	border-right: 1px solid #fff !important;
	text-transform: capitalize;
}
.btn-default:hover {
	background-color: #3f9583 !important;
}
.tyming span {
	border-right: 2px solid #666;
	font-size: 18px;
	font-weight: 600;
	margin-bottom: 15px;
	padding: 0px 10px;
}
.shift-active {
	padding: 12px 18px !important;
	font-weight: 600;
	font-size: 16px;
}
.tyming span:last-child {
	border-right: 0px;
}
.text-center {
	text-align: center;
}
#beforeBudget
{
font-size: 13px;
color: #303030;
font-weight: 600;}
</style>
<div class="card-box m-t-20" >
  <?php //print_r($PositionLists);exit; ?>
  <input type="hidden" name="unpublished_count" id="unpublished_count" value="<?php echo $unpublished_count ?>" />
  <table class="table table-striped table-head" style="margin-bottom: 0px;" >
    <thead>
      <?php
			$days = ($current_back*7);
			$start_date = date('D d M',strtotime('+'.$days.' days'));
			?>
      <tr>
        <?php $company_notes = Session::get('CompanyDetails.notes');
		for($i=0;$i<=6;$i++){ ?>
        <th><?php echo date('D d M',strtotime('+'.$i.' days',strtotime($start_date))); 
		$ajax_current_date = date('Y-m-d',strtotime('+'.$i.' days',strtotime($start_date)));?>
          <?php if($company_notes==1): $date_array = array_column($notes,'note_date'); if(!in_array($ajax_current_date,$date_array)){?>
          <a href="#" style="color: #505050;margin-left:8px;"><i class="fa fa-plus-square adddatenotes" data-date_format = "<?php echo date('jS F Y',strtotime($ajax_current_date)); ?>" data-note_date = "<?php echo $ajax_current_date; ?>" data-location_id = "<?php echo $Location['location_id']; ?>"  aria-hidden="true"  data-toggle="modal" data-target="#myModal3"></i></a>
          <?php } else{
			
			$notes_text = array_column(array_filter($notes,function($var)use($ajax_current_date){
				if($var['note_date']==$ajax_current_date){
					return $var;
				}
			}),'notes');
			?>
          <div class="tooltip"><i class="fa fa-comment-o editdatenotes" data-edit_notes="<?php echo  @$notes_text[0]; ?>"  data-date_format = "<?php echo date('jS F Y',strtotime($ajax_current_date)); ?>" data-note_date = "<?php echo $ajax_current_date; ?>"  aria-hidden="true"  data-toggle="modal" data-target="#myModal4"></i> <span class="tooltiptext"><?php echo @$notes_text[0]; ?></span> </div>
          <?php } endif;?>
        </th>
        <?php } ?>
      </tr>
    </thead>
	</table>
	<div style="max-height:347px;overflow-y:auto;height:auto;">
	<table class="table table-striped table-head" >
    <tbody>
      <?php $firstday_labour_cost = 0;
				$firstday_total_hrs = 0;
				$secondday_labour_cost = 0;
				$secondday_total_hrs = 0;
				$thirdday_labour_cost = 0;
				$thirdday_total_hrs = 0;
				$fourthday_labour_cost = 0;
				$fourthday_total_hrs = 0;
				$fifthday_labour_cost = 0;
				$fifthday_total_hrs = 0;
				$sixthday_labour_cost = 0;
				$sixthday_total_hrs = 0;
				$seventhday_labour_cost = 0;
				$seventhday_total_hrs = 0;
	  if(@$UserLists){
		foreach($UserLists as $User):?>
      <tr class="tr_odd">
        <?php $total_labour_cost = 0;
					  $total_hrs = 0;
		for($i=0;$i<=6;$i++){ 
				      $current_date = date('Y-m-d',strtotime('+'.$i.' days',strtotime($start_date)));
				   ?>
        <td ><span>
          <?php 
					  if(@$User['Shift']):
					  
						    foreach($User['Shift'] as $shift):
						    if((strtotime($shift['shift_date'])==strtotime($current_date))){
								if(strtotime($shift['shift_start_time'])!=strtotime($shift['shift_end_time'])){
								$diff = strtotime($shift['shift_start_time']) - strtotime($shift['shift_end_time']);
								$diff = abs($diff)- $shift['meal_break']*60;
								$diff_in_hrs = $diff/3600;
								$Hours = abs($diff_in_hrs);
								if(in_array(strtotime($shift['shift_date']),$holiday_list)){ // holiday Rate
									  $labourCost= $Hours*$shift['holiday_rate'];
								}elseif(date('w', strtotime($shift['shift_date'])) == 6){//saturday
									 $labourCost= $Hours*$shift['saturday_rate'];
								}elseif(date('w', strtotime($shift['shift_date'])) == 0){//sunday
									 $labourCost= $Hours*$shift['sunday_rate'];

								}else{
									$labourCost= $Hours*$shift['standard_rate'];
								}
								$total_labour_cost =  $total_labour_cost + $labourCost; 
								$total_hrs = $total_hrs + $Hours;
								if($i==0){
									$firstday_labour_cost = $firstday_labour_cost+$labourCost;
									$firstday_total_hrs =$firstday_total_hrs + $Hours;
								}
								elseif($i==1){
									$secondday_labour_cost = $secondday_labour_cost+$labourCost;
									$secondday_total_hrs =$secondday_total_hrs + $Hours;
								}
								elseif($i==2){
									$thirdday_labour_cost = $thirdday_labour_cost+$labourCost;
									$thirdday_total_hrs =$thirdday_total_hrs + $Hours;
								}
								elseif($i==3){
									$fourthday_labour_cost = $fourthday_labour_cost+$labourCost;
									$fourthday_total_hrs =$fourthday_total_hrs + $Hours;
								}
								elseif($i==4){
									$fifthday_labour_cost = $fifthday_labour_cost+$labourCost;
									$fifthday_total_hrs =$fifthday_total_hrs + $Hours;
								}
								elseif($i==5){
									$sixthday_labour_cost = $sixthday_labour_cost+$labourCost;
									$sixthday_total_hrs =$sixthday_total_hrs + $Hours;
								}
								else{
									$seventhday_labour_cost = $seventhday_labour_cost+$labourCost;
									$seventhday_total_hrs =$seventhday_total_hrs + $Hours;
								}
								}
						  ?>
          <div class="time-div clearfix" style="<?php echo ($shift['status']==1)?'background-color: rgba(95, 190, 170, 0.3);border-color: rgba(95, 190, 170, 0.4);color: #44A692;':'';?>"> <span class="pull-left"><?php echo date('h:i A',strtotime($shift['shift_start_time'])).' - '.date('h:i A',strtotime($shift['shift_end_time'])); ?></span><br>
            <span class="pull-left"><?php echo $shift['position_name']; ?></span>
            <?php if($shift['status']!=1){?>
            <span class="pull-right icns"> <a href="#" class="copy_shift_model" data-toggle="modal" data-position_name = "<?php echo $shift['position_name']; ?>" data-shift_start_time ="<?php echo date('h:i A',strtotime($shift['shift_start_time'])) ?>" data-shift_end_time ="<?php echo date('h:i A',strtotime($shift['shift_end_time'])); ?>" data-meal_break ="<?php echo $shift['meal_break']; ?>" data-shift_id ="<?php echo $shift['id']; ?>"  data-target="#mycopyModal"><i class="fa fa-floppy-o" aria-hidden="true"></i></a><a href="#" class="EditmodelUserShow" data-toggle="modal"  data-shift_id = "<?php echo $shift['id']; ?>" data-shift_end_time = "<?php echo date('h:i A',strtotime($shift['shift_end_time'])); ?>" data-shift_start_time = "<?php echo date('h:i A',strtotime($shift['shift_start_time'])); ?>"  data-user_id="<?php echo $User['id']; ?>"  data-target="#myEditModal"><i class="icon-pencil icons" style ="color:green;"></i></a> <a href="#" class="deletemodelUserShow" data-shift_id = "<?php echo $shift['id']; ?>"><i class="icon-close icons" style = "color:red;"></i></a> </span>
            <?php }?>
            <?php if($shift['is_conflict']==1){?>
            <div class="tooltip"  style="float:right;"><i class="fa fa-exclamation-triangle" aria-hidden="true" style="font-size: 13px;color: #ffb507;"></i> <span class="tooltiptext">Conflict shift </span> </div>
            <?php } ?>
          </div>
          <?php  }
			endforeach;?>
          <?php  endif; ?>
          <a href="#" class="modelShowUsers" data-toggle="modal" data-meal_break = "<?php echo $Location['default_meal_break']; ?>" data-end_time = "<?php echo $Location['default_end_time']; ?>" data-start_time = "<?php echo $Location['default_start_time']; ?>" data-location_id = "<?php echo $Location['location_id']; ?>"  data-date="<?php echo $current_date; ?>" data-user_id="<?php echo $User['id']; ?>"  data-target="#myModal"><i class="icon-plus icons"></i></a> </span></td>
        <?php } ?>
      </tr>
      <tr class="tr_even">
        <td colspan="7"><b style="float:left;"><?php echo $User['firstname'].' '.$User['lastname'];?></b><b style="float:right;"><?php echo number_format(abs($total_hrs),2).' hrs / $ '.number_format(abs($total_labour_cost),2);?></b></td>
      </tr>
      <?php endforeach;?>
     <?php $show_budget = Session::get('CompanyDetails.budget');
	 if($show_budget==1){?><tr id="beforeBudget1" >
        <td><?php echo number_format(abs($firstday_total_hrs),2).' hrs / $ '.number_format(abs($firstday_labour_cost),2);?></td>
        <td><?php echo number_format(abs($secondday_total_hrs),2).' hrs / $ '.number_format(abs($secondday_labour_cost),2);?></td>
        <td><?php echo number_format(abs($thirdday_total_hrs),2).' hrs / $ '.number_format(abs($thirdday_labour_cost),2);?></td>
        <td><?php echo number_format(abs($fourthday_total_hrs),2).' hrs / $ '.number_format(abs($fourthday_labour_cost),2);?></td>
        <td><?php echo number_format(abs($fifthday_total_hrs),2).' hrs / $ '.number_format(abs($fifthday_labour_cost),2);?></td>
        <td><?php echo number_format(abs($sixthday_total_hrs),2).' hrs / $ '.number_format(abs($sixthday_labour_cost),2);?></td>
        <td><?php echo number_format(abs($seventhday_total_hrs),2).' hrs / $ '.number_format(abs($seventhday_labour_cost),2);?></td>
      </tr>
	 <?php }
	  }elseif(@$PositionLists){
	
	foreach($PositionLists as $Position):?>
      <tr>
        <?php //print_r($holiday_list);exit;
		$total_labour_cost = 0;
					  $total_hrs = 0;
		for($i=0;$i<=6;$i++){ 
				      $current_date = date('Y-m-d',strtotime('+'.$i.' days',strtotime($start_date)));
				   ?>
        <td><span>
          <?php 
					  if(@$Position['Shift']):
						    foreach($Position['Shift'] as $shift):
						    if(strtotime($shift['shift_date'])==strtotime($current_date)){
								if(strtotime($shift['shift_start_time'])!==strtotime($shift['shift_end_time'])){
									$diff = strtotime($shift['shift_start_time']) - strtotime($shift['shift_end_time']);
									$diff = abs($diff)- $shift['meal_break']*60;
									$diff_in_hrs = $diff/3600;
									$Hours = abs($diff_in_hrs);
									if(in_array(strtotime($shift['shift_date']),$holiday_list)){ // holiday Rate
										  $labourCost= $Hours*$shift['holiday_rate'];
									}elseif(date('w', strtotime($shift['shift_date'])) == 6){//saturday
										  $labourCost =$Hours*$shift['saturday_rate'];
									}elseif(date('w', strtotime($shift['shift_date'])) == 0){//sunday
										  $labourCost = $Hours*$shift['sunday_rate'];
									}else{
										 $labourCost = $Hours*$shift['standard_rate'];
									}
									$total_labour_cost =  $total_labour_cost + $labourCost; 
								$total_hrs = $total_hrs + $Hours;
								if($i==0){
									$firstday_labour_cost = $firstday_labour_cost+$labourCost;
									$firstday_total_hrs =$firstday_total_hrs + $Hours;
								}
								elseif($i==1){
									$secondday_labour_cost = $secondday_labour_cost+$labourCost;
									$secondday_total_hrs =$secondday_total_hrs + $Hours;
								}
								elseif($i==2){
									$thirdday_labour_cost = $thirdday_labour_cost+$labourCost;
									$thirdday_total_hrs =$thirdday_total_hrs + $Hours;
								}
								elseif($i==3){
									$fourthday_labour_cost = $fourthday_labour_cost+$labourCost;
									$fourthday_total_hrs =$fourthday_total_hrs + $Hours;
								}
								elseif($i==4){
									$fifthday_labour_cost = $fifthday_labour_cost+$labourCost;
									$fifthday_total_hrs =$fifthday_total_hrs + $Hours;
								}
								elseif($i==5){
									$sixthday_labour_cost = $sixthday_labour_cost+$labourCost;
									$sixthday_total_hrs =$sixthday_total_hrs + $Hours;
								}
								else{
									$seventhday_labour_cost = $seventhday_labour_cost+$labourCost;
									$seventhday_total_hrs =$seventhday_total_hrs + $Hours;
								}
								}
						  ?>
          <div class="time-div clearfix" style="<?php echo ($shift['status']==1)?'background-color: rgba(95, 190, 170, 0.3);border-color: rgba(95, 190, 170, 0.4);color: #44A692;':'';?>"> <span class="pull-left"><?php echo date('h:i A',strtotime($shift['shift_start_time'])).' - '.date('h:i A',strtotime($shift['shift_end_time'])); ?></span><br>
            <span class="pull-left"><?php echo $shift['firstname'].' '.$shift['lastname']; ?></span>
            <?php if($shift['status']!=1){?>
            <span class="pull-right icns"> <a href="#" class="copy_shift_model" data-toggle="modal" data-date_index = "<?php echo $i; ?>" data-position_name = "<?php echo $shift['position_name']; ?>" data-shift_start_time ="<?php echo date('h:i A',strtotime($shift['shift_start_time'])) ?>" data-shift_end_time ="<?php echo date('h:i A',strtotime($shift['shift_end_time'])); ?>" data-meal_break ="<?php echo $shift['meal_break']; ?>" data-shift_id ="<?php echo $shift['id']; ?>"  data-target="#mycopyModal"><i class="fa fa-floppy-o" aria-hidden="true"></i></a> <a href="#" class="EditmodelShow" data-toggle="modal"  data-shift_id = "<?php echo $shift['id']; ?>" data-notes="<?php echo $shift['notes']; ?>" data-visible="<?php echo $shift['visible']; ?>" data-position_id="<?php echo $Position['id']; ?>"    data-target="#myEditModal"><i class="icon-pencil icons" style ="color:green;"></i></a> <a href="#" class="deletemodelUserShow" data-shift_id = "<?php echo $shift['id']; ?>"><i class="icon-close icons" style = "color:red;"></i></a>
            <?php } ?>
            <?php if($shift['is_conflict']==1){?>
            <div class="tooltip" style="float:right;"><i class="fa fa-exclamation-triangle" aria-hidden="true" style="font-size: 13px;color: #ffb507;"></i> <span class="tooltiptext">Conflict shift </span> </div>
            <?php } ?>
            </span> </div>
          <?php  }
							  endforeach;
							  endif;
							?>
          <a href="#" class="modelShow" data-toggle="modal" data-meal_break="<?php echo $Location['default_meal_break']; ?>" data-end_time="<?php echo $Location['default_end_time']; ?>" data-start_time="<?php echo $Location['default_start_time']; ?>" data-location_id="<?php echo $Location['location_id']; ?>"  data-date="<?php echo $current_date; ?>" data-position_id="<?php echo $Position['id']; ?>"  data-target="#myModal"><i class="icon-plus icons"></i></a> </span></td>
        <?php } ?>
      </tr>
      <tr>
        <td colspan="7"><b style="float:left;"><?php echo $Position['position_name'];?></b><b style="float:right;"><?php echo number_format(abs($total_hrs),2).' hrs / $ '.number_format(abs($total_labour_cost),2);?></b></td>
      </tr>
      <?php endforeach?><?php $show_budget = Session::get('CompanyDetails.budget');
	 if($show_budget==1){?><tr id="beforeBudget" >
        <td><?php echo number_format(abs($firstday_total_hrs),2).' hrs / $ '.number_format(abs($firstday_labour_cost),2);?></td>
        <td><?php echo number_format(abs($secondday_total_hrs),2).' hrs / $ '.number_format(abs($secondday_labour_cost),2);?></td>
        <td><?php echo number_format(abs($thirdday_total_hrs),2).' hrs / $ '.number_format(abs($thirdday_labour_cost),2);?></td>
        <td><?php echo number_format(abs($fourthday_total_hrs),2).' hrs / $ '.number_format(abs($fourthday_labour_cost),2);?></td>
        <td><?php echo number_format(abs($fifthday_total_hrs),2).' hrs / $ '.number_format(abs($fifthday_labour_cost),2);?></td>
        <td><?php echo number_format(abs($sixthday_total_hrs),2).' hrs / $ '.number_format(abs($sixthday_labour_cost),2);?></td>
        <td><?php echo number_format(abs($seventhday_total_hrs),2).' hrs / $ '.number_format(abs($seventhday_labour_cost),2);?></td>
      </tr>
	  <?php } }else{ ?>
      <tr>
        <td colspan="7"><b style="float:left;">No Shifts Found </b></td>
      </tr>
      <?php } ?>
      
    </tbody>
  </table>
 </div>
 </div>
  <div class="card-box m-t-20">

  <div class="bottom-table">
  <table class="table table-striped table-head">
  <tbody><!--Sales Calculation starts -->
      
      <tr class="afterBudget" style="display:none;">
	     
        <?php for($i=0;$i<=6;$i++){ 
		 $current_date = date('Y-m-d',strtotime('+'.$i.' days',strtotime($start_date)));
		 $sales_price = array_column(array_filter($SalesPerDays,function($var)use($current_date){
				if($var['sales_shift_date']==$current_date){
					return $var;
				}
			}),'sales_price');
			
		?>
        <td>$
          <input type="number" id="sales<?php echo $i;?>" value="<?php echo  @$sales_price[0];?>"  min="0" name="sales<?php echo $i;?>" class="form-control sales"/>
          </td>
        <?php } ?>
      </tr>
	  <?php $show_labor_hours = Session::get('CompanyDetails.labor_hours');
	 if($show_labor_hours==1){?><tr class="afterBudget" style="display:none;">
	     
        <td><?php echo number_format(abs($firstday_total_hrs),2).' hrs';?></td>
        <td><?php echo number_format(abs($secondday_total_hrs),2).' hrs ';?></td>
        <td><?php echo number_format(abs($thirdday_total_hrs),2).' hrs ';?></td>
        <td><?php echo number_format(abs($fourthday_total_hrs),2).' hrs ';?></td>
        <td><?php echo number_format(abs($fifthday_total_hrs),2).' hrs ';?></td>
        <td><?php echo number_format(abs($sixthday_total_hrs),2).' hrs ';?></td>
        <td><?php echo number_format(abs($seventhday_total_hrs),2).' hrs';?></td>
	 </tr><?php } $show_labor_cost = Session::get('CompanyDetails.labor_cost');
	 if($show_labor_cost==1){?> 
	  <tr class="afterBudget" style="display:none;">
	     
        <td><?php echo ' $ '.number_format(abs($firstday_labour_cost),2);?></td>
        <td><?php echo ' $ '.number_format(abs($secondday_labour_cost),2);?></td>
        <td><?php echo ' $ '.number_format(abs($thirdday_labour_cost),2);?></td>
        <td><?php echo ' $ '.number_format(abs($fourthday_labour_cost),2);?></td>
        <td><?php echo ' $ '.number_format(abs($fifthday_labour_cost),2);?></td>
        <td><?php echo ' $ '.number_format(abs($sixthday_labour_cost),2);?></td>
        <td><?php echo ' $ '.number_format(abs($seventhday_labour_cost),2);?></td>
      </tr>
	 <?php } ?>
	  <tr class="afterBudget" style="display:none;">
	   
        <?php 
		for($i=0;$i<=6;$i++){ 
			$current_date = date('Y-m-d',strtotime('+'.$i.' days',strtotime($start_date)));
			
			$sales_per_hour = array_column(array_filter($SalesPerDays,function($var)use($current_date){
				if($var['sales_shift_date']==$current_date){
					return $var;
				}
			}),'sales_per_hour');
		
		?>
        <td>
		<?php $show_sales_per_hour = Session::get('CompanyDetails.sales_per_hour');
	 if($show_sales_per_hour==1){?><span id="salesperHour<?php echo $i;?>"> $ <?php echo @$sales_per_hour[0];?>  </span><br/>
	 <?php } ?></td>
        <?php } ?>
      </tr>
	  <tr class="afterBudget" style="display:none;">
	 
        <?php 
		for($i=0;$i<=6;$i++){ 
			$current_date = date('Y-m-d',strtotime('+'.$i.' days',strtotime($start_date)));
			
			$labour_variation = array_column(array_filter($SalesPerDays,function($var)use($current_date){
				if($var['sales_shift_date']==$current_date){
					return $var;
				}
			}),'labour_variation');
		?>
        <td>
		
	 <?php  $show_labor_adjustment = Session::get('CompanyDetails.labor_adjustment');
	 if($show_labor_adjustment==1){?>$<input type="number" id="labour_variation<?php echo $i;?>" value="<?php echo  @$labour_variation[0];?>" min="0" name="labour_variation<?php echo $i;?>" value="0" class="form-control labour_variation"/>
	 <br/><?php } ?>
         </td>
        <?php } ?>
      </tr>
	  <tr class="afterBudget" style="display:none;">
	   
        <?php 
		for($i=0;$i<=6;$i++){ 
			$current_date = date('Y-m-d',strtotime('+'.$i.' days',strtotime($start_date)));
			
			$sales_percentage = array_column(array_filter($SalesPerDays,function($var)use($current_date){
				if($var['sales_shift_date']==$current_date){
					return $var;
				}
			}),'sales_percentage');
		?>
        <td>
          <span id="percentage_calculate<?php echo $i;?>"> <?php echo  @$sales_percentage[0];?> % </span></td>
        <?php } ?>
      </tr><!--Sales Calculation End --></tbody>
  </table>
  </div></div>

<div class="modal fade" id="mycopyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    {!! Form::open(array('url'=> '#','id'=>'copyShifts','class'=>'form-horizontal m-t-20')) !!}
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" onclick="refreshDiv();" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Copy Shifts</h4>
      </div>
      <div class="modal-body clearfix">
	    <div class="row">
          <div class="col-md-12 copyShiftsuccess" ></div>
          <div class="col-md-12 copyShiftfailure" ></div>
        </div>
        <h4 class="text-center tyming"><span id="copy_position"> Manager </span><span id="copy_time">10:00am - 10:00pm</span><span id="copy_meal">30 min</span></h4>
        <h4 class="text-center ">Which days would you like to copy the shift to?</h4>
        <div class="location-list">
          <div class="row">
		    <input name="copy_shift_id" type="hidden" id="copy_shift_id" value=""/>
            <div class="check-design custom">
			   
			  <?php 
					for($i=0;$i<=6;$i++){ 
				      $current_date = date('D',strtotime('+'.$i.' days',strtotime($start_date)));
					  $current_date_value = date('Y-m-d',strtotime('+'.$i.' days',strtotime($start_date)));
					?>
					<div class="emp-name">
						<label class="btn btn-default class<?php echo $i;?> " style="margin-top:6px;">
						  <input name="copy_days[]" type="checkbox" value="<?php echo $current_date_value; ?>" />
						  <?php echo $current_date; ?></label>
					</div><?php }?>
            </div>
          </div>
        </div>
        <div class="on-off copy_notes" >
          <label class="pull-left" style="padding-right: 10px">Copy Notes : </label>
          <label class="switch">
          <input type="checkbox"  name="copy_notes" >
          <div class="slider round"></div>
        </div>
        </label>
      </div>
      <div class="modal-footer clearfix">
        <button type="button" class="btn btn-danger" onclick="refreshDiv();" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Copy Shift</button>
      </div>
    </div>
	 {!! Form::close() !!}
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="myModal4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document"> {!! Form::open(array('url'=> '#','id'=>'editDateNotes','class'=>'form-horizontal m-t-20')) !!}
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"  onclick="refreshDiv();" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title " id="myModalLabel">Notes for <span class="edit_title_note">Thu Mar 16th</span></h4>
      </div>
      <div class="modal-body clearfix">
        <div class="row">
          <div class="col-md-12 addNotesuccess" ></div>
          <div class="col-md-12 addNotefailure" ></div>
        </div>
        <div class="form-group  clearfix">
          <label class="col-md-12 control-label">Note</label>
          <div class="col-md-12">
            <textarea class="form-control" id="edit_notes" name="notes" cols="3"></textarea>
          </div>
        </div>
        <input type="hidden" name="note_date" id="edit_note_note_date" value=""/>
        <!--<div class="form-group  clearfix">
          <label class="col-md-4 control-label">Staff Timesheet</label>
          <div class="pull-right col-md-8">
            <input type="checkbox"  name="staff_timesheet" data-toggle="toggle" data-on="on" data-off="off" data-onstyle="success" data-offstyle="danger">
          </div>
        </div>-->
        <div class="form-group  clearfix">
          <label class="col-md-12 control-label">Locations</label>
          <div class="col-md-12">
            <div class="positions-tab">
              <div>
                <button type="button"  class="btn btn-white btn-custom waves-effect" id="AddLocationSelectAll">Select All</button>
                <button  type="button" class="btn btn-white btn-custom waves-effect" id="AddLocationClearAll">Clear All</button>
              </div>
              <div class="location-list">
                <div class="row">
                  <div class="check-design">
                    <?php 
						 if($Locationlist):
							foreach($Locationlist as $locations):
						 ?>
                    <div class="col-md-6">
                      <div class="emp-name add_location_name_list ">
                        <label class="<?php if($Location['location_id']==$locations['location_id']){echo "checked";} ?>">
                          <input name="location_ids[]" type="checkbox" value="<?php echo $locations['location_id'];?>" <?php if($Location['location_id']==$locations['location_id']){echo "checked";} ?>/>
                          <?php echo $locations['location_name'];?></label>
                      </div>
                    </div>
                    <?php endforeach;
						 endif; ?>
                  </div>
                </div>
              </div>
            </div>
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
<!-- Modal --> 
<!-- Modal -->
<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document"> {!! Form::open(array('url'=> '#','id'=>'AddDateNotes','class'=>'form-horizontal m-t-20')) !!}
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"  onclick="refreshDiv();" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Notes for <span class="title_note">Thu Mar 16th</span></h4>
      </div>
      <div class="modal-body clearfix">
        <div class="row">
          <div class="col-md-12 addNotesuccess" ></div>
          <div class="col-md-12 addNotefailure" ></div>
        </div>
        <div class="form-group  clearfix">
          <label class="col-md-12 control-label">Note</label>
          <div class="col-md-12">
            <textarea class="form-control" id="notes" name="notes" cols="3"></textarea>
          </div>
        </div>
        <input type="hidden" name="note_date" id="add_note_note_date" value=""/>
        <!--<div class="form-group  clearfix">
          <label class="col-md-4 control-label">Staff Timesheet</label>
          <div class="pull-right col-md-8">
            <input type="checkbox"  name="staff_timesheet" data-toggle="toggle" data-on="on" data-off="off" data-onstyle="success" data-offstyle="danger">
          </div>
        </div>-->
        <div class="form-group  clearfix">
          <label class="col-md-12 control-label">Locations</label>
          <div class="col-md-12">
            <div class="positions-tab">
              <div>
                <button type="button"  class="btn btn-white btn-custom waves-effect" id="AddLocationSelectAll">Select All</button>
                <button  type="button" class="btn btn-white btn-custom waves-effect" id="AddLocationClearAll">Clear All</button>
              </div>
              <div class="location-list">
                <div class="row">
                  <div class="check-design">
                    <?php 
						 if($Locationlist):
							foreach($Locationlist as $locations):
						 ?>
                    <div class="col-md-6">
                      <div class="emp-name add_location_name_list ">
                        <label class="<?php if($Location['location_id']==$locations['location_id']){echo "checked";} ?>">
                          <input name="location_ids[]" type="checkbox" value="<?php echo $locations['location_id'];?>" <?php if($Location['location_id']==$locations['location_id']){echo "checked";} ?>/>
                          <?php echo $locations['location_name'];?></label>
                      </div>
                    </div>
                    <?php endforeach;
						 endif; ?>
                  </div>
                </div>
              </div>
            </div>
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
<!-- Modal -->
<div class="modal fade" id="myEditModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="refreshDiv();"> <span aria-hidden="true">&times;</span> </button>
        <h4 class="modal-title" id="myModalLabel">Edit Shift</h4>
      </div>
      {!! Form::open(array('url'=> '#','id'=>'EditShiftForm','class'=>'form-horizontal m-t-20')) !!}
      <div class="modal-body clearfix">
        <div class="row">
          <div class="col-md-12" id="editsuccess"></div>
          <div class="col-md-12" id="editfailure"></div>
        </div>
        <div class="row">
          <input id="shift_editlocation_id" name="location_id" type="hidden"  value="" placeholder = "shift_location_id" class="form-control" >
          <input id="shift_editdate" name="shift_date" type="hidden" value="" placeholder = "shift_date" class="form-control" >
          <input id="shift_edituser_id" name="shift_user_id" type="hidden" value="" placeholder = "shift_user_id" class="form-control" >
          <input id="shift_editposition_id" name="shift_position_id" type="hidden" value="" placeholder = "shift_position_id" class="form-control" >
          <input id="shift_id" name="shift_id" type="hidden" value="" placeholder = "shift_id" class="form-control" >
          <div class="col-md-6">
            <div class="form-group  clearfix">
              <label>Start</label>
              <div class="input-group m-b-15">
                <div class="bootstrap-timepicker">
                  <input name="shift_start_time" id="Edittimepicker"  type="text" class="form-control">
                </div>
                <span class="input-group-addon bg-custom b-0 text-white"><i class="glyphicon glyphicon-time"></i></span> </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group  clearfix">
              <label>End</label>
              <div class="input-group m-b-15">
                <div class="bootstrap-timepicker">
                  <input id="Edittimepicker2" name="shift_end_time"  type="text" class="form-control">
                </div>
                <span class="input-group-addon bg-custom b-0 text-white"><i class="glyphicon glyphicon-time"></i></span> </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group  clearfix">
              <label>Meal break</label>
              <input type="number" id="editmeal_break" name="meal_break" value="15" min="15" max="400"  step="15" class="form-control">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group  clearfix">
              <label>End Option</label>
              <select name="end_option" id="editend_option" class="form-control">
                <option value="1">Time</option>
                <option value="2">Close</option>
                <option value="3">Required</option>
              </select>
            </div>
          </div>
			<div class="col-md-12">
            <div class="form-group  clearfix">
              <label> Notes</label>
              <textarea name="notes" id="shift_notes" class="form-control"></textarea>
            </div>
          </div>
		  <div class="on-off copy_notes" style="float:left;" >
			  <label class="pull-right" style="padding-left: 10px">Notes Visibility : </label>
			  <label class="switch">
			  <input type="checkbox"  name="visible" id="shift_visible" >
			  <div class="slider round"></div>
		  </div>
          <div class="col-md-12">
            <div class="form-group  clearfix">
              <label>Select from the list</label>
              <?php //echo "<pre>";print_r($PositionLists);?>
              <select name="<?php echo (@$UserLists)?'position_id[]':'assigned_to[]';?>"  id="<?php echo (@$UserLists)?'edit_position_id_list':'edit_assigned_to_list';?>" class="form-control multiple">
              </select>
            </div>
          </div>
        </div>
        <!--<div class="row">
			  <div class="col-md-6">
				<div class="pull-left clearfix ">
				  <h4><b class="shift_length">2.75 &nbsp; hrs </b></h4>
				  <p>Shift Length</p>
				</div>
			  </div>
			  <div class="col-md-6">
				<div class="pull-right clearfix">
				  <h4><b>$  &nbsp;  N/A</b></h4>
				  <p>Shift Cost</p>
				</div>
			  </div>
			</div>--> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="refreshDiv();">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      {!! Form::close() !!} </div>
  </div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" onclick="refreshDiv();" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
        <h4 class="modal-title" id="myModalLabel">Add Shift</h4>
      </div>
      {!! Form::open(array('url'=> '#','id'=>'AddShiftForm','class'=>'form-horizontal m-t-20')) !!}
      <div class="modal-body clearfix">
        <div class="row">
          <div class="col-md-12" id="addsuccess"></div>
          <div class="col-md-12" id="addfailure"></div>
        </div>
        <div class="row">
          <input id="shift_location_id" name="location_id" type="hidden" value="" placeholder = "shift_location_id" class="form-control">
          <input id="shift_date" name="shift_date" type="hidden" value="" placeholder = "shift_date" class="form-control">
          <input id="shift_user_id" name="shift_user_id" type="hidden" value="" placeholder = "shift_user_id" class="form-control">
          <input id="shift_position_id" name="shift_position_id" type="hidden" value="" placeholder = "shift_position_id" class="form-control">
          <div class="col-md-6">
            <div class="form-group  clearfix">
              <label>Start</label>
              <div class="input-group m-b-15">
                <div class="bootstrap-timepicker">
                  <input name="shift_start_time" id="Edittimepicker" type="text" class="form-control">
                </div>
                <span class="input-group-addon bg-custom b-0 text-white"><i class="glyphicon glyphicon-time"></i></span> </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group  clearfix">
              <label>End</label>
              <div class="input-group m-b-15">
                <div class="bootstrap-timepicker">
                  <input id="Edittimepicker2" name="shift_end_time" type="text" class="form-control">
                </div>
                <span class="input-group-addon bg-custom b-0 text-white"><i class="glyphicon glyphicon-time"></i></span> </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group  clearfix">
              <label>Meal break</label>
              <input type="number" id="meal_break" name="meal_break" value="15" min="15" max="400"  step="15" class="form-control">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group  clearfix">
              <label>End Option</label>
              <select name="end_option" class="form-control">
                <option value="1">Time</option>
                <option value="2">Close</option>
                <option value="3">Required</option>
              </select>
            </div>
          </div>
		  <div class="col-md-12">
            <div class="form-group  clearfix">
              <label> Notes</label>
              <textarea name="notes" id="notes" class="form-control"></textarea>
            </div>
          </div>
		  <div class="on-off copy_notes" style="float:left;" >
			  <label class="pull-right" style="padding-left: 10px">Notes Visibility : </label>
			  <label class="switch">
			  <input type="checkbox"  name="visible" >
			  <div class="slider round"></div>
		  </div>
          <div class="col-md-12">
            <div class="form-group  clearfix">
              <label>Select from the list</label>
              <?php //echo "<pre>";print_r($PositionLists);?>
              <select name="<?php echo (@$UserLists)?'position_id[]':'assigned_to[]';?>"  id="<?php echo (@$UserLists)?'position_id_list':'assigned_to_list';?>" class="form-control multiple">
              </select>
            </div>
          </div>
        </div>
        <!--<div class="row">
          <div class="col-md-6">
            <div class="pull-left clearfix ">
              <h4><b class="shift_length">2.75 &nbsp; hrs </b></h4>
              <p>Shift Length</p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="pull-right clearfix">
              <h4><b>$  &nbsp;  N/A</b></h4>
              <p>Shift Cost</p>
            </div>
          </div>
        </div>--> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" onclick="refreshDiv();" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      {!! Form::close() !!} </div>
  </div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('body').on('change','#Edittimepicker2', function(evt){
			var date_diff= (new Date($('#Edittimepicker2').val()) - new Date($('#Edittimepicker').val())) / 1000 / 60 / 60;
			var d1 = Date.parse($('#Edittimepicker').val());
			var d2 = Date.parse($('#Edittimepicker2').val());
		});
		
		$('body').on('click','.copy_week_btn', function(evt){
			var location = $('.main_location_id').val();
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
	});
</script>
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
