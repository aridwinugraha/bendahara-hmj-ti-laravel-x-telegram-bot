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
                <div class="text-center m-t-30"> <img  width="250" height="220" alt="Deskripsi-Gambar" src="/images/logo-hmj.png">
                    <h3 class="card-title m-t-10 p-1">{{__('HMJ TI AKAKOM') }}</h3>
                      <h5 class="card-subtitle p-1">{{__('Total Kas HMJ Saat Ini') }}</h5>
                      @if ($count == 0)
                            <span class="fa fa-money h4 p-1"></span>
                              <a class="h5 color-black">
                                    Rp. 0,-
                              </a>
                            <div class="p-1"></div>
                            <a class="tab">
                                <a href="{{ route('admin-kas-hmj.create') }}"><button class="btn btn-primary"><i class="far fa-plus-square"></i>{{__(' Buat Kas') }}</button>
                            </a>
                      @else
                        @foreach ($kashmj as $hmj)
                                <span class="fa fa-money h4 p-1"></span>
                                  <a class="h5 color-black">
                                        Rp.{{ $hmj->total_kas_hmj }},-
                                  </a>
                                  <div class="p-1"></div>
                            <a class="tab">
                                <a href="{{ route('admin-kas-hmj.edit', $hmj->id) }}"><button class="btn btn-primary"><i class="fas fa-edit"></i>{{__(' Update Kas') }}</button>
                            </a>
                        @endforeach
                      @endif
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