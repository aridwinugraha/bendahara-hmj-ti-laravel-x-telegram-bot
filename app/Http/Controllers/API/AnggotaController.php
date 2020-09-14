<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Notifikasi;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Commands\Command;
use DB;

class AnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $anggota = User::orderBy('npk', 'ASC')->paginate(10);

        $count = \DB::table('users')->count();

        return view('umum.anggota.index', compact('anggota', 'count'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $anggota = \App\User::all();

        $detail = User::find($id);

        return view('umum.anggota.detail', compact('detail', 'anggota'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $anggota = \App\User::all();

        $showById = User::find($id);
        
        return view('umum.anggota.edit', compact('showById', 'anggota'));
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
        $re = '/\b[0IVXLCDM]+\b/';
        $str = $request->npk;
        if(preg_match("#^HMJ/#i", $str)) {
            if (preg_match("#TI/#i", $str)) {
                if(preg_match_all($re, $str)) {
                    if(preg_match("/-/", $str)) {
                        if(strlen($str)>=19) { 
                            $this->validate($request, [
                                'npk' => 'required',
                                'first_name' => 'required',
                                'last_name' => 'required',
                                'email' => 'required',
                                'jk' => 'required',
                                'agama' => 'required',
                                'no_hp' => 'required',
                                'username' => 'required',
                              ]);
                    
                            $ubah = User::find($id);
                            
                            $ubah->npk = $request->npk;
                            $ubah->first_name = $request->first_name;
                            $ubah->last_name = $request->last_name;
                            $ubah->jk = $request->jk;
                            $ubah->agama = $request->agama;
                            $ubah->no_hp = $request->no_hp;
                            $ubah->username = $request->username;
                            
                            $ubah->update();
                    
                            return redirect()->route('anggota.index')->with('message', 'Data berhasil diubah!');
                        } else {
                            return redirect()->back()->withInput()
                            ->withErrors(['Input NPK anda memiliki kesalahan : Harus menyertakan nomor anggota pelantikan anda setelah tahun ajaran pelantikan']);
                        }
                    } else {
                        return redirect()->back()->withInput()
                        ->withErrors(['Input NPK anda memiliki kesalahan : Harus menyertakan tanda strip "-" setelah tahun angkatan anggota dan diantara tahun ajaran pelantikan']);
                    }
                } else {
                    return redirect()->back()->withInput()
                    ->withErrors(['Input NPK anda memiliki kesalahan : Harus menyertakan tahun angkatan anggota dalam angka romawi setelah TI/']);
                }
            } else {
                return redirect()->back()->withInput()
                ->withErrors(['Input NPK anda memiliki kesalahan : Harus menyertakan TI/ setelah HMJ/']);
            }
        } else {
            return redirect()->back()->withInput()
            ->withErrors(['Input NPK anda memiliki kesalahan : Harus menyertakan awalan HMJ/']);
        }
    }

    public function updateRole($id)
    {
        $admin = User::where('level', 'admin')->first();

        $notif = DB::table('notifikasi')->count();

        $showById = User::find($id);

        $user = DB::table('users')->get();

        if ($notif != 0) {

            $notif_1 = DB::table('notifikasi')->select('chat_id_notifikasi')->where('status_notifikasi', 'setuju')->get();
            $decode_setuju = json_decode($notif_1);
    
            foreach ($decode_setuju as $s) {
                $notif_setuju = $s->chat_id_notifikasi;
            }
    
            $notif_2 = DB::table('notifikasi')->select('chat_id_notifikasi')->where('status_notifikasi', 'tidak setuju')->get();
            $decode_tidak_setuju = json_decode($notif_2);
    
            foreach ($decode_tidak_setuju as $ts) {
                $notif_tidak_setuju = $ts->chat_id_notifikasi;
            }
    
            $notif_3 = DB::table('notifikasi')->select('chat_id_notifikasi')->where('status_notifikasi', 'tunggu konfirmasi')->get();
            $decode_bayar = json_decode($notif_3);
    
            foreach ($decode_bayar as $by) {
                $notif_bayar = $by->chat_id_notifikasi;
            }
    
            $notif_4 = DB::table('notifikasi')->select('chat_id_notifikasi')->where('status_notifikasi', 'tunggu konfirmasi lunas')->get();
            $decode_lunas = json_decode($notif_4);
    
            foreach ($decode_lunas as $lu) {
                $notif_lunas = $lu->chat_id_notifikasi;
            }
            
            $notif_5 = DB::table('notifikasi')->select('chat_id_notifikasi')->where('status_notifikasi', 'tunggu konfirmasi upgrade ke admin')->get();
            $decode_admin = json_decode($notif_5);
    
            foreach ($decode_admin as $ad) {
                $notif_admin = $ad->chat_id_notifikasi;
            }

            if ($notif_setuju==$showById->chat_id || $notif_tidak_setuju==$showById->chat_id) {
                Notifikasi::where('chat_id_notifikasi', $showById->chat_id)
                            ->update(['status_notifikasi' => 'tunggu konfirmasi upgrade ke admin']);

                            foreach ($user as $u) {
                                if ($u->level=='admin') {
                                    Telegram::sendMessage([
                                        'chat_id' => $u->chat_id,
                                        'parse_mode' => 'HTML',
                                        'text' => "<b>Pemberitahuan Permintaan Menjadi ADMIN</b>\n"
                                                    ."<b>$showById->name $showById->name_last</b>\n"
                                                    ."Mengirim Permintaan menjadi ADMIN\n"
                                                    ."Untuk Bendahara silahkan konfirmasi permintaan tersebut\n"
                                                    ."dengan klik button link, anda akan langsung beralih ke halaman notifikasi"
                                                    ."\n"
                                                    ."Terima Kasih...\n"
                                                    ."\n"
                                                    ."<b>Jangan Membalas Pesan ini dengan perintah Apapun</b>\n",
                                        'reply_markup' => Keyboard::make()
                                        ->inline()
                                        ->row(
                                            Keyboard::inlineButton(['text' => 'Halaman Notifikasi', 'url' => "http://127.0.0.1:8000/notifikasi/admin"]),
                                        )
                                        ]);
                                }
                            }

                            Telegram::sendMessage([
                                'chat_id' => $showById->chat_id,
                                'parse_mode' => 'HTML',
                                'text' =>   "<b>SALAM INFORMATIKA</b>\n"
                                            ."\n"
                                            ."Permintaan menjadi ADMIN <b>telah terkirim</b>, tunggu email balasan dari ADMIN\n"
                                            ."\n"
                                            ."Klik Button 'WEB BENDAHARA HMJ TI' untuk menuju ke web bendahara hmj ti\n"
                                            ."\n"
                                            ."Terima Kasih\n"
                                            ."\n"
                                            ."<i>Jangan Balas Pesan ini dengan perintah APAPUN</i>",
                                'reply_markup' => Keyboard::make()
                                                ->inline()
                                                ->row(
                                                    Keyboard::inlineButton(['text' => 'Web Bendahara HMJ TI', 'url' => 'http://127.0.0.1:8000/home/']),
                                                ),
                                ]);
                
                            return redirect()->route('home')->with('message', 'Permintaan menjadi ADMIN telah terkirim, tunggu email balasan dari ADMIN');

            } elseif($notif_bayar==$showById->chat_id || $notif_lunas==$showById->chat_id) {        
                Notifikasi::create([
                    'first_nama' => $showById->name,
                    'last_nama' => $showById->name_last,
                    'username_telegram_notifikasi' => $showById->username_telegram,
                    'chat_id_notifikasi' => $showById->chat_id,
                    'nominal_bayar' => 0,
                    'status_notifikasi' => 'tunggu konfirmasi upgrade ke admin'
                    ]);
                
                foreach ($user as $u) {
                    if ($u->level=='admin') {
                        Telegram::sendMessage([
                            'chat_id' => $u->chat_id,
                            'parse_mode' => 'HTML',
                            'text' => "<b>Pemberitahuan Permintaan Menjadi ADMIN</b>\n"
                                        ."<b>$showById->name $showById->name_last</b>\n"
                                        ."Mengirim Permintaan menjadi ADMIN\n"
                                        ."Untuk Bendahara silahkan konfirmasi permintaan tersebut\n"
                                        ."dengan klik button link, anda akan langsung beralih ke halaman notifikasi"
                                        ."\n"
                                        ."Terima Kasih...\n"
                                        ."\n"
                                        ."<b>Jangan Membalas Pesan ini dengan perintah Apapun</b>\n",
                            'reply_markup' => Keyboard::make()
                            ->inline()
                            ->row(
                                Keyboard::inlineButton(['text' => 'Halaman Notifikasi', 'url' => "http://127.0.0.1:8000/notifikasi/admin"]),
                            )
                            ]);
                    }
                }

                Telegram::sendMessage([
                    'chat_id' => $showById->chat_id,
                    'parse_mode' => 'HTML',
                    'text' =>   "<b>SALAM INFORMATIKA</b>\n"
                                ."\n"
                                ."Permintaan menjadi ADMIN <b>telah terkirim</b>, tunggu email balasan dari ADMIN\n"
                                ."\n"
                                ."Klik Button 'WEB BENDAHARA HMJ TI' untuk menuju ke web bendahara hmj ti\n"
                                ."\n"
                                ."Terima Kasih\n"
                                ."\n"
                                ."<i>Jangan Balas Pesan ini dengan perintah APAPUN</i>",
                    'reply_markup' => Keyboard::make()
                                    ->inline()
                                    ->row(
                                        Keyboard::inlineButton(['text' => 'Web Bendahara HMJ TI', 'url' => 'http://127.0.0.1:8000/home/']),
                                    ),
                    ]);

                return redirect()->route('home')->with('message', 'Permintaan menjadi ADMIN telah terkirim, tunggu email balasan dari ADMIN');
            }
        } elseif($notif_admin==$showById->chat_id) {
            
            Telegram::sendMessage([
                'chat_id' => $showById->chat_id,
                'parse_mode' => 'HTML',
                'text' =>   "Maaf, sebelumnya anda telah mengirim permintaan menjadi ADMIN\n"
                            ."\n"
                            ."Mohon untuk tidak mengirim permintaan terus-menerus dan tunggu konfirmasi dari bendahara\n"
                            ."\n"
                            ."Terima Kasih\n"
                            ."\n"
                            ."<i>Jangan Balas Pesan ini dengan perintah APAPUN</i>"
            ]);

            return redirect()->route('home')->with('message', 'Anda Sebelumnya telah mengirim permintaan menjadi ADMIN, mohon tunggu konfirmasi dari bendahara');
        }
        
    }
}
    