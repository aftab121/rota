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
}else{
?><div class="no-roster "><div>There aren't any shifts this week.</div><div>If you are expecting to be rostered</div><div>try checking again later...</div></div>
<?php
}?>
</div>