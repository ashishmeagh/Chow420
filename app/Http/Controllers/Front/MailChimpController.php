<?php
namespace App\Http\Controllers\Front;



use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Front\MailChimpFileController;

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


class MailChimpController extends Controller
{
    public $api_key;
    public $api_endpoint = 'https://<dc>.api.mailchimp.com/3.0';

    const TIMEOUT = 10;

    /*  SSL Verification
        Read before disabling:
        http://snippets.webaware.com.au/howto/stop-turning-off-curlopt_ssl_verifypeer-and-fix-your-php-config/
    */
    public $verify_ssl = true;

    private $request_successful = false;
    private $last_error         = '';
    private $last_response      = array();
    private $last_request       = array();



public function index()
{

        $MailChimp = new MailChimpFileController('c0945de3555f07a50686cac5c853ba36-us17');
        $result    = $MailChimp->post("campaigns", [
            'type' => 'regular',
            'recipients' => ['list_id' => 'c642ca6ce3'],
            'settings' => ['subject_line' => 'Email Sending Test2',
                   'reply_to' => 'ashwini.rwaltzsoftware@gmail.com',
                   'from_name' => 'Ash'
                  ]
            ]);

        $response    = $MailChimp->getLastResponse();
        $responseObj = json_decode($response['body']);  

        $html   = file_get_contents('http://localhost/chow420/test.html');
        $result = $MailChimp->put('campaigns/' . $responseObj->id . '/content', [
              'template' => ['id' => 10008442, 
                'sections' => ['body' => $html]
                ]
              ]);

        $result = $MailChimp->post('campaigns/' . $responseObj->id . '/actions/send');
}


/* $apiKey = 'c0945de3555f07a50686cac5c853ba36-us17';
        $listID = 'c642ca6ce3';
        
        // MailChimp API URL
        $memberID   = md5(strtolower('ashwini.rwaltzsoftware@gmail.com'));
        $dataCenter = substr($apiKey,strpos($apiKey,'-')+1);
        $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $listID . '/members/' . $memberID;

 $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $result);
        $new_result = curl_exec($ch);

echo"<pre>";print_r(json_decode($new_result));exit();*/


}


