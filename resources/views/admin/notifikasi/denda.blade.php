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
                    @if ($count_4 == 0)
                        <h4 class="font-weight-bolder pb-4">{{__('Semua Pesan Telah Dikonfirmasi') }}</h4>   
                    @else
                        <h4 class="font-weight-bolder pb-4"><mark class="bg-yellow">{{__('Pesan "Konfirmasi Tidak Membayar Iuran Kas PH Bulan lalu" Yang Belum Dikonfirmasi : ') }}{{ $count_4 }}{{__(' Pesan') }}</mark></h4>
                    @endif
                @foreach ($notif as $n)
                @if ($n->status_notifikasi=='tidak setuju')
                <div class="row justify-content-center">
                    <div class="col-md-10">
                                {{-- konten notif --}}
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                @if (\Carbon\Carbon::now() > \Carbon\Carbon::parse($batas_tgl) )
                                    <h5 class="font-weight-bolder">{{ $n->first_nama }} {{ $n->last_nama }} {{__(' Pesan Anggota Tidak Membayar Iuran Kas PH')}}</h5>
                                    <div class="px-md-5">
                                        <p>{{ $n->first_nama }} {{ $n->last_nama }} {{__('terkonfirmasi tidak membayar iuran Kas PH bulan lalu') }}
                                            <br>{{__('Apakah anda memberikan persetujuan ?') }}
                                        </p>
                                    </div>
                                    <div class="px-md-3">
                                        <span class="float-left pr-2">
                                            <a href="{{ route('notifikasi.update.denda', $n->id) }}" onclick="return confirm('Apakah Anda Yakin Ingin Memberikan Denda PH kepada {{ $n->first_nama }} {{ $n->last_nama }}?')" class="btn btn-primary"><i class="far fa-check-circle"></i>{{__(' Setuju') }}</a>
                                        </span>
                                    </div>
                                @else
                                    <h5 class="font-weight-bolder">{{ $n->first_nama }} {{ $n->last_nama }} {{__(' Pesan Anggota Belum Membayar Iuran Kas PH')}}</h5>
                                    <div class="px-md-5">
                                        <p>{{ $n->first_nama }} {{ $n->last_nama }} {{__('terkonfirmasi belum membayar iuran Kas PH') }} {{__('pada tanggal') }} {{ Carbon\Carbon::parse($n->updated_at)->isoFormat('D MMMM Y') }}
                                            <br>{{__('Belum Bisa Memberikan Persetujuan, tunggu hingga batas waktu bayar iuran kas telah melewati batas tanggal nya...') }}
                                        </p>
                                    </div>
                                    <div class="px-md-3">
                                        <span class="float-left pr-2">
                                            <a href="{{ route('notifikasi.update.denda', $n->id) }}" onclick="return confirm('Apakah Anda Yakin Ingin Memberikan Denda PH kepada {{ $n->first_nama }} {{ $n->last_nama }}?')" class="btn btn-primary disabled" disabled><i class="far fa-check-circle"></i>{{__(' Setuju') }}</a>
                                        </span>
                                    </div>
                                @endif  
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