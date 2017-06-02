<div class="box-header with-border" id="delStaffsuccess"></div>
<div class="box-header with-border" id="delStafffailure"></div>
<div class="table-responsive" >
			<table class="table table-bordered"  id="datatable2">
				<thead>
					<tr>
						<th>Date Name</th>
						<th>Set Reminder</th>
						<th># of Days in Advance</th>
						<th>Action</th>
					</tr>
				</thead>
			<tbody>
			    <?php if(@$StaffDateReminders): 
				  foreach($StaffDateReminders as $StaffDateReminder):
				  ?>
				  <tr >
					<td id="tddate_name_{{$StaffDateReminder['id']}}">{{$StaffDateReminder['date_name']}}</td>
					<td id="tdset_reminders_{{$StaffDateReminder['id']}}"><?php echo ($StaffDateReminder['set_reminders']==1)?'Yes':'No'; ?></td>
					<td id="tddays_advance_{{$StaffDateReminder['id']}}">{{$StaffDateReminder['days_advance']}}</td>
					<td><button class="btn btn-icon waves-effect waves-light btn-success" id="editHoliday" onclick="editReminder({{$StaffDateReminder['id']}})"> <i class="fa fa-pencil"></i> </button> 
<button class="btn btn-icon waves-effect waves-light btn-danger"  id="deleteHoliday" onclick="deleteReminder({{$StaffDateReminder['id']}})"> <i class="fa fa-remove"></i> </button>
</td>
				  </tr>
				  <?php endforeach;
				  else:?> 
				  <tr >
					<td colspan="4" ><strong style="text-align:center">No Record Found !!</strong></td>
				  </tr >
				  <?php endif;?>
			</tbody>
			</table>
			</div>
		