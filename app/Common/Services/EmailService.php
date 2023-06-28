<?php

namespace App\Common\Services;

use App\Models\EmailTemplateModel;

use \Session;
use \Mail;

class EmailService
{
	public function __construct(EmailTemplateModel $email)
	{
		$this->EmailTemplateModel = $email;
		$this->BaseModel          = $this->EmailTemplateModel;
	}

	public function send_mail($arr_mail_data = FALSE)
	{
		
		if(isset($arr_mail_data) && sizeof($arr_mail_data)>0)
		{			
			$arr_email_template = [];
			$obj_email_template = $this->EmailTemplateModel->where('id',$arr_mail_data['email_template_id'])->first();
			
			if($obj_email_template)
	      	{
	        	$arr_email_template = $obj_email_template->toArray();

				

	        	$user   = $arr_mail_data['user'];

	        	$content = $arr_email_template['template_html'];

	        	if(isset($arr_mail_data['arr_built_content']) && sizeof($arr_mail_data['arr_built_content'])>0)
	        	{
	        		foreach($arr_mail_data['arr_built_content'] as $key => $data)
	        		{
	        			$content = str_replace("##".$key."##",$data,$content);
	        		}
				}	

	        	$content = view('email.front_general',compact('content'))->render();
	        	$content = html_entity_decode($content);
				

	        	$send_mail = Mail::send(array(),array(), function($message) use($user,$arr_email_template,$content)
		        {
		          $message->from($arr_email_template['template_from_mail'], $arr_email_template['template_from']);
		          $message->to($user['email'], $user['first_name'])
				          ->subject($arr_email_template['template_subject'])
						  ->setBody($content, 'text/html');					  
		        });
	    		

		        return $send_mail;
	        }
	        return FALSE;	
	    }
	    return FALSE;    
	}

	public function send_notification_mail($arr_mail_data = FALSE)
	{

		if(isset($arr_mail_data) && sizeof($arr_mail_data)>0)
		{	
 
			$arr_email_template = [];
			$obj_email_template = $this->EmailTemplateModel->where('id',$arr_mail_data['email_template_id'])->first();
			
			if($obj_email_template)
	      	{
	        	$arr_email_template = $obj_email_template->toArray();
	        	$user               = $arr_mail_data['user'];

	        	$content = $arr_email_template['template_html'];

	        	if(isset($arr_mail_data['arr_built_content']) && sizeof($arr_mail_data['arr_built_content'])>0)
	        	{
	        		foreach($arr_mail_data['arr_built_content'] as $key => $data)
	        		{
	        			$content = str_replace("##".$key."##",$data,$content);
	        		}
	        	}

	        	$content = view('email.front_general',compact('content'))->render();
	        	$content = html_entity_decode($content);



	        	$send_mail = Mail::send(array(),array(), function($message) use($user,$arr_email_template,$content,$arr_mail_data)
		        {
		        	$arr_email_template['template_subject'] = str_replace("##SUBJECT##",$arr_mail_data['arr_built_subject'],$arr_email_template['template_subject']);

		          	
		          	$message->from($arr_email_template['template_from_mail'], $arr_email_template['template_from']);
		          	$message->to($user['email'], $user['first_name'])
				          ->subject($arr_email_template['template_subject'])
				          ->setBody($content, 'text/html');
		        });
	    
		        return $send_mail;
	        }
	        return FALSE;	
	    }
	    return FALSE;    
	}


	public function send_refer_mail($arr_mail_data = FALSE)
	{
		if(isset($arr_mail_data) && sizeof($arr_mail_data)>0)
		{	

			$arr_email_template = [];
			$obj_email_template = $this->EmailTemplateModel->where('id',$arr_mail_data['email_template_id'])->first();
			
			if($obj_email_template)
	      	{
	        	$arr_email_template = $obj_email_template->toArray();
	        	$user               = $arr_mail_data['user'];

	        	$content = $arr_email_template['template_html'];

	        	if(isset($arr_mail_data['arr_built_content']) && sizeof($arr_mail_data['arr_built_content'])>0)
	        	{
	        		foreach($arr_mail_data['arr_built_content'] as $key => $data)
	        		{
	        			$content = str_replace("##".$key."##",$data,$content);
	        		}
	        	}

	        	$content = view('email.front_general',compact('content'))->render();
	        	$content = html_entity_decode($content);

	        	$send_mail = Mail::send(array(),array(), function($message) use($user,$arr_email_template,$content,$arr_mail_data)
		        {
		        	$arr_email_template['template_subject'] = str_replace("##SUBJECT##",$arr_mail_data['arr_built_subject'],$arr_email_template['template_subject']);
		          	
		          	$message->from($arr_email_template['template_from_mail'], $arr_email_template['template_from']);
		          	$message->to($user, $user)
				          ->subject($arr_email_template['template_subject'])
				          ->setBody($content, 'text/html');
		        });
	    
		        return $send_mail;
	        }
	        return FALSE;	
	    }
	    return FALSE;    
	}//end function



	/*public function send_mail_section($arr_mail_data = FALSE)
	{

		if(isset($arr_mail_data) && sizeof($arr_mail_data)>0)
		{	
 
			$arr_email_template = [];
			$obj_email_template = $this->EmailTemplateModel->where('id',$arr_mail_data['email_template_id'])->first();
			
			if($obj_email_template)
	      	{
	        	$arr_email_template = $obj_email_template->toArray();
	        	$user               = $arr_mail_data['user'];

	        	//$content = $arr_mail_data['arr_built_content'];
	        	$content = $arr_email_template['template_html'];

	        	if(isset($arr_mail_data['arr_built_content']) && sizeof($arr_mail_data['arr_built_content'])>0)
	        	{
	        		foreach($arr_mail_data['arr_built_content'] as $key => $data)
	        		{
	        			$content = str_replace("##".$key."##",$data,$content);
	        		}
	        	}

	        	$content = view('email.front_general',compact('content'))->render();
	        	$content = html_entity_decode($content);



	        	$send_mail = Mail::send(array(),array(), function($message) use($user,$arr_email_template,$content,$arr_mail_data)
		        {
			        if(isset($arr_mail_data['arr_built_subject']) && sizeof($arr_mail_data['arr_built_subject'])>0)
		        	{
			        	$arr_email_template['template_subject'] = str_replace("##SUBJECT##",$arr_mail_data['arr_built_subject'],$arr_email_template['template_subject']);
	                }
		          	
		          	$message->from($arr_email_template['template_from_mail'], $arr_email_template['template_from']);
		          	$message->to($user['email'], $user['first_name'])
				          ->subject($arr_email_template['template_subject'])
				          ->setBody($content, 'text/html');
		        });
	    
		        return $send_mail;
	        }
	        return FALSE;	
	    }
	    return FALSE;    
	}//end function*/

	
	public function send_mail_section($arr_mail_data = FALSE)
	{

		if(isset($arr_mail_data) && sizeof($arr_mail_data)>0)
		{	
 
			$arr_email_template = [];
			$obj_email_template = $this->EmailTemplateModel->where('id',$arr_mail_data['email_template_id'])->first();
			
			if($obj_email_template)
	      	{
	        	$arr_email_template = $obj_email_template->toArray();
	        	$user               = $arr_mail_data['user'];

	        	//$content = $arr_mail_data['arr_built_content'];
	        	$content = $arr_email_template['template_html'];

	        	if(isset($arr_mail_data['arr_built_content']) && sizeof($arr_mail_data['arr_built_content'])>0)
	        	{
	        		foreach($arr_mail_data['arr_built_content'] as $key => $data)
	        		{
	        			$content = str_replace("##".$key."##",$data,$content);
	        		}
	        	}

	        	$content = view('email.front_general',compact('content'))->render();
	        	$content = html_entity_decode($content);



	        	$send_mail = Mail::send(array(),array(), function($message) use($user,$arr_email_template,$content,$arr_mail_data)
		        {

		        	if(isset($arr_mail_data['template_subject']) && $arr_mail_data['template_subject']!='')
	        	   {

		        	$arr_email_template['template_subject'] = str_replace("##SUBJECT##",$arr_mail_data['arr_built_subject'],$arr_email_template['template_subject']);
		           }
		          	
		          	$message->from($arr_email_template['template_from_mail'], $arr_email_template['template_from']);
		          	$message->to($user['email'], $user['first_name'])
				          ->subject($arr_email_template['template_subject'])
				          ->setBody($content, 'text/html');
		        });
	    
		        return $send_mail;
	        }
	        return FALSE;	
	    }
	    return FALSE;    
	}//end function


	public function send_mail_section_order($arr_mail_data = FALSE)
	{
		if(isset($arr_mail_data) && sizeof($arr_mail_data)>0)
		{	
			$arr_email_template = [];
			$obj_email_template = $this->EmailTemplateModel->where('id',$arr_mail_data['email_template_id'])->first();
			
			if($obj_email_template)
	      	{
	        	$arr_email_template = $obj_email_template->toArray();
	        	$user               = $arr_mail_data['user'];
	        	$order_number = isset($arr_mail_data['order_number']) ? $arr_mail_data['order_number'] : '' ;
	        	

	        	//$content = $arr_mail_data['arr_built_content'];
	        	$content = $arr_email_template['template_html'];
	        	$subj = $arr_email_template['template_subject'] .' '. $order_number;
	
	        	if(isset($arr_mail_data['arr_built_content']) && sizeof($arr_mail_data['arr_built_content'])>0)
	        	{
	        		foreach($arr_mail_data['arr_built_content'] as $key => $data)
	        		{
	        			$content = str_replace("##".$key."##",$data,$content);
	        		}
	        	}
	        	$content = view('email.front_general',compact('content'))->render();
	        	$content = html_entity_decode($content);
	        	if(isset($arr_mail_data['arr_built_subject']) && sizeof($arr_mail_data['arr_built_subject'])>0)
	        	{
	        		foreach($arr_mail_data['arr_built_subject'] as $key => $data)
	        		{
	        			$subj = str_replace("##".$key."##",$data,$subj);
	        		}
	        	}
	        	$send_mail = Mail::send(array(),array(), function($message) use($user,$arr_email_template,$content,$arr_mail_data,$subj)
		        {
		        	// $arr_email_template['template_subject'] = str_replace("##SUBJECT##",$arr_mail_data['arr_built_subject'],$arr_email_template['template_subject']);
	          	
		          	$message->from($arr_email_template['template_from_mail'], $arr_email_template['template_from']);
		          	$message->to($user['email'], $user['first_name'])
				          ->subject($subj)
				          ->setBody($content, 'text/html');
		        });
	   
		        return $send_mail;
	        }
	        return FALSE;	
	    }
	    return FALSE;
	}//end function order



/*	public function send_mail_section_order($arr_mail_data = FALSE)
	{

		if(isset($arr_mail_data) && sizeof($arr_mail_data)>0)
		{	
 
			$arr_email_template = [];
			$obj_email_template = $this->EmailTemplateModel->where('id',$arr_mail_data['email_template_id'])->first();
			
			if($obj_email_template)
	      	{
	        	$arr_email_template = $obj_email_template->toArray();
	        	$user               = $arr_mail_data['user'];

	        	//$content = $arr_mail_data['arr_built_content'];
	        	$content = $arr_email_template['template_html'];
	        	$subj = $arr_email_template['template_subject'];
	

	        	if(isset($arr_mail_data['arr_built_content']) && sizeof($arr_mail_data['arr_built_content'])>0)
	        	{
	        		foreach($arr_mail_data['arr_built_content'] as $key => $data)
	        		{
	        			$content = str_replace("##".$key."##",$data,$content);
	        		}
	        	}

	        	$content = view('email.front_general',compact('content'))->render();
	        	$content = html_entity_decode($content);


	        	if(isset($arr_mail_data['arr_built_subject']) && sizeof($arr_mail_data['arr_built_subject'])>0)
	        	{
	        		foreach($arr_mail_data['arr_built_subject'] as $key => $data)
	        		{
	        			$subj = str_replace("##".$key."##",$data,$subj);
	        		}
	        	}



	        	$send_mail = Mail::send(array(),array(), function($message) use($user,$arr_email_template,$content,$arr_mail_data,$subj)
		        {
		        	// $arr_email_template['template_subject'] = str_replace("##SUBJECT##",$arr_mail_data['arr_built_subject'],$arr_email_template['template_subject']);
	          	
	          	
		          	$message->from($arr_email_template['template_from_mail'], $arr_email_template['template_from']);
		          	$message->to($user['email'], $user['first_name'])
				          ->subject($subj)
				          ->setBody($content, 'text/html');
		        });
	    
		        return $send_mail;
	        }
	        return FALSE;	
	    }
	    return FALSE;    
	}//end function order*/


}

?>