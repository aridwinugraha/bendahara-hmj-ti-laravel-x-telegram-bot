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
                <div class="card-header text-center">{{__('Buat Kas HMJ') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin-kas-hmj.store') }}">
                        @csrf

                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                Terdapat beberapa kasalahan pada saat mengisi yang harus diperbaiki.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li> @endforeach
                                </ul>
                            </div>
                        @endif
                        
                         <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{__('Sisa Uang Kas HMJ') }}</label>

                            <div class="col-md-6">
                                <input type="number" autocomplete="off" class="form-control inst_amount" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{__('Sisa Uang Event HMJ') }}</label>

                            <div class="col-md-6">
                                <input type="number" autocomplete="off" class="form-control inst_amount" value="0" autofocus>
                            </div>
                        </div>

                         <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{__('Uang Pegangan Bendahara') }}</label>

                            <div class="col-md-6">
                                <input type="number" autocomplete="off" class="form-control inst_amount" value="0" autofocus>
                            </div>
                        </div>

                         <div class="form-group row">
                            <label for="total_kas_hmj" class="col-md-4 col-form-label text-md-right">{{__('Total Uang Kas HMJ') }}</label>

                            <div class="col-md-6">
                                <input id="total_price" class="form-control total_amount" type="number" name="total_kas_hmj" readonly>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" name="submit" class="btn btn-primary"><i class="fas fa-save"></i>
                                    {{__('Simpan') }}
                            </button>
                            <a href="{{ route('admin-kas-hmj.index') }}" class="btn btn-warning"><i class="fas fa-arrow-circle-left"></i>{{__(' Kembali') }}</a>
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