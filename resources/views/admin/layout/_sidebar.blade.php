@php

    $module_arr = [];
    $user = Sentinel::check();
    $module_arr = isset($assigned_module_arr)?$assigned_module_arr:[];
  

    $admin_path     = config('app.project.admin_panel_slug');
    $obj_data  = Sentinel::getUser();
        
    $totNotiCnt = 0;
    if($obj_data)
    {
        $arr_data   = $obj_data->toArray();    
        $logUserID  = $obj_data->id;

        if(($user->inRole('admin')) || ($user->inRole('sub_admin') && in_array('notification',$module_arr)))
        {
           
             $totNotiCnt = get_notifications_count(1);
            
        }else{
             $totNotiCnt = get_notifications_count($logUserID);
        }

       // $totNotiCnt = get_notifications_count($logUserID);
    }               
@endphp


 @php
    if(isset($site_setting_arr['site_logo']) && $site_setting_arr['site_logo']!='' && file_exists(base_path().'/uploads/profile_image/'.$site_setting_arr['site_logo'])){
    $sitelogo = url('/').'/uploads/profile_image/'.$site_setting_arr['site_logo'];
    }else{
     $sitelogo = url('/').'/assets/front/images/chow-logo.png';
    }

   $module_arr = [];


   $modules = isset($assigned_module_arr)?$assigned_module_arr:[];

    if(isset($modules) && count($modules)>0)
    { 
        foreach($modules as $key=>$menus)
        { 
           array_push($module_arr,trim($menus));
        }
    }

    $assigned_module_arr = $module_arr;

    $user = Sentinel::check();

@endphp    

 <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top m-b-0">
            <div class="navbar-header"> 
            <a class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse"><i class="ti-menu"></i></a>
                <div class="top-left-part">
                    @if($user->inRole('admin'))
                        <a class="logo" href="{{ url(config('app.project.admin_panel_slug').'/dashboard') }}">
                        <b>   
                          <img src="{{$sitelogo}}" class="sidebarimgs" alt="home" /></b>
                        </a>
                    @elseif($user->inRole('sub_admin'))
                      <a class="logo" href="javascript:void(0);">
                      <b>   
                       <img src="{{$sitelogo}}" class="sidebarimgs" alt="home" /></b>
                      </a>
                    @endif
                </div>
                {{-- <ul class="nav navbar-top-links navbar-left hidden-xs">
                    <li><a href="javascript:void(0)" class="open-close hidden-xs waves-effect waves-light"><i class="icon-arrow-left-circle ti-menu"></i></a></li>
                    <li>
                        <form role="search" class="app-search hidden-xs">
                            <input type="text" placeholder="Search..." class="form-control"> <a href=""><i class="fa fa-search"></i></a> </form>
                    </li>
                </ul> --}}
                <ul class="nav navbar-top-links navbar-right pull-right">
                    <li class="dropdown">

                        @if(($user->inRole('admin')) || ($user->inRole('sub_admin') && in_array('notification',$assigned_module_arr)))

                            <a href="{{ url('/').'/'.$admin_path }}/notification"><i class="icon-bell"></i>
                                <div class="countsidebr" id="admin_notify">{{$totNotiCnt}}</div>
                            </a>
                            
                        @endif
                            
                        <ul class="dropdown-menu mailbox animated bounceInDown">
                          {{--   <li>
                                <div class="drop-title">You have 4 new messages</div>
                            </li> --}}
                            <li>
                                <div class="message-center">
                                    <a href="#" class="no-notifications-found">
                                        Notification Not Found
                                    </a>
                                    <a href="#" class="latest-notifications">
                                    </a>
                                    {{-- <a href="#">
                                        <div class="user-img"> <img src="{{url('/')}}/assets/admin/plugins/images/users/sonu.jpg" alt="user" class="img-circle"> <span class="profile-status busy pull-right"></span> </div>
                                        <div class="mail-contnet">
                                            <h5>Sonu Nigam</h5> <span class="mail-desc">I've sung a song! See you at</span> <span class="time">9:10 AM</span> </div>
                                    </a>
                                    <a href="#">
                                        <div class="user-img"> <img src="{{url('/')}}/assets/admin/plugins/images/users/arijit.jpg" alt="user" class="img-circle"> <span class="profile-status away pull-right"></span> </div>
                                        <div class="mail-contnet">
                                            <h5>Arijit Sinh</h5> <span class="mail-desc">I am a singer!</span> <span class="time">9:08 AM</span> </div>
                                    </a>
                                    <a href="#">
                                        <div class="user-img"> <img src="{{url('/')}}/assets/admin/plugins/images/users/pawandeep.jpg" alt="user" class="img-circle"> <span class="profile-status offline pull-right"></span> </div>
                                        <div class="mail-contnet">
                                            <h5>Pavan kumar</h5> <span class="mail-desc">Just see the my admin!</span> <span class="time">9:02 AM</span> </div>
                                    </a> --}}
                                </div>
                            </li>
                            <li class="see-all-notifications" style="display: none;">
                                <a class="text-center" href="{{ url(config('app.project.admin_panel_slug').'/notification') }}"> <strong>See all notifications</strong> <i class="fa fa-angle-right"></i> </a>
                            </li>
                        </ul>
                        <!-- /.dropdown-messages -->
                    </li>

                    <li class="dropdown">

                        @php
                        if(isset($arr_data['profile_image']) && $arr_data['profile_image'] != '' && file_exists(base_path().'/uploads/profile_image/'.$arr_data['profile_image']))
                        {
                            $profile_img = url('/uploads/profile_image/'.$arr_data['profile_image']);
                        }
                        else
                        {                  
                            $profile_img = url('/assets/images/avatar.png');
                        }
                        @endphp



                        <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"> 
                            <img id="admin-profile-img" 
                            src="{{ $profile_img }}" alt="user-img" width="36" 
                            class="img-circle">
                            <b class="hidden-xs">{{$arr_data['first_name'] or ''}}</b> 
                        </a>
                        <ul class="dropdown-menu dropdown-user animated flipInY">
                        <!--<li><a href="{{url('/')}}"><i class="ti-world"></i> Visit Website</a></li>-->

                        @if(($user->inRole('admin')) || ($user->inRole('sub_admin') && in_array('change_password',$assigned_module_arr)))

                           <li><a href="{{ url('/').'/'.$admin_path.'/change_password' }}"><i class="ti-key"></i> Change Password</a></li>
                        @endif
                           
                        <li role="separator" class="divider"></li>

                     {{--    @if(($user->inRole('admin')) || ($user->inRole('sub_admin') && in_array('logout',$assigned_module_arr))) --}}
                            
                          <li><a href="{{ url('/').'/'.$admin_path }}/logout"><i class="fa fa-power-off"></i> Logout</a></li>

                      {{--   @endif --}}

                        </ul>
                        <!-- /.dropdown-user -->
                    </li>
                    <!-- .Megamenu -->
                    <li class="mega-dropdown"> 
                    {{-- <a class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#"><span class="hidden-xs">Mega</span> <i class="icon-options-vertical"></i></a> --}}
                        <ul class="dropdown-menu mega-dropdown-menu animated bounceInDown">
                            <li class="col-sm-3">
                                <ul>
                                    <li class="dropdown-header">Forms Elements</li>
                                    <li><a href="form-basic.html">Basic Forms</a></li>
                                    <li><a href="form-layout.html">Form Layout</a></li>
                                    <li><a href="form-advanced.html">Form Addons</a></li>
                                    <li><a href="form-material-elements.html">Form Material</a></li>
                                    <li><a href="form-float-input.html">Form Float Input</a></li>
                                    <li><a href="form-upload.html">File Upload</a></li>
                                    <li><a href="form-mask.html">Form Mask</a></li>
                                    <li><a href="form-img-cropper.html">Image Cropping</a></li>
                                    <li><a href="form-validation.html">Form Validation</a></li>
                                </ul>
                            </li>
                            <li class="col-sm-3">
                                <ul>
                                    <li class="dropdown-header">Advance Forms</li>
                                    <li><a href="form-dropzone.html">File Dropzone</a></li>
                                    <li><a href="form-pickers.html">Form-pickers</a></li>
                                    <li><a href="icheck-control.html">Icheck Form Controls</a></li>
                                    <li><a href="form-wizard.html">Form-wizards</a></li>
                                    <li><a href="form-typehead.html">Typehead</a></li>
                                    <li><a href="form-xeditable.html">X-editable</a></li>
                                    <li><a href="form-summernote.html">Summernote</a></li>
                                    <li><a href="form-bootstrap-wysihtml5.html">Bootstrap wysihtml5</a></li>
                                    <li><a href="form-tinymce-wysihtml5.html">Tinymce wysihtml5</a></li>
                                </ul>
                            </li>
                            <li class="col-sm-3">
                                <ul>
                                    <li class="dropdown-header">Table Example</li>
                                    <li><a href="basic-table.html">Basic Tables</a></li>
                                    <li><a href="table-layouts.html">Table Layouts</a></li>
                                    <li><a href="data-table.html">Data Table</a></li>
                                    <li class="hidden"><a href="crud-table.html">Crud Table</a></li>
                                    <li><a href="bootstrap-tables.html">Bootstrap Tables</a></li>
                                    <li><a href="responsive-tables.html">Responsive Tables</a></li>
                                    <li><a href="editable-tables.html">Editable Tables</a></li>
                                    <li><a href="foo-tables.html">FooTables</a></li>
                                    <li><a href="jsgrid.html">JsGrid Tables</a></li>
                                </ul>
                            </li>
                            <li class="col-sm-3">
                                <ul>
                                    <li class="dropdown-header">Charts</li>
                                    <li> <a href="flot.html">Flot Charts</a> </li>
                                    <li><a href="morris-chart.html">Morris Chart</a></li>
                                    <li><a href="chart-js.html">Chart-js</a></li>
                                    <li><a href="peity-chart.html">Peity Charts</a></li>
                                    <li><a href="knob-chart.html">Knob Charts</a></li>
                                    <li><a href="sparkline-chart.html">Sparkline charts</a></li>
                                    <li><a href="extra-charts.html">Extra Charts</a></li>
                                </ul>
                            </li>
                            <li class="col-sm-12 m-t-40 demo-box">
                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="white-box text-center bg-purple"><a href="http://eliteadmin.themedesigner.in/demos/eliteadmin-inverse/index.html" target="_blank" class="text-white"><i class="linea-icon linea-basic fa-fw" data-icon="v"></i><br/>Demo 1</a></div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="white-box text-center bg-success"><a href="http://eliteadmin.themedesigner.in/demos/eliteadmin/index.html" target="_blank" class="text-white"><i class="linea-icon linea-basic fa-fw" data-icon="v"></i><br/>Demo 2</a></div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="white-box text-center bg-info"><a href="http://eliteadmin.themedesigner.in/demos/eliteadmin-ecommerce/index.html" target="_blank" class="text-white"><i class="linea-icon linea-basic fa-fw" data-icon="v"></i><br/>Demo 3</a></div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="white-box text-center bg-inverse"><a href="http://eliteadmin.themedesigner.in/demos/eliteadmin-horizontal-navbar/index3.html" target="_blank" class="text-white"><i class="linea-icon linea-basic fa-fw" data-icon="v"></i><br/>Demo 4</a></div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="white-box text-center bg-warning"><a href="http://eliteadmin.themedesigner.in/demos/eliteadmin-iconbar/index4.html" target="_blank" class="text-white"><i class="linea-icon linea-basic fa-fw" data-icon="v"></i><br/>Demo 5</a></div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="white-box text-center bg-danger"><a href="https://themeforest.net/item/elite-admin-responsive-web-app-kit-/16750820?ref=suniljoshi" target="_blank" class="text-white"><i class="linea-icon linea-ecommerce fa-fw" data-icon="d"></i><br/>Buy Now</a></div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <li class="right-side-toggle"> <a class="waves-effect waves-light" href="javascript:void(0)"><i class="ti-settings"></i></a></li>
                    </li>
                    <!-- /.Megamenu -->
                    {{-- <li class="right-side-toggle"> <a class="waves-effect waves-light" href="javascript:void(0)"><i class="ti-settings"></i></a></li> --}}
                    <!-- /.dropdown -->
                </ul>
            </div>
            <!-- /.navbar-header -->
            <!-- /.navbar-top-links -->
            <!-- /.navbar-static-side -->
        </nav>
        <!-- Left navbar-header -->
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse slimscrollsidebar">
                <ul class="nav" id="side-menu">
                    <li class="sidebar-search hidden-sm hidden-md hidden-lg">
                        <!-- input-group -->
                        <div class="input-group custom-search-form">
                            <input type="text" class="form-control" placeholder="Search..."> <span class="input-group-btn">
            <button class="btn btn-default" type="button"> <i class="fa fa-search"></i> </button>
            </span> </div>
                        <!-- /input-group -->
                    </li>
                    <li class="user-pro">
                        <a href="#" class="waves-effect">
                               @php
                                if(isset($arr_data['profile_image']) && $arr_data['profile_image'] != '' && file_exists(base_path().'/uploads/profile_image/'.$arr_data['profile_image']))
                                {
                                    $profile_img = url('/uploads/profile_image/'.$arr_data['profile_image']);
                                }
                                else
                                {                  
                                    $profile_img = url('/assets/images/avatar.png');
                                }
                               @endphp
                           
                               <img src="{{$profile_img}}" class="img-circle"><span class="hide-menu"> {{$arr_data['first_name'] or ''}}<span class="fa arrow"></span></span>

                        </a>
                        <ul class="nav nav-second-level">

                           @if(($user->inRole('admin')) || ($user->inRole('sub_admin') && in_array('account_settings',$assigned_module_arr)))
                            
                            <li><a href="{{ url('/').'/'.$admin_path.'/account_settings' }}"><i class="ti-settings"></i> Account Settings</a></li>

                           @endif 
                          
                           {{-- @if(($user->inRole('admin')) || ($user->inRole('sub_admin') && in_array('logout',$assigned_module_arr))) --}}

                             <li><a href="{{ url('/').'/'.$admin_path }}/logout"><i class="fa fa-power-off"></i> Logout</a></li>

                           {{-- @endif --}}

                        </ul>
                    </li>

                 @if(($user->inRole('admin')) || ($user->inRole('sub_admin') && in_array('dashboard', $assigned_module_arr))) 

                    <li class="<?php  if(Request::segment(2) == 'categories'){ echo 'active'; } ?>"> <a href="{{ url('/').'/'.$admin_path.'/dashboard'}}" class="waves-effect"><span class="icn-left-side"> <i data-icon="P" class=" ti-dashboard"></i></span> <span class="hide-menu"> Dashboard</span></a> </li>

                @endif

                     <!-- <li class="user-pro">
                        <a href="#" class="waves-effect"><span class="icn-left-side"><i data-icon="P" class="ti-crown"></i></span><span class="hide-menu">OnChain Config<span class="fa arrow"></span></span></a>
                    
                        <ul class="nav nav-second-level">
                             <li class="<?php  if(Request::segment(2) == 'onchain_config' && Request::segment(3) == 'trade'){ echo 'active'; } ?>"> <a href="{{ url('/').'/'.$admin_path.'/onchain_config/trade'}}" class="waves-effect"><span class="icn-left-side"> <i data-icon="P" class=" ti-dashboard"></i></span> <span class="hide-menu"> Trade</span></a> </li>

                             <li class="<?php  if(Request::segment(2) == 'onchain_config' && Request::segment(3) == 'dispute_settlement'){ echo 'active'; } ?>"> <a href="{{ url('/').'/'.$admin_path.'/onchain_config/dispute_settlement'}}" class="waves-effect"><span class="icn-left-side"> <i data-icon="P" class=" ti-dashboard"></i></span> <span class="hide-menu">Dispute Settlement</span></a> </li>

                        </ul>
                    </li> --> 

                  


                    
                    <!-- <li class="<?php  if(Request::segment(2) == 'activity_logs'){ echo 'active'; } ?>">
                    <a href="{{ url('/').'/'.$admin_path.'/activity_logs' }}" class="waves-effect"><i data-icon="P" class="icon-bubble"></i> <span class="hide-menu">Activity Log</span></a>
                    </li> -->

                    <!--<li class="<?php  if(Request::segment(2) == 'categories'){ echo 'active'; } ?>"> <a href="{{ url('/').'/'.$admin_path.'/categories'}}" class="waves-effect"><i data-icon="P" class=" ti-crown"></i> <span class="hide-menu"> Categories</span></a> </li>-->

                @if(($user->inRole('admin')) || ($user->inRole('sub_admin') && in_array('site_settings', $assigned_module_arr)))    

                    <li class="<?php  if(Request::segment(2) == 'site_settings'){ echo 'active'; } ?>"> <a href="{{ url(config('app.project.admin_panel_slug').'/site_settings') }}" class="waves-effect"><span class="icn-left-side"><i data-icon="P" class="linea-icon linea-basic fa-fw"></i></span> <span class="hide-menu">Site Settings</span></a> </li>

                @endif    

                @if(($user->inRole('admin')) || ($user->inRole('sub_admin') && in_array('membership',$assigned_module_arr)))    
                
                    <li class="<?php  if(Request::segment(2) == 'membership'){ echo 'active'; } ?>"> <a href="{{ url(config('app.project.admin_panel_slug').'/membership') }}" class="waves-effect"><span class="icn-left-side"><i data-icon="P" class="fa fa-credit-card-alt"></i></span> <span class="hide-menu">Membership Plans</span></a> </li>

                @endif

                 
                @if(($user->inRole('admin')) || ($user->inRole('sub_admin') && in_array('container',$assigned_module_arr)))

                     <li class="<?php  if(Request::segment(2) == 'container'){ echo 'active'; } ?>"> <a href="{{ url(config('app.project.admin_panel_slug').'/container') }}" class="waves-effect"><span class="icn-left-side"><i data-icon="P" class="fa fa-crosshairs"></i></span> <span class="hide-menu">Forum Containers </span></a> </li>

                @endif     

                @if(($user->inRole('admin')) || ($user->inRole('sub_admin') && in_array('post',$assigned_module_arr)))

                       <li class="<?php  if(Request::segment(2) == 'post'){ echo 'active'; } ?>"> <a href="{{ url(config('app.project.admin_panel_slug').'/post') }}" class="waves-effect"><span class="icn-left-side"><i data-icon="P" class="fa fa-comment"></i></span> <span class="hide-menu">Forum Posts </span></a> </li>
                @endif       


                 
                @if(($user->inRole('admin')) || (($user->inRole('sub_admin') && in_array('first_level_categories',$assigned_module_arr)) ||($user->inRole('sub_admin') && in_array('second_level_categories',$assigned_module_arr))))

                    <li class="user-pro">
                        <a href="#" class="waves-effect"><span class="icn-left-side"><i data-icon="P" class="ti-crown"></i></span><span class="hide-menu">Categories<span class="fa arrow"></span></span></a>
                    
                        <ul class="nav nav-second-level">

                        @if(($user->inRole('admin')) || ($user->inRole('sub_admin') && in_array('first_level_categories',$assigned_module_arr)))
                            
                            <li class="<?php  if(Request::segment(2) == 'first_level_categories'){ echo 'active'; } ?>"> <a href="{{ url($admin_panel_slug.'/first_level_categories')}}" class="waves-effect"><i data-icon="P" class="ti-crown"></i> <span class="hide-menu">Category</span></a> </li>

                        @endif    

                        @if(($user->inRole('admin')) || ($user->inRole('sub_admin') && in_array('second_level_categories',$assigned_module_arr)))

                            <li class="<?php  if(Request::segment(2) == 'second_level_categories'){ echo 'active'; } ?>"> <a href="{{ url($admin_panel_slug.'/second_level_categories')}}" class="waves-effect"><i data-icon="P" class="ti-crown"></i> <span class="hide-menu">Sub Category</span></a> </li>

                        @endif     

                            <!--<li class="<?php  if(Request::segment(2) == 'third_level_categories'){ echo 'active'; } ?>"> <a href="{{ url($admin_panel_slug.'/third_level_categories')}}" class="waves-effect"><i data-icon="P" class="ti-crown"></i> <span class="hide-menu">Third Level Category</span></a> </li>-->


                        </ul>
                    </li>
                  
            @endif


                @if(($user->inRole('admin')) || ($user->inRole('sub_admin') && in_array('brands',$assigned_module_arr)))

                    <li class="<?php  if(Request::segment(2) == 'brands'){ echo 'active'; } ?>"> <a href="{{ url($admin_panel_slug.'/brands')}}"  class="waves-effect"><i data-icon="P" class="fa-fw ti-user"></i> <span class="hide-menu">Brands</span></a> </li>
                @endif    

                 @if(($user->inRole('admin')) || ($user->inRole('sub_admin') && in_array('cannabinoids',$assigned_module_arr)))

                    <li class="<?php  if(Request::segment(2) == 'cannabinoids'){ echo 'active'; } ?>"> <a href="{{ url($admin_panel_slug.'/cannabinoids')}}"  class="waves-effect"><i data-icon="P" class="fa-fw ti-more-alt"></i> <span class="hide-menu">Cannabinoids</span></a> </li>
                @endif    

                @if(($user->inRole('admin')) || ($user->inRole('sub_admin') && in_array('product',$assigned_module_arr)))

                    <li class="<?php  if(Request::segment(2) == 'product'){ echo 'active'; } ?>"> <a href="{{ url($admin_panel_slug.'/product')}}"  class="waves-effect"><span class="icn-left-side"><i data-icon="P" class="fa fa-cubes"></i></span> <span class="hide-menu">Manage Products</span></a> </li>

                @endif    


                @if(($user->inRole('admin')) || ($user->inRole('sub_admin') && in_array('reported_issues_products',$assigned_module_arr)))

                    <li class="<?php  if(Request::segment(2) == 'reported_issues_products'){ echo 'active'; } ?>"> <a href="{{ url($admin_panel_slug.'/reported_issues_products')}}"  class="waves-effect"><span class="icn-left-side"><i data-icon="P" class="fa fa-cubes"></i></span> <span class="hide-menu">Reported Issues</span></a> </li>

                @endif   


                @if(($user->inRole('admin')) || (($user->inRole('sub_admin') && in_array('buyers',$assigned_module_arr))||($user->inRole('sub_admin') && in_array('sellers',$assigned_module_arr))))

                    <li class=" user-pro <?php  if(Request::segment(2) == 'seller' || Request::segment(2) == 'seller_membership_history' || Request::segment(2) == 'buyer' ){ echo 'active'; } ?>"> 
                        <a href="#" class="waves-effect"><span class="icn-left-side"><i data-icon="P" class="icon-people"></i></span> <span class="hide-menu">Users<span class="fa arrow"></span></span></a> 

                        <ul class="nav nav-second-level">

                            @if(($user->inRole('admin')) || ($user->inRole('sub_admin') && in_array('buyers',$assigned_module_arr)))

                               <li class="<?php  if(Request::segment(2) == 'buyer'){ echo 'active'; } ?>"> <a href="{{ url($admin_panel_slug.'/buyers')}}" class="waves-effect"><i data-icon="P" class="icon-people"></i> <span class="hide-menu">Buyers</span></a> </li>
                            @endif   

                            @if(($user->inRole('admin')) || ($user->inRole('sub_admin') && in_array('sellers',$assigned_module_arr)))

                                <li class="<?php  if(Request::segment(2) == 'seller' || Request::segment(2) == 'seller_membership_history' ){ echo 'active'; } ?>"> <a href="{{ url($admin_panel_slug.'/sellers')}}" class="waves-effect"><i data-icon="P" class="icon-people"></i> <span class="hide-menu">Dispensaries</span></a> </li>
                            @endif    
                           
                            @if($user->inRole('admin'))

                               <li class="<?php  if(Request::segment(2) == 'sub_admin'){ echo 'active'; } ?>"> <a href="{{ url($admin_panel_slug.'/sub_admins')}}" class="waves-effect"><i data-icon="P" class="icon-people"></i> <span class="hide-menu">Sub Admin</span></a> </li>
                            @endif
                            
                        </ul>
                    </li>
               @endif



                @if($user->inRole('admin'))

                    <li class="<?php  if(Request::segment(2) == 'sub_admin_activity'){ echo 'active'; } ?>"> <a href="{{ url($admin_panel_slug.'/sub_admin_activity')}}" class="waves-effect"><span class="icn-left-side"><i data-icon="P" class="ti-layers-alt"></i></span> <span class="hide-menu">Sub Admin Activity Log</span></a> </li>

                @endif



                @if(($user->inRole('admin')) || ($user->inRole('sub_admin') && in_array('drop_shipper',$assigned_module_arr)))

                    <li class="<?php  if(Request::segment(2) == 'drop_shipper'){ echo 'active'; } ?>"> <a href="{{ url($admin_panel_slug.'/drop_shipper')}}"  class="waves-effect"><span class="icn-left-side"><i data-icon="P" class="fa-fw ti-user"></i></span> <span class="hide-menu">Dropshippers</span></a> </li>
                @endif    
                    
                @if(($user->inRole('admin')) || ($user->inRole('sub_admin') && in_array('order',$assigned_module_arr)))

                    <li class="<?php  if(Request::segment(2) == 'order'){ echo 'active'; } ?>"> <a href="{{ url($admin_panel_slug.'/order')}}"  class="waves-effect"><span class="icn-left-side"><i data-icon="P" class="fa fa-files-o"></i></span> <span class="hide-menu">Manage Orders</span></a> </li>
                @endif    
                    
                @if(($user->inRole('admin')) || ($user->inRole('sub_admin') && in_array('transaction',$assigned_module_arr)))
                    
                    <li class="<?php  if(Request::segment(2) == 'transaction'){ echo 'active'; } ?>"> <a href="{{ url($admin_panel_slug.'/transaction')}}"  class="waves-effect"><span class="icn-left-side"><i data-icon="P" class="ti-exchange-vertical"></i> </span><span class="hide-menu">Manage Transactions</span></a> </li>
                @endif    

                @if(($user->inRole('admin')) || ($user->inRole('sub_admin') && in_array('manage_product_visibility',$assigned_module_arr)))

                    <li class="<?php  if(Request::segment(2) == 'manage_product_visibility'){ echo 'active'; } ?>"> <a href="{{ url($admin_panel_slug.'/manage_product_visibility')}}"  class="waves-effect"><span class="icn-left-side"><i data-icon="P" class="fa fa-eye"></i></span> <span class="hide-menu">Manage Product Visibility</span></a> </li>
                @endif    

               @if(($user->inRole('admin')) || ($user->inRole('sub_admin') && in_array('helpcenter',$assigned_module_arr)))
                    <li class="<?php  if(Request::segment(2) == 'helpcenter'){ echo 'active'; } ?>"> <a href="{{ url($admin_panel_slug.'/helpcenter')}}"  class="waves-effect"><span class="icn-left-side"><i data-icon="P" class="fa fa-question-circle"></i></span> <span class="hide-menu">Manage Help Center</span></a> </li>
                @endif  


                @if(($user->inRole('admin')) || ($user->inRole('sub_admin') && in_array('help_center_category',$assigned_module_arr)))
                    <li class="<?php  if(Request::segment(2) == 'help_center_category'){ echo 'active'; } ?>"> <a href="{{ url($admin_panel_slug.'/help_center_category')}}"  class="waves-effect"><span class="icn-left-side"><i data-icon="P" class="fa fa-question-circle"></i></span> <span class="hide-menu">Help Center Category</span></a> </li>
                @endif  



                @if(($user->inRole('admin')) || ($user->inRole('sub_admin') && in_array('report_product',$assigned_module_arr)))

                     <li class="<?php  if(Request::segment(2) == 'report_product'){ echo 'active'; } ?>"> <a href="{{ url($admin_panel_slug.'/report_product')}}"  class="waves-effect"><span class="icn-left-side"><i data-icon="P" class="fa fa-glass"></i></span> <span class="hide-menu">Manage Abuse Reports</span></a> </li>
                @endif     

                @if(($user->inRole('admin')) || ($user->inRole('sub_admin') && in_array('seller_questions',$assigned_module_arr)))

                    <li class="<?php  if(Request::segment(2) == 'seller_questions'){ echo 'active'; } ?>"> <a href="{{ url($admin_panel_slug.'/seller_questions')}}" class="waves-effect"><span class="icn-left-side"><i data-icon="P" class="ti-help"></i></span> <span class="hide-menu"> Dispensary Questions</span></a> </li>  
                @endif    

                 @if(($user->inRole('admin')) || ($user->inRole('sub_admin') && in_array('slider_images',$assigned_module_arr)))

                    <li class="<?php  if(Request::segment(2) == 'slider_images'){ echo 'active'; } ?>"> <a href="{{ url($admin_panel_slug.'/slider_images')}}" class="waves-effect"><span class="icn-left-side"><i data-icon="P" class="ti-image"></i></span> <span class="hide-menu"> Slider Images</span></a> </li>   
                @endif

                @if(($user->inRole('admin')) || ($user->inRole('sub_admin') && in_array('withdraw-request',$assigned_module_arr)))

                    <li class="<?php  if(Request::segment(2) == 'withdraw-request'){ echo 'active'; } ?>"> <a href="{{ url($admin_panel_slug.'/withdraw-request')}}"  class="waves-effect"><i data-icon="P" class="fa-fw ti-user"></i> <span class="hide-menu">Withdraw Request</span></a> </li>
                @endif    

                @if(($user->inRole('admin')) || ($user->inRole('sub_admin') && in_array('notification',$assigned_module_arr)))

                    <li class="<?php  if(Request::segment(2) == 'notification'){ echo 'active'; } ?>"> <a href="{{ url($admin_panel_slug.'/notification')}}"  class="waves-effect"><i data-icon="P" class="fa-fw ti-email"></i> <span class="hide-menu">Notifications</span></a> </li>
                @endif    

                @if(($user->inRole('admin')) || ($user->inRole('sub_admin') && in_array('chowwatch',$assigned_module_arr)))

                    <li class="<?php  if(Request::segment(2) == 'chowwatch'){ echo 'active'; } ?>"> <a href="{{ url($admin_panel_slug.'/chowwatch')}}"  class="waves-effect"><i data-icon="P" class="fa-fw ti-layout-accordion-list"></i> <span class="hide-menu">Chow Watch</span></a> </li>
                @endif    

                @if(($user->inRole('admin')) || ($user->inRole('sub_admin') && in_array('email_template',$assigned_module_arr)))

                    <li class="<?php  if(Request::segment(2) == 'email_template'){ echo 'active'; } ?>"> <a href="{{ url($admin_panel_slug.'/email_template')}}" class="waves-effect"><span class="icn-left-side"><i data-icon="P" class="fa-fw ti-email"></i></span> <span class="hide-menu">Email Templates</span></a> </li> 

                @endif    


                @if(($user->inRole('admin')) || ($user->inRole('sub_admin') && in_array('report_post',$assigned_module_arr)))

                    <li class="<?php  if(Request::segment(2) == 'report_post'){ echo 'active'; } ?>"> <a href="{{ url($admin_panel_slug.'/report_post')}}"  class="waves-effect"><span class="icn-left-side"><i data-icon="P" class="fa fa-commenting-o"></i></span> <span class="hide-menu">Manage Post Report</span></a> </li>
                @endif    


                 @if(($user->inRole('admin')) || ($user->inRole('sub_admin') && in_array('tags',$assigned_module_arr)))

                    <li class="<?php  if(Request::segment(2) == 'tags'){ echo 'active'; } ?>"> <a href="{{ url($admin_panel_slug.'/tags')}}"  class="waves-effect"><span class="icn-left-side"><i data-icon="P" class="fa fa-tags"></i></span> <span class="hide-menu">Manage Tags</span></a> </li>
                @endif    



             
                @if(($user->inRole('admin')) || (($user->inRole('sub_admin') && in_array('newsletter_template',$assigned_module_arr)) ||  ($user->inRole('sub_admin') && in_array('newsletter_emails',$assigned_module_arr)) || ($user->inRole('sub_admin') && in_array('send_newsletter',$assigned_module_arr) )))  

                    <li class=" user-pro"> 
                        <a href="#" class="waves-effect"><span class="icn-left-side"><i data-icon="P" class="fa-fw ti-email"></i></span> <span class="hide-menu">Newsletters<span class="fa arrow"></span></span></a> 

                        <ul class="nav nav-second-level">

                        @if(($user->inRole('admin')) || ($user->inRole('sub_admin') && in_array('newsletter_template',$assigned_module_arr)))     

                          <li class="<?php  if(Request::segment(2) == 'newsletter_template'){ echo 'active'; } ?>"> <a href="{{ url($admin_panel_slug.'/newsletter_template')}}" class="waves-effect"><span class="icn-left-side"><i data-icon="P" class="ti-exchange-vertical"></i></span> <span class="hide-menu">Templates</span></a> </li> 
                        @endif   

                         @if(($user->inRole('admin')) || ($user->inRole('sub_admin') && in_array('newsletter_emails',$assigned_module_arr)))

                            <li class="<?php  if(Request::segment(2) == 'newsletter_emails'){ echo 'active'; } ?>"> <a href="{{ url($admin_panel_slug.'/newsletter_emails')}}" class="waves-effect"><span class="icn-left-side"><i data-icon="P" class="fa fa-empire"></i></span> <span class="hide-menu">Email</span></a> </li>

                        @endif    

                        @if(($user->inRole('admin')) || ($user->inRole('sub_admin') && in_array('send_newsletter',$assigned_module_arr)))

                            <li class="<?php  if(Request::segment(2) == 'send_newsletter'){ echo 'active'; } ?>"> <a href="{{ url($admin_panel_slug.'/send_newsletter')}}" class="waves-effect"><span class="icn-left-side"><i data-icon="P" class="fa-fw ti-email"></i></span> <span class="hide-menu">Send Newsletter</span></a> </li>
                        @endif    

                            
                        </ul>
                    </li>

                @endif
                    

                @if(($user->inRole('admin')) || ($user->inRole('sub_admin') && in_array('banner_images',$assigned_module_arr)))

                        <li class="<?php  if(Request::segment(2) == 'banner_images'){ echo 'active'; } ?>"> <a href="{{ url($admin_panel_slug.'/banner_images')}}"  class="waves-effect"><span class="icn-left-side"><i data-icon="P" class="ti-image"></i></span> <span class="hide-menu">Banner Images</span></a> </li>
                @endif     

                @if(($user->inRole('admin')) || ($user->inRole('sub_admin') && in_array('shop_by_reviews',$assigned_module_arr)))

                        <li class="<?php  if(Request::segment(2) == 'shop_by_reviews'){ echo 'active'; } ?>"> <a href="{{ url($admin_panel_slug.'/shop_by_reviews')}}"  class="waves-effect"><span class="icn-left-side"><i data-icon="P" class="ti-image"></i></span> <span class="hide-menu">Shop By Reviews</span></a> </li>
                @endif  

                @if(($user->inRole('admin')) || ($user->inRole('sub_admin') && in_array('shop_by_spectrum',$assigned_module_arr)))

                        <li class="<?php  if(Request::segment(2) == 'shop_by_spectrum'){ echo 'active'; } ?>"> <a href="{{ url($admin_panel_slug.'/shop_by_spectrum')}}"  class="waves-effect"><span class="icn-left-side"><i data-icon="P" class="ti-image"></i></span> <span class="hide-menu">Shop By Spectrum</span></a> </li>
                @endif       



                @if(($user->inRole('admin')) || ($user->inRole('sub_admin') && in_array('event_list',$assigned_module_arr)))

                        <li class="<?php  if(Request::segment(2) == 'event_list'){ echo 'active'; } ?>"> <a href="{{ url($admin_panel_slug.'/event_list')}}"  class="waves-effect"><span class="icn-left-side"><i data-icon="P" class="fa fa-leaf"></i></span> <span class="hide-menu">Manage Events</span></a> </li>
                @endif        

                @if(($user->inRole('admin')) || ($user->inRole('sub_admin') && in_array('hear_about',$assigned_module_arr)))

                        <li class="<?php  if(Request::segment(2) == 'hear_about'){ echo 'active'; } ?>"> <a href="{{ url($admin_panel_slug.'/hear_about')}}"  class="waves-effect"><span class="icn-left-side"><i data-icon="P" class="fa fa-volume-up"></i></span> <span class="hide-menu">Manage Hear About Us</span></a> </li>
                @endif        

                @if(($user->inRole('admin')) || ($user->inRole('sub_admin') && in_array('cancel_membership',$assigned_module_arr)))

                        <li class="<?php  if(Request::segment(2) == 'cancel_membership'){ echo 'active'; } ?>"> <a href="{{ url($admin_panel_slug.'/cancel_membership')}}"  class="waves-effect"><span class="icn-left-side"><i data-icon="P" class="fa fa-credit-card-alt"></i></span> <span class="hide-menu">Manage Cancelled Subscriptions</span></a> </li>
                @endif        



                    <!--<li class="<?php  if(Request::segment(2) == 'site_settings'){ echo 'active'; } ?>"> <a href="{{ url('/')}}/admin/trades" class="waves-effect"><span class="icn-left-side"><i data-icon="P" class="fa fa-shopping-cart fa-fw"></i></span> <span class="hide-menu">Trades</span></a> </li>-->

                    <!-- <li class="user-pro">
                        <a href="#" class="waves-effect"><span class="icn-left-side"><i data-icon="P" class="ti-crown"></i></span><span class="hide-menu">Trades<span class="fa arrow"></span></span></a>
                    
                        <ul class="nav nav-second-level">
                             <li class="<?php  if(Request::segment(2) == 'trades'){ echo 'active'; } ?>"> <a href="{{ url(config('app.project.admin_panel_slug').'/trades') }}" class="waves-effect"><span class="icn-left-side"><i data-icon="P" class="fa fa-shopping-cart fa-fw"></i></span> <span class="hide-menu">Market Trades</span></a> </li>

                             <li class="<?php  if(Request::segment(2) == 'CashMarkets'){ echo 'active'; } ?>"> <a href="{{ url(config('app.project.admin_panel_slug').'/CashMarkets') }}" class="waves-effect"><span class="icn-left-side"> <i data-icon="P" class=" ti-dashboard"></i></span> <span class="hide-menu">Cash Trades</span></a> </li>

                        </ul>
                    </li> -->

                    <!-- <li class="user-pro">
                        <a href="#" class="waves-effect"><span class="icn-left-side"><i data-icon="P" class="ti-crown"></i></span><span class="hide-menu">Dispute Trades<span class="fa arrow"></span></span></a>
                    
                        <ul class="nav nav-second-level">
                            <li class="<?php  if(Request::segment(3) == 'commodity' && Request::segment(2) == 'dispute-trades'){ echo 'active'; } ?>"> <a href="{{ url(config('app.project.admin_panel_slug').'/dispute-trades/commodity') }}" class="waves-effect"><span class="icn-left-side"> <i data-icon="P" class=" ti-dashboard"></i></span> <span class="hide-menu">Market Dispute Trades</span></a> </li>

                            <li class="<?php  if(Request::segment(3) == 'cash' && Request::segment(2) == 'dispute-trades'){ echo 'active'; } ?>"> <a href="{{ url(config('app.project.admin_panel_slug').'/dispute-trades/cash') }}" class="waves-effect"><span class="icn-left-side"><i data-icon="P" class="fa fa-shopping-cart fa-fw"></i></span> <span class="hide-menu">Cash Dispute Trades</span></a> </li>
                        </ul>
                    </li> -->

                    <!-- <li class="user-pro">
                        <a href="#" class="waves-effect"><span class="icn-left-side"><i data-icon="P" class="ti-crown"></i></span><span class="hide-menu">Offers<span class="fa arrow"></span></span></a>
                    
                        <ul class="nav nav-second-level">
                            <li class="<?php  if(Request::segment(3) == 'commodity' && Request::segment(2) == 'offers'){ echo 'active'; } ?>"> <a href="{{ url(config('app.project.admin_panel_slug').'/offers/commodity') }}" class="waves-effect"><span class="icn-left-side"> <i data-icon="P" class=" ti-dashboard"></i></span> <span class="hide-menu">Commodity Offers</span></a> </li>

                            <li class="<?php  if(Request::segment(3) == 'cash' && Request::segment(2) == 'offers'){ echo 'active'; } ?>"> <a href="{{ url(config('app.project.admin_panel_slug').'/offers/cash') }}" class="waves-effect"><span class="icn-left-side"><i data-icon="P" class="fa fa-shopping-cart fa-fw"></i></span> <span class="hide-menu">Cash Offers</span></a> </li>
                        </ul>
                    </li> -->


                    <!--<li class="<?php  if(Request::segment(2) == 'admin_users'){ echo 'active'; } ?>"> <a href="{{ url($admin_panel_slug.'/admin_users')}}" class="waves-effect"><i data-icon="P" class="ti-user"></i> <span class="hide-menu"> Admin Users</span></a> </li>-->

                  
                @if(($user->inRole('admin')) || ($user->inRole('sub_admin') && in_array('static_pages',$assigned_module_arr)))

                    <li class="<?php  if(Request::segment(2) == 'static_pages'){ echo 'active'; } ?>"> <a href="{{ url($admin_panel_slug.'/static_pages')}}" class="waves-effect"><span class="icn-left-side"><i data-icon="P" class="ti-layers-alt"></i></span> <span class="hide-menu">CMS</span></a> </li>
                @endif

                 @if(($user->inRole('admin')) || ($user->inRole('sub_admin') && in_array('highlights',$assigned_module_arr)))

                   <!--  <li class="<?php  if(Request::segment(2) == 'highlights'){ echo 'active'; } ?>"> <a href="{{ url($admin_panel_slug.'/highlights')}}" class="waves-effect"><span class="icn-left-side"><i data-icon="P" class="ti-image"></i></span> <span class="hide-menu">Highlights</span></a> </li>    -->
              
                @endif 


                @if(($user->inRole('admin')) || ($user->inRole('sub_admin') && (in_array('highlights',$assigned_module_arr) || in_array('highlights_header',$assigned_module_arr) || in_array('highlights_sub_header',$assigned_module_arr))))

                    <li class="user-pro">
                        <a href="#" class="waves-effect"><span class="icn-left-side"><i data-icon="P" class="ti-image"></i></span><span class="hide-menu">Highlights<span class="fa arrow"></span></span></a>
                    
                        <ul class="nav nav-second-level">


                            @if(($user->inRole('admin')) || ($user->inRole('sub_admin') && in_array('highlights',$assigned_module_arr)))
                            
                            <li class="<?php  if(Request::segment(2) == 'highlights'){ echo 'active'; } ?>"> <a href="{{ url($admin_panel_slug.'/highlights')}}" class="waves-effect"><i data-icon="P" class="ti-image"></i> <span class="hide-menu">Highlights</span></a> </li>

                        @endif 

                        @if(($user->inRole('admin')) || ($user->inRole('sub_admin') && in_array('highlights_header',$assigned_module_arr)))
                            
                            <li class="<?php  if(Request::segment(2) == 'update_header'){ echo 'active'; } ?>"> <a href="{{ url($admin_panel_slug.'/update_header')}}" class="waves-effect"><i data-icon="P" class="ti-image"></i> <span class="hide-menu">Header</span></a> </li>

                        @endif    

                        @if(($user->inRole('admin')) || ($user->inRole('sub_admin') && in_array('highlights_sub_header',$assigned_module_arr)))

                            <li class="<?php  if(Request::segment(2) == 'update_sub_header'){ echo 'active'; } ?>"> <a href="{{ url($admin_panel_slug.'/update_sub_header')}}" class="waves-effect"><i data-icon="P" class="ti-image"></i> <span class="hide-menu">Sub Header</span></a> </li>

                        @endif     

                         


                        </ul>
                    </li>
                  
            @endif

                @if(($user->inRole('admin')) || ($user->inRole('sub_admin') && in_array('announcements',$assigned_module_arr)))

                        <li class="<?php  if(Request::segment(2) == 'announcements'){ echo 'active'; } ?>"> <a href="{{ url($admin_panel_slug.'/announcements')}}"  class="waves-effect"><span class="icn-left-side"><i data-icon="P" class="ti-announcement"></i></span> <span class="hide-menu">Announcements</span></a> </li>
                @endif

                <!--    @if(($user->inRole('admin')) || ($user->inRole('sub_admin') && in_array('suggestion_category',$assigned_module_arr)))

                        <li class="<?php  if(Request::segment(2) == 'suggestion_category'){ echo 'active'; } ?>"> <a href="{{ url($admin_panel_slug.'/suggestion_category')}}"  class="waves-effect"><span class="icn-left-side"><i data-icon="P" class="ti-search"></i></span> <span class="hide-menu">Suggestion Category</span></a> </li>
                @endif  -->

                @if(($user->inRole('admin')) || ($user->inRole('sub_admin') && in_array('user_search',$assigned_module_arr)))

                        <li class="<?php  if(Request::segment(2) == 'user_search'){ echo 'active'; } ?>"> <a href="{{ url($admin_panel_slug.'/user_search')}}"  class="waves-effect"><span class="icn-left-side"><i data-icon="P" class="ti-search"></i></span> <span class="hide-menu">User Search</span></a> </li>
                @endif    

             

                @if(($user->inRole('admin')) || ($user->inRole('sub_admin') && in_array('health_claims',$assigned_module_arr)))

                        <li class="<?php  if(Request::segment(2) == 'keywords'){ echo 'active'; } ?>"> <a href="{{ url($admin_panel_slug.'/health_claims')}}"  class="waves-effect"><span class="icn-left-side"><i data-icon="P" class="ti-key"></i></span> <span class="hide-menu">Health Claims</span></a> </li>
                @endif    
                @if(($user->inRole('admin')) || ($user->inRole('sub_admin') && in_array('investortracker',$assigned_module_arr)))

                        <li class="<?php  if(Request::segment(2) == 'investortracker'){ echo 'active'; } ?>"> <a href="{{ url($admin_panel_slug.'/investortracker')}}"  class="waves-effect"><span class="icn-left-side"><i data-icon="P" class="ti-announcement"></i></span> <span class="hide-menu">Investor Tracker</span></a> </li>
                @endif      

                 @if(($user->inRole('admin')) || ($user->inRole('sub_admin') && in_array('reportedeffect',$assigned_module_arr)))

                    <li class="<?php  if(Request::segment(2) == 'reportedeffect'){ echo 'active'; } ?>"> <a href="{{ url($admin_panel_slug.'/reportedeffect')}}"  class="waves-effect"><i data-icon="P" class="fa-fw ti-layout-grid4"></i> <span class="hide-menu">Reported Effects</span></a> </li>
                @endif   

                @if(($user->inRole('admin')) || ($user->inRole('sub_admin') && in_array('lab_result',$assigned_module_arr)))
                    <li class="<?php  if(Request::segment(2) == 'lab_result'){ echo 'active'; } ?>"> <a href="{{ url($admin_panel_slug.'/lab_result')}}"  class="waves-effect"><i data-icon="P" class="fa-fw ti-widget"></i> <span class="hide-menu">Lab Result</span></a> </li>
                @endif    


                    <!-- <li class="<?php  if(Request::segment(2) == 'faq'){ echo 'active'; } ?>"> <a href="{{ url($admin_panel_slug.'/faq')}}" class="waves-effect"><i data-icon="P" class="ti-help-alt"></i> <span class="hide-menu"> FAQ</span></a> </li> -->

                    <!-- <li class="<?php  if(Request::segment(2) == 'contact_enquiry'){ echo 'active'; } ?>"> <a href="{{ url($admin_panel_slug.'/contact_enquiry')}}" class="waves-effect"><span class="icn-left-side"><i data-icon="P" class="icon-phone"></i></span> <span class="hide-menu"> Contact Enquiries</span></a> </li> --> 

                    <!-- <li class="<?php  if(Request::segment(2) == 'customize_request_enquiry'){ echo 'active'; } ?>"> <a href="{{ url($admin_panel_slug.'/customize_request_enquiry')}}" class="waves-effect"><span class="icn-left-side"><i data-icon="P" class="icon-phone"></i></span> <span class="hide-menu"> Customize Request Enquiries</span></a> </li>  -->
                   
                   
                   
                   
                  

                    <!-- <li class="<?php  if(Request::segment(2) == 'general_settings'){ echo 'active'; } ?>"> <a href="{{ url($admin_panel_slug.'/general_settings')}}" class="waves-effect"><span class="icn-left-side"><i data-icon="P" class="ti-crown"></i></span> <span class="hide-menu">General Settings</span></a> </li> -->

                    

                    
                    <!-- <li class="<?php  if(Request::segment(2) == 'unit'){ echo 'active'; } ?>">  <a href="{{ url($admin_panel_slug.'/unit')}}"  class="waves-effect"><i data-icon="P" class="ti-crown"></i> <span class="hide-menu">Unit</span></a></li> -->

                    <!--  <li class="<?php  if(Request::segment(2) == 'transaction'){ echo 'active'; } ?>"> <a href="{{ url($admin_panel_slug.'/transaction')}}"  class="waves-effect"><i data-icon="P" class="ti-crown"></i> <span class="hide-menu">All Transactions</span></a> </li> -->

                    <!--  <li class="<?php  if(Request::segment(2) == 'blockchain_trans_detail'){ echo 'active'; } ?>"> <a href="{{ url($admin_panel_slug.'/blockchain_trans_detail')}}"  class="waves-effect"><i data-icon="P" class="ti-crown"></i> <span class="hide-menu">BlockChain Transaction Details</span></a> </li> -->

                    


                     <!--<li class="<?php  if(Request::segment(2) == 'testimonial'){ echo 'active'; } ?>"> <a href="{{ url($admin_panel_slug.'/testimonial')}}"  class="waves-effect"><i data-icon="P" class="fa-fw ti-user"></i> <span class="hide-menu">Testimonial</span></a> </li>-->

                     

                    
                     


                     <!-- <li class="<?php  if(Request::segment(2) == 'comment'){ echo 'active'; } ?>"> <a href="{{ url($admin_panel_slug.'/comment')}}"  class="waves-effect"><i data-icon="P" class="fa-fw ti-user"></i> <span class="hide-menu">Comments</span></a> </li> -->

                     
                     <!--<li class="user-pro">
                        <a href="#" class="waves-effect"><i data-icon="P" class="ti-location-pin"></i><span class="hide-menu">Locations<span class="fa arrow"></span></span></a>
                    
                        <ul class="nav nav-second-level">
                            <li><a href="{{ url('/').'/'.$admin_path.'/countries'}}"><i class="icon-flag"></i> Manage Country</a></li>
                            <li><a href="{{ url('/').'/'.$admin_path.'/states'}}"><i class=" ti-location-arrow"></i> Manage State/Regions</a></li>
                            <li><a href="{{ url('/').'/'.$admin_path.'/cities'}}"><i class=" ti-map-alt"></i> Manage Cities</a></li>
                        </ul>
                    </li> -->

                    <!--<li class="<?php  if(Request::segment(2) == 'faq'){ echo 'active'; } ?>"> <a href="{{ url('/').'/'.$admin_path.'/keyword_translation' }}" class="waves-effect"><i data-icon="P" class="icon-bubble"></i> <span class="hide-menu">Keyword Translation</span></a> </li>-->

                     </li>
                    
                </ul>
            </div>
        </div>
        <!-- Left navbar-header end -->

                <!-- .right-sidebar -->
                <div class="right-sidebar">
                    <div class="slimscrollright">
                        <div class="rpanel-title"> Service Panel <span><i class="ti-close right-side-toggle"></i></span> </div>
                        <div class="r-panel-body">
                            <ul>
                                <li><b>Layout Options</b></li>
                                <li>
                                    <div class="checkbox checkbox-info">
                                        <input id="checkbox1" type="checkbox" class="fxhdr">
                                        <label for="checkbox1"> Fix Header </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="checkbox checkbox-warning">
                                        <input id="checkbox2" type="checkbox" class="fxsdr">
                                        <label for="checkbox2"> Fix Sidebar </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="checkbox checkbox-success">
                                        <input id="checkbox4" type="checkbox" class="open-close">
                                        <label for="checkbox4"> Toggle Sidebar </label>
                                    </div>
                                </li>
                            </ul>
                            {{-- <ul id="themecolors" class="m-t-20">
                                <li><b>With Light sidebar</b></li>
                                <li><a href="javascript:void(0)" theme="default" class="default-theme">1</a></li>
                                <li><a href="javascript:void(0)" theme="green" class="green-theme">2</a></li>
                                <li><a href="javascript:void(0)" theme="gray" class="yellow-theme">3</a></li>
                                <li><a href="javascript:void(0)" theme="blue" class="blue-theme working">4</a></li>
                                <li><a href="javascript:void(0)" theme="purple" class="purple-theme">5</a></li>
                                <li><a href="javascript:void(0)" theme="megna" class="megna-theme">6</a></li>
                                <li><b>With Dark sidebar</b></li>
                                <br/>
                                <li><a href="javascript:void(0)" theme="default-dark" class="default-dark-theme">7</a></li>
                                <li><a href="javascript:void(0)" theme="green-dark" class="green-dark-theme">8</a></li>
                                <li><a href="javascript:void(0)" theme="gray-dark" class="yellow-dark-theme">9</a></li>
                                <li><a href="javascript:void(0)" theme="blue-dark" class="blue-dark-theme">10</a></li>
                                <li><a href="javascript:void(0)" theme="purple-dark" class="purple-dark-theme">11</a></li>
                                <li><a href="javascript:void(0)" theme="megna-dark" class="megna-dark-theme">12</a></li>
                            </ul> --}}
                           
                        </div>
                    </div>
                </div>
                <!-- /.right-sidebar -->
