<!DOCTYPE html>
<html>
    <head>
        @include('backend.admininclude.head')
        <style>
            .sidebar-menu .treeview-menu>li>a{
                padding: 10px 10px 10px 15px;
            }
            .content-header>h1 {
                font-size: 16px;
            }
        </style>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <!-- Site wrapper -->
        <div class="wrapper">
            @include('backend.admininclude.header')
            @include('backend.admininclude.sidebar')
            
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        View Users
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                        <li><a class="active">View Users</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <!-- Default box -->
                    <div class="box">
					   @if(Session::has('validate'))
						<div class="box-header with-border">
							<div class="alert alert-{{ Session::get('msgtype') }} alert-dismissable">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								{{ Session::get('validate') }}
							</div>
						</div>
						{{ Session::forget('validate') }}
					   @endif
					  @if(Session::has('Status'))
                            <div class="col-md-12">

                                <?php 
                                    if(Session::get('Status')==1){?>
                                        <div class="alert alert-success"> 
                                <?php }else{ ?>
                                        <div class="alert alert-danger"> 
                                <?php  }?>
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <ul>
                                               {{ Session::get('message') }}
                                            </ul>
                                        </div>
                            </div>
                            {{ Session::forget('Status')}}
                            {{ Session::forget('message')}}
                            @endif
                        <div class="box-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
											<th>Email</th>
											<th>Registered By </th>
											<th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
										
                                        if (@$users){
                                            $i=1;
                                            foreach ($users as $user) {
                                                ?>
                                                <tr>
													<td><?php echo $user['firstname'].' '.$user['lastname'];?></td>
													<td><?php echo $user['email'];?></td>
													<td><?php echo ($user['registered_by']==1)?'User':'Admin';?></td>
													<td><?php echo ($user['status']==0)?'InActive':'Active';?></td>
                                                    <td>
                                                     <a href="{{ url('/admin/editUser')}}/<?php echo $user['id']?>" class="btn btn-primary"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
													<?php if($user['status']==0){?><a href="{{ url('/admin/statusUser')}}/1/<?php echo $user['id'];?>" title="Activate" class="btn btn-success"><i class="fa fa-thumbs-o-up"></i></a><?php } else{?><a href="{{ url('/admin/statusUser')}}/0/<?php echo $user['id'];?>" class="btn btn-warning"><i class="fa fa-thumbs-o-down"></i></a><?php }?> 
                                                    <a href="{{ url('/admin/statusUser')}}/4/<?php echo $user['id'];?>" title="Activate" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                                    </td>
                                                </tr>  
                                                <?php $i++;
                                                }
                                            }else{
                                            ?>
											<tr><td colspan="5" style="text-align: center;"><strong>No Record Found !!</strong></td></tr>
											<?php } ?>
                                    </tbody>
                                </table>
                            </div><!-- /.box-body -->
                        </div><!-- /.box-body -->
                </section><!-- /.content -->
            </div><!-- /.box -->

        </div><!-- /.content-wrapper -->


            @include('backend.admininclude.footer')
        </div><!-- ./wrapper -->
    </body>
</html>


