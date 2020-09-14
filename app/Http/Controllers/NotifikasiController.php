<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Reminder;
use App\Notifikasi;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Commands\Command;

class NotifikasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $anggota = \App\User::all();

        $notif = Notifikasi::all();

        $count = \DB::table('notifikasi')->count();

        $count_1 = \DB::table('notifikasi')->select('status_notifikasi')->where('status_notifikasi', 'tunggu konfirmasi')->count();
        $count_2 = \DB::table('notifikasi')->select('status_notifikasi')->where('status_notifikasi', 'tunggu konfirmasi lunas')->count();
        $count_3 = \DB::table('notifikasi')->select('status_notifikasi')->where('status_notifikasi', 'tunggu konfirmasi upgrade ke admin')->count();
        $count_4 = \DB::table('notifikasi')->select('status_notifikasi')->where('status_notifikasi', 'tidak setuju')->count();
        $tgl_batas = \DB::table('kas_ph')->select('tanggal_batas_iuran')->where('id', '=', 1)->get();
        $decode_tgl = json_decode($tgl_batas);

            foreach ($decode_tgl as $tgl) {
                $batas_tgl = $tgl->tanggal_batas_iuran;
            }

        $count_total = $count_1+$count_2+$count_3+$count_4;

        return view('admin.notifikasi.index', compact('anggota', 'notif', 'count', 'count_total', 'batas_tgl'));
    }

    public function indexBayar()
    {
        $anggota = \App\User::all();

        $notif = Notifikasi::all();

        $count = \DB::table('notifikasi')->count();

        $count_1 = \DB::table('notifikasi')->select('status_notifikasi')->where('status_notifikasi', 'tunggu konfirmasi')->count();

        return view('admin.notifikasi.bayar', compact('anggota', 'notif', 'count', 'count_1'));
    }
    
    public function indexLunas()
    {
        $anggota = \App\User::all();

        $notif = Notifikasi::all();

        $count = \DB::table('notifikasi')->count();

        $count_2 = \DB::table('notifikasi')->select('status_notifikasi')->where('status_notifikasi', 'tunggu konfirmasi lunas')->count();

        return view('admin.notifikasi.lunas', compact('anggota', 'notif', 'count', 'count_2'));
    }

    public function indexAdmin()
    {
        $anggota = \App\User::all();

        $notif = Notifikasi::all();

        $count = \DB::table('notifikasi')->count();

        $count_3 = \DB::table('notifikasi')->select('status_notifikasi')->where('status_notifikasi', 'tunggu konfirmasi upgrade ke admin')->count();

        return view('admin.notifikasi.admin', compact('anggota', 'notif', 'count', 'count_3'));
    }

    public function indexDenda()
    {
        $anggota = \App\User::all();

        $notif = Notifikasi::all();

        $count = \DB::table('notifikasi')->count();

        $count_4 = \DB::table('notifikasi')->select('status_notifikasi')->where('status_notifikasi', 'tidak setuju')->count();

        $tgl_batas = \DB::table('kas_ph')->select('tanggal_batas_iuran')->where('id', '=', 1)->get();
        $decode_tgl = json_decode($tgl_batas);

            foreach ($decode_tgl as $tgl) {
                $batas_tgl = $tgl->tanggal_batas_iuran;
            }

        return view('admin.notifikasi.denda', compact('anggota', 'notif', 'count', 'count_4', 'batas_tgl'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $ph_iuran = \DB::table('kas_ph')->select('iuran_ph')->where('id', '=', 1)->get();
        $decode_ph = json_decode($ph_iuran);

            foreach ($decode_ph as $iuran) {
                $ph_iuran = $iuran->iuran_ph;
            }

        $users = \DB::table('users')->get();
        
        $update = Notifikasi::find($id);
        
        $update->status_notifikasi = 'setuju';
        

        $data_iuran = \DB::table('users')->select('iuran_kas')->where('username_telegram', $update->username_telegram_notifikasi)->get();
        $decode_iuran_anggota = json_decode($data_iuran);

            foreach ($decode_iuran_anggota as $o) {
                $iuran_data = $o->iuran_kas;
            }

        Reminder::where('username_telegram_reminder', $update->username_telegram_notifikasi)
                ->where('chat_id_reminder', $update->chat_id_notifikasi)
                ->update(['status_iuran' => 'bayar']);

        User::where('username_telegram', $update->username_telegram_notifikasi)
                ->where('chat_id', $update->chat_id_notifikasi)
                ->update(['status_kas' => 'bayar']);
        
        User::where('username_telegram', $update->username_telegram_notifikasi)
                ->where('chat_id', $update->chat_id_notifikasi)
                ->update(['iuran_kas' => $ph_iuran+$iuran_data]);
        
                $update->update();
        
        return redirect()->back()->with('message', 'Data Pembayaran iuran PH disetujui!');
    }

    public function lunas(Request $request, $id)
    {   
        $ph_iuran = \DB::table('kas_ph')->select('iuran_ph')->where('id', '=', 1)->get();
        $decode_ph = json_decode($ph_iuran);

            foreach ($decode_ph as $iuran) {
                $ph_iuran = $iuran->iuran_ph;
            }
        
        $users = \DB::table('users')->get();
        
        $update = Notifikasi::find($id);
        
        $update->status_notifikasi = 'setuju';
        

        $data_iuran = \DB::table('users')->select('iuran_kas')->where('username_telegram', $update->username_telegram_notifikasi)->get();
        $decode_iuran_anggota = json_decode($data_iuran);

            foreach ($decode_iuran_anggota as $o) {
                $iuran_data = $o->iuran_kas;
            }
        
        $data_denda = \DB::table('users')->select('denda')->where('username_telegram', $update->username_telegram_notifikasi)->get();
        $decode_denda_anggota = json_decode($data_denda);

            foreach ($decode_denda_anggota as $den) {
                $denda_data = $den->denda;
            }
            
        Reminder::where('username_telegram_reminder', $update->username_telegram_notifikasi)
                ->where('chat_id_reminder', $update->chat_id_notifikasi)
                ->update(['status_iuran' => 'bayar']);

        User::where('username_telegram', $update->username_telegram_notifikasi)
                ->where('chat_id', $update->chat_id_notifikasi)
                ->update(['status_kas' => 'bayar']);

        User::where('username_telegram', $update->username_telegram_notifikasi)
            ->where('chat_id', $update->chat_id_notifikasi)
            ->update(['iuran_kas' => $update->nominal_bayar+$iuran_data]);
        
        User::where('username_telegram', $update->username_telegram_notifikasi)
            ->where('chat_id', $update->chat_id_notifikasi)
            ->update(['denda' => ($update->nominal_bayar-$ph_iuran)-$denda_data]);
        
            $update->update();

        return redirect()->back()->with('message', 'Data Pembayaran iuran PH dan denda disetujui!');
    }

    public function tidak(Request $request, $id)
    {
        $update = Notifikasi::find($id);
        
        $update->status_notifikasi = 'tidak setuju';

        Reminder::where('username_telegram_reminder', $update->username_telegram_notifikasi)
            ->where('chat_id_reminder', $update->chat_id_notifikasi)
            ->update(['status_iuran' => 'belum bayar']);

        User::where('username_telegram', $update->username_telegram_notifikasi)
            ->where('chat_id', $update->chat_id_notifikasi)
            ->update(['status_kas' => 'belum bayar']);

        $update->update();
        return redirect()->back()->with('message', 'Data tidak disetujui!');
    }

    public function beAdmin($id)
    {
        $update = Notifikasi::find($id);

        User::where('username_telegram', $update->username_telegram_notifikasi)
                ->where('chat_id', $update->chat_id_notifikasi)
                ->update(['level' => 'admin']);
    

        Telegram::sendMessage([
            'chat_id' => $update->chat_id_notifikasi,
            'parse_mode' => 'HTML',
            'text' => "SALAM INFORMATIKA\n"
                        ."Selamat\n"
                        ."Permintaan anda menjadi ADMIN <b>telah disetujui</b>, sekarang anda telah dapat masuk sebagai ADMIN\n"
                        ."\n"
                        ."Terima Kasih\n"
                        ."\n"
                        ."Klik Button 'WEB BENDAHARA HMJ TI' untuk menuju ke web bendahara hmj ti\n"
                        ."\n"
                        ."<i>Jangan Balas Pesan ini dengan perintah APAPUN</i>",
            'reply_markup' => Keyboard::make()
                            ->inline()
                            ->row(
                                Keyboard::inlineButton(['text' => 'Web Bendahara HMJ TI', 'url' => 'http://127.0.0.1:8000/home/']),
                            ),
            ]);

        $update->delete();

        return redirect()->back()->with('message', 'Satu Anggota telah menjadi ADMIN, silahkan cek data anggota terbaru');
    }

    public function beUser($id)
    {
        $update = Notifikasi::find($id);

        Telegram::sendMessage([
            'chat_id' => $update->chat_id_notifikasi,
            'parse_mode' => 'HTML',
            'text' => "SALAM INFORMATIKA\n"
                        ."Maaf\n"
                        ."Permintaan anda menjadi ADMIN <b>tidak disetujui</b>\n"
                        ."\n"
                        ."Terima Kasih\n"
                        ."\n"
                        ."Klik Button 'WEB BENDAHARA HMJ TI' untuk menuju ke web bendahara hmj ti\n"
                        ."\n"
                        ."<i>Jangan Balas Pesan ini dengan perintah APAPUN</i>",
            'reply_markup' => Keyboard::make()
                            ->inline()
                            ->row(
                                Keyboard::inlineButton(['text' => 'Web Bendahara HMJ TI', 'url' => 'http://127.0.0.1:8000/home/']),
                            ),
            ]);

        $update->delete();

        return redirect()->back()->with('message', 'Permintaan menjadi ADMIN tidak disetujui');
    }

    public function denda(Request $request, $id)
    {
        $update = Notifikasi::find($id);

        $denda = \DB::table('kas_ph')->select('denda_ph')->where('id', '=', 1)->get();
        $decode_denda = json_decode($denda);

        foreach ($decode_denda as $d) {
            $ph_denda = $d->denda_ph;
        }
        
        $users = \DB::table('users')->select('denda')->where('username_telegram', $update->username_telegram_notifikasi)->get();
        $decode_users = json_decode($users);

        foreach ($decode_users as $u) {
            $ph_users = $u->denda;
        }

        Reminder::where('username_telegram_reminder', $update->username_telegram_notifikasi)
            ->where('chat_id_reminder', $update->chat_id_notifikasi)
            ->update(['status_iuran' => 'denda']);

        User::where('username_telegram', $update->username_telegram_notifikasi)
            ->where('chat_id', $update->chat_id_notifikasi)
            ->update(['status_kas' => 'denda']);
        
        User::where('username_telegram', $update->username_telegram_notifikasi)
            ->where('chat_id', $update->chat_id_notifikasi)
            ->update(['denda' => $ph_denda+$ph_users]);
        
        $hasil = \DB::table('reminder')->select('chat_id_reminder')->where('status_iuran', '=', 'belum ada aksi')->get();
        $decode_hasil = json_decode($hasil);

        foreach ($decode_hasil as $hs) {
            User::where('chat_id', $hs->chat_id_reminder)
                ->update(['denda' => $ph_denda+$ph_users]);

            User::where('chat_id', $hs->chat_id_reminder)
                ->update(['status_kas' => 'denda']); 
        }

        $tambah = \DB::table('users')->select('denda')->where('username_telegram', $update->username_telegram_notifikasi)->get();
        $decode_tambah = json_decode($tambah);

        foreach ($decode_tambah as $t) {
            $ph_tambah = $t->denda;
        }

        Telegram::sendMessage([
            'chat_id' => $update->chat_id_notifikasi,
            'parse_mode' => 'HTML',
            'text' =>  "<b>SALAM INFORMATIKA</b>\n"
                        ."<b>Pengumuman Penambahan sanksi DENDA PH</b>\n"
                        ."$update->first_nama $update->last_nama\n"
                        ."\n"
                        ."Anda terkonfirmasi tidak membayar iuran kas ph periode bulan lalu\n"
                        ."Maka sanksi yang diberikan berupa penambahan denda PH sebesar <b>Rp. $ph_denda</b>\n"
                        ."\n"
                        ."Dan secara akumulusi saat ini anda memiliki denda PH sebanyak,\n"
                        ."<b>Denda : Rp. $ph_tambah</b>\n"
                        ."\n"
                        ."Terima Kasih\n"
                        ."\n"
                        ."Catatan : <i>Pelunasan denda bisa dilakukan kapan saja selama masa kepengurusan PH anda masih aktif (belum demisioner) dan uang untuk melunasi denda diberikan langsung kepada Bendahara</i>",
            ]);

            $update->delete();
            
            if (\DB::table('notifikasi')->where('status_notifikasi', 'setuju')->count()!=0) {

                \DB::table('notifikasi')->where('status_notifikasi', 'setuju')->delete();

            }

            if (\DB::table('reminder')->where('status_iuran', 'bayar')->count()!=0) {

                \DB::table('reminder')->where('status_iuran', 'bayar')->delete();

            }

            if (\DB::table('reminder')->where('status_iuran', 'belum ada aksi')->count()!=0) {

                \DB::table('reminder')->where('status_iuran', 'belum ada aksi')->delete();

            }

            if (\DB::table('reminder')->where('status_iuran', 'denda')->count()!=0) {

                \DB::table('reminder')->where('status_iuran', 'denda')->delete();

            }

            if (\DB::table('reminder')->count() == 0) {
                
                $user = \DB::table('users')->get();
                $decode_user = json_decode($user);

                foreach ($decode_user as $u) {
                    if ($u->level=='admin') {
                        Telegram::sendMessage([
                            'chat_id' => $u->chat_id,
                            'parse_mode' => 'HTML',
                            'text' => "<b>Pemberitahuan Semua Pengingat Iuran Kas PH Telah Dihapus </b>\n"
                                        ."Kepada ADMIN atau Bendahara\n"
                                        ."Segera Buat Pengingat Iuran Kas PH kepada semua anggota PH\n"
                                        ."Untuk kelancaran transaksi Pembayaran Iuran Kas PH dan pelunasan Sanksi Denda PH pada periode ini\n"
                                        ."dengan klik button link, anda akan langsung beralih ke halaman buat reminder"
                                        ."\n"
                                        ."Terima Kasih...\n"
                                        ."\n"
                                        ."<b>Jangan Membalas Pesan ini dengan perintah Apapun</>\n",
                            'reply_markup' => Keyboard::make()
                            ->inline()
                            ->row(
                                Keyboard::inlineButton(['text' => 'Halaman Buat Reminder', 'url' => "http://127.0.0.1:8000/reminder/create"]),
                            )
                            ]);
                    }
                }
                
            }

        return redirect()->back()->with('message', 'Data Denda bertambah!');

    }
}
