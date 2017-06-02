<!-- Left side column. contains the sidebar -->
<?php $url = Route::currentRouteAction(); 
 $array_url = explode('@',$url);
 $function = $array_url[1];
?>
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <ul class="sidebar-menu">
            <li class="treeview <?php echo ($function=='dashboard')?'active':'';?>">
                <a href="{{ url('/admin/dashboard') }}">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="treeview <?php echo ($function=='addEventCategory'|| $function=='viewEventCategory' || $function=='editEventCategory')?'active':'';?>" >
                <a href="#">
                    <i class="fa fa-users"></i> <span>Event Category</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li <?php if($function=='addEventCategory'){echo 'class="active"'; }?> >
                        <a href="{{ url('/admin/addEventCategory') }}"><i class="fa fa-user-plus"></i> Add Event Category</a>
                    </li>
                    <li <?php if($function=='viewEventCategory' || $function=='editEventCategory' ){echo 'class="active"'; }?>><a href="{{ url('/admin/viewEventCategory') }}"><i class="fa fa-users"></i>View Event Category</a></li>
                </ul>

            </li>
			<li class="treeview <?php echo ($function=='addEvent'|| $function=='viewEvent' || $function=='editEvent')?'active':'';?>" >
                <a href="#">
                    <i class="fa fa-users"></i> <span>Event Management </span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li <?php if($function=='addEvent'){echo 'class="active"'; }?> >
                        <a href="{{ url('/admin/addEvent') }}"><i class="fa fa-user-plus"></i> Add Event </a>
                    </li>
                    <li <?php if($function=='viewEvent' || $function=='editEvent' ){echo 'class="active"'; }?>><a href="{{ url('/admin/viewEvent') }}"><i class="fa fa-users"></i>View Events</a></li>
                </ul>

            </li>
			<li class="treeview <?php echo ($function=='addblog'|| $function=='viewblog' || $function=='editblog')?'active':'';?>" >
                <a href="#">
                    <i class="fa fa-users"></i> <span>Blog Management </span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li <?php if($function=='addblog'){echo 'class="active"'; }?> >
                        <a href="{{ url('/admin/addblog') }}"><i class="fa fa-user-plus"></i> Add Blog </a>
                    </li>
                    <li <?php if($function=='viewblog' || $function=='editblog' ){echo 'class="active"'; }?>><a href="{{ url('/admin/viewblog') }}"><i class="fa fa-users"></i>View Blogs</a></li>
                </ul>
            </li>
			<li class="treeview <?php echo ($function=='addUser'|| $function=='viewUser' || $function=='editUser')?'active':'';?>" >
                <a href="#">
                    <i class="fa fa-users"></i> <span>User Management </span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li <?php if($function=='addUser'){echo 'class="active"'; }?> >
                        <a href="{{ url('/admin/addUser') }}"><i class="fa fa-user-plus"></i> Add User </a>
                    </li>
                    <li <?php if($function=='viewUser' || $function=='editUser' ){echo 'class="active"'; }?>><a href="{{ url('/admin/viewUser') }}"><i class="fa fa-users"></i>View Users</a></li>
                </ul>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
