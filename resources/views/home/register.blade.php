@extends('layouts.home')
@section('title', 'Register')
@section('content')
<div class="account-pages"></div>
<div class="clearfix"></div>
<div class="wrapper-page">
	<div class=" card-box">
		<div class="logo-login">
			<img src="{{ asset('images/logo.png')}}" alt="rota">  
		</div>
		<div class="panel-heading no-pad text-center"> 
			<h3> Register</h3>
		</div> 
		<div class="panel-body no-pad">
		    {!! Form::open(array('url' => '#','id'=>'form','class'=>'form-horizontal m-t-20')) !!}
				<div id="success"></div>
				<div id="failure"></div>
				<div class="form-group ">
					<div class="col-xs-6">
						 {!! Form::text('firstname',@$inputData['firstname'],array('class'=>'form-control','placeholder'=>'Firstname')) !!}
					</div>
					<div class="col-xs-6">
						{!! Form::text('lastname',@$inputData['lastname'],array('class'=>'form-control','placeholder'=>'Lastname')) !!}
					</div>
				</div>
				<div class="form-group">
					<div class="col-xs-12">
						{!! Form::text('email',@$inputData['email'],array('class'=>'form-control','placeholder'=>'Email')) !!}
					</div>
				</div>
				<div class="form-group">
					<div class="col-xs-12">
						{!! Form::text('company_name',@$inputData['company_name'],array('class'=>'form-control','placeholder'=>'Company Name')) !!}
					</div>
				</div>
				<div class="form-group">
					<div class="col-xs-12">
						{!! Form::password('password',array('class'=>'form-control','placeholder'=>' Password')) !!}
					</div>
				</div>
				<div class="form-group">
					<div class="col-xs-12">
						{!! Form::password('password_confirmation',array('class'=>'form-control','placeholder'=>'Confirm Password')) !!}
					</div>
				</div>
				<div class="form-group">
					<div class="col-xs-12">
						{!! Form::text('business_contact_no',@$inputData['business_contact_no'],array('class'=>'form-control','placeholder'=>'Business Contact No.','maxlength'=>'14','onkeypress'=>'return isNumber(event)')) !!}
					</div>
				</div>
				<div class="form-group">
					<div class="col-xs-12">
						<div class="checkbox checkbox-primary">
							<input id="checkbox-signup" type="checkbox" name="accept" >
							<label for="checkbox-signup">I accept <a href="#" target='_blank'> Terms and Conditions </a></label>
						</div>
					</div>
				</div>
				<div class="form-group text-right m-t-20 m-b-0">
					<div class="col-xs-12">
						<button class="btn btn-pink text-uppercase waves-effect waves-light w-sm" id="login-form-submit" type="button">
							Sign Up
						</button>
					</div>
				</div>	
			{!! Form::close() !!}
		</div>   
	</div>                              
	<div class="row">
		<div class="col-sm-12 text-center">
			<p>Already have account? <a href="{{ URL('Login')}}" class="text-primary m-l-5"><b>Sign in</b></a></p>	
		</div>
	</div>
</div>

	
<script>
	var resizefunc = [];
</script>

<!-- jQuery  -->
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script> 

<!--body content end-->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("#login-form-submit").click(function(){
		var data = $('#form').serialize();
		$.ajax({
			type: "POST",
			url: "<?php url('/Register')?>",
			data: data,
			dataType: 'json',
			success: function (res) {
				$('#response').addClass('alert'+res.Status);
				$('#response').addClass('alert'+res.Status);
				if (res.Status=='success') {
					$('#success').html('<div class="alert alert-success  alert-dismissable"><button class="close"  data-dismiss="alert" aria-hidden="true">×</button><span>' + res.message + '</span></div>');
				} else {
					$('#success').html('');
				}
				if (res.Status=='danger') {
					$('#failure').html('<div class="alert alert-danger  alert-dismissable"><button class="close"  data-dismiss="alert" aria-hidden="true">×</button><span>' + res.message + '</span></div>');
				} else {
					$('#failure').html('');
				}
				
			}
        });
	});
});
function isNumber(evt) {
	evt = (evt) ? evt : window.event;
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	if (charCode > 31 && (charCode < 48 || charCode > 57)) {
		return false;
	}
	return true;
}
</script>

@stop
