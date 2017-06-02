@extends('layouts.home')
@section('title', 'Organization')
@section('content') 
<!-- Begin page -->
<div id="wrapper"> @include('elements.TopNav')
  @include('elements.sidebar') 
  
  <!-- ============================================================== --> 
  <!-- Start right Content here --> 
  <!-- ============================================================== -->
  <style>
 .back
 {
	 background:#fff;
	 padding:20px;
 }
 .report-list ul li
 {
 list-style:none;
 border-bottom:1px solid #e4e4e4;
 padding: 14px 15px;
 }
 .report-list ul li:hover
 {
	 background:#5fbeaa;
	 color:#fff;
 }
 .report-list
 {
 max-height: 450px;
overflow: auto;
height: 450px;
 }
 .report-list ul
 {
 padding-left:0px;}
  .report-list ul li p
 {
 margin:0px;}
 .uppercase
 {
 text-transform: uppercase;
color: #3e3e3e;
font-weight: 600;
font-size: 18px;
border-bottom: 1px solid #eaeaea;
padding: 10px 0px;}
  </style>
  <div class="content-page" style="margin-left:0px;"> 
    <!-- Start content -->
    <div class="content">
      <div class="container"> 
        <!-- Page-Title -->
        <div class="row">
          <div class="col-sm-12">
            <div class="page-header-2">
              <h4 class="page-title">Reports</h4>
              <ol class="breadcrumb">
                <li> <a href="#">Home</a> </li>
                <li class="active"> Reports </li>
              </ol>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="back clearfix">
            <div class="col-md-8 ">
              <h4 class="uppercase">Roster reports</h4>
              <div class="report-list">
              <ul>
                <li>
                  <p><b>Roster By Employee</b></p>
                  <p><i>(Generate roster by employee)</i></p>
                </li>
                <li>
                  <p><b>Roster By Employee (Condensed)</b></p>
                  <p><i>(Generate roster by employee (portrait with smaller type)</i></p>
                </li>
                <li>
                  <p><b>Roster By Employee (Enhanced)</b></p>
                  <p><i>(Generate roster by employee (landscape with calculated hours)</i></p>
                </li>
                <li>
                  <p><b>Schedule By Position</b></p>
                  <p><i>(Generate roster by position)</i></p>
                </li>
                <li>
                  <p><b>Availability Listing </b></p>
                  <p><i>(Generate a listing of all availability grouped by employee)</i></p>
                </li>
              </ul>
              </div>
            </div>
            <div class="col-md-4">
              <h4 class="uppercase m-b-20">Report Options</h4>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group clearfix">
                    <label>Locations</label>
                    <div class="dropdown clearfix"> <a style="text-align:left;" class="col-md-12 btn btn-default" id="dLabel" data-target="#" href="http://example.com" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Dropdown trigger <span class="caret" style="position: absolute;
top: 15px;
right: 15px;"></span> </a>
                      <ul class="dropdown-menu" aria-labelledby="dLabel">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Selected week</label>
                    <div>
                      <button class="btn btn-sm btn-default decWeek" data-id="-1"><i class="fa fa-chevron-left"></i></button>
                      <button class="btn btn-sm btn-default selectWeek" data-id="0">Mar 27 - Apr 2</button>
                      <button class="btn btn-sm btn-default decWeek" data-id="-1"><i class="fa fa-chevron-right"></i></button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Options</label>
                    <div>
                      <label>
                        <input type="checkbox" >
                        Published shifts only </label>
                    </div>
                    <div>
                      <label>
                        <input type="checkbox">
                        Show daily notes </label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <button class="btn col-md-12 btn-sm btn-default">Generate Report <i class="fa fa-chevron-right"></i></button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- container --> 
      
    </div>
  </div>
  
  <!-- content --> 
  <script>
  var resizefunc = [];
</script> 
  @include('elements.footer') </div>

<!-- ============================================================== --> 
<!-- End Right content here --> 
<!-- ============================================================== -->
</div>
<!-- END wrapper --> 
@stop 