<?php

namespace App\Http\Controllers;

use App\Kasph;
use App\User;
use Illuminate\Http\Request;

class KasPhController extends Controller
{
    public function index()
    {
        $anggota = \App\User::all();

        $users = User::where('status_anggota', 'Pengurus Harian')->orderBy('npk', 'ASC')->paginate(3);

        $kasph = Kasph::all();

        $lap = \DB::table('lap_kas_ph')->count();

        $total = \DB::table('lap_kas_ph')->sum('jumlah_harga_barang');

        $count = \DB::table('users')->where('status_anggota', 'Pengurus Harian')->count();

        $count_ph = \DB::table('kas_ph')->count();

        $tgl_update = \DB::table('lap_kas_ph')->latest('created_at')->limit(1)->get();
        $decode_date = json_decode($tgl_update);

        return view('admin.kasph.index', compact('anggota', 'users', 'kasph', 'lap', 'total', 'decode_date', 'tgl_update', 'count', 'count_ph'));
    }
    
    public function create()
    {
        $anggota = \App\User::all();

        $kasph = new Kasph();

        return view('admin.kasph.create', compact('anggota', 'kasph'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'iuran_ph' => 'required',
            'denda_ph' => 'required',
            'tanggal_batas_iuran' => 'required', 
        ]);

        $store = new Kasph();

        $store->iuran_ph = $request->iuran_ph;
        $store->denda_ph = $request->denda_ph;
        $store->tanggal_batas_iuran = \Carbon\Carbon::parse($request->tanggal_batas_iuran);
        $store->total_kas_ph = 0;

        $store->save();

        return redirect()->route('admin-kas-ph.index')->with('message', 'Data berhasil diubah!');
    }

    public function edit($id)
    {
        $anggota = \App\User::all();

        $showById = Kasph::find($id);

        return view('admin.kasph.iuran', compact('anggota', 'showById'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'iuran_ph' => 'required',
            'denda_ph' => 'required',
            'tanggal_batas_iuran' => 'required', ]);

        $update = Kasph::find($id);

        $update->iuran_ph = $request->iuran_ph;
        $update->denda_ph = $request->denda_ph;
        $update->tanggal_batas_iuran = \Carbon\Carbon::parse($request->tanggal_batas_iuran);

        $update->update();

        return redirect()->route('admin-kas-ph.index')->with('message', 'Data berhasil diubah!');
    }
}
