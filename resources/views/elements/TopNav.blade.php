<div class="topbar">
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
     <a lass="navbar-brand" href="{{ URL('/') }}" class="logo">
                            <i class="icon-c-logo"> <img src="{{ asset('images/logo-sm.png')}}" /> </i>
                            <span><img src="{{ asset('images/logo-light.png')}}" /></span>
                        </a>
    </div>
<?php  $controller = substr(class_basename(Route::currentRouteAction()), 0, (strpos(class_basename(Route::currentRouteAction()), '@') -0)); ?>
 
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
     
       <ul class="nav navbar-nav  custom">
								<?php if(Session::get('Users.type')==1||Session::get('Users.type')==2):?>
								<li class="dropdown">
									<a href="#" class="dropdown-toggle waves-effect waves-light <?php echo ($controller=='HomeController'||$controller=='StoreController'||$controller=='PositionController')?'active':'';?>" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-users"></i> &nbsp; Organization <span class="caret"></span></a>
									<ul class="dropdown-menu">
									  <li><a href="{{URL('Company')}}" >Company</a></li>
									  <li><a href="{{URL('Store')}}">Store</a></li>
									  <li><a href="{{URL('Position')}}">Positions</a></li>
									  <li><a href="{{URL('Staff')}}">Staff</a></li>
									</ul>
								</li>
								<li class="dropdown">
									<a href="{{URL('Schedule')}}" class="dropdown-toggle waves-effect waves-light <?php echo ($controller=='ScheduleController')?'active':'';?>" ><i class="fa fa-calendar"></i> &nbsp; Schedule</a>
								</li>
								<?php else: ?>
								<li class="dropdown">
									<a href="{{URL('Employee')}}" class="dropdown-toggle waves-effect waves-light <?php echo ($controller=='EmployeeController')?'active':'';?>" ><i class="fa fa-user"></i> &nbsp; Profile</a>
								</li>
								<li class="dropdown">
									<a href="{{URL('employeeSchedule')}}" class="dropdown-toggle waves-effect waves-light <?php echo ($controller=='EmployeeController')?'active':'';?>" ><i class="fa fa-calendar"></i> &nbsp; Schedule</a>
								</li>
								<?php endif;?>
								
            </ul>
     
      
      <ul class="nav navbar-nav navbar-right">
        <li class="hidden-xs">
                                    <a href="#" id="btn-fullscreen" class="waves-effect waves-light"><i class="icon-size-fullscreen"></i></a>
                                </li>
                               <!-- <li class="hidden-xs">
                                    <a href="#" class="right-bar-toggle waves-effect waves-light"><i class="icon-settings"></i></a>
                                </li>-->
                                <li class="dropdown top-menu-item-xs">
                                    <a href="#" class="dropdown-toggle profile waves-effect waves-light" data-toggle="dropdown" aria-expanded="true" ><span id="topnavName"> Dear <?php echo Session::get('Users.firstname').' '.Session::get('Users.lastname'); ?></span>
									<?php $img = (!empty(Session::get('Users.profile_pic')))?('profile/'.Session::get('Users.profile_pic')):'noimage.png';  ?>
									<img src="{{ asset('images/'.$img)}}" alt="<?php echo Session::get('Users.firstname').' '.Session::get('Users.lastname'); ?>" class="img-circle"/> </a>
                                    <ul class="dropdown-menu" style="position:absolute;background:#fff;">
                                        <li><a href="{{URL('changePassword')}}"><i class="ti-lock m-r-10 text-custom"></i> Change Password</a></li>
                                        <li class="divider"></li>
                                        <li><a href="{{URL('Logout')}}"><i class="ti-power-off m-r-10 text-danger"></i> Logout</a></li>
                                    </ul>
                                </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
</div>