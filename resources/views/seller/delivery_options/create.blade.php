@extends('seller.layout.master')
@section('main_content')

<div class="my-profile-pgnm">
    {{$page_title}}
    <ul class="breadcrumbs-my">
        <li><a href="{{url('/')}}/seller/dashboard">Dashboard</a></li>
        <li><i class="fa fa-angle-right"></i></li>
        <li><a href="{{url('/')}}/seller/delivery_options">Delivery Options</a></li>
        <li><i class="fa fa-angle-right"></i></li>
        <li>{{$page_title}}</li>
    </ul>
</div>
<div class="new-wrapper">
    <div class="main-my-profile">
        <div class="innermain-my-profile add-product-inrs space-o">
            <form id="validation-form">
                {{ csrf_field() }}
                <div class="row">
                    <h4> <span id="showerr"></span> </h4>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Title <span>*</span></label>
                            <input type="text" name="title" id="title" class="input-text" placeholder="Enter title" data-parsley-required-message="Please enter title" data-parsley-required ='false' >
                            <div id="title_error" ></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="day"> Length of Delivery (day) <span>*</span></label>
                            <div class="select-style">
                                <select class="frm-select" name="day" id="day" data-parsley-required ='true' data-parsley-required-message="Please select day">
                                    <option value="" selected="" disabled="">Select day</option>
                                    @php
                                        for ($x = 1; $x <= 31; $x++) {
                                          echo "<option value='".$x."'>".$x."</option>";
                                        }
                                    @endphp
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="unit_cost">Amount ($)<span>*</span></label>
                            <input type="text" name="cost" id="cost" class="input-text" placeholder="Enter amount" data-parsley-required="true" data-parsley-required-message="Please enter cost" data-parsley-maxlength="10" data-parsley-min="1" data-parsley-type="number" min="0">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="button-list-dts">
                            <a href="javascript:void(0)" class="butn-def" id="btn_add">Add Delivery Options</a>
                            <a href="{{ url('/') }}/seller/delivery_options" class="butn-def cancelbtnss">Back</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">

    $(document).ready(function() {

        $('#btn_add').click(function() {

            var title = $('#title').val();

            console.clear();
            console.log(title);

            if (title == '') {
                $( "#title_error" ).html( '<small style="color: #e00000;" id="title_msg">Please enter title</small>' );
            }
            else {
                $( "#title_error" ).html( '' );
            }

            if($('#validation-form').parsley().validate()==false) return;

            var title = $('#title').val();

            if (title == '') {
                return false;
            }

            var title = "x" + $('#title').val().toLowerCase().replace(/\s+/g, '');

            function isNumeric(n) {
                return !isNaN(parseFloat(n)) && isFinite(n);
            }
            
            var doller = title.indexOf("$");
            var free = title.includes("free");
            
            if ((doller == 0 || doller == -1 || isNumeric(doller)) || free == true) {
            
                if (free != true) {
            
                    var next_of_doller = title.substr(doller + 1, 1);
            
                    if (!isNumeric(next_of_doller)) {
            
                        $( "#title_error" ).html( '<small style="color: #e00000;" id="title_msg">Include the dollar value in your title, or use the word "Free" for free options</small>' );
                        return false;
                    }
                }
            } else {
            
                $( "#title_error" ).html( '<small style="color: #e00000;" id="title_msg">Include the dollar value in your title, or use the word "Free" for free options</small>' );
                return false;
            }

            var doller_free = title.includes("$free");

            if (doller_free) {

                $( "#title_error" ).html( '<small style="color: #e00000;" id="title_msg">Include the dollar value in your title, or use the word "Free" for free options</small>' );
                return false;
            }

            formdata = new FormData($('#validation-form')[0]);
            
            var SITE_URL  = "{{ url('/')}}";

            var title   = $('#title').val();
            var day     = $('#day').val();
            var cost    = $('#cost').val();

            $.ajax({

                url: SITE_URL+'/seller/delivery_options/store',
                data: formdata,
                method:'POST',
                contentType: false,
                processData: false,
                beforeSend : function() {

                    showProcessingOverlay();        
                },
                success:function(data) {

                    hideProcessingOverlay(); 
                    if('success' == data.status) {
                  
                        $('#validation-form')[0].reset();

                        swal({

                            title:'Success',
                            text: data.description,
                            type: data.status,
                            confirmButtonText: "OK",
                            closeOnConfirm: false
                        },
                        function(isConfirm,tmp) {

                           if(isConfirm==true) {

                              window.location = data.link;
                           }
                         });
                    } 
                    else {

                        swal('Alert!',data.description,data.status);
                    }  
                }
            });   
        });
    });
</script>
@endsection