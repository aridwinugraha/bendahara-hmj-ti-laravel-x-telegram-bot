<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Telegram\Bot\Api;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->telegram = new Api(config('telegram.bots.common.token'));

        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        $count_anggota = DB::table('users')->count();
        $reminder = DB::table('reminder')->count();
        $count_bayar_1 = DB::table('reminder')->where('status_iuran', 'tunggu konfirmasi')->count();
        $count_bayar_2 = DB::table('reminder')->where('status_iuran', 'tunggu konfirmasi lunas')->count();
        $count_bayar_total = $count_bayar_1+$count_bayar_2;
        $count_kas_ph = DB::table('kas_ph')->count();;

        $tgl_batas_iuran = DB::table('kas_ph')->select('tanggal_batas_iuran', 'iuran_ph', 'denda_ph')->where('id', '=', 1)->get();
        $decode_batas = json_decode($tgl_batas_iuran);

        $anggota = User::all();

        return view('home', compact('anggota', 'count_anggota', 'count_bayar_total', 'count_kas_ph', 'decode_batas', 'reminder', 'count_bayar_1', 'count_bayar_2'));
    }

    public function deepLinking()
    {
        $url = 'https://bendahara-hmjti.herokuapp.com/' . config('telegram.bots.common.token') . '/webhook';
        $response = $this->telegram->setWebhook(['url' => $url]);

        return redirect('https://telegram.me/bendaharahmjti_bot?start=d2Aklc2PKp5bUtTt');
    }
}
