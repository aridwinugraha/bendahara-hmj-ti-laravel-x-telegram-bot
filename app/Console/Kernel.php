<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Telegram\Bot\Laravel\Facades\Telegram;
use DB;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {   
        $tanggal = DB::table('kas_ph')->get();
        $decode_tanggal = json_decode($tanggal);
        
        // inisiasi loop mengambil field tabel telegram
        foreach ($decode_tanggal as $tgl) {
            $test3 = $tgl->tanggal_batas_iuran;
        }

        $this->batasNotif1 = \Carbon\Carbon::parse($test3);

        if (\Carbon\Carbon::now()->between(\Carbon\Carbon::now()->startOfMonth(), $this->batasNotif1)) {

            $schedule->command('command:notifikasi')->everyMinute()->when(function () 
            {
                $count = DB::table('reminder')->count();
        
                if($count == 0) {
                    return FALSE;
                } else {
                    $reminder = DB::table('reminder')->select('notifikasi')->get();
                    $decode_reminder = json_decode($reminder);

                    foreach ($decode_reminder as $rm) {
                        $sec = $rm->notifikasi;
                    }
                    
                    return \App\Cron::shouldIRun('command:notifikasi', $sec);
                }
            });  

        }

        if (\Carbon\Carbon::now() > \Carbon\Carbon::parse($test3)) {
            // $schedule->command('logs:clear')->everyMinute()->when(function () 
            // {
            //     return \App\Cron::shouldIRun('logs:clear', 1440);
            // });  
        }
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