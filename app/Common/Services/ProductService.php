<?php

namespace App\Common\Services;

use App\Models\ProductModel;    
use App\Models\FirstLevelCategoryModel;
use App\Models\SecondLevelCategoryModel;
use App\Models\UserModel;
use App\Models\UnitModel;
use App\Models\DisputeModel;
use App\Models\ProductInventoryModel;
use App\Models\FavoriteModel;
use App\Models\ReviewRatingsModel;
use App\Models\ProductImagesModel;
use App\Models\BrandModel;
use App\Models\ProductCannabinoidsModel;
use App\Models\UserSubscriptionsModel; 
use App\Models\EventModel;
use App\Models\ProductDimensionsModel;
use App\Models\DropShipperModel;
use App\Models\FollowModel;

use App\Common\Services\EmailService;

use Illuminate\Http\Request;
use Flash;   

use DB;
use Sentinel;
use Image;

use App\Common\Services\GeneralService;


class ProductService
{
	public function __construct(ProductModel $ProductModel, 
                                FirstLevelCategoryModel $FirstLevelCategoryModel,
                                SecondLevelCategoryModel $SecondLevelCategoryModel,
                                UserModel $UserModel,
                                UnitModel $UnitModel,
                                ProductInventoryModel $ProductInventoryModel,
                                DisputeModel $DisputeModel,
                                FavoriteModel $FavoriteModel,
                                GeneralService $GeneralService,
                                ReviewRatingsModel $ReviewRatingsModel,
                                ProductImagesModel $ProductImagesModel,
                                BrandModel $BrandModel,
                                ProductCannabinoidsModel $ProductCannabinoidsModel,
                                EmailService $EmailService,
                                UserSubscriptionsModel $UserSubscriptionsModel,
                                EventModel $EventModel,
                                ProductDimensionsModel $ProductDimensionsModel,
                                DropShipperModel $DropShipperModel,
                                FollowModel $FollowModel
                            )
	{ 
        $this->ProductModel             = $ProductModel;
        $this->ProductDimensionsModel   = $ProductDimensionsModel;
        $this->DropShipperModel         = $DropShipperModel; 
        $this->FirstLevelCategoryModel  = $FirstLevelCategoryModel;
        $this->SecondLevelCategoryModel = $SecondLevelCategoryModel;
        $this->UserModel                = $UserModel;
        $this->UnitModel                = $UnitModel;
        $this->ProductInventoryModel    = $ProductInventoryModel;
        $this->FavoriteModel            = $FavoriteModel;
        $this->DisputeModel             = $DisputeModel;
        $this->module_title             = "Manage Product";
        $this->GeneralService           = $GeneralService;
        $this->ReviewRatingsModel       = $ReviewRatingsModel;
        $this->ProductImagesModel       = $ProductImagesModel;
        $this->BrandModel               = $BrandModel;
        $this->ProductCannabinoidsModel = $ProductCannabinoidsModel;
        $this->FollowModel              = $FollowModel;

        $this->EmailService             = $EmailService;
        $this->UserSubscriptionsModel   = $UserSubscriptionsModel;
        $this->EventModel               = $EventModel;

        $this->product_image_thumb_base_img_path = base_path().config('app.project.img_path.product_imagesthumb');

        $this->product_image_base_img_path  = base_path().config('app.project.img_path.product_images');
        $this->product_public_img_path      = url('/').config('app.project.img_path.product_images');

        $this->add_product_image_base_img_path = base_path().config('app.project.img_path.additional_product_image');
        $this->add_product_public_img_path  = url('/').config('app.project.img_path.additional_product_image');


	}

    public function get_all_product()
    {
        $obj_product = $this->ProductModel->with(['first_level_category_details',
                                            'second_level_category_details'])
                                            ->where([['is_active',1],['is_approve',1]])
                                            ->get();
        if ($obj_product) {
           $aprr_product = $obj_product->toArray();
        }
        return $obj_product;
    }

    public function save($form_data, Request $request)
    {
        

        $is_update_process            = false;
        $price_drop_flag_changed_to_1 = "";

        $id = $request->input('id',false);

        if($request->has('id'))
        {
            $is_update_process = true; 
        }

         /* Main Model Entry */
        $productlist = $this->ProductModel->firstOrNew(['id' => $id]);

        if(!empty($productlist) && $productlist->error_message!='' && $productlist->is_bulk_upload==1)
        {
           $productlist->error_message=''; 
        }

         $productlist->sku    =  isset($form_data['sku'])?$form_data['sku']:'';

        $productlist->product_name             =  isset($form_data['product_name'])?$form_data['product_name']:'';
        $productlist->first_level_category_id  =  isset($form_data['first_level_category_id'])?$form_data['first_level_category_id']:'';
        $productlist->second_level_category_id =  isset($form_data['second_level_category_id'])?$form_data['second_level_category_id']:'';
        $productlist->description       =  isset($form_data['description'])?$form_data['description']:'';
        $productlist->ingredients       =  isset($form_data['ingredients'])?$form_data['ingredients']:'';
        $productlist->suggested_use     =  isset($form_data['suggested_use'])?$form_data['suggested_use']:'';
        $productlist->amount_per_serving = isset($form_data['amount_per_serving'])?$form_data['amount_per_serving']:'';
        $productlist->unit_price        =  isset($form_data['unit_price'])?$form_data['unit_price']:'';
        $productlist->price_drop_to     =  isset($form_data['price_drop_to'])?$form_data['price_drop_to']:'';
        $productlist->shipping_type     =  isset($form_data['shipping_type'])?$form_data['shipping_type']:'';
        $productlist->shipping_duration =  isset($form_data['shipping_duration'])?$form_data['shipping_duration']:'';
        
        $productlist->avg_rating =  isset($form_data['product_rating'])?$form_data['product_rating']:'';
        $productlist->avg_review =  isset($form_data['product_review'])?$form_data['product_review']:'';
        
        $productlist->terpenes  =  isset($form_data['terpenes'])?$form_data['terpenes']:'';

     
        $shipping_type     =  isset($form_data['shipping_type'])?$form_data['shipping_type']:'';
        if($shipping_type==1){
            $productlist->shipping_charges     =  isset($form_data['shipping_charges']) ? $form_data['shipping_charges'] : '';
        }else{
            $productlist->shipping_charges     =  0;
        }
        
        $productlist->user_id        =  isset($form_data['user_id'])?$form_data['user_id']:'';
        $productlist->product_stock  =  isset($form_data['product_stock'])?$form_data['product_stock']:0;
        $productlist->per_product_quantity  =  isset($form_data['per_product_quantity'])?$form_data['per_product_quantity']:0;

        $product_stock =  isset($form_data['product_stock'])?$form_data['product_stock']:'';

        $is_age_limit = isset($form_data['is_age_limit'])?$form_data['is_age_limit']:0;
        $age_restriction = isset($form_data['age_restriction'])?$form_data['age_restriction']:'';
        $unit_id    = isset($form_data['unit_id'])?$form_data['unit_id']:0;
        $is_active    = isset($form_data['is_active'])?$form_data['is_active']:0;

         $brand = isset($form_data['brand'])?$form_data['brand']:'';
         $drop_shipper_name  =  isset($form_data['drop_shipper_name'])?$form_data['drop_shipper_name']:'';
         $drop_shipper_email =  isset($form_data['drop_shipper_email'])?$form_data['drop_shipper_email']:'';
         $drop_shipper_product_price =  isset($form_data['drop_shipper_product_price'])?$form_data['drop_shipper_product_price']:'';
         
        $productlist->product_video_source = isset($form_data['product_video_source'])?$form_data['product_video_source']:'';
        $productlist->product_video_url = isset($form_data['product_video_url'])?$form_data['product_video_url']:'';

        $product_dimension_arr             = isset($form_data['product_dimension'])?$form_data['product_dimension']:'';

        $product_dimension_value_arr       = isset($form_data['product_dimension_value'])?$form_data['product_dimension_value']:'';


         $spectrum       = isset($form_data['spectrum'])?$form_data['spectrum']:'';
         $coa_link        = isset($form_data['coa_link'])?$form_data['coa_link']:'';


        if($brand)
        {
            $res_brand = $this->BrandModel->select('*')->where('name',$brand)->get()->toArray();
            // dd($res_brand);
            if(!empty($res_brand)){
            $brandid = $res_brand[0]['id'];
            }else{
              $brandid = DB::table('brands')-> insertGetId(array(
                  'name' => $brand,
                  'is_active'=>1
                ));  
            }
        }

        if(isset($productlist->price_drop_to) && !empty($productlist->price_drop_to) && $productlist->price_drop_to >0 && isset($productlist->unit_price) && $productlist->unit_price > 0)
        {
           $unit_price    =  $productlist->unit_price;
           $price_drop_to =  $productlist->price_drop_to;
           calculate_percentage_price_drop($id,$unit_price,$price_drop_to);
        }


        $productlist->spectrum  = $spectrum;

        $productlist->brand       =$brandid;
       // $productlist->drop_shipper=$dropshipperid;

        $productlist->is_age_limit =$is_age_limit;
        $productlist->unit_id = $unit_id;
        $productlist->is_bulk_upload=0;
        if($is_age_limit=='1')
        {
            $productlist->age_restriction = $age_restriction;
        }else{
            $productlist->age_restriction ='';
        }

        $productlist->coa_link = $coa_link;

      
      /*  $file_name = '';
        if($request->hasFile('product_image'))
        {   
           $file_name = $request->input('product_image');
                      $file_extension = strtolower($request->file('product_image')->getClientOriginalExtension()); 
                      if(!in_array($file_extension,['jpg','png','jpeg']))
                      {                           
                          $arr_response['status']       = 'FAILURE';
                          $arr_response['description']  = 'Invalid product image..Please try again';

                          return response()->json($arr_response);
                      }

                      $file_name = sha1(uniqid().$file_name.uniqid()).'.'.$file_extension;
                      $request->file('product_image')->move($this->product_image_base_img_path, $file_name);

            $unlink_old_img_path    = $this->product_image_base_img_path.'/'.$request->input('old_img');
                            
            if(file_exists($unlink_old_img_path))
            {
                @unlink($unlink_old_img_path);  
            }
        } 
        else
        {
            $file_name = $request->input('old_product_image');            
        }

        $productlist->product_image  = $file_name;   */


        /**************************** code for uploading multiple images *********************/

         if(isset($form_data['duplicate']) && $form_data['duplicate']==1)
         {      
                $file_name = $additional_img = '';


                if($request->hasfile('product_image'))
                {
                        $image_data=[];

                       
                            $file_name = $request->input('product_image');

                            $file_extension = strtolower($request->file('product_image')->getClientOriginalExtension()); 

                            $file_name = sha1(uniqid().$request->file('product_image').uniqid()).'.'.$file_extension;

                            $img = Image::make($request->file('product_image')->getRealPath());
                                // $img->resize(140, 200, function ($constraint) {
                                $img->resize(236, 236, function ($constraint) {
                                $constraint->aspectRatio();
                            })->save($this->product_image_base_img_path.$file_name);

                                $img2 = Image::make($request->file('product_image')->getRealPath());
                                // $img2->resize(200, 300, function ($constraint) {
                                $img2->resize(1000, 1000, function ($constraint) {
                                $constraint->aspectRatio();
                            })->save($this->product_image_thumb_base_img_path.$file_name);


                            $unlink_old_img_path    = $this->product_image_base_img_path.'/'.$request->input('old_img');
                            $unlink_old_thumb_img_path    = $this->product_image_thumb_base_img_path.'/'.$request->input('old_img');
                        

                }//if duplicate image new
                else
                {
                          
                        if($request->input('old_img') && file_exists(base_path().'/uploads/product_images/'.$request->input('old_img')))  
                        {
                            $file_name = rand(10,100).$request->input('old_img'); 
                            $destinationPath=$this->product_image_base_img_path.$file_name;
                            $destinationPaththumb=$this->product_image_thumb_base_img_path.$file_name;

                            $success = copy($this->product_image_base_img_path.$request->input('old_img'),$destinationPath);
                             $successcp = copy($this->product_image_thumb_base_img_path.$request->input('old_img'),$destinationPaththumb);
                        } //if
                        else
                        {
                            $file_name = $request->input('old_img'); 
                        } 
                      

                }//else



                //img upload for additional product image

            /*    if($request->hasFile('product_additional_image'))
                {   
                    $file = $request->file('product_additional_image');
                    $extension  = strtolower($file->getClientOriginalExtension());
                    $size  = $file->getClientSize();
                   
                    $additional_img   = uniqid(rand(11111,99999)).'.'.$extension;

                    $image1      = Image::make($file);
                    //$image1->resize(346,268);
                    $image1->save($this->add_product_image_base_img_path.'/'.$additional_img);

                    $unlink_old_img_path = $this->add_product_image_base_img_path.'/'.$request->input('old_additional_product_img');
                                    
                    if(file_exists($unlink_old_img_path))
                    {
                        @unlink($unlink_old_img_path);  
                    }
                } 
                else
                {
                    $additional_img = $request->input('old_additional_product_img');
                }

            
                $productlist->additional_product_image  = $additional_img;*/ 
                    
         }//if duplicate
         else
         {
                    if($request->hasfile('product_image'))
                    {
                        $image_data=[];

                       
                            $file_name = $request->input('product_image');

                            $file_extension = strtolower($request->file('product_image')->getClientOriginalExtension()); 

                            $file_name = sha1(uniqid().$request->file('product_image').uniqid()).'.'.$file_extension;

                            $img = Image::make($request->file('product_image')->getRealPath());
                                // $img->resize(140, 200, function ($constraint) {
                                $img->resize(236, 236, function ($constraint) {
                                $constraint->aspectRatio();
                            })->save($this->product_image_base_img_path.$file_name);

                                $img2 = Image::make($request->file('product_image')->getRealPath());
                                // $img2->resize(200, 300, function ($constraint) {
                                $img2->resize(1000, 1000, function ($constraint) {
                                $constraint->aspectRatio();
                            })->save($this->product_image_thumb_base_img_path.$file_name);


                            $unlink_old_img_path    = $this->product_image_base_img_path.'/'.$request->input('old_img');
                            $unlink_old_thumb_img_path    = $this->product_image_thumb_base_img_path.'/'.$request->input('old_img');
                        
                            if(file_exists($unlink_old_img_path))
                            {
                                @unlink($unlink_old_img_path);  
                            } 
                             if(file_exists($unlink_old_thumb_img_path))
                            {
                                @unlink($unlink_old_thumb_img_path);  
                            }     

                     }
                     else
                     {
                        $file_name = $request->input('old_img');            
                     }

/*
                    if($request->hasFile('product_additional_image'))
                    {   
                        $file = $request->file('product_additional_image');
                        $extension  = strtolower($file->getClientOriginalExtension());
                        $size  = $file->getClientSize();
                       
                        $additional_img   = uniqid(rand(11111,99999)).'.'.$extension;

                        $image1      = Image::make($file);
                        //$image1->resize(346,268);
                        $image1->save($this->add_product_image_base_img_path.'/'.$additional_img);

                        $unlink_old_img_path = $this->add_product_image_base_img_path.'/'.$request->input('old_additional_product_img');
                                        
                        if(file_exists($unlink_old_img_path))
                        {
                            @unlink($unlink_old_img_path);  
                        }
                    } 
                    else
                    {
                        $additional_img = $request->input('old_additional_product_img');
                    }

            
            $productlist->additional_product_image  = $additional_img; 
*/


         }//else of duplicate



         /* code commented at 2 july 20
         if($request->hasfile('product_image'))
         {
            $image_data=[];

           
                $file_name = $request->input('product_image');

                $file_extension = strtolower($request->file('product_image')->getClientOriginalExtension()); 

                $file_name = sha1(uniqid().$request->file('product_image').uniqid()).'.'.$file_extension;

                $img = Image::make($request->file('product_image')->getRealPath());
                    // $img->resize(140, 200, function ($constraint) {
                    $img->resize(236, 236, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($this->product_image_base_img_path.$file_name);

                    $img2 = Image::make($request->file('product_image')->getRealPath());
                    // $img2->resize(200, 300, function ($constraint) {
                    $img2->resize(1000, 1000, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($this->product_image_thumb_base_img_path.$file_name);


                $unlink_old_img_path    = $this->product_image_base_img_path.'/'.$request->input('old_img');
                $unlink_old_thumb_img_path    = $this->product_image_thumb_base_img_path.'/'.$request->input('old_img');
            
                if(file_exists($unlink_old_img_path))
                {
                    @unlink($unlink_old_img_path);  
                } 
                 if(file_exists($unlink_old_thumb_img_path))
                {
                    @unlink($unlink_old_thumb_img_path);  
                }     

         }
         else
         {
            $file_name = $request->input('old_img');            
         }*/
         /****************************************************************/

         /*************************start of certificate*******************/

           if(isset($form_data['duplicate']) && $form_data['duplicate']==1)
           {
                 if($request->hasfile('product_certificate'))
                 {

                     $file_certificate_name = $request->input('product_certificate');
                     $file_extension = strtolower($request->file('product_certificate')->getClientOriginalExtension()); 

                    $file_certificate_name = sha1(uniqid().$request->file('product_certificate').uniqid()).'.'.$file_extension;

                     if($file_extension=="pdf")
                    {
                       $request->file('product_certificate')->move($this->product_image_base_img_path,$file_certificate_name);
                    }
                    else
                    {
                            $img = Image::make($request->file('product_certificate')->getRealPath());
                                // $img->resize(140, 200, function ($constraint) {
                                $img->resize(236, 236, function ($constraint) {
                                $constraint->aspectRatio();
                            })->save($this->product_image_base_img_path.$file_certificate_name);

                                $img2 = Image::make($request->file('product_certificate')->getRealPath());
                                // $img2->resize(200, 300, function ($constraint) {
                                $img2->resize(473, 473, function ($constraint) {
                                $constraint->aspectRatio();
                            })->save($this->product_image_thumb_base_img_path.$file_certificate_name);

                    }// else of not image 
                    $unlink_old_img_path_certi    = $this->product_image_base_img_path.'/'.$request->input('old_product_certificate');
                    $unlink_old_thumb_img_path_certi    = $this->product_image_thumb_base_img_path.'/'.$request->input('old_product_certificate');
                
                       /* if(file_exists($unlink_old_img_path_certi))
                        {
                            @unlink($unlink_old_img_path_certi);  
                        } 
                         if(file_exists($unlink_old_thumb_img_path_certi))
                        {
                            @unlink($unlink_old_thumb_img_path_certi);  
                        } */    

                 }//if product certificate new selected
                 else
                 {
                         if($request->input('old_product_certificate') && file_exists(base_path().'/uploads/product_images/'.$request->input('old_product_certificate')))  
                        {
                            $file_certificate_name = rand(10,100).$request->input('old_product_certificate'); 
                            $destinationPath=$this->product_image_base_img_path.$file_certificate_name;

                            $success = copy($this->product_image_base_img_path.$request->input('old_product_certificate'),$destinationPath);
                            
                        } //if
                        else
                        {
                            $file_certificate_name = $request->input('old_product_certificate'); 
                        } 
                 }//else of if old ceritificate then copy   

                   $productlist->product_certificate  = $file_certificate_name;

           }//if duplicated
           else
           {
                if($request->hasfile('product_certificate'))
                 {

                     $file_certificate_name = $request->input('product_certificate');
                     $file_extension = strtolower($request->file('product_certificate')->getClientOriginalExtension()); 

                    $file_certificate_name = sha1(uniqid().$request->file('product_certificate').uniqid()).'.'.$file_extension;

                     if($file_extension=="pdf")
                    {
                   
                       $request->file('product_certificate')->move($this->product_image_base_img_path,$file_certificate_name);

                    }
                    else
                    {

                            $img = Image::make($request->file('product_certificate')->getRealPath());
                                // $img->resize(140, 200, function ($constraint) {
                                $img->resize(236, 236, function ($constraint) {
                                $constraint->aspectRatio();
                            })->save($this->product_image_base_img_path.$file_certificate_name);

                                $img2 = Image::make($request->file('product_certificate')->getRealPath());
                                // $img2->resize(200, 300, function ($constraint) {
                                $img2->resize(473, 473, function ($constraint) {
                                $constraint->aspectRatio();
                            })->save($this->product_image_thumb_base_img_path.$file_certificate_name);

                    }// else of not image 

                    $unlink_old_img_path_certi    = $this->product_image_base_img_path.'/'.$request->input('old_product_certificate');
                    $unlink_old_thumb_img_path_certi    = $this->product_image_thumb_base_img_path.'/'.$request->input('old_product_certificate');
                
                    if(file_exists($unlink_old_img_path_certi))
                    {
                        @unlink($unlink_old_img_path_certi);  
                    } 
                     if(file_exists($unlink_old_thumb_img_path_certi))
                    {
                        @unlink($unlink_old_thumb_img_path_certi);  
                    }     

                 }//if product certificate
                 else
                 {
                    $file_certificate_name = $request->input('old_product_certificate');            
                 }//else
                 $productlist->product_certificate  = $file_certificate_name;

           } //else of duplicate 






           /*  //commented on 4july20
           if($request->hasfile('product_certificate'))
            {

           
                $file_certificate_name = $request->input('product_certificate');

                $file_extension = strtolower($request->file('product_certificate')->getClientOriginalExtension()); 

                $file_certificate_name = sha1(uniqid().$request->file('product_certificate').uniqid()).'.'.$file_extension;

                 if($file_extension=="pdf")
                {
                 // $request->file('product_certificate')->move($this->product_image_base_img_path.$file_certificate_name);
                   $request->file('product_certificate')->move($this->product_image_base_img_path,$file_certificate_name);

                }
                else
                {

                    $img = Image::make($request->file('product_certificate')->getRealPath());
                        // $img->resize(140, 200, function ($constraint) {
                        $img->resize(236, 236, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($this->product_image_base_img_path.$file_certificate_name);

                        $img2 = Image::make($request->file('product_certificate')->getRealPath());
                        // $img2->resize(200, 300, function ($constraint) {
                        $img2->resize(473, 473, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($this->product_image_thumb_base_img_path.$file_certificate_name);

                }// else of not image 


                $unlink_old_img_path_certi    = $this->product_image_base_img_path.'/'.$request->input('old_product_certificate');
                $unlink_old_thumb_img_path_certi    = $this->product_image_thumb_base_img_path.'/'.$request->input('old_product_certificate');
            
                if(file_exists($unlink_old_img_path_certi))
                {
                    @unlink($unlink_old_img_path_certi);  
                } 
                 if(file_exists($unlink_old_thumb_img_path_certi))
                {
                    @unlink($unlink_old_thumb_img_path_certi);  
                }     

         }
         else
         {
            $file_certificate_name = $request->input('old_product_certificate');            
         }

         $productlist->product_certificate  = $file_certificate_name; */
        /********************end of certificate************************/    


        if ($is_update_process == true) {


            $old_product_stock = isset($form_data['old_product_stock'])?$form_data['old_product_stock']:'';

            if($old_product_stock != $productlist->product_stock)
            {


               // $product_stock = $productlist->product_stock + $old_product_stock;
                $product_stock = $productlist->product_stock; 

                $this->ProductInventoryModel->where('product_id',$id)->update(['remaining_stock'=>$product_stock]);


               /******************* Notification START* For Update Stock *************************/

                    $from_user_id = 0;
                    $admin_id     = 0;
                    $user_name    = "";

                    if(Sentinel::check())
                    {
                        $user_details = Sentinel::getUser();
                        $from_user_id = $user_details->id;

                        $f_name = isset($user_details->first_name)?$user_details->first_name:'';
                        $l_name = isset($user_details->last_name)?$user_details->last_name:'';

                        $user_name    = $f_name.' '.$l_name;
                    }

                    $admin_role = Sentinel::findRoleBySlug('admin');        
                    $admin_obj = \DB::table('role_users')->where('role_id',$admin_role->id)->first();
                    if($admin_obj)
                    {
                        $admin_id = $admin_obj->user_id;            
                    }

                    $product_url     = url('/').'/'.config('app.project.admin_panel_slug').'/product/view/'.base64_encode($productlist->id);

                    //$trade_ref = isset($trade->trade_ref)?$trade->trade_ref:'';

                    $arr_event                 = [];
                    $arr_event['from_user_id'] = $from_user_id;
                    $arr_event['to_user_id']   = $admin_id;
                    $arr_event['description']      = html_entity_decode('Dispensary <b>'.$user_name.'</b> has updated the stock for the product <b><a target="_blank" href="'.$product_url.'">'.$productlist->product_name.'</a></b> <br><b>Updated Stock: </b>'.$productlist->product_stock);
                   // $arr_event['url']          = $url;
                    $arr_event['type']         = '';
                    $arr_event['title']        = 'Product Stock Updated By Dispensary';

                    $this->GeneralService->save_notification($arr_event);

                /*******************Notification END***************************/

                /**************Send Mail Notification to Admin (START)*******************/
                    /*$msg    = html_entity_decode('Dispensary <b>'.$user_name.'</b> has updated the stock for the product <b>'.$productlist->product_name.'</b>. <br><b>Updated Stock:</b> '.$productlist->product_stock);
                    */


                    $product_url     = url('/').'/'.config('app.project.admin_panel_slug').'/product/view/'.base64_encode($productlist->id);
                    //$subject     = 'Product Stock Updated By Dispensary';

                    $arr_built_content = ['USER_NAME'     => config('app.project.admin_name'),
                                          'APP_NAME'      => config('app.project.name'),
                                          //'MESSAGE'       => $msg,
                                          'SELLER_NAME'   => $user_name,
                                          'PRODUCT_NAME'  => $productlist->product_name,
                                          'PRODUCT_STOCK' => $productlist->product_stock,
                                          'URL'           => $product_url
                                         ];

                    $arr_mail_data['email_template_id'] = '84';
                    $arr_mail_data['arr_built_content'] = $arr_built_content;
                    $arr_mail_data['arr_built_subject'] = '';
                    $arr_mail_data['user']              = Sentinel::findById($admin_id);

                    $this->EmailService->send_mail_section($arr_mail_data);

                /**************Send Mail Notification to Admin (END)*********************/

            }// if old product stock and current stock value not same then update
 
        }


        $user = Sentinel::check();        

        if ($is_update_process == false) {
            // if insert product
            if($user->inRole('admin')==true)
            {
               $productlist->is_active=1;
               $productlist->is_approve=1;
            }else if($user->inRole('seller')==true){
               $productlist->is_active=$is_active;
              // $productlist->is_approve=1;  // approve 
               $productlist->is_approve=0;    // disapprove
            }
       }else if($is_update_process==true)
       {    //if update product
            if($user->inRole('seller')==true)
            {

               // $productlist->is_active=$is_active;
                    
               //old code
                    
               /* if($old_product_stock != $productlist->product_stock)
                {
                    $productlist->is_approve=0; 
                }

               $productlist->is_approve=0;   

               if(isset($productlist->price_drop_changed) && $productlist->price_drop_changed >0 && $productlist->price_drop_changed==1)
               {
                  $productlist->is_approve=1;
               }

               else if(isset($productlist->price_drop_changed) && $productlist->price_drop_changed >0 && $productlist->price_drop_changed==0)
               {
                  $productlist->is_approve=0;
               }*/



               /*-----------check price drop value and other fields (new code)--------------------------*/

               if(isset($productlist->price_drop_changed) && $productlist->price_drop_changed == 1 && 

                (isset($form_data['product_name_flag']) && $form_data['product_name_flag'] == 1 ||
                 isset($form_data['sku_flag']) && $form_data['sku_flag'] == 1 ||
                 isset($form_data['brand_flag']) && $form_data['brand_flag'] == 1 ||
                 isset($form_data['category_flag']) && $form_data['category_flag'] == 1 ||
                 isset($form_data['sub_category_flag']) && $form_data['sub_category_flag'] == 1 ||
                 isset($form_data['price_flag']) && $form_data['price_flag'] == 1 ||
                 
                 isset($form_data['shipping_type_flag']) && $form_data['shipping_type_flag'] == 1 ||
                 isset($form_data['shipping_duration_flag']) && $form_data['shipping_duration_flag'] == 1 ||
                 isset($form_data['stock_flag']) && $form_data['stock_flag'] == 1 ||
                 isset($form_data['concentration_flag']) && $form_data['concentration_flag'] == 1 ||
                 isset($form_data['spectrum_flag']) && $form_data['spectrum_flag'] == 1 ||
                 isset($form_data['description_flag']) && $form_data['description_flag'] == 1 ||
                 isset($form_data['certificate_flag']) && $form_data['certificate_flag'] == 1 ||
                 isset($form_data['drop_shipper_name_flag']) && $form_data['drop_shipper_name_flag'] == 1 ||
                 isset($form_data['drop_shipper_email_flag']) && $form_data['drop_shipper_email_flag'] == 1 ||
                 isset($form_data['drop_shipper_product_price_flag']) && $form_data['drop_shipper_product_price_flag'] == 1 ||
                 isset($form_data['product_video_source_flag']) && $form_data['product_video_source_flag'] == 1 ||
                 isset($form_data['product_video_url_flag']) && $form_data['product_video_url_flag'] == 1 ||

                 isset($form_data['shipping_charges_flag']) && $form_data['shipping_charges_flag'] == 1 ||


                 isset($form_data['ingredients_flag']) && $form_data['ingredients_flag'] == 1 ||

                 isset($form_data['suggested_use_flag']) && $form_data['suggested_use_flag'] == 1 ||

                 isset($form_data['terpenes_flag']) && $form_data['terpenes_flag'] == 1 ||

                 isset($form_data['amount_per_serving_flag']) && $form_data['amount_per_serving_flag'] == 1 ||
                 /*isset($form_data['additional_product_img_flag']) && $form_data['additional_product_img_flag'] == 1 ||
              */   
                 isset($form_data['prev_sel_cannabinoids_flag']) && $form_data['prev_sel_cannabinoids_flag'] == 1 

                ))
                {
                     
                  // $productlist->is_approve = 0; //previous condition

                 //If previous status is pending and user changed the price drop and another field is also changed then product will be pending
                     if($productlist->is_approve==0)
                     {
                        $productlist->is_approve = 0;
                     } 
                     else if($productlist->is_approve==1)
                     {
                        // If previous status is approved and user changed the price drop and another field is also changed then product will be pending
                        $productlist->is_approve = 0;
                     }
                     else
                     {
                        $productlist->is_approve = 0;
                     }



                }
                else if(isset($productlist->price_drop_changed) && $productlist->price_drop_changed == 1 && 

                (isset($form_data['product_name_flag']) && $form_data['product_name_flag'] == 0 ||
                 isset($form_data['sku_flag']) && $form_data['sku_flag'] == 0 ||
                 isset($form_data['brand_flag']) && $form_data['brand_flag'] == 0 ||
                 isset($form_data['category_flag']) && $form_data['category_flag'] == 0 ||
                 isset($form_data['sub_category_flag']) && $form_data['sub_category_flag'] == 0 ||
                 isset($form_data['price_flag']) && $form_data['price_flag'] == 0 ||
                 
                 isset($form_data['shipping_type_flag']) && $form_data['shipping_type_flag'] == 0 ||
                 isset($form_data['shipping_duration_flag']) && $form_data['shipping_duration_flag'] == 0 ||
                 isset($form_data['stock_flag']) && $form_data['stock_flag'] == 0 ||
                 isset($form_data['concentration_flag']) && $form_data['concentration_flag'] == 0 ||
                 isset($form_data['spectrum_flag']) && $form_data['spectrum_flag'] == 0 ||
                 isset($form_data['description_flag']) && $form_data['description_flag'] == 0 ||
                 isset($form_data['certificate_flag']) && $form_data['certificate_flag'] == 0 ||
                 isset($form_data['drop_shipper_name_flag']) && $form_data['drop_shipper_name_flag'] == 0 ||
                 isset($form_data['drop_shipper_email_flag']) && $form_data['drop_shipper_email_flag'] == 0 ||
                 isset($form_data['drop_shipper_product_price_flag']) && $form_data['drop_shipper_product_price_flag'] == 0 ||
                 isset($form_data['product_video_source_flag']) && $form_data['product_video_source_flag'] == 0 ||
                 isset($form_data['product_video_url_flag']) && $form_data['product_video_url_flag'] == 0 ||

                 isset($form_data['shipping_charges_flag']) && $form_data['shipping_charges_flag'] == 0 ||

                 isset($form_data['ingredients_flag']) && $form_data['ingredients_flag'] == 0 ||

                 isset($form_data['suggested_use_flag']) && $form_data['suggested_use_flag'] == 0 ||

                 isset($form_data['terpenes_flag']) && $form_data['terpenes_flag'] == 0 ||
                 
                 isset($form_data['amount_per_serving_flag']) && $form_data['amount_per_serving_flag'] == 0 ||
                /* isset($form_data['additional_product_img_flag']) && $form_data['additional_product_img_flag'] == 0 ||
*/
                 isset($form_data['prev_sel_cannabinoids_flag']) && $form_data['prev_sel_cannabinoids_flag'] == 0
                   
                ))
                {
                   // $productlist->is_approve = 1; // Previous condition
                    
                    //if user only change the price drop and previous status is pending then pending
                    if($productlist->is_approve==0)
                    {
                        $productlist->is_approve = 0;
                    }
                    else if($productlist->is_approve==1)
                    { 
                         //if user only change the price drop and previous status is approved then approve    
                        $productlist->is_approve = 1;
                    }
                    else
                    {
                        $productlist->is_approve = 0;
                    }
                    
                }
                else
                { 
                    
                    $productlist->is_approve = 0;
                }

               /*------------------------------------------------------------------------------*/



            }



       }









       /******************subscripition*************************/
       /*$user_subscried = 0;
        if ($user->subscribed('main')) {
            $user_subscried = 1;

        }else{
          $user_subscried =0;
        }
        $user_subscriptiontabledata = $this->UserSubscriptionsModel->with('get_membership_details')->where('user_id',$user->id)->where('membership_status','1')->get();
         if(isset($user_subscriptiontabledata) && !empty($user_subscriptiontabledata))
         {
          $user_subscriptiontabledata = $user_subscriptiontabledata->toArray();
         }

          $get_cancelmembershipdata = $this->UserSubscriptionsModel->with('get_membership_details')
                    ->where('user_id',$user->id)
                    ->where('membership_status','0')
                    ->where('is_cancel','1')
                    ->orderBy('id','desc')
                    ->first(); 
          if(isset($get_cancelmembershipdata) && !empty($get_cancelmembershipdata))
          {
            $get_cancelmembershipdata = $get_cancelmembershipdata->toArray();
            
          }          

            $res_active_product = $this->ProductModel->with('first_level_category_details')
                                          ->where('is_active','1')
                                          ->where('user_id',$user->id)
                                          ->get()->count();

          if($user_subscried=="1" && isset($user_subscriptiontabledata) && !empty($user_subscriptiontabledata))
          {

          }    */                             

       /******************subscripition**********************/

        $productlist->save(); 

        /* Insert or update product cannaboinoid*/
         // dd($is_update_process);
          if ($is_update_process == true) {
            // Update
            if(isset($form_data['sel_cannabinoids']) && count($form_data['sel_cannabinoids']) > 0 )
            {

                if($spectrum=="1" || $spectrum=="2" || $spectrum=="3") {
                        foreach($form_data['sel_cannabinoids'] as $k => $cannaboinoid_data)
                        {
                            $cann_percent = isset($form_data['txt_percent'][$k]) ? $form_data['txt_percent'][$k] : 0;
                            $cann_id = isset($cannaboinoid_data) ? $cannaboinoid_data : 0;
                            $insert_arr = array(
                                    'product_id'=>$productlist->id,
                                    'cannabinoids_id'=>$cann_id,
                                    'percent'=>$cann_percent
                                );
                            
                            if(isset($form_data['hid_product_can_id']) && isset($form_data['hid_product_can_id'][$k]) && $form_data['hid_product_can_id'][$k] != ""){
                                        $product_cannabio = $this->ProductCannabinoidsModel
                                                                 ->where('id',$form_data['hid_product_can_id'][$k])
                                                                 ->update($insert_arr);

                            }  else {
                                $product_cannabio = $this->ProductCannabinoidsModel->create($insert_arr);
                            }
                        }
               } else {
                    $this->ProductCannabinoidsModel->where('product_id',$productlist->id)->delete(); 
               }

            } 
          } else {
            //dd($form_data['sel_cannabinoids']);
            if(isset($form_data['sel_cannabinoids']) && count($form_data['sel_cannabinoids']) > 0 )
            {

                 if($spectrum=="1" || $spectrum=="2" || $spectrum=="3") {
                        foreach($form_data['sel_cannabinoids'] as $k => $cannaboinoid_data)
                        {
                            $cann_percent = isset($form_data['txt_percent'][$k]) ? $form_data['txt_percent'][$k] : 0;
                            $cann_id = isset($cannaboinoid_data) ? $cannaboinoid_data : 0;
                            $insert_arr = array(
                                    'product_id'=>$productlist->id,
                                    'cannabinoids_id'=>$cann_id,
                                    'percent'=>$cann_percent
                                );


                            $product_cannabio = $this->ProductCannabinoidsModel->create($insert_arr);
                        }
                    }

            } 
          }
         /*Ends*/

        //Update price_drop_changed to 0
       $price_drop_flag_changed_to_1 =  $this->ProductModel->where('id',$id)->update(array('price_drop_changed'=>0));


         /*******************dropshipper code*****************************/
        $dropshipperid = $seller_id = $logged_in_user_id = "";

        if($drop_shipper_email)
        {
            $user = Sentinel::check();
            if($user)
            {
               $logged_in_user_id = $user->id;  
               if($logged_in_user_id==1)
               {
                  $seller_id = isset($form_data['user_id'])?$form_data['user_id']:'';
               }
               else
               {
                 $seller_id  = $logged_in_user_id;
               } 
            }

            /*$res_drop_shipper = $this->DropShipperModel
            ->select('*')
            //->where('email',$drop_shipper_email)
            ->where('product_id',$productlist->id)
            ->get()->toArray();
            
            if(!empty($res_drop_shipper))
            {

               $dropshipperid = $res_drop_shipper[0]['id'];

                $resupdatedropshipper = [];
                $resupdatedropshipper['product_price'] = $drop_shipper_product_price;
                $updatedrop = DB::table('drop_shipper')->where('id',$dropshipperid)->update($resupdatedropshipper);              
              
            }else{
              $dropshipperid = DB::table('drop_shipper')-> insertGetId(array(
                  'seller_id'=> $seller_id,
                  'name' => $drop_shipper_name,
                  'email'=> $drop_shipper_email,
                  'product_price'=> $drop_shipper_product_price,
                  'product_id'=>$productlist->id
                ));  
            }*/

             $res_drop_shipper = $this->ProductModel
            ->select('drop_shipper')
            ->where('id',$productlist->id)
            ->first();
           
            
            if(isset($res_drop_shipper) && !empty($res_drop_shipper))
            {
               $res_drop_shipper =  $res_drop_shipper->toArray();
               

               $check_drop_shipper = $this->DropShipperModel
                ->select('*')
                 ->where('name',$drop_shipper_name)
                 ->where('email',$drop_shipper_email)
                 ->where('product_id',$productlist->id)
                ->first();

                

                if(isset($check_drop_shipper) && !empty($check_drop_shipper))
                {
                  $check_drop_shipper =  $check_drop_shipper->toArray();


                     $dropshipperid = $check_drop_shipper['id'];
                    

                    $resupdatedropshipper = [];
                    $resupdatedropshipper['product_price'] = $drop_shipper_product_price;
                    
                    $updatedrop = DB::table('drop_shipper')->where('id',$dropshipperid)->update($resupdatedropshipper);              
                }
                else
                {
                     $dropshipperid = DB::table('drop_shipper')-> insertGetId(array(
                      'seller_id'    => $seller_id,
                      'name'         => $drop_shipper_name,
                      'email'        => $drop_shipper_email,
                      'product_price'=> $drop_shipper_product_price,
                      'product_id'   => $productlist->id
                    ));  


                    //send mail to the drop shipper

                    $product_url = url('/').'/search/product_detail/'.base64_encode($productlist->id); 


                    $arr_built_content = ['USER_NAME'     => $drop_shipper_name,
                                          'APP_NAME'      => config('app.project.name'),
                                          'PRODUCT_NAME'  => $productlist->product_name,  
                                          'PRODUCT_URL'   => $product_url
                                         ];

                    $user_details = [ 'email'      => $drop_shipper_email,
                                      'first_name' => $drop_shipper_name
                                    ];                      

                    $arr_mail_data['email_template_id']   = '133';
                    $arr_mail_data['arr_built_content']   = $arr_built_content;
                    $arr_mail_data['arr_built_subject']   = '';
                    $arr_mail_data['user']                = $user_details;

                    $this->EmailService->send_mail_section($arr_mail_data);
                }

             
            }else{
                    $dropshipperid = DB::table('drop_shipper')-> insertGetId(array(
                        'seller_id'    => $seller_id,
                        'name'         => $drop_shipper_name,
                        'email'        => $drop_shipper_email,
                        'product_price'=> $drop_shipper_product_price,
                        'product_id'   =>$productlist->id
                    )); 

                //send mail to the drop shipper 

                $product_url = url('/').'/search/product_detail/'.base64_encode($productlist->id); 


                $arr_built_content = [  'USER_NAME'     => $drop_shipper_name,
                                        'APP_NAME'      => config('app.project.name'),
                                        'PRODUCT_NAME'  => $productlist->product_name,  
                                        'PRODUCT_URL'   => $product_url
                                    ];

                $user_details = [ 'email'       => $drop_shipper_email,
                                  'first_name'  => $drop_shipper_name
                                ];                    

                $arr_mail_data['email_template_id']   = '133';
                $arr_mail_data['arr_built_content']   = $arr_built_content;
                $arr_mail_data['arr_built_subject']   = '';
                $arr_mail_data['user']                = $user_details;

                $this->EmailService->send_mail_section($arr_mail_data);
            }


        }   


         $product_dropship = $this->ProductModel->firstOrNew(['id'=> $productlist->id]);
         $product_dropship->drop_shipper = $dropshipperid;
         $product_dropship->save();





        /****************end dropshipper*code****************************/



         if ($is_update_process == false)
        {
             $user_details = Sentinel::getUser();
             $loguser_id = $user_details->id;

            $dbproduct_count =  $user_details->product_count;
            $update_productcount_arr = [
                          'product_count' => $dbproduct_count+1
                            ];
            $this->UserModel->where('id',$loguser_id)->update($update_productcount_arr);   
        }

        if ($is_update_process == false) // add
        {     

            $this->ProductInventoryModel->create(['product_id'=>$productlist->id,'remaining_stock'=>$productlist->product_stock]);
 
            $i = $cnt ="";

              if(isset($product_dimension_arr) && !empty($product_dimension_arr)>0)
             {
             
                $cnt =  count($product_dimension_arr);
                $i   =  0;

               foreach($product_dimension_arr as $dimen){
             
                $arr = array('product_id'=>$productlist->id,'option_type'=>$dimen,'option'=>$product_dimension_value_arr[$i]);
                if(!empty($product_dimension_value_arr[$i])){
                    $product_dimension       = $dimen;
                    $product_dimension_value = $product_dimension_value_arr[$i];
                   $is_inserted =  $this->ProductDimensionsModel->create($arr);
                 }
                 $i++;
               }
             } 


             if($user->inRole('seller')==true){

               /******************* Notification START* For add product *************************/

                $from_user_id = 0;
                $admin_id     = 0;
                $user_name    = "";

                if(Sentinel::check())
                {
                    $user_details = Sentinel::getUser();
                    $from_user_id = $user_details->id;
                  
                    $f_name = isset($user_details->first_name)?$user_details->first_name:'';
                    $l_name = isset($user_details->last_name)?$user_details->last_name:'';

                    $user_name    = $f_name.' '.$l_name;
                }

                $admin_role = Sentinel::findRoleBySlug('admin');        
                $admin_obj = \DB::table('role_users')->where('role_id',$admin_role->id)->first();
                if($admin_obj)
                {
                    $admin_id = $admin_obj->user_id;            
                }

                $url = url(config('app.project.admin_panel_slug')."/product/").base64_encode($from_user_id);

                $product_url     = url('/').'/'.config('app.project.admin_panel_slug').'/product/view/'.base64_encode($productlist->id);

                $arr_event                 = [];
                $arr_event['from_user_id'] = $from_user_id;
                $arr_event['to_user_id']   = $admin_id;
                $arr_event['description']  = html_entity_decode('Dispensary <b>'.$user_name.'</b> has added new product <b><a target="_blank" href="'.$product_url.'">'.$productlist->product_name.'</a></b>');
               // $arr_event['url']        = $url;
                $arr_event['type']         = '';
                $arr_event['title']        = 'Product Added By Dispensary';

                $this->GeneralService->save_notification($arr_event);

            /*******************Notification END for add product***************************/ 

            /**************Send Mail Notification to Admin (START)*******************/
                //$msg    = html_entity_decode('Dispensary <b>'.$user_name.'</b> has added new product <b>'.$productlist->product_name.'</b>.');

                $product_url     = url('/').'/'.config('app.project.admin_panel_slug').'/product/view/'.base64_encode($productlist->id);
                //$subject     = 'Product Added By Dispensary';

                $arr_built_content = ['USER_NAME'     => config('app.project.admin_name'),
                                      'APP_NAME'      => config('app.project.name'),
                                      //'MESSAGE'     => $msg,
                                      'SELLER_NAME'   => $user_name,
                                      'PRODUCT_NAME'  => $productlist->product_name,  
                                      'URL'           => $product_url
                                     ];

                $arr_mail_data['email_template_id']   = '85';
                $arr_mail_data['arr_built_content']   = $arr_built_content;
                $arr_mail_data['arr_built_subject']   = '';
                $arr_mail_data['user']                = Sentinel::findById($admin_id);

                $this->EmailService->send_mail_section($arr_mail_data);

            /**************Send Mail Notification to Admin (END)*********************/
                       
                        /***************start of eventdata**for newproduct*******/
                       /* $arr_eventdata             = [];
                        $arr_eventdata['user_id']  = $from_user_id;
                        $arr_eventdata['message']  = html_entity_decode('Seller <b>'.$user_name.'</b> has added new product <b>'.$productlist->product_name.'</b>');
                        $arr_eventdata['title']    = 'Product Added By Seller';             
                        $this->EventModel->create($arr_eventdata);*/
                        /***************end of eventdata**for newproduct*******/

             }//ifin role seller
            else if($user->inRole('admin')==true)
            {
                if(Sentinel::check())
                {
                    $user_details = Sentinel::getUser();
                    $from_user_id = $user_details->id;
                  
                    $f_name = isset($user_details->first_name)?$user_details->first_name:'';
                    $l_name = isset($user_details->last_name)?$user_details->last_name:'';

                    $user_name    = $f_name.' '.$l_name;
                }

               /***************start of eventdata**for newproduct*******/
              /*  $arr_eventdata             = [];
                $arr_eventdata['user_id']  = $from_user_id;
                $arr_eventdata['message']  = html_entity_decode(' <b>'.$user_name.'</b> has added new product <b>'.$productlist->product_name.'</b>');
                $arr_eventdata['title']    = 'Product Added By Admin';             
                $this->EventModel->create($arr_eventdata);*/
                /***************end of eventdata**for newproduct*******/
            }



        }//if add
        else{ // update
            // added new condition for old stock and new stock not same at edit
               $i=$cnt="";
               $is_product_dimensions_exists = $this->ProductDimensionsModel->where('product_id',$productlist->id)->count(); 

               if($is_product_dimensions_exists >0)
               { 
                $delete_previous_records     = $this->ProductDimensionsModel->where('product_id',$productlist->id)->delete(); 
               } 

              //if($product_dimension_arr!=null && sizeof($product_dimension_arr)>0)
              if(isset($product_dimension_arr) && !empty($product_dimension_arr))
             {

                $cnt =  count($product_dimension_arr);
                $i   =  0;

               foreach($product_dimension_arr as $dimen){
             
                $arr = array('product_id'=>$productlist->id,'option_type'=>$dimen,'option'=>$product_dimension_value_arr[$i]);
                if(!empty($product_dimension_value_arr[$i])){
                    $product_dimension       = $dimen;
                    $product_dimension_value = $product_dimension_value_arr[$i];
                   $is_inserted =  $this->ProductDimensionsModel->create($arr);
                 }
                 $i++;
              }
             } 


            if($old_product_stock != $productlist->product_stock)
            {

                    $product_inventory = $this->ProductInventoryModel->firstOrNew(['product_id'=> $productlist->id]);
                   
                    $product_inventory->product_id = $productlist->id;
                    $product_inventory->remaining_stock = $product_stock;
                    $product_inventory->save();
           }

           /***************send noti and email to admin ***********************/
           if($user->inRole('seller')==true)
            {
                $from_user_id = 0;
                $admin_id     = 0;
                $user_name    = "";

                if(Sentinel::check())
                {
                    $user_details = Sentinel::getUser();
                    $from_user_id = $user_details->id;
                  
                    $f_name = isset($user_details->first_name)?$user_details->first_name:'';
                    $l_name = isset($user_details->last_name)?$user_details->last_name:'';

                    $user_name    = $f_name.' '.$l_name;
                }



                $admin_role = Sentinel::findRoleBySlug('admin');        
                $admin_obj = \DB::table('role_users')->where('role_id',$admin_role->id)->first();
                if($admin_obj)
                {
                    $admin_id = $admin_obj->user_id;            
                }

                $url = url(config('app.project.admin_panel_slug')."/product/").base64_encode($from_user_id);

                $product_url     = url('/').'/'.config('app.project.admin_panel_slug').'/product/view/'.base64_encode($productlist->id);

                $arr_event                 = [];
                $arr_event['from_user_id'] = $from_user_id;
                $arr_event['to_user_id']   = $admin_id;
                $arr_event['description']  = html_entity_decode('Dispensary <b>'.$user_name.'</b> has resubmitted the product <b><a target="_blank" href="'.$product_url.'">'.$productlist->product_name.'</a></b>');
               // $arr_event['url']        = $url;
                $arr_event['type']         = '';
                $arr_event['title']        = 'Product Resubmitted By Dispensary';

                $this->GeneralService->save_notification($arr_event);



                 /**************Send Mail Notification to Admin (START)*******************/
                //$msg    = html_entity_decode('Dispensary <b>'.$user_name.'</b> has resubmitted the  product <b>'.$productlist->product_name.'</b>.');

                $product_url     = url('/').'/'.config('app.project.admin_panel_slug').'/product/view/'.base64_encode($productlist->id);
                //$subject     = 'Product Resubmitted By Dispensary';

                $arr_built_content = ['USER_NAME'     => config('app.project.admin_name'),
                                      'APP_NAME'      => config('app.project.name'),
                                      //'MESSAGE'       => $msg,
                                      'SELLER_NAME'   => $user_name,
                                      'PRODUCT_NAME'  => $productlist->product_name,
                                      'URL'           => $product_url
                                     ];

                $arr_mail_data['email_template_id'] = '86';
                $arr_mail_data['arr_built_content'] = $arr_built_content;
                $arr_mail_data['arr_built_subject'] = '';
                $arr_mail_data['user']              = Sentinel::findById($admin_id);

                $this->EmailService->send_mail_section($arr_mail_data);

            /**************Send Mail Notification to Admin (END)*********************/


                /*************end of email and noti*****************************/
            }

          
        }

         $user_details = Sentinel::getUser();
         $loginuser_id = $user_details->id;

      /**************** code for uploading multiple images **************/   
      /*if(!empty($image_data) && count($image_data)>0)
       {
         foreach($image_data as $img){
            $arr['image']= $img;
            $arr['product_id']= $productlist->id;
            $arr['user_id'] = $loginuser_id;
            $this->ProductImagesModel->insert($arr);
         }         
       }*/

       $product_images = $this->ProductImagesModel->firstOrNew(['product_id'=> $productlist->id]);
       if($file_name!="" && isset($file_name))
       {
            $product_images->image= $file_name;
            $product_images->product_id= $productlist->id;
            $product_images->user_id = $loginuser_id;
            $product_images->save();
       }
       /*****************************************************************/




        /******code for price drop send noti to buyer *****/
            $unit_price = $form_data['unit_price'];
            $price_drop_to = $form_data['price_drop_to'];
            $old_price_drop = isset($form_data['old_price_drop'])?$form_data['old_price_drop']:'0';

           
            if((isset($price_drop_to) && $price_drop_to>0) && (isset($unit_price) && ($unit_price>0)))
            {
                if($unit_price==$price_drop_to)
                {

                }else if($price_drop_to<$unit_price && (isset($old_price_drop) && ($old_price_drop!=$price_drop_to)))
                {
                    $get_wishlist_records = $this->FavoriteModel->select('buyer_id')->where('product_id',$productlist->id)->get();
                    if(!empty($get_wishlist_records))
                    {
                        $get_wishlist_records = $get_wishlist_records->toArray();
                        if(!empty($get_wishlist_records))
                        {
                           $buyerids = array_column($get_wishlist_records,'buyer_id'); 
                           if(isset($buyerids)){
                              foreach($buyerids as $buyer){  
                                $this->send_noti_email_to_buyer($productlist->id,$buyer);
                              }
                           }
                        }//if get wishlist record
                    } //if get wishlist record not empty

                   /************If price drop then add eventdata*****/ 

                        $arr_eventdata             = [];
                        $arr_eventdata['user_id']  = $loginuser_id;
                           $get_product_name = $this->ProductModel
                                        // ->select('product_name','user_id')
                                         ->with(['product_images_details'])
                                         ->where('id',$productlist->id)
                                         ->first();

                              if(!empty($get_product_name) && isset($get_product_name))
                              {
                                  $get_product_name = $get_product_name->toArray();
                              }
                         
                               if(!empty($get_product_name['product_images_details']) 
                                                 && count($get_product_name['product_images_details'])  && file_exists(base_path().'/uploads/product_images/'.$get_product_name['product_images_details'][0]['image'])
                                                  && $get_product_name['product_images_details'][0]['image']!=''
                                             )
                               {
                                  /*$imgsrc = url('/').'/uploads/product_images/'.$get_product_name['product_images_details'][0]['image'];*/

                                  //image resize
                                  $imgsrc = image_resize('/uploads/product_images/'.$get_product_name['product_images_details'][0]['image'],35,35);

                               }else{
                                $imgsrc = url('/').'/assets/front/images/chow.png';
                               }  


                          $arr_eventdata['message']  = html_entity_decode('<div class="discription-marq">
                           <div class="mainmarqees-image">
                             <img src="'.$imgsrc.'" alt="">
                           </div><b>'.$productlist->product_name.'</b> just went on sale. <div class="clearfix"></div></div><a href="'.url('/').'/search/product_detail/'.base64_encode($productlist->id).'" target="_blank" class="viewcls">View</a>');
                         $arr_eventdata['title']    = 'Price Drop';     

                         if($user->inRole('seller')==true)
                         {

                         }else
                         {
                             $this->EventModel->create($arr_eventdata);
                         }

                        

                   /***********end of eventdata*for pricedrop*****/

                   // if price drop then send notificaiton to those buyers who is followers of this logged in seller

                   /****************start**noti*for*follower************************/
                      if($user->inRole('seller')==true)
                      {

                           /*if ($is_update_process == false) // add
                           {


                             $sellername = '';

                              $sellername = get_seller_details($user_details->id);


                           // get followers of seller
                             $getfollowers = $this->FollowModel->where('seller_id',$user_details->id)->get();
                             if(isset($getfollowers) && !empty($getfollowers))
                             {
                                $getfollowers = $getfollowers->toArray();


                                if(isset($productlist->id)){
                                $get_productinfo = $this->ProductModel->where('id',$productlist->id)->first();
                                if(!empty($get_productinfo))
                                {
                                    $get_productinfo = $get_productinfo->toArray();
                               
                                     $product_url     = url('/').'/search/product_detail/'.base64_encode($get_productinfo['id']);


                                     foreach($getfollowers as $kk=>$vv)
                                     {

                                        $arr_event                 = [];
                                        $arr_event['from_user_id'] = $user_details->id;
                                        $arr_event['to_user_id']   = $vv['buyer_id'];
                                        $arr_event['description']  = html_entity_decode('There is new product <a target="_blank" href="'.$product_url.'"> '.ucfirst($get_productinfo['product_name'].' </a> on chow by '.$sellername).'');
                                       // $arr_event['url']        = $url;
                                        $arr_event['type']         = '';
                                        $arr_event['title']        = 'New product from '.$sellername;         

                                        $this->GeneralService->save_notification($arr_event);

                                       //send email to follower start 
                                       $get_user_detail = $this->UserModel->where('id',$vv['buyer_id'])->first();
                                      if(isset($get_user_detail) && !empty($get_user_detail))
                                      {
                                          $get_user_detail = $get_user_detail->toArray();
                                          if(isset($get_user_detail))
                                          {
                                              $full_name = $get_user_detail['first_name'].' '.$get_user_detail['last_name'];
                                              //$subject     = 'Product Price Dropped';

                                              $arr_built_content = ['USER_NAME'     => $full_name,
                                                                    'APP_NAME'      => config('app.project.name'),
                                                                    //'MESSAGE'       => $msg,
                                                                    'PRODUCT_NAME'  => ucfirst($get_productinfo['product_name']),                                                                
                                                                    'URL'           => $product_url,
                                                                    'SELLER_NAME'     => $sellername,
                                                                   ];

                                              $arr_mail_data['arr_built_subject'] = ['SELLER_NAME' => $sellername ];                     

                                              $arr_mail_data['email_template_id'] = '128';
                                              $arr_mail_data['arr_built_content'] = $arr_built_content;
                                             // $arr_mail_data['arr_built_subject'] = '';

                                              $arr_mail_data['user']              = Sentinel::findById($vv['buyer_id']);

                                              $this->EmailService->send_mail_section_order($arr_mail_data);
                                          }
                                      }//if get userdetail

                                     //send email to follower end

                                   }//foreach
                               }//if getprofductinfo
                              }//if isset productlistid
                             }//if getfollowers
                           }//if add
                         */
                      }//if seller login  
                   /*****************end*noti*for*follower***********************/


                }//elseif
            }//if unit price and price drop
            

        /****************end of price drop noti to buyer*****************************************/

        return $productlist;
    }

	function send_noti_email_to_buyer($productid,$buyer)
    {
        if(isset($productid) && isset($buyer)){
        $get_productinfo = $this->ProductModel->with('get_brand_detail','get_seller_additional_details')->where('id',$productid)->where('is_active',1)->where('is_approve',1)->first();

        $productname_slug = $brand_slug = $seller_slug ='';
          
        if(!empty($get_productinfo))
        {
            $get_productinfo  = $get_productinfo->toArray();
           

                $productname_slug = isset($get_productinfo['product_name'])?str_slug($get_productinfo['product_name']):'';
           
               $brand_slug = isset($get_productinfo['get_brand_detail']['name'])?str_slug($get_productinfo['get_brand_detail']['name']):'';

               $seller_slug = isset($get_productinfo['get_seller_additional_details']['business_name'])?str_slug($get_productinfo['get_seller_additional_details']['business_name']):'';

               $product_url = url('/').'/search/product_detail/'.base64_encode($get_productinfo['id']).'/'.$productname_slug.'/'.$brand_slug.'/'.$seller_slug;
          
       
             // $product_url     = url('/').'/search/product_detail/'.base64_encode($get_productinfo['id']);

            $admin_role = Sentinel::findRoleBySlug('admin');        
            $admin_obj = \DB::table('role_users')->where('role_id',$admin_role->id)->first();
            if($admin_obj)
            {
                $admin_id = $admin_obj->user_id;            
            }    
          

            /****************send noti*to buyer***************************/
                $arr_event                 = [];
                $arr_event['from_user_id'] = $admin_id;
                $arr_event['to_user_id']   = $buyer;
                $arr_event['description']  = html_entity_decode('<a target="_blank" href="'.$product_url.'">'.ucfirst($get_productinfo['product_name']).'</a> price reduced from <b> $'.num_format($get_productinfo['unit_price'],2).'</b> to <b> $'.num_format($get_productinfo['price_drop_to'],2).'. </b>');
               // $arr_event['url']        = $url;
                $arr_event['type']         = '';
                $arr_event['title']        = 'Product price drop';                
                $this->GeneralService->save_notification($arr_event);
            /****************end of send noti**to buyer****************************/

            /**************Send Mail Notification to Buyer (START)*******************/
                /*$msg    = html_entity_decode('<a target="_blank" href="'.$product_url.'">'.ucfirst($get_productinfo['product_name']).'</a> price reduced from<b> $'.num_format($get_productinfo['unit_price'],2).'</b> to <b> $'.num_format($get_productinfo['price_drop_to'],2).'. </b>');*/

                $get_user_detail = $this->UserModel->where('id',$buyer)->first();
                if($get_user_detail)
                {
                    $get_user_detail = $get_user_detail->toArray();
                    if(isset($get_user_detail))
                    {
                        $full_name = $get_user_detail['first_name'].' '.$get_user_detail['last_name'];
                        //$subject     = 'Product Price Dropped';

                        $arr_built_content = ['USER_NAME'     => $full_name,
                                              'APP_NAME'      => config('app.project.name'),
                                              //'MESSAGE'       => $msg,
                                              'PRODUCT_NAME'  => ucfirst($get_productinfo['product_name']),
                                              'UNIT_PRICE'    => '$'.num_format($get_productinfo['unit_price'],2),
                                              'PRICE_DROP_TO' => '$'.num_format($get_productinfo['price_drop_to'],2),
                                              'URL'           => $product_url
                                             ];

                        $arr_mail_data['email_template_id'] = '87';
                        $arr_mail_data['arr_built_content'] = $arr_built_content;
                        $arr_mail_data['arr_built_subject'] = '';
                        $arr_mail_data['user']              = Sentinel::findById($buyer);

                        $this->EmailService->send_mail_section($arr_mail_data);
                    }
                }

            /**************Send Mail Notification to Buyer (END)*********************/
         
       }
      }
    }   
    

    /* this function for when admin settle dispute then usdc will send from seller to buyer and acknowledge wire by seller.*/

    public function update_trades_status($trade_id)
    {

        $trade_obj = $this->ProductModel->where('id',$trade_id)->first();

        if($trade_obj)
        {
          $trade_arr  = $trade_obj->toArray();
        }

        //get seller trade details
        $seller_trade_details_obj = $this->ProductModel->where('id',$trade_arr['linked_to'])
                                                     ->first(); 

        if($seller_trade_details_obj)
        {
          $seller_trade_arr = $seller_trade_details_obj->toArray();
        }

        //get seller set quantiy
        $seller_qty = $seller_trade_arr['quantity'] or 0;

        //get all buyer purchase quantity
        $purchase_qty = $this->ProductModel->where('linked_to',$seller_trade_arr['id'])
                                         ->where('is_crypto_trade','1')
                                         ->whereIn('crypto_trade_status',[3,4])
                                         // ->where('crypto_trade_status','3')
                                         ->sum('quantity');

        //if purchase quantiy is greater than or equal to seller quantity then update order status 2 ie completed else order status is 1 ie partialy completed
        if($purchase_qty>=$seller_qty)
        {
          $order_status['order_status'] = 2;
        }
        else
        {
          $order_status['order_status'] = 1;
        }

        //$order_status['sold_out_qty'] = $purchase_qty;

        $status = $this->ProductModel->where('id',$seller_trade_arr['id'])->update($order_status);

        if($status)
        {
           return true;
        }
        else
        {
           return false;
        }
    }


    public function filtered_trade_records(Array $arr_request = [],$is_crypto_trade)
    {
        $user_id               = $arr_request['user_id'];

        $trades_tbl            = $this->ProductModel->getTable();
        $prefixed_product_tbl   = DB::getTablePrefix().$this->ProductModel->getTable();

        $product_tbl           = $this->FirstLevelCategoryModel->getTable();
        $prefixed_firstlevel_tbl  = DB::getTablePrefix().$this->FirstLevelCategoryModel->getTable();

        $category_tbl          = $this->SecondLevelCategoryModel->getTable();
        $prefixed_seccategory_tbl = DB::getTablePrefix().$this->SecondLevelCategoryModel->getTable();

        $user_tbl              = $this->UserModel->getTable();
        $prefixed_user_tbl     = DB::getTablePrefix().$this->UserModel->getTable();

        $obj_trades = DB::table($trades_tbl)->select($prefixed_product_tbl.'.*',
                                               // $prefixed_firstlevel_tbl.'.product_type as product_name',
                                                $prefixed_seccategory_tbl.'.name as category_name',        
                                                $prefixed_user_tbl.'.user_type'
                                                    )
                                            ->leftJoin($product_tbl,$prefixed_firstlevel_tbl.'.id',$prefixed_product_tbl.'.first_level_category_id')
                                            ->leftJoin($category_tbl,$prefixed_seccategory_tbl.'.id',$prefixed_product_tbl.'.second_level_category_id')
                                            ->leftJoin($user_tbl,$prefixed_user_tbl.'.id',$prefixed_product_tbl.'.user_id')
                                           // ->where($prefixed_product_tbl.'.is_crypto_trade',$is_crypto_trade)
                                            ->whereNull($prefixed_product_tbl.'.deleted_at')
                                            ->orderBy($prefixed_product_tbl.'.id','DESC');

        if(isset($user_id) && $user_id!='')
        {
            $obj_trades = $obj_trades->where($prefixed_product_tbl.'.user_id',$user_id);
        }        
        

        /* ----------------Filtering----------------------------------*/                    
       /* $arr_search_column = isset($arr_request['column_filter']) ? $arr_request['column_filter'] : [];
        
        if(isset($arr_search_column['q_trade_ref']) && $arr_search_column['q_trade_ref']!="")
        {
            $search_term = $arr_search_column['q_trade_ref'];
            $obj_trades  = $obj_trades->where($prefixed_product_tbl.'.trade_ref','LIKE', '%'.$search_term.'%');
        }*/

       /*if(isset($arr_search_column['q_product']) && $arr_search_column['q_product']!="")
        {
            $search_term  = $arr_search_column['q_product'];
            $obj_trades   = $obj_trades->having('product_name','LIKE', '%'.$search_term.'%');
        }*/

        /*if(isset($arr_search_column['q_category']) && $arr_search_column['q_category']!="")
        {
           $search_term  = $arr_search_column['q_category'];            
           $obj_trades   = $obj_trades->having('category_name','LIKE', '%'.$search_term.'%');
        }    */         

       /* if(isset($arr_search_column['q_trade_status']) && $arr_search_column['q_trade_status']!="")
        {
            $search_term       = $arr_search_column['q_trade_status'];

           /* if($is_crypto_trade == '0')
            {
                $obj_trades   = $obj_trades->where($prefixed_product_tbl.'.trade_status','LIKE', '%'.$search_term.'%');
            }
            else if($is_crypto_trade == '1')
            {
                $obj_trades   = $obj_trades->where($prefixed_product_tbl.'.crypto_trade_status','LIKE', '%'.$search_term.'%');
            }*/
       // }*/

        /*if(isset($arr_search_column['q_trade_type']) && $arr_search_column['q_trade_type']!="")
        {
            $search_term   = $arr_search_column['q_trade_type'];
            $obj_trades    = $obj_trades->where($prefixed_product_tbl.'.trade_type','LIKE', '%'.$search_term.'%');
        }*/

        return $obj_trades;
    }


    public function trade_view($enc_product_id = false)
    {
        $trade_arr = [];

        $product_id = base64_decode($enc_trade_id);

        $trade_obj = $this->ProductModel->with(['product_details',
                                             'category_details',
                                             'user_details'
                                             
                                         ])
                                        ->where('id',$product_id)
                                        ->first();

        if($trade_obj)
        {
            $trade_arr    = $trade_obj->toArray();
        }

        return $trade_arr;
    }

    public function selected_offers($trade_id = false)
    {
        $selected_offers_arr = $this->ProductModel->with(['product_details',
                                             'category_details', 
                                             'unit_data'
                                            ])
                                            ->where('linked_to',$trade_id)
                                            ->where('is_finalized','1')
                                            ->get()->toArray();

        return $selected_offers_arr;
    }


    

    /*
        seller_filtered_trade_records() - This function is call from front panel
    */
    public function seller_filtered_product_records(Array $arr_request = [])
    {
        $user_id   = Sentinel::Check()->id;
 
        $category_id            = $arr_request['category_id']; 

        $product_table            = $this->ProductModel->getTable();
        $prefixed_product_table   = DB::getTablePrefix().$this->ProductModel->getTable();

        $first_level_cat_table  = $this->FirstLevelCategoryModel->getTable();
        $prefixed_first_level   = DB::getTablePrefix().$this->FirstLevelCategoryModel->getTable();

        $second_level_cat_table = $this->SecondLevelCategoryModel->getTable();
        $prefixed_second_level  =  DB::getTablePrefix().$this->SecondLevelCategoryModel->getTable(); 

        $unit_table             = $this->UnitModel->getTable();
        $prefixed_unit          =  DB::getTablePrefix().$this->UnitModel->getTable();  

        $obj_trade  = DB::table($product_table)
                        ->select(DB::raw(
                            $prefixed_product_table.'.*,'.
                            $prefixed_first_level.'.id as first_category_id,'.
                            $prefixed_first_level.'.product_type,'.
                            $prefixed_second_level.'.name as category'
                            //$prefixed_unit.'.unit'                                  
                        ))
                        ->leftjoin($prefixed_first_level,$prefixed_first_level.'.id','=',$prefixed_product_table.'.first_level_category_id')
                        ->leftjoin($prefixed_second_level,$prefixed_second_level.'.id','=',$prefixed_product_table.'.second_level_category_id')                    
                        //->leftjoin($prefixed_unit,$prefixed_unit.'.id','=',$prefixed_product_table.'.unit_id')
                        ->where($prefixed_product_table.'.user_id',$user_id)
                        
                        ->whereNull($prefixed_product_table.'.deleted_at')
                        ->orderBy($prefixed_product_table.'.created_at','DESC'); 

                       // dd($obj_trade);


        if(isset($is_crypto_trade) && $is_crypto_trade == '1')
        {   
            $obj_trade =  $obj_trade->whereNotNull($prefixed_trade_table.'.crypto_trade_status');
        }


         if(isset($category_id) && $category_id !='')
        {   
            $obj_trade =  $obj_trade->where($prefixed_first_level.'.id',$category_id);
        }  

        // dd($obj_trade->get());
        /* ---------------- Filtering Logic for Market Trade ----------------------------------*/
        $arr_search_column = isset($arr_request['column_filter']) ? $arr_request['column_filter'] : [];
    
        if(isset($arr_search_column['q_trade_ref']) && $arr_search_column['q_trade_ref']!="")
        {
           $search_term  = $arr_search_column['q_trade_ref'];
           $obj_trade    = $obj_trade->where($prefixed_trade_table.'.trade_ref','LIKE', '%'.$search_term.'%');
        }

        if(isset($arr_search_column['q_product_type']) && $arr_search_column['q_product_type'] != '')
        {
            $search_term = $arr_search_column['q_product_type'];
            $obj_trade   = $obj_trade->having('product_type','LIKE', '%'.$search_term.'%');
        }

        if(isset($arr_search_column['q_category']) && $arr_search_column['q_category'] != '')
        {
            $search_term = $arr_search_column['q_category'];
            $obj_trade   = $obj_trade->having('category','LIKE', '%'.$search_term.'%');
        }
            
        return  $obj_trade;
    }

    public function update_remaining_stock($product_id,$sold_out_qty)
    {
        if ($product_id) {

            $get_remainig_quantity = $this->ProductInventoryModel->where('product_id',$product_id)->first();

            $remain_stock = $get_remainig_quantity['remaining_stock'] - $sold_out_qty;
            $update_quantity='';
            if ($remain_stock >= 0) {
               
               $update_quantity = $this->ProductInventoryModel->where('product_id',$product_id)->update(['remaining_stock'=>$remain_stock]);
            }
            if ($update_quantity) {
                  
                 $response['status'] = 'success';
            }   
            else
            {
                $response['status'] = 'failure';
            }
        }
        else{

            $response['status'] = 'failure';
        }
    }    

    public function get_product_details($product_id)
    {
        $arr_product = [];

        $obj_product  = $this->ProductModel
                          ->with(['first_level_category_details',
                            'first_level_category_details.age_restriction_detail',
                            'second_level_category_details',
                            'product_comment_details',
                            'inventory_details',
                            'product_comment_details.seller_detail',
                            'product_comment_details.buyer_detail',
                            'user_details.seller_detail',
                            'user_details.get_country_detail',
                            'user_details.get_state_detail',
                            'review_details.buyer_details',
                            'review_details.user_details',
                            'product_images_details',
                            'age_restriction_detail',
                            'get_brand_detail'
                                ]) 
                          ->where('id',$product_id)
                          ->first();
        if($obj_product)
        {
            $arr_product = $obj_product->toArray();
            
        }
       
        return $arr_product;
    }

    // function for getting reviews and rating

      public function get_reviewsrating_details(Request $request,$productid)
     {
        $product_details    = $this->ProductModel->getTable();
        $prefix_product_detail  = DB::getTablePrefix().$this->ProductModel->getTable();

        $user_details       = $this->UserModel->getTable();
        $prefix_user_detail = DB::getTablePrefix().$this->UserModel->getTable();

        $firstlevel         = $this->FirstLevelCategoryModel->getTable();
        $prefix_firstlevel  = DB::getTablePrefix().$this->FirstLevelCategoryModel->getTable();

        $secondlevel        = $this->SecondLevelCategoryModel->getTable();
        $prefix_secondlevel = DB::getTablePrefix().$this->SecondLevelCategoryModel->getTable();

        $reviews_detail = $this->ReviewRatingsModel->getTable();
        $prefix_reviews = DB::getTablePrefix().$this->ReviewRatingsModel->getTable();


        $obj_product   = DB::table($reviews_detail)->select(DB::raw($reviews_detail.'.*,'.
                        "CONCAT(".$prefix_user_detail.".first_name,' ',"
                                .$prefix_user_detail.".last_name) as buyer_name"
                            ))                     
                        ->leftjoin($prefix_user_detail,$prefix_user_detail.'.id','=',$prefix_reviews.'.buyer_id')
                        ->where($reviews_detail.'.product_id',$productid)
                        ->orderBy($reviews_detail.'.created_at','desc');
                       // ->get(); 

         /* ---------------- Filtering Logic ----------------------------------*/
          $arr_search_column = $request->input('column_filter');

          /*if(isset($arr_search_column['q_buyer_name']) && $arr_search_column['q_buyer_name'] != '')
          {
              $search_buyer_term  = $arr_search_column['q_buyer_name'];
              $obj_product        = $obj_product->where($prefix_user_detail.'.first_name','LIKE', '%'.$search_buyer_term.'%')->orWhere($prefix_user_detail.'.last_name', 'LIKE', '%'.$search_buyer_term.'%');

          }*/
      
         if(isset($arr_search_column['q_buyer_name']) && $arr_search_column['q_buyer_name'] != '')
          {
               $search_buyer_term  = $arr_search_column['q_buyer_name'];
               $obj_product  = $obj_product->where($prefix_user_detail.'.first_name','LIKE', '%'.$search_buyer_term.'%')->orWhere($prefix_user_detail.'.last_name', 'LIKE', '%'.$search_buyer_term.'%');

          }
         return $obj_product;
                                    
    }




    //This function call from admin panel
    public function filtered_dispute_trade_records(Array $arr_request = [],$is_crypto_trade)
    {   
        $dispute_trade_ids = [];
        $user_id               = $arr_request['user_id'];

        $trades_tbl            = $this->ProductModel->getTable();
        $prefixed_trades_tbl   = DB::getTablePrefix().$this->ProductModel->getTable();

        $product_tbl           = $this->FirstLevelCategoryModel->getTable();
        $prefixed_product_tbl  = DB::getTablePrefix().$this->FirstLevelCategoryModel->getTable();

        $category_tbl          = $this->SecondLevelCategoryModel->getTable();
        $prefixed_category_tbl = DB::getTablePrefix().$this->SecondLevelCategoryModel->getTable();

        $user_tbl              = $this->UserModel->getTable();
        $prefixed_user_tbl     = DB::getTablePrefix().$this->UserModel->getTable();


        //Get all dispute trade ids
        $arr_dispute = $this->DisputeModel->get()->toArray();
        $dispute_trade_ids = array_column($arr_dispute,'trade_id');


        $obj_trades = DB::table($trades_tbl)->select($prefixed_trades_tbl.'.*',
                                                $prefixed_product_tbl.'.product_type as product_name',
                                                $prefixed_category_tbl.'.name as category_name',        
                                                $prefixed_user_tbl.'.user_type'
                                                    )
                                            ->leftJoin($product_tbl,$prefixed_product_tbl.'.id',$prefixed_trades_tbl.'.first_level_category_id')
                                            ->leftJoin($category_tbl,$prefixed_category_tbl.'.id',$prefixed_trades_tbl.'.second_level_category_id')
                                            ->leftJoin($user_tbl,$prefixed_user_tbl.'.id',$prefixed_trades_tbl.'.user_id')
                                            ->where($prefixed_trades_tbl.'.is_crypto_trade',$is_crypto_trade)
                                            ->whereIn($prefixed_trades_tbl.'.id',$dispute_trade_ids)
                                            ->whereNull($prefixed_trades_tbl.'.deleted_at')
                                            ->orderBy($prefixed_trades_tbl.'.id','DESC');

        if(isset($user_id) && $user_id!='')
        {
            $obj_trades = $obj_trades->where($prefixed_trades_tbl.'.user_id',$user_id);
        }        
        

        /* ----------------Filtering----------------------------------*/                    
        $arr_search_column = isset($arr_request['column_filter']) ? $arr_request['column_filter'] : [];
        
        if(isset($arr_search_column['q_trade_ref']) && $arr_search_column['q_trade_ref']!="")
        {
            $search_term = $arr_search_column['q_trade_ref'];
            $obj_trades  = $obj_trades->where($prefixed_trades_tbl.'.trade_ref','LIKE', '%'.$search_term.'%');
        }

        if(isset($arr_search_column['q_product']) && $arr_search_column['q_product']!="")
        {
            $search_term  = $arr_search_column['q_product'];
            $obj_trades   = $obj_trades->having('product_name','LIKE', '%'.$search_term.'%');
        }

        if(isset($arr_search_column['q_category']) && $arr_search_column['q_category']!="")
        {
           $search_term  = $arr_search_column['q_category'];            
           $obj_trades   = $obj_trades->having('category_name','LIKE', '%'.$search_term.'%');
        }             

        if(isset($arr_search_column['q_trade_status']) && $arr_search_column['q_trade_status']!="")
        {
            $search_term       = $arr_search_column['q_trade_status'];

            if($is_crypto_trade == '0')
            {
                $obj_trades   = $obj_trades->where($prefixed_trades_tbl.'.trade_status','LIKE', '%'.$search_term.'%');
            }
            else if($is_crypto_trade == '1')
            {
                $obj_trades   = $obj_trades->where($prefixed_trades_tbl.'.crypto_trade_status','LIKE', '%'.$search_term.'%');
            }
        }

        if(isset($arr_search_column['q_trade_type']) && $arr_search_column['q_trade_type']!="")
        {
            $search_term   = $arr_search_column['q_trade_type'];
            $obj_trades    = $obj_trades->where($prefixed_trades_tbl.'.trade_type','LIKE', '%'.$search_term.'%');
        }

        return $obj_trades;
    }

   
    public function perform_delete($id)
    {
        $is_fav_prod     = "";
        $entity          = $this->ProductModel->where('id',$id)->first();
    
        if($entity)
        {
            $unlink_old_img_path    = $this->product_image_base_img_path.'/'.$entity->product_image;
                            
            if(file_exists($unlink_old_img_path))
            {
                @unlink($unlink_old_img_path);  
            }

            $this->ProductModel->where('id',$id)->delete(); 

            $is_fav_prod = $this->FavoriteModel->where('product_id',$id)->count();

            if($is_fav_prod > 0)
            {  
             $this->FavoriteModel->where('product_id',$id)->delete();
            }

            Flash::success(str_plural($this->module_title).' Deleted Successfully');
            return true; 
        }
        else
        {
          Flash::error('Problem Occurred while deleting '.str_singular($this->module_title)); 
          return FALSE;
        }
    }
}

?>