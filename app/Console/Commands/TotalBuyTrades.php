<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TradeModel;
use App\Models\SecondLevelCategoryModel;
use App\Models\TradeBuyHistoryModel;

class TotalBuyTrades extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'save:total-buy-trades';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Save today\'s total buy trades';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(TradeModel $TradeModel,
                                SecondLevelCategoryModel $SecondLevelCategoryModel,
                                TradeBuyHistoryModel $TradeBuyHistoryModel)
    {
        parent::__construct();

        $this->TradeModel               = $TradeModel;
        $this->SecondLevelCategoryModel = $SecondLevelCategoryModel;
        $this->TradeBuyHistoryModel     = $TradeBuyHistoryModel;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
       $arr_log['cron_signature'] = $this->signature;
       $arr_log['start_datetime'] = date('c');

       $cron_status = \App\Models\CronLogModel::create($arr_log);

        $status = false;
        //get slider categories
        $slider_cat_arr = $this->SecondLevelCategoryModel->with(['unit_details'])
                                                         ->where('is_active','1')
                                                         
                                                         ->get()->toArray();

        $current_date   = date('Y-m-d');//curret date time        
        $yesterday_date = date('Y-m-d',strtotime('last day'));// 24 hours before date (1 day)
        
        foreach ($slider_cat_arr as $key => $category) 
        {
            $avarage_volume = $avg_unit_price = 0;
            //calculate avarage sell quantity since 24 hours
            $avarage_volume_arr = $this->TradeModel
                                            ->where('second_level_category_id',$category['id'])
                                            ->where('trade_type','1')
                                            ->where('is_crypto_trade','0')
                                            ->whereBetween('created_at',[$yesterday_date, $current_date]) 
                                            ->whereIn('order_status',[0,1])
                                            ->whereNull('linked_to')
                                            ->get()->toArray();

            $available_qty = [];
            if(count($avarage_volume_arr)>0)
            {
                foreach ($avarage_volume_arr as $key => $value) 
                {
                    if($value['sold_out_qty']>0)
                    {
                        $available_qty[$key] = $value['quantity'] - $value['sold_out_qty'];
                    }
                    else
                    {
                        $available_qty[$key] = $value['quantity'];
                    }
                }
            }   


            $valume = array_sum($available_qty);

            $current_avg_unit_price = $this->TradeModel
                                            ->where('second_level_category_id',$category['id'])
                                            ->where('trade_type','1')
                                            ->whereBetween('created_at',[$yesterday_date, $current_date]) 
                                            ->whereNull('linked_to')
                                            ->where('is_crypto_trade','0') 
                                            ->avg('unit_price');

            if($valume>0 && $current_avg_unit_price>0)
            {
                $todays_data_arr['category_id']      = $category['id'];            
                $todays_data_arr['avg_volume']       = $valume;
                $todays_data_arr['avg_unit_price']   = $current_avg_unit_price;
                
                $status = $this->TradeBuyHistoryModel->create($todays_data_arr);    
            }

            // $avarage_volume = $this->TradeModel->where('second_level_category_id',$category['id'])
            //                                 ->whereIn('trade_status',[3,4])//buyer completed trade or payment
            //                                 ->whereDate('updated_at','>=',$yesterday_date)
            //                                 ->where('trade_type','0')
            //                                 ->where('linked_to','!=',NULL)
            //                                 ->avg('quantity');

            //calculate current unit price since 24 hours
            // $avg_unit_price = $this->TradeModel->where('second_level_category_id',$category['id'])
            //                                 ->whereDate('updated_at','>=',$yesterday_date)
            //                                 ->whereIn('trade_status',[3,4])//buyer completed trade or payment
            //                                 ->where('trade_type','0')
            //                                 ->where('linked_to','!=',NULL)
            //                                 ->avg('unit_price');

            // if($avarage_volume>0 && $avg_unit_price>0)
            // {
            //     $todays_data_arr['category_id']      = $category['id'];            
            //     $todays_data_arr['avg_volume']       = $avarage_volume;
            //     $todays_data_arr['avg_unit_price']   = $avg_unit_price;
                
            //     $status = $this->TradeBuyHistoryModel->create($todays_data_arr);    
            // }
            
        }
      
        $cron_status->end_datetime = date('c');
        $cron_status->save();
    
        return true;
      
    }
}
