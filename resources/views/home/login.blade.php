@extends('layouts.home')
@section('title', 'Login')
@section('content')
 <div class="account-pages"></div>
        <div class="clearfix"></div>
        <div class="wrapper-page">
        	<div class=" card-box">
            <div class="logo-login">
                <img src="{{ asset('images/logo.png') }}" alt="rota">  
            </div>
            
            <div class="panel-heading no-pad text-center"> 
                <h3> Login</h3>
            </div> 


            <div class="panel-body no-pad">
			@if(!empty($verifyMessage['message']))
				<div class="box-header with-border" id="verifyMessage">
					<div class="alert alert-{{$verifyMessage['status']}} alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						{{ $verifyMessage['message']}}
					</div>
				</div>
			@endif
			<div class="box-header with-border" id="success"></div>
			<div class="box-header with-border" id="failure"></div>
            {!! Form::open(array('url' => '#','id'=>'form','class'=>'form-horizontal m-t-20')) !!}    
                <div class="form-group ">
                    <div class="col-xs-12">
                         {!! Form::text('email',@$inputData['email'],array('class'=>'form-control','placeholder'=>'Email')) !!}
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-12">
                       {!! Form::password('password',array('class'=>'form-control','placeholder'=>' Password')) !!}
                    </div>
                </div>

                <div class="form-group ">
                    <div class="col-xs-12">
                        <div class="checkbox checkbox-primary">
                            <input id="checkbox-signup" type="checkbox">
                            <label for="checkbox-signup">
                                Remember me
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="form-group text-center m-t-40">
                    <div class="col-xs-12">
                        <button class="btn btn-pink btn-block text-uppercase waves-effect waves-light" id="login-form-submit" type="button">Log In</button>
                    </div>
                </div>

                <div class="form-group m-t-30 m-b-0">
                    <div class="col-sm-12">
                        <a href="{!! URL('ForgetPassword')!!}" class="text-dark"><i class="fa fa-lock m-r-5"></i> Forgot your password?</a>
                    </div>
                </div>
            {!! Form::close() !!}
            
            </div>   
            </div>                              
                <div class="row">
            	<div class="col-sm-12 text-center">
            		<p>Don't have an account? <a href="{!! URL('Register')!!}" class="text-primary m-l-5"><b>Sign Up</b></a></p>
                        
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
	$("#login-form-submit").click(function(){
		var data = $('#form').serialize();
		$.ajax({
			type: "POST",
			url: "<?php url('/Login')?>",
			data: data,
			dataType: 'json',
			success: function (res) {
				$('#verifyMessage').hide();
				if (res.Status=='success') {
					$('#success').html('<div class="alert alert-success  alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>' + res.message + '</span></div>');
					window.location.href = '<?php url('/dashboard');?>';
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