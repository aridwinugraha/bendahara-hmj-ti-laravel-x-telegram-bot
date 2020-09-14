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
                    <div class="card-header">
                        Update Email
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('edit.email', $showById->id) }}">
                            @method('put')
                            @csrf

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
                                <label class="col-md-4 col-form-label text-md-right">{{ __('Current Email Address') }}</label>
    
                                <div class="col-md-6">
                                    <input class="form-control"  value="{{ $showById->email }}" autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email Address') }}</label>
    
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" oninvalid="this.setCustomValidity('Tolong Masukkan Data Email Jangan Dibiarkan Kosong')"
                                    oninput="setCustomValidity('')" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
    
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" onclick="return confirm('Apakah Anda Yakin Ingin mengubah Email Address anda ?')" class="btn btn-primary" value="PUT"><i class="far fa-save"></i>
                                        Update Email
                                    </button>
                                </div>
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