@extends('layouts.home')
@section('title', 'Organization')
@section('content')
<!-- Begin page -->
        <div id="wrapper">
			@include('elements.TopNav')
            
            
			@include('elements.sidebar')

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container">

                        <!-- Page-Title -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="page-header-2">
                                    <h4 class="page-title">Dashboard</h4>
                                    <ol class="breadcrumb">
                                        <li>
                                            <a href="#">Home</a>
                                        </li>
                                        
                                        <li class="active">
                                            Dashboard
                                        </li>
                                    </ol>
                                </div>
                            </div>
                        </div>

                       
  
  
<div class="row">
                    </div>  
  
  

                    </div> <!-- container -->

                </div> <!-- content -->

                @include('elements.footer')
            </div>


            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->
 
@stop
