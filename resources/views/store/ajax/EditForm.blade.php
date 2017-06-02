<div class="col-lg-9 content-height">
            <div class="top-info"> <span> <i class="fa fa-map-marker
"></i> <span id="position_nameDiv"><?php echo @$Location['location_name'];?></span> </span>
                 </div>
            <div > 
			{!! Form::open(array('url' => '#','id'=>'editPositionForm','class'=>'form-horizontal m-t-20')) !!} 
				<ul class="nav nav-tabs">
				  <li class="active"> <a href="#editl1" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-cube" aria-hidden="true"></i></span> <span class="hidden-xs"><i class="fa fa-cube" aria-hidden="true"></i> Location Details</span> </a> </li>
				  <li > <a href="#editl2" data-toggle="tab" aria-expanded="true"> <span class="visible-xs"><i class="fa fa-map-marker" aria-hidden="true"></i></span> <span class="hidden-xs"><i class="fa fa-map-marker" aria-hidden="true"></i> Positions for <?php echo @$Location['location_name']; ?> </span> </a> </li>
				  <li class=""> <a href="#editl3" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-location-arrow" aria-hidden="true"></i></span> <span class="hidden-xs"><i class="fa fa-location-arrow" aria-hidden="true"></i>Employees at <?php echo @$Location['location_name']; ?></span> </a> </li>
				</ul>
					<div class="tab-content clearfix">
					  {!! Form::hidden('id',@$Location['location_id'],array('class'=>'form-control','placeholder'=>'Hidden Id')) !!}
					  <div class="box-header with-border" id="editsuccess"></div>
					  <div class="box-header with-border" id="editfailure"></div>
					  <div class="tab-pane active" id="editl1">
										   
											<div class="col-sm-6">
									  <div class="form-group">
										<label for="location-name" class="control-label">Location name</label>
										<div>
										  {!! Form::text('location_name',@$Location['location_name'],array('class'=>'form-control','placeholder'=>'Location name')) !!}
										</div>
									  </div>
									</div>
										  
											
									<div class="clear"></div>
									
									<hr>
									
									<div class="col-sm-6">
									  <div class="form-group">
										<label for="location-name" class="control-label">Address</label>
										<div>
										   {!! Form::text('street_address',@$Location['street_address'],array('class'=>'form-control','placeholder'=>'Address')) !!}
										</div>
									  </div>
									</div>
									<div class="col-sm-6">
									  <div class="form-group">
										<label for="location-name" class="control-label">Country</label>
										<div>
										  {!! Form::select('country_id',$countries,@$Location['country_id'],array('class'=>'form-control','placeholder'=>'Select Country'))!!}
														
										</div>
									  </div>
									</div>
									<div class="col-sm-6">
									  <div class="form-group">
										<label for="location-name" class="control-label">State</label>
										<div>
										   {!! Form::text('state_name',@$Location['state_name'],array('class'=>'form-control','placeholder'=>'State')) !!}
										</div>
									  </div>
									</div>
									<div class="col-sm-6">
									  <div class="form-group">
										<label for="location-name" class="control-label">City</label>
										<div>
										 {!! Form::text('city',@$Location['city'],array('class'=>'form-control','placeholder'=>'City')) !!}
										</div>
									  </div>
									</div>
									<div class="col-sm-6">
									  <div class="form-group">
										<label for="location-name" class="control-label">Zip Code</label>
										<div>
										  {!! Form::text('zip_code',@$Location['zip_code'],array('class'=>'form-control','placeholder'=>'Zip Code','onkeypress'=>'return isNumber(event)')) !!}
										</div>
									  </div>
									</div>

									<div class="clear"></div>
									<hr>
									
									<div class="col-md-4">
									   <div class="form-group">
										   
										<label>Default Start Time</label>
										<div class="input-group m-b-15">
						
											<div class="bootstrap-timepicker">
												 {!! Form::text('default_start_time',@$Location['default_start_time'],array('class'=>'form-control','id'=>'Edittimepicker','placeholder'=>'Default Start Time')) !!}
											</div>
											<span class="input-group-addon bg-custom b-0 text-white"><i class="glyphicon glyphicon-time"></i></span>
										</div><!-- input-group -->                       
										   
									   </div>
									</div>
									
									
									<div class="col-md-4">
									   <div class="form-group">
										   
										<label>Default End Time</label>
										<div class="input-group m-b-15">
						
											<div class="bootstrap-timepicker">
												{!! Form::text('default_end_time',@$Location['default_end_time'],array('class'=>'form-control','id'=>'Edittimepicker2','placeholder'=>'Default End Time')) !!}
											</div>
											<span class="input-group-addon bg-custom b-0 text-white"><i class="glyphicon glyphicon-time"></i></span>
										</div><!-- input-group -->                       
										   
									   </div>
									</div>
									
									
									<div class="col-md-4">
									   <div class="form-group">
										<label>Default meal break</label>
										<div class="input-group m-b-15">
											<div class="bootstrap-timepicker">
												{!! Form::number('default_meal_break',@$Location['default_meal_break'],array('class'=>'form-control','min'=>10,'max'=>390,'step'=>20,'placeholder'=>'Default meal break')) !!}
											</div>
										</div><!-- input-group -->                       
										   
									   </div>
									</div>
									
								  
										  </div>
										  <div class="tab-pane" id="editl2">
					   <div class="positions-tab">
						   <h4>Select the Positions that have the <?php echo @$Location['location_name']; ?>:</h4>
							<div>
								<button type="button"  class="btn btn-white btn-custom waves-effect" id="EditPositionSelectAll">Select All</button>
								<button  type="button" class="btn btn-white btn-custom waves-effect" id="EditPositionClearAll">Clear All</button>
							 </div>
							 <div class="location-list">
								<div class="row">
								 <div class="check-design">
									 <?php 
									 $position_ids =  explode(',',@$Location['position_ids']);
									 if($PositionList):
										foreach($PositionList as $Position):
									 ?>
									 <div class="col-md-4">
										 <div class="emp-name edit_position_name_list">
											 <label class="<?php echo (in_array($Position['id'],$position_ids))?'checked':'';?>"> <input name="position_ids[]" type="checkbox" value="<?php echo $Position['id'];?>" <?php echo (in_array($Position['id'],$position_ids))?'checked=""':'';?> /><?php echo $Position['position_name'];?></label>
										 </div>
									 </div>
									 <?php endforeach;
									 endif; ?>
								 </div>
								</div>
							 </div>
					   </div>
					  </div>
					  <div class="tab-pane" id="editl3">
						 <div class="staff-list-main">
							 <h4>Select the staff that can work in the <?php echo $Location['location_name']; ?> :</h4>
							 <div>
								<button type="button" class="btn btn-white btn-custom waves-effect" id="EditStaffSelectAll">Select All</button>
								<button type="button" class="btn btn-white btn-custom waves-effect"  id="EditStaffClearAll">Clear All</button>
							 </div>
							 <div class="staff-list">
								 <div class="row">
							 <div class="check-design">
								 <?php 
								 $staff_ids =  explode(',',@$Location['staff_ids']);
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
							   <button type="submit" class="btn btn-success waves-effect waves-light">Update</button>
							 </div>
							</div>   
						  </div>
						 </div>
					  </div>
					</div>
				{!! Form::close() !!}
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
 </div>