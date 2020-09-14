
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
            <div class="card-header text-center">{{__('Edit Iuran Kas Ph') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin-kas-ph.update', $showById->id ) }}">
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
                            <label for="iuran_ph" class="col-md-4 col-form-label text-md-right">{{__('Iuran Kas Ph') }}</label>

                            <div class="col-md-6">
                                <input id="iuran_ph" type="number" class="form-control @error('iuran_ph') is-invalid @enderror" name="iuran_ph" value="{{ $showById->iuran_ph }}" required autocomplete="iuran_ph" autofocus>
                                @error('iuran_ph')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="denda_ph" class="col-md-4 col-form-label text-md-right">{{__('Denda Kas Ph') }}</label>

                            <div class="col-md-6">
                                <input id="denda_ph" type="number" class="form-control @error('denda_ph') is-invalid @enderror" name="denda_ph" value="{{ $showById->denda_ph }}" required autocomplete="denda_ph" autofocus>
                                @error('denda_ph')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tanggal_batas_iuran" class="col-md-4 col-form-label text-md-right">{{__('Tanggal Batas Bayar Kas PH') }}</label>

                            <div class="col-md-6">
                                <input id="tanggal_batas_iuran" type="date" class="form-control @error('tanggal_batas_iuran') is-invalid @enderror" name="tanggal_batas_iuran" value="{{ $showById->tanggal_batas_iuran }}" required autocomplete="tanggal_batas_iuran" autofocus>
                                @error('tanggal_batas_iuran')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="text-center">
                                    <button type="submit" name="submit" class="btn btn-primary" value="PUT"><i class="far fa-save"></i>
                                        @if ($showById->iuran_kas_ph>0)
                                            {{__('Update') }}
                                        @else
                                            {{__('Simpan') }}
                                        @endif
                                    </button>
                                    <a href="{{ route('admin-kas-ph.index') }}" class="btn btn-warning"><i class="fas fa-arrow-circle-left"></i>{{__(' Kembali') }}</a>
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
