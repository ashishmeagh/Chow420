function confirm_action(ref,evt,msg,delete_param="")
{
  var msg = msg || false;
  
    evt.preventDefault();  
    swal({
          title: msg,
          type: "warning",
          showCancelButton: true,
          // confirmButtonColor: "#DD6B55",
          confirmButtonColor: "#873dc8",
          confirmButtonText: "Yes, do it!",
          closeOnConfirm: false
        },
        function(isConfirm,tmp)
        {
          if(isConfirm==true)
          {
            if(delete_param!="")
            {
               swal("Success!",delete_param+" deleted successfully","success");
            }
            else
            {
              swal("Success!","Action performed successfully","success");
            }

            window.location = $(ref).attr('href');
          }
        });
}    

/*---------- Multi_Action-----------------*/

  function check_multi_action(checked_record,frm_id,action)
  {
    var len = $('input[name="'+checked_record+'"]:checked').length;
    var flag=1;
    var frm_ref = $("#"+frm_id);
    
    if(len<=0)
    {
      swal("Opps..","Please select the record to perform this Action.");
      return false;
    }
    
    if(action=='delete')
    {
      var confirmation_msg = "Do you really want to delete selected records?";
    }
    else if(action == 'deactivate')
    {
      var confirmation_msg = "Do you really want to deactivate selected records?";
    }
    else if(action == 'activate')
    {
      var confirmation_msg = "Do you really want to activate selected records?";
    }
    
    swal({
          title: confirmation_msg,
          text: "",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#873dc8",
          confirmButtonText: "Yes",
          cancelButtonText: "No",
          closeOnConfirm: false,
          closeOnCancel: true
        },
        function(isConfirm)
        {
          if(isConfirm)
          {
            $('input[name="multi_action"]').val(action);
            $(frm_ref)[0].submit();
          }
          else
          {
           return false;
          }
        }); 

  }


  /* This function shows simple alert box for showing information */
  function showAlert(msg,type,confirm_btn_txt)
  {
      confirm_btn_txt = confirm_btn_txt || 'Ok';
      swal({
        title: "",
        text: msg,
        type: type,
        confirmButtonText: confirm_btn_txt
      });
      return false; 
  }



