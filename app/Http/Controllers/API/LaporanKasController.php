<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Laporankas;
use PDF;

class LaporanKasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $anggota = \App\User::all();

        $lap = Laporankas::orderBy('created_at', 'ASC')->paginate(10);

        $count = \DB::table('lap_kas_ph')->count();

        return view('umum.kasph.lap', compact('anggota', 'lap', 'count'));
    }

    public function downloadPdf()
    {
         // retreive all records from db
      $data = Laporankas::all();

      // share data to view
      view()->share('lap',$data);
      $pdf = PDF::loadView('umum.kasph.lap_pdf', $data);

      // download PDF file with download method
      return $pdf->download('pdf_file.pdf');     
    }

}