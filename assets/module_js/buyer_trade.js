function get_trade_detail(ref)
{
   var trade_id = ref.attr('data-trade_id');

   $.ajax({
      url:SITE_URL+'/buyer/get_trade_detail',
      type:'GET',
      data:{trade_id:trade_id},
      dataType:'JSON',
      beforeSend: function() {
        showProcessingOverlay();
      },
      success:function(response)
      { 
        hideProcessingOverlay();  
         if(response.status == 'success')
         {

            $('#total_qty').val('');
            $('#total_price').val('');

            $('#min_qty').html(response.arr_trade.minimum_quantity+' '+response.arr_trade.unit);
            $('#max_qty').html(response.arr_trade.remaining_qty+' '+response.arr_trade.unit);
            
            // $('#max_qty').html(response.arr_trade.quantity+' '+response.arr_trade.unit);

            $('#minimum_quantity').val(response.arr_trade.minimum_quantity);
            $('#maximum_quantity').val(response.arr_trade.remaining_qty);
            
            // $('#maximum_quantity').val(response.arr_trade.quantity);

            $('#unit_price').val(response.arr_trade.unit_price);

            $('#trade_id').val(response.arr_trade.id);
         }
      }
   });
}


function calculate_price(ref)
{
   var qty         = parseFloat(ref.val().trim());
   var min_qty     = parseFloat($('#minimum_quantity').val().trim());
   var max_qty     = parseFloat($('#maximum_quantity').val().trim());
   var unit_price  = parseFloat($('#unit_price').val().trim());
   var total_price = 0;

   if(qty < min_qty)
   {  
      $('#total_qty').val(0);
      $('#total_price').val(0);
   }
   else if(qty > max_qty)
   {
      $('#total_qty').val(0);
      $('#total_price').val(0);
   }
   else
   {  
      total_price  = qty * unit_price;

      var approvalAmount = $('#approvalAmount').val();

      if($.trim(approvalAmount)<total_price){        

        var url = `<a onclick="toggleModale($(this));" data-model-id="#escroAuthorisation">click here </a>`;
        var warning_msg = `Your trade price ie.( `+total_price+`)
        is greater than your escrow apporval amount i.e `+approvalAmount+`,
        Please `+url+` to update escrow authorisation amount`;

        $('.escrow-amount-err').html(warning_msg);
        $('.escrow-amount-err').show();
        $('#total_price').val('');   
        
      }else{
        
        $('#total_price').val(total_price);        
        $('.escrow-amount-err').hide();
      }
   }
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


$('#btn_add').click(function()
{ 

    var wallet_balance ='';

    if($('#frm-trade').parsley().validate()==false) return;
   
    //assign metamsk address to hiiden field
    $('#metamask_wallet_address').val(globCoinbase);

    /*get active meta mask balance*/
    
  
    var promise = new Promise(function(resolve, reject){ 

      globUsdcoinsContractInstance.methods.balanceOf(globCoinbase).call().then(function(result)
      {
          wallet_balance = result / (10 ** globContractDecimal); 
     
          if(wallet_balance !='')
          {
             
            $('#metamask_balance').val(wallet_balance);
            
            resolve();
          }
          else{
             reject();
          }

      });

  }); 

promise. 
  then(function (){ 
   
    var FormData = $('#frm-trade').serialize();

    $.ajax({
              
      url: SITE_URL+'/buyer/store_trade',
      data: FormData,
      method:'POST',
      dataType:'json',
      beforeSend: function() {
        showProcessingOverlay();
      },
      success:function(data)
      {
         hideProcessingOverlay();
         if('success' == data.status)
         {
            $('#frm-trade')[0].reset();

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

  }). 
  catch(function () { 
    swal('warning','Something went wrong','warning');
  }); 


});

