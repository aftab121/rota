@extends('layouts.home')
@section('title', 'Organization')
@section('content')
<style>
.text-center
{
text-align:center;}
.card-box-custom 
{ 
	color:#fff;
	font-size:30px;
	display:block;
	border:0px;
}
.red
{
 background: #f74b4b;
 color:#fff;
}
.blue
{
background: #378fff;
color:#fff;
}
.yellow
{
background: #fdb024;
color:#fff;
}
.card-box-custom p
{
font-size: 18px;
text-transform: capitalize;
margin-top: 15px;
}
.primary
{

background:#5fbeaa;
color:#fff;}
legend {
display: block;
width: auto;
margin-bottom: 30px;
font-size: 26px;
line-height: inherit;
color: #616161;
border: 0;
text-align: center;
border-bottom: 0;
}
.card-box {
    padding: 10px;
  margin-bottom:10px;
    -webkit-border-radius: 0px;
    border-radius: 0;
    -moz-border-radius: 0px;
  
}
.card-box:hover
{
	background:#fff;
	color:#666;
}
fieldset {
    padding: .35em .625em .75em;
    margin: 0 2px;
    border: 1px solid #ccc;
}
.card-box-custom
{
border:0px !important;
background:transparent !important;

}
.quick-links a
{
background: #5fbeaa;
    color: #fff;
    font-size: 15px;
    padding: 10px 20px;
    display: block;
    margin: 5px 0px;
    text-align: center;
    text-transform: uppercase;
	}
	   
.quick-links a:hover
{
	 background: #31a58c;
}
</style>
<!-- Begin page -->
<div id="wrapper"> @include('elements.TopNav')
  
  
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
                <li> <a href="#">Home</a> </li>
                <li class="active"> Dashboard </li>
              </ol>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-8 col-sm-8 col-xs-12">
            <div class="row">
              <div class="card-box card-box-custom clearfix">
                <fieldset style="background:#fff;">
                  <legend>What's new in the app?</legend>
                  <div class="col-md-6 col-sm-6 text-center">
                    <div class="card-box  red"> <i class="fa fa-check-circle" aria-hidden="true"></i>
                      <p>A new way to get started! The dashboard.</p>
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-6 text-center">
                    <div class="card-box blue"> <i class="fa fa-check-circle" aria-hidden="true"></i>
                      <p>A new way to get started! The dashboard.</p>
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-6 text-center">
                    <div class="card-box primary"> <i class="fa fa-check-circle" aria-hidden="true"></i>
                      <p>A new way to get started! The dashboard.</p>
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-6 text-center">
                    <div class="card-box  yellow"> <i class="fa fa-check-circle" aria-hidden="true"></i>
                      <p>A new way to get started! The dashboard.</p>
                    </div>
                  </div>
                </fieldset>
              </div>
            </div>
          </div>
          <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="row">
              <div class="card-box card-box-custom quick-links clearfix">
                <fieldset style="background:#fff;">
                  <legend>Dashboard quick links</legend>
                  <?php if(Session::get('Users.type')==1||Session::get('Users.type')==2):?>
                  <div class="col-md-12"> <a href="{{URL('Company')}}">Manage Company Settings</a> </div>
                  <div class="col-md-12"> <a href="{{URL('Store')}}">Add / Edit Store</a> </div>
                  <div class="col-md-12"> <a href="{{URL('Position')}}">Add / Edit Positions</a> </div>
                  <div class="col-md-12"> <a href="{{URL('Staff')}}">Add / Edit staff</a> </div>
                  <div class="col-md-12"> <a href="{{URL('Position')}}">Create  &  Publish shift</a> </div>
                  <div class="col-md-12"> <a href="{{URL('Schedule')}}">Manage Schedules</a> </div>
                  <?php else: ?>
                  <div class="col-md-12"> <a href="{{URL('Employee')}}">Employee</div>
                  <?php endif;?>
                </fieldset>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- container --> 
      
    </div>
    <!-- content --> 
    
    @include('elements.footer') </div>
  
  <!-- ============================================================== --> 
  <!-- End Right content here --> 
  <!-- ============================================================== --> 
  
</div>
<!-- END wrapper --> 

@stop 