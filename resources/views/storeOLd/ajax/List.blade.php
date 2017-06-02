 <?php if($Locationlist):
foreach($Locationlist as $Location):
?>
<li data-id ="{{ $Location['location_id']}}" class="liclick liclick_<?php echo $Location['location_id'];?>"><?php echo $Location['location_name'];?> </li>
<?php endforeach;
endif;?>