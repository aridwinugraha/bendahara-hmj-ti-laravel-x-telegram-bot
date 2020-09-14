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
                <div class="card-body">
                    <div class="panel panel-default">
                        <div class="panel-body">
                                <h2 class="page-header">{{__('Halaman Detail Anggota') }}</h2>
                                <div class="panel panel-primary">
                <div class="col-lg-19">
                        <!-- /.panel-heading -->
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <tbody>
            <tr>
            <td>{{__('Nomor Pokok Keanggotaan') }}</td>
            @if ($detail->npk!=null)
            <td>{{ $detail->npk }}</td>
            @else
            <td class="i">{{__('Tidak Ada Data') }}</td>
            @endif
            </tr>

            <tr>                                 
            <td class="col-lg-3">{{__('Nama') }}</td>
            @if ($detail->name!=null && $detail->name_last!=null)
            <td>{{ $detail->name }} {{ $detail->name_last }}</td>
            @else
            <td class="i">{{__('Tidak Ada Data') }}</td>
            @endif
            </tr>

            <tr>
            <td>{{__('Email') }}</td>
            @if ($detail->email!=null)
            <td>{{ $detail->email }}</td>
            @else
            <td class="i">{{__('Tidak Ada Data') }}</td>
            @endif
            </tr>

            @if ($detail->level=='admin')
                <tr>                                 
                <td class="col-lg-3">{{__('Role (Web Bendahara HMJ TI)') }}</td>
                @if ($detail->level!=null)
                <td>{{ $detail->level }}</td>
                @else
                <td class="i">{{__('Tidak Ada Data') }}</td>
                @endif
                </tr>    
            @endif

            <tr>
            <td>{{__('Jenis Kelamin') }}</td>
            @if ($detail->jk!=null)
            <td>{{ $detail->jk }}</td>
            @else
            <td class="i">{{__('Tidak Ada Data') }}</td>
            @endif
            </tr>

            <tr>
            <td>{{__('Agama') }}</td>
            @if ($detail->agama!=null)
            <td>{{ $detail->agama }}</td>
            @else
            <td class="i">{{__('Tidak Ada Data') }}</td>
            @endif
            </tr>

            <tr>
            <td>{{__('Nomot Telepon') }}</td>
            @if ($detail->no_hp!=null)
            <td>{{ $detail->no_hp }}</td>
            @else
            <td class="i">{{__('Tidak Ada Data') }}</td>            
            @endif
            </tr>

            <tr>
            <td>{{__('Status') }}</td>
            @if ($detail->status_anggota!=null)
            <td>{{ $detail->status_anggota }}</td>
            @else
            <td class="i">{{__('Tidak Ada Data') }}</td>            
            @endif
            </tr>

            <tr>
            <td>{{__('Total Iuran') }}</td>
            @if ($detail->iuran_kas>=0)
            <td>{{ $detail->iuran_kas }}</td>
            @else
            <td class="i">{{ $detail->iuran_kas }}</td>
            @endif
            </tr>

            <tr>
            <td>{{__('Denda') }}</td>
            @if ($detail->denda>=0)
            <td>{{ $detail->denda }}</td>
            @else
            <td class="i">{{__('Tidak Ada Data') }}</td>
            @endif
            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
            <div class="text-center"> 
                <a href="{{ route('admin-anggota.edit', $detail->id) }}"><button class="btn btn-primary"><i class="fas fa-edit"></i>{{__(' Edit') }}</button></a>
                <a href="{{ route('admin-anggota.index') }}"><button class="btn btn-warning"><i class="fas fa-arrow-circle-left"></i>{{__(' Kembali') }}</button></a>
            </div>
        </div><br>
        <!-- /.col-lg-6 -->
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