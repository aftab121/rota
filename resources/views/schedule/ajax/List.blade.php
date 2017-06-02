<?php if($Positionlist):
foreach($Positionlist as $Position):
?>
<li data-id="{{ $Position['id']}}" class="liclick liclick_<?php echo $Position['id'];?>"><span></span><?php echo $Position['position_name'];?> </li>
<?php endforeach;
endif;?>