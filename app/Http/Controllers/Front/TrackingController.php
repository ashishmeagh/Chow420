<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\ProductModel;
use App\Models\FirstLevelCategoryModel;
use App\Models\SecondLevelCategoryModel;
use App\Models\UnitModel;
use App\Models\UserModel;
use App\Models\ShippingAddressModel;
use App\Models\TradeRatingModel;
use App\Models\SliderImagesModel;
use App\Models\StaticPageModel;
use App\Models\GeneralSettingsModel;
use App\Models\TestimonialModel;
use App\Models\BuyerModel;
use App\Models\FavoriteModel;
use App\Models\ProductNewsModel;
use App\Models\ReviewRatingsModel;
use App\Models\ProductImagesModel;
use App\Models\OrderModel;
use App\Models\OrderProductModel;
use App\Models\BrandModel;
use App\Models\CountriesModel;
use App\Models\StatesModel;
use App\Models\UserReferedModel;
use App\Models\UserSubscriptionsModel; 
use App\Models\MembershipModel;
use App\Models\EventModel;

use Carbon\Carbon;

use App\Models\StaticPageTranslationModel;
use App\Common\Services\GeneralService;
use App\Common\Services\EmailService;

use Sentinel;
use DB; 
use Datatables;
use Session;


use Illuminate\Support\Str;
 

class TrackingController extends Controller
{
    

    public function __construct(
                                    ProductModel $ProductModel,
                                    FirstLevelCategoryModel $FirstLevelCategoryModel,
                                    SecondLevelCategoryModel $SecondLevelCategoryModel,
                                    UnitModel $UnitModel,
                                    UserModel $UserModel,
                                    ShippingAddressModel $ShippingAddressModel,
                                    TradeRatingModel $TradeRatingModel,
                                    SliderImagesModel $SliderImagesModel,
                                    StaticPageModel $StaticPageModel,
                                    GeneralSettingsModel $GeneralSettingsModel,
                                     CountriesModel $CountriesModel,
                                      StatesModel $StatesModel,
                                    
                                    EmailService $EmailService,
                                    TestimonialModel $TestimonialModel,
                                    BuyerModel $BuyerModel,
                                    ProductNewsModel $ProductNewsModel,
                                    ReviewRatingsModel $ReviewRatingsModel,
                                    ProductImagesModel $ProductImagesModel,
                                    OrderModel $OrderModel,
                                    OrderProductModel $OrderProductModel,
                                    BrandModel $BrandModel,
                                    UserReferedModel $UserReferedModel,
                                    UserSubscriptionsModel $UserSubscriptionsModel,
                                    MembershipModel $MembershipModel,
                                    EventModel $EventModel,
                                    GeneralService $GeneralService
                                )
    {   
        $this->ProductModel               = $ProductModel;
        $this->FirstLevelCategoryModel  = $FirstLevelCategoryModel;
        $this->SecondLevelCategoryModel = $SecondLevelCategoryModel;
        $this->UnitModel                = $UnitModel;
        $this->UserModel                = $UserModel;
        $this->ShippingAddressModel     = $ShippingAddressModel; 
        $this->TradeRatingModel         = $TradeRatingModel;
        $this->SliderImagesModel        = $SliderImagesModel;
        $this->StaticPageModel          = $StaticPageModel;
        $this->GeneralSettingsModel     = $GeneralSettingsModel;
        
        $this->EmailService             = $EmailService;
        $this->GeneralService           = $GeneralService;
        $this->TestimonialModel         = $TestimonialModel;
        $this->BuyerModel               = $BuyerModel;
        $this->BuyerModel               = $BuyerModel;
        $this->FavoriteModel            = new FavoriteModel();
        $this->ProductNewsModel         = $ProductNewsModel;
        $this->ReviewRatingsModel       = $ReviewRatingsModel;
        $this->ProductImagesModel       = $ProductImagesModel;
        $this->OrderModel               = $OrderModel;
        $this->OrderProductModel        = $OrderProductModel;
        $this->BrandModel               = $BrandModel;

        $this->CountriesModel           = $CountriesModel;
        $this->StatesModel              = $StatesModel;
        $this->UserReferedModel         = $UserReferedModel;
        $this->UserSubscriptionsModel   = $UserSubscriptionsModel;
        $this->MembershipModel          = $MembershipModel;
        $this->EventModel               = $EventModel;

        $this->user_profile_base_img_path   = base_path().config('app.project.img_path.user_profile_image');
        $this->user_profile_public_img_path = url('/').config('app.project.img_path.user_profile_image');

        $this->slider_base_img_path   = base_path().config('app.project.img_path.slider_images');
        $this->slider_public_img_path = url('/').config('app.project.img_path.slider_images');
        $this->module_view_folder   = 'front';  
        $this->arr_view_data        = [];
    }
   


    public function index()
    {
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.shipengine.com/v1/tracking?carrier_code=fedex&tracking_number=122816215025810",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => array(
            "Host: api.shipengine.com",
            "API-Key: TEST_BuQJWQc+VzsRehlxxjEnOqQ4WAOwQwF/+aFTPRRzhLg"
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo"<pre>"; print_r($response);
    }  

    public function ship_package()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.shipengine.com/v1/labels",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS =>"{
              'shipment': {
                'service_code': 'usps_priority_mail',
                'ship_to': {
                  'name': 'Amanda Miller',
                  'phone': '555-555-5555',
                  'address_line1': '525 S Winchester Blvd',
                  'city_locality': 'San Jose',
                  'state_province': 'CA',
                  'postal_code': '95128',
                  'country_code': 'US',
                  'address_residential_indicator': 'yes'
                },
                'ship_from': {
                  'name': 'John Doe',
                  'phone': '111-111-1111',
                  'company_name': 'Example Corp.',
                  'address_line1': '4009 Marathon Blvd',
                  'address_line2': 'Suite 300',
                  'city_locality': 'Austin',
                  'state_province': 'TX',
                  'postal_code': '78756',
                  'country_code': 'US',
                  'address_residential_indicator': 'no'
                },
                'packages': [
                  {
                    'weight': {
                      'value': 20,
                      'unit': 'ounce'
                    }
                  }
                ]
            }
        }",
     CURLOPT_HTTPHEADER => array(
            "Host: api.shipengine.com",
            "API-Key: TEST_BuQJWQc+VzsRehlxxjEnOqQ4WAOwQwF/+aFTPRRzhLg",
            "Content-Type: application/json"
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo"<pre>"; print_r($response);
    } 


    public function track_package_by_lable()
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.shipengine.com/v1/labels/se-14481901/track",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => array(
            "Host: api.shipengine.com",
            "API-Key: TEST_BuQJWQc+VzsRehlxxjEnOqQ4WAOwQwF/+aFTPRRzhLg",
            "Cache-Control: no-cache"
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;

    }
    public function create_brandedpage()
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.shipengine.com/v-beta/tracking_page",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS =>"{
                  'tracking_pages' :
                    [ {
                      ' branded_tracking_theme_guid'   : 'fc16e39d-9722-4514-aff5-75e1f24c5bbd',
                        'tracking_number' : '012345678910',
                        'carrier_code' : 'ups',
                        'service_code' : 'ups_ground', 
                        'to_city_locality' :'austin',
                        'to_state_province' : 'tx',
                        'to_postal_code' : '78756',
                        'to_country_code' : 'US',
                        'from_city_locality' :'denver',
                        'from_state_province' : 'CO',
                        'from_postal_code' : '80014',
                        'from_country_code' : 'US' 
                      }]
                    }",
          CURLOPT_HTTPHEADER => array(
            "Host: api.shipengine.com",
            "API-Key: TEST_GlDFwCkDvDzj+yQorN8qJrS+ig12vO8qO4vA2IHh7f0",
            "Content-Type: application/json"
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }


    public function image_to_lable()
    {
      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.shipengine.com/v1/labels",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS =>"{\n  \"label_image_id\": \"img_DtBXupDBxREpHnwEXhTfgK\",\n  \"shipment\": {\n    \"service_code\": \"usps_priority_mail\",\n    \"ship_to\": {\n      \"name\": \"Amanda Miller\",\n      \"phone\": \"555-555-5555\",\n      \"address_line1\": \"525 S Winchester Blvd\",\n      \"city_locality\": \"San Jose\",\n      \"state_province\": \"CA\",\n      \"postal_code\": \"95128\",\n      \"country_code\": \"US\",\n      \"address_residential_indicator\": \"yes\"\n    },\n    \"ship_from\": {\n      \"name\": \"John Doe\",\n      \"phone\": \"111-111-1111\",\n      \"company_name\": \"Example Corp.\",\n      \"address_line1\": \"4009 Marathon Blvd\",\n      \"address_line2\": \"Suite 300\",\n      \"city_locality\": \"Austin\",\n      \"state_province\": \"TX\",\n      \"postal_code\": \"78756\",\n      \"country_code\": \"US\",\n      \"address_residential_indicator\": \"no\"\n    },\n    \"packages\": [\n      {\n        \"weight\": {\n          \"value\": 20,\n          \"unit\": \"ounce\"\n        }\n      }\n    ]\n  }\n}",
        CURLOPT_HTTPHEADER => array(
          "Host: api.shipengine.com",
          "API-Key: TEST_BuQJWQc+VzsRehlxxjEnOqQ4WAOwQwF/+aFTPRRzhLg",
          "Content-Type: application/json"
        ),
      ));

      $response = curl_exec($curl);

      curl_close($curl);
      echo $response;
   }   


   public function brand()
   {

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.shipengine.com/v-beta/tracking_page",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS =>"{\n  \"tracking_pages\" :[\n  {\n    \"branded_tracking_theme_guid\"   : \"fc16e39d-9722-4514-aff5-75e1f24c5bbd\",\n    \"tracking_number\" : \"012345678910\",\n    \"carrier_code\" : \"ups\",\n    \"service_code\" : \"ups_ground\",\n    \"to_city_locality\" :\"austin\",\n    \"to_state_province\" : \"tx\",\n    \"to_postal_code\" : \"78756\",\n    \"to_country_code\" : \"US\",\n    \"from_city_locality\" :\"denver\",\n    \"from_state_province\" : \"CO\",\n      \"from_postal_code\" : \"80014\",\n    \"from_country_code\" : \"US\"\n\n  }\n  ]\n}",
  CURLOPT_HTTPHEADER => array(
    "Host: api.shipengine.com",
    "API-Key: TEST_GlDFwCkDvDzj+yQorN8qJrS+ig12vO8qO4vA2IHh7f0",
    "Content-Type: application/json"
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

   }

      public function send_reminder_to_seller()
     { 

      $get_ongoing_orders =\DB::table('order_details')->where('order_status','3')->get();
        if(isset($get_ongoing_orders) && !empty($get_ongoing_orders))
        {
           $get_ongoing_orders = $get_ongoing_orders->toArray(); 
           $tracking_number    = $shipping_company_name = ""; 
           $arr_valid_shipping_companies = [];




           foreach($get_ongoing_orders as $order)
           {
               $orderid                = $order->id;
               $tracking_number        =  $order->tracking_no;
               $shipping_company_name  =  $order->shipping_company_name;
               $arr_valid_shipping_companies = array('usps','stamps_com','fedex','ups','dhl_express','canada_post','australia_post','firstmile','asendia','ontrac','apc','newgistics','globegistics','rr_donnelley','imex','access_worldwide','purolator_ca','sendle');

               if($tracking_number!="" && $shipping_company_name!="")
               {    
                    if(in_array($shipping_company_name, $arr_valid_shipping_companies)==false)
                    {    

                        $admin_role = Sentinel::findRoleBySlug('admin');  

                        $admin_obj  = DB::table('role_users')->where('role_id',$admin_role->id)->first();
                        $admin_id   = 0;
                        if($admin_obj)
                        {
                            $admin_id = $admin_obj->user_id;            
                        }
                        
                        $user_name='';

                        $getsellername = $this->UserModel->with('seller_detail')
                                            ->where('id',$order->seller_id)
                                            ->first();
                        if(isset($getsellername) && !empty($getsellername))
                        {
                            $getsellername = $getsellername->toArray();
                            if($getsellername['first_name']=="" || $getsellername['last_name']=="")
                            {
                                $user_name = $getsellername['email'];
                            }
                            else
                            {
                                $user_name = $getsellername['first_name'].' '.$getsellername['last_name'];
                            }                      
                        }

                         $order_details_url     = url('/').'/seller/order/view/'.base64_encode($order->id);

                        /*********Send Notification*to*Seller***************/

                        $arr_event                 = [];
                        $arr_event['from_user_id'] = $admin_id; 
                        $arr_event['to_user_id']   = $order->seller_id;;
                        $arr_event['type']         = 'seller';
                        $arr_event['description']  = 'Has <a href="'.$order_details_url.'">'.$order->order_no.'</a> been delivered ? Click delivered in the ongoing orders section if your product has been delivered.';                 
                        $arr_event['title']        = 'Has '.$order->order_no.' been delivered ?';                     


                        $this->GeneralService->save_notification($arr_event);

                        /************End*Send*Notification****************/

                        $seller_details = Sentinel::findById($order->seller_id);


                        $msg     = html_entity_decode('Click delivered in the ongoing orders section if your product has been delivered.');

                        $subject = 'Has '.$order->order_no.' been delivered ?';

                        $url     = url('/').'/seller/order/ongoing';

                        $arr_built_content = [
                            'USER_NAME'     => $user_name,
                            'APP_NAME'      => config('app.project.name'),
                            'MESSAGE'       => $msg,
                            'URL'           => $url
                        ];

                        $arr_mail_data['email_template_id'] = '49';
                        $arr_mail_data['arr_built_content'] = $arr_built_content;
                        $arr_mail_data['arr_built_subject'] = $subject;
                        $arr_mail_data['user']              = Sentinel::findById($order->seller_id);


                        $this->EmailService->send_notification_mail($arr_mail_data);


                    /**************end send email**********************/



               }//if invalid shipping comp name
            }   

           }//foreach
        }//if isset

    }//handle

}                       

