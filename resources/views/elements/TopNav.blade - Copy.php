<!-- Top Bar Start -->
            <div class="topbar">

                <!-- LOGO -->
                <div class="topbar-left">
                    <div class="text-center">
                       <!-- <a href="index.html" class="logo">
                         <img src="assets/images/logo-light.png"  alt="rota"/>
                        </a>-->
                        <!-- Image Logo here -->
                        <a href="{{ URL('/') }}" class="logo">
                            <i class="icon-c-logo"> <img src="{{ asset('images/logo-sm.png')}}" /> </i>
                            <span><img src="{{ asset('images/logo-light.png')}}" /></span>
                        </a>
                    </div>
                </div>
<?php  $controller = substr(class_basename(Route::currentRouteAction()), 0, (strpos(class_basename(Route::currentRouteAction()), '@') -0)); ?>
                <!-- Button mobile view to collapse sidebar menu -->
                <nav class="navbar navbar-default" role="navigation">
                    <div class="container">
                        <div class="">
                           <!--  <div class="pull-left">
                                <button class="button-menu-mobile open-left waves-effect waves-light">
                                    <i class="md md-menu"></i>
                                </button>
                                <span class="clearfix"></span>
                            </div> -->
        <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">

            <span class="sr-only">Toggle navigation</span>

            <span class="icon-bar"></span>

            <span class="icon-bar"></span>

            <span class="icon-bar"></span>

        </button>

        
                            <div id="navbarCollapse" class="collapse custom-res navbar-collapse">
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
                            
                            
                            <ul class="nav navbar-nav navbar-right pull-right">
                               <!-- <li class="dropdown top-menu-item-xs">
                                    <a href="#" data-target="#" class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="true">
                                        <i class="icon-bell"></i> <span class="badge badge-xs badge-danger">3</span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-lg">
                                        <li class="notifi-title"><span class="label label-default pull-right">New 3</span>Notification</li>
                                        <li class="list-group slimscroll-noti notification-list">
                                           
                                           <a href="javascript:void(0);" class="list-group-item">
                                              <div class="media">
                                                 <div class="pull-left p-r-10">
                                                    <em class="fa fa-diamond noti-primary"></em>
                                                 </div>
                                                 <div class="media-body">
                                                    <h5 class="media-heading">A new order has been placed A new order has been placed</h5>
                                                    <p class="m-0">
                                                        <small>There are new settings available</small>
                                                    </p>
                                                 </div>
                                              </div>
                                           </a>

                                         
                                           <a href="javascript:void(0);" class="list-group-item">
                                              <div class="media">
                                                 <div class="pull-left p-r-10">
                                                    <em class="fa fa-cog noti-warning"></em>
                                                 </div>
                                                 <div class="media-body">
                                                    <h5 class="media-heading">New settings</h5>
                                                    <p class="m-0">
                                                        <small>There are new settings available</small>
                                                    </p>
                                                 </div>
                                              </div>
                                           </a>

                                          
                                           <a href="javascript:void(0);" class="list-group-item">
                                              <div class="media">
                                                 <div class="pull-left p-r-10">
                                                    <em class="fa fa-bell-o noti-custom"></em>
                                                 </div>
                                                 <div class="media-body">
                                                    <h5 class="media-heading">Updates</h5>
                                                    <p class="m-0">
                                                        <small>There are <span class="text-primary font-600">2</span> new updates available</small>
                                                    </p>
                                                 </div>
                                              </div>
                                           </a>
                                          <a href="javascript:void(0);" class="list-group-item">
                                              <div class="media">
                                                 <div class="pull-left p-r-10">
                                                    <em class="fa fa-user-plus noti-pink"></em>
                                                 </div>
                                                 <div class="media-body">
                                                    <h5 class="media-heading">New user registered</h5>
                                                    <p class="m-0">
                                                        <small>You have 10 unread messages</small>
                                                    </p>
                                                 </div>
                                              </div>
                                           </a>
                                           
                                           <a href="javascript:void(0);" class="list-group-item">
                                              <div class="media">
                                                 <div class="pull-left p-r-10">
                                                    <em class="fa fa-diamond noti-primary"></em>
                                                 </div>
                                                 <div class="media-body">
                                                    <h5 class="media-heading">A new order has been placed A new order has been placed</h5>
                                                    <p class="m-0">
                                                        <small>There are new settings available</small>
                                                    </p>
                                                 </div>
                                              </div>
                                           </a>
                                          
                                           <a href="javascript:void(0);" class="list-group-item">
                                              <div class="media">
                                                 <div class="pull-left p-r-10">
                                                    <em class="fa fa-cog noti-warning"></em>
                                                 </div>
                                                 <div class="media-body">
                                                    <h5 class="media-heading">New settings</h5>
                                                    <p class="m-0">
                                                        <small>There are new settings available</small>
                                                    </p>
                                                 </div>
                                              </div>
                                           </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="list-group-item text-right">
                                                <small class="font-600">See all notifications</small>
                                            </a>
                                        </li>
                                    </ul>
                                </li> -->
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
                                    <ul class="dropdown-menu">
                                        <li><a href="{{URL('changePassword')}}"><i class="ti-lock m-r-10 text-custom"></i> Change Password</a></li>
                                        <li class="divider"></li>
                                        <li><a href="{{URL('Logout')}}"><i class="ti-power-off m-r-10 text-danger"></i> Logout</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div> </div>
                        <!--/.nav-collapse -->
                    </div>
                </div>
            </div>
            <!-- Top Bar End -->
