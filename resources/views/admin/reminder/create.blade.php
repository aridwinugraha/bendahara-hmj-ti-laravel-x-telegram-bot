@extends('layouts.app')

@section('content')
@if (Auth::user()->username_telegram != null && Auth::user()->chat_id != null)
    @if ($count_ph != 0)
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
                        <div class="card-header text-center">{{__('Form Tambah Reminder') }}</div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('reminder.store') }}">
                                @csrf

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
                                        <select id="tujuan" name="pilihan" class="form-control @if ($errors->has('')) is-invalid @endif">
                                            <option value=""></option>
                                            <option value="all">{{__('Pilih Semua') }}</option>@foreach($user as $u)
                                            <option  value="{{ $u->id }}">{{ $u->name }} {{ $u->name_last }}</option> @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="first_nama_tujuan" class="col-md-4 col-form-label text-md-right">{{__('Nama Depan Penerima') }}</label>

                                    <div class="col-md-6">
                                        <input id="first_nama_tujuan" type="text" class="form-control @error('first_nama_tujuan') is-invalid @enderror" name="first_nama_tujuan" required autocomplete="first_nama_tujuan" readonly>
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
                                        <input id="last_nama_tujuan" type="text" class="form-control @error('last_nama_tujuan') is-invalid @enderror" name="last_nama_tujuan" required autocomplete="last_nama_tujuan" readonly>
                                        @error('last_nama_tujuan')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                <label for="username_telegram" class="col-md-4 col-form-label text-md-right">{{__('Username Telegram Penerima') }}</label>

                                    <div class="col-md-6">
                                        <input id="username_telegram" type="text" class="form-control @error('username_telegram') is-invalid @enderror" name="username_telegram_reminder" required autocomplete="username_telegram" readonly>
                                        @error('username_telegram')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="chat_id" class="col-md-4 col-form-label text-md-right">{{__('Chat ID Telegram Penerima') }}</label>

                                    <div class="col-md-6">
                                        <input id="chat_id" type="text" class="form-control @error ('chat_id') is-invalid @enderror" name="chat_id_reminder" required autocomplete="chat_id" readonly>
                                        @error('chat_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="no_hp_tujuan" class="col-md-4 col-form-label text-md-right">{{__('Nomor Penerima') }}</label>

                                    <div class="col-md-6">
                                        <input id="no_hp_tujuan" type="text" class="form-control @error('no_hp_tujuan') is-invalid @enderror" name="no_hp_tujuan" required autocomplete="no_hp_tujuan" readonly>
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
                                        <input id="denda" type="text" class="form-control @error('denda') is-invalid @enderror inst_amount"  required autocomplete="denda" readonly>
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
                                        <input id="iuran_ph" type="number" class="form-control @error('iuran_ph') is-invalid @enderror inst_amount" placeholder="{{__('Isi Input Iuran PH ini dengan nilai ')}}{{ $ph->iuran_ph }}" required autocomplete="iuran_ph" autofocus>
                                        @endforeach
                                        @error('iuran_ph')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label id="total" for="nominal" class="col-md-4 col-form-label text-md-right">{{__('Total Iuran PH dan Denda Kas Penerima Pesan') }}</label>

                                    <div class="col-md-6">
                                        <input id="total_price" type="number" class="form-control @error('nominal') is-invalid @enderror total_amount" name="nominal" required autocomplete="nominal" autofocus>
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
                                                    <option value="5" {{ old('notifikasi') == '5' ? 'selected' : '' }}>Tiap 5 Menit</option>
                                                    <option value="10" {{ old('notifikasi') == '10' ? 'selected' : '' }}>Tiap 10 Menit</option>
                                                    <option value="30" {{ old('notifikasi') == '30' ? 'selected' : '' }}>Tiap 30 Menit</option>
                                                    <option value="60" {{ old('notifikasi') == '60' ? 'selected' : '' }}>Tiap 60 Menit(Satu Kali sejam)</option>
                                                    <option value="180" {{ old('notifikasi') == '180' ? 'selected' : '' }}>Tiap 180 Menit(Satu Kali dalam tiga jam)</option>
                                                    <option value="480" {{ old('notifikasi') == '480' ? 'selected' : '' }}>Tiap 480 Menit(Tiga Kali sehari)</option>
                                                    <option value="720" {{ old('notifikasi') == '720' ? 'selected' : '' }}>Tiap 720 Menit(Dua Kali sehari)</option>
                                                    <option value="1440" {{ old('notifikasi') == '1440' ? 'selected' : '' }}>Tiap 1440 Menit(Satu Kali sehari)</option>
                                                    <option value="3600" {{ old('notifikasi') == '3600' ? 'selected' : '' }}>Tiap 3600 Menit(Satu Kali dalam dua hari)</option>
                                                    <option value="10080" {{ old('notifikasi') == '10080' ? 'selected' : '' }}>Tiap 10080 Menit(Mingguan)</option>
                                                    <option value="43200" {{ old('notifikasi') == '43200' ? 'selected' : '' }}>Tiap 43200 Menit(Satu Kali dalam satu bulan jumlah hari nya = 30)</option>
                                                    <option value="43260" {{ old('notifikasi') == '43260' ? 'selected' : '' }}>Tiap 43260 Menit(Satu Kali dalam satu bulan jumlah hari nya = 31)</option>
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

                                    <div id="pesan_petunjuk" class="col-md-6">
                                        {!!__("<b> Petunjuk Pengisian Pesan Pengingat </b><br>"
                                        . "Secara Default Pesan Memiliki konteks<br>"
                                        . "seperti pesan dibawah ini<br>"
                                        . "Pesan Default :<br>"
                                        . "{!--<br>"
                                        . "<b>PENGINGAT</b><br>"
                                        . "<b>Salam Informatika</b><br>"
                                        . "<b>'NAMA DEPAN TUJUAN REMINDER' 'NAMA BELAKANG TUJUAN REMINDER'</b>, Anda memiliki tagihan kas PH yang belum terbayar<br>"
                                        . "Iuran tersebut sebesar <b>Rp. 'IURAN KAS PH'</b><br>"
                                        . "tanggal batas pembayaran hingga <b>'TANGGAL BATAS IURAN KAS PH'</b><br>"
                                        . "segeralah membayar sebelum batas waktu<br>"
                                        . "jika tidak membayar hingga batas waktu<br>"
                                        . "maka otomatis akan dikenai Denda<br>"
                                        . "<br>"
                                        . "<b>Cara Membalas Pesan (jika siap atau belum membayar) :</b><br>"
                                        . "<br>"
                                        . "Balas /bayar<br>"
                                        . "jika telah benar-benar membayar iuran,<br>"
                                        . "<br>"
                                        . "Balas /belum<br>"
                                        . "jika belum membayar iuran.<br>"
                                        . "<br>"
                                        . "<b>Terima Kasih</b><br>"
                                        . "--!}<br>"
                                        . "<br>"
                                        . "Jika <b>ADMIN</b> ingin menggunakan pesan Default tersebut<br>"
                                        . "Silahkan Copy pesan ke textarea yang ada dibawah<br>"
                                        . "dan ganti <b>'NAMA DEPAN', 'NAMA BELAKANG'</b><br>"
                                        . "<b>'IURAN KAS PH'</b> dan <b>'TANGGAL BATAS IURAN KAS PH'</b><br>"
                                        . "Serta tambahkan syntax HTML untuk membuat font menjadi bold") !!}{{__(" '<b>Nama Tujuan</b>'")}}
                                        {!!__("<br>"
                                        . "<br>"
                                        . "Namun jika <b>ADMIN</b> ingin membuat pesan pengingat dengan konteks lain<br>"
                                        . "atau memodifikasi isi pesan default tersebut<br>"
                                        . "bisa dibuat atau edit di textarea yang ada dibawah<br>"
                                        . "<b>Jangan Lupa Untuk Menulis/Mengetik Nama Pengurus yang akan dikirimi pesan,</b><br>"
                                        . "<b>Nominal Iuran Kas PH yang harus dibayar</b> dan<br>"
                                        . "<b>Tanggal Batas Iuran Kas PH</b><br>"
                                        . "<br>"
                                        . "Sekian Petunjuk Pengisian Pesan Pengingat<br>"
                                        . "<br>") !!}
                                    </div>
                                <div id="jarak" class="col-md-4 col-form-label text-md-right"></div>
                                    <div class="col-md-6">
                                    <textarea id="pesan_pengingat" name="pesan_pengingat" rows="5" class="form-control" oninvalid="this.setCustomValidity('Tolong Masukkan Data Pesan Jangan Dibiarkan Kosong')"
                                    oninput="setCustomValidity('')" required autocomplete="pesan_pengingat" autofocus></textarea>
                                        @error('pesan_pengingat')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>{{__(' Simpan') }}</button>
                                        <a href="{{ route('reminder.index') }}" onclick="return confirm('Apakah Anda Yakin Ingin Kembali ke halaman sebelumnya, form akan direset jika anda kembali ?')" class="btn btn-warning"><i class="fas fa-arrow-circle-left"></i>{{__(' Kembali') }}</a>
                                    </div>
                                </div>
                            </form>    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        @include('modal_kas')
    @endif
@else
    @include('modal')
@endif
@forelse ($anggota as $t)    
@empty
    @include('modal') 
@endforelse
@endsection