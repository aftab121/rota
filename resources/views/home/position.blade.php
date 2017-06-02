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
                                    <h4 class="page-title">Position</h4>
                                    <ol class="breadcrumb">
                                        <li>
                                            <a href="#">Home</a>
                                        </li>
                                        
                                        <li class="active">
                                            Position
                                        </li>
                                    </ol>
                                </div>
                            </div>
                        </div>

                       
  
<div class="row">
        
          <div class="col-md-3">
              <div class="store-location-list">
                  <form>
                     <div class="input-group m-b-10">
                      <input type="text" class="form-control" placeholder="Search" style="height:40px;">
                      <div class="input-group-btn">
                        <button class="btn btn-default btn-block" type="submit"><i class="fa fa-map-marker"></i> Search</button>
                      </div>
                    </div>
                  </form>
                  
                  <div class="store-list">
                     <ul>
                     <li>Manager</li>
                      <li>Sales Manager</li>
                     </ul>
                  </div>
                  
              </div>
          </div>
        
          <div class="col-lg-9 content-height">
          <div class="top-info">
                 <span> <i class="fa fa-user"></i> Manager </span>
                   <a href=""  class="btn btn-default d-inline pull-right"><i class="fa fa-plus"></i> Add New</a>
              </div>
            <ul class="nav nav-tabs">
              <li class="active"> <a href="#l1" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-cube" aria-hidden="true"></i></span> <span class="hidden-xs"><i class="fa fa-cube" aria-hidden="true"></i> Position Details</span> </a> </li>
              <li > <a href="#l2" data-toggle="tab" aria-expanded="true"> <span class="visible-xs"><i class="fa fa-location-arrow" aria-hidden="true"></i></span> <span class="hidden-xs"><i class="fa fa-location-arrow" aria-hidden="true"></i>Locations using the
 Manager position</span> </a> </li>
              <li class=""> <a href="#l3" data-toggle="tab" aria-expanded="false"> <i class="fa fa-users" aria-hidden="true"></i> <span class="visible-xs"><i class="fa fa-users" aria-hidden="true"></i></span> <span class="hidden-xs">Employees who work 
as Manager</span> </a> </li>
            </ul>
            <div class="tab-content clearfix">
              <div class="tab-pane active" id="l1">
                
               
                  <div class="form-group">
                      <div class="row">
                    <label for="location-name" class="control-label col-md-12">Position name</label>
                    <div class="col-md-6">
                      <input  class="form-control"  placeholder="Position name" style="" type="text" value="Manager">
                    </div>
                    </div>
                    
                   <div class="m-t-20">
                   <button type="button" class="btn btn-success waves-effect waves-light">Success</button>
                   <button type="button" class="btn btn-pink waves-effect waves-light">Cancel</button>
                </div>

                    
                  </div>
               
              </div>
              
              
              <div class="tab-pane" id="l2">
               
               <div class="positions-tab">
                   
                   <h4>Select the locations that have the Manager position:</h4>
                   
                    <div>
                        <button type="button"  class="btn btn-white btn-custom waves-effect">Select All</button>
                        <button  class="btn btn-white btn-custom waves-effect">Clear All</button>
                     </div>
                     
                     <div class="location-list">
                         <div class="row">
                        
                         
                         <div class="check-design">
                     
                     <div class="col-md-4">
                         <div class="emp-name">
                             <label> <input type="checkbox" />  Manager</label>
                         </div>
                     </div>
                     
                     
                     <div class="col-md-4">
                         <div class="emp-name">
                             <label> <input type="checkbox" />  Project Manager</label>
                         </div>
                     </div>
                     

                     <div class="col-md-4">
                         <div class="emp-name">
                             <label> <input type="checkbox" />  Sales Manager</label>
                         </div>
                     </div>
                     </div>
                     
                      <div class="m-t-20 col-md-12">
                   <button type="button" class="btn btn-success waves-effect waves-light">Success</button>
                   <button type="button" class="btn btn-pink waves-effect waves-light">Cancel</button>
                </div>
                         
                         </div>
                     </div>
                     
               </div>
               
               
              </div>
              <div class="tab-pane" id="l3">
                 <div class="staff-list-main">
                     <h4>Select the staff that can work in the Manager position:</h4>
                     <div>
                        <button type="button"  class="btn btn-white btn-custom waves-effect">Select All</button>
                        <button  class="btn btn-white btn-custom waves-effect">Clear All</button>
                     </div>
                     
                     <div class="staff-list">
                         <div class="row">
                     <div class="check-design">
                     
                     <div class="col-md-4">
                         <div class="emp-name">
                             <label> <input type="checkbox" />  Johnathan Doe</label>
                         </div>
                     </div>
                     
                     
                     <div class="col-md-4">
                         <div class="emp-name">
                             <label> <input type="checkbox" />  Johnathan Doe</label>
                         </div>
                     </div>
                     

                     <div class="col-md-4">
                         <div class="emp-name">
                             <label> <input type="checkbox" />  Johnathan Doe</label>
                         </div>
                     </div>
                     </div>
                     
                      <div class="m-t-20 col-md-12">
                   <button type="button" class="btn btn-success waves-effect waves-light">Success</button>
                   <button type="button" class="btn btn-pink waves-effect waves-light">Cancel</button>
                </div>
                          </div>   
                     </div>
                     
                 </div>
              </div>
            </div>
          </div>
        </div>
     

                    </div> <!-- container -->

                </div> <!-- content -->
		<script>
            var resizefunc = [];
        </script>
                @include('elements.footer')
            </div>


            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->
 
@stop
