@extends('layouts.app')

@section('content')
@if (Auth::user()->status_anggota == 'Pengurus Harian')
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
                        <h2 class="card-title m-t-10">{{ __('Tabel Data Anggota HMJ TI') }}</h2>
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>{{__('No') }}</th>
                                                <th>{{__('NPK') }}</th>
                                                <th>{{__('Nama Lengkap') }}</th>
                                                <th>{{__('Status') }}</th>
                                                <th>{{__('Action') }}</th>
                                            </tr>
                                        </thead>
                                        @if ($count == 0)
                                            <tr>
                                                <td colspan="5" class="i text-center">{{__('Tidak Ada Data') }}</td>
                                            </tr>
                                        @else
                                        <tbody>
                                            @php(
                                                $no = 1 {{-- buat nomor urut --}}
                                                )
                                                @foreach ($anggota as $ambil_anggota)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    @if ($ambil_anggota->npk!=null)
                                                    <td>{{ $ambil_anggota->npk }}</td>
                                                    @else
                                                        <td class="i">{{__('Tidak Ada Data') }}</td>
                                                    @endif
                                                    @if ($ambil_anggota->name!=null && $ambil_anggota->name_last!=null)
                                                    <td>{{ $ambil_anggota->name }} {{ $ambil_anggota->name_last }}</td>
                                                    @else
                                                        <td class="i">{{__('Tidak Ada Data') }}</td>
                                                    @endif
                                                    @if ($ambil_anggota->status_anggota!=null)
                                                    <td>{{ $ambil_anggota->status_anggota }}</td>
                                                    @else
                                                        <td class="i">{{__('Tidak Ada Data') }}</td>
                                                    @endif
                                                <td align="center" width="30%">
                                                    @if ($ambil_anggota->id==Auth::user()->id)
                                                        <a href="{{ route('anggota.edit', Auth::user()->id) }}" class="btn btn-warning"><i class="fas fa-edit"></i>{{__(' Edit') }}</a>
                                                    @endif
                                                        <a href="{{ route('anggota.show', $ambil_anggota->id) }}" class="btn btn-primary"><i class="fas fa-info-circle"></i>{{__(' Detail') }}</a>     
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        @endif
                                    </table>
                                    {{ $anggota->links() }}
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
                    <h2 class="card-title m-t-10">{{ __('Tabel Data Anggota HMJ TI') }}</h2>
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>{{__('No') }}</th>
                                            <th>{{__('NPK') }}</th>
                                            <th>{{__('Nama Lengkap') }}</th>
                                            <th>{{__('Status') }}</th>
                                            <th>{{__('Action') }}</th>
                                        </tr>
                                    </thead>
                                    @if ($count == 0)
                                        <tr>
                                            <td colspan="5" class="i text-center">{{__('Tidak Ada Data') }}</td>
                                        </tr>
                                    @else
                                    <tbody>
                                        @php(
                                            $no = 1 {{-- buat nomor urut --}}
                                            )
                                            @foreach ($anggota as $ambil_anggota)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                @if ($ambil_anggota->npk!=null)
                                                <td>{{ $ambil_anggota->npk }}</td>
                                                @else
                                                    <td class="i">{{__('Tidak Ada Data') }}</td>
                                                @endif
                                                @if ($ambil_anggota->name!=null && $ambil_anggota->name_last!=null)
                                                <td>{{ $ambil_anggota->name }} {{ $ambil_anggota->name_last }}</td>
                                                @else
                                                    <td class="i">{{__('Tidak Ada Data') }}</td>
                                                @endif
                                                @if ($ambil_anggota->status_anggota!=null)
                                                <td>{{ $ambil_anggota->status_anggota }}</td>
                                                @else
                                                    <td class="i">{{__('Tidak Ada Data') }}</td>
                                                @endif
                                            <td align="center" width="30%">
                                                @if ($ambil_anggota->id==Auth::user()->id)
                                                    <a href="{{ route('anggota.edit', Auth::user()->id) }}" class="btn btn-warning"><i class="fas fa-edit"></i>{{__(' Edit') }}</a>
                                                @endif
                                                    <a href="{{ route('anggota.show', $ambil_anggota->id) }}" class="btn btn-primary"><i class="fas fa-info-circle"></i>{{__(' Detail') }}</a>     
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    @endif
                                </table>
                                {{ $anggota->links() }}
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