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
    <body class="skin-blue sidebar-mini">
        <!-- Site wrapper -->
        
        <div class="wrapper">
            @include('backend.admininclude.header')
            @include('backend.admininclude.sidebar')
            
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                    Dashboard
                    <small>Control panel</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Dashboard</li>
                    </ol>
                </section>
                <!-- Main content -->
                <section class="content">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3>150</h3>
                                    <p>Events</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div><!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-yellow">
                                <div class="inner">
                                    <h3>44</h3>
                                    <p>User Registrations</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div><!-- ./col -->
                    </div><!-- /.row -->
                                        <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->
                        <section class="col-lg-7 connectedSortable">
                        </section><!-- /.Left col -->
                        <!-- right col (We are only adding the ID to make the widgets sortable)-->
                        <section class="col-lg-5 connectedSortable">
                            
                        </section><!-- right col -->
                    </div><!-- /.row (main row) -->
                </section><!-- /.content -->
            </div>
            @include('backend.admininclude.footer')
        </div><!-- ./wrapper -->
    </body>
</html>