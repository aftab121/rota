@extends('layouts.account')
@section('title', 'Page Title')
@include('elements.header')

@section('content')
   <!--page title start-->
        <section class="page-title">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="text-uppercase">Home</h4>
                        <ol class="breadcrumb">
                            <li><a href="index.html">Account</a>
                            </li>
                            <li class="active"><a href="#">My Account</a>
                            </li>
                            
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <!--page title end-->



         <!--body content start-->
        <section class="body-content">
           <div class="page-content">
              
              <div class="container">
                   <div class="row">
                       
                       <div class="profile-section">
                          <div class="col-md-12">

                            <!--tabs border start-->
                            <section class="normal-tabs">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a data-toggle="tab" href="#tab-one">My profile</a>
                                    </li>
                                    <li class="">
                                        <a data-toggle="tab" href="#tab-two">Order History</a>
                                    </li>
                                  
                                </ul>
                                <div class="panel-body">
                                    <div class="tab-content">
                                        <div id="tab-one" class="tab-pane active">
                                           <div class="profile-form">
                                               <form class="form-horizontal">
                                               
                                                 <h4>Login Information</h4>
                                               
                                                 <div  class="form-group">
                                                     <label class="control-label col-md-3">Login Email</label>
                                                     <div class="col-md-4">
                                                     <input type="text" class="form-control">
                                                     </div>
                                                 </div>
                                                 
                                                 
                                                 <div  class="form-group">
                                                     <label class="control-label col-md-3">Password</label>
                                                     <div class="col-md-4">
                                                     <input type="password" class="form-control">
                                                     </div>
                                                 </div>
                                                 
                                                 
                                                 <div  class="form-group">
                                                     <label class="control-label col-md-3">Retype Password</label>
                                                     <div class="col-md-4">
                                                     <input type="password" class="form-control">
                                                     </div>
                                                 </div>
                                                 
                                                 
                                                 <h4>Customer Information</h4>  
                                                 
                                                 
                                                 <div  class="form-group">
                                                     <label class="control-label col-md-3">First Name</label>
                                                     <div class="col-md-4">
                                                     <input type="text" class="form-control">
                                                     </div>
                                                 </div>
                                                 
                                                 
                                                 
                                                 <div  class="form-group">
                                                     <label class="control-label col-md-3">Last Name</label>
                                                     <div class="col-md-4">
                                                     <input type="text" class="form-control">
                                                     </div>
                                                 </div>
                                                 
                                                 
                                                 <div  class="form-group">
                                                     <label class="control-label col-md-3">Institution/Organization 	</label>
                                                     <div class="col-md-4">
                                                     <input type="text" class="form-control">
                                                     </div>
                                                 </div>
                                                 
                                                  
                                                 
                                                 <div  class="form-group">
                                                     <label class="control-label col-md-3">Billing Address 	</label>
                                                     <div class="col-md-4">
                                                     <input type="text" class="form-control">
                                                     </div>
                                                 </div>
                                                
                                                    
                                                 <div  class="form-group">
                                                     <label class="control-label col-md-3">City 		</label>
                                                     <div class="col-md-4">
                                                     <input type="text" class="form-control">
                                                     </div>
                                                 </div>
                                                      
                                                 <div  class="form-group">
                                                     <label class="control-label col-md-3">State</label>
                                                     <div class="col-md-4">
                                                     <input type="text" class="form-control">
                                                     </div>
                                                 </div>
                                                
                                              
                                                 <div  class="form-group">
                                                     <label class="control-label col-md-3">Country 	</label>
                                                     <div class="col-md-4">
                                                     <input type="text" class="form-control">
                                                     </div>
                                                 </div>
                                                
 
 
                                                  <div  class="form-group">
                                                     <label class="control-label col-md-3">Zip 	</label>
                                                     <div class="col-md-4">
                                                     <input type="text" class="form-control">
                                                     </div>
                                                 </div>
                                                
                                             
                                                   <div  class="form-group">
                                                     <label class="control-label col-md-3">Phone</label>
                                                     <div class="col-md-4">
                                                     <input type="text" class="form-control">
                                                     </div>
                                                 </div>
                                                
                                             
                                             
                                              <h4>Shipping Information:</h4>  
                                             
                                            
                                              <div  class="form-group">
                                                     <label class="control-label col-md-3">First Name</label>
                                                     <div class="col-md-4">
                                                     <input type="text" class="form-control">
                                                     </div>
                                                 </div>
                                                 
                                                 
                                                 
                                                 <div  class="form-group">
                                                     <label class="control-label col-md-3">Last Name</label>
                                                     <div class="col-md-4">
                                                     <input type="text" class="form-control">
                                                     </div>
                                                 </div>
                                                 
                                                 
                                                 <div  class="form-group">
                                                     <label class="control-label col-md-3">Institution/Organization 	</label>
                                                     <div class="col-md-4">
                                                     <input type="text" class="form-control">
                                                     </div>
                                                 </div>
                                                 
                                                  
                                                 
                                                 <div  class="form-group">
                                                     <label class="control-label col-md-3">Billing Address 	</label>
                                                     <div class="col-md-4">
                                                     <input type="text" class="form-control">
                                                     </div>
                                                 </div>
                                                
                                                    
                                                 <div  class="form-group">
                                                     <label class="control-label col-md-3">City 		</label>
                                                     <div class="col-md-4">
                                                     <input type="text" class="form-control">
                                                     </div>
                                                 </div>
                                                      
                                                 <div  class="form-group">
                                                     <label class="control-label col-md-3">State</label>
                                                     <div class="col-md-4">
                                                     <input type="text" class="form-control">
                                                     </div>
                                                 </div>
                                                
                                              
                                                 <div  class="form-group">
                                                     <label class="control-label col-md-3">Country 	</label>
                                                     <div class="col-md-4">
                                                     <input type="text" class="form-control">
                                                     </div>
                                                 </div>
                                                
 
 
                                                  <div  class="form-group">
                                                     <label class="control-label col-md-3">Zip 	</label>
                                                     <div class="col-md-4">
                                                     <input type="text" class="form-control">
                                                     </div>
                                                 </div>
                                                
                                             
                                                   <div  class="form-group">
                                                     <label class="control-label col-md-3">Phone 		</label>
                                                     <div class="col-md-4">
                                                     <input type="text" class="form-control">
                                                     </div>
                                                 </div>
                                             
                                              <div  class="form-group">
                                                    
                                                     <div class="col-md-4 col-md-offset-3">
                                                     <input type="submit" value="save"  class="btn btn-primary">
                                                     </div>
                                                 </div>
                                             
                                             
                                             
                                               </form>
                                               
                                           </div>
                                        </div>
                                        
                                        
                                        
                                        <div id="tab-two" class="tab-pane">
                                            <div class="order-history-table">
                                            <div class="table-responsive">
                                               <table class="table table-bordered">
    <thead>
      <tr>
        <th>Order ID</th>
        <th>Purchase Date</th>
        <th>Items</th>
        <th>Total</th>
        <th>Paid</th>
        <th>Due</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </tbody>
  </table>
                                		    </div>
                                            </div>
                                        </div>
                                       
                                    </div>
                                </div>
                            </section>
                            <!--tabs border end-->
                        </div>
                       </div>
                       
                   </div>
              </div>
           </div>
        </section>
        <!--body content end-->
     

@include('elements.footer')

@stop
