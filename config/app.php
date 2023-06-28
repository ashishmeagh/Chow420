<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    */

    'name' => env('APP_NAME', 'Laravel'), 

    /* 
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services your application utilizes. Set this in your ".env" file.
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | your application so that it is used when running Artisan tasks.
    |
    */

    'url' => env('APP_URL', 'http://localhost'),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. We have gone
    | ahead and set this to a sensible default for you out of the box.
    |
    */

   // 'timezone' => 'UTC',
    'timezone' => 'America/New_York',

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */

    'locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Application Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale determines the locale to use when the current one
    | is not available. You may change the value to correspond to any of
    | the language folders that are provided through your application.
    |
    */

    'fallback_locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Illuminate encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    */

    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',

    /*
    |--------------------------------------------------------------------------
    | Logging Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log settings for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Settings: "single", "daily", "syslog", "errorlog"
    |
    */

    'log' => env('APP_LOG', 'single'),

    'log_level' => env('APP_LOG_LEVEL', 'debug'),

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

    'providers' => [

        /*
         * Laravel Framework Service Providers...
         */
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Notifications\NotificationServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,
        Maatwebsite\Excel\ExcelServiceProvider::class,

        /*
         * Package Service Providers...
         */

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        App\Providers\HelperServiceProvider::class,
        Dimsav\Translatable\TranslatableServiceProvider::class,
        Yajra\Datatables\DatatablesServiceProvider::class,
        Laracasts\Flash\FlashServiceProvider::class,
        Cartalyst\Sentinel\Laravel\SentinelServiceProvider::class,

        // App\Providers\BroadcastServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
        Anam\Phpcart\CartServiceProvider::class,
        Barryvdh\Snappy\ServiceProvider::class,
        Intervention\Image\ImageServiceProvider::class,
        Arcanedev\LogViewer\LogViewerServiceProvider::class




    ],

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
    */

    'aliases' => [

        'App' => Illuminate\Support\Facades\App::class,
        'Artisan' => Illuminate\Support\Facades\Artisan::class,
        'Auth' => Illuminate\Support\Facades\Auth::class,
        'Blade' => Illuminate\Support\Facades\Blade::class,
        'Broadcast' => Illuminate\Support\Facades\Broadcast::class,
        'Bus' => Illuminate\Support\Facades\Bus::class,
        'Cache' => Illuminate\Support\Facades\Cache::class,
        'Config' => Illuminate\Support\Facades\Config::class,
        'Cookie' => Illuminate\Support\Facades\Cookie::class,
        'Crypt' => Illuminate\Support\Facades\Crypt::class,
        'DB' => Illuminate\Support\Facades\DB::class,
        'Eloquent' => Illuminate\Database\Eloquent\Model::class,
        'Event' => Illuminate\Support\Facades\Event::class,
        'File' => Illuminate\Support\Facades\File::class,
        'Gate' => Illuminate\Support\Facades\Gate::class,
        'Hash' => Illuminate\Support\Facades\Hash::class,
        'Lang' => Illuminate\Support\Facades\Lang::class,
        'Log' => Illuminate\Support\Facades\Log::class,
        'Mail' => Illuminate\Support\Facades\Mail::class,
        'Notification' => Illuminate\Support\Facades\Notification::class,
        'Password' => Illuminate\Support\Facades\Password::class,
        'Queue' => Illuminate\Support\Facades\Queue::class,
        'Redirect' => Illuminate\Support\Facades\Redirect::class,
        'Redis' => Illuminate\Support\Facades\Redis::class,
        'Request' => Illuminate\Support\Facades\Request::class,
        'Response' => Illuminate\Support\Facades\Response::class,
        'Route' => Illuminate\Support\Facades\Route::class,
        'Schema' => Illuminate\Support\Facades\Schema::class,
        'Session' => Illuminate\Support\Facades\Session::class,
        'Storage' => Illuminate\Support\Facades\Storage::class,
        'URL' => Illuminate\Support\Facades\URL::class,
        'Validator' => Illuminate\Support\Facades\Validator::class,
        'View' => Illuminate\Support\Facades\View::class,
        'Datatables' => Yajra\Datatables\Facades\Datatables::class,
        'Activation' => Cartalyst\Sentinel\Laravel\Facades\Activation::class,
        'Reminder'   => Cartalyst\Sentinel\Laravel\Facades\Reminder::class,
        'Sentinel'   => Cartalyst\Sentinel\Laravel\Facades\Sentinel::class,
        'Excel' => Maatwebsite\Excel\Facades\Excel::class,
        'Cart' => Anam\Phpcart\Facades\Cart::class,
        'PDF' => Barryvdh\Snappy\Facades\SnappyPdf::class,
        'SnappyImage' => Barryvdh\Snappy\Facades\SnappyImage::class,
        'Image' => Intervention\Image\Facades\Image::class



    ], 

    'project' => [ 
        'admin_name' =>'Chow420', //This name will be used for email and notifications
        'name'       =>'Chow420',
        'img_path'  =>[
                        'categories'          => '/uploads/categories/',
                        'user_profile_image'  => '/uploads/profile_image/',
                        'slider_images'       => '/uploads/slider_images/',
                        'product_images'      => '/uploads/product_images/',
                        'product_imagesthumb' => '/uploads/product_images/thumb/',
                        'product_news'        => '/uploads/product_news',
                        'reported_effects'    => '/uploads/reported_effects',
                        'brands'              => '/uploads/brands',
                        'id_proof'            => '/uploads/id_proof/',
                        'seller_id_proof'     => '/uploads/seller_id_proof/',  
                        'first_category'      => '/uploads/first_category/',
                        'seller_banner'      => '/uploads/seller_banner/',
                        'container'          => '/uploads/container',
                        'post'               => '/uploads/post',
                        'membership'         => '/uploads/membership',
                        'welcome'            => '/uploads/welcome',
                        'referal'            => '/uploads/referal',
                         'faq'               => '/uploads/faq',
                         'newsletter'        => '/uploads/newsletter',
                         'seller_documents'  => '/uploads/seller_documents/',
                         'banner_images'       => '/uploads/banner_images/',
                         'banner_images_thumb' => '/uploads/banner_images/thumb/',
                         'shop_by_effect'    => '/uploads/shop_by_effect',
                         'shop_by_spectrum'  => '/uploads/shop_by_spectrum',
                         'highlights'        => '/uploads/highlights',
                         'additional_product_image' => '/uploads/additional_product_image/',
                         'first_level_category_productdetail'=>'/uploads/first_level_category_productdetail/'

                      ],
        'shipment_proofs'     => '/uploads/shipment_proofs/',
        'wire_transfer_proof' => '/uploads/wire_transfer_proof/',
        'chat_attachment'     => '/uploads/chat_attachment/',
        'admin_panel_slug'    => 'book',
        'buyer_panel_slug'    => 'buyer',
        'seller_panel_slug'    => 'seller',
        'product_images'      => '/uploads/product_images',
        'membership'          => '/uploads/membership',
        'welcome'          => '/uploads/welcome',
        'referal'          => '/uploads/referal',
         'faq'          => '/uploads/faq',
         'newsletter'          => '/uploads/newsletter',

        /*Development Sandbox*/
        'square_access_token' => 'EAAAEC63sYYCbZtNmOFxLRxn5AJQ6JerEvGellq5v-nYk3lTsQOTag2nV1VSu1Ct',
        'square_Location_id' => '4PD2BG4CDT1MX',
        'square_application_id' => 'sandbox-sq0idb-e8DS2ixcobu7FBFMh6zRtA',


        /*Development Live*/
        // 'square_access_token'   => 'EAAAEMQbmaItD95Y0f_SyPL0acERfC8j_f01RkEGJAUrumQpLYOPthdrCAw650cP',
        // 'square_Location_id'    => '3K7R29Q45P2RM',
        // 'square_application_id' => 'sq0idp-3dLj2sDj04-8-ldqqtVM9g',


        /*Production live*/
        // 'square_access_token' => 'EAAAEN92iKlblMqhFQ7j_B6xymEL23s8M-2BNmF9tQbEkQ4uaMXgSo1c7bSN40jR',
        // 'square_Location_id' => '6TJVBYYRHRDHA',
        // 'square_application_id' => 'sq0idp-xx46fnMkN7XxNdosOuyM1Q',

        /*Production Development*/
        // 'square_access_token' => 'EAAAEN92iKlblMqhFQ7j_B6xymEL23s8M-2BNmF9tQbEkQ4uaMXgSo1c7bSN40jR',
        // 'square_Location_id' => '6TJVBYYRHRDHA',
        // 'square_application_id' => 'sq0idp-xx46fnMkN7XxNdosOuyM1Q',


        'footer_link' => 'Chow420.com',
        'footer_link_year' => '2018-2021',
        'seller_commision'=>'87',
        'seller_min_withdraw_amount'=>'50',
        'stripe_publish_key'=>'pk_test_dEtr662tvSvuhA7diHCPtx9900Uwz55VcX',
        'stripe_secret_key'=>'sk_test_K6UcH0uZfs3EUuDcspzjBYPn00H4KXdMLP',
        'seller_referal'=>'15',
        'buyer_referal'=>'10',
        'buyer_refered'=>'10', 
        'buyer_review_amount',
       //  'stripe_publish_key'=>'pk_test_lxmSkaumpYupNKHjy3qCAAGI00Oqocx5BQ',
      //  'stripe_secret_key'=>'sk_test_B3TMD2D83x03IRzGjtuhtSrl00i4IaZG15'

        // 'account_sid'=>'AC6dad0e6b65c0181b302cc08ab3d6f45b', //my
        // 'auth_token'=>'b24e8feeecef07b6d06cfc4d632ae93e',
        // 'from'=>'+12564195057'

         'account_sid'=>'ACfc8efea30acecde2e76f5799b1ba2767', //david
         'auth_token'=>'a86c1a44fc24505fe7e7e859ae40a3c4',
         'from' => '+12403396347'



         // 'account_sid'=>'AC24354d26dbbbee00de6a10b04994aa71', //prajakta
         // 'auth_token'=>'735e2e0e7c3522747141b18303b49db7',
         // 'from'=>'+13142549050'


        ],

];
