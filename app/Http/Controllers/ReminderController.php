<?php

namespace App\Http\Controllers;

use App\Kasph;
use App\Notifikasi;
use App\Reminder;
use App\User;
use DB;
use Illuminate\Http\Request;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;

class ReminderController extends Controller
{
    protected $telegram;
    protected $chat_id;
    protected $username;
    protected $text;
    protected $first_name;
    protected $last_name;

    public function __construct()
    {
        $this->telegram = new Api(config('telegram.bots.common.token'));
    }

    public function index()
    {
        $anggota = \App\User::all();

        $reminder = Reminder::orderBy('first_nama_tujuan', 'ASC')->paginate(10);

        $count = DB::table('reminder')->count();

        return view('admin.reminder.index', compact('anggota', 'reminder', 'count'));
    }

    public function findNomorPenerima($id)
    {
        $data = User::select('name', 'name_last', 'username_telegram', 'chat_id', 'no_hp', 'denda')->where('id', '=', $id)->get();

        return response()->json($data);
    }

    public function findIuranPh($id = 1)
    {
        $data = Kasph::select('iuran_ph')->where('id', '=', 1)->get();

        return response()->json($data);
    }

    public function create()
    {
        $anggota = \App\User::all();

        $reminder = new Reminder();

        $decode_user = \DB::table('users')->where('status_anggota', 'Pengurus Harian')->get();
        $user = json_decode($decode_user);

        $kasph = Kasph::all();

        $count_ph = \DB::table('kas_ph')->count();

        return view('admin.reminder.create', compact('anggota', 'reminder', 'user', 'kasph', 'count_ph'));
    }

    public function store(Request $request)
    {
        if ($request->pilihan == 'all') {

            $iuran = \DB::table('kas_ph')->select('iuran_ph', 'tanggal_batas_iuran')->where('id', '=', 1)->get();
            $decode_iuran = json_decode($iuran);

            foreach ($decode_iuran as $ui) {
                $ph_iuran = $ui->iuran_ph;
                $tgl_batas = $ui->tanggal_batas_iuran;
            }

            $carbon_tgl = \Carbon\Carbon::parse($tgl_batas)->isoFormat('D MMMM Y');

            $user = \DB::table('users')->select('name', 'name_last', 'username_telegram', 'chat_id', 'no_hp', 'denda')->where('status_anggota', 'Pengurus Harian')->get();
            $decode_users = json_decode($user);

            $this->validate($request, [
                'first_nama_tujuan' => 'required',
                'last_nama_tujuan' => 'required',
                'username_telegram_reminder' => 'required',
                'chat_id_reminder' => 'required',
                'no_hp_tujuan' => 'required',
                'nominal' => 'required',
                'notifikasi' => 'required']);

            foreach ($decode_users as $us) {
                Reminder::create([
                    'first_nama_tujuan' => $us->name,
                    'last_nama_tujuan' => $us->name_last,
                    'username_telegram_reminder' => $us->username_telegram,
                    'chat_id_reminder' => $us->chat_id,
                    'no_hp_tujuan' => $us->no_hp,
                    'nominal' => $us->denda + $ph_iuran,
                    'notifikasi' => $request->notifikasi,
                    'status_iuran' => 'belum ada aksi',
                    'pesan_pengingat' => "<b>PENGINGAT</b>\n"
                    . "<b>Salam Informatika</b>\n"
                    . "<b>$us->name $us->name_last</b>, Anda memiliki tagihan kas PH yang belum terbayar\n"
                    . "Iuran tersebut sebesar <b>Rp. $ph_iuran</b>\n"
                    . "tanggal batas pembayaran hingga <b>$carbon_tgl</b>\n"
                    . "segeralah membayar sebelum batas waktu\n"
                    . "jika tidak membayar hingga batas waktu\n"
                    . "maka otomatis akan dikenai Denda\n"
                    . "\n"
                    . "<b>Cara Membalas Pesan (jika siap atau belum membayar) :</b>\n"
                    . "\n"
                    . "Balas /bayar\n"
                    . "jika telah benar-benar membayar iuran PH,\n"
                    . "\n"
                    . "Balas /belum\n"
                    . "jika belum membayar iuran.\n"
                    . "\n"
                    . "<b>Terima Kasih</b>",
                ]);
            }

            return redirect()->route('reminder.index')->with('message', 'Data berhasil ditambah!');

        } else {

            $this->validate($request, [
                'first_nama_tujuan' => 'required',
                'last_nama_tujuan' => 'required',
                'username_telegram_reminder' => 'required',
                'chat_id_reminder' => 'required',
                'no_hp_tujuan' => 'required',
                'nominal' => 'required',
                'notifikasi' => 'required',
                'pesan_pengingat' => 'required']);

            $simpan = new Reminder();

            $simpan->first_nama_tujuan = $request->first_nama_tujuan;
            $simpan->last_nama_tujuan = $request->last_nama_tujuan;
            $simpan->username_telegram_reminder = $request->username_telegram_reminder;
            $simpan->chat_id_reminder = $request->chat_id_reminder;
            $simpan->no_hp_tujuan = $request->no_hp_tujuan;
            $simpan->nominal = $request->nominal;
            $simpan->notifikasi = $request->notifikasi;
            $simpan->status_iuran = 'belum ada aksi';
            $simpan->pesan_pengingat = $request->pesan_pengingat;

            $simpan->save();

            return redirect()->route('reminder.index')->with('message', 'Data berhasil ditambah!');

        }
    }

    public function edit($id)
    {
        $anggota = \App\User::all();

        $showById = Reminder::find($id);

        $user = User::all();

        $kasph = Kasph::all();

        return view('admin.reminder.edit', compact('anggota', 'showById', 'user', 'kasph'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'first_nama_tujuan' => 'required',
            'last_nama_tujuan' => 'required',
            'username_telegram_reminder' => 'required',
            'chat_id_reminder' => 'required',
            'no_hp_tujuan' => 'required',
            'nominal' => 'required',
            'notifikasi' => 'required',
            'pesan_pengingat' => 'required']);

        $update = Reminder::find($id);

        $update->first_nama_tujuan = $request->first_nama_tujuan;
        $update->last_nama_tujuan = $request->last_nama_tujuan;
        $update->username_telegram_reminder = $request->username_telegram_reminder;
        $update->chat_id_reminder = $request->chat_id_reminder;
        $update->no_hp_tujuan = $request->no_hp_tujuan;
        $update->nominal = $request->nominal;
        $update->notifikas = $request->notifikasi;
        $update->pesan_pengingat = $request->pesan_pengingat;

        $update->update();

        return redirect()->route('reminder.index')->with('message', 'Data berhasil diubah!');
    }

    public function destroy($id)
    {
        $reminder = Reminder::find($id);
        $reminder->delete();
        DB::table('crons')->where('command', '=', 'command:notifikasi')->delete();

        return redirect()->back()->with('message', 'Data berhasil dihapus!');
    }

    // public function setWebHook()
    // {
    //     $url = 'https://bendahara-hmjti.herokuapp.com/' . config('telegram.bots.common.token') . '/webhook';
    //     $response = $this->telegram->setWebhook(['url' => $url]);

    //     return $response == true ? redirect()->back() : dd($response);
    // }

    public function handleRequest(Request $request)
    {
        $this->chat_id = $request['message']['chat']['id'];
        $this->username = $request['message']['from']['username'];
        $this->first_name = $request['message']['from']['first_name'];
        $this->last_name = $request['message']['from']['last_name'];
        $this->text = $request['message']['text'];

        $telegram = DB::table('users')->select('username_telegram', 'chat_id')->where('chat_id', $this->chat_id)->get();
        $decode = json_decode($telegram);

        if ($this->text == '/start d2Aklc2PKp5bUtTt' && $decode == null) {
            $this->showStartStore();
        } elseif ($this->text == '/start d2Aklc2PKp5bUtTt' && $decode != null) {
            $this->showStart();
        } elseif ($this->text == '/start') {
            $this->showStart();
        } elseif ($this->text == '/menu') {
            $this->showMenu();
        } elseif ($this->text == '/reminder') {
            $this->showReminder();
        } elseif ($this->text == '/iuran') {
            $this->infoIuranKas();
        } elseif ($this->text == '/bayar') {
            $this->updateIuranBayar();
        } elseif ($this->text == '/belum') {
            $this->updateIuranDenda();
        } elseif ($this->text == '/lunas') {
            $this->updateIuranLunas();
        } else {
            $this->errorCommand();
        }
    }

    public function showStartStore()
    {
        User::where('name', $this->first_name)
            ->where('name_last', $this->last_name)
            ->update(['username_telegram' => $this->username]);

        User::where('name', $this->first_name)
            ->where('name_last', $this->last_name)
            ->update(['chat_id' => $this->chat_id]);

        $username = DB::table('users')->select('username_telegram')->where('username_telegram', $this->username)->get();
        $decode_username = json_decode($username);

        $chat = DB::table('users')->select('chat_id')->where('chat_id', $this->chat_id)->get();
        $decode_chat = json_decode($chat);

        if ($decode_username == null) {
            $message = "Maaf Nama Depan(first name) akun telegram anda berbeda dengan nama depan akun web hmj ti anda\n";
            $message .= "Mohon ubah Nama Depan(first name) akun telegram anda sesuaikan dengan nama depan akun web hmj ti anda";
            $message .= "jika anda telah mengubah Nama Depan akun telegram anda, silahkan mengunjungi web bendahara HMJ TI klik button link dibawah ini... \n";
            $keyboard = Keyboard::make()
                ->inline()
                ->row(
                    Keyboard::inlineButton(['text' => 'Web Bendahara HMJ TI', 'url' => 'http://127.0.0.1:8000/home/']),
                );
        } elseif ($decode_chat == null) {
            $message = "Maaf Nama Belakang(last name) akun telegram anda berbeda dengan nama depan akun web hmj ti anda\n";
            $message .= "Mohon ubah Nama Belakang(last name) akun telegram anda sesuaikan dengan nama depan akun web hmj ti anda";
            $message .= "jika anda telah mengubah Nama Belakang akun telegram anda, silahkan mengunjungi web bendahara HMJ TI klik button link dibawah ini... \n";
            $keyboard = Keyboard::make()
                ->inline()
                ->row(
                    Keyboard::inlineButton(['text' => 'Web Bendahara HMJ TI', 'url' => 'http://127.0.0.1:8000/home/']),
                );
        } elseif ($decode_username == null && $decode_chat == null) {
            $message = "Maaf Nama Depan(first name) dan Nama Belakang(last name) akun telegram anda berbeda dengan nama depan dan nama belakang akun web hmj ti anda\n";
            $message .= "Mohon ubah Nama Depan(first name) dan Nama Belakang(last name) akun telegram anda sesuaikan dengan nama depan dan nama belakang akun web hmj ti anda";
            $message .= "jika anda telah mengubah Nama Depan dan Nama Belakang akun telegram anda, silahkan mengunjungi web bendahara HMJ TI klik button link dibawah ini... \n";
            $keyboard = Keyboard::make()
                ->inline()
                ->row(
                    Keyboard::inlineButton(['text' => 'Web Bendahara HMJ TI', 'url' => 'http://127.0.0.1:8000/home/']),
                );
        } else {
            $message = "Selamat Datang, akun anda telah dikenali oleh BOT Bendahara\n";
            $message .= "BOT ini menyediakan beberapa pilihan perintah :\n";
            $message .= '/menu' . chr(10);
            $message .= '/reminder' . chr(10);
            $message .= '/iuran' . chr(10);
            $message .= "atau jika anda ingin kembali mengunjungi web bendahara HMJ TI klik button link dibawah ini... \n";
            $keyboard = Keyboard::make()
                ->inline()
                ->row(
                    Keyboard::inlineButton(['text' => 'Web Bendahara HMJ TI', 'url' => 'http://127.0.0.1:8000/home/']),
                );
        }

        $this->replyWithMessage($message, $keyboard);
    }

    public function showStart()
    {
        $message = "Data anda telah tersimpan dalam database\n";
        $message .= "Mohon tidak masukkan perintah /start lagi\n";
        $message .= "Mohon masukkan perintah dibawah ini : \n";
        $message .= '/menu' . chr(10);
        $message .= '/reminder' . chr(10);
        $message .= '/iuran' . chr(10);

        $this->sendMessage($message);
    }

    public function showMenu($info = null)
    {
        $message = "";
        if ($info) {
            $message .= $info . chr(10);
        }
        $message .= '/menu' . chr(10);
        $message .= '/reminder' . chr(10);
        $message .= '/iuran' . chr(10);

        $this->sendMessage($message);
    }

    public function showReminder()
    {
        $username = DB::table('reminder')->select('chat_id_reminder')->where('chat_id_reminder', $this->chat_id)->count();

        $kas_ph = DB::table('kas_ph')->count();

        if ($kas_ph != 0) {
            if ($username != 0) {
                $date_batas = DB::table('kas_ph')->select('tanggal_batas_iuran')->where('id', '=', 1)->get();
                $decode_date_batas = json_decode($date_batas);

                foreach ($decode_date_batas as $d) {
                    $batas = $d->tanggal_batas_iuran;
                }
                $tgl = \Carbon\Carbon::parse($batas)->isoFormat('D MMMM Y');
                $tgl_batas = \Carbon\Carbon::parse($batas);

                if (\Carbon\Carbon::now() <= $tgl_batas) {

                    $st_iuran = DB::table('reminder')->select('status_iuran')->where('chat_id_reminder', $this->chat_id)->get();
                    $decode_stiuran = json_decode($st_iuran);
            
                    foreach ($decode_stiuran as $stiu) {
                        $status_iuran = $stiu->status_iuran;
                    }

                    if ($status_iuran != 'bayar') {
    
                        $depan = DB::table('reminder')->select('first_nama_tujuan')->where('chat_id_reminder', $this->chat_id)->get();
                        $decode_depan = json_decode($depan);

                        foreach ($decode_depan as $dpn) {
                            $nama_depan = $dpn->first_nama_tujuan;
                        }

                        $belakang = DB::table('reminder')->select('last_nama_tujuan')->where('chat_id_reminder', $this->chat_id)->get();
                        $decode_belakang = json_decode($belakang);

                        foreach ($decode_belakang as $blkg) {
                            $nama_belakang = $blkg->last_nama_tujuan;
                        }

                        $mentah_nominal = DB::table('reminder')->select('nominal')->where('chat_id_reminder', $this->chat_id)->get();
                        $decode_nominal = json_decode($mentah_nominal);

                        foreach ($decode_nominal as $n) {
                            $nominal = $n->nominal;
                        }

                        $kas_ph_iuran = DB::table('kas_ph')->select('iuran_ph')->where('id', '=', 1)->get();
                        $decode_iuran_ph = json_decode($kas_ph_iuran);

                        foreach ($decode_iuran_ph as $kas) {
                            $iuran_kas_ph = $kas->iuran_ph;
                        }

                        $denda = DB::table('users')->select('denda')->where('chat_id', $this->chat_id)->get();
                        $decode_denda = json_decode($denda);

                        foreach ($decode_denda as $dnd) {
                            $denda_ph = $dnd->denda;
                        }

                        if ($denda_ph != 0) {
                            $message = "<b>PENGINGAT</b>\n"
                                . "<b>Salam Informatika</>\n"
                                . "<b>$nama_depan $nama_belakang</b>, Anda memiliki tagihan kas PH yang belum terbayar\n"
                                . "dengan rincian sebagai berikut :\n"
                                . "Iuran PH sebesar : <b>Rp. $iuran_kas_ph</b>\n"
                                . "Denda Anda sebesar : <b>Rp. $denda_ph</b>\n"
                                . "Total Yang harus dilunasi sebesar <b>Rp. $nominal</b>\n"
                                . "Untuk pembayaran denda dapat dilakukan diluar batas waktu bayar iuran kas PH periode bulan ini"
                                . "tanggal batas pembayaran iuran kas PH hingga <b>$tgl</b>\n"
                                . "segeralah membayar sebelum batas waktu\n"
                                . "jika tidak membayar hingga batas waktu\n"
                                . "maka otomatis akan dikenai Denda\n"
                                . "\n"
                                . "<b>Cara Membalas Pesan (jika siap atau belum membayar) :</b>\n"
                                . "\n"
                                . "Balas /bayar\n"
                                . "jika telah benar-benar membayar iuran PH,\n"
                                . "\n"
                                . "Balas /lunas\n"
                                . "jika telah benar-benar membayar iuran PH dan melunasi denda Anda,\n"
                                . "\n"
                                . "Balas /belum\n"
                                . "jika belum membayar iuran.\n"
                                . "\n"
                                . "<b>Terima Kasih</b>";
                        } else {
                            $message = "<b>PENGINGAT</b>\n"
                                . "<b>Salam Informatika</>\n"
                                . "<b>$nama_depan $nama_belakang</b>, Anda memiliki tagihan kas PH yang belum terbayar\n"
                                . "dengan rincian sebagai berikut :\n"
                                . "Iuran PH sebesar : <b>Rp. $iuran_kas_ph</b>\n"
                                . "Denda Anda sebesar : <b>Rp. $denda_ph</b>\n"
                                . "Total Yang harus dilunasi sebesar <b>Rp. $nominal</b>\n"
                                . "tanggal batas pembayaran iuran kas PH hingga <b>$tgl</b>\n"
                                . "segeralah membayar sebelum batas waktu\n"
                                . "jika tidak membayar hingga batas waktu\n"
                                . "maka otomatis akan dikenai Denda\n"
                                . "\n"
                                . "<b>Cara Membalas Pesan (jika siap atau belum membayar) :</b>\n"
                                . "\n"
                                . "Balas /bayar\n"
                                . "jika telah benar-benar membayar iuran PH,\n"
                                . "\n"
                                . "Balas /belum\n"
                                . "jika belum membayar iuran.\n"
                                . "\n"
                                . "<b>Terima Kasih</b>";
                        }

                    } elseif ($status_iuran == 'bayar') {
                        $message = "Anda sudah membayar iuran kas PH periode bulan ini.";
                    }

                } else {
                    $message = "batas waktu reminder iuran kas PH telah melampaui batas waktu";
                }
            } else {
                $message = "Pengingat Iuran Kas PH Untuk Anda ($this->first_name $this->last_name) belum dibuat";
            }
        } else {
            $message = "Maaf, Data Iuran Ph, denda ph dan Tanggal Batas Iuran PH belum dibuat oleh ADMIN";
        }

        $this->sendMessage($message);
    }

    public function infoIuranKas()
    {
        $first_name = DB::table('users')->select('name')->where('chat_id', $this->chat_id)->get();
        $decode_awal = json_decode($first_name);

        foreach ($decode_awal as $awal) {
            $nama_awal = $awal->name;
        }

        $last_name = DB::table('users')->select('name_last')->where('chat_id', $this->chat_id)->get();
        $decode_akhir = json_decode($last_name);

        foreach ($decode_akhir as $akhir) {
            $nama_akhir = $akhir->name_last;
        }

        $iuran = DB::table('users')->select('iuran_kas')->where('chat_id', $this->chat_id)->get();
        $decode_iuran = json_decode($iuran);

        foreach ($decode_iuran as $ir) {
            $iuran_ph = $ir->iuran_kas;
        }

        $denda = DB::table('users')->select('denda')->where('chat_id', $this->chat_id)->get();
        $decode_denda = json_decode($denda);

        foreach ($decode_denda as $dnd) {
            $denda_ph = $dnd->denda;
        }

        $message = "<b>Info Iuran Kas</b>\n"
            . "Nama        : <b>$nama_awal $nama_akhir</b>\n"
            . "Iuran Kas : <b>Rp. $iuran_ph</b>\n"
            . "Denda       : <b>Rp. $denda_ph</b>\n"
            . "\n"
            . "<b>Terima Kasih</b>\n"
            . "\n"
            . "<i>cat : denda akan bertambah jika anda tidak membayar iuran kas hingga lewat batas waktu pembayaran</i>";

        $this->sendMessage($message);
    }

    public function updateIuranBayar()
    {
        $kas_ph = DB::table('kas_ph')->count();

        $reminder = DB::table('reminder')->count();

        if ($kas_ph != 0) {
            if ($reminder != 0) {
                $date = DB::table('kas_ph')->select('tanggal_batas_iuran')->where('id', '=', 1)->get();
                $decode_date = json_decode($date);

                foreach ($decode_date as $d) {
                    $batas = $d->tanggal_batas_iuran;
                }
                $tgl = \Carbon\Carbon::parse($batas);

                if (\Carbon\Carbon::now() <= $tgl) {

                    $notif_chat_id = DB::table('notifikasi')->select('chat_id_notifikasi')->where('chat_id_notifikasi', $this->chat_id)->count();

                    if ($notif_chat_id != 0) {

                        $status = DB::table('reminder')->select('status_iuran')->where('chat_id_reminder', $this->chat_id)->get();
                        $status_decode = json_decode($status);

                        foreach ($status_decode as $s) {
                            $iuran_status = $s->status_iuran;
                        }

                        $iuran = DB::table('kas_ph')->select('iuran_ph')->where('id', '=', 1)->get();
                        $decode_iuran = json_decode($iuran);

                        foreach ($decode_iuran as $iu) {
                            $iuran_ph = $iu->iuran_ph;
                        }

                        $user = DB::table('users')->get();
                        $decode_user = json_decode($user);

                        if ($iuran_status == 'belum ada aksi' || $iuran_status == 'belum bayar' || $iuran_status == 'konfirmasi pembayaran lunas') {

                            Reminder::where('username_telegram_reminder', $this->username)
                                ->where('chat_id_reminder', $this->chat_id)
                                ->update(['status_iuran' => 'konfirmasi pembayaran']);

                            Notifikasi::where('chat_id_notifikasi', $this->chat_id)
                                ->update(['status_notifikasi' => 'tunggu konfirmasi']);

                            Notifikasi::where('chat_id_notifikasi', $this->chat_id)
                                ->update(['nominal_bayar' => $iuran_ph]);

                            $message = "Data Iuran anda telah diperbaharui\n";
                            $message .= 'Terima Kasih...';

                            foreach ($decode_user as $u) {
                                if ($u->level == 'admin') {
                                    Telegram::sendMessage([
                                        'chat_id' => $u->chat_id,
                                        'parse_mode' => 'HTML',
                                        'text' => "<b>Pemberitahuan Pembayaran Iuran kas PH</b>\n"
                                        . "<b>$depan_nama $belakang_nama</b>\n"
                                        . "Telah melakukan pembayaran Iuran Kas Ph\n"
                                        . "Untuk Bendahara silahkan konfirmasi pembayaran tersebut\n"
                                        . "dengan klik button link, anda akan langsung beralih ke halaman notifikasi"
                                        . "\n"
                                        . "Terima Kasih...\n"
                                        . "\n"
                                        . "<b>Jangan Membalas Pesan ini dengan perintah Apapun</b>\n",
                                        'reply_markup' => Keyboard::make()
                                            ->inline()
                                            ->row(
                                                Keyboard::inlineButton(['text' => 'Halaman Notifikasi', 'url' => "http://127.0.0.1:8000/notifikasi/konfirmasi/bayar"]),
                                            ),
                                    ]);
                                }
                            }

                        } elseif ($iuran_status == 'konfirmasi pembayaran') {
                            $message = "Maaf anda sebelumnya telah membalas pesan perintah /bayar\n";
                            $message .= "Maka untuk proses perintah /bayar tidak dijalankan\n";
                            $message .= "Mohon untuk menunggu konfirmasi pembayaran anda yang dilakukan bendahara\n";
                            $message .= "Terima Kasih...";

                        } elseif ($iuran_status == 'bayar') {
                            $message = "Anda terkonfirmasi telah membayar iuran kas PH\n";
                            $message .= 'Terima Kasih...';
                        }

                    } else {
                        $first_nama = DB::table('users')->select('name')->where('chat_id', $this->chat_id)->get();
                        $decode_first = json_decode($first_nama);

                        foreach ($decode_first as $first) {
                            $depan_nama = $first->name;
                        }

                        $last_nama = DB::table('users')->select('name_last')->where('chat_id', $this->chat_id)->get();
                        $decode_last = json_decode($last_nama);

                        foreach ($decode_last as $last) {
                            $belakang_nama = $last->name_last;
                        }

                        $status = DB::table('reminder')->select('status_iuran')->where('chat_id_reminder', $this->chat_id)->get();
                        $status_decode = json_decode($status);

                        foreach ($status_decode as $s) {
                            $iuran_status = $s->status_iuran;
                        }

                        $iuran = DB::table('kas_ph')->select('iuran_ph')->where('id', '=', 1)->get();
                        $decode_iuran = json_decode($iuran);

                        foreach ($decode_iuran as $iu) {
                            $iuran_ph = $iu->iuran_ph;
                        }

                        $user = DB::table('users')->get();
                        $decode_user = json_decode($user);

                        if ($iuran_status == 'belum ada aksi' || $iuran_status == 'konfirmasi pembayaran lunas' || $iuran_status == 'belum bayar') {

                            Notifikasi::create([
                                'first_nama' => $depan_nama,
                                'last_nama' => $belakang_nama,
                                'username_telegram_notifikasi' => $this->username,
                                'chat_id_notifikasi' => $this->chat_id,
                                'nominal_bayar' => $iuran_ph,
                                'status_notifikasi' => 'tunggu konfirmasi',
                            ]);

                            Reminder::where('username_telegram_reminder', $this->username)
                                ->where('chat_id_reminder', $this->chat_id)
                                ->update(['status_iuran' => 'konfirmasi pembayaran']);

                            $message = "Data Iuran anda telah diperbaharui\n";
                            $message .= 'Terima Kasih...';

                            foreach ($decode_user as $u) {
                                if ($u->level == 'admin') {
                                    Telegram::sendMessage([
                                        'chat_id' => $u->chat_id,
                                        'parse_mode' => 'HTML',
                                        'text' => "<b>Pemberitahuan Pembayaran Iuran kas PH</b>\n"
                                        . "<b>$depan_nama $belakang_nama</b>\n"
                                        . "Telah melakukan pembayaran Iuran Kas Ph\n"
                                        . "Untuk Bendahara silahkan konfirmasi pembayaran tersebut\n"
                                        . "dengan klik button link, anda akan langsung beralih ke halaman notifikasi"
                                        . "\n"
                                        . "Terima Kasih...\n"
                                        . "\n"
                                        . "<b>Jangan Membalas Pesan ini dengan perintah Apapun</b>\n",
                                        'reply_markup' => Keyboard::make()
                                            ->inline()
                                            ->row(
                                                Keyboard::inlineButton(['text' => 'Halaman Notifikasi', 'url' => "http://127.0.0.1:8000/notifikasi/konfirmasi/bayar"]),
                                            ),
                                    ]);
                                }
                            }

                        }
                    }

                } else {

                    $status = DB::table('reminder')->select('status_iuran')->where('chat_id_reminder', $this->chat_id)->get();
                    $status_decode = json_decode($status);

                    foreach ($status_decode as $s) {
                        $iuran_status = $s->status_iuran;
                    }
                    if ((\Carbon\Carbon::now() > $tgl && $iuran_status == 'denda') || (\Carbon\Carbon::now() > $tgl && $iuran_status == 'belum ada aksi') || (\Carbon\Carbon::now() > $tgl && $iuran_status == 'konfirmasi pembayaran') || (\Carbon\Carbon::now() > $tgl && $iuran_status == 'konfirmasi pembayaran lunas' || $iuran_status == 'belum bayar')) {
                        $message = "Anda terkonfirmasi tidak melakukan iuran kas PH periode bulan lalu\n";
                        $message .= "Denda anda telah bertambah, untuk info selanjutnya ketik perintah /iuran\n";
                        $message .= "Terima Kasih...";
                    }

                    if ((\Carbon\Carbon::now() > $tgl && $iuran_status == 'bayar')) {
                        $message = "Anda terkonfirmasi telah membayar iuran kas PH periode bulan lalu\n";
                        $message .= "Terima Kasih...";
                    }
                }
            } else {
                $message = "Pengingat Iuran Kas PH Untuk Anda ($this->first_name $this->last_name) belum dibuat";
            }
        } else {
            $message = "Maaf, Data Iuran Ph, denda ph dan Tanggal Batas Iuran PH belum dibuat oleh ADMIN";
        }

        $this->sendMessage($message);
    }

    public function updateIuranDenda()
    {

        $kas_ph = DB::table('kas_ph')->count();

        $reminder = DB::table('reminder')->count();

        if ($kas_ph != 0) {
            if ($reminder != 0) {

                $date = DB::table('kas_ph')->select('tanggal_batas_iuran')->where('id', '=', 1)->get();
                $decode_date = json_decode($date);

                foreach ($decode_date as $d) {
                    $batas = $d->tanggal_batas_iuran;
                }
                $tgl = \Carbon\Carbon::parse($batas);

                if (\Carbon\Carbon::now() <= $tgl) {

                    $status = DB::table('reminder')->select('status_iuran')->where('chat_id_reminder', $this->chat_id)->get();
                    $status_decode = json_decode($status);

                    foreach ($status_decode as $s) {
                        $iuran_status = $s->status_iuran;
                    }

                    $notif_chat_id = DB::table('notifikasi')->select('chat_id_notifikasi')->where('chat_id_notifikasi', $this->chat_id)->count();

                    if ($notif_chat_id != 0) {
                        if ($iuran_status == 'konfirmasi pembayaran') {
                            $message = "Maaf anda sebelumnya telah membalas pesan perintah /bayar\n";
                            $message .= "Maka untuk proses perintah /belum tidak dijalankan\n";
                            $message .= "Mohon untuk menunggu konfirmasi pembayaran anda yang dilakukan bendahara\n";
                            $message .= "Terima Kasih...";

                        } elseif ($iuran_status == 'konfirmasi pembayaran lunas') {
                            $message = "Maaf anda sebelumnya telah membalas pesan perintah /lunas\n";
                            $message .= "Maka untuk proses perintah /belum tidak dijalankan\n";
                            $message .= "Mohon untuk menunggu konfirmasi pembayaran anda yang dilakukan bendahara\n";
                            $message .= "Terima Kasih...";

                        } elseif ($iuran_status == 'bayar') {
                            $message = "Anda terkonfirmasi telah membayar iuran kas PH periode bulan ini\n";
                            $message .= "Maka untuk proses perintah /belum tidak dijalankan\n";
                            $message .= "Terima Kasih...";

                        } elseif ($iuran_status == 'denda') {
                            $message = "Anda terkonfirmasi tidak membayar iuran kas PH periode bulan ini\n";
                            $message .= "Maka untuk proses perintah /belum tidak dijalankan\n";
                            $message .= "Terima Kasih...";

                        } elseif ($iuran_status == 'belum bayar') {
                            $message = "Maaf anda sebelumnya telah membalas pesan perintah /belum\n";
                            $message .= "Maka untuk proses perintah /belum tidak dijalankan\n";
                            $message .= "Mohon untuk segera membayar iuran kas PH....\n";
                            $message .= "Terima Kasih...";
                        }

                    } else {

                        $denda = DB::table('users')->select('denda')->where('chat_id', $this->chat_id)->get();
                        $decode_denda = json_decode($denda);

                        foreach ($decode_denda as $dnd) {
                            $ph_denda = $dnd->denda;
                        }

                        $first_nama = DB::table('users')->select('name')->where('chat_id', $this->chat_id)->get();
                        $decode_first = json_decode($first_nama);

                        foreach ($decode_first as $first) {
                            $depan_nama = $first->name;
                        }

                        $last_nama = DB::table('users')->select('name_last')->where('chat_id', $this->chat_id)->get();
                        $decode_last = json_decode($last_nama);

                        foreach ($decode_last as $last) {
                            $belakang_nama = $last->name_last;
                        }

                        $status = DB::table('reminder')->select('status_iuran')->where('chat_id_reminder', $this->chat_id)->get();
                        $status_decode = json_decode($status);

                        foreach ($status_decode as $s) {
                            $iuran_status = $s->status_iuran;
                        }

                        $iuran = DB::table('kas_ph')->select('iuran_ph')->where('id', '=', 1)->get();
                        $decode_iuran = json_decode($iuran);

                        foreach ($decode_iuran as $iu) {
                            $iuran_ph = $iu->iuran_ph;
                        }

                        $nominal_reminder = DB::table('reminder')->select('nominal')->where('chat_id_reminder', $this->chat_id)->get();
                        $decode_nominal = json_decode($nominal_reminder);

                        foreach ($decode_nominal as $no) {
                            $reminder_nominal = $no->nominal;
                        }

                        if ($iuran_status == 'belum ada aksi' && $ph_denda == 0) {

                            Notifikasi::create([
                                'first_nama' => $depan_nama,
                                'last_nama' => $belakang_nama,
                                'username_telegram_notifikasi' => $this->username,
                                'chat_id_notifikasi' => $this->chat_id,
                                'nominal_bayar' => $iuran_ph,
                                'status_notifikasi' => 'tidak setuju',
                            ]);

                            Reminder::where('username_telegram_reminder', $this->username)
                                ->where('chat_id_reminder', $this->chat_id)
                                ->update(['status_iuran' => 'belum bayar']);

                            $message = "Data Iuran anda telah diperbaharui\n";
                            $message .= 'Terima Kasih...';

                        } elseif ($iuran_status == 'belum ada aksi' && $ph_denda != 0) {

                            Notifikasi::create([
                                'first_nama' => $depan_nama,
                                'last_nama' => $belakang_nama,
                                'username_telegram_notifikasi' => $this->username,
                                'chat_id_notifikasi' => $this->chat_id,
                                'nominal_bayar' => $reminder_nominal,
                                'status_notifikasi' => 'tidak setuju',
                            ]);

                            Reminder::where('username_telegram_reminder', $this->username)
                                ->where('chat_id_reminder', $this->chat_id)
                                ->update(['status_iuran' => 'belum bayar']);

                            $message = "Data Iuran anda telah diperbaharui\n";
                            $message .= 'Terima Kasih...';

                        } elseif ($iuran_status == 'konfirmasi pembayaran') {
                            $message = "Maaf anda sebelumnya telah membalas pesan perintah /bayar\n";
                            $message .= "Maka untuk proses perintah /belum tidak dijalankan\n";
                            $message .= "Mohon untuk menunggu konfirmasi pembayaran anda yang dilakukan bendahara\n";
                            $message .= "Terima Kasih...";

                        } elseif ($iuran_status == 'konfirmasi pembayaran lunas') {
                            $message = "Maaf anda sebelumnya telah membalas pesan perintah /lunas\n";
                            $message .= "Maka untuk proses perintah /belum tidak dijalankan\n";
                            $message .= "Mohon untuk menunggu konfirmasi pembayaran anda yang dilakukan bendahara\n";
                            $message .= "Terima Kasih...";

                        } elseif ($iuran_status == 'bayar') {
                            $message = "Anda terkonfirmasi telah membayar iuran kas PH periode bulan ini\n";
                            $message .= "Maka untuk proses perintah /belum tidak dijalankan\n";
                            $message .= "Terima Kasih...";

                        } elseif ($iuran_status == 'denda') {
                            $message = "Anda terkonfirmasi tidak membayar iuran kas PH periode bulan ini\n";
                            $message .= "Maka untuk proses perintah /belum tidak dijalankan\n";
                            $message .= "Terima Kasih...";

                        } elseif ($iuran_status == 'belum bayar') {
                            $message = "Maaf anda sebelumnya telah membalas pesan perintah /belum\n";
                            $message .= "Maka untuk proses perintah /belum tidak dijalankan\n";
                            $message .= "Mohon untuk segera membayar iuran kas PH....\n";
                            $message .= "Terima Kasih...";
                        }

                    }

                } else {

                    $status = DB::table('reminder')->select('status_iuran')->where('chat_id_reminder', $this->chat_id)->get();
                    $status_decode = json_decode($status);

                    foreach ($status_decode as $s) {
                        $iuran_status = $s->status_iuran;
                    }

                    if ((\Carbon\Carbon::now() > $tgl && $iuran_status == 'denda') || (\Carbon\Carbon::now() > $tgl && $iuran_status == 'belum ada aksi') || (\Carbon\Carbon::now() > $tgl && $iuran_status == 'konfirmasi pembayaran') || (\Carbon\Carbon::now() > $tgl && $iuran_status == 'konfirmasi pembayaran lunas' || $iuran_status == 'belum bayar')) {
                        $message = "Anda terkonfirmasi tidak membayar iuran kas PH periode bulan lalu\n";
                        $message .= "Denda anda telah bertambah, untuk info selanjutnya ketik perintah /iuran\n";
                        $message .= "Terima Kasih...";
                    }

                    if ((\Carbon\Carbon::now() > $tgl && $iuran_status == 'bayar')) {
                        $message = "Anda terkonfirmasi telah membayar iuran kas PH periode bulan lalu\n";
                        $message .= "Terima Kasih...";
                    }
                }

            } else {
                $message = "Pengingat Iuran Kas PH Untuk Anda ($this->first_name $this->last_name) belum dibuat";
            }

        } else {
            $message = "Maaf, Data Iuran Ph, denda ph dan Tanggal Batas Iuran PH belum dibuat oleh ADMIN";
        }

        $this->sendMessage($message);
    }

    public function updateIuranLunas()
    {
        $kas_ph = DB::table('kas_ph')->count();

        $reminder = DB::table('reminder')->count();

        if ($kas_ph != 0) {
            if ($reminder != 0) {
                $date = DB::table('kas_ph')->select('tanggal_batas_iuran')->where('id', '=', 1)->get();
                $decode_date = json_decode($date);

                foreach ($decode_date as $d) {
                    $batas = $d->tanggal_batas_iuran;
                }
                $tgl = \Carbon\Carbon::parse($batas);

                if (\Carbon\Carbon::now() <= $tgl) {

                    $notif_chat_id = DB::table('notifikasi')->select('chat_id_notifikasi')->where('chat_id_notifikasi', $this->chat_id)->count();

                    if ($notif_chat_id != 0) {

                        $status = DB::table('reminder')->select('status_iuran')->where('chat_id_reminder', $this->chat_id)->get();
                        $status_decode = json_decode($status);

                        foreach ($status_decode as $s) {
                            $iuran_status = $s->status_iuran;
                        }

                        $nominal_reminder = DB::table('reminder')->select('nominal')->where('chat_id_reminder', $this->chat_id)->get();
                        $decode_nominal = json_decode($nominal_reminder);

                        foreach ($decode_nominal as $no) {
                            $reminder_nominal = $no->nominal;
                        }

                        $user = DB::table('users')->get();
                        $decode_user = json_decode($user);

                        if ($iuran_status == 'belum ada aksi' || $iuran_status == 'belum bayar' || $iuran_status == 'konfirmasi pembayaran') {

                            Reminder::where('username_telegram_reminder', $this->username)
                                ->where('chat_id_reminder', $this->chat_id)
                                ->update(['status_iuran' => 'konfirmasi pembayaran lunas']);

                            Notifikasi::where('chat_id_notifikasi', $this->chat_id)
                                ->update(['status_notifikasi' => 'tunggu konfirmasi lunas']);

                            Notifikasi::where('chat_id_notifikasi', $this->chat_id)
                                ->update(['nominal_bayar' => $reminder_nominal]);

                            $message = "Data Iuran anda telah diperbaharui\n";
                            $message .= 'Terima Kasih...';

                            foreach ($decode_user as $u) {
                                if ($u->level == 'admin') {
                                    Telegram::sendMessage([
                                        'chat_id' => $u->chat_id,
                                        'parse_mode' => 'HTML',
                                        'text' => "<b>Pemberitahuan Pelunasan Iuran kas PH dan denda</b>\n"
                                        . "<b>$depan_nama $belakang_nama</b>\n"
                                        . "Telah melakukan pelunasan Iuran Kas Ph dan denda\n"
                                        . "Untuk Bendahara silahkan konfirmasi pelunasan tersebut\n"
                                        . "dengan klik button link, anda akan langsung beralih ke halaman notifikasi"
                                        . "\n"
                                        . "Terima Kasih...\n"
                                        . "\n"
                                        . "<b>Jangan Membalas Pesan ini dengan perintah Apapun</b>\n",
                                        'reply_markup' => Keyboard::make()
                                            ->inline()
                                            ->row(
                                                Keyboard::inlineButton(['text' => 'Halaman Notifikasi', 'url' => "http://127.0.0.1:8000/notifikasi/konfirmasi/lunas"]),
                                            ),
                                    ]);
                                }
                            }

                        } elseif ($iuran_status == 'konfirmasi pembayaran lunas') {
                            $message = "Maaf anda sebelumnya telah membalas pesan perintah /lunas\n";
                            $message .= "Maka untuk proses perintah /lunas tidak dijalankan\n";
                            $message .= "Mohon untuk menunggu konfirmasi pembayaran anda yang dilakukan bendahara\n";
                            $message .= "Terima Kasih...";

                        } elseif ($iuran_status == 'bayar') {
                            $message = "Anda terkonfirmasi telah membayar iuran kas PH\n";
                            $message .= 'Terima Kasih...';
                        }

                    } else {
                        $first_nama = DB::table('users')->select('name')->where('chat_id', $this->chat_id)->get();
                        $decode_first = json_decode($first_nama);

                        foreach ($decode_first as $first) {
                            $depan_nama = $first->name;
                        }

                        $last_nama = DB::table('users')->select('name_last')->where('chat_id', $this->chat_id)->get();
                        $decode_last = json_decode($last_nama);

                        foreach ($decode_last as $last) {
                            $belakang_nama = $last->name_last;
                        }

                        $status = DB::table('reminder')->select('status_iuran')->where('chat_id_reminder', $this->chat_id)->get();
                        $status_decode = json_decode($status);

                        foreach ($status_decode as $s) {
                            $iuran_status = $s->status_iuran;
                        }

                        $nominal_reminder = DB::table('reminder')->select('nominal')->where('chat_id_reminder', $this->chat_id)->get();
                        $decode_nominal = json_decode($nominal_reminder);

                        foreach ($decode_nominal as $no) {
                            $reminder_nominal = $no->nominal;
                        }

                        $user = DB::table('users')->get();
                        $decode_user = json_decode($user);

                        if ($iuran_status == 'belum ada aksi' || $iuran_status == 'konfirmasi pembayaran' || $iuran_status == 'belum bayar') {

                            Notifikasi::create([
                                'first_nama' => $depan_nama,
                                'last_nama' => $belakang_nama,
                                'username_telegram_notifikasi' => $this->username,
                                'chat_id_notifikasi' => $this->chat_id,
                                'nominal_bayar' => $reminder_nominal,
                                'status_notifikasi' => 'tunggu konfirmasi lunas',
                            ]);

                            Reminder::where('username_telegram_reminder', $this->username)
                                ->where('chat_id_reminder', $this->chat_id)
                                ->update(['status_iuran' => 'konfirmasi pembayaran lunas']);

                            $message = "Data Iuran anda telah diperbaharui\n";
                            $message .= 'Terima Kasih...';

                            foreach ($decode_user as $u) {
                                if ($u->level == 'admin') {
                                    Telegram::sendMessage([
                                        'chat_id' => $u->chat_id,
                                        'parse_mode' => 'HTML',
                                        'text' => "<b>Pemberitahuan Pelunasan Iuran kas PH dan denda</b>\n"
                                        . "<b>$depan_nama $belakang_nama</b>\n"
                                        . "Telah melakukan pelunasan Iuran Kas Ph dan denda\n"
                                        . "Untuk Bendahara silahkan konfirmasi pelunasan tersebut\n"
                                        . "dengan klik button link, anda akan langsung beralih ke halaman notifikasi"
                                        . "\n"
                                        . "Terima Kasih...\n"
                                        . "\n"
                                        . "<b>Jangan Membalas Pesan ini dengan perintah Apapun</b>\n",
                                        'reply_markup' => Keyboard::make()
                                            ->inline()
                                            ->row(
                                                Keyboard::inlineButton(['text' => 'Halaman Notifikasi', 'url' => "http://127.0.0.1:8000/notifikasi/konfirmasi/lunas"]),
                                            ),
                                    ]);
                                }
                            }

                        }
                    }

                } else {

                    $status = DB::table('reminder')->select('status_iuran')->where('chat_id_reminder', $this->chat_id)->get();
                    $status_decode = json_decode($status);

                    foreach ($status_decode as $s) {
                        $iuran_status = $s->status_iuran;
                    }
                    if ((\Carbon\Carbon::now() > $tgl && $iuran_status == 'denda') || (\Carbon\Carbon::now() > $tgl && $iuran_status == 'belum ada aksi') || (\Carbon\Carbon::now() > $tgl && $iuran_status == 'konfirmasi pembayaran') || (\Carbon\Carbon::now() > $tgl && $iuran_status == 'konfirmasi pembayaran lunas' || $iuran_status == 'belum bayar')) {
                        $message = "Anda terkonfirmasi tidak melakukan iuran kas PH periode bulan lalu\n";
                        $message .= "Denda anda telah bertambah, untuk info selanjutnya ketik perintah /iuran\n";
                        $message .= "Terima Kasih...";
                    }

                    if ((\Carbon\Carbon::now() > $tgl && $iuran_status == 'bayar')) {
                        $message = "Anda terkonfirmasi telah membayar iuran kas PH periode bulan lalu\n";
                        $message .= "Terima Kasih...";
                    }
                }
            } else {
                $message = "Pengingat Iuran Kas PH Untuk Anda ($this->first_name $this->last_name) belum dibuat";
            }
        } else {
            $message = "Maaf, Data Iuran Ph, denda ph dan Tanggal Batas Iuran PH belum dibuat oleh ADMIN";
        }

        $this->sendMessage($message);
    }

    public function errorCommand()
    {
        $error = "Maaf, perintah yang anda masukkan salah.\n";
        $error .= "Mohon untuk masukkan salah satu perintah dibawah ini : ";

        $this->showMenu($error);
    }

    protected function sendMessage($message)
    {
        $data = [
            'chat_id' => $this->chat_id,
            'parse_mode' => 'HTML',
            'text' => $message,
        ];

        $this->telegram->sendMessage($data);
    }

    protected function replyWithMessage($message, $keyboard)
    {
        $data = [
            'chat_id' => $this->chat_id,
            'parse_mode' => 'HTML',
            'text' => $message,
            'reply_markup' => $keyboard,
        ];

        $this->telegram->sendMessage($data);
    }
}
