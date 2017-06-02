<?php if($inputData):?>
<div class="top-info">
    <span> <i class="fa fa-user"></i> {{$inputData['firstname']}}&nbsp;{{$inputData['lastname']}} </span>
</div>
{!! Form::open(array('url' => '#','id'=>'editform','class'=>'form-horizontal m-t-20')) !!}  
<ul class="nav nav-tabs">
  <li class="active"><a href="#editl1" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-users" aria-hidden="true"></i></span> <span class="hidden-xs"><i class="fa fa-users" aria-hidden="true"></i> Employee Details</span> </a> </li>
  <li > <a href="#editl2" data-toggle="tab" aria-expanded="true"> <span class="visible-xs"><i class="fa fa-location-arrow" aria-hidden="true"></i></span> <span class="hidden-xs"><i class="fa fa-location-arrow" aria-hidden="true"></i> Locations </span> </a> </li>
  <li class=""> <a href="#editl3" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"> <i class="fa fa-star" aria-hidden="true"></i></span> <span class="hidden-xs"><i class="fa fa-star" aria-hidden="true"></i> Positions</span> </a> </li> 
  <li class=""> <a href="#editl4" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"> <i class="fa fa-usd" aria-hidden="true"></i> </span> <span class="hidden-xs"><i class="fa fa-usd" aria-hidden="true"></i> Salary / Wage</span> </a> </li>
  
</ul>
<div class="tab-content clearfix">
  <div class="box-header with-border" id="editsuccess"></div>
		<div class="box-header with-border" id="editfailure"></div>
  <div class="tab-pane active" id="editl1">
	
	  <div class="staff-profile">
		
		 <div class="col-md-4 col-sm-4 ">
		  <div class="row">
			 <div class="staff-photo">
			     <?php $img = (!empty($inputData['profile_pic']))?('profile/'.$inputData['profile_pic']):'noimage.png';  ?>
				 <img src="{{ asset('images/'.$img)}}" alt="" id="edit_image"/>
				 
			  <div class="upload-photo">
				<div class="fileupload btn btn-purple btn-block waves-effect waves-light">
					<span><i class="ion-upload m-r-5"></i>New Upload</span>
					{!! Form::file('profile_pic', ['class' => 'upload','id'=>'profile-image']) !!}
				</div>
			 </div>
			 </div>
			 </div>
		 </div>
		 <div class="col-md-8 col-sm-8 ">
			 <div class="profile-form">
				 <h4  class="header-title m-t-0 m-b-20 col-md-12"><strong>Personal Information</strong></h4>
				 <div  class="col-md-6">
					<div class="form-group">
						<label>First Name</label>
						{!! Form::text('firstname',@$inputData['firstname'],array('class'=>'form-control','placeholder'=>'Firstname')) !!}
				   </div>
				 </div>
				 <div  class="col-md-6">
					<div class="form-group">
						<label>Last Name</label>
						{!! Form::text('lastname',@$inputData['lastname'],array('class'=>'form-control','placeholder'=>'Lastname')) !!}
					</div>
				 </div>
				 <div  class="col-md-6">
					<div class="form-group">
						<label>Email address </label>
						{!! Form::text('email',@$inputData['email'],array('class'=>'form-control','placeholder'=>'Email')) !!}
					</div>
				 </div>
				 <div  class="col-md-6">
					<div class="form-group">
						<label>Contact No.</label>
						{!! Form::text('business_contact_no',@$inputData['business_contact_no'],array('class'=>'form-control','placeholder'=>'Contact No.','maxlength'=>'12','onkeypress'=>'return isNumber(event)')) !!}
					</div>
				 </div>
				 <div class="col-md-6">
					 <div class="form-group">
						<label>Joining Date</label>
						<div class="input-group">
						{!! Form::text('start_date_with_company',@$inputData['start_date_with_company'],array('class'=>'form-control','id'=>'editdatepicker1','placeholder'=>'Joining Date')) !!}
						<span class="input-group-addon bg-custom b-0 text-white"><i class="icon-calender"></i></span>
						</div>
					 </div>
			     </div>
				 <div  class="col-md-6">
					<div class="form-group">
					   <label>Gender</label>
				  <div> 			  
				 <div class="radio radio-info radio-inline">
				  <input id="inlineRadio1" value="1" name="gender" <?php echo ($inputData['gender']==1)?'checked=""':''; ?> type="radio">
					<label for="inlineRadio1"> Male</label>
				 </div> 
				 <div class="radio radio-info radio-inline">
					<input id="gender" value="2" name="gender" <?php echo ($inputData['gender']==2)?'checked=""':''; ?> type="radio">
					<label for="inlineRadio2">Female</label>
				 </div>
</div>
					</div>
				 </div>
				 
			 </div>
	   
		  </div>
		 <div class="clear"></div>
		<hr>
		 
		 
		 
		 <div>
			<h4  class="header-title m-t-0 m-b-20 col-md-12"><strong>Access Privileges</strong></h4>
			<div class=" col-md-12">
			 <div class="form-group ">
			       <?php $disabled = (Session::get('Users.type')==2)?'disabled=""':''; ?>
				  <div class="radio radio-info radio-inline">
				  <input id="inlineRadio4"  name="type" value="1" <?php echo ($inputData['type']==1)?'checked=""':'';?> <?php echo $disabled; ?>  type="radio">
					<label for="inlineRadio4"> Administrator  </label>
				  </div>
				  
				  <div class="radio radio-info radio-inline">
				  <input id="inlineRadio5"  name="type" value="2" <?php echo ($inputData['type']==2)?'checked=""':'';?> <?php echo $disabled; ?> type="radio">
					<label for="inlineRadio5"> Manager   </label>
				  </div>
				  
				  
				  <div class="radio radio-info radio-inline">
				  <input id="inlineRadio6"  name="type" value="3" <?php echo ($inputData['type']==3)?'checked=""':'';?> <?php echo $disabled; ?> type="radio">
					<label for="inlineRadio6"> Employee</label>
				  </div>
			 </div>
			 </div>
			<div class="col-md-6">
			 <div class="form-group">
				<label>Employee ID</label>
				{!! Form::text('employee_id',@$inputData['employee_id'],array('class'=>'form-control','placeholder'=>'Employee ID')) !!}
			 </div>
			 </div>
			 
			<div class="col-md-6">
			 <div class="form-group">
				<label>Date of Birth</label>
				<div class="input-group">
				{!! Form::text('dob',@$inputData['dob'],array('class'=>'form-control','id'=>'editdatepicker','placeholder'=>'Date Of Birth')) !!}
				<span class="input-group-addon bg-custom b-0 text-white"><i class="icon-calender"></i></span>
				<input type="hidden" id="hidden_id" name="hidden_id" value="<?php echo @$inputData['id'];?>"/>
				<input type="hidden" id="profile_pic_old" name="profile_pic_old" value="<?php echo @$inputData['profile_pic'];?>"/>
				</div>
			 </div>
			  </div>
			 
			<div class="col-md-6">
			 <div class="form-group">
				<label>Emergency Contact</label>
				{!! Form::text('emergency_contact',@$inputData['emergency_contact'],array('class'=>'form-control','placeholder'=>'Emergency Contact')) !!}
				</div>
			  </div>
			 
			<div class="col-md-6">
			 <div class="form-group">
				<label>Emergency Number</label>
				{!! Form::text('emergency_number',@$inputData['emergency_number'],array('class'=>'form-control','placeholder'=>'Emergency Number','onkeypress'=>'return isNumber(event)')) !!}
			  </div>
			  </div>
			<div class="col-md-12">
			 <div class="form-group">
				<label>Additional Notes</label>
				{!! Form::textarea('notes',@$inputData['notes'],array('class'=>'form-control','rows' =>4,'placeholder'=>'Additional Notes')) !!}
			  </div>
			  </div>
		 </div>
	  </div>
  </div>  
  <div class="tab-pane" id="editl2">
   <div class="positions-tab">
	   <h4>Select the locations that {{$inputData['firstname']}}&nbsp;{{$inputData['lastname']}} can work at:</h4>
		<div>
			<button type="button"  class="btn btn-white btn-custom waves-effect" id="EditLocationSelectAll">Select All</button>
			<button  type="button" class="btn btn-white btn-custom waves-effect" id="EditLocationClearAll">Clear All</button>
		 </div>
		 <div class="location-list">
			<div class="row">
			 <div class="check-design">
				 <?php 
				 $location_ids =  explode(',',@$inputData['location_ids']);
				 if($Locationlist):
					foreach($Locationlist as $location):
				 ?>
				 <div class="col-md-4 col-xs-6 col-sm-6">
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
  </div>
  <div class="tab-pane" id="editl3">
	 <div class="staff-list-main">
	   <h4>Select the positions that {{$inputData['firstname']}}&nbsp;{{$inputData['lastname']}} can work in:</h4>
		<div>
			<button type="button"  class="btn btn-white btn-custom waves-effect" id="EditPositionSelectAll">Select All</button>
			<button  type="button" class="btn btn-white btn-custom waves-effect" id="EditPositionClearAll">Clear All</button>
		</div>
		<div class="location-list">
			<div class="row">
			 <div class="check-design">
				 <?php 
				 $position_ids =  explode(',',@$inputData['position_ids']);
				 if($PositionList):
					foreach($PositionList as $Position):
				 ?>
				 <div class="col-md-4 col-sm-6 col-xs-6">
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
<div class="tab-pane" id="editl4">
	<div class="staff-list-main">
	   <h4>For budgeting, set how much gets paid:</h4>
		 <div class="rate">
			 <div class="row m-t-20">
				<div class="col-lg-6"> 
					<ul class="nav nav-tabs tabs tabs-top">
						<li class="active tab">
							<a href="#editWages21" data-toggle="tab" aria-expanded="false"> 
								<span class="visible-xs"><i class="fa fa-home"></i></span> 
								<span class="hidden-xs">Hourly Wage </span> 
							</a> 
						</li> 
						<li class="tab"> 
							<a href="#editWages22" data-toggle="tab" aria-expanded="false"> 
								<span class="visible-xs"><i class="fa fa-user"></i></span> 
								<span class="hidden-xs">Yearly Salary </span> 
							</a> 
						</li> 
					</ul> 
					<div class="tab-content" style="padding: 30px 15px;"> 
						<div class="tab-pane active custom-tab-style" id="editWages21"> 
						    <p><span><strong>Standard Rate:</strong> $ <button type="button" class="editable editable-click addButton" ><?php echo (!empty($wages['standard_rate']))?$wages['standard_rate']:'Set Rate'; ?></button><span class='TextBoxesGroup' style="display:none;">{!! Form::text('standard_rate',@$wages['standard_rate'],array('class'=>'form-control-custom','placeholder'=>'Standard Rate/per hour','onkeypress'=>'return isNumber(event)')) !!}   </span> <span class="removeButton" style="display:none">
						  
							  <input type='button' value='Remove' class="btn btn-danger " style="padding: 4px 12px;">
							  </span> </p>
							<p><span><strong>Saturday Rate:</strong> </span>$ <button type="button" class="editable editable-click addButton" ><?php echo (!empty($wages['saturday_rate']))?$wages['saturday_rate']:'Set Rate'; ?></button><span class='TextBoxesGroup' style="display:none;">{!! Form::text('saturday_rate',@$wages['saturday_rate'],array('class'=>'form-control-custom','placeholder'=>'Saturday Rate/per hour','onkeypress'=>'return isNumber(event)')) !!}  </span> <span class="removeButton" style="display:none">
							  <input type='button' value='Remove' class="btn btn-danger "  style="padding: 4px 12px;">
							  </span> </p>
							<p><span><strong>Sunday Rate:</strong> </span>$ <button type="button" class="editable editable-click addButton" ><?php echo (!empty($wages['sunday_rate']))?$wages['sunday_rate']:'Set Rate'; ?></button><span class='TextBoxesGroup' style="display:none;">{!! Form::text('sunday_rate',@$wages['sunday_rate'],array('class'=>'form-control-custom','placeholder'=>'Sunday Rate/per hour','onkeypress'=>'return isNumber(event)')) !!} </span> <span class="removeButton" style="display:none">
							  <input type='button' value='Remove' class="btn btn-danger" style="padding: 4px 12px;">
							  </span> </p>
							<p><span><strong>Holiday Rate:</strong> </span>$ <button type="button" class="editable editable-click addButton" ><?php echo (!empty($wages['holiday_rate']))?$wages['holiday_rate']:'Set Rate'; ?></button><span class='TextBoxesGroup' style="display:none;"> {!! Form::text('holiday_rate',@$wages['holiday_rate'],array('class'=>'form-control-custom','placeholder'=>'Holiday Rate/per hour','onkeypress'=>'return isNumber(event)')) !!} </span> <span class="removeButton" style="display:none">
							  <input type='button' value='Remove' class="btn btn-danger" style="padding: 4px 12px;">
							  </span> </p>
							<p><span><strong>Overtime Rate:</strong> </span>$ <button type="button" class="editable editable-click addButton" ><?php echo (!empty($wages['overtime_rate']))?$wages['overtime_rate']:'Set Rate'; ?></button><span class='TextBoxesGroup' style="display:none;"> {!! Form::text('overtime_rate',@$wages['overtime_rate'],array('class'=>'form-control-custom','placeholder'=>'Overtime Rate/per hour','onkeypress'=>'return isNumber(event)')) !!} </span> <span class="removeButton" style="display:none">
							  <input type='button' value='Remove' class="btn btn-danger" style="padding: 4px 12px;">
							  </span> </p>
						</div> 
						<div class="tab-pane" id="editWages22">
						   <p><strong>Yearly Rate:</strong> </span>$ <button type="button" class="editable editable-click addButton" ><?php echo (!empty($wages['yearly_rate']))?$wages['yearly_rate']:'Set Rate'; ?></button><span class='TextBoxesGroup' style="display:none;"> {!! Form::text('yearly_rate',@$wages['yearly_rate'],array('class'=>'form-control-custom','placeholder'=>'Yearly Rate/per annum','onkeypress'=>'return isNumber(event)')) !!} </span> <span class="removeButton" style="display:none">
                          <input type='button' value='Remove' class="btn btn-danger " style="padding: 4px 12px;">
                          </span>  </p>
						</div>  
					</div> 
				</div> 
			</div>
			<div class="m-t-20 col-md-12">
			    <?php if($inputData['status']==2):?><button type="submit"  id="submit_users" class="btn btn-success waves-effect waves-light">Update & Send Invitation</button>
				<?php else: ?><button type="submit"  id="submit_users" class="btn btn-success waves-effect waves-light">Update</button><?php endif;?>
			</div>
			
		 </div>
	 </div>
  </div>
</div>

{!! Form::close() !!}
<?php endif;?>
