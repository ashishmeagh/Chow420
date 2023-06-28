<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\TradeModel;

use DB;

class CancelCashTrade extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'save:cancel_cash_trade';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancel cash trade if buyer did not upload wire transfer proof within 3 hours after seller accept the trade';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(TradeModel $TradeModel)
    {
        parent::__construct();

        $this->TradeModel = $TradeModel;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {       
        $arr_seller_trade = $arr_trade = [];

        $arr_log['cron_signature'] = $this->signature;
        $arr_log['start_datetime'] = date('c');

        $cron_status = \App\Models\CronLogModel::create($arr_log);

        $current_date_time = date('Y-m-d H:i:s');

        /* Conditions: 
                1. trade type should be buy (trade_type = 0)
                2. trade should be cash market trade (is_crypto_trade = 1)
                3. trade should be accepted by seller(crypto_trade_status = 1)
                4. Get hours between current date time and accepted date time
                5. If hours is more than 3 then cancel the trade
        */

        $arr_trade = $this->TradeModel
                        ->select(DB::raw('*,'.'time_to_sec(timediff("'.$current_date_time.'",`accepted_at`)) /3600 as hours'))
                        ->where('trade_type','0')
                        ->where('is_crypto_trade','1')
                        ->where('crypto_trade_status','1')
                        ->get()->toArray();

        // dd($arr_trade);

        foreach ($arr_trade as $key => $trade) 
        {
            if($trade['hours'] > 3)
            {   
                //cancel the buyer trade
                $this->TradeModel->where('id',$trade['id'])
                                 ->update(['is_cancelled'=>'1']);

                //Get seller details
                $obj_seller_trade = $this->TradeModel
                                         ->where('id',$trade['linked_to'])
                                         ->first();

                if($obj_seller_trade)
                {
                    $arr_seller_trade = $obj_seller_trade->toArray();
                }

                //Get seller sold out quantity
                $seller_sold_out_quantity = isset($arr_seller_trade['sold_out_qty'])?$arr_seller_trade['sold_out_qty']:0;

                //Get buyer quantity
                $buyer_quantity = isset($trade['quantity'])?$trade['quantity']:0;

                //we will get available qty after doing this
                $seller_updated_sold_out_qty = $seller_sold_out_quantity - $buyer_quantity;

                //update the seller sold out qty
                $this->TradeModel->where('id',$trade['linked_to'])
                                 ->update(['sold_out_qty'=>$seller_updated_sold_out_qty]);

            }
        }

        $cron_status->end_datetime = date('c');
        $cron_status->save();
    
        return true;
    }
}
