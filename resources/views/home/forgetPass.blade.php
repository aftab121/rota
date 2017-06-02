@extends('layouts.home')
@section('title', 'Forget Password')
@section('content')
 <div class="account-pages"></div>
        <div class="clearfix"></div>
        <div class="wrapper-page">
        	<div class=" card-box">
            <div class="logo-login">
                <img src="{{ asset('images/logo.png') }}" alt="rota">  
            </div>
            
            <div class="panel-heading no-pad text-center"> 
                <h3> Forgot Password</h3>
            </div> 


           <div class="panel-body no-pad">
            {!! Form::open(array('url' => '#','id'=>'form','class'=>'form-horizontal m-t-20')) !!}  
						<div class="alert alert-info alert-dismissable" style="display:none">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
								×
							</button>
							Enter your <b>Email</b> and instructions will be sent to you!
						</div>
						<div class="box-header with-border" id="success"></div>
						<div class="box-header with-border" id="failure"></div>
						<div class="form-group m-b-0">
							<div class="input-group">
								{!! Form::text('email',@$inputData['email'],array('class'=>'form-control','placeholder'=>'Email')) !!}
								<span class="input-group-btn">
									<button type="button" class="btn btn-pink w-sm waves-effect waves-light" id="forget">
										Reset
									</button> 
								</span>
							</div>
						</div>

					{!! Form::close() !!}
            
            </div>   
            </div> 
        </div>
        
        

        
    	<script>
            var resizefunc = [];
        </script>

        <!-- jQuery  -->
        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
	
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("#forget").click(function(){
		var data = $('#form').serialize();
		$.ajax({
			type: "POST",
			url: "<?php url('/forgetPassword')?>",
			data: data,
			dataType: 'json',
			success: function (res) {
				
				if (res.Status=='success') {
					$('#success').html('<div class="alert alert-success  alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>' + res.message + '</span></div>');
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

     
@stop