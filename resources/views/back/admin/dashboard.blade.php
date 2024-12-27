@extends('back.admin.layout.app')
@section('content')


       
       <div class="page-content fade-in-up">
           <div class="row">
               <div class="col-lg-3 col-md-6">
                   <div class="ibox bg-success color-white widget-stat">
                       <div class="ibox-body">
                           <h2 class="m-b-5 font-strong">{{$order}}</h2>
                           <div class="m-b-5">Total ORDERS</div><i class="ti-shopping-cart widget-stat-icon"></i>
                         
                       </div>
                   </div>
               </div>
               <div class="col-lg-3 col-md-6">
                   <div class="ibox bg-info color-white widget-stat">
                       <div class="ibox-body">
                           <h2 class="m-b-5 font-strong">{{$completedOrders}}</h2>
                           <div class="m-b-5">Complete Order</div><i class="ti-bar-chart widget-stat-icon"></i>
                       </div>
                   </div>
               </div>
               <div class="col-lg-3 col-md-6">
                   <div class="ibox bg-warning color-white widget-stat">
                       <div class="ibox-body">
                           <h2 class="m-b-5 font-strong">{{$newOrders}}</h2>
                           <div class="m-b-5">New Order</div><i class="ti-bar-chart widget-stat-icon"></i>
                       </div>
                   </div>
               </div>
               <div class="col-lg-3 col-md-6">
                   <div class="ibox bg-warning color-white widget-stat">
                       <div class="ibox-body">
                           <h2 class="m-b-5 font-strong">{{$transferOrders}}</h2>
                           <div class="m-b-5">Transfer Order</div><i class="ti-bar-chart widget-stat-icon"></i>
                       </div>
                   </div>
               </div>
               <div class="col-lg-3 col-md-6">
                   <div class="ibox bg-danger color-white widget-stat">
                       <div class="ibox-body">
                           <h2 class="m-b-5 font-strong">{{$data}}</h2>
                           <div class="m-b-5">NEW USERS</div><i class="ti-user widget-stat-icon"></i>
                       </div>
                   </div>
               </div>
               <div class="col-lg-3 col-md-6">
                   <div class="ibox bg-secondary color-white widget-stat">
                       <div class="ibox-body">
                           <h2 class="m-b-5 font-strong">{{$totalVendors}}</h2>
                           <div class="m-b-5">Total VENDORS</div><i class="fa fa-user widget-stat-icon"></i>
                       </div>
                   </div>
               </div>
           </div>
       
           <style>
               .visitors-table tbody tr td:last-child {
                   display: flex;
                   align-items: center;
               }

               .visitors-table .progress {
                   flex: 1;
               }

               .visitors-table .progress-parcent {
                   text-align: right;
                   margin-left: 10px;
               }
           </style>
     
       </div>
   
  
@endsection