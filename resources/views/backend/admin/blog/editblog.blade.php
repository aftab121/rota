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
                        Edit Blog 
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                        <li><a class="active">Edit Blog </a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <!-- Default box -->
                    <div class="box">
					   @if(!empty($response))
                            <div class="box-header with-border">
                                <div class="alert alert-{{ $response['Status']}} alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    {{ $response['message']}}
                                </div>
                            </div>
                        @endif
                        <div class="box-body">
                            <!-- right column -->
                            <div class="col-md-12">
                                <!-- Horizontal Form -->
                                <div class="box box-info">
                                    <!-- form start -->
                                    
                                     {!! Form::open(array('url' => '#','class'=>'form-horizontal','files'=>'true')) !!}
                                         <div class="box-body">
										    
                                            <div class="form-group">
                                                <label for="current" class="col-sm-2 control-label">Blog Title<em class="text-danger">*</em></label>
                                                <div class="col-sm-10">
                                                     {!! Form::text('blog_title',@$inputData['blog_title'],array('class'=>'form-control')) !!}
                                                </div>
                                            </div>
											<div class="form-group">
                                                <label for="password" class="col-sm-2 control-label">Blog Description<em class="text-danger">*</em></label>
                                                <div class="col-sm-10">
                                                     {!! Form::textarea('blog_description',@$inputData['blog_description'],array('class'=>'form-control','rows' => '5')) !!}
                                                </div>
                                            </div>
											
											<div class="form-group">
                                                <label for="password" class="col-sm-2 control-label">Blog Image </label>
                                                <div class="col-sm-4">
                                                     {!! Form::file('blog_image')!!}
                                                </div>
												<div class="col-sm-6">
                                                     <?php if(!empty($old_file['blog_image'])){?>
													<img src="{{ asset('images/blogImages/'.$old_file['blog_image']) }}" style="width:150px"><?php }else{?>No Image<?php }?>
                                                </div>
                                            </div>
											<div class="form-group">
                                                <label for="password" class="col-sm-2 control-label">Blog Video </label>
                                                <div class="col-sm-4">
                                                     {!! Form::file('blog_video')!!}
                                                </div>
												<div class="col-sm-6">
												
												   <?php  if(!empty($old_file['blog_video'])){ ?><video width="180" height="100" controls>
													<source src="{{ asset('images/blogVideo/'.$old_file['blog_video']) }}" type="video/mp4"></video><?php }else{?>No Video<?php }?>
											    </div>
                                            </div>
											
											<div class="form-group">
                                                <label for="confirm" class="col-sm-2 control-label">Blog Status<em class="text-danger">*</em></label>
                                                <div class="col-sm-10">
												    <?php  //$status = array(0=>'Inactive',1=>'Active'); ?>
                                                     <label class="radio-inline">
														{{ Form::radio('status', '0', @$inputData['status']==0?true: (!isset($inputData['status'])? true:false ) ) }} 
													Inactive </label>
													<label class="radio-inline">
														{{ Form::radio('status', '1', @$inputData['status']==1?true: false)  }} 
													Active </label>
                                                </div>
                                            </div>
                                        </div><!-- /.box-body -->
                                        <div class="box-footer">
                                            <button type="reset" class="btn btn-default">reset</button>
                                            <button type="submit" class="btn btn-info pull-right">Save</button>
                                        </div><!-- /.box-footer -->
                                     {!! Form::close() !!}
                                </div><!-- /.box -->
                            </div><!--/.col (right) -->
                        </div>   <!-- /.row -->
                    </div><!-- /.box-body -->
                </section><!-- /.content -->
            </div><!-- /.box -->

        </div><!-- /.content-wrapper -->


            @include('backend.admininclude.footer')
        </div><!-- ./wrapper -->
    </body>
</html>


