<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Kashmj;

class KasHmjController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $anggota = \App\User::all();

        $kashmj = Kashmj::all();

        $count = \DB::table('kas_hmj')->count();

        return view('umum.kashmj.index', compact('anggota', 'kashmj', 'count'));
    }
}
