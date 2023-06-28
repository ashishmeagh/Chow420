<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SellerModel;
use App\Models\SellerBannerImageModel;

use Sentinel;
use Validator;
use Image;

class BannerImageController extends Controller
{
    //
    public function __construct(
    							SellerModel $SellerModel,
    							SellerBannerImageModel $SellerBannerImageModel
    							)
    {
    	$this->SellerModel        		= $SellerModel;
        $this->SellerBannerImageModel   = $SellerBannerImageModel;
        
        $this->arr_view_data      		= [];

        $this->module_title       		= "Dispensary Image";
        $this->module_view_folder 		= "seller/seller-banner";
        $this->module_url_path    		= url('/')."/seller/dispensary-image";
        $this->banner_public_path 	= url('/').config('app.project.img_path.seller_banner');
        $this->banner_base_path   	= base_path().config('app.project.img_path.seller_banner');
    }


    // function for listing of Banner Image
    public function index()
    {
    	$banner_arr = [];
        $logginId = 0;
        $user = Sentinel::check();

        if ($user) {
            
            $logginId = $user->id;
        }

        $obj_banner_details = $this->SellerBannerImageModel->where('seller_id',$logginId)->first();

        // dd($obj_banner_details);
        if ($obj_banner_details) {

            $banner_arr = $obj_banner_details->toArray();
        }
           
  
        $this->arr_view_data['banner_public_path']    	= $this->banner_public_path;
        $this->arr_view_data['module_url_path']    		= $this->module_url_path ;
        $this->arr_view_data['banner_arr']         		= $banner_arr;
        $this->arr_view_data['logged_in_seller_id']   		= $logginId;
        $this->arr_view_data['page_title']              = 'Rectangular-Image';

        // dd($this->arr_view_data);

        return view($this->module_view_folder.'.manage',$this->arr_view_data); 
    }


    public function store(Request $request)
    {
    	$form_data = $request->all();    	
        $is_update_process = false;

        $seller_id = $request->input('seller_id',false);

        if($request->has('seller_id'))
        {
            $is_update_process = true; 
        }

        $arr_rules = [];
        if($is_update_process == false)
        {
        	$arr_rules = [
                         //   'banner_image' => 'required',
                         //   'image_medium'=> 'required',
                         //   'image_small'=>'required'

                         ];
        }


        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            // dd('fails');
            $response['status']      = 'warning';
            $response['description'] = 'Please select image';

            return response()->json($response);
        }

        if ($request->hasFile('banner_image')) 
        {
           //Validation for product image
           $file_extension = strtolower($request->file('banner_image')->getClientOriginalExtension());
           	if(!in_array($file_extension,['jpg','png','jpeg']))
           	{
                $response['status']       = 'ImageFAILURE';
                $response['description']  = 'Invalid image only jpg,png,jpeg extensions allowed.';
                return response()->json($response);
            }

        } 


       /*  if ($request->hasFile('image_medium')) 
        {
           $file_extension = strtolower($request->file('image_medium')->getClientOriginalExtension());
            if(!in_array($file_extension,['jpg','png','jpeg']))
            {
                $response['status']       = 'MediumImageFAILURE';
                $response['description']  = 'Invalid image only jpg,png,jpeg extensions allowed.';
                return response()->json($response);
            }

        } 

        if ($request->hasFile('image_small')) 
        {
           $file_extension = strtolower($request->file('image_small')->getClientOriginalExtension());
            if(!in_array($file_extension,['jpg','png','jpeg']))
            {
                $response['status']       = 'SmallImageFAILURE';
                $response['description']  = 'Invalid image only jpg,png,jpeg extensions allowed.';
                return response()->json($response);
            }

        } */




    	/* Main Model Entry */
        $banner_image = $this->SellerBannerImageModel->firstOrNew(['seller_id' => $seller_id]);

        $file_name = 'default.jpg';
        if($request->hasFile('banner_image'))
        {	

        	$file = $request->file('banner_image');
            $extension  = strtolower($file->getClientOriginalExtension());
            $size  = $file->getClientSize();
           
            $file_name   = uniqid(rand(11111,99999)).'.'.$extension;

            $image1      = Image::make($file);
           // $image1->resize(1920,715);

            $image1->save($this->banner_base_path.$file_name);
             $file_name = $file_name;

            if(isset($form_data['old_img']) && !empty($form_data['old_img']))
            {
            	$unlink_old_img_path    = $this->banner_base_path.'/'.$request->input('old_img');
                            
	            if(file_exists($unlink_old_img_path))
	            {
	                @unlink($unlink_old_img_path);  
	            }
            }            
        }else{            
          $file_name = $request->input('old_img');  
        } 
        
        /*********************medium size start*************************/

        /* $file_name_medium = 'default.jpg';
        if($request->hasFile('image_medium'))
        {   

            $file = $request->file('image_medium');
            $extension  = strtolower($file->getClientOriginalExtension());
            $size  = $file->getClientSize();
           
            $file_name_medium   = uniqid(rand(11111,99999)).'.'.$extension;

            $image1      = Image::make($file);

            $image1->save($this->banner_base_path.$file_name_medium);
            $file_name_medium = $file_name_medium;

            if(isset($form_data['old_img_medium']) && !empty($form_data['old_img_medium']))
            {
                $unlink_old_img_path_medium    = $this->banner_base_path.'/'.$request->input('old_img_medium');
                            
                if(file_exists($unlink_old_img_path_medium))
                {
                    @unlink($unlink_old_img_path_medium);  
                }
            }            
        }else{
            $file_name_medium = $request->input('old_img_medium');
        } */


        /********************medium size end**************************/

         /*********************small size start*************************/

        /* $file_name_small = 'default.jpg';
        if($request->hasFile('image_small'))
        {   

            $file = $request->file('image_small');
            $extension  = strtolower($file->getClientOriginalExtension());
            $size  = $file->getClientSize();
           
            $file_name_small   = uniqid(rand(11111,99999)).'.'.$extension;

            $image1      = Image::make($file);

            $image1->save($this->banner_base_path.$file_name_small);
            $file_name_small = $file_name_small;

            if(isset($form_data['old_img_small']) && !empty($form_data['old_img_small']))
            {
                $unlink_old_img_path_small    = $this->banner_base_path.'/'.$request->input('old_img_small');
                            
                if(file_exists($unlink_old_img_path_small))
                {
                    @unlink($unlink_old_img_path_small);  
                }
            }            
        }else{
            $file_name_small = $request->input('old_img_small');
        } */

        /********************small size end**************************/

        $banner_image->image_name  = $file_name;   
      //  $banner_image->image_medium  = $file_name_medium;        
      //  $banner_image->image_small  = $file_name_small;        

        $banner_image->save();

        if($banner_image)
        {          
         	$response['status']      = "success";
            $response['description'] = "Image changed successfully."; 
        }
        else
        {
            $response['status']      = "error";
            $response['description'] = "Unable to change image";
        }

        return response()->json($response);
    }
}
