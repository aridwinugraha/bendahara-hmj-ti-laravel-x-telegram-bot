@extends('layouts.app')

@section('content')
@if (Auth::user()->username_telegram != null && Auth::user()->chat_id != null)
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 ml-sm-auto col-lg-9 px-md-4">
            @if (session('message'))
                    <div class="alert alert-success  alert-dismissible fade show" role="alert">
                      {{ session('message') }}
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                @endif
            <div class="card">
                <div class="card-header text-center">{{__('Tambah Data') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin-anggota.store') }}">
                        @csrf
                        
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                Terdapat beberapa kasalahan pada saat mengisi yang harus diperbaiki.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li> @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="form-group row">
                            <label for="npk" class="col-md-4 col-form-label text-md-right">{{ __('Nomor Pokok Keanggotaan') }}</label>

                            <div class="col-md-6">
                                <input id="npk" type="text" class="form-control" oninvalid="this.setCustomValidity('Tolong Masukkan Data Nomor Pokok Keanggotaan Jangan Dibiarkan Kosong')"
                                oninput="setCustomValidity('')" name="npk" value="{{ old('npk') }}" required autocomplete="npk" autofocus>

                                @error('npk')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nama Depan') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" oninvalid="this.setCustomValidity('Tolong Masukkan Data Nama Depan Jangan Dibiarkan Kosong')"
                                oninput="setCustomValidity('')" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name_last" class="col-md-4 col-form-label text-md-right">{{ __('Nama Belakang') }}</label>

                            <div class="col-md-6">
                                <input id="name_last" type="text" class="form-control" oninvalid="this.setCustomValidity('Tolong Masukkan Data Nama Belakang Jangan Dibiarkan Kosong')"
                                oninput="setCustomValidity('')" name="name_last" value="{{ old('name_last') }}" required autocomplete="name_last" autofocus>

                                @error('name_last')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('Username') }}</label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control" oninvalid="this.setCustomValidity('Tolong Masukkan Data Username Jangan Dibiarkan Kosong')"
                                oninput="setCustomValidity('')" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" oninvalid="this.setCustomValidity('Tolong Masukkan Data Password Jangan Dibiarkan Kosong')"
                                oninput="setCustomValidity('')" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" oninvalid="this.setCustomValidity('Tolong Konfirmasi Password Anda')"
                                oninput="setCustomValidity('')" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" oninvalid="this.setCustomValidity('Tolong Masukkan Data Email Jangan Dibiarkan Kosong')"
                                oninput="setCustomValidity('')" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="jk" class="col-md-4 col-form-label text-md-right">{{ __('Jenis Kelamin') }}</label>

                            <div class="col-md-6">
                                
                                <label class="col-form-label" oninvalid="this.setCustomValidity('Tolong Pilih Jenis Kelamin')"
                                oninput="setCustomValidity('')"><input id="jk" type="radio" name="jk" value="Laki-laki" {{ old('jk') == 'Laki-laki' ? 'checked' : '' }}> Laki-laki</label>
                                
                                <label><input id="jk" type="radio" name="jk" value="Perempuan" {{ old('jk') == 'Perempuan' ? 'checked' : '' }}> Perempuan</label>
                                @error('jk')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror 
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="agama" class="col-md-4 col-form-label text-md-right">{{ __('Agama') }}</label>
                            <div class="col-md-6">
                                <select name="agama" class="form-control" oninvalid="this.setCustomValidity('Tolong Pilih Agama')"
                                oninput="setCustomValidity('')">
                                            <option value=""></option>
                                            <option value="islam" {{ old('agama') == 'islam' ? 'selected' : '' }}>Islam</option>
                                            <option value="kristen" {{ old('agama') == 'kristen' ? 'selected' : '' }}>Kristen</option>
                                            <option value="hindu" {{ old('agama') == 'hindu' ? 'selected' : '' }}>Hindu</option>
                                            <option value="budha" {{ old('agama') == 'budha' ? 'selected' : '' }}>Budha</option>
                                        </select>
                                @error('agama')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="status_anggota" class="col-md-4 col-form-label text-md-right">{{ __('Status Anggota') }}</label>
                                <div class="col-md-6">
                                    <label class="col-form-label" oninvalid="this.setCustomValidity('Tolong Pilih Status Anggota')"
                                    oninput="setCustomValidity('')"><input id="status_anggota" type="radio" name="status_anggota" value="Pengurus Harian" {{ old('status_anggota') == 'Pengurus Harian' ? 'checked' : '' }}> Pengurus Harian</label>
                                    <label><input id="status_anggota" type="radio" name="status_anggota" value="Anggota Inti" {{ old('status_anggota') == 'Anggota Inti' ? 'checked' : '' }}> Anggota Inti</label>
                                        @error('status_anggota')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                </div>
                        </div>
                        <div class="form-group row">
                            <label for="no_hp" class="col-md-4 col-form-label text-md-right">{{ __('Nomor Telepon') }}</label>

                            <div class="col-md-6">
                                <input id="no_hp" type="text" class="form-control" oninvalid="this.setCustomValidity('Tolong Masukkan Data Nomor Telepon Jangan Dibiarkan Kosong')"
                                oninput="setCustomValidity('')" name="no_hp" value="{{ old('no_hp') }}" required autocomplete="no_hp" autofocus>

                                @error('no_hp')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
    
                        <div class="text-center">
                                <button type="submit" name="submit" class="btn btn-primary"><i class="fas fa-save"></i>
                                {{__(' Simpan') }}
                                </button>
                                <a href="{{ route('admin-anggota.index') }}" type="button" class="btn btn-warning"><i class="fas fa-arrow-circle-left"></i>{{__(' Kembali') }}</a>
                                 </div>
                            </form>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
    @else
        @include('modal')
    @endif
    @forelse ($anggota as $t)    
    @empty
        @include('modal') 
    @endforelse
@endsection