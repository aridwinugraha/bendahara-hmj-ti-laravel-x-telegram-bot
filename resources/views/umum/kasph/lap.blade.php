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
                            <h2 class="card-title m-t-10">{{__('Pengeluaran Kas PH') }}</h2>
                        <div class="card">
                            <div class="card-body">
                                <a href="{{ route('export.pdf') }}" class="btn btn-success my-3" target="_blank"><i class="far fa-file-pdf"></i>{{__(' DOWNLOAD') }}</a>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th width="5%">{{__('No') }}</th>
                                                <th width="13%">{{__('Tanggal Pengeluaran') }}</th>
                                                <th width="15%">{{__('Nama Barang') }}</th>
                                                <th width="9%">{{__('Jumlah dan Satuan Barang') }}</th>
                                                <th width="9%">{{__('Harga Satuan Barang(Rp)') }}</th>
                                                <th width="9%">{{__('Jumlah Harga Barang(Rp)') }}</th>
                                                <th width="25%">{{__('Keterangan') }}</th>
                                            </tr>
                                        </thead>
                                        @if ($count == 0)
                                        <tbody>
                                            <tr>
                                                <td colspan="8" class="i ont-italic text-center">{{__('Tidak Ada Data') }}</td>
                                            </tr>
                                        </tbody>
                                        @else
                                        <tbody>
                                            @php(
                                                $no = 1 {{-- buat nomor urut --}}
                                                )
                                                @foreach ($lap as $data)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    @if ($data->created_at!=null)
                                                    <td>{{ \Carbon\Carbon::parse($data->created_at)->isoFormat('D MMMM Y') }}</td>
                                                    @else
                                                        <td class="i">{{__('Tidak Ada Data') }}</td>
                                                    @endif
                                                    @if ($data->nama_barang!=null)
                                                    <td>{{ $data->nama_barang }}</td>
                                                    @else
                                                        <td class="i">{{__('Tidak Ada Data') }}</td>
                                                    @endif
                                                    @if ($data->jumlah_barang!=null)
                                                        <td>{{ $data->jumlah_barang }} {{ $data->satuan_barang }}</td>
                                                    @else
                                                        <td class="i">{{__('Tidak Ada Data') }}</td>
                                                    @endif
                                                    @if ($data->harga_satuan_barang!=null)
                                                    <td>{{ $data->harga_satuan_barang }}</td>
                                                    @else
                                                        <td class="i">{{__('Tidak Ada Data') }}</td>
                                                    @endif
                                                    @if ($data->jumlah_harga_barang!=null)
                                                    <td>{{ $data->jumlah_harga_barang }}</td>
                                                    @else
                                                        <td class="i">{{__('Tidak Ada Data') }}</td>
                                                    @endif
                                                    @if ($data->keterangan!=null)
                                                    <td>{{ $data->keterangan }}</td>
                                                    @else
                                                        <td class="i">{{__('Tidak Ada Data') }}</td>
                                                    @endif
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        @endif
                                    </table>
                                </div>
                                        {{ $lap->links() }}
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
                        <h2 class="card-title m-t-10">{{__('Pengeluaran Kas PH') }}</h2>
                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route('export.pdf') }}" class="btn btn-success my-3" target="_blank"><i class="far fa-file-pdf"></i>{{__(' DOWNLOAD') }}</a>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th width="5%">{{__('No') }}</th>
                                            <th width="13%">{{__('Tanggal Pengeluaran') }}</th>
                                            <th width="15%">{{__('Nama Barang') }}</th>
                                            <th width="9%">{{__('Jumlah dan Satuan Barang') }}</th>
                                            <th width="9%">{{__('Harga Satuan Barang(Rp)') }}</th>
                                            <th width="9%">{{__('Jumlah Harga Barang(Rp)') }}</th>
                                            <th width="25%">{{__('Keterangan') }}</th>
                                        </tr>
                                    </thead>
                                    @if ($count == 0)
                                    <tbody>
                                        <tr>
                                            <td colspan="8" class="i ont-italic text-center">{{__('Tidak Ada Data') }}</td>
                                        </tr>
                                    </tbody>
                                    @else
                                    <tbody>
                                        @php(
                                            $no = 1 {{-- buat nomor urut --}}
                                            )
                                            @foreach ($lap as $data)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                @if ($data->created_at!=null)
                                                <td>{{ \Carbon\Carbon::parse($data->created_at)->isoFormat('D MMMM Y') }}</td>
                                                @else
                                                    <td class="i">{{__('Tidak Ada Data') }}</td>
                                                @endif
                                                @if ($data->nama_barang!=null)
                                                <td>{{ $data->nama_barang }}</td>
                                                @else
                                                    <td class="i">{{__('Tidak Ada Data') }}</td>
                                                @endif
                                                @if ($data->jumlah_barang!=null)
                                                    <td>{{ $data->jumlah_barang }} {{ $data->satuan_barang }}</td>
                                                @else
                                                    <td class="i">{{__('Tidak Ada Data') }}</td>
                                                @endif
                                                @if ($data->harga_satuan_barang!=null)
                                                <td>{{ $data->harga_satuan_barang }}</td>
                                                @else
                                                    <td class="i">{{__('Tidak Ada Data') }}</td>
                                                @endif
                                                @if ($data->jumlah_harga_barang!=null)
                                                <td>{{ $data->jumlah_harga_barang }}</td>
                                                @else
                                                    <td class="i">{{__('Tidak Ada Data') }}</td>
                                                @endif
                                                @if ($data->keterangan!=null)
                                                <td>{{ $data->keterangan }}</td>
                                                @else
                                                    <td class="i">{{__('Tidak Ada Data') }}</td>
                                                @endif
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    @endif
                                </table>
                            </div>
                                    {{ $lap->links() }}
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