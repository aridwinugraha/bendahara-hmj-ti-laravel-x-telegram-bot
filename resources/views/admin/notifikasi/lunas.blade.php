@extends('layouts.app')

@section('content')
@if (Auth::user()->username_telegram != null && Auth::user()->chat_id != null)
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
            @if (session('message'))
            <div class="alert alert-success  alert-dismissible fade show" role="alert">
              {{ session('message') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
        @endif
            <div class="card">
                <div class="card-header p-4">
                    <h1 class="font-weight-bolder text-center">{{__('Notifikasi') }}</h1>
                  </div>
                <div class="card-body">
                @if ($count == 0)
                    <h5 class="i text-center">{{__('Tidak Ada Notifikasi') }}</h5>
                @else
                    @if ($count_2 == 0)
                        <h4 class="font-weight-bolder pb-4">{{__('Semua Pesan Telah Dikonfirmasi') }}</h4>   
                    @else
                        <h4 class="font-weight-bolder pb-4"><mark class="bg-yellow">{{__('Pesan "Konfirmasi Lunas Iuran PH dan denda" Yang Belum Dikonfirmasi : ') }}{{ $count_2 }}{{__(' Pesan') }}</mark></h4>
                    @endif
                @foreach ($notif as $n)
                @if ($n->status_notifikasi=='tunggu konfirmasi lunas')
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                                    {{-- konten notif --}}
                                    <div class="card shadow-sm">
                                        <div class="card-body">
                                        <h5 class="font-weight-bolder">{{ $n->first_nama }} {{ $n->last_nama }} {{__(' Menunggu Konfirmasi Pelunasan Iuran PH dan denda PH')}}</h5>
                                            <div class="px-md-5">
                                                <p>{{ $n->nama }} {{__('telah mengirim konfirmasi telah membayar iuran PH dan denda sebesar Rp') }} {{ $n->nominal_bayar }} {{__('pada tanggal') }} {{ Carbon\Carbon::parse($n->updated_at)->isoFormat('D MMMM Y') }}
                                                    <br>{{__('Apakah anda memberikan persetujuan ?') }}
                                                </p>
                                            </div>
                                            <div class="px-md-3">
                                                <span class="float-left pr-2">
                                                    <form action="{{ route('notifikasi.update.lunas', $n->id) }}" method="post"> @csrf @method('PUT')
                                                        <button type="submit" onclick="return confirm('Apakah Anda Yakin Ingin Memberikan Persetujuan kepada {{ $n->first_nama }} {{ $n->last_nama }}?')" class="btn btn-primary"><i class="far fa-check-circle"></i>{{__(' Setuju') }}</button>
                                                    </form>
                                                </span>
                
                                                <span class="float-left">
                                                    <form action="{{ route('Route::put('/notifikasi/tidak/{id}', 'NotifikasiController@tidak')->middleware('auth')->name('notifikasi.update.tidak');
                                                        ', $n->id) }}" method="post"> @csrf @method('PUT')
                                                        <button type="submit" onclick="return confirm('Apakah Anda Yakin Tidak Memberikan Persetujuan kepada {{ $n->first_nama }} {{ $n->last_nama }}?')" class="btn btn-danger"><i class="far fa-times-circle"></i>{{__(' Tidak Setuju') }}</button>
                                                    </form>
                                                </span>
                                            </div>  
                                        </div>  
                                    </div>
                                    <div class="row-bottom-2"></div>    
                        </div>
                    </div>
                @endif
            @endforeach
                @endif
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