@extends('front.layout.master')
@section('main_content') 
<link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/common/data-tables/latest/dataTables.bootstrap.min.css">
<div class="space-inx-opn-bzr">
<div class="container">
  <div class="row">
   <div class="col-md-6">
    
   </div>
   <div class="col-md-6">
   <div class="sort-main">
      <div class="list-found-dropdown">
       
      </div>
      <div class="clearfix"></div>
   </div>
 </div>
 </div>
  @include('admin.layout._operation_status')
   <div class="recent-buy-listing-table">
      <div class="table-responsive">
         <table class="table table-lisitng" id="table_module">
            <thead>
               <tr>
                  <th>From User</th>
                  <th>Message</th>
                  <th>Action</th>
               </tr>
             
            </thead>
            <tbody>
              @if(isset($arr_notification) && count($arr_notification) > 0)
                @foreach($arr_notification as $notification)
                <tr>
                  <td>{{ isset($notification->user_name) ? $notification->user_name : 'NA' }}</td>
                  <td>{!! isset($notification->message)?$notification->message:'NA' !!}</td>
                  <td><a class="btn btn-outline btn-danger btn-circle show-tooltip" onclick="confirm_delete(this,event);" href="{{ $module_url_path}}/delete/{{ isset($notification->id) ? base64_encode($notification->id) : '0' }}" title="Delete"><i class="fa fa-trash" ></i></a></td>
                </tr>
                @endforeach
                @else
                 No Notification Available
                @endif
            </tbody>
         </table>
      </div>
              <span class="pull-right">{{$arr_notification->render()}}</span>
   </div>

</div>
</div>
<script type="text/javascript">
  
  function confirm_delete(ref,event)
  {
    confirm_action(ref,event,'Are you sure to delete this Notification?');
  }

  $('document').ready(function(){
    $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
  });
</script>

@endsection