<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateEmailRequest;
use App\Http\Requests\TambahAnggotaAuthRequest;
use Illuminate\Support\Facades\Hash;
use App\User;

class DataAnggotaController extends Controller
{

    public function index()
    {
        $anggota = User::orderBy('npk', 'ASC')->paginate(10);

        $count = \DB::table('users')->count();

        return view('admin.anggota.index', compact('anggota', 'count'));
    }

    public function create()
    {
        $anggota = new User();

        return view('admin.anggota.create', compact('anggota'));
    }

    public function show($id)
    {
        $anggota = \App\User::all();

        $detail = User::find($id);
        
        return view('admin.anggota.detail', compact('anggota', 'detail'));
    }

    public function edit($id)
    {
        $anggota = \App\User::all();

        $showById = User::find($id);

        return view('admin.anggota.edit', compact('anggota', 'showById'));
    }

    public function password()
    {
        $anggota = \App\User::all();

        return view('admin.anggota.password.edit', compact('anggota'));
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $request->user()->update([
            'password' => Hash::make($request->get('password'))
        ]);
            
        return redirect()->back()->with('message', 'Password Berhasil Diubah');
    }

    public function email($id)
    {
        $anggota = \App\User::all();

        $showById = User::find($id);

        return view('admin.anggota.email.edit', compact('anggota', 'showById'));
    }

    public function updateEmail(UpdateEmailRequest $request, $id)
    {
        $request->user()->update([
            'email' => $request->get('email'),
          ]);

        $verify = User::find($id);
        
        $verify->email_verified_at = NULL;
        
        $verify->update();
    
        return redirect()->route('home');
    }

    public function role($id)
    {
        $anggota = \App\User::all();

        $showById = User::find($id);

        return view('admin.anggota.role.edit', compact('anggota', 'showById'));
    }

    public function updateRole(Request $request, $id)
    {
        $this->validate($request, [
            'level' => 'required'
          ]);

        $verify = User::find($id);
        
        $verify->level = $request->level;

        $verify->update();

        return redirect()->route('home');
    }

    public function store(TambahAnggotaAuthRequest $request)
    {
        $re = '/\b[0IVXLCDM]+\b/';
        $str = $request->get('npk');
        if(preg_match("#^HMJ/#i", $str)) {
            if (preg_match("#TI/#i", $str)) {
                if(preg_match_all($re, $str)) {
                    if(preg_match("/-/", $str)) {
                        if(strlen($str)>=18) { 
                            $user = $request->user()->create([
                                'npk' => $request->get('npk'),
                                'name' => $request->get('name'),
                                'name_last' => $request->get('name_last'),
                                'username' => $request->get('username'),
                                'email' => $request->get('email'),
                                'password' => Hash::make($request->get('password')),
                                'jk' => $request->get('jk'),
                                'agama' => $request->get('agama'),
                                'status_anggota' => $request->get('status_anggota'),
                                'no_hp' => $request->get('no_hp')
                            ]);
                    
                            return redirect()->route('admin-anggota.index')->with('message', 'Data Anggota Berhasil Ditambah!');
                        } else {
                            return redirect()->route('admin-anggota.create')->withInput()
                            ->withErrors(['Input NPK anda memiliki kesalahan : Harus menyertakan nomor anggota pelantikan anda setelah tahun ajaran pelantikan']);
                        }
                    } else {
                        return redirect()->route('admin-anggota.create')->withInput()
                        ->withErrors(['Input NPK anda memiliki kesalahan : Harus menyertakan tanda strip "-" setelah tahun angkatan anggota dan diantara tahun ajaran pelantikan']);
                    }
                } else {
                    return redirect()->route('admin-anggota.create')->withInput()
                    ->withErrors(['Input NPK anda memiliki kesalahan : Harus menyertakan tahun angkatan anggota dalam angka romawi setelah TI/']);
                }
            } else {
                return redirect()->route('admin-anggota.create')->withInput()
                ->withErrors(['Input NPK anda memiliki kesalahan : Harus menyertakan TI/ setelah HMJ/']);
            }
        } else {
            return redirect()->route('admin-anggota.create')->withInput()
            ->withErrors(['Input NPK anda memiliki kesalahan : Harus menyertakan awalan HMJ/']);
        }
    }

    public function update(Request $request, $id)
    {
        $re = '/\b[0IVXLCDM]+\b/';
        $str = $request->npk;
        if(preg_match("#^HMJ/#i", $str)) {
            if (preg_match("#TI/#i", $str)) {
                if(preg_match_all($re, $str)) {
                    if(preg_match("/-/", $str)) {
                        if(strlen($str)>=18) { 
                            $this->validate($request, [
                                'npk' => 'required',
                                'name' => 'required',
                                'name_last' => 'required',
                                'username' => 'required',
                                'jk' => 'required',
                                'agama' => 'required',
                                'no_hp' => 'required',
                                'status_anggota' => 'required',
                                'iuran_kas' => 'required',
                                'denda' => 'required'
                              ]);
                    
                            $ubah = User::find($id);
                            
                            $ubah->npk = $request->npk;
                            $ubah->name = $request->name;
                            $ubah->name_last = $request->name_last;
                            $ubah->username = $request->username;
                            $ubah->jk = $request->jk;
                            $ubah->agama = $request->agama;
                            $ubah->no_hp = $request->no_hp;
                            $ubah->status_anggota = $request->status_anggota;
                            $ubah->iuran_kas = $request->iuran_kas;
                            $ubah->denda = $request->denda;
                            
                            $ubah->update();
                    
                            return redirect()->route('admin-anggota.index')->with('message', 'Data berhasil diubah!');
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

    public function destroy($id)
    {
        $hapus = User::find($id);
        $hapus->delete();

        return redirect()->back()->with('message', 'Data berhasil dihapus!');
    }
}
