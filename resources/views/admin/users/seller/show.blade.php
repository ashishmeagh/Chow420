
@extends('admin.layout.master')                
@section('main_content')

<style>
  .myprofile-lefts{text-align: left; width: 100%;}
  .profile-view-seller .myprofile-right{width: 100%; padding-left: 0px; word-break: break-all; }
  .profile-view-seller .myprofile-lefts{text-align: left; width: 100%; }
.profile-view-seller{margin: 0 auto 30px;}
.row{display: block;}
.title-profiles-slrs.fnt-size-large{font-size: 25px;}
.myprofile-main.myprofile-main-nw .myprofile-lefts{    font-weight: normal;}
.myprofile-main.myprofile-main-nw .myprofile-right {
    width: 100%;
    padding-left: 0px;
    font-weight: 600;
    color: #333;
    font-size: 13px;
    margin-top: 5px;
}
span.ans {
    text-transform: uppercase;
    color: #873dc8;
    margin-right: 8px;
    font-weight: normal; font-size: 15px;
}
</style>


<!-- Page Content -->
<div id="page-wrapper">
   <div class="container-fluid">
      <div class="row bg-title">
         <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">{{$page_title or ''}}</h4>
         </div>
         <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">

              @php
                $user = Sentinel::check();
              @endphp

              @if(isset($user) && $user->inRole('admin'))
                <li><a href="{{ url(config('app.project.admin_panel_slug').'/dashboard') }}">Dashboard</a></li>
              @endif
               
               <li><a href="{{ url(config('app.project.admin_panel_slug').'/sellers') }}">Dispensary</a></li>
               <li class="active">{{$page_title or ''}}</li>
            </ol>
         </div>
         <!-- /.col-lg-12 -->
      </div>
      <!-- .row -->
      <div class="row">
         <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
               @include('admin.layout._operation_status')
                  <div class="col-sm-12 col-xs-12">
                        <div style="font-size: 20px; font-weight: 600; color: #333;cursor: default;" 
                           class="text-" ondblclick="scrollToButtom()" title="Double click to Take Action" >
                        </div>
                  </div>
               <div class="form-group">
                  <div class="col-sm-12 col-lg-12 controls text-center">
                     <h4><b>{{$page_title or ''}}</b></h4>
                  </div>
               </div>
                  <div class="profile-view-seller shopsellerview-box">
                     {{-- <div class="profile-view-seller-img">
                        <img id="admin-profile-img" src="{{ getProfileImage($user_arr['profile_image'])}}" alt="user-img" width="100" class="img-circle">
                     </div> --}}


                     <div class="title-profiles-slrs">{{ $user_arr['first_name'] or '' }} {{ $user_arr['last_name'] or '' }}</div>
                     <div class="main-prfl-conts">
                      {{--   <div class="myprofile-main">
                           <div class="myprofile-lefts">Mobile Number</div>
                           <div class="myprofile-right">
                             @if(isset($user_arr['phone']) && $user_arr['phone']!="")
                               {{ $user_arr['phone'] }}
                             @else
                                NA
                             @endif
                               
                           </div>
                           <div class="clearfix"></div>
                        </div> --}}
                        <div class="myprofile-main">
                           <div class="myprofile-lefts">Email</div>
                           <div class="myprofile-right">
                             @if(isset($user_arr['email']) && $user_arr['email']!="") 
                             {{ $user_arr['email']}}
                             @else
                             NA
                             @endif
                           </div>
                           <div class="clearfix"></div>
                        </div>
                        <div class="myprofile-main">
                           <div class="myprofile-lefts">Address</div>
                           <div class="myprofile-right">

                            @if($user_arr['street_address']=="" && $user_arr['city']=="" && $user_arr['get_state_detail']['name']=="" && $user_arr['get_country_detail']['name']=="" && $user_arr['zipcode']=="")
                              NA
                            @else

                                 @if(isset($user_arr['street_address']) && $user_arr['street_address']!="")
                                 {{ $user_arr['street_address'] }}
                                 @endif
                                 @if(isset($user_arr['city']) && $user_arr['city']!="")
                                 ,{{ $user_arr['city'] }}
                                 @endif
                                 @if(isset($user_arr['get_state_detail']['name']) && $user_arr['get_state_detail']['name']!="")
                                 ,{{ $user_arr['get_state_detail']['name'] }}
                                 @endif
                                 @if(isset($user_arr['get_country_detail']['name']) && $user_arr['get_country_detail']['name']!="")
                                 ,{{ $user_arr['get_country_detail']['name'] }}
                                 @endif
                                 @if(isset($user_arr['zipcode']) && $user_arr['zipcode']!="")
                                 ,{{ $user_arr['zipcode'] }}
                                 @endif
                            @endif     
                           </div>
                           <div class="clearfix"></div>
                        </div>

                        <div class="myprofile-main">
                           <div class="myprofile-lefts">Last Login Time</div>
                           <div class="myprofile-right">{{ isset($user_arr['last_login'])?date('d-M-Y H:i A',strtotime($user_arr['last_login'])):'Not Login Yet!' }}</div>
                           <div class="clearfix"></div>
                        </div>

                         <div class="myprofile-main">
                           <div class="myprofile-lefts">How did you hear about us?</div>
                           <div class="myprofile-right">
                            @if(isset($user_arr['hear_about']) && $user_arr['hear_about']!='')
                                  {{ $user_arr['hear_about'] }}
                            @else
                               {{ 'NA' }}
                            @endif       
                           </div>
                           <div class="clearfix"></div>
                        </div>


                         <div class="myprofile-main">
                           <div class="myprofile-lefts">Domain</div>
                           <div class="myprofile-right">
                            @if(isset($user_arr['domain_source']) && $user_arr['domain_source']!='')
                                  @if($user_arr['domain_source']==1)
                                    https://beta.chow420.com/
                                  @elseif($user_arr['domain_source']==2)
                                   http://sellonchow.com/
                                  @else
                                    NA
                                  @endif
                            @else
                               {{ 'NA' }}
                            @endif       
                           </div>
                           <div class="clearfix"></div>
                        </div>




                     </div>
                  </div>
               
         </div>

         @if(isset($user_arr['seller_detail']['business_name']) && $user_arr['seller_detail']['business_name']!="")
         <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
               @include('admin.layout._operation_status')
                <div style="font-size: 20px; font-weight: 600; color: #333; cursor: default;" 
                   class="text-" ondblclick="scrollToButtom()" title="Double click to Take Action" >
                </div>
              <div id="status_msg"></div>
               <div class="form-group">
                  <div class="col-sm-12 col-lg-12 controls text-center">
                     <h4><b>Business Details</b></h4>
                  </div>
               </div>


                  <div class="profile-view-seller shopsellerview-box">
                
                     <div class="main-prfl-conts">
                     <div class="myprofile-main">
                       <div class="myprofile-lefts">Business Name</div>
                       <div class="myprofile-right">
                           @if(isset($user_arr['seller_detail']['business_name']) && $user_arr['seller_detail']['business_name']!="")
                           {{ $user_arr['seller_detail']['business_name'] }}
                           @else
                           NA
                           @endif

                       </div>
                       <div class="clearfix"></div>
                    </div>
                    </div>


                  {{--   <div class="main-prfl-conts">
                     <div class="myprofile-main">
                       <div class="myprofile-lefts">Tax Id</div>
                       <div class="myprofile-right">
                          @if(isset($user_arr['seller_detail']['tax_id']) && $user_arr['seller_detail']['tax_id']!="")
                           {{ $user_arr['seller_detail']['tax_id'] }}
                           @else
                           NA
                           @endif
                       </div>
                       <div class="clearfix"></div>
                    </div>
                    </div> --}}

                    
                      {{--   @if(isset($user_arr['seller_detail']['id_proof']) && $user_arr['seller_detail']['id_proof']!='')
                        <div class="myprofile-main">
                           <div class="myprofile-lefts">Identity Proof</div>
                             <div class="profile-view-seller-img">
                               <img id="" src="{{ getIdProof($user_arr['seller_detail']['id_proof'])}}" alt="user-img" width="100" class="img-circle">
                            </div>
                        </div>
                        @endif --}}
                </div>
    {{--            <div class="form-group row">
                  <div class="col-12 text-center">
                      @if(isset($user_arr['seller_detail']['approve_status']) && $user_arr['seller_detail']['approve_status']!="" && $user_arr['seller_detail']['approve_status']=="1")
                        <a class="btn btn-success waves-effect waves-light show-btns" href="javascript:void(0)"><i class="fa fa-check" aria-hidden="true" readonly=""></i>Approved</a>
                     @else 
                     <a class="btn btn-success waves-effect waves-light show-btns" href="javascript:void(0)" onclick="approve_business_details($(this))" data-id="{{$user_arr['seller_detail']['user_id']}}" id="btn-approve-bussiness-details"><i class="fa fa-check" aria-hidden="true"></i>Approve</a>
                     @endif
                  </div>
               </div> --}}
            </div>
           @endif 

           <!--------------------------bank details------------------------------------->
                   
          <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
               @include('admin.layout._operation_status')
              
               <div class="form-group">
                  <div class="col-sm-12 col-lg-12 controls text-center">
                     <h4><b>Bank Details</b></h4>
                  </div>
               </div>
                  <div class="profile-view-seller shopsellerview-box">                    
                   
                     <div class="main-prfl-conts">
                        <div class="myprofile-main">
                           <div class="myprofile-lefts">Registered Name</div>
                            @php
                             $registered_name = $user_arr['seller_detail']['registered_name'];
                             if($registered_name)
                              $registered_name = $registered_name;
                             else
                              $registered_name = 'NA';
                           @endphp
                           <div class="myprofile-right">{{ $registered_name }}</div>
                           <div class="clearfix"></div>
                        </div>
                        <div class="myprofile-main">
                           <div class="myprofile-lefts">Account Number</div>
                           @php
                             $account_no = $user_arr['seller_detail']['account_no'];
                             if($account_no)
                              $account_no = $account_no;
                             else
                              $account_no = 'NA';
                           @endphp
                           <div class="myprofile-right">{{ $account_no }}</div>
                           <div class="clearfix"></div>
                        </div>
                        <div class="myprofile-main">
                           <div class="myprofile-lefts">Routing Number</div>
                           @php
                           $routing_no = $user_arr['seller_detail']['routing_no'];
                           if($routing_no)
                            $routing_no = $routing_no;
                           else
                            $routing_no = 'NA';
                           @endphp

                           <div class="myprofile-right">{{ $routing_no }}</div>
                           <div class="clearfix"></div>
                        </div>
                        <div class="myprofile-main">
                           <div class="myprofile-lefts">Swift Number</div>
                           @php
                           $switft_no = $user_arr['seller_detail']['switft_no'];
                           if($switft_no)
                            $switft_no = $switft_no;
                           else
                            $switft_no = 'NA';
                           @endphp

                           <div class="myprofile-right">{{ $switft_no }}</div>
                           <div class="clearfix"></div>
                        </div>

                         <div class="myprofile-main">
                           <div class="myprofile-lefts">Paypal Email</div>
                           @php

                           $paypalemail = $user_arr['seller_detail']['paypal_email'];
                           if($paypalemail)
                            $paypalemail = $paypalemail;
                           else
                            $paypalemail = 'NA';

                           @endphp
                           <div class="myprofile-right">{{ $paypalemail }}</div>
                           <div class="clearfix"></div>
                        </div>
                       
                     </div>
                  </div>
         </div>




            <!-------------------------------------------------------------------->

        
         </div>
         <div class="clearfix"></div>
         <div class="row">
              {{--  Seller Questions Module  --}}
            @if($user_arr['seller_detail']['seller_question_answer']!='')
           <div class="col-sm-12">
               @include('admin.layout._operation_status')
               @php
                  $seller_qa =  json_decode($user_arr['seller_detail']['seller_question_answer']);                 
               @endphp
                  <div class="profile-view-seller full-profile-view-seller">
                     <div class="title-profiles-slrs fnt-size-large">Dispensary Questions & Answers</div>
                     <div class="main-prfl-conts">
                        <div class="myprofile-main myprofile-main-nw">
                           <div class="myprofile-lefts"><span>1.</span> {!! $seller_qa->seller_question1 or '' !!}</div>
                           <div class="myprofile-right"><span class="ans">Ans:</span>{{ $seller_qa->seller_answer1 or '' }}</div>
                           <div class="clearfix"></div>
                        </div> 
                        <div class="myprofile-main myprofile-main-nw">
                           <div class="myprofile-lefts"><span>2.</span> {!! $seller_qa->seller_question2 or '' !!}</div>
                           <div class="myprofile-right"><span class="ans">Ans:</span>{{ $seller_qa->seller_answer2 or '' }}</div>
                           <div class="clearfix"></div>
                        </div>    
                        <div class="myprofile-main myprofile-main-nw">
                           <div class="myprofile-lefts"><span>3.</span> {!! $seller_qa->seller_question3 or '' !!}</div>
                           <div class="myprofile-right"><span class="ans">Ans:</span>{{ $seller_qa->seller_answer3 or '' }}</div>
                           <div class="clearfix"></div>
                        </div>                        
                     </div>
                  </div>
               <div class="form-group row">
                  <div class="col-12 text-center">
                     <a class="btn btn-inverse waves-effect waves-light show-btns" href="{{$module_url_path}}"><i class="fa fa-arrow-left"></i> Back</a>
                  </div>
               </div>
         </div>
         @endif
         </div>
      </div>
   </div>
</div>
<!-- END Main Content -->
{{--    
   <script type="text/javascript">
   function approve_business_details(ref)
  {
      var seller_id  = $(ref).attr('data-id');
      var module_url_path = "{{$module_url_path}}";

      alert(seller_id + "/" + module_url_path);

      $.ajax({
              url:module_url_path+'/approve_business_details',
              type:'GET',
              data:{
                      seller_id:seller_id
                    },
              dataType:'JSON',
              beforeSend: function() {
                        showProcessingOverlay();
          $('#btn-approve-bussiness-details').prop('disabled',true);
          $('#btn-approve-bussiness-details').html('Updating... <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');
              },
              success:function(response)
              { 
                 hideProcessingOverlay();
                 var success_HTML = '';
                 if(response.status && response.status=="SUCCESS")
                {
                  $('#btn-approve-bussiness-details').prop('disabled',true);
                  $('#btn-approve-bussiness-details').html('Approved');  
                  success_HTML +='<div class="alert alert-success alert-dismissible">\
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                        <span aria-hidden="true">&times;</span>\
                    </button>'+response.message+'</div>';

                    $('#status_msg').html(success_HTML);
                    window.location.reload();  
                 }
                 else
                 {
                    var error_HTML = '';   
                    error_HTML+='<div class="alert alert-danger alert-dismissible">\
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                        <span aria-hidden="true">&times;</span>\
                    </button>'+response.message+'</div>';
                   $('#status_msg').html(error_HTML);
                 }                  
                  
              }
      });
  }
  </script> --}}
@stop

