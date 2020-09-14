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
                <h2 class="card-title m-t-10">{{__('Aturan Pengingat Setoran Uang Kas PH') }}<div class="float-right"></div></h2>
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('reminder.create') }}"><button class="btn btn-primary"><i class="fas fa-plus"></i>{{__(' Reminder') }}</button></a>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>{{__('Reminder') }}</th>
                                        <th>{{__('Status') }}</th>
                                        <th>{{__('Waktu Notifikasi') }}</th>
                                        <th>{{__('Pesan') }}</th>
                                        <th>{{__('Action') }}</th>
                                    </tr>
                                </thead>
                            @if ($count == 0)
                                <tbody>
                                    <tr>
                                        <td colspan="4" class="i ont-italic text-center">{{__('Tidak Ada Data') }}</td>
                                    </tr>
                                </tbody>
                            @else
                                <tbody>
                                    @foreach ($reminder as $r)
                                        <tr>
                                            @if ($r->chat_id_reminder!=null)
                                            <td>{{__('Nama :   ')}}{{ $r->first_nama_tujuan }} {{ $r->last_nama_tujuan }} {{__(', Nomor Handphone ') }} {{ $r->no_hp_tujuan }} {{__('Rp. ') }}{{ $r->nominal }}</td>
                                            @else
                                            <td class="i">Tidak Ada Data</td>
                                            @endif
                                            @if ($r->status_iuran!=null)
                                            <td>{{ $r->status_iuran }}</td>
                                            @else
                                            <td class="i">Tidak Ada Data</td>
                                            @endif
                                            @if ($r->notifikasi!=null)
                                                @if ($r->notifikasi=='5')
                                                    <td>{{__('Tiap 5 Menit') }}</td>
                                                @elseif ($r->notifikasi=='10')
                                                    <td>{{__('Tiap 10 Menit') }}</td>
                                                @elseif ($r->notifikasi=='30')
                                                    <td>{{__('Tiap 30 Menit') }}</td>
                                                @elseif ($r->notifikasi=='60')
                                                    <td>{{__('Tiap 60 Menit(Satu Kali sejam)') }}</td>
                                                @elseif ($r->notifikasi=='180')
                                                    <td>{{__('Tiap 180 Menit(Satu Kali dalam tiga jam)') }}</td>
                                                @elseif ($r->notifikasi=='480')
                                                    <td>{{__('Tiap 480 Menit(Tiga Kali Sehari)') }}</td>
                                                @elseif ($r->notifikasi=='720')
                                                    <td>{{__('Tiap 720 Menit(Dua Kali Sehari)') }}</td>
                                                @elseif ($r->notifikasi=='1440')
                                                    <td>{{__('Tiap 1440 Menit(Satu Kali Sehari)') }}</td>
                                                @elseif ($r->notifikasi=='3600')
                                                    <td>{{__('Tiap 3600 Menit(Satu Kali dalam dua hari)') }}</td>
                                                @elseif ($r->notifikasi=='10080')
                                                    <td>{{__('Tiap 10080 Menit(Mingguan)') }}</td>
                                                @elseif ($r->notifikasi=='43200')
                                                    <td>{{__('Tiap 43200 Menit(Satu Bulan jumlah hari nya = 30 sekali)') }}</td>
                                                @elseif ($r->notifikasi=='43260')
                                                    <td>{{__('Tiap 43260 Menit(Satu Bulan jumlah hari nya = 31 sekali)') }}</td>
                                                @endif
                                            @else
                                            <td class="i">Tidak Ada Data</td>
                                            @endif
                                            @if ($r->pesan_pengingat!=null)
                                            <td width="35%">{!! $r->pesan_pengingat !!}</td>
                                            @else
                                            <td class="i">Tidak Ada Data</td>
                                            @endif
                                            <td align="center" width="20%">
                                                <form action="{{ route('reminder.destroy', $r->id) }}" method="post"> @csrf @method('DELETE')
                                                    <a href="{{ route('reminder.edit', $r->id) }}" class="btn btn-primary"><i class="fas fa-edit"></i>{{__(' Edit') }}</a>
                                                    <button type="submit" onclick="return confirm('Apakah Anda Yakin Ingin menghapus data reminder {{ $r->first_nama_tujuan }} {{ $r->last_nama_tujuan }}?')" class="btn btn-danger"><i class="fas fa-trash"></i>{{__(' Hapus') }}</button>            
                                                </form>
                                            </td>
                                            </tr>
                                    @endforeach
                                </tbody>
                            @endif  
                            </table>
                    {{ $reminder->links() }}
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