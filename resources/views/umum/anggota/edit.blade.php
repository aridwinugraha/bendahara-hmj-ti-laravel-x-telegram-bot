@extends('layouts.app')

@section('content')
@if (Auth::user()->status_anggota == 'Pengurus Harian')
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
                        <div class="card-header text-center">{{__('Edit Data') }} {{ Auth::User()->name }} {{ Auth::User()->name_last }}</div>

                        <div class="card-body">
                            <form method="POST" action="{{ route( 'anggota.update', $showById->id ) }}">
                                @csrf
                                @method('PUT')
                                
                                @if (count($errors) > 0)
                                    <div class="alert alert-danger">
                                        {{__('Terdapat beberapa kasalahan pada saat mengisi yang harus diperbaiki.') }}<br><br>
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li> @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="form-group row">
                                <label for="npk" class="col-md-4 col-form-label text-md-right">{{__('Nomor Pokok Keanggotaan') }}</label>

                                    <div class="col-md-6">
                                        <input id="npk" type="text" class="form-control" oninvalid="this.setCustomValidity('Tolong Masukkan Data Nomor Pokok Keanggotaan Jangan Dibiarkan Kosong')"
                                        oninput="setCustomValidity('')" name="npk" value="{{ $showById->npk }}" required autocomplete="npk" autofocus>
                                        @error('npk')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">{{__('Nama Depan') }}</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control" oninvalid="this.setCustomValidity('Tolong Masukkan Data Nama Depan Jangan Dibiarkan Kosong')"
                                        oninput="setCustomValidity('')" name="name" value="{{ $showById->name }}" required autocomplete="name" autofocus>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="name_last" class="col-md-4 col-form-label text-md-right">{{__('Nama Belakang') }}</label>

                                    <div class="col-md-6">
                                        <input id="name_last" type="text" class="form-control" oninvalid="this.setCustomValidity('Tolong Masukkan Data Nama Belakang Jangan Dibiarkan Kosong')"
                                        oninput="setCustomValidity('')" name="name_last" value="{{ $showById->name_last }}" required autocomplete="name_last" autofocus>
                                        @error('name_last')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                @if (Auth::user()->id==$showById->id)
                                <div class="form-group row">
                                    <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('Username') }}</label>

                                    <div class="col-md-6">
                                        <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ $showById->username }}" required autocomplete="username" autofocus>

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
                                        <a href="{{ route('edit.password') }}" type="button" class="btn btn-danger"><i class="fa fa-key"></i>{{__(' Ubah Password') }}</a>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">{{__('E-Mail Address') }}</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $showById->email }}" required autocomplete="email" readonly>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div> 
                                </div>

                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right"></label>

                                    <div class="col-md-6">
                                        <a href="{{ route('edit.email', $showById->id) }}" type="button" class="btn btn-dark"><i class="far fa-envelope"></i>{{__(' Ubah Email Address') }}</a>
                                    </div>   
                                </div>
                                @if (Auth::user()->status_anggota=='Pengurus Harian')
                                    <div class="form-group row">
                                        <label for="level" class="col-md-4 col-form-label text-md-right">{{__('Level User') }}</label>

                                        <div class="col-md-6">
                                            <a href="{{ route('upgrade.admin', Auth::user()->id) }}" onclick="return confirm('Apakah Anda Yakin Ingin mengirim permintaan menjadi ADMIN WEB BENDAHARA HMJ TI ?')" class="btn btn-success"><i class="fas fa-user-tag"></i>{{__(' UPGRADE to ADMIN') }}</a> 
                                        </div>
                                    </div>    
                                @endif
                            @endif

                                <div class="form-group row">
                                <label for="agama" class="col-md-4 col-form-label text-md-right">{{__('Agama') }}</label>

                                    <div class="col-md-6">
                                        <select name="agama" class="form-control" oninvalid="this.setCustomValidity('Tolong Pilih Select Agama')"
                                        oninput="setCustomValidity('')">
                                                    <option value=""></option>
                                        <option value="islam" {{ $showById->agama == 'islam' ? 'selected' : '' }}>{{__('Islam' )}}</option>
                                        <option value="kristen" {{ $showById->agama == 'kristen' ? 'selected' : '' }}>{{__('Kristen') }}</option>
                                        <option value="hindu" {{ $showById->agama == 'hindu' ? 'selected' : '' }}>{{__('Hindu') }}</option>
                                        <option value="buddha" {{ $showById->agama == 'buddha' ? 'selected' : '' }}>{{__('Buddha') }}</option>
                                                </select>
                                            @error('agama')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                <label for="jk" class="col-md-4 col-form-label text-md-right">{{__('Jenis Kelamin') }}</label>

                                    <div class="col-md-6">
                                        <label class="col-form-label" oninvalid="this.setCustomValidity('Tolong Pilih Jenis Kelamin')"
                                        oninput="setCustomValidity('')"><input id="jk" type="radio" name="jk" value="Laki-laki" {{ $showById->jk == 'Laki-laki' ? 'checked' : '' }} />{{__(' Laki-laki') }}</label>
                                        <label><input id="jk" type="radio" name="jk" value="Perempuan" {{ $showById->jk == 'Perempuan' ? 'checked' : '' }} />{{__(' Perempuan') }}</label>
                                        @error('jk')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>                        

                                <div class="form-group row">
                                <label for="no_hp" class="col-md-4 col-form-label text-md-right">{{__('Nomor Telepon') }}</label>

                                    <div class="col-md-6">
                                        <input id="no_hp" type="text" class="form-control" oninvalid="this.setCustomValidity('Tolong Masukkan Data Nomor Telepon Jangan Dibiarkan Kosong')"
                                        oninput="setCustomValidity('')" name="no_hp" value="{{ $showById->no_hp }}" required autocomplete="name" autofocus>
                                        @error('no_hp')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" name="submit" class="btn btn-primary" value="PUT"><i class="far fa-save"></i>
                                            {{__('Update') }}
                                        </button>
                                        <a href="{{ URL::previous() }}" type="button" class="btn btn-warning"><i class="fas fa-arrow-circle-left"></i>{{__(' Kembali') }}</a>
                                        </div>
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
@else
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
                    <div class="card-header text-center">{{__('Edit Data') }} {{ Auth::User()->name }} {{ Auth::User()->name_last }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route( 'anggota.update', $showById->id ) }}">
                            @csrf
                            @method('PUT')
                            
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    {{__('Terdapat beberapa kasalahan pada saat mengisi yang harus diperbaiki.') }}<br><br>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li> @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="form-group row">
                            <label for="npk" class="col-md-4 col-form-label text-md-right">{{__('Nomor Pokok Keanggotaan') }}</label>

                                <div class="col-md-6">
                                    <input id="npk" type="text" class="form-control" oninvalid="this.setCustomValidity('Tolong Masukkan Data Nomor Pokok Keanggotaan Jangan Dibiarkan Kosong')"
                                    oninput="setCustomValidity('')" name="npk" value="{{ $showById->npk }}" required autocomplete="npk" autofocus>
                                    @error('npk')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{__('Nama Depan') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" oninvalid="this.setCustomValidity('Tolong Masukkan Data Nama Depan Jangan Dibiarkan Kosong')"
                                    oninput="setCustomValidity('')" name="name" value="{{ $showById->name }}" required autocomplete="name" autofocus>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name_last" class="col-md-4 col-form-label text-md-right">{{__('Nama Belakang') }}</label>

                                <div class="col-md-6">
                                    <input id="name_last" type="text" class="form-control" oninvalid="this.setCustomValidity('Tolong Masukkan Data Nama Belakang Jangan Dibiarkan Kosong')"
                                    oninput="setCustomValidity('')" name="name_last" value="{{ $showById->name_last }}" required autocomplete="name_last" autofocus>
                                    @error('name_last')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            @if (Auth::user()->id==$showById->id)
                            <div class="form-group row">
                                <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('Username') }}</label>

                                <div class="col-md-6">
                                    <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ $showById->username }}" required autocomplete="username" autofocus>

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
                                    <a href="{{ route('edit.password') }}" type="button" class="btn btn-danger"><i class="fa fa-key"></i>{{__(' Ubah Password') }}</a>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{__('E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $showById->email }}" required autocomplete="email" readonly>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div> 
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right"></label>

                                <div class="col-md-6">
                                    <a href="{{ route('edit.email', $showById->id) }}" type="button" class="btn btn-dark"><i class="far fa-envelope"></i>{{__(' Ubah Email Address') }}</a>
                                </div>   
                            </div>
                            @if (Auth::user()->status_anggota=='Pengurus Harian')
                                <div class="form-group row">
                                    <label for="level" class="col-md-4 col-form-label text-md-right">{{__('Level User') }}</label>

                                    <div class="col-md-6">
                                        <a href="{{ route('upgrade.admin', Auth::user()->id) }}" onclick="return confirm('Apakah Anda Yakin Ingin mengirim permintaan menjadi ADMIN WEB BENDAHARA HMJ TI ?')" class="btn btn-success"><i class="fas fa-user-tag"></i>{{__(' UPGRADE to ADMIN') }}</a> 
                                    </div>
                                </div>    
                            @endif
                        @endif

                            <div class="form-group row">
                            <label for="agama" class="col-md-4 col-form-label text-md-right">{{__('Agama') }}</label>

                                <div class="col-md-6">
                                    <select name="agama" class="form-control" oninvalid="this.setCustomValidity('Tolong Pilih Select Agama')"
                                    oninput="setCustomValidity('')">
                                                <option value=""></option>
                                    <option value="islam" {{ $showById->agama == 'islam' ? 'selected' : '' }}>{{__('Islam' )}}</option>
                                    <option value="kristen" {{ $showById->agama == 'kristen' ? 'selected' : '' }}>{{__('Kristen') }}</option>
                                    <option value="hindu" {{ $showById->agama == 'hindu' ? 'selected' : '' }}>{{__('Hindu') }}</option>
                                    <option value="buddha" {{ $showById->agama == 'buddha' ? 'selected' : '' }}>{{__('Buddha') }}</option>
                                            </select>
                                        @error('agama')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                            <label for="jk" class="col-md-4 col-form-label text-md-right">{{__('Jenis Kelamin') }}</label>

                                <div class="col-md-6">
                                    <label class="col-form-label" oninvalid="this.setCustomValidity('Tolong Pilih Jenis Kelamin')"
                                    oninput="setCustomValidity('')"><input id="jk" type="radio" name="jk" value="Laki-laki" {{ $showById->jk == 'Laki-laki' ? 'checked' : '' }} />{{__(' Laki-laki') }}</label>
                                    <label><input id="jk" type="radio" name="jk" value="Perempuan" {{ $showById->jk == 'Perempuan' ? 'checked' : '' }} />{{__(' Perempuan') }}</label>
                                    @error('jk')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>                        

                            <div class="form-group row">
                            <label for="no_hp" class="col-md-4 col-form-label text-md-right">{{__('Nomor Telepon') }}</label>

                                <div class="col-md-6">
                                    <input id="no_hp" type="text" class="form-control" oninvalid="this.setCustomValidity('Tolong Masukkan Data Nomor Telepon Jangan Dibiarkan Kosong')"
                                    oninput="setCustomValidity('')" name="no_hp" value="{{ $showById->no_hp }}" required autocomplete="name" autofocus>
                                    @error('no_hp')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" name="submit" class="btn btn-primary" value="PUT"><i class="far fa-save"></i>
                                        {{__('Update') }}
                                    </button>
                                    <a href="{{ URL::previous() }}" type="button" class="btn btn-warning"><i class="fas fa-arrow-circle-left"></i>{{__(' Kembali') }}</a>
                                    </div>
                                </div>
                                </form>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
    @forelse ($anggota as $t)    
    @empty
        @include('modal') 
    @endforelse
@endsection
