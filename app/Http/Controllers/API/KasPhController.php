<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Kasph;
use App\User;

class KasPhController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $anggota = \App\User::all();

        $users = User::all();

        $kasph = Kasph::all();

        $lap = \DB::table('lap_kas_ph')->count();

        $total = \DB::table('lap_kas_ph')->sum('jumlah_harga_barang');

        $count = \DB::table('users')->where('status_anggota', 'Pengurus Harian')->count();

        $count_ph = \DB::table('kas_ph')->count();

        $tgl_update = \DB::table('lap_kas_ph')->latest('created_at')->limit(1)->get();
        $decode_date = json_decode($tgl_update);

        return view('umum.kasph.index', compact('anggota', 'users', 'kasph', 'lap', 'total', 'decode_date', 'tgl_update', 'count', 'count_ph'));
    }
}
