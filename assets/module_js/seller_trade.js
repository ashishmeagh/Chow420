function get_second_level_category()
{
    var first_level_category_id  = $('#first_level_category_id').val();

    $.ajax({
            url:SITE_URL+'/seller/product/get_second_level_category',
            type:'GET',
            data:{
                    first_level_category_id:first_level_category_id,
                    _token:$("input[name=_token]").val()
                  },
            dataType:'JSON',
            beforeSend: function() {
              showProcessingOverlay();
            },
            success:function(response)
            { 
                hideProcessingOverlay();                   
                var html = '';
                html +='<option value="">Select Category</option>';
                 
                for(var i=0; i < response.second_level_category.length; i++)
                {
                  var obj_cat = response.second_level_category[i];
                  html+="<option value='"+obj_cat.id+"'>"+obj_cat.name+"</option>";
                }
                
                $("#second_level_category_id").html(html);
            }
    });
}



$('.decimal').keyup(function()
{
  var val = $(this).val();
  if(isNaN(val)){
       val = val.replace(/[^0-9\.]/g,'');
       if(val.split('.').length>2) 
           val =val.replace(/\.+$/,"");
  }
  $(this).val(val); 
})

/*Total Quantity should be greater than Minimum Quantity*/
$('#total_quantity').on('blur',function()
{
    var total_quantity = parseFloat($('#total_quantity').val());
    var minimum_quantity = parseFloat($('#minimum_quantity').val());

    if(total_quantity.length <= 0) return ;

    if(total_quantity <= minimum_quantity)
    {  
       $('#total_quantity').val(minimum_quantity); 
    }       
});

$('#btn_add').click(function()
{ 
    if($('#frm-product').parsley().validate()==false) return;

    $.ajax({
              
      url: SITE_URL+'/seller/product/save_product',
      data: new FormData($('#frm-product')[0]),
      contentType:false,
      processData:false,
      method:'POST',
      cache: false,
      dataType:'json',
      beforeSend: function() {
        showProcessingOverlay();
      },
      success:function(data)
      {
         hideProcessingOverlay();
         if('success' == data.status)
         {
            
            $('#frm-product')[0].reset();

              swal({
                     title: data.status,
                     text: data.description,
                     type: data.status,
                     confirmButtonText: "OK",
                     closeOnConfirm: false
                  },
                 function(isConfirm,tmp)
                 {
                   if(isConfirm==true)
                   {  
                      location.reload();
                      // window.location = data.link;
                   }
                 });
          }
          else
          {
             swal('warning',data.description,data.status);
          }  
      }
      
    });   


});