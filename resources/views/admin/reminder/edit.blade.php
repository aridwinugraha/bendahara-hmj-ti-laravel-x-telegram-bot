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
                <div class="card-header text-center">{{__('Form Buat Reminder') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('reminder.update', $showById->id) }}">
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
                            <label for="tujuan" class="col-md-4 col-form-label text-md-right">{{__('Kepada') }}</label>

                            <div class="col-md-6">
                                <select id="tujuan" class="form-control">
                                    <option value=""></option>@foreach($user as $u)
                                    <option  value="{{ $u->id }}">{{ $u->name }} {{ $u->name_last }}</option> @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="first_nama_tujuan" class="col-md-4 col-form-label text-md-right">{{__('Nama Depan Penerima') }}</label>

                            <div class="col-md-6">
                                <input id="first_nama_tujuan" type="text" class="form-control @error('first_nama_tujuan') is-invalid @enderror" name="first_nama_tujuan" value="{{ $showById->first_nama_tujuan }}" required autocomplete="first_nama_tujuan" readonly>
                                @error('first_nama_tujuan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="last_nama_tujuan" class="col-md-4 col-form-label text-md-right">{{__('Nama Belakang Penerima') }}</label>

                            <div class="col-md-6">
                                <input id="last_nama_tujuan" type="text" class="form-control @error('last_nama_tujuan') is-invalid @enderror" name="last_nama_tujuan" value="{{ $showById->last_nama_tujuan }}" required autocomplete="last_nama_tujuan" readonly>
                                @error('last_nama_tujuan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="username_telegram_reminder" class="col-md-4 col-form-label text-md-right">{{__('Username Telegram') }}</label>

                            <div class="col-md-6">
                                <input id="username_telegram_reminder" type="text" class="form-control @error ('username_telegram_reminder') is-invalid @enderror" name="username_telegram_reminder" value="{{ $showById->username_telegram_reminder }}" required autocomplete="username_telegram_reminder" readonly>
                                 @error ('username_telegram_reminder')
                                    <span class="help-block">
                                        <strong>{{ $errors->first('username_telegram_reminder') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="chat_id_reminder" class="col-md-4 col-form-label text-md-right">{{__('Chat ID Penerima') }}</label>

                            <div class="col-md-6">
                                <input id="chat_id_reminder" type="text" class="form-control @error ('chat_id_reminder') is-invalid @enderror" name="chat_id_reminder" value="{{ $showById->chat_id_reminder }}" required autocomplete="chat_id_reminder" readonly>
                                @error ('chat_id_reminder') 
                                    <span class="help-block">
                                        <strong>{{ $errors->first('chat_id_reminder') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="no_hp_tujuan" class="col-md-4 col-form-label text-md-right">{{__('Nomor Penerima') }}</label>

                            <div class="col-md-6">
                                <input id="no_hp_tujuan" type="text" class="form-control @error('no_hp_tujuan') is-invalid @enderror" name="no_hp_tujuan" value="{{ $showById->no_hp_tujuan }}" required autocomplete="no_hp_tujuan" readonly>
                                @error('no_hp_tujuan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{__('Denda Sanksi Pengurus Harian') }}</label>

                            <div class="col-md-6">
                                <input id="denda" type="number" class="form-control @error('denda') is-invalid @enderror inst_amount" value="{{ $u->denda }}" required autocomplete="denda" readonly>
                                @error('denda')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{__('Iuran PH') }}</label>

                            <div class="col-md-6">
                                @foreach($kasph as $ph)
                                <input id="iuran_ph" type="number" class="form-control @error('iuran_ph') is-invalid @enderror inst_amount" value="{{ $ph->iuran_ph }}" required autocomplete="iuran_ph" readonly>
                                @endforeach
                                @error('iuran_ph')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nominal" class="col-md-4 col-form-label text-md-right">{{__('Nominal') }}</label>

                            <div class="col-md-6">
                                <input id="total_price" type="number" class="form-control @error('nominal') is-invalid @enderror total_amount" name="nominal" value="{{ $showById->nominal }}" required autocomplete="nominal" autofocus>
                                @error('nominal')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-4 col-form-label text-md-right"></div>
                                <div class="col-md-6">
                                    {!!__("<b>Cat : Pemilihan Waktu Notifikasi sebaiknya dilakukan pada saat pagi hari jam 6 atau 7, kalau tidak hitung waktu dari info menit yang tertera</i></b>") !!}
                                </div>
                        </div>
                    
                        <div class="form-group row">
                            <label for="notifikasi" class="col-md-4 col-form-label text-md-right">{{ __('Waktu Notifikasi') }}</label>
                            <div class="col-md-6">
                                <select name="notifikasi" class="form-control" oninvalid="this.setCustomValidity('Tolong Pilih Waktu Notifikasi')"
                                oninput="setCustomValidity('')">
                                            <option value=""></option>
                                            <option value="5" {{ $showById->notifikasi == '5' ? 'selected' : '' }}>Tiap 5 Menit</option>
                                            <option value="10" {{ $showById->notifikasi == '10' ? 'selected' : '' }}>Tiap 10 Menit</option>
                                            <option value="30" {{ $showById->notifikasi == '30' ? 'selected' : '' }}>Tiap 30 Menit</option>
                                            <option value="60" {{ $showById->notifikasi == '60' ? 'selected' : '' }}>Tiap 60 Menit(Satu Kali sejam)</option>
                                            <option value="180" {{ $showById->notifikasi == '180' ? 'selected' : '' }}>Tiap 180 Menit(Satu Kali dalam tiga jam)</option>
                                            <option value="480" {{ $showById->notifikasi == '480' ? 'selected' : '' }}>Tiap 480 Menit(Tiga Kali sehari)</option>
                                            <option value="720" {{ $showById->notifikasi == '720' ? 'selected' : '' }}>Tiap 720 Menit(Dua Kali sehari)</option>
                                            <option value="1440" {{ $showById->notifikasi == '1440' ? 'selected' : '' }}>Tiap 1440 Menit(Satu Kali sehari)</option>
                                            <option value="3600" {{ $showById->notifikasi == '3600' ? 'selected' : '' }}>Tiap 3600 Menit(Satu Kali dalam dua hari)</option>
                                            <option value="10080" {{ $showById->notifikasi == '10080' ? 'selected' : '' }}>Tiap 10080 Menit(Mingguan)</option>
                                            <option value="43200" {{ $showById->notifikasi == '43200' ? 'selected' : '' }}>Tiap 43200 Menit(Satu Bulan jumlah hari nya = 30 Sekali)</option>
                                            <option value="43260" {{ $showById->notifikasi == '43260' ? 'selected' : '' }}>Tiap 43260 Menit(Satu Bulan jumlah hari nya = 31 Sekali)</option>
                                        </select>
                                @error('notifikasi')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="pesan_pengingat" class="col-md-4 col-form-label text-md-right">{{__('Pesan') }}</label>

                            <div class="col-md-6">
                                <textarea name="pesan_pengingat" rows="5" class="form-control" oninvalid="this.setCustomValidity('Tolong Masukkan Data Pesan Jangan Dibiarkan Kosong')"
                                oninput="setCustomValidity('')">{{ $showById->pesan_pengingat }}</textarea>
                                @error('pesan_pengingat')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary"><i class="far fa-save"></i>{{__(' Update') }}</button>
                                <a href="{{ route('reminder.index') }}" class="btn btn-warning"><i class="fas fa-arrow-circle-left"></i>{{__(' Kembali') }}</a>
                            </div>
                    </form>    
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