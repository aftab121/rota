<div class="col-lg-9 content-height" >
						<div class="top-info">
						 <span> <i class="fa fa-star"></i> <span id="position_nameDiv"><?php echo @$Position['position_name']; ?></span> </span>
						 
					    </div>
{!! Form::open(array('url' => '#','id'=>'editPositionForm','class'=>'form-horizontal m-t-20')) !!} 
	<ul class="nav nav-tabs">
	  <li class="active"> <a href="#editl1" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-star" aria-hidden="true"></i></span> <span class="hidden-xs"><i class="fa fa-star" aria-hidden="true"></i> Position Details</span> </a> </li>
	  <li > <a href="#editl2" data-toggle="tab" aria-expanded="true"> <span class="visible-xs"><i class="fa fa-location-arrow" aria-hidden="true"></i></span> <span class="hidden-xs"><i class="fa fa-map-marker" aria-hidden="true"></i> Locations for <?php echo @$Position['position_name']; ?> </span> </a> </li>
	  <li class=""> <a href="#editl3" data-toggle="tab" aria-expanded="false"> <i class="fa fa-users" aria-hidden="true"></i> <span class="visible-xs"><i class="fa fa-users" aria-hidden="true"></i></span> <span class="hidden-xs">Employees in the <?php echo @$Position['position_name']; ?>  Position</span> </a> </li>
	</ul>
<div class="tab-content clearfix">
  {!! Form::hidden('id',@$Position['id'],array('class'=>'form-control','placeholder'=>'Hidden Id')) !!}
  <div class="box-header with-border" id="editsuccess"></div>
  <div class="box-header with-border" id="editfailure"></div>
  <div class="tab-pane active" id="editl1">
	<div class="positions-tab">
	  <div class="form-group">
		  <div class="row">
		<label for="location-name" class="control-label col-md-12">Position name</label>
		<div class="col-md-6">
		  {!! Form::text('position_name',@$Position['position_name'],array('class'=>'form-control','placeholder'=>'Position name')) !!}
		  
		</div>
		</div>
	  </div>
	</div>
	<div class="m-t-20 col-md-12">
		   <button type="submit" class="btn btn-success waves-effect waves-light">Save</button>
		 </div>
  </div>
  <div class="tab-pane" id="editl2">
   <div class="positions-tab">
	   <h4>Select the locations that have the <?php echo @$Position['position_name']; ?> position:</h4>
		<div>
			<button type="button"  class="btn btn-white btn-custom waves-effect" id="EditLocationSelectAll">Select All</button>
			<button  type="button" class="btn btn-white btn-custom waves-effect" id="EditLocationClearAll">Clear All</button>
		 </div>
		 <div class="location-list">
			<div class="row">
			 <div class="check-design">
				 <?php 
				 $location_ids =  explode(',',@$Position['location_ids']);
				 if($Locationlist):
					foreach($Locationlist as $location):
				 ?>
				 <div class="col-md-4">
					 <div class="emp-name edit_location_name_list">
						 <label class="<?php echo (in_array($location['location_id'],$location_ids))?'checked':'';?>"> <input name="location_ids[]" type="checkbox" value="<?php echo $location['location_id'];?>" <?php echo (in_array($location['location_id'],$location_ids))?'checked=""':'';?> /><?php echo $location['location_name'];?></label>
					 </div>
				 </div>
				 <?php endforeach;
				 endif; ?>
			 </div>
			</div>
		 </div>
   </div>
	<div class="m-t-20 col-md-12">
		   <button type="submit" class="btn btn-success waves-effect waves-light">Save</button>
		 </div>
  </div>
  <div class="tab-pane" id="editl3">
	 <div class="staff-list-main">
		 <h4>Select the staff that can work in the <?php echo @$Position['position_name']; ?> position:</h4>
		 <div>
			<button type="button" class="btn btn-white btn-custom waves-effect" id="EditStaffSelectAll">Select All</button>
			<button type="button" class="btn btn-white btn-custom waves-effect"  id="EditStaffClearAll">Clear All</button>
		 </div>
		 <div class="staff-list">
			 <div class="row">
		 <div class="check-design">
			 <?php 
			 $staff_ids =  explode(',',@$Position['staff_ids']);
			 if($Stafflist):
				foreach($Stafflist as $Staff):
			 ?>
			 <div class="col-md-4">
				 <div class="emp-name edit_staff_name_list">
					 <label class="<?php echo (in_array($Staff['id'],$staff_ids))?'checked':'';?>"> <input name="staff_ids[]" type="checkbox" value="<?php echo $Staff['id'];?>" <?php echo (in_array($Staff['id'],$staff_ids))?'checked=""':'';?> /><?php echo $Staff['firstname'].' '.$Staff['lastname'];?></label>
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