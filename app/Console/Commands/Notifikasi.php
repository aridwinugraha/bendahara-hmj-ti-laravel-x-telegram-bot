<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Telegram\Bot\Laravel\Facades\Telegram;

class Notifikasi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:notifikasi';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notifikasi Telegram';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $count = \DB::table('reminder')->count();
        
        if($count == 0) {
            # code..
        } else {

            $hasil = \DB::table('reminder')->get();

            foreach ($hasil as $item) {

                if ($item->status_iuran == 'belum ada aksi') {
                    Telegram::sendMessage([
                        'chat_id' => $item->chat_id_reminder,
                        'parse_mode' => 'HTML',
                        'text' => $item->pesan_pengingat
                        ]);
                }

                if ($item->status_iuran == 'belum bayar') {
                    Telegram::sendMessage([
                        'chat_id' => $item->chat_id_reminder,
                        'parse_mode' => 'HTML',
                        'text' => $item->pesan_pengingat
                        ]);
                }

                if ($item->status_iuran == 'konfirmasi pembayaran lunas') {
                    Telegram::sendMessage([
                        'chat_id' => $item->chat_id_reminder,
                        'parse_mode' => 'HTML',
                        'text' => $item->pesan_pengingat
                        ]);
                }

                if ($item->status_iuran == 'konfirmasi pembayaran') {
                    Telegram::sendMessage([
                        'chat_id' => $item->chat_id_reminder,
                        'parse_mode' => 'HTML',
                        'text' => $item->pesan_pengingat
                        ]);
                }
            }
        }
    }
}
