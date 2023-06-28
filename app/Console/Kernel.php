<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
         '\App\Console\Commands\Ordershipalert',
         '\App\Console\Commands\Shipalert',
         '\App\Console\Commands\Isdelivered',
         '\App\Console\Commands\Trackpackage',
         '\App\Console\Commands\buyeragelink',
         '\App\Console\Commands\AuthorizeNetTransactionChecks',
         '\App\console\Commands\Dropshipper'
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
       /* $schedule->command('save:total-buy-trades')
                 ->daily();*/


       /* $schedule->command('Ordershipalert:seller')
                   ->daily();  */
                   
      /*  $schedule->command('Shipalert:seller')
                   ->daily();   */

              
        // $schedule->command('Trackpackage:seller')
        //            ->daily();            
                
         // $schedule->command('Isdelivered:seller')                     
         //            ->cron('0 0 */3 * *');
          

        $schedule->command('Trackpackage:seller')->twiceDaily(1, 13);

        // $schedule->command('buyeragelink:buyer')->daily(); //commented for showing at 12 noon 7jan21

      //   $schedule->command('Shipalert:seller')->cron('0 0 12 * *'); //uncommented for 12 noon
       //  $schedule->command('Shipalert:seller')->cron('0 0 0 * *'); //uncommented for 12 noon american time and 12 am mid at our indian time


            // Ship order Reminder for pending age verification order
           $schedule->command('Shipalert:seller')->dailyAt('12:00'); //for 12 noon 

           //Reminder for pending age verification order
       //  $schedule->command('buyeragelink:buyer')->cron('0 0 12 * *'); //uncommented for 12 noon commented on 13 jan 21
         $schedule->command('buyeragelink:buyer')->dailyAt('12:00'); //uncommented for 12 noon

         
         $schedule->command('authorize_net_transaction:check')->everyFiveMinutes(); 

         $schedule->command('Dropshipper:ongoingorder')->dailyAt('12:00'); //for 12 noon      
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
