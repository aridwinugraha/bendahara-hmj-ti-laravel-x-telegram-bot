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
                    <h2 class="card-title m-t-10">{{__('Pengeluaran Kas PH') }}</h2>
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('export.excel') }}" class="btn btn-success my-3" target="_blank"><i class="fa fa-file-excel"></i>{{__(' Export')}}</a>
                        <a href="{{ route('admin-laporan-kas.create') }}" class="btn btn-primary my-3"><i class="fa fa-plus"></i>{{__(' Data')}}</a>
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
                                        <th>{{__('Action') }}</th>
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
                                   @foreach ($lap as $l)
                                   <tr>
                                       <td>{{ $no++ }}</td>
                                       @if ($l->created_at!=null)
                                       <td>{{ \Carbon\Carbon::parse($l->created_at)->isoFormat('D MMMM Y') }}</td>
                                       @else
                                           <td class="i">{{__('Tidak Ada Data') }}</td>
                                       @endif
                                       @if ($l->nama_barang!=null)
                                       <td>{{ $l->nama_barang }}</td>
                                       @else
                                           <td class="i">{{__('Tidak Ada Data') }}</td>
                                       @endif
                                       @if ($l->jumlah_barang!=null && $l->satuan_barang!=null)
                                       <td>{{ $l->jumlah_barang }} {{ $l->satuan_barang }}</td>
                                       @else
                                            <td class="i">{{__('Tidak Ada Data') }}</td>
                                       @endif
                                       @if ($l->harga_satuan_barang!=null)
                                       <td>{{ $l->harga_satuan_barang }}</td>
                                       @else
                                            <td class="i">{{__('Tidak Ada Data') }}</td>
                                       @endif
                                       @if ($l->jumlah_harga_barang!=null)
                                       <td>{{ $l->jumlah_harga_barang }}</td>
                                       @else
                                            <td class="i">{{__('Tidak Ada Data') }}</td>
                                       @endif
                                       @if ($l->keterangan!=null)
                                       <td>{{ $l->keterangan }}</td>
                                       @else
                                            <td class="i">{{__('Tidak Ada Data') }}</td>
                                       @endif
                                   <td align="center" width="30%">
                                       <form action="{{ route('admin-laporan-kas.destroy', $l->id) }}" method="post"> @csrf @method('DELETE')
                                       <a href="{{ route('admin-laporan-kas.edit', $l->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i>{{__(' Edit') }}</a>
                                       <button type="submit" onclick="return confirm('Apakah Anda Yakin Ingin menghapus data {{ $l->nama_barang }}?')" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i>{{__(' Hapus') }}</button>               
                                   </td>
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
        @forelse ($anggota as $t)    
        @empty
            @include('modal') 
        @endforelse
@endsection