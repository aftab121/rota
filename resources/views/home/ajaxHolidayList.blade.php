<table class="table table-bordered"  id="datatable">
					<thead>
					  <tr>
					    <th>Country Name</th>
					    <th>Year</th>
						<th>Description</th>
						<th>Date</th>
						<th>Action</th>
					  </tr>
					</thead>
					<tbody >
					  <?php if(@$HolidayLists): 
					  foreach($HolidayLists as $HolidayList):
					  ?>
					  <tr >
						<td id="tdcountry_name_{{$HolidayList['id']}}">{{$HolidayList['country_name']}}</td>
						<td id="tdyear_{{$HolidayList['id']}}">{{$HolidayList['year']}}</td>
						<td id="tdholiday_name_{{$HolidayList['id']}}">{{$HolidayList['holiday_name']}}</td>
						<td id="tdholiday_date_{{$HolidayList['id']}}">{{$HolidayList['holiday_date']}}</td>
						<td><button class="btn btn-icon waves-effect waves-light btn-success" id="editHoliday" onclick="editHoliday({{$HolidayList['id']}})"> <i class="fa fa-pencil"></i> </button> 
<button class="btn btn-icon waves-effect waves-light btn-danger"> <i class="fa fa-remove"></i> </button>
</td>
					  </tr>
					  <?php endforeach;
					   else:?> 
					  <tr >
						<td colspan="5" > <div style="text-align:center" class="alert alert-danger">No Record Found !!</div> </td>
						</tr >
					  <?php endif;?>
					  
					</tbody>
				  </table>