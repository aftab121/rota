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
                        Edit Event Category
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                        <li><a class="active">Edit Event Category</a></li>
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
                                    
                                     {!! Form::open(array('url' => '#','class'=>'form-horizontal')) !!}
                                        <div class="box-body">
                                            <div class="form-group">
                                                <label for="current" class="col-sm-2 control-label">Event Category Name<em class="text-danger">*</em></label>
                                                <div class="col-sm-10">
                                                     {!! Form::text('event_category_name',@$inputData['event_category_name'],array('class'=>'form-control')) !!}
                                                </div>
                                            </div>
											<div class="form-group">
                                                <label for="password" class="col-sm-2 control-label">Event Category Description<em class="text-danger">*</em></label>
                                                <div class="col-sm-10">
                                                     {!! Form::textarea('event_category_description',@$inputData['event_category_description'],array('class'=>'form-control','rows' => '5')) !!}
                                                </div>
                                            </div>
											<div class="form-group">
                                                <label for="confirm" class="col-sm-2 control-label">Event Category Status<em class="text-danger">*</em></label>
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


