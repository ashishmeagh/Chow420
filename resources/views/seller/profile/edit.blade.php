@extends('seller.layout.master')
@section('main_content')


<style type="text/css">

.uplaod-edit-img {
    width: 100px;
    height: 100px;
    border-radius: 5px;
    border: 1px solid #ccc;
    margin-top: 10px;
 overflow: hidden;
 padding: 5px;
}
.profl-em img{width: 100%; height: 100%;}
.yprofiles{position: relative; margin-bottom: 5px;}
.yprofiles .form-control{height: 45px;padding: 0;}
.yprofiles input[type=file]::-webkit-file-upload-button {
     background-color: #333;
     padding: 5px 20px; border: none; height: 45px; color: #ffff;
     position: absolute; left: 0px; top: 0px;
}
.main-dv-re{max-width: 855px; margin: 30px auto 0px;}
.idprooftitle.person-left-class {
     float: left;
    max-width: 100%;
        margin: 0 0 8px;
}
.maxwidthsss {
        margin-left: 190px
}
.main-dv-re.edit-top-space{    margin: 10px auto 0px;}
.main-my-profile.paddingnone.padding-bottomnone{padding-bottom: 0px;}
.form-group.button-list-dts{margin-bottom: 0px;}
/*.status-div-icon.innermain-my-profile.max-widnone{max-width: auto;}*/
.main-my-profile .main-dv-re1 {display:flex; align-items:center;}
.main-my-profile .main-dv-re1 .idprooftitle.person-left-class {margin-bottom:0px !important;}
.maxwidthsss {margin-left:30px;}
.innermain-my-profile {padding:20px;}
.err{
    color: #e00000;
    font-size: 13px;
}
</style>

<div class="my-profile-pgnm">Edit Profile
     <ul class="breadcrumbs-my">
     <li><a href="{{url('/')}}/seller/dashboard">Dashboard</a></li>
     <li><i class="fa fa-angle-right"></i></li>
      <li><a href="{{url('/')}}/seller/profile">Profile</a></li>
      <li><i class="fa fa-angle-right"></i></li>
      <li>Edit Profile</li>
    </ul>
</div>
<div class="new-wrapper">


@php
 
$user_profile_status = isset($user_details_arr['approve_status'])?$user_details_arr['approve_status']:'';
$documents_verification_status = isset($user_details_arr['user_details']['documents_verification_status'])?$user_details_arr['user_details']['documents_verification_status']:'';

@endphp


<div class="main-my-profile paddingnone padding-bottomnone">
  <div class="main-dv-re main-dv-re1 ">
     <div class="idprooftitle person-left-class"> Personal Details</div>
      {{--   @if(isset($user_details_arr['user_details']['approve_verification_status']) && ($user_details_arr['user_details']['approve_verification_status']==1 ) && ($user_profile_status==1)) --}}

        @if(isset($user_profile_status) && $user_profile_status==1)

           <div class="maxwidthsss">
              <a href="mailto:{{ $admin_arr['email'] }}" class="eye-actn" title="mailto:{{isset($admin_arr['email'])?$admin_arr['email']:''}}">
                Request Change
              </a>
            </div>


            {{--  <div class="status-div-icon innermain-my-profile">
                <div class="myprofile-main">
                  <div class="maxwidthsss">
                  <div class="text-left">
                        <a href="mailto:{{ $admin_arr['email'] }}" class="eye-actn" title="mailto:{{isset($admin_arr['email'])?$admin_arr['email']:''}}">
                           Request Change
                        </a>
                 </div> </div> 
               </div>
            </div> --}}

        @else
</div>

<div class="clearfix"></div>
    <form id="frm-profile">
        {{ csrf_field() }}
   <div class="innermain-my-profile">

     <input type="hidden" name="old_front_image" value="{{$user_details_arr['user_details']['front_image'] or ''}}"> 
     <input type="hidden" name="old_back_image" value="{{$user_details_arr['user_details']['back_image'] or ''}}"> 

     <div id="status_msg"></div>


    
       <div class="row">
           <div class="col-md-6">
                 <div class="form-group">
                    <label for="">First Name <span>*</span></label>
                     <input type="text" class="input-text" placeholder="Enter First Name" value="{{$user_details_arr['first_name'] or ''}}" data-parsley-required="true" data-parsley-required-message="Please enter first name" data-parsley-pattern="^[a-zA-Z]+$" id="first_name" name="first_name" />
                </div>
            </div>
            <div class="col-md-6">
                 <div class="form-group">
                    <label for="">Last Name <span>*</span></label>
                    <input type="text" placeholder="Enter Last Name"  class="input-text" value="{{$user_details_arr['last_name'] or ''}}" data-parsley-required="true" data-parsley-required-message="Please enter last name" data-parsley-pattern="^[a-zA-Z]+$" id="last_name" name="last_name" />
                </div>
            </div>
            <div class="col-md-6">
                 <div class="form-group">
                    <label for="">Email Address <span>*</span></label>
                     <input type="email" placeholder="Enter Email Address" class="input-text disbl-input" value="{{$user_details_arr['email'] or ''}}" data-parsley-required="true" data-parsley-required-message="Please enter email" id="email" name="email" readonly=""/>
                </div>
            </div> 

             {{-- <div class="col-md-6">
                 <div class="form-group">
                    <label for="">Mobile Number <span>*</span></label>
                     <input type="text" placeholder="Enter Mobile No"  class="input-text" data-parsley-required="true" data-parsley-required-message="Please enter mobile number" data-parsley-minlength="10" data-parsley-maxlength="10" data-parsley-type="number" id="mobile_no" name="mobile_no" value="{{$user_details_arr['phone'] or ''}}"/>
                </div>
            </div> --}}



            <div class="col-md-12">
                <div class="form-group">
                   <div id="locationField">
                    <input class="input-text search-address" id="autocomplete" placeholder="Search your address here" onFocus="geolocate()" type="text" />
                  </div>
              </div>
            </div> 





             <div class="col-md-12">
                 <div class="form-group">
                    <label for="">Address <span>*</span></label>

                   <input class="field" id="street_number" disabled="true" type="hidden" /> 

                   {{--  <input type="text" placeholder="Enter Address" value="{{$user_details_arr['street_address'] or ''}}" data-parsley-required="true" data-parsley-required-message="Please enter address" id="street_address" name="street_address" class="input-text" /> --}}

                   <input type="text" data-parsley-required="true" data-parsley-required-message="Please enter address" id="route" name="street_address" placeholder="Enter Address" class="input-text" value="{{$user_details_arr['street_address'] or ''}}">

                </div>
            </div> 

            <div class="col-md-6">
                 <div class="form-group">
                    <label for="">City <span>*</span></label>
                    <input type="text" id="locality" name="city" value="{{$user_details_arr['city'] or ''}}" data-parsley-required="true" class="input-text" placeholder="City"  data-parsley-required-message="Please enter city">
                </div>
            </div>    


             <div class="col-md-6">
                 <div class="form-group">
                    <label for="">Country <span>*</span></label>
                     @php
                         $country_id = isset($user_details_arr['country'])?$user_details_arr['country']:0;
                    @endphp
                    <div class="select-style">
                    <select class="frm-select" data-parsley-required="true" data-parsley-required-message="Please select country" id="country" name="country" onchange="get_states()">

                      @if(isset($countries_arr) && count($countries_arr)>0)
                      <option value="">Select Country</option>
                      @foreach($countries_arr as $country)


                       <option  @if($country['id']==$country_id) selected="selected" @endif value="{{$country['id']}}">{{isset($country['name'])?ucfirst(strtolower($country['name'])):'--' }}</option>
                     
                      @endforeach
                      @else
                      <option>Countries Not Available</option>
                      @endif
                     </select> 
                    </div>
                    </div>
                
            </div>

            <div class="col-md-6">
                 <div class="form-group">
                    <label for="">State <span>*</span></label>
                    @php
                         $state_id = isset($user_details_arr['state'])?$user_details_arr['state']:0;
                      //   dd($states_arr);
                        
                    @endphp
                    <div class="select-style">
                    <select class="frm-select" data-parsley-required="true" data-parsley-required-message="Please select state " id="administrative_area_level_1" name="state">
                      @if(isset($states_arr) && count($states_arr)>0)
                      <option value="">Select State</option>
                      @foreach($states_arr as $state)
                      
                       <option  @if($state['id']==$state_id) selected="selected" @endif value="{{$state['id']}}">{{isset($state['name'])?ucfirst(strtolower($state['name'])):'--' }}</option>
                     
                      @endforeach
                      @else
                      <option>State Not Available</option>
                      @endif
                      
                     </select> 
                </div>
                </div>
            </div>



            <div class="col-md-6">
                 <div class="form-group">
                    <label for="">Zip Code <span>*</span></label>
                     <input type="text" placeholder="Enter Zip Code"  class="input-text" value="{{$user_details_arr['zipcode'] or ''}}" data-parsley-required="true" data-parsley-required-message="Please enter zip code " id="postal_code" name="zipcode" data-parsley-type="number" data-parsley-type-message="Please enter valid zip code"/>
                </div>
            </div>
           

            <div class="col-md-12">
                <div class="button-list-dts">
                    <a href="javascript:void(0)" class="butn-def" id="btn-profile">SAVE</a>
                    {{-- <a href="{{ url('/') }}/seller/profile" class="butn-def cancelbtnss">Cancel</a> --}}
                </div>
            </div>
       </div>
   </div>
  </form>

@endif

</div> <!---end of my profile div----->


<!--------------------start of id proof div----------------------->

{{-- <div class="main-dv-re edit-top-space">
<div class="main-my-profile paddingnone">

  <div class="idprooftitle ">ID Proof Details</div>


   <form id="frm-profile_idproof" class="">

        {{ csrf_field() }}
                    
  <input type="hidden" name="old_front_image" value="{{$user_details_arr['user_details']['front_image'] or ''}}"> 
  <input type="hidden" name="old_back_image" value="{{$user_details_arr['user_details']['back_image'] or ''}}"> 
  <input type="hidden" name="old_selfie_image" value="{{$user_details_arr['user_details']['selfie_image'] or ''}}"> 
   

      <!----------------------------start of form of age verification------------->

      
    @if(isset($user_details_arr['user_details']['approve_verification_status']) && $user_details_arr['user_details']['approve_verification_status']==1)

              <div class="status-div-icon innermain-my-profile max-widnone">
                   
                        <div class="myprofile-lefts"> Verification Status </div>
                      @if(isset($user_details_arr['user_details']['approve_verification_status']) && $user_details_arr['user_details']['approve_verification_status']==1)
                        <div class="myprofile-right">
                          <div class="status-completed">Approved</div>
                        </div>
                      @endif 
               </div>
    @else
     <div class="clearfix"></div>
          <div class="innermain-my-profile">      
            <div class="row">      
              <div id="status_msg_idproof" class="row"></div>
              <div class="form-group">
                <div class="col-md-2"><label for="">Front of ID <span>*</span></label></div>
                <div class="col-md-10">
                  <div class="yprofiles">
                    <div class="int-profiles">                                
                      <input type="file" class="form-control" id="front_image" name="front_image"  data-allowed-file-extensions="png jpg JPG jpeg JPEG" data-errors-position="outside" data-parsley-errors-container="#image_error"  @if(isset($user_details_arr['user_details']['front_image']) && $user_details_arr['user_details']['front_image']!='') @else required="" data-parsley-required-message="Please select front of ID" @endif>
                    </div>

                    @if(isset($user_details_arr['user_details']['front_image']) && $user_details_arr['user_details']['front_image']!='')
                        <div class="uplaod-edit-img">
                            <img src="{{$id_proof_path.$user_details_arr['user_details']['front_image']}}" id="upload-f" class="profile" alt="Front of ID" width="100" height="100">
                          
                        </div> 
                      @endif
                  </div> 
                </div>
                <div class="clearfix"></div>
              </div>               

              <div class="form-group">
                <div class="col-md-2"><label for="">Back of ID <span>*</span></label></div>
                <div class="col-md-10">
                  <div class="yprofiles">
                    <div class="int-profiles">                            
                      <input type="file" class="form-control" id="back_image" name="back_image"  data-allowed-file-extensions="png jpg JPG jpeg JPEG" data-errors-position="outside" data-parsley-errors-container="#image_error" @if(isset($user_details_arr['user_details']['back_image']) && $user_details_arr['user_details']['back_image']!='') @else required="" data-parsley-required-message="Please select back of ID" @endif>
                    </div>

                    @if(isset($user_details_arr['user_details']['back_image']) && $user_details_arr['user_details']['back_image']!='')

                      <div class="uplaod-edit-img">
                        <img src="{{$id_proof_path.'/'.$user_details_arr['user_details']['back_image']}}" id="upload-f" class="profile" alt="Back of ID" width="100" height="100">
                       
                      </div>   
                    @endif
                  </div>
                </div>
                <div class="clearfix"></div>
              </div>

              <div class="form-group">
                <div class="col-md-2"><label for="">Selfie <span>*</span></label></div>
                <div class="col-md-10">
                  <div class="yprofiles">
                    <div class="int-profiles">                            
                        <input type="file" class="form-control" id="selfie_image" name="selfie_image"  data-allowed-file-extensions="png jpg JPG jpeg JPEG" data-errors-position="outside" data-parsley-errors-container="#image_error" @if(isset($user_details_arr['user_details']['selfie_image']) && $user_details_arr['user_details']['selfie_image']!='') @else required="required" data-parsley-required-message="Please select selfie" @endif>
                    </div>
                    @if(isset($user_details_arr['user_details']['selfie_image']) && $user_details_arr['user_details']['selfie_image']!='')

                      <div class="uplaod-edit-img">
                        <img src="{{$id_proof_path.'/'.$user_details_arr['user_details']['selfie_image']}}" id="upload-f" class="profile" alt="Selfie" width="100" height="100">
                       
                      </div>   
                    @endif
                  </div>
                </div>
                <div class="clearfix"></div>
              </div>

               <div class="form-group">
                    <div class="">
                     <div class="col-md-2"><label for="">Address <span>*</span></label></div>
                     <div class="col-md-10">
                      <div class="yprofiles">
                      <input type="text" id="age_address" name="age_address" value="{{$user_details_arr['user_details']['age_address'] or ''}}" data-parsley-required="true" data-parsley-required-message="Please enter full address" class="input-text" placeholder="Address">
                     <span class="add_note" for=""></span>
                     </div>
                     </div>
                  </div>
                  <div class="clearfix"></div>
                </div>

              <div class="col-md-12">
                <div class="button-list-dts">
                  <a href="javascript:void(0)" class="butn-def" id="btn-profile_idproof">SAVE</a>
                </div> 
              </div>
            </div>
          </div>

          @endif 
      

  </form>
</div>
</div> --}}
<!---------------------end of id proof div------------------------>

<!--------------start of business profile div-------->

<div class="idprooftitle  ">Business Details</div>
 

<div class="innermain-my-profile ">
  <div id="status_msg_business"></div>
<div class="pad-0">

  <div class="login-inner-form">
    <div class="details login-inr-fild">
     <form id="frm_add_business"> 
               {{ csrf_field() }}
        <input type="hidden" name="old_id_proof" id="old_id_proof" value="{{isset($business_details['id_proof'])?$business_details['id_proof']:''}}">

        <div class="form-group">
            <label for="">Business Name <span>*</span></label>

          {{--   <input type="text" name="business_name" id="business_name" class="input-text" placeholder="Enter Business Name" value="{{isset($business_details['business_name'])?$business_details['business_name']:''}}" data-parsley-required="true" data-parsley-required-message="Please enter business name"  data-parsley-pattern="/^[a-zA-Z0-9 ]*$/" data-parsley-pattern-message="Please remove special characters from business name"> --}}


            <input type="text" name="business_name" id="business_name" class="input-text" placeholder="Enter Business Name" value="{{isset($business_details['business_name'])?$business_details['business_name']:''}}" data-parsley-required="true" data-parsley-required-message="Please enter business name" 
             data-parsley-pattern="/^([A-Za-z0-9]+ )+[A-Za-z0-9]+$|^[A-Za-z0-9]+$/" data-parsley-pattern-message="Please remove special characters from business name">


           <div id="businessname_exist_error_message"></div>

        </div>
       {{--  <div class="form-group">
            <label for="">Tax ID. <span>*</span></label>
        
             <input type="text" name="tax_id" id="tax_id" class="input-text" placeholder="Enter Tax ID." value="{{isset($business_details['tax_id'])?$business_details['tax_id']:''}}" data-parsley-required="true" data-parsley-required-message="Please enter tax ID." data-parsley-type="digits"  data-parsley-maxlength="9"  data-parsley-minlength="9" data-parsley-minlength-message="Provided tax id should be 9 characters." data-parsley-maxlength-message="Provided tax id should be 9 characters." 
             data-parsley-type-message="Provided tax id should be numeric only." >
        </div> --}}


        <div class="form-group button-list-dts">
            <button type="submit" class="butn-def" id="btn_business_profile">SAVE</button>
        </div>
 
    </form>
   </div>
 </div>
  </div>
</div>

<div class="idprooftitle  ">Upload Documents</div>
 
<div class="innermain-my-profile ">
  <div id="status_msg_document"></div>
<div class="pad-0">

  <div class="login-inner-form">

    <div class="details login-inr-fild">
      @if(isset($list_document_required) && !empty($list_document_required))
     <div class="note-show-abtform">
    Upload: {{$list_document_required}} <span>*</span>
     </div>
     @endif


      @if(isset($str_document_required) && !empty($str_document_required))
        <div class="note-show-abtform">{{$str_document_required}}</div>
      @else
     <form id="frm_upload_documents"> 
           {{ csrf_field() }} 
     @if(sizeof($documents_arr)==0)       
        <div class="document_div">
          <div id="row1"  class="rowmain">
             @if(isset($documents_verification_status) && ($documents_verification_status=='2' || $documents_verification_status=='0'))
             <div class="plusiconright"> 
               <a href="javascript:void(0)" class="add_more_document addplus-icon" name="add_more_document" id="add_more_product_dimension_1" title="Add More"><i class="fa fa-plus"></i></a>
               {{--  <a href="javascript:void(0)" class="remove minuss-icon" name="add_more_product_dimension" id="1" rec_id="0"><i class="fa fa-minus"></i></a> --}}
                <div class="clearfix"></div> 
             </div>
             @elseif(isset($documents_verification_status) && ($documents_verification_status=='1' || $documents_verification_status=='3'))
                 <div class="text-right">
                  <a href="mailto:{{ $admin_arr['email'] }}" class="eye-actn" title="mailto:{{isset($admin_arr['email'])?$admin_arr['email']:''}}">
                    Request Change
                  </a>
                 </div>
             @endif
                       
           <div class="form-group">
              <label for="">Document Title <span>*</span></label>
              <input type="text" name="document_title[]" id="document_title_1" class="input-text document_title" placeholder="Enter Document Title" onkeyup="clear_err_div_dim(1)" value="{{isset($doc['document_title'])?$doc['document_title']:''}}">
             <span id="err_document_title_1" class="err"></span>
           </div>

          <div class="form-group">
              <label for="">Upload Document <span>*</span></label>
                                        <div class="errorwithnote" id="dynamic_field">
                                             <div class="clone-divs none-padding-profile">
                                                <input type="file" name="document[]" id="document_1" class="document" data-allowed-file-extensions="png jpg JPG jpeg JPEG doc docx pdf" data-errors-position="outside" data-parsley-errors-container="#image_error" onchange="clear_err_div_dim_value(1)"> 
                                                <span class="errorimg-cvr" id="image_error"></span>
                                                <input type="hidden" id="document_new_1">
                                            </div>                                        
                                        </div>
                                       <span id="err_document_1" class="err"></span>
                                      {{--   @if(isset($doc['document']) && $doc['document']!='')
                                        <div class="uplaod-edit-img">
                                            <img src="{{$document_path.$doc['document']}}" id="upload-f_1" class="profile" alt="Document" width="100" height="100" value="{{$document_path.$doc['document']}}">
                                        </div> 
                                      @endif --}}
            </div>
           </div> 
     </div>
    @endif 


           
      @php $i=1; @endphp
      @if(isset($documents_arr) && !empty($documents_arr))
       @foreach($documents_arr as $doc)
      <div class="document_div">
       <div class="rowmain" id="row{{$i}}">
           @if(isset($documents_verification_status) && ($documents_verification_status=='2' || $documents_verification_status=='0'))
               <div class="plusiconright">
                  @if(isset($i) && $i==1)  
                   <a href="javascript:void(0)" class="add_more_document addplus-icon" name="add_more_document" id="add_more_product_dimension_1" title="Add More"><i class="fa fa-plus" title="Add More"></i></a>
                  @endif  
                  @if(isset($i) && $i!=1)
                  <a href="javascript:void(0)" class="remove minuss-icon" name="add_more_product_dimension" id="{{$i}}" rec_id="{{$doc['id']}}"><i class="fa fa-minus"></i></a>
                  @endif
                   <div class="clearfix"></div> 
               </div>
          @elseif(isset($documents_verification_status) && ($documents_verification_status=='1' || $documents_verification_status=='3') && $i==1)
                  <div class="text-right">
                  <a href="mailto:{{ $admin_arr['email'] }}" class="eye-actn" title="mailto:{{isset($admin_arr['email'])?$admin_arr['email']:''}}">
                    Request Change
                  </a>
                 </div>     
         @endif
                     
          <div class="form-group">

            <label for="">Document Title <span>*</span></label>

            <input type="text" name="document_title[]" id="document_title_{{$i}}" class="input-text document_title" placeholder="Enter Document Title" onkeyup="clear_err_div_dim({{$i}})" value="{{isset($doc['document_title'])?$doc['document_title']:''}}" disabled="disabled">

            <input type="hidden" name="old_document_title[]" id="old_document_title_{{$i}}" value="{{isset($doc['document_title'])?$doc['document_title']:''}}">

           <span id="err_document_title_{{$i}}" class="err"></span>
         </div>


        <div class="form-group">
            <label for="">Upload Document <span>*</span></label>
              @php
                                        $ext  = "";
                                        $path = $doc['document'];
                                        if(isset($path) && $path!="")
                                        {  
                                          $ext  = pathinfo($path, PATHINFO_EXTENSION);
                                        }  
                                      @endphp
                                       @if(isset($doc['document']) && $doc['document']!='')
                                        @if(isset($ext) && ($ext=="doc" || $ext=="pdf" || $ext=="docx" || $ext=="xls" || $ext=="xlsx"))
                                      

                                        {{--   <img src="{{$document_path.$doc['document']}}" id="upload-f_{{$i}}" class="profile" alt="Document" width="100" height="100" value="{{$document_path.$doc['document']}}"> --}}
                                        <a href="{{$document_path.$doc['document']}}" target="_blank" title="View Document">view Document</a>
                                        @else
                                      <div class="errorwithnote" id="dynamic_field">
                                           <div class="clone-divs none-padding-profile">
                                              <input type="file" name="document[]" id="document_{{$i}}" class="document" data-allowed-file-extensions="png jpg JPG jpeg JPEG doc docx pdf" data-errors-position="outside" data-parsley-errors-container="#image_error" onchange="clear_err_div_dim_value({{$i}})" disabled="disabled"> 
                                              <input type="hidden" id="document_new_{{$i}}" value="{{$doc['document']}}">
                                              <span class="errorimg-cvr" id="image_error"></span>
                                          </div>                                        
                                      </div>
                                     
                                     <span id="err_document_{{$i}}" class="err"></span>

                                      
                                     <div id="doc_{{$i}}" style="display:none;">{{$document_path.$doc['document']}}</div> 

                                        <div class="uplaod-edit-img">

                                          <img src="{{$document_path.$doc['document']}}" id="upload-f_{{$i}}" class="profile" alt="Document" width="100" height="100" value="{{$document_path.$doc['document']}}">
                                        {{--  @else
                                        <img src="{{url('/')}}/assets/images/Profile-img-new.jpg" id="upload-f" class="profile" alt="" width="100" height="100"> --}}
                                      </div> 
                                     <div id="doc_{{$i}}" style="display:none;">{{$document_path.$doc['document']}}</div> 
                                     @endif
                                   @endif  
              </div>


            <input type="hidden" name="old_document[]" value="{{$doc['document']}}">
            <input type="hidden" name="seller_id" value="{{$user_details_arr['id']}}">
         </div> 
     </div>             
      @php $i++; @endphp
    @endforeach
   @endif  
  <div class="documents_div_new"></div>
    @if(isset($documents_verification_status) && ($documents_verification_status=='2' || $documents_verification_status=='0'))
        <div class="form-group button-list-dts">
            <input type="button"  class="butn-def" id="btn_upload_documents" value="SAVE">
        </div>
    @endif
   </form>
   @endif
   </div>
 </div>
  </div>
</div>
<!--------------end of business profile div-------->

</div> <!------end of wrapper class------------>
<script type="text/javascript">


    function readURL(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();
    
            reader.onload = function (e) {
                $('#upload-f')
                    .attr('src', e.target.result)
                    .width(160)
                    .height(160);
            };
    
            reader.readAsDataURL(input.files[0]);
        }
    } 
    $('#btn-profile').click(function(){
      
      /*Check all validation is true*/
      if($('#frm-profile').parsley().validate()==false) return;

      $.ajax({
        //url:SITE_URL+'/seller/business-profile/update',
        url:SITE_URL+'/seller/profile/update',

        data:new FormData($('#frm-profile')[0]),
        method:'POST',
        contentType:false,
        processData:false,
        cache: false,
        dataType:'json',
        beforeSend : function()
        {
          showProcessingOverlay();
          $('#btn-profile').prop('disabled',true);
          $('#btn-profile').html('Updating... <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');
        },
        success:function(response)
        {
            
          hideProcessingOverlay();
          $('#btn-profile').prop('disabled',false);
          $('#btn-profile').html('SAVE');

          if(typeof response =='object')
          {
            if(response.status && response.status=="SUCCESS")
            {
              var success_HTML = '';
              success_HTML +='<div class="alert alert-success alert-dismissible">\
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                        <span aria-hidden="true">&times;</span>\
                    </button>'+response.message+'</div>';

                    $('#status_msg').html(success_HTML);

                      $('html, body').animate({
                          scrollTop: $('#status_msg').offset().top
                      }, 'slow');


                     setTimeout(function(){
                       window.location.href="{{ url('/') }}/seller/profile";
                    },4000);
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
        }
      });
    });

//get selected country id for address form
function get_country_id(countryname,states_selected_val)
{
   $.ajax({
              url:SITE_URL+'/seller/profile/get_countryid',
              type:'GET',
              data:{
                      countryname:countryname
                    },
             // dataType:'JSON',
              beforeSend: function() {
                showProcessingOverlay();
              },
              success:function(countryid)
              { 
                  
                  hideProcessingOverlay();                   
                
                  if(countryid)
                  {
                    get_country_states(countryid,states_selected_val);
                  }

                 // $("#state").html(html);
                 // $("#administrative_area_level_1").html(html);
              }
      });
}//function get_country_id

//get selected countries state for address form
function get_country_states(country_id,states_selected_val)
{
     // var country_id  = $('#country').val();

      $.ajax({
              url:SITE_URL+'/seller/profile/get_states',
              type:'GET',
              data:{
                      country_id:country_id
                    },
              dataType:'JSON',
              beforeSend: function() {
                showProcessingOverlay();
              },
              success:function(response)
              { 
                  
                  hideProcessingOverlay();                   
                  var html = '';
                  html +='<option value="">Select State</option>';
                   
                  for(var i=0; i < response.arr_states.length; i++)
                  {
                    var obj_state = response.arr_states[i];
                    html+="<option value='"+obj_state.id+"'>"+obj_state.name+"</option>";
                  }
                  
                 // $("#state").html(html);
                  $("#administrative_area_level_1").html(html);
                  $("#administrative_area_level_1").val(states_selected_val);
              }
      });
  }//end get_country_states



     function get_states()
  {
      var country_id  = $('#country').val();
        
      $.ajax({
              url:SITE_URL+'/seller/profile/get_states',
              type:'GET',
              data:{
                      country_id:country_id
                    },
              dataType:'JSON',
              beforeSend: function() {
                showProcessingOverlay();
              },
              success:function(response)
              { 
                  
                  hideProcessingOverlay();                   
                  var html = '';
                  html +='<option value="">Select State</option>';
                   
                  for(var i=0; i < response.arr_states.length; i++)
                  {
                    var obj_state = response.arr_states[i];
                    html+="<option value='"+obj_state.id+"'>"+obj_state.name+"</option>";
                  }
                  
                 // $("#state").html(html);
                  $("#administrative_area_level_1").html(html);
              }
      });
  }

</script>    

<script>

     //Check image validation on upload file
    $("input[type=file]").on("change", function(e) 
    {

    
        var selectedID       = $(this).attr('id');

        var fileType         = this.files[0].type;
         var validImageTypes = ["image/jpg", "image/jpeg", "image/png",
                               "image/JPG", "image/JPEG", "image/PNG",
                               "application/vnd.openxmlformats-officedocument.wordprocessingml.document","application/docx","application/pdf",
                               "application/vnd.ms-excel","application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"];
      
        if($.inArray(fileType, validImageTypes) < 0) 
        {
          swal('Alert!','Please select valid document type. Only jpg, jpeg,png,doc,docx,pdf files are allowed.');

          $('#'+selectedID).val('');
        }
    });
  


$('#btn-profile_idproof').click(function(){
      
      /*Check all validation is true*/
      if($('#frm-profile_idproof').parsley().validate()==false) return;

      $.ajax({
        //url:SITE_URL+'/seller/business-profile/update',
        url:SITE_URL+'/seller/id_verification/update',

        data:new FormData($('#frm-profile_idproof')[0]),
        method:'POST',
        contentType:false,
        processData:false,
        cache: false,
        dataType:'json',
        beforeSend : function()
        {
          showProcessingOverlay();
          $('#btn-profile_idproof').prop('disabled',true);
          $('#btn-profile_idproof').html('Updating... <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');
        },
        success:function(response)
        {
          hideProcessingOverlay();
          $('#btn-profile_idproof').prop('disabled',false);
          $('#btn-profile_idproof').html('SAVE');

          if(typeof response =='object')
          {
            if(response.status && response.status=="SUCCESS")
            {
              var success_HTML = '';
              success_HTML +='<div class="alert alert-success alert-dismissible">\
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                        <span aria-hidden="true">&times;</span>\
                    </button>'+response.message+'</div>';

                    $('#status_msg_idproof').html(success_HTML);
                     $('html, body').animate({
                          scrollTop: $('#status_msg_idproof').offset().top
                      }, 'slow');

                    setTimeout(function(){
                       window.location.href="{{ url('/') }}/seller/profile";
                    },4000);
                   
            }
            else
            {                    
                var error_HTML = '';   
                error_HTML+='<div class="alert alert-danger alert-dismissible">\
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                        <span aria-hidden="true">&times;</span>\
                    </button>'+response.message+'</div>';
                
                $('#status_msg_idproof').html(error_HTML);
            }
          }
        }
      });
    });

</script>
<script>
  

    $('#btn_business_profile').click(function(){
      
      /*Check all validation is true*/
      if($('#frm_add_business').parsley().validate()==false) return;

      $.ajax({
        //url:SITE_URL+'/seller/business-profile/update',
        url:SITE_URL+'/seller/business-profile/update',

        data:new FormData($('#frm_add_business')[0]),
        method:'POST',
        contentType:false,
        processData:false,
        cache: false,
        dataType:'json',
        beforeSend : function()
        {
          showProcessingOverlay();
          $('#btn_business_profile').prop('disabled',true);
          $('#btn_business_profile').html('Updating... <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');
        },
        success:function(response)
        {
          hideProcessingOverlay();
          $('#btn_business_profile').prop('disabled',false);
          $('#btn_business_profile').html('SAVE');

          if(typeof response =='object')
          {
            if(response.status && response.status=="SUCCESS")
            {
              var success_HTML = '';
              success_HTML +='<div class="alert alert-success alert-dismissible">\
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                        <span aria-hidden="true">&times;</span>\
                    </button>'+response.message+'</div>';

                    $('#status_msg_business').html(success_HTML);
                     $('html, body').animate({
                          scrollTop: $('#status_msg_business').offset().top
                      }, 'slow');

                    setTimeout(function(){
                       window.location.href="{{ url('/') }}/seller/profile";
                     },4000);
                   
            }
            else
            {                    
                var error_HTML = '';   
                error_HTML+='<div class="alert alert-danger alert-dismissible">\
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                        <span aria-hidden="true">&times;</span>\
                    </button>'+response.message+'</div>';
                $("#hideuploadtext").val('');
                $('#status_msg_business').html(error_HTML);
            }
          }
        }
      });
    });


 $("#business_name").change(function(){
    var business_name = $(this).val();
   
     $.ajax({
        url:SITE_URL+'/common/get_business_name/'+business_name,
        method:'GET',
        dataType:'json',                         
        success:function(response)
        {       
              if(typeof response =='object')
              {
                if(response.status && response.status=="SUCCESS")
                {
                   var error_HTML = '';   
                   $('#status_msg_business').html(error_HTML);

                }else if(response.status && response.status=="ERROR"){
                   

                    var error_HTML = '';   
                    error_HTML+='<div class="alert alert-danger alert-dismissible">\
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                            <span aria-hidden="true">&times;</span>\
                        </button>'+response.msg+'</div>';                   
                    $('#status_msg_business').html(error_HTML);

                  //$('#status_msg').css('color','red').html(response.msg);
                  return false;

                }
              }// if object
        } //success 
      });    
  });//end business_name function


     $('#btn_upload_documents').click(function(){
    
        var document_titles = $("input[name='document_title[]']")
              .map(function(){return $(this).val();}).get();
        var document_files  = $("input[name='document[]']")
              .map(function(){return $(this).val();}).get(); 


      // var inputs = document.querySelectorAll("#frm_upload_documents input[name='document[]']");

        if(document_titles.length>0)
        { 

          for (var i = 1; i <= document_titles.length; i++) {

              if($("#document_title_"+i).val()=="")
              {  
                 $("#err_document_title_"+i).html('Please enter document title.'); 
                 $("#document_title_"+i).focus();
                 return false;
              }

              /*else if($("#document_new_"+i).val()=="")
              {  
                 $("#err_document_"+i).html('Please upload document.'); 
                 $("#document_"+i).focus();
                 return false;
              }*/
          }
        }

/*        if(files_length>0)
        { 

          for (var i = 1; i <= files_length; i++) {



              if($("#document_"+i).val()=="")
              {  
                 $("#err_document_"+i).html('Please enter document title.'); 
                 $("#document_"+i).focus();
                 return false;
              }
            
          }
        }*/


/*
        if(files.length>0)
        { 
          for (var i = 1; i <= files.length; i++) {
              if($("#document_"+i).val()=="" && $("#document_title_"+i).val()!="")
              {  
                 $("#err_document_"+i).html('Please upload document.'); 
                 $("#document_"+i).focus();
                 return false;
              }
          }
        }*/

/*        if(document_files.length>0)
        { 
          for (var i = 1; i <= document_files.length; i++) {
              if($("#document_"+i).val()=="" && $("#document_title_"+i).val()!="")
              {
                 $("#err_document_"+i).html('Please select document.'); 
                 $("#document_"+i).focus();
                 return false;
              }
          }
        }
      */
/*      /*Check all validation is true*/
      //if($('#frm_upload_documents').parsley().validate()==false) return;




      $.ajax({
        //url:SITE_URL+'/seller/business-profile/update',
        url:SITE_URL+'/seller/upload-documents/update',

        data:new FormData($('#frm_upload_documents')[0]),
        method:'POST',
        contentType:false,
        processData:false,
        cache: false,
        dataType:'json',
        beforeSend : function()
        {
          showProcessingOverlay();
          $('#btn_upload_documents').prop('disabled',true);
          $('#btn_upload_documents').html('Uploading... <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');
        },
        success:function(response)
        {
          hideProcessingOverlay();
          $('#btn_upload_documents').prop('disabled',false);
          $('#btn_upload_documents').html('SAVE');

          if(typeof response =='object')
          {
            if(response.status && response.status=="SUCCESS")
            {
              var success_HTML = '';
              success_HTML +='<div class="alert alert-success alert-dismissible">\
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                        <span aria-hidden="true">&times;</span>\
                    </button>'+response.message+'</div>';

                    $('#status_msg_document').html(success_HTML);
                     $('html, body').animate({
                          scrollTop: $('#status_msg_document').offset().top
                      }, 'slow');

                    setTimeout(function(){
                       window.location.href="{{ url('/') }}/seller/profile";
                     },4000);
                   
            }
            else
            {                    
                var error_HTML = '';   
                error_HTML+='<div class="alert alert-danger alert-dismissible">\
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                        <span aria-hidden="true">&times;</span>\
                    </button>'+response.message+'</div>';
                $("#hideuploadtext").val('');
                $('#status_msg_document').html(error_HTML);
                 $('html, body').animate({
                          scrollTop: $('#status_msg_document').offset().top
                      }, 'slow');

            }
          }
        }
      });
    });


  var last_row  = ""; 
  var inputcount = $(document).find('.document_title').length;
  var i=inputcount; 

    
   $(".add_more_document").click(function(){


          
             if(inputcount<10)
             { 
                   last_row_doc_title  = $('#document_title_'+i).val();
                  // last_row_doc      = document.getElementById('upload-f_'+i).getAttribute('src');


                  if(last_row_doc_title==""){
                      $('#err_document_title_'+i).html('Please enter document title.');
                      $('#document_title_'+i).focus();
                      return false;
                  } 
                  /*if(last_row_doc==""){
                      $('#err_document_'+i).html('Please upload document.');
                      $('#document_'+i).focus();
                      return false;
                  }*/ 

                 i++; 

                $('.documents_div_new').append('<div id="row'+i+'" class="rowmain"><div class="plusiconright"><a href="javascript:void(0)" class="remove minuss-icon" name="add_more_product_dimension" id="'+i+'" rec_id=""><i class="fa fa-minus"></i></a> <div class="clearfix"></div></div><div class="form-group"><label for="">Document Title <span>*</span></label><input type="text" name="document_title[]" id="document_title_'+i+'" class="input-text document_title" placeholder="Enter Document Title" onkeyup="clear_err_div_dim('+i+')"><span id="err_document_title_'+i+'" class="err"></span></div><div class="form-group"><label for="">Upload Document <span>*</span></label><div class="errorwithnote" id="dynamic_field"><div class="clone-divs none-padding-profile"><input type="file" name="document[]" id="document_'+i+'" class="document" data-allowed-file-extensions="png jpg JPG jpeg JPEG" data-errors-position="outside" data-parsley-errors-container="#image_error" onchange="clear_err_div_dim_value('+i+')"><input type="hidden" id="document_new_'+i+'"><span class="errorimg-cvr" id="image_error"></span></div></div><span id="err_document_'+i+'" class="err"></span></div></div>');
             } 
             else
             {
                  alert('You can not upload more documents');
             }
    });


    
      $(document).on('click', '.remove', function(){  

         /*  var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  */
           var button_id = $(this).attr("id"); 
           var rec_id    = $(this).attr("rec_id");
           var document_title = $("#document_title_"+button_id).val();
           var document_file  = $('#doc_'+button_id).html();


         /*if(document_title!="" && document_file!="")
         {*/
                swal({
                title: "Need Confirmation",
                text:  "Are you sure? Do you want to remove this row.",
                type:  "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "OK",
                cancelButtonText: "Cancel",
                closeOnConfirm: true,
                closeOnCancel: true
              },
              function(isConfirm) 
              {
                if (isConfirm) 
                {
                  $('#row'+button_id+'').remove();  
                   $.ajax({
                    url:SITE_URL+'/seller/upload-documents/remove',
                    data:{rec_id:rec_id},
                    method:'GET',
                    dataType:'json',
                   
                    success:function(response)
                    {
                      
                      if(typeof response =='object')
                      {
                        if(response.status && response.status=="SUCCESS")
                        {

                          window.location.href="{{ url('/') }}/seller/profile/edit";

                        }
                        else
                        {                    
                        
                          window.location.href="{{ url('/') }}/seller/profile/edit";
                         
                        }
                      }
                    }
      });
                   
    }
               
  }); 
         
      }); 

     function clear_err_div_dim(i) 
     {
      
         var document_title     = $("#document_title_"+i).val();
         //var document_file    = document.getElementById('upload-f_'+i).getAttribute('src');


          if(document_title=="")
          {
            $("#err_document_title_"+i).html('Please enter document title.');
            $("#err_document_title_"+i).addClass('err');
            return false;
          }  
          else if(document_title!="")
          {
              $("#err_document_title_"+i).html('');
          }
          /*else if(document_title=="" && document_file=="")
          {
             $("#err_document_title_"+i).html('');
             $("#err_document_"+i).html('');
             if(i!=1)
             { 
               $('#row'+i+'').remove();  
             }
          }
          else if(document_title!="")
          {
              $("#err_document_title_"+i).html('');
          }*/
     }

    function clear_err_div_dim_value(i) 
     {
         var document_title     = $("#document_title_"+i).val();
        /* var document_file      = document.getElementById('upload-f_'+i).getAttribute('src');

          if(document_title!=""  && document_file=="")
          {
            $("#err_document_"+i).html('Please upload document.');
            $("#err_document_"+i).addClass('err');
            return false;
          }
          else if(document_file=="" && document_title=="")
          {     
            $("#err_document_title_"+i).html('');
            $("#err_document_"+i).html('');
            if(i!=1)
            {  
              $('#row'+i+'').remove();  
            }
          } 
          else if(document_file!="")
          {
              $("#err_document_"+i).html('');
          }*/
       }
 
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBwEKBOzIn5iOO4_0VuFcCldDziZn0cYbc&callback=initAutocomplete&libraries=places&v=weekly" async >
</script>
<script>
      // This sample uses the Autocomplete widget to help the user select a
      // place, then it retrieves the address components associated with that
      // place, and then it populates the form fields with those details.
      // This sample requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script
      // src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">
      let placeSearch;
      let autocomplete;
      const componentForm = {
        street_number: "short_name",
        route: "long_name",
        locality: "long_name",
        administrative_area_level_1: "long_name",
        country: "long_name",
        postal_code: "short_name",
      };

      function initAutocomplete() {
        // Create the autocomplete object, restricting the search predictions to
        // geographical location types.
        autocomplete = new google.maps.places.Autocomplete(
          document.getElementById("autocomplete"),
          { types: ["geocode"] }
        );
        // Avoid paying for data that you don't need by restricting the set of
        // place fields that are returned to just the address components.
        autocomplete.setFields(["address_component"]);
        // When the user selects an address from the drop-down, populate the
        // address fields in the form.
        autocomplete.addListener("place_changed", fillInAddress);
      }

      function fillInAddress() {
        // Get the place details from the autocomplete object.
        const place = autocomplete.getPlace();

        for (const component in componentForm) {
          document.getElementById(component).value = "";
          document.getElementById(component).disabled = false;
        }

        // Get each component of the address from the place details,
        // and then fill-in the corresponding field on the form.
        for (const component of place.address_components) {
          const addressType = component.types[0];

          if (componentForm[addressType]) {
            const val = component[componentForm[addressType]];


            if(addressType=="country")
            { 
               $("#country option").filter(function() { 
                 if($(this).text() == val)
                 {
                    var states_selected_val = $('#administrative_area_level_1 option:selected').val();

                    get_country_id(val,states_selected_val);

                   return $(this).text() == val;    
                 }
                }).prop('selected', true);

            }
            else
            { 
              if(addressType=="administrative_area_level_1")
              { 
                 
                   $("#administrative_area_level_1 option").filter(function() {

                     return $(this).text() == val;
                    
                    }).prop('selected', true);
                  // get_states();

              }else
              {

                 if(addressType=="route")
                  {
                     const street_number = $("#street_number").val();
                      
                      if(street_number.trim()!='')
                      {
                         document.getElementById(addressType).value = street_number + " " + val;
                      }
                      else
                      {
                         document.getElementById(addressType).value = val;
                      }
                   
                  }
                  else
                  {
                    document.getElementById(addressType).value = val;
                  }
              }

              

             }//else
            
          }
        }
      }

      // Bias the autocomplete object to the user's geographical location,
      // as supplied by the browser's 'navigator.geolocation' object.
      function geolocate() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition((position) => {
            const geolocation = {
              lat: position.coords.latitude,
              lng: position.coords.longitude,
            };
            const circle = new google.maps.Circle({
              center: geolocation,
              radius: position.coords.accuracy,
            });
            autocomplete.setBounds(circle.getBounds());
          });
        }
      }
    </script>      


@endsection
