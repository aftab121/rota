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
.back .btn {
    border-radius: 0;
    outline: none !important;
    margin-right: 5px;
}
.back .btn:hover
{
border: 1px solid #5fbeaa !important;
background: #fff !important;
color: #5fbeaa !important;
}
.print-style
{
	border:2px solid #ccc;
	padding:20px;
	text-align:center;
	margin:20px 0px;
	height:600px;
}
.print-date-tym
{
    text-align: left;
    font-size: 13px;
    text-transform: capitalize;
    color: #959595;
}
td,th
{
padding:8px;}
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
            <div class="col-md-8">
              <div class="row">
                <div class="col-md-12">
                  <div class="btn-group" role="group" aria-label="...">
                    <button type="button" class="btn btn-default"><i class="fa fa-bars" aria-hidden="true"></i></button>
                    <div class="btn-group" role="group">
                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Export <span class="caret"></span> </button>
                      <ul class="dropdown-menu">
                        <li><a href="#">Pdf</a></li>
                      </ul>
                    </div>
                    <button type="button" class="btn btn-default"><i class="fa fa-search" aria-hidden="true"></i> Toggle zoom</button>
                  </div>
                </div>
              </div>
              <div class="row print-style">
                <div class="col-md-12 ">
                  <p class="print-date-tym"> printed : 4 may 11:12 am</p>
                  <table width="100%" border="0" cellspacing="5" cellpadding="5">
                    <tr>
                      <td><h3>Nextolive - Week started from sunday ,april 23, 2017 (published)</h3></td>
                    </tr>
                    <tr>
                      <td><h4 style="color:red;">opps , we could not find any 'published' shifts for this week</h4>
                        <p>Try returning to the schedule </p></td>
                    </tr>
                  </table>
                  <table width="100%" border="1"  cellpadding="7">
                    <tr>
                      <td>Name</td>
                      <td>Sun Apr 23</td>
                      <td>Mon Apr 24</td>
                      <td>Tue Apr 25</td>
                      <td>Wed Apr 26</td>
                      <td>Thu Apr 27</td>
                      <td>Fri Apr 28</td>
                      <td>Sat Apr 29</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                  </table>
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