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
                        Change Password
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                        <li><a class="active">Change Password</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <!-- Default box -->
                    <div class="box">

                            @if(Session::has('validate'))
                            <div class="box-header with-border">
                                <div class="alert alert-{{ Session::get('msgtype')  }} alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    {{ Session::get('validate')  }}
                                </div>
                            </div>
                            @endif
                       
                       
                        <div class="box-body">
                            <!-- right column -->
                            <div class="col-md-12">
                                <!-- Horizontal Form -->
                                <div class="box box-info">
                                    <!-- form start -->
                                    
                                     {!! Form::open(array('url' => 'admin/ChangePassword','class'=>'form-horizontal')) !!}
                                        <div class="box-body">
                                            <div class="form-group">
                                                <label for="current" class="col-sm-2 control-label">Current Password <em class="text-danger">*</em></label>
                                                <div class="col-sm-10">
                                                     {!! Form::password('current',array('class'=>'form-control')) !!}
                                                </div>
                                            </div>
											<div class="form-group">
                                                <label for="password" class="col-sm-2 control-label">New Password <em class="text-danger">*</em></label>
                                                <div class="col-sm-10">
                                                     {!! Form::password('password',array('class'=>'form-control')) !!}
                                                </div>
                                            </div>
											<div class="form-group">
                                                <label for="confirm" class="col-sm-2 control-label">Confirm Password <em class="text-danger">*</em></label>
                                                <div class="col-sm-10">
                                                     {!! Form::password('confirm',array('class'=>'form-control')) !!}
                                                </div>
                                            </div>
                                        </div><!-- /.box-body -->
                                        <div class="box-footer">
                                            <button type="reset" class="btn btn-default">reset</button>
                                            <button type="submit" class="btn btn-info pull-right">Save</button>
                                        </div><!-- /.box-footer -->
                                    </form>
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


