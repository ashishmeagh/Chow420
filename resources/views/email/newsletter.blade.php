<!DOCTYPE html>
<html lang="en-US">
  <head>
    <meta charset="utf-8" />
  </head>
  <body>
    @php
    $fullname =''; $userarr=[];$content='';
     if(isset($newsletter_message) && !empty($newsletter_message))
     {

         $content = $newsletter_message['message'];
         $userarr = $newsletter_message['userarr'];
          $fullname ='';	

     	if(isset($userarr['first_name']) && !empty($userarr['first_name']) && isset($userarr['last_name']) && !empty($userarr['last_name']))
     	{
     		$fullname = $userarr['first_name'].' '.$userarr['last_name'];
     		$content  = str_replace("##USER_NAME##",$fullname,$content);
     		echo  $content;
     	}
     	else
     	{
     		
     		$content  = str_replace("##USER_NAME##",'',$content);
     		$content  = str_replace("Hello ,",'',$content);
     		echo  $content;
     	}
        
      

     }
   

   //  echo $newsletter_message 
    @endphp
  </body>
</html>