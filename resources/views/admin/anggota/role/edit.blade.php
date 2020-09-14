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
                        <form method="POST" action="{{ route('update.level', $showById->id) }}">
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
                                <label class="col-md-4 col-form-label text-md-right">{{__('Nomor Pokok Keanggotaan') }}</label>
       
                                   <div class="col-md-6">
                                       <input type="text" class="form-control" value="{{ $showById->npk }}" readonly>
                                   </div>
                               </div>
       
                               <div class="form-group row">
                                   <label class="col-md-4 col-form-label text-md-right">{{__('Nama Depan') }}</label>
       
                                   <div class="col-md-6">
                                       <input type="text" class="form-control" value="{{ $showById->name }}" readonly>
                                   </div>
                               </div>
       
                               <div class="form-group row">
                                   <label class="col-md-4 col-form-label text-md-right">{{__('Nama Belakang') }}</label>
       
                                   <div class="col-md-6">
                                       <input type="text" class="form-control" value="{{ $showById->name_last }}" readonly>
                                   </div>
                               </div>

                               <div class="form-group row">
                                <label for="level" class="col-md-4 col-form-label text-md-right">{{__('Level User') }}</label>
    
                                <div class="col-md-6">
                                    <label class="col-form-label @error('level') is-invalid @enderror"><input id="level" type="radio" name="level" value="admin" {{ $showById->level == 'admin' ? 'checked' : '' }} />{{__(' Admin') }}</label>
                                    <label><input id="level" type="radio" name="level" value="user" {{ $showById->level == 'user' ? 'checked' : '' }} />{{__(' User') }}</label>
                                    @error('level')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" onclick="return confirm('Apakah Anda Yakin Ingin mengubah level user dari anggota {{ $showById->name }} {{ $showById->name_last }}?')" class="btn btn-primary" value="PUT"><i class="far fa-save"></i>
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