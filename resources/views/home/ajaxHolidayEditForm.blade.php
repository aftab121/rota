<div  id="Holidayeditsuccess"></div>
	<div  id="Holidayeditfailure"></div>
	<div class="col-md-3"></div>
	<div class="col-md-6" >
	<?php // print_r($HolidayData);exit;?>
		<div class="row" >
		  {!! Form::open(array('url' => '#','id'=>'editHoliday','class'=>'form-horizontal m-t-20')) !!} 
		  
		  <div class="form-group">
				<label class="col-md-3 control-label" for="example-email">Country</label>
				<div class="col-md-9">
					{!! Form::select('country_id',$countries,$HolidayData['country_id'],array('class'=>'form-control','id'=>'editcountry_name','placeholder'=>'Select Country'))!!}
				</div>
		  </div>
		  <div class="form-group" >
			<label class="col-md-3 control-label">Year</label>
			<div class="col-md-9">
				<select name="year" id="edityear" class="form-control">
				<?php $year=date('Y');
				$count = $year+5;
				for($year;$year<=$count;$year++){ ?>
					 <option value="<?php echo $year; ?>" <?php if($HolidayData['year']==$year){echo "selected";}?>><?php echo $year; ?></option>
				<?php } ?>
				</select>

			
			</div>
		  </div>
		  <div class="form-group clearfix">
			
			  <label  class="col-md-3 control-label">Description</label>
			   <div class="col-md-9">
			    {!! Form::text('holiday_name',$HolidayData['holiday_name'],array('class'=>'form-control','placeholder'=>'Description')) !!}
				{!! Form::hidden('id',$HolidayData['id'],array('class'=>'form-control','placeholder'=>'hidden_id')) !!}
			 
			  </div>
		  </div>
		  <div class="form-group clearfix">
		  
			  <label class="col-md-3 control-label">Date</label>
			   <div class="col-md-9">
			<div class="input-group">
			    {!! Form::text('holiday_date',$HolidayData['holiday_date'],array('class'=>'form-control editdatepicker-autoclose','placeholder'=>'mm/dd/YYYY','id'=>'editdatepicker-autoclose')) !!}
				<span class="input-group-addon bg-custom b-0 text-white"><i class="icon-calender"></i></span>
			</div>
			
			  </div>
		  </div>
		  <div class="form-group">
			  <div class="col-md-offset-3 col-md-9">
			 <button type="submit" class="btn btn-success waves-effect waves-light">Update</button>
			 </div>
		  </div>
		  {!! Form::close() !!} 
		</div>
	</div>
</div>
