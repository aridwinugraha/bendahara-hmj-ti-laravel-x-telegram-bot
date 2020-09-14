<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kashmj;

class KasHmjController extends Controller
{
    public function index()
    {
        $anggota = \App\User::all();

        $kashmj = Kashmj::all();

        $count = \DB::table('kas_hmj')->count();

        return view('admin.kashmj.index', compact('anggota', 'kashmj', 'count'));
    }

    public function create()
    {
        $anggota = \App\User::all();

        $kashmj = new Kashmj();

        return view('admin.kashmj.create', compact('anggota', 'kashmj'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'total_kas_hmj' => 'required', 
        ]);

        $store = new Kashmj();

        $store->total_kas_hmj = $request->total_kas_hmj;

        $store->save();
        
        return redirect()->route('admin-kas-hmj.index')->with('message', 'Data berhasil dibuat!');
    }

    public function edit($id)
    {
        $anggota = \App\User::all();

        $showById = Kashmj::find($id);

        return view('admin.kashmj.update', compact('anggota', 'showById'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'total_kas_hmj' => 'required', ]);

        $kashmj = Kashmj::find($id);

        $kashmj->total_kas_hmj = $request->total_kas_hmj;

        $kashmj->update();
        
        return redirect()->route('admin-kas-hmj.index')->with('message', 'Data berhasil diubah!');
    }
}
