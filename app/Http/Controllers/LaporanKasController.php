<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Laporankas;
use App\Exports\LaporanKasExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Jenssegers\Agent\Agent;

class LaporanKasController extends Controller
{
    public function index()
    {
        $anggota = \App\User::all();

        $lap = Laporankas::orderBy('created_at', 'ASC')->paginate(10);

        $count = \DB::table('lap_kas_ph')->count();

        return view('admin.kasph.lap', compact('anggota', 'lap', 'count'));
    }

    public function create()
    {
        $anggota = \App\User::all();

        $create = new Laporankas();

        $agent = new Agent();

        return view('admin.kasph.createlap', compact('anggota', 'create', 'agent'));
    }
    
    public function edit($id)
    {
        $anggota = \App\User::all();

        $showById = Laporankas::find($id);

        return view('admin.kasph.editlap', compact('anggota', 'showById'));
    }

    public function export() 
    {   
        $nama_file = 'laporan kas '.date('d M Y').'.xlsx';
        return Excel::download(new LaporanKasExport, $nama_file);
    }

    public function store(Request $request)
    {
        $data = [];

        foreach ($request->no as $key => $no){
        $data["nama_barang.{$key}"] = 'required';
        $data["keterangan.{$key}"] = 'required';
        $data["jumlah_barang.{$key}"] = 'required';
        $data["satuan_barang.{$key}"] = 'required';
        $data["harga_satuan_barang.{$key}"] = 'required';
        $data["jumlah_harga_barang.{$key}"] = 'required';
        }

        $validator = Validator::make($request->all(), $data);

        if ($validator->passes()) {

            foreach ($request->no as $key => $no){
                $sale = new Laporankas();
                $sale->nama_barang = $request->nama_barang[$key];
                $sale->keterangan = $request->keterangan[$key];
                $sale->jumlah_barang = $request->jumlah_barang[$key];
                $sale->satuan_barang = $request->satuan_barang[$key];
                $sale->harga_satuan_barang = $request->harga_satuan_barang[$key];
                $sale->jumlah_harga_barang = $request->jumlah_harga_barang[$key];
                $sale->save();
            }

            return response()->json(['success'=>'done']);
        }

        return response()->json(['error'=>$validator->errors()->all()]);
    }

    public function storeMobile(Request $request)
    {
        $this->validate($request, [
            'nama_barang' => 'required',
            'jumlah_barang' => 'required',
            'satuan_barang' => 'required',
            'harga_satuan_barang' => 'required',
            'jumlah_harga_barang' => 'required',
            'keterangan' => 'required'
          ]);
  
          $simpan = new Laporankas();
          
          $simpan->nama_barang = $request->nama_barang;
          $simpan->jumlah_barang = $request->jumlah_barang;
          $simpan->satuan_barang = $request->satuan_barang;
          $simpan->harga_satuan_barang = $request->harga_satuan_barang;
          $simpan->jumlah_harga_barang = $request->jumlah_harga_barang;
          $simpan->keterangan = $request->keterangan;
          
          $simpan->save();
            
        return redirect()->back()->with('message', 'Data berhasil ditambah!');
    }

    public function update(Request $request, $id)
    {

        $this->validate($request, [
          'nama_barang' => 'required',
          'jumlah_barang' => 'required',
          'harga_satuan_barang' => 'required',
          'satuan_barang' => 'required',
          'jumlah_harga_barang' => 'required',
          'keterangan' => 'required'
        ]);

        $ubah = Laporankas::find($id);
        
        $ubah->nama_barang = $request->nama_barang;
        $ubah->jumlah_barang = $request->jumlah_barang;
        $ubah->satuan_barang = $request->satuan_barang;
        $ubah->harga_satuan_barang = $request->harga_satuan_barang;
        $ubah->jumlah_harga_barang = $request->jumlah_harga_barang;
        $ubah->keterangan = $request->keterangan;
        
        $ubah->update();

        return redirect()->route('admin-laporan-kas.index')->with('message', 'Data berhasil diubah!');
    }

    public function destroy($id)
    {
        $hapus = Laporankas::find($id);
        $hapus->delete();
        
        return redirect()->back()->with('message', 'Data berhasil dihapus!');
        ;
    }
}