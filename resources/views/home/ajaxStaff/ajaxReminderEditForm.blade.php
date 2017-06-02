<div class="col-md-12">
				<div  id="editStaffsuccess"></div>
				<div  id="editStafffailure"></div>
			</div>
			<div class="col-md-7 col-md-offset-2">
				<div class="row">
				     <?php //print_r($StaffDateReminders); ?>
					
					{!! Form::open(array('url' => '#','id'=>'EditReminder','class'=>'form-horizontal m-t-20')) !!} 
					<div class="form-group clearfix">
						<div class="row">
							<label class="col-md-3 control-label">Date Name</label>
							<div class="col-md-9">
								{!! Form::text('date_name',$StaffDateReminders['date_name'],array('class'=>'form-control','placeholder'=>'Enter Name for date type')) !!}
							</div>
						</div>
					</div>
					<div class="form-group clearfix">
					    <div class="row">
							<label class="col-md-3 control-label">Set Reminder</label>    
							<div class="radio radio-info radio-inline">
								<input id="editsetReminder" value="1" name="editsetReminder" <?php echo  ($StaffDateReminders['set_reminders']==1)?'checked=""':'';?> type="radio">
								<label for="inlineRadio1"> Yes</label>
							</div> 
							<div class="radio radio-info radio-inline">
								<input id="setReminder1" value="0" <?php echo  ($StaffDateReminders['set_reminders']==0)?'checked=""':'';?> name="editsetReminder" type="radio">
								<label for="inlineRadio2">No</label>
							</div>
						</div>
					</div>
					<div class="form-group clearfix" id="editdays_toggle" style="display:<?php echo ($StaffDateReminders['set_reminders']==0)?'none':'block';?>">
						<div class="row">
							<label class="col-md-3 control-label">Days in Advance</label>
							<div class="col-md-9">
								{!! Form::number('days_advance',$StaffDateReminders['days_advance'],array('class'=>'form-control','min'=>'0','max'=>'100','placeholder'=>'Enter No. of Days in Advance')) !!}
								{!! Form::hidden('id',$StaffDateReminders['id'],array('class'=>'form-control','placeholder'=>'Enter No. of Days in Advance')) !!}
							
							</div>
						</div>
					</div>
					<div class="col-md-offset-3 col-md-9">
						<button type="submit" class="btn btn-success waves-effect waves-light">Update</button>
					</div>
					{!! Form::close() !!} 
				</div>
			</div>