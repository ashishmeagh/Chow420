<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\BannerImagesModel;

use App\Common\Traits\MultiActionTrait;
use App\Common\Services\UserService;

use Validator;
use Image;
use DB;  
use Datatables; 
use Flash;
use Sentinel;

class BannerImagesController extends Controller
{       
    use MultiActionTrait;

    public function __construct(BannerImagesModel $BannerImagesModel,
                                UserService $UserService
                               ) 
    {
    	$this->BaseModel          = $BannerImagesModel;
        $this->UserService        = $UserService;

        $this->arr_view_data      = [];
        $this->admin_url_path     = url(config('app.project.admin_panel_slug'));

        $this->banner_base_img_path   = base_path().config('app.project.img_path.banner_images');
        $this->banner_public_img_path = url('/').config('app.project.img_path.banner_images');


        $this->banner_image_thumb_base_img_path = base_path().config('app.project.img_path.banner_images_thumb');

        $this->module_title       = "Banner Images";
        $this->module_view_folder = "admin.banner_images";
        $this->module_url_path    = $this->admin_url_path."/banner_images";
    }

 


    public function store(Request $request)
    {
    	$form_data = $request->all();  
        $user = Sentinel::check();  


        $is_update_process = false;

        $id = $request->input('id',false);

        if($request->has('id'))
        {
            $is_update_process = true; 
        }

       
        if ($request->hasFile('banner_image1_desktop')) 
        {
           //Validation for product image
           $file_extension = strtolower($request->file('banner_image1_desktop')->getClientOriginalExtension());
           if(!in_array($file_extension,['jpg','png','jpeg']))
           {
                $response['status']       = 'ImageFAILURE_banner_image1_desktop';
                $response['description']  = 'Invalid image only jpg,png,jpeg extensions allowed.';
                return response()->json($response);
            }

        }

        if ($request->hasFile('banner_image1_mobile')) 
        {
           //Validation for product image
           $file_extension = strtolower($request->file('banner_image1_mobile')->getClientOriginalExtension());
           if(!in_array($file_extension,['jpg','png','jpeg']))
           {
                $response['status']       = 'ImageFAILURE_banner_image1_mobile';
                $response['description']  = 'Invalid image only jpg,png,jpeg extensions allowed.';
                return response()->json($response);
            }

        }


        if ($request->hasFile('banner_image2_desktop')) 
        {
           //Validation for product image
           $file_extension = strtolower($request->file('banner_image2_desktop')->getClientOriginalExtension());
           if(!in_array($file_extension,['jpg','png','jpeg']))
           {
                $response['status']       = 'ImageFAILURE_banner_image2_desktop';
                $response['description']  = 'Invalid image only jpg,png,jpeg extensions allowed.';
                return response()->json($response);
            }

        }

        if ($request->hasFile('banner_image2_mobile')) 
        {
           //Validation for product image
           $file_extension = strtolower($request->file('banner_image2_mobile')->getClientOriginalExtension());
           if(!in_array($file_extension,['jpg','png','jpeg']))
           {
                $response['status']       = 'ImageFAILURE_banner_image2_mobile';
                $response['description']  = 'Invalid image only jpg,png,jpeg extensions allowed.';
                return response()->json($response);
            }

        }

        if ($request->hasFile('banner_image3_desktop')) 
        {
           //Validation for product image
           $file_extension = strtolower($request->file('banner_image3_desktop')->getClientOriginalExtension());
           if(!in_array($file_extension,['jpg','png','jpeg']))
           {
                $response['status']       = 'ImageFAILURE_banner_image3_desktop';
                $response['description']  = 'Invalid image only jpg,png,jpeg extensions allowed.';
                return response()->json($response);
            }

        }
    
        

        if ($request->hasFile('banner_image3_mobile')) 
        {
           //Validation for product image
           $file_extension = strtolower($request->file('banner_image3_mobile')->getClientOriginalExtension());
           if(!in_array($file_extension,['jpg','png','jpeg']))
           {
                $response['status']       = 'ImageFAILURE_banner_image3_mobile';
                $response['description']  = 'Invalid image only jpg,png,jpeg extensions allowed.';
                return response()->json($response);
            }
        }


        if ($request->hasFile('banner_image4_desktop')) 
        {
           //Validation for product image
           $file_extension = strtolower($request->file('banner_image4_desktop')->getClientOriginalExtension());
           if(!in_array($file_extension,['jpg','png','jpeg']))
           {
                $response['status']       = 'ImageFAILURE_banner_image4_desktop';
                $response['description']  = 'Invalid image only jpg,png,jpeg extensions allowed.';
                return response()->json($response);
            }
        }

        if ($request->hasFile('banner_image4_mobile')) 
        {
           //Validation for product image
           $file_extension = strtolower($request->file('banner_image4_mobile')->getClientOriginalExtension());
           if(!in_array($file_extension,['jpg','png','jpeg']))
           {
                $response['status']       = 'ImageFAILURE_banner_image4_mobile';
                $response['description']  = 'Invalid image only jpg,png,jpeg extensions allowed.';
                return response()->json($response);
            }
        }



        if ($request->hasFile('banner_image5_desktop')) 
        {
           //Validation for product image
           $file_extension = strtolower($request->file('banner_image5_desktop')->getClientOriginalExtension());
           if(!in_array($file_extension,['jpg','png','jpeg']))
           {
                $response['status']       = 'ImageFAILURE_banner_image5_desktop';
                $response['description']  = 'Invalid image only jpg,png,jpeg extensions allowed.';
                return response()->json($response);
            }
        }

        if ($request->hasFile('banner_image5_mobile')) 
        {
           //Validation for product image
           $file_extension = strtolower($request->file('banner_image5_mobile')->getClientOriginalExtension());
           if(!in_array($file_extension,['jpg','png','jpeg']))
           {
                $response['status']       = 'ImageFAILURE_banner_image5_mobile';
                $response['description']  = 'Invalid image only jpg,png,jpeg extensions allowed.';
                return response()->json($response);
            }
        }




        if ($request->hasFile('banner_image6_desktop')) 
        {
           //Validation for product image
           $file_extension = strtolower($request->file('banner_image6_desktop')->getClientOriginalExtension());
           if(!in_array($file_extension,['jpg','png','jpeg']))
           {
                $response['status']       = 'ImageFAILURE_banner_image6_desktop';
                $response['description']  = 'Invalid image only jpg,png,jpeg extensions allowed.';
                return response()->json($response);
            }
        }

        if ($request->hasFile('banner_image6_mobile')) 
        {
           //Validation for product image
           $file_extension = strtolower($request->file('banner_image6_mobile')->getClientOriginalExtension());
           if(!in_array($file_extension,['jpg','png','jpeg']))
           {
                $response['status']       = 'ImageFAILURE_banner_image6_mobile';
                $response['description']  = 'Invalid image only jpg,png,jpeg extensions allowed.';
                return response()->json($response);
            }
        }


        if ($request->hasFile('banner_image7_desktop')) 
        {
           //Validation for product image
           $file_extension = strtolower($request->file('banner_image7_desktop')->getClientOriginalExtension());
           if(!in_array($file_extension,['jpg','png','jpeg']))
           {
                $response['status']       = 'ImageFAILURE_banner_image7_desktop';
                $response['description']  = 'Invalid image only jpg,png,jpeg extensions allowed.';
                return response()->json($response);
            }
        }

        if ($request->hasFile('banner_image7_mobile')) 
        {
           //Validation for product image
           $file_extension = strtolower($request->file('banner_image7_mobile')->getClientOriginalExtension());
           if(!in_array($file_extension,['jpg','png','jpeg']))
           {
                $response['status']       = 'ImageFAILURE_banner_image7_mobile';
                $response['description']  = 'Invalid image only jpg,png,jpeg extensions allowed.';
                return response()->json($response);
            }
        }


        if ($request->hasFile('banner_image8_desktop')) 
        {
           //Validation for product image
           $file_extension = strtolower($request->file('banner_image8_desktop')->getClientOriginalExtension());
           if(!in_array($file_extension,['jpg','png','jpeg']))
           {
                $response['status']       = 'ImageFAILURE_banner_image8_desktop';
                $response['description']  = 'Invalid image only jpg,png,jpeg extensions allowed.';
                return response()->json($response);
            }
        }

        if ($request->hasFile('banner_image8_mobile')) 
        {
           //Validation for product image
           $file_extension = strtolower($request->file('banner_image8_mobile')->getClientOriginalExtension());
           if(!in_array($file_extension,['jpg','png','jpeg']))
           {
                $response['status']       = 'ImageFAILURE_banner_image8_mobile';
                $response['description']  = 'Invalid image only jpg,png,jpeg extensions allowed.';
                return response()->json($response);
            }
        }

        if ($request->hasFile('banner_image9_desktop')) 
        {
           //Validation for product image
           $file_extension = strtolower($request->file('banner_image9_desktop')->getClientOriginalExtension());
           if(!in_array($file_extension,['jpg','png','jpeg']))
           {
                $response['status']       = 'ImageFAILURE_banner_image9_desktop';
                $response['description']  = 'Invalid image only jpg,png,jpeg extensions allowed.';
                return response()->json($response);
            }
        }

        if ($request->hasFile('banner_image9_mobile')) 
        {
           //Validation for product image
           $file_extension = strtolower($request->file('banner_image9_mobile')->getClientOriginalExtension());
           if(!in_array($file_extension,['jpg','png','jpeg']))
           {
                $response['status']       = 'ImageFAILURE_banner_image9_mobile';
                $response['description']  = 'Invalid image only jpg,png,jpeg extensions allowed.';
                return response()->json($response);
            }
        }


        if ($request->hasFile('banner_image10_desktop')) 
        {
           //Validation for product image
           $file_extension = strtolower($request->file('banner_image10_desktop')->getClientOriginalExtension());
           if(!in_array($file_extension,['jpg','png','jpeg']))
           {
                $response['status']       = 'ImageFAILURE_banner_image10_desktop';
                $response['description']  = 'Invalid image only jpg,png,jpeg extensions allowed.';
                return response()->json($response);
            }
        }

        if ($request->hasFile('banner_image10_mobile')) 
        {
           //Validation for product image
           $file_extension = strtolower($request->file('banner_image10_mobile')->getClientOriginalExtension());
           if(!in_array($file_extension,['jpg','png','jpeg']))
           {
                $response['status']       = 'ImageFAILURE_banner_image10_mobile';
                $response['description']  = 'Invalid image only jpg,png,jpeg extensions allowed.';
                return response()->json($response);
            }
        }




    	
        
        /* Main Model Entry */
        $banner_image = $this->BaseModel->firstOrNew(['id' => $id]);

   
        /********************for banner image1*desktop******************/
        $file_name = '';
        if($request->hasFile('banner_image1_desktop'))
        {	
        	$file = $request->file('banner_image1_desktop');
            $extension  = strtolower($file->getClientOriginalExtension());
            $size  = $file->getClientSize();
           
            $file_name   = uniqid(rand(11111,99999)).'.'.$extension;

            // $image1      = Image::make($file);
            // $image1->resize(1170,300); // commented
            // $image1->resize(650,300);  //old
            // $image1->save($this->banner_base_img_path.$file_name);

             $img = Image::make($request->file('banner_image1_desktop')->getRealPath());
                                $img->resize(1170, 300, function ($constraint) {
                                $constraint->aspectRatio();
             })->save($this->banner_base_img_path.$file_name);

             // $img2 = Image::make($request->file('banner_image1_desktop')->getRealPath());
             //                    $img2->resize(650, 300, function ($constraint) {
             //                    $constraint->aspectRatio();
             // })->save($this->banner_image_thumb_base_img_path.$file_name);                   


            $unlink_old_img_path    = $this->banner_base_img_path.'/'.$request->input('old_banner_image1_desktop');

            // $unlink_old_img_thumb_path    = $this->banner_image_thumb_base_img_path.'/'.$request->input('old_banner_image1_desktop');
                            
            if(file_exists($unlink_old_img_path))
            {
                @unlink($unlink_old_img_path);  
            }
            //  if(file_exists($unlink_old_img_thumb_path))
            // {
            //     @unlink($unlink_old_img_thumb_path);  
            // }
        } 
        else
        {
            $file_name = $request->input('old_banner_image1_desktop');
        }
        /********************for banner image1*desktop***************************/


         /********************for banner image1*mobile******************/
        $file_medium_name = '';
        if($request->hasFile('banner_image1_mobile'))
        {   
            $file = $request->file('banner_image1_mobile');
            $extension  = strtolower($file->getClientOriginalExtension());
            $size  = $file->getClientSize();
           
            $file_medium_name   = uniqid(rand(11111,99999)).'.'.$extension;

            // $image1      = Image::make($file);
            // $image1->resize(1170,300); // commented
            // $image1->resize(650,300);  //old
            // $image1->save($this->banner_base_img_path.$file_medium_name);

             $img = Image::make($request->file('banner_image1_mobile')->getRealPath());
                                $img->resize(650, 300, function ($constraint) {
                                $constraint->aspectRatio();
             })->save($this->banner_base_img_path.$file_medium_name);
                             

            $unlink_old_img_path    = $this->banner_base_img_path.'/'.$request->input('old_banner_image1_mobile');
                            
            if(file_exists($unlink_old_img_path))
            {
                @unlink($unlink_old_img_path);  
            }
        } 
        else
        {
            $file_medium_name = $request->input('old_banner_image1_mobile');
        }
        /********************for banner image1*desktmobile***************************/




         /********************for banner image2*desktop******************/
        $file_name2 = '';
        if($request->hasFile('banner_image2_desktop'))
        {   
            $file = $request->file('banner_image2_desktop');
            $extension  = strtolower($file->getClientOriginalExtension());
            $size  = $file->getClientSize();
           
            $file_name2   = uniqid(rand(11111,99999)).'.'.$extension;

            // $image1      = Image::make($file);
            // $image1->resize(1170,300); // commented
            // $image1->resize(650,300);  //old
            // $image1->save($this->banner_base_img_path.$file_name2);


             $img = Image::make($request->file('banner_image2_desktop')->getRealPath());
                                $img->resize(1170, 300, function ($constraint) {
                                $constraint->aspectRatio();
             })->save($this->banner_base_img_path.$file_name2);

             // $img2 = Image::make($request->file('banner_image2_desktop')->getRealPath());
             //                    $img2->resize(650, 300, function ($constraint) {
             //                    $constraint->aspectRatio();
             // })->save($this->banner_image_thumb_base_img_path.$file_name2);      


            $unlink_old_img_path    = $this->banner_base_img_path.'/'.$request->input('old_banner_image2_desktop');

            // $unlink_old_img_thumb_path    = $this->banner_image_thumb_base_img_path.'/'.$request->input('old_banner_image2_desktop');
                            
            if(file_exists($unlink_old_img_path))
            {
                @unlink($unlink_old_img_path);  
            }
            // if(file_exists($unlink_old_img_thumb_path))
            // {
            //     @unlink($unlink_old_img_thumb_path);  
            // }
        } 
        else
        {
            $file_name2 = $request->input('old_banner_image2_desktop');
        }
        /********************for banner image2*desktop***************************/



          /********************for banner image2*mobile******************/
            $file_mobile2 = '';
            if($request->hasFile('banner_image2_mobile'))
            {   
                $file = $request->file('banner_image2_mobile');
                $extension  = strtolower($file->getClientOriginalExtension());
                $size  = $file->getClientSize();
               
                $file_mobile2   = uniqid(rand(11111,99999)).'.'.$extension;

                // $image1      = Image::make($file);
                // $image1->resize(1170,300); // commented
                // $image1->resize(650,300);  //old
                // $image1->save($this->banner_base_img_path.$file_mobile2);
                 $img = Image::make($request->file('banner_image2_mobile')->getRealPath());
                                $img->resize(650, 300, function ($constraint) {
                                $constraint->aspectRatio();
                 })->save($this->banner_base_img_path.$file_mobile2);


                $unlink_old_img_path    = $this->banner_base_img_path.'/'.$request->input('old_banner_image2_mobile');
                                
                if(file_exists($unlink_old_img_path))
                {
                    @unlink($unlink_old_img_path);  
                }
            } 
            else
            {
                $file_mobile2 = $request->input('old_banner_image2_mobile');
            }
        /********************for banner image1*desktmobile***************************/


         /********************for banner image3*desktop3******************/
        $file_name3 = '';
        if($request->hasFile('banner_image3_desktop'))
        {   
            $file = $request->file('banner_image3_desktop');
            $extension  = strtolower($file->getClientOriginalExtension());
            $size  = $file->getClientSize();
           
            $file_name3   = uniqid(rand(11111,99999)).'.'.$extension;

            // $image1      = Image::make($file);
            // $image1->resize(1170,300); // commented
            // $image1->resize(650,300);  //old
            // $image1->save($this->banner_base_img_path.$file_name3);

             $img = Image::make($request->file('banner_image3_desktop')->getRealPath());
                                $img->resize(1170, 300, function ($constraint) {
                                $constraint->aspectRatio();
             })->save($this->banner_base_img_path.$file_name3);

             // $img2 = Image::make($request->file('banner_image3_desktop')->getRealPath());
             //                    $img2->resize(650, 300, function ($constraint) {
             //                    $constraint->aspectRatio();
             // })->save($this->banner_image_thumb_base_img_path.$file_name3);      




            $unlink_old_img_path    = $this->banner_base_img_path.'/'.$request->input('old_banner_image3_desktop');

            // $unlink_old_img_path_thumb    = $this->banner_image_thumb_base_img_path.'/'.$request->input('old_banner_image3_desktop');
                            
            if(file_exists($unlink_old_img_path))
            {
                @unlink($unlink_old_img_path);  
            }
            //   if(file_exists($unlink_old_img_path_thumb))
            // {
            //     @unlink($unlink_old_img_path_thumb);  
            // }
        } 
        else
        {
            $file_name3 = $request->input('old_banner_image3_desktop');
        }
        /********************for banner image1*desktop***************************/



        /********************for banner image3*mobile3******************/
        $file_mobile3 = '';
        if($request->hasFile('banner_image3_mobile'))
        {   
            $file = $request->file('banner_image3_mobile');
            $extension  = strtolower($file->getClientOriginalExtension());
            $size  = $file->getClientSize();
           
            $file_mobile3   = uniqid(rand(11111,99999)).'.'.$extension;

            // $image1      = Image::make($file);
            // $image1->resize(1170,300); // commented
            // $image1->resize(650,300);  //old
            // $image1->save($this->banner_base_img_path.$file_mobile3);

              $img = Image::make($request->file('banner_image3_mobile')->getRealPath());
                                $img->resize(650, 300, function ($constraint) {
                                $constraint->aspectRatio();
             })->save($this->banner_base_img_path.$file_mobile3);

            $unlink_old_img_path    = $this->banner_base_img_path.'/'.$request->input('old_banner_image3_mobile');
                            
            if(file_exists($unlink_old_img_path))
            {
                @unlink($unlink_old_img_path);  
            }
        } 
        else
        {
            $file_mobile3 = $request->input('old_banner_image3_mobile');
        }
        /********************for banner image3*tmobile***************************/
       


       /********************for banner image4*desktop4******************/
        $file_name4 = '';
        if($request->hasFile('banner_image4_desktop'))
        {   
            $file = $request->file('banner_image4_desktop');
            $extension  = strtolower($file->getClientOriginalExtension());
            $size  = $file->getClientSize();
           
            $file_name4   = uniqid(rand(11111,99999)).'.'.$extension;

            // $image1      = Image::make($file);
            // $image1->resize(1170,300); // commented
            // $image1->resize(650,300);  //old
            // $image1->save($this->banner_base_img_path.$file_name4);

             $img = Image::make($request->file('banner_image4_desktop')->getRealPath());
                                $img->resize(1170, 300, function ($constraint) {
                                $constraint->aspectRatio();
             })->save($this->banner_base_img_path.$file_name4);

             // $img2 = Image::make($request->file('banner_image4_desktop')->getRealPath());
             //                    $img2->resize(650, 300, function ($constraint) {
             //                    $constraint->aspectRatio();
             // })->save($this->banner_image_thumb_base_img_path.$file_name4);      

            $unlink_old_img_path    = $this->banner_base_img_path.'/'.$request->input('old_banner_image4_desktop');
            // $unlink_old_img_path_thumb    = $this->banner_image_thumb_base_img_path.'/'.$request->input('old_banner_image4_desktop');
                            
            if(file_exists($unlink_old_img_path))
            {
                @unlink($unlink_old_img_path);  
            }
            //  if(file_exists($unlink_old_img_path_thumb))
            // {
            //     @unlink($unlink_old_img_path_thumb);  
            // }
        } 
        else
        {
            $file_name4 = $request->input('old_banner_image4_desktop');
        }
        /********************for banner image4*desktop***************************/



        /********************for banner image4*mobile4******************/
        $file_mobile4 = '';
        if($request->hasFile('banner_image4_mobile'))
        {   
            $file = $request->file('banner_image4_mobile');
            $extension  = strtolower($file->getClientOriginalExtension());
            $size  = $file->getClientSize();
           
            $file_mobile4   = uniqid(rand(11111,99999)).'.'.$extension;

            // $image1      = Image::make($file);
            // $image1->resize(1170,300); // commented
            // $image1->resize(650,300);  //old
            // $image1->save($this->banner_base_img_path.$file_mobile4);

             $img = Image::make($request->file('banner_image4_mobile')->getRealPath());
                                $img->resize(650, 300, function ($constraint) {
                                $constraint->aspectRatio();
             })->save($this->banner_base_img_path.$file_mobile4);

            $unlink_old_img_path    = $this->banner_base_img_path.'/'.$request->input('old_banner_image4_mobile');
                            
            if(file_exists($unlink_old_img_path))
            {
                @unlink($unlink_old_img_path);  
            }
        } 
        else
        {
            $file_mobile4 = $request->input('old_banner_image4_mobile');
        }
        /********************for banner image4*mobile***************************/




       /********************for banner image5*desktop5******************/
        $file_name5 = '';
        if($request->hasFile('banner_image5_desktop'))
        {   
            $file = $request->file('banner_image5_desktop');
            $extension  = strtolower($file->getClientOriginalExtension());
            $size  = $file->getClientSize();
           
            $file_name5   = uniqid(rand(11111,99999)).'.'.$extension;

            // $image1      = Image::make($file);
            // $image1->resize(1170,300); // commented
            // $image1->resize(650,300);  //old
            // $image1->save($this->banner_base_img_path.$file_name5);

             $img = Image::make($request->file('banner_image5_desktop')->getRealPath());
                                $img->resize(1170, 300, function ($constraint) {
                                $constraint->aspectRatio();
             })->save($this->banner_base_img_path.$file_name5);

             // $img2 = Image::make($request->file('banner_image5_desktop')->getRealPath());
             //                    $img2->resize(650, 300, function ($constraint) {
             //                    $constraint->aspectRatio();
             // })->save($this->banner_image_thumb_base_img_path.$file_name5);      

            $unlink_old_img_path    = $this->banner_base_img_path.'/'.$request->input('old_banner_image5_desktop');

            // $unlink_old_img_path_thumb    = $this->banner_image_thumb_base_img_path.'/'.$request->input('old_banner_image5_desktop');
                            
            if(file_exists($unlink_old_img_path))
            {
                @unlink($unlink_old_img_path);  
            }
            // if(file_exists($unlink_old_img_path_thumb))
            // {
            //     @unlink($unlink_old_img_path_thumb);  
            // }
        } 
        else
        {
            $file_name5 = $request->input('old_banner_image5_desktop');
        }
        /********************for banner image5*desktop***************************/


        /********************for banner image5*mobile5******************/
        $file_mobile5 = '';
        if($request->hasFile('banner_image5_mobile'))
        {   
            $file = $request->file('banner_image5_mobile');
            $extension  = strtolower($file->getClientOriginalExtension());
            $size  = $file->getClientSize();
           
            $file_mobile5   = uniqid(rand(11111,99999)).'.'.$extension;

            // $image1      = Image::make($file);
            // $image1->resize(1170,300); // commented
            // $image1->resize(650,300);  //old
            // $image1->save($this->banner_base_img_path.$file_mobile5);

              $img = Image::make($request->file('banner_image5_mobile')->getRealPath());
                                $img->resize(650, 300, function ($constraint) {
                                $constraint->aspectRatio();
             })->save($this->banner_base_img_path.$file_mobile5);

            $unlink_old_img_path    = $this->banner_base_img_path.'/'.$request->input('old_banner_image5_mobile');
                            
            if(file_exists($unlink_old_img_path))
            {
                @unlink($unlink_old_img_path);  
            }
        } 
        else
        {
            $file_mobile5 = $request->input('old_banner_image5_mobile');
        }
        /********************for banner image4*mobile***************************/


        /********************for banner image6*desktop6******************/
        $file_name6 = '';
        if($request->hasFile('banner_image6_desktop'))
        {   
            $file = $request->file('banner_image6_desktop');
            $extension  = strtolower($file->getClientOriginalExtension());
            $size  = $file->getClientSize();
           
            $file_name6   = uniqid(rand(11111,99999)).'.'.$extension;

            // $image1      = Image::make($file);
            // $image1->resize(1170,300); // commented
            // $image1->resize(650,300);  //old
            // $image1->save($this->banner_base_img_path.$file_name6);

             $img = Image::make($request->file('banner_image6_desktop')->getRealPath());
                                $img->resize(1170, 300, function ($constraint) {
                                $constraint->aspectRatio();
             })->save($this->banner_base_img_path.$file_name6);

             // $img2 = Image::make($request->file('banner_image6_desktop')->getRealPath());
             //                    $img2->resize(650, 300, function ($constraint) {
             //                    $constraint->aspectRatio();
             // })->save($this->banner_image_thumb_base_img_path.$file_name6);      

            $unlink_old_img_path    = $this->banner_base_img_path.'/'.$request->input('old_banner_image6_desktop');

             // $unlink_old_img_path_thumb    = $this->banner_image_thumb_base_img_path.'/'.$request->input('old_banner_image6_desktop');
                            
            if(file_exists($unlink_old_img_path))
            {
                @unlink($unlink_old_img_path);  
            }
            // if(file_exists($unlink_old_img_path_thumb))
            // {
            //     @unlink($unlink_old_img_path_thumb);  
            // }
        } 
        else
        {
            $file_name6 = $request->input('old_banner_image6_desktop');
        }
        /********************for banner image6*desktop***************************/


         /********************for banner image6*mobile******************/
         $file_mobile6 = '';
        if($request->hasFile('banner_image6_mobile'))
        {   
            $file = $request->file('banner_image6_mobile');
            $extension  = strtolower($file->getClientOriginalExtension());
            $size  = $file->getClientSize();
           
            $file_mobile6   = uniqid(rand(11111,99999)).'.'.$extension;

            // $image1      = Image::make($file);
            // $image1->resize(1170,300); // commented
            // $image1->resize(650,300);  //old
            // $image1->save($this->banner_base_img_path.$file_mobile6);

             $img = Image::make($request->file('banner_image6_mobile')->getRealPath());
                                $img->resize(650, 300, function ($constraint) {
                                $constraint->aspectRatio();
             })->save($this->banner_base_img_path.$file_mobile6);

            $unlink_old_img_path    = $this->banner_base_img_path.'/'.$request->input('old_banner_image6_mobile');
                            
            if(file_exists($unlink_old_img_path))
            {
                @unlink($unlink_old_img_path);  
            }
        } 
        else
        {
            $file_mobile6 = $request->input('old_banner_image6_mobile');
        }
        /********************for banner image6*mobile***************************/



          /********************for banner image7*desktop******************/
        $file_name7 = '';
        if($request->hasFile('banner_image7_desktop'))
        {   
            $file = $request->file('banner_image7_desktop');
            $extension  = strtolower($file->getClientOriginalExtension());
            $size  = $file->getClientSize();
           
            $file_name7   = uniqid(rand(11111,99999)).'.'.$extension;

            // $image1      = Image::make($file);
            // $image1->resize(1170,300); // commented
            // $image1->resize(650,300);  //old
            // $image1->save($this->banner_base_img_path.$file_name6);

             $img = Image::make($request->file('banner_image7_desktop')->getRealPath());
                                $img->resize(1170, 300, function ($constraint) {
                                $constraint->aspectRatio();
             })->save($this->banner_base_img_path.$file_name7);

             // $img2 = Image::make($request->file('banner_image6_desktop')->getRealPath());
             //                    $img2->resize(650, 300, function ($constraint) {
             //                    $constraint->aspectRatio();
             // })->save($this->banner_image_thumb_base_img_path.$file_name6);      

            $unlink_old_img_path    = $this->banner_base_img_path.'/'.$request->input('old_banner_image7_desktop');

             // $unlink_old_img_path_thumb    = $this->banner_image_thumb_base_img_path.'/'.$request->input('old_banner_image6_desktop');
                            
            if(file_exists($unlink_old_img_path))
            {
                @unlink($unlink_old_img_path);  
            }
            // if(file_exists($unlink_old_img_path_thumb))
            // {
            //     @unlink($unlink_old_img_path_thumb);  
            // }
        } 
        else
        {
            $file_name7 = $request->input('old_banner_image7_desktop');
        }
        /********************for banner image7*desktop***************************/


         /********************for banner image7*mobile******************/
         $file_mobile7 = '';
        if($request->hasFile('banner_image7_mobile'))
        {   
            $file = $request->file('banner_image7_mobile');
            $extension  = strtolower($file->getClientOriginalExtension());
            $size  = $file->getClientSize();
           
            $file_mobile7   = uniqid(rand(11111,99999)).'.'.$extension;

            // $image1      = Image::make($file);
            // $image1->resize(1170,300); // commented
            // $image1->resize(650,300);  //old
            // $image1->save($this->banner_base_img_path.$file_mobile6);

             $img = Image::make($request->file('banner_image7_mobile')->getRealPath());
                                $img->resize(650, 300, function ($constraint) {
                                $constraint->aspectRatio();
             })->save($this->banner_base_img_path.$file_mobile7);

            $unlink_old_img_path    = $this->banner_base_img_path.'/'.$request->input('old_banner_image7_mobile');
                            
            if(file_exists($unlink_old_img_path))
            {
                @unlink($unlink_old_img_path);  
            }
        } 
        else
        {
            $file_mobile7 = $request->input('old_banner_image7_mobile');
        }
        /********************for banner image6*mobile***************************/



          /********************for banner image8*desktop******************/
        $file_name8 = '';
        if($request->hasFile('banner_image8_desktop'))
        {   
            $file = $request->file('banner_image8_desktop');
            $extension  = strtolower($file->getClientOriginalExtension());
            $size  = $file->getClientSize();
           
            $file_name8   = uniqid(rand(11111,99999)).'.'.$extension;

            $img = Image::make($request->file('banner_image8_desktop')->getRealPath());
                                $img->resize(1170, 300, function ($constraint) {
                                $constraint->aspectRatio();
             })->save($this->banner_base_img_path.$file_name8);

            $unlink_old_img_path    = $this->banner_base_img_path.'/'.$request->input('old_banner_image8_desktop');

                                     
            if(file_exists($unlink_old_img_path))
            {
                @unlink($unlink_old_img_path);  
            }
          
        } 
        else
        {
            $file_name8 = $request->input('old_banner_image8_desktop');
        }
        /********************for banner image8*desktop***************************/


        /********************for banner image8*mobile******************/
         $file_mobile8 = '';
        if($request->hasFile('banner_image8_mobile'))
        {   
            $file = $request->file('banner_image8_mobile');
            $extension  = strtolower($file->getClientOriginalExtension());
            $size  = $file->getClientSize();
           
            $file_mobile8   = uniqid(rand(11111,99999)).'.'.$extension;

            // $image1      = Image::make($file);
            // $image1->resize(1170,300); // commented
            // $image1->resize(650,300);  //old
            // $image1->save($this->banner_base_img_path.$file_mobile6);

             $img = Image::make($request->file('banner_image8_mobile')->getRealPath());
                                $img->resize(650, 300, function ($constraint) {
                                $constraint->aspectRatio();
             })->save($this->banner_base_img_path.$file_mobile8);

            $unlink_old_img_path    = $this->banner_base_img_path.'/'.$request->input('old_banner_image8_mobile');
                            
            if(file_exists($unlink_old_img_path))
            {
                @unlink($unlink_old_img_path);  
            }
        } 
        else
        {
            $file_mobile8 = $request->input('old_banner_image8_mobile');
        }
        /********************for banner image8*mobile***************************/

        /********************for banner image9*desktop******************/
        $file_name9 = '';
        if($request->hasFile('banner_image9_desktop'))
        {   
            $file = $request->file('banner_image9_desktop');
            $extension  = strtolower($file->getClientOriginalExtension());
            $size  = $file->getClientSize();
           
            $file_name9   = uniqid(rand(11111,99999)).'.'.$extension;

            // $image1      = Image::make($file);
            // $image1->resize(1170,300); // commented
            // $image1->resize(650,300);  //old
            // $image1->save($this->banner_base_img_path.$file_name9);

             $img = Image::make($request->file('banner_image9_desktop')->getRealPath());
                                $img->resize(1170, 300, function ($constraint) {
                                $constraint->aspectRatio();
             })->save($this->banner_base_img_path.$file_name9);

             // $img2 = Image::make($request->file('banner_image9_desktop')->getRealPath());
             //                    $img2->resize(650, 300, function ($constraint) {
             //                    $constraint->aspectRatio();
             // })->save($this->banner_image_thumb_base_img_path.$file_name9);                   


            $unlink_old_img_path    = $this->banner_base_img_path.'/'.$request->input('old_banner_image9_desktop');

            // $unlink_old_img_thumb_path    = $this->banner_image_thumb_base_img_path.'/'.$request->input('old_banner_image9_desktop');
                            
            if(file_exists($unlink_old_img_path))
            {
                @unlink($unlink_old_img_path);  
            }
            //  if(file_exists($unlink_old_img_thumb_path))
            // {
            //     @unlink($unlink_old_img_thumb_path);  
            // }
        } 
        else
        {
            $file_name9 = $request->input('old_banner_image9_desktop');
        }
        /********************for banner image9*desktop***************************/


         /********************for banner image9*mobile******************/
        $file_mobile9 = '';
        if($request->hasFile('banner_image9_mobile'))
        {   
            $file = $request->file('banner_image9_mobile');
            $extension  = strtolower($file->getClientOriginalExtension());
            $size  = $file->getClientSize();
           
            $file_mobile9   = uniqid(rand(11111,99999)).'.'.$extension;

            // $image1      = Image::make($file);
            // $image1->resize(1170,300); // commented
            // $image1->resize(650,300);  //old
            // $image1->save($this->banner_base_img_path.$file_mobile9);

             $img = Image::make($request->file('banner_image9_mobile')->getRealPath());
                                $img->resize(650, 300, function ($constraint) {
                                $constraint->aspectRatio();
             })->save($this->banner_base_img_path.$file_mobile9);
                             

            $unlink_old_img_path    = $this->banner_base_img_path.'/'.$request->input('old_banner_image9_mobile');
                            
            if(file_exists($unlink_old_img_path))
            {
                @unlink($unlink_old_img_path);  
            }
        } 
        else
        {
            $file_mobile9 = $request->input('old_banner_image9_mobile');
        }
        /********************for banner image9*mobile***************************/

        /********************for banner image10*desktop******************/
        $file_name10 = '';
        if($request->hasFile('banner_image10_desktop'))
        {   
            $file = $request->file('banner_image10_desktop');
            $extension  = strtolower($file->getClientOriginalExtension());
            $size  = $file->getClientSize();
           
            $file_name10   = uniqid(rand(11111,99999)).'.'.$extension;

            // $image1      = Image::make($file);
            // $image1->resize(1170,300); // commented
            // $image1->resize(650,300);  //old
            // $image1->save($this->banner_base_img_path.$file_name10);

             $img = Image::make($request->file('banner_image10_desktop')->getRealPath());
                                $img->resize(1170, 300, function ($constraint) {
                                $constraint->aspectRatio();
             })->save($this->banner_base_img_path.$file_name10);

             // $img2 = Image::make($request->file('banner_image10_desktop')->getRealPath());
             //                    $img2->resize(650, 300, function ($constraint) {
             //                    $constraint->aspectRatio();
             // })->save($this->banner_image_thumb_base_img_path.$file_name10);                   


            $unlink_old_img_path    = $this->banner_base_img_path.'/'.$request->input('old_banner_image10_desktop');

            // $unlink_old_img_thumb_path    = $this->banner_image_thumb_base_img_path.'/'.$request->input('old_banner_image10_desktop');
                            
            if(file_exists($unlink_old_img_path))
            {
                @unlink($unlink_old_img_path);  
            }
            //  if(file_exists($unlink_old_img_thumb_path))
            // {
            //     @unlink($unlink_old_img_thumb_path);  
            // }
        } 
        else
        {
            $file_name10 = $request->input('old_banner_image10_desktop');
        }
        /********************for banner image10*desktop***************************/


         /********************for banner image10*mobile******************/
        $file_mobile10 = '';
        if($request->hasFile('banner_image10_mobile'))
        {   
            $file = $request->file('banner_image10_mobile');
            $extension  = strtolower($file->getClientOriginalExtension());
            $size  = $file->getClientSize();
           
            $file_mobile10   = uniqid(rand(11111,99999)).'.'.$extension;

            // $image1      = Image::make($file);
            // $image1->resize(1170,300); // commented
            // $image1->resize(650,300);  //old
            // $image1->save($this->banner_base_img_path.$file_mobile10);

             $img = Image::make($request->file('banner_image10_mobile')->getRealPath());
                                $img->resize(650, 300, function ($constraint) {
                                $constraint->aspectRatio();
             })->save($this->banner_base_img_path.$file_mobile10);
                             

            $unlink_old_img_path    = $this->banner_base_img_path.'/'.$request->input('old_banner_image10_mobile');
                            
            if(file_exists($unlink_old_img_path))
            {
                @unlink($unlink_old_img_path);  
            }
        } 
        else
        {
            $file_mobile10 = $request->input('old_banner_image10_mobile');
        }
        /********************for banner image10*mobile***************************/





        $banner_image->banner_image1_desktop = $file_name;  
        $banner_image->banner_image1_mobile  = $file_medium_name;   

        $banner_image->banner_image2_desktop = $file_name2;  
        $banner_image->banner_image2_mobile  = $file_mobile2;   


        $banner_image->banner_image3_desktop = $file_name3;  
        $banner_image->banner_image3_mobile  = $file_mobile3;   

        $banner_image->banner_image4_desktop = $file_name4;  
        $banner_image->banner_image4_mobile  = $file_mobile4;    

        $banner_image->banner_image5_desktop = $file_name5;  
        $banner_image->banner_image5_mobile  = $file_mobile5;       

        $banner_image->banner_image6_desktop = $file_name6;  
        $banner_image->banner_image6_mobile  = $file_mobile6;       

        $banner_image->banner_image7_desktop = $file_name7;  
        $banner_image->banner_image7_mobile  = $file_mobile7;  

        $banner_image->banner_image8_desktop = $file_name8;  
        $banner_image->banner_image8_mobile  = $file_mobile8;  

        $banner_image->banner_image9_desktop = $file_name9;  
        $banner_image->banner_image9_mobile  = $file_mobile9;

        $banner_image->banner_image10_desktop = $file_name10;  
        $banner_image->banner_image10_mobile  = $file_mobile10;

        $banner_image->banner_image1_link1   = isset($request->banner_image1_link1)?$request->banner_image1_link1:'';
        $banner_image->banner_image2_link2   = isset($request->banner_image2_link2)?$request->banner_image2_link2:'';
        $banner_image->banner_image3_link3   = isset($request->banner_image3_link3)?$request->banner_image3_link3:'';

        $banner_image->banner_image4_link4   = isset($request->banner_image4_link4)?$request->banner_image4_link4:'';
        $banner_image->banner_image5_link5   = isset($request->banner_image5_link5)?$request->banner_image5_link5:'';

        $banner_image->banner_image6_link6   = isset($request->banner_image6_link6)?$request->banner_image6_link6:'';
        $banner_image->banner_image7_link7   = isset($request->banner_image7_link7)?$request->banner_image7_link7:'';
        $banner_image->banner_image8_link8   = isset($request->banner_image8_link8)?$request->banner_image8_link8:'';

        $banner_image->banner_image9_link9   = isset($request->banner_image9_link9)?$request->banner_image9_link9:'';
        $banner_image->banner_image10_link10   = isset($request->banner_image10_link10)?$request->banner_image10_link10:'';

        $banner_image->save();

        if($banner_image)
        {
          
            $response['link'] =$this->module_url_path;
              

              /*-------------------------------------------------------
                |   Activity log Event
                --------------------------------------------------------*/
                  
               //save sub admin activity log 

                if(isset($user) && $user->inRole('sub_admin'))
                {
                    $arr_event                 = [];
                    $arr_event['action']       = 'EDIT';
                    $arr_event['title']        = $this->module_title;
                    $arr_event['user_id']      = isset($user->id)?$user->id:'';
                    $arr_event['message']      = $user->first_name.' '.$user->last_name.' has updated banner image.';

                    $result = $this->UserService->save_activity($arr_event); 
                }

                /*----------------------------------------------------------------------*/
               $response['status']      = "success";
               $response['description'] = "Banner image updated successfully."; 
            
        }
        else
        {
            $response['status']      = "error";
            $response['description'] = "Error occurred while adding banner images.";
        }

        return response()->json($response);
    }

    public function index()
    {       
       
        $obj_data = $this->BaseModel->first();
    
        $arr_slider_image = [];
        if($obj_data)
        {
           $arr_slider_image = $obj_data->toArray(); 
        }
    
      	$this->arr_view_data['banner_public_img_path']   = $this->banner_public_img_path;
      	$this->arr_view_data['edit_mode']                = TRUE;
      	$this->arr_view_data['module_url_path']          = $this->module_url_path;
      	$this->arr_view_data['arr_banner_image']   		 = isset($arr_slider_image) ? $arr_slider_image : [];  
      	$this->arr_view_data['page_title']               = $this->module_title;
      	$this->arr_view_data['module_title']             = $this->module_title;
  
      return view($this->module_view_folder.'.edit',$this->arr_view_data);   
    }//end


    public function delete_bannerimages(Request $request)
    {
      $update_data = $arr_response = [];
      $id = isset($request->id)?$request->id:''; 

      if(isset($id)){

      $oldimagedesktop1 = isset($request->oldimagedesktop1)?$request->oldimagedesktop1:'';
      $oldimagemobile1 = isset($request->oldimagemobile1)?$request->oldimagemobile1:'';
      $link1 = isset($request->link1)?$request->link1:'';




      $oldimagedesktop2 = isset($request->oldimagedesktop2)?$request->oldimagedesktop2:'';
      $oldimagemobile2 = isset($request->oldimagemobile2)?$request->oldimagemobile2:'';
      $link2 = isset($request->link2)?$request->link2:'';


      $oldimagedesktop3 = isset($request->oldimagedesktop3)?$request->oldimagedesktop3:'';
      $oldimagemobile3 = isset($request->oldimagemobile3)?$request->oldimagemobile3:'';
      $link3 = isset($request->link3)?$request->link3:'';


      $oldimagedesktop4 = isset($request->oldimagedesktop4)?$request->oldimagedesktop4:'';
      $oldimagemobile4 = isset($request->oldimagemobile4)?$request->oldimagemobile4:'';
      $link4 = isset($request->link4)?$request->link4:'';


      $oldimagedesktop5 = isset($request->oldimagedesktop5)?$request->oldimagedesktop5:'';
      $oldimagemobile5 = isset($request->oldimagemobile5)?$request->oldimagemobile5:'';
      $link5 = isset($request->link4)?$request->link5:'';
    


      $oldimagedesktop6 = isset($request->oldimagedesktop6)?$request->oldimagedesktop6:'';
      $oldimagemobile6 = isset($request->oldimagemobile6)?$request->oldimagemobile6:'';
      $link6 = isset($request->link6)?$request->link6:'';


      $oldimagedesktop7 = isset($request->oldimagedesktop7)?$request->oldimagedesktop7:'';
      $oldimagemobile7 = isset($request->oldimagemobile7)?$request->oldimagemobile7:'';
      $link7 = isset($request->link7)?$request->link7:'';



      $oldimagedesktop8 = isset($request->oldimagedesktop8)?$request->oldimagedesktop8:'';
      $oldimagemobile8 = isset($request->oldimagemobile8)?$request->oldimagemobile8:'';
      $link8 = isset($request->link8)?$request->link8:'';


      $oldimagedesktop9 = isset($request->oldimagedesktop9)?$request->oldimagedesktop9:'';
      $oldimagemobile9 = isset($request->oldimagemobile9)?$request->oldimagemobile9:'';
      $link9 = isset($request->link9)?$request->link9:'';

      $oldimagedesktop10 = isset($request->oldimagedesktop10)?$request->oldimagedesktop10:'';
      $oldimagemobile10 = isset($request->oldimagemobile10)?$request->oldimagemobile10:'';
      $link10 = isset($request->link10)?$request->link10:'';
  

      if(isset($request->oldimagedesktop1))
      {
         $update_data['banner_image1_desktop'] ='';
      }
       if(isset($request->oldimagemobile1))
      {
         $update_data['banner_image1_mobile'] ='';
      }
       if(isset($request->link1))
      {
         $update_data['banner_image1_link1'] ='';
      }
       $unlink_old_img_path    = $this->banner_base_img_path.'/'.$request->oldimagedesktop1;
       if(file_exists($unlink_old_img_path))
       {
            @unlink($unlink_old_img_path);  
       }
        $unlink_old_img_mobile    = $this->banner_base_img_path.'/'.$request->oldimagemobile1;
       if(file_exists($unlink_old_img_mobile))
       {
            @unlink($unlink_old_img_mobile);  
       }


        if(isset($request->oldimagedesktop2))
      {
         $update_data['banner_image2_desktop'] ='';
      }
       if(isset($request->oldimagemobile2))
      {
         $update_data['banner_image2_mobile'] ='';
      }
       if(isset($request->link2))
      {
         $update_data['banner_image2_link2'] ='';
      }
       $unlink_old_img_path2    = $this->banner_base_img_path.'/'.$request->oldimagedesktop2;
       if(file_exists($unlink_old_img_path2))
       {
            @unlink($unlink_old_img_path2);  
       }
        $unlink_old_img_mobile2    = $this->banner_base_img_path.'/'.$request->oldimagemobile2;
       if(file_exists($unlink_old_img_mobile2))
       {
            @unlink($unlink_old_img_mobile2);  
       }


     if(isset($request->oldimagedesktop3))
      {
         $update_data['banner_image3_desktop'] ='';
      }
       if(isset($request->oldimagemobile3))
      {
         $update_data['banner_image3_mobile'] ='';
      }
       if(isset($request->link3))
      {
         $update_data['banner_image3_link3'] ='';
      }
       $unlink_old_img_path3    = $this->banner_base_img_path.'/'.$request->oldimagedesktop3;
       if(file_exists($unlink_old_img_path3))
       {
            @unlink($unlink_old_img_path3);  
       }
        $unlink_old_img_mobile3    = $this->banner_base_img_path.'/'.$request->oldimagemobile3;
       if(file_exists($unlink_old_img_mobile3))
       {
            @unlink($unlink_old_img_mobile3);  
       }




        if(isset($request->oldimagedesktop4))
      {
         $update_data['banner_image4_desktop'] ='';
      }
       if(isset($request->oldimagemobile4))
      {
         $update_data['banner_image4_mobile'] ='';
      }
       if(isset($request->link4))
      {
         $update_data['banner_image4_link4'] ='';
      }
       $unlink_old_img_path4    = $this->banner_base_img_path.'/'.$request->oldimagedesktop4;
       if(file_exists($unlink_old_img_path4))
       {
            @unlink($unlink_old_img_path4);  
       }
        $unlink_old_img_mobile4    = $this->banner_base_img_path.'/'.$request->oldimagemobile4;
       if(file_exists($unlink_old_img_mobile4))
       {
            @unlink($unlink_old_img_mobile4);  
       }



     if(isset($request->oldimagedesktop5))
      {
         $update_data['banner_image5_desktop'] ='';
      }
       if(isset($request->oldimagemobile5))
      {
         $update_data['banner_image5_mobile'] ='';
      }
       if(isset($request->link5))
      {
         $update_data['banner_image5_link5'] ='';
      }
       $unlink_old_img_path5    = $this->banner_base_img_path.'/'.$request->oldimagedesktop5;
       if(file_exists($unlink_old_img_path5))
       {
            @unlink($unlink_old_img_path5);  
       }
        $unlink_old_img_mobile5    = $this->banner_base_img_path.'/'.$request->oldimagemobile5;
       if(file_exists($unlink_old_img_mobile5))
       {
            @unlink($unlink_old_img_mobile5);  
       }



         if(isset($request->oldimagedesktop6))
      {
         $update_data['banner_image6_desktop'] ='';
      }
       if(isset($request->oldimagemobile6))
      {
         $update_data['banner_image6_mobile'] ='';
      }
       if(isset($request->link6))
      {
         $update_data['banner_image6_link6'] ='';
      }
       $unlink_old_img_path6    = $this->banner_base_img_path.'/'.$request->oldimagedesktop6;
       if(file_exists($unlink_old_img_path6))
       {
            @unlink($unlink_old_img_path6);  
       }
        $unlink_old_img_mobile6    = $this->banner_base_img_path.'/'.$request->oldimagemobile6;
       if(file_exists($unlink_old_img_mobile6))
       {
            @unlink($unlink_old_img_mobile6);  
       }




        if(isset($request->oldimagedesktop7))
      {
         $update_data['banner_image7_desktop'] ='';
      }
       if(isset($request->oldimagemobile7))
      {
         $update_data['banner_image7_mobile'] ='';
      }
       if(isset($request->link7))
      {
         $update_data['banner_image7_link7'] ='';
      }
       $unlink_old_img_path7    = $this->banner_base_img_path.'/'.$request->oldimagedesktop7;
       if(file_exists($unlink_old_img_path7))
       {
            @unlink($unlink_old_img_path7);  
       }
        $unlink_old_img_mobile7    = $this->banner_base_img_path.'/'.$request->oldimagemobile7;
       if(file_exists($unlink_old_img_mobile7))
       {
            @unlink($unlink_old_img_mobile7);  
       }




        if(isset($request->oldimagedesktop8))
      {
         $update_data['banner_image8_desktop'] ='';
      }
       if(isset($request->oldimagemobile8))
      {
         $update_data['banner_image8_mobile'] ='';
      }
       if(isset($request->link8))
      {
         $update_data['banner_image8_link8'] ='';
      }
       $unlink_old_img_path8    = $this->banner_base_img_path.'/'.$request->oldimagedesktop8;
       if(file_exists($unlink_old_img_path8))
       {
            @unlink($unlink_old_img_path8);  
       }
        $unlink_old_img_mobile8    = $this->banner_base_img_path.'/'.$request->oldimagemobile8;
       if(file_exists($unlink_old_img_mobile8))
       {
            @unlink($unlink_old_img_mobile8);  
       }



      if(isset($request->oldimagedesktop9))
      {
         $update_data['banner_image9_desktop'] ='';
      }
       if(isset($request->oldimagemobile9))
      {
         $update_data['banner_image9_mobile'] ='';
      }
       if(isset($request->link9))
      {
         $update_data['banner_image9_link9'] ='';
      }
       $unlink_old_img_path9    = $this->banner_base_img_path.'/'.$request->oldimagedesktop9;
       if(file_exists($unlink_old_img_path9))
       {
            @unlink($unlink_old_img_path9);  
       }
        $unlink_old_img_mobile9    = $this->banner_base_img_path.'/'.$request->oldimagemobile9;
       if(file_exists($unlink_old_img_mobile9))
       {
            @unlink($unlink_old_img_mobile9);  
       }


       if(isset($request->oldimagedesktop10))
      {
         $update_data['banner_image10_desktop'] ='';
      }
       if(isset($request->oldimagemobile10))
      {
         $update_data['banner_image10_mobile'] ='';
      }
       if(isset($request->link10))
      {
         $update_data['banner_image10_link10'] ='';
      }
       $unlink_old_img_path10    = $this->banner_base_img_path.'/'.$request->oldimagedesktop10;
       if(file_exists($unlink_old_img_path10))
       {
            @unlink($unlink_old_img_path10);  
       }
        $unlink_old_img_mobile10    = $this->banner_base_img_path.'/'.$request->oldimagemobile10;
       if(file_exists($unlink_old_img_mobile10))
       {
            @unlink($unlink_old_img_mobile10);  
       }



       $this->BaseModel->where('id',$id)->update($update_data);
       $arr_response['status']      = 'SUCCESS';
       $arr_response['description'] = 'Image deleted successfully';

       }else{
         $arr_response['status']      = 'ERROR';
         $arr_response['description'] = 'Problem occured while deleting';
       }
       return $arr_response;
    }//end function delete_bannerimages



}
