    @extends('seller.layout.master')
@section('main_content')
<style type="text/css">
  .div-icon{
      width: 16px;
    margin-right: 2px;
    margin-top: -3px;
}
.err{
    color: #e00000;
    font-size: 13px;
}
.myprofile-main .profile {
    margin-left: 125px;
    width: 100px;
}
.note-show-abtform.bgnone {
    background-color: transparent;
    padding: 0;
}
</style>
<div class="my-profile-pgnm">
 Profile

  <ul class="breadcrumbs-my">
    <li><a href="{{url('/')}}/seller/dashboard">Dashboard</a></li>
    <li><i class="fa fa-angle-right"></i></li>
    <li>Profile</li>
  </ul>
</div>
<div class="new-wrapper">

<div class="main-my-profile">
   <div class="innermain-my-profile paddingnones">


@php
 
$user_profile_status = isset($user_details_arr['approve_status'])?$user_details_arr['approve_status']:'';

@endphp
  
 

  {{--  @if(isset($user_details_arr['user_details']['approve_verification_status']) && ($user_details_arr['user_details']['approve_verification_status']==1 ) && ($user_profile_status==1)) --}}

  @if(isset($user_profile_status) && $user_profile_status==1)

    <div class="text-right">
      <a href="mailto:{{ $admin_arr['email'] }}" class="eye-actn" title="mailto:{{isset($admin_arr['email'])?$admin_arr['email']:''}}">
        Request Change
      </a>
     </div>
   {{--  @elseif(isset($user_details_arr['user_details']['approve_verification_status']) && ($user_details_arr['user_details']['approve_verification_status']==2 ))
      <a href="{{url('/')}}/seller/profile/edit" class="editmyprofiles" title="Edit Personal Details">
        <img src="{{url('/')}}/assets/seller/images/edit-profile.png" alt="" class="div-icon" /> Edit 
      </a>  --}}
    @else
       <a href="{{url('/')}}/seller/profile/edit" class="editmyprofiles" title="Edit Personal Details">
        <img src="{{url('/')}}/assets/seller/images/edit-profile.png" alt="" class="div-icon" /> Edit 
       </a> 
    @endif


                 <div class="myprofile-main">
                     <div class="myprofile-lefts">First Name</div>
                     <div class="myprofile-right">
                        @if(isset($user_details_arr['first_name']) && !empty($user_details_arr['first_name']))
                        {{$user_details_arr['first_name']}}
                        @else
                         NA
                        @endif
                     </div>
                     <div class="clearfix"></div>
                 </div>
                 <div class="myprofile-main">
                     <div class="myprofile-lefts">Last Name</div>
                     <div class="myprofile-right">
                      @if(isset($user_details_arr['last_name']) && !empty($user_details_arr['last_name']))
                        {{$user_details_arr['last_name']}}
                        @else
                         NA
                        @endif

                     </div>
                     <div class="clearfix"></div>
                 </div>
                 <div class="myprofile-main">
                     <div class="myprofile-lefts">Email Address</div>
                     <div class="myprofile-right">{{isset($user_details_arr['email'])?$user_details_arr['email']:'NA'}}</div>
                     <div class="clearfix"></div>
                 </div>
               {{--  <div class="myprofile-main">
                     <div class="myprofile-lefts">Mobile Number</div>
                     <div class="myprofile-right">
                       @if(isset($user_details_arr['phone']) && !empty($user_details_arr['phone']))
                        {{$user_details_arr['phone']}}
                        @else
                         NA
                        @endif

                     </div>
                     <div class="clearfix"></div>
                 </div> --}}

                  <div class="myprofile-main">
                     <div class="myprofile-lefts">Address</div>
                     <div class="myprofile-right">{{isset($user_details_arr['street_address'])?ucwords($user_details_arr['street_address']):'NA'}}</div>
                     <div class="clearfix"></div>
                 </div>
                 <div class="myprofile-main">
                     <div class="myprofile-lefts">City</div>
                     <div class="myprofile-right">{{isset($user_details_arr['city'])?ucwords($user_details_arr['city']):'NA'}}</div>
                     <div class="clearfix"></div>
                 </div>

                  <div class="myprofile-main">
                     <div class="myprofile-lefts">State</div>
                     <div class="myprofile-right">{{isset($user_details_arr['get_states_arr']['name'])?$user_details_arr['get_states_arr']['name']:'NA'}}</div>
                     <div class="clearfix"></div>
                 </div>

                 <div class="myprofile-main">
                     <div class="myprofile-lefts">Country</div>
                     <div class="myprofile-right">{{isset($user_details_arr['get_countries_arr']['name'])?$user_details_arr['get_countries_arr']['name']:'NA'}}</div>
                     <div class="clearfix"></div>
                 </div>

                 <div class="myprofile-main">
                     <div class="myprofile-lefts">Zip Code</div>
                     <div class="myprofile-right">{{isset($user_details_arr['zipcode'])?$user_details_arr['zipcode']:'NA'}}</div>
                     <div class="clearfix"></div>
                 </div>
               
                {{--  <div class="myprofile-main">
                     <div class="myprofile-lefts">Country Code</div>
                     <div class="myprofile-right">{{isset($user_details_arr['country'])?$user_details_arr['country']:''}}</div>
                     <div class="clearfix"></div>
                 </div>  --}}

               <!----------------------start of profile verification------------->
               


               <div class="myprofile-main">
                  <div class="myprofile-lefts">Profile Verification</div>

                     @if(isset($user_details_arr['approve_status']) && $user_details_arr['approve_status']=='0' && ($user_details_arr['first_name']=="" ||  $user_details_arr['last_name']=="" || $user_details_arr['email']=="" || $user_details_arr['street_address']=="" || $user_details_arr['country']=="" || $user_details_arr['state']=="" || $user_details_arr['zipcode']=="" || $user_details_arr['city']==""))

                      <div class="myprofile-right"><div class="status-dispatched">Profile details not uploaded</div></div>

                      @elseif(isset($user_details_arr['approve_status']) && $user_details_arr['approve_status']=='0' && $user_details_arr['first_name']!="" &&  $user_details_arr['last_name']!="" &&  $user_details_arr['email']!="" && $user_details_arr['street_address']!="" &&  $user_details_arr['country']!="" &&  $user_details_arr['state']!="" &&  $user_details_arr['zipcode']!="" &&  $user_details_arr['city']!="")

                      <div class="myprofile-right">
                        <div class="status-dispatched">Pending</div>
                      </div>  

                       @elseif(isset($user_details_arr['approve_status']) && $user_details_arr['approve_status']=='3' && $user_details_arr['first_name']!="" &&  $user_details_arr['last_name']!="" &&  $user_details_arr['email']!="" &&  $user_details_arr['street_address']!="" &&  $user_details_arr['country']!="" &&  $user_details_arr['state']!="" &&  $user_details_arr['zipcode']!="" &&  $user_details_arr['city']!="")

                      <div class="myprofile-right">
                        <div class="status-dispatched">Submitted</div>
                      </div>  
                      

                     @elseif(isset($user_details_arr['approve_status']) && $user_details_arr['approve_status']==1)
                      <div class="myprofile-right">
                        <div class="status-completed">Approved</div>
                      </div>

                     @elseif(isset($user_details_arr['approve_status']) && $user_details_arr['approve_status']==2)

                       
                      <div class="myprofile-right">
                          <div class="status-shipped">Rejected</div>
                      </div>
                      <div class="main-rejects">
                        <div class="myprofile-lefts">Reject Reason</div>
                          <div class="myprofile-right">{{isset($user_details_arr['note'])?$user_details_arr['note']:''}}</div>
                      </div>
                      <div class="clearfix"></div>
                   
                     @endif    
                  </div> <!---------end of profile verification status------>




               <!-----------------------start of id proof verification div------->

              {{--   <div class="myprofile-main">
                  <div class="myprofile-lefts">ID Proof Verification</div>
                 @if(isset($user_details_arr['user_details']['approve_verification_status']) && $user_details_arr['user_details']['approve_verification_status']=='0' && $user_details_arr['user_details']['front_image']=="" &&  $user_details_arr['user_details']['back_image']=="" &&  $user_details_arr['user_details']['selfie_image']=="")

                  <div class="myprofile-right"><div class="status-dispatched">Id proof details not uploaded</div>
                     @if($user_details_arr['user_details']['approve_verification_status']!=1)
                     <div class="approved-business-profile-buuton">                     
                     </div>
                    @endif  
                </div>
                  @elseif(isset($user_details_arr['user_details']['approve_verification_status']) && $user_details_arr['user_details']['approve_verification_status']=='3' && $user_details_arr['user_details']['front_image']!="" &&  $user_details_arr['user_details']['back_image']!="" &&  $user_details_arr['user_details']['selfie_image']!="")

                  <div class="myprofile-right">
                    <div class="status-dispatched">Submitted</div>
                     @if($user_details_arr['user_details']['approve_verification_status']!=1)
                     <div class="approved-business-profile-buuton">
                     
                     </div>
                    @endif  
                  </div>                    

                 @elseif(isset($user_details_arr['user_details']['approve_verification_status']) && $user_details_arr['user_details']['approve_verification_status']==1)
                  <div class="myprofile-right">
                    <div class="status-completed">Approved</div>
                  </div>

                 @elseif(isset($user_details_arr['user_details']['approve_verification_status']) && $user_details_arr['user_details']['approve_verification_status']==2)
                   
                  <div class="myprofile-right">
                      <div class="status-shipped">Rejected</div>
                       @if($user_details_arr['user_details']['approve_verification_status']!=1)
                          <div class="approved-business-profile-buuton">
                        
                         </div>
                      @endif  
                  </div>
                  <div class="main-rejects">
                    <div class="myprofile-lefts">Reject Reason</div>
                      <div class="myprofile-right">{{isset($user_details_arr['user_details']['note'])?$user_details_arr['user_details']['note']:''}}</div>
                  </div>
                  <div class="clearfix"></div>
                 @endif    
             </div> --}}

             <!-----------------------end of id proof verification div------->

             

              <div class="myprofile-main">
                <div class="myprofile-lefts">Business Verification</div>
                @php 
                    if($user_details_arr['user_details']['approve_status']==0){
                      $status = 'Pending';
                      $cls = 'status-dispatched';
                    }
                    else if($user_details_arr['user_details']['approve_status']==1){
                      $status = 'Approved';
                      $cls = 'status-completed';
                    }
                    else if($user_details_arr['user_details']['approve_status']==2){
                      $status = 'Rejected';
                      $cls = 'status-shipped';
                    }
                    else if($user_details_arr['user_details']['approve_status']==3){
                      $status = 'Submitted';
                      $cls = 'status-dispatched';
                    }
                @endphp
                  <div class="myprofile-right">
                    <div class="{{ $cls }}">{{ $status }} </div>
                     {{--  @if($user_details_arr['user_details']['approve_status']!=1) --}}
                     <div class="approved-business-profile-buuton">
                       <a href="{{ url('/') }}/seller/profile/edit" class="" title="Edit Business Details">  <img src="{{url('/')}}/assets/seller/images/edit-profile.png" class="div-icon" alt="" /> Edit </a>
                     </div>
                   {{--  @endif  --}} 
                  </div>  
              </div>   
             <!---------------end of business verification---->
        
   </div>


<br/>
<div class="maxwidthhere">

@if(isset($list_document_required) && !empty($list_document_required))
    <div class="note-show-abtform">
     Upload: {{$list_document_required}} <span>*</span>
     </div>
     @endif
   <div class="note-show-abtform <?php if(isset($str_document_required) && !empty($str_document_required) && $str_document_required!="No additional documents required") {echo"bgnone"; } ?>">
         @if(isset($str_document_required) && !empty($str_document_required) && $str_document_required=="Upload Documents")  

                 @if(isset($user_details_arr['user_details']['documents_verification_status']) && ($user_details_arr['user_details']['documents_verification_status']=='0' || $user_details_arr['user_details']['documents_verification_status']=='2' ))


                 <a href="{{url('/')}}/seller/profile/edit" class="editmyprofiles" title="Upload Documents">
                  <img src="{{url('/')}}/assets/seller/images/edit-profile.png" alt="" class="div-icon" /> {{$str_document_required}}
                 </a> 

                 @else

                   <div class="maxwidthsss">
                    <a href="mailto:{{ $admin_arr['email'] }}" class="eye-actn pull-right" title="mailto:{{isset($admin_arr['email'])?$admin_arr['email']:''}}">
                      Request Change
                    </a>
                  </div>


                 @endif


           @elseif((isset($str_document_required) && !empty($str_document_required) && $str_document_required=="No additional documents required"))
          {{$str_document_required}}
      @endif
    </div>


    
            <!-----------------start-product-dimension---------------------->
           {{--  <hr>
              <div class="col-md-12"><div class="form-group"><label for="shipping_duration">Product Dimensions</label></div></div>
              <div class="product_dimension_div">
                <div  id="row1">
                  <div class="col-md-5">
                      <div class="form-group">
                         <label for="second_level_category_id">Product Dimension Type </label>
                         <input type="text" name="product_dimension[]" id="product_dimension_1" class="input-text" placeholder="Enter Product Dimension Type" onkeyup="clear_err_div_dim(1)">
                        <span id="err_product_dimension_1" class="err"></span>

                      </div>
                  </div>
                  <div class="col-md-5">
                      <div class="form-group">
                         <label for="second_level_category_id">Product Dimension </label>
                         <input type="text" id="product_dimension_value_1" name="product_dimension_value[]" class="input-text product_dimension_value" placeholder="Enter Product Dimension" onkeyup="clear_err_dim_val(1)">
                        <span id="err_product_dimension_value_1" class="err"></span>
                      </div>
                  </div>
                  <div class="col-md-2">
                      <div class="form-group" style="margin-top:30px;">
                  <a href="javascript:void(0)" class="addMore" name="add_more_product_dimension" id="add_more_product_dimension_1"><i class="fa fa-plus"></i></a>
                     </div>
                  </div>  
                 </div>  
           </div> --}}
           <!---------------end-product-dimension------------------------>
{{--     @if(isset($arr_documents) && !empty($arr_documents) && $str_document_required=='Upload Documents')
    @foreach($arr_documents as $doc)       

              <div class="myprofile-main">
                     <div class="myprofile-lefts">Document Title</div>
                     <div class="myprofile-right">
                        @if(isset($doc['document_title']) && !empty($doc['document_title']))
                        {{$doc['document_title']}}
                        @else
                         NA
                        @endif
                     </div>
                     <div class="clearfix"></div>
                 </div>

            
                 <div class="myprofile-main">
                     <div class="myprofile-lefts">Document</div>
                     <div class="">
                  @if(isset($doc['document']) && $doc['document']!='')
                    <div class="uplaod-edit-img">
                        <img src="{{$document_path.$doc['document']}}" class="profile" alt="Document" width="100" height="100" value="{{$document_path.$doc['document']}}">
                    </div> 
                 @endif
                </div>  
                </div>                  
     @endforeach
    @endif  --}}

                   @if(isset($str_document_required) && !empty($str_document_required) && $str_document_required=="Upload Documents")    
                  <div class="myprofile-main">
                  <div class="myprofile-lefts">Documents Verification</div>

                     @if(isset($user_details_arr['user_details']['documents_verification_status']) && $user_details_arr['user_details']['documents_verification_status']=='0')

                      <div class="myprofile-right"><div class="status-dispatched">Documents not uploaded</div></div>

                      @elseif(isset($user_details_arr['user_details']['documents_verification_status']) && $user_details_arr['user_details']['documents_verification_status']=='3')

                      <div class="myprofile-right">
                        <div class="status-dispatched">Submitted</div>
                      </div>  


                     @elseif(isset($user_details_arr['user_details']['documents_verification_status']) && $user_details_arr['user_details']['documents_verification_status']=='1')
                      <div class="myprofile-right">
                        <div class="status-completed">Approved</div>
                      </div>

                     @elseif(isset($user_details_arr['user_details']['documents_verification_status']) && $user_details_arr['user_details']['documents_verification_status']=='2')
                       
                      <div class="myprofile-right">
                          <div class="status-shipped">Rejected</div>
                      </div>
                      <div class="main-rejects">
                        <div class="myprofile-lefts">Reject Reason</div>
                          <div class="myprofile-right">{{isset($user_details_arr['user_details']['note_doc_reject'])?$user_details_arr['user_details']['note_doc_reject']:''}}</div>
                      </div>
                      <div class="clearfix"></div>
                   
                     @endif    
                  </div> <!---------end of profile verification status------>
                @endif  


               <!-----------------------start of id proof verification div------->

              {{--   <div class="myprofile-main">
                  <div class="myprofile-lefts">ID Proof Verification</div>
                 @if(isset($user_details_arr['user_details']['approve_verification_status']) && $user_details_arr['user_details']['approve_verification_status']=='0' && $user_details_arr['user_details']['front_image']=="" &&  $user_details_arr['user_details']['back_image']=="" &&  $user_details_arr['user_details']['selfie_image']=="")

                  <div class="myprofile-right"><div class="status-dispatched">Id proof details not uploaded</div>
                     @if($user_details_arr['user_details']['approve_verification_status']!=1)
                     <div class="approved-business-profile-buuton">                     
                     </div>
                    @endif  
                </div>
                  @elseif(isset($user_details_arr['user_details']['approve_verification_status']) && $user_details_arr['user_details']['approve_verification_status']=='3' && $user_details_arr['user_details']['front_image']!="" &&  $user_details_arr['user_details']['back_image']!="" &&  $user_details_arr['user_details']['selfie_image']!="")

                  <div class="myprofile-right">
                    <div class="status-dispatched">Submitted</div>
                     @if($user_details_arr['user_details']['approve_verification_status']!=1)
                     <div class="approved-business-profile-buuton">
                     
                     </div>
                    @endif  
                  </div>                    

                 @elseif(isset($user_details_arr['user_details']['approve_verification_status']) && $user_details_arr['user_details']['approve_verification_status']==1)
                  <div class="myprofile-right">
                    <div class="status-completed">Approved</div>
                  </div>

                 @elseif(isset($user_details_arr['user_details']['approve_verification_status']) && $user_details_arr['user_details']['approve_verification_status']==2)
                   
                  <div class="myprofile-right">
                      <div class="status-shipped">Rejected</div>
                       @if($user_details_arr['user_details']['approve_verification_status']!=1)
                          <div class="approved-business-profile-buuton">
                        
                         </div>
                      @endif  
                  </div>
                  <div class="main-rejects">
                    <div class="myprofile-lefts">Reject Reason</div>
                      <div class="myprofile-right">{{isset($user_details_arr['user_details']['note'])?$user_details_arr['user_details']['note']:''}}</div>
                  </div>
                  <div class="clearfix"></div>
                 @endif    
             </div> --}}

             <!-----------------------end of id proof verification div------->
 
             <!---------------end of business verification---->

            
        
   </div>

</div>
</div>
@endsection




