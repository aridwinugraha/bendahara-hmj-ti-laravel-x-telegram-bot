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
                <div class="card-header text-center">{{__('Edit Laporan Kas PH') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin-laporan-kas.update', $showById->id) }}">
                        @csrf
                        @method('PUT')

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
                            <label for="nama_barang" class="col-md-4 col-form-label text-md-right">{{__('Nama Barang') }}</label>

                            <div class="col-md-6">
                                <input id="nama_barang" type="text" class="form-control @error('nama_barang') is-invalid @enderror" name="nama_barang" value="{{ $showById->nama_barang }}" required autocomplete="nama_barang" autofocus>
                                @error('nama_barang')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                        <label for="jumlah_barang" class="col-md-4 col-form-label text-md-right">{{__('Jumlah Barang') }}</label>

                            <div class="col-md-6">
                                <input id="rate" type="number" autocomplete="off" class="form-control @error('jumlah_barang') is-invalid @enderror val1" name="jumlah_barang" value="{{ $showById->jumlah_barang }}" autofocus>
                                @error('jumlah_barang')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="harga_satuan_barang" class="col-md-4 col-form-label text-md-right">{{__('Harga Satuan Barang(Rp)') }}</label>
    
                                <div class="col-md-6">
                                    <input id="box" type="number" autocomplete="off" class="form-control @error('harga_satuan_barang') is-invalid @enderror val2" name="harga_satuan_barang" value="{{ $showById->harga_satuan_barang }}" autofocus>
                                    @error('harga_satuan_barang')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                        </div>

                        <div class="form-group row">
                            <label for="satuan_barang" class="col-md-4 col-form-label text-md-right">{{__('Satuan Barang') }}</label>
    
                                <div class="col-md-6">
                            <select name="satuan_barang" class="form-control satuan_barang_list">
                                <option value=""></option>
                                <option value="kg" {{ $showById->satuan_barang == 'kg' ? 'selected' : '' }}>kg</option>
                                <option value="g" {{ $showById->satuan_barang == 'g' ? 'selected' : '' }}>g</option>
                                <option value="km" {{ $showById->satuan_barang == 'km' ? 'selected' : '' }}>km</option>
                                <option value="m" {{ $showById->satuan_barang == 'm' ? 'selected' : '' }}>m</option>
                                <option value="buah" {{ $showById->satuan_barang == 'buah' ? 'selected' : '' }}>Buah</option>
                                <option value="biji" {{ $showById->satuan_barang == 'biji' ? 'selected' : '' }}>Biji</option>
                                <option value="liter" {{ $showById->satuan_barang == 'liter' ? 'selected' : '' }}>Liter</option>
                            </select>
                                </div>
                        </div>
                        <div class="form-group row">
                            <label for="jumlah_harga_barang" class="col-md-4 col-form-label text-md-right">{{__('Total Harga Barang(Rp)') }}</label>
    
                                <div class="col-md-6">
                                    <input id="amount" type="number" class="form-control @error('jumlah_harga_barang') is-invalid @enderror multTotal" name="jumlah_harga_barang" value="{{ $showById->jumlah_harga_barang }}" readonly>
                                    @error('jumlah_harga_barang')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                        </div>

                        <div class="form-group row">
                            <label for="keterangan" class="col-md-4 col-form-label text-md-right">{{__('Keterangan') }}</label>
    
                                <div class="col-md-6">
                                    <textarea id="keterangan" name="keterangan" rows="5" class="form-control" oninvalid="this.setCustomValidity('Tolong Masukkan Data Keterangan Jangan Dibiarkan Kosong')"
                                        oninput="setCustomValidity('')" required autocomplete="keterangan" autofocus>{{ $showById->keterangan }}</textarea>
                                    @error('keterangan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                        </div>

                        <div class="text-center">
                                    <button type="submit" name="submit" class="btn btn-primary" value="PUT"><i class="far fa-save"></i>
                                        {{__('Update') }}
                                    </button>
                                    <a href="{{ route('admin-laporan-kas.index') }}" class="btn btn-warning"><i class="fas fa-arrow-circle-left"></i>{{__(' Kembali') }}</a>
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