<?php if($UserTargetList): ?>
<table class="table table-striped table-head fixtable">
	<thead>
		<td><strong>Name</strong></td>
        <td><strong>Weekly (Total Hours)</strong></td>
		<td><strong>Weekly Target ( Percentage )</strong></td>
		<td><strong>Weekly Target Acheived</strong></td>
	</thead>
  <tbody>
<?php foreach($UserTargetList as $UserTarget):
?>
	  <tr>
        <td><?php echo $UserTarget['name'];?></td>
        <td><?php echo $UserTarget['user_total_hrs'];?></td>
		<td><?php echo  $UserTarget['user_total_hrs_percentage']." %";?></td>
		   <td><?php echo '$ '.$UserTarget['user_week_target'];?></td>
      </tr>
<?php endforeach;?>
	  </tbody>
  </table>
<?php endif;?>