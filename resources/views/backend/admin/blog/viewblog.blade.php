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
                        View Blogs
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                        <li><a class="active">View Blogs</a></li>
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
                                            <th>Blog Title</th>
											<th>Description</th>
											<th>Image</th>
											<th>Video</th>
											<th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        if (@$blogs) {
                                            $i=1;
                                            foreach ($blogs as $blog) {
												//print_r($event);
                                                ?>
                                                <tr>
													<td><?php echo $blog['blog_title'];?></td>
													<td><?php echo $blog['blog_description'];?></td>
													<td>
													<?php if(!empty($blog['blog_image'])){?>
													<img src="{{ asset('images/blogImages/'.$blog['blog_image']) }}" style="width:150px"><?php }else{?>No Image<?php }?></td>
													<td><?php  if(!empty($blog['blog_video'])){ ?><video width="220" height="140" controls>
													<source src="{{ asset('images/blogVideo/'.$blog['blog_video']) }}" type="video/mp4"></video><?php }else{?>No Video<?php }?></td>
													<td><?php echo ($blog['status']==0)?'InActive':'Active';?></td>
                                                    <td>
                                                     <a href="{{ url('/admin/editblog')}}/<?php echo $blog['id']?>" class="btn btn-primary"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
													<?php if($blog['status']==0){?><a href="{{ url('/admin/statusblog')}}/1/<?php echo $blog['id'];?>" title="Activate" class="btn btn-success"><i class="fa fa-thumbs-o-up"></i></a><?php } else{?><a href="{{ url('/admin/statusblog')}}/0/<?php echo $blog['id'];?>" class="btn btn-warning"><i class="fa fa-thumbs-o-down"></i></a><?php }?> 
                                                    <a href="{{ url('/admin/statusblog')}}/4/<?php echo $blog['id'];?>" title="Activate" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                                    </td>
                                                </tr>  
                                                <?php $i++;
                                                }
                                            }
                                            ?>
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


