<?php if($Userlists):
  foreach($Userlists as $user):
 ?>
<?php $img = ($user['profile_pic'])?('profile/'.$user['profile_pic']):'noimage.png'; ?>
<li data-id ="{{ $user['id']}}" class="liclick liclick_<?php echo $user['id'];?>"><span><img src="{{ asset('images/'.$img) }}" ></span><?php echo $user['firstname']." ".$user['lastname'];?> </li>
<?php endforeach; else: ?>
<li>No Users</li>
 <?php endif;?>