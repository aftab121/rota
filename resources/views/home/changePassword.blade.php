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
                                    <h4 class="page-title">Change Password</h4>
                                    <ol class="breadcrumb">
                                        <li>
                                            <a href="#">Home</a>
                                        </li>
                                        
                                        <li class="active">
                                            Change Password
                                        </li>
                                    </ol>
                                </div>
                            </div>
                        </div>

                       <!-- Basic Form Wizard -->
                        <div class="row">
						    
                            <div class="row">
                             <div class="col-md-12">
                              <div class="col-md-offset-3 col-md-6">
                            	<div class="card-box">
                            		<h4 class="m-t-0 m-b-30 header-title" style="border-bottom: 1px solid #eee;
padding-bottom: 18px;"><b>Change Password</b></h4>
                            		<div class="box-header with-border col-md-12" id="success"></div>
							<div class="box-header with-border col-md-12" id="failure"></div>
									{!! Form::open(array('url' => '#','id'=>'form','class'=>'form-horizontal m-t-20')) !!}  
                                        <div>
                                            <section>
                                                <div class="form-group clearfix">
                                                    <label class="col-lg-4 control-label " for="password"> Old Password *</label>
                                                    <div class="col-lg-8">
                                                        {!! Form::password('old_password',array('class'=>'form-control','placeholder'=>'Old Password')) !!}
                   
                                                    </div>
                                                </div>

                                                <div class="form-group clearfix">
                                                    <label class="col-lg-4 control-label " for="password">New Password *</label>
                                                    <div class="col-lg-8">
                                                        {!! Form::password('password',array('class'=>'form-control','placeholder'=>'New Password')) !!}
                                                    </div>
                                                </div>

                                                <div class="form-group clearfix">
                                                    <label class="col-lg-4 control-label " for="confirm">Confirm New Password *</label>
                                                    <div class="col-lg-8">
                                                       {!! Form::password('password_confirmation',array('class'=>'form-control','placeholder'=>'Confirm New Password')) !!}
                   
                                                    </div>
                                                </div>
												<div class="form-group text-right m-b-0">
													<button class="btn btn-default waves-effect waves-light" id="changePass" type="button">
														Submit
													</button>
													<button type="reset" class="btn btn-danger waves-effect waves-light m-l-5">
														Cancel
													</button>
												</div>
                                                
                                            </section>
                                           </div>
                                    {!! Form::close() !!}
                                    
                            	</div></div></div>
                        	</div>
                    	</div>

                        <!-- End row -->
     

                    </div> <!-- container -->

                </div> <!-- content -->
		<script>
            var resizefunc = [];
        </script>
                @include('elements.footer')
            </div>
<script type="text/javascript">
$(document).ready(function(){
	$("#changePass").click(function(){
		var data = $('#form').serialize();
		$.ajax({
			type: "POST",
			url: "<?php url('/changePassword')?>",
			data: data,
			dataType: 'json',
			success: function (res) {
				$('#verifyMessage').hide();
				if (res.Status=='success'){
					$('#success').html('<div class="alert alert-success  alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>' + res.message + '</span></div>');
					//window.location.href = '<?php url('/dashboard');?>';
				} else {
					$('#success').html('');
				}
				if (res.Status=='danger') {
					$('#failure').html('<div class="alert alert-danger  alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>' + res.message + '</span></div>');
				} else {
					$('#failure').html('');
				}
				
			}
        });
	});
});
</script>

            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->
 
@stop
