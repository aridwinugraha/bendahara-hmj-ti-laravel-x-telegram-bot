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
                <h2 class="card-title m-t-10">{{ __('Tabel Data Anggota HMJ TI') }}</h2>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <a href="{{ route('admin-anggota.create') }}" class="btn btn-success">
                                    <span class="fa fa-user-plus"></span>{{__(' Anggota')}}
                                </a>
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
                                            @if ($ambil_anggota->name!=null)
                                            <td>{{ $ambil_anggota->name }} {{ $ambil_anggota->name_last }}</td>
                                            @else
                                                 <td class="i">{{__('Tidak Ada Data') }}</td>
                                            @endif
                                            @if ($ambil_anggota->status_anggota!=null)
                                            <td>{{ $ambil_anggota->status_anggota }}</td>
                                            @else
                                                <td class="i">{{__('Tidak Ada Data') }}</td>
                                            @endif
                                        <td>
                                            <form action="{{ route('admin-anggota.destroy', $ambil_anggota->id) }}" method="post"> @csrf @method('DELETE')
                                            <a href="{{ route('admin-anggota.show', $ambil_anggota->id) }}" class="btn btn-primary"><i class="fas fa-info-circle"></i>{{__(' Detail') }}</a>
                                            <a href="{{ route('admin-anggota.edit', $ambil_anggota->id) }}" class="btn btn-warning"><i class="fas fa-edit"></i>{{__(' Edit') }}</a>
                                            <button type="submit" onclick="return confirm('Apakah Anda Yakin Ingin menghapus data anggota {{ $ambil_anggota->name }} {{ $ambil_anggota->name_last }}?')" class="btn btn-danger"><i class="fas fa-trash"></i>{{__(' Hapus') }}</button>
                                            </form>            
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>                              
                                @endif
                            </table>
                        </div>
                    {{ $anggota->links() }}
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