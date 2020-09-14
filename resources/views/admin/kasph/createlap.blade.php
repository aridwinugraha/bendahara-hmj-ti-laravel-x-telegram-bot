@extends('layouts.app')

@section('content')
@if (Auth::user()->username_telegram != null && Auth::user()->chat_id != null)
<div class="container-fluid">
    <div class="row justify-content-center">
          <div class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
             @if (session('message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                      {{ session('message') }}
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                @endif
                    <h2 class="card-title m-t-10">{{__('Pengeluaran Kas PH') }}</h2>
                <div class="card">
                    <div class="card-body">                    
                        <div class="form-group">
                            @if($agent->isDesktop())
                            <form name="add_name" id="add_name">  
                    
                                <div class="alert alert-danger alert-dismissible print-error-msg fade show gone" role="alert">
                                    <ul></ul>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                            
                                <div class="alert alert-success alert-dismissible print-success-msg fade show gone" role="alert">
                                    <p class="mb-0" id="result"></p>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>    
                                </div>
        
                               <div class="table-responsive">  
                                   <table class="table table-bordered" id="dynamic_field">
                                    <thead>
                                        <tr>
                                            <th width="5%">{{__('No') }}</th>
                                            <th width="15%">{{__('Nama Barang') }}</th>
                                            <th width="40%">{{__('Keterangan') }}</th>
                                            <th width="10%">{{__('Jumlah Barang') }}</th>
                                            <th width="10%">{{__('Satuan Barang') }}</th>
                                            <th width="10%">{{__('Harga Satuan Barang(Rp)') }}</th>
                                            <th width="10%">{{__('Jumlah Harga Barang(Rp)') }}</th>
                                            <th>{{__('Action') }}</th>
                                        </tr>
                                    </thead> 
                                       <tr>
                                        @php(
                                            $i = 1 {{-- buat nomor urut --}}
                                            )
                                        <td width="5%"><input type="text" name="no[]" placeholder="Enter task" class="form-control no__list" value="{{ $i }}" readonly></td>
                                        <td width="15%"><input type="text" name="nama_barang[]" placeholder="Nama Barang" class="form-control nama_barang_list"></td>
                                        <td width="40%"><input type="text" name="keterangan[]" placeholder="Keterangan" class="form-control keterangan_list"></td>  
                                        <td width="10%"><input type="text" name="jumlah_barang[]" placeholder="Jumlah" class="form-control jumlah_barang_list val1"></td>
                                        <td width="10%">
                                            <select name="satuan_barang[]" class="form-control satuan_barang_list">
                                                <option value=""></option>
                                                <option value="kg" {{ old('satuan_barang[]') == 'kg' ? 'selected' : '' }}>kg</option>
                                                <option value="g" {{ old('satuan_barang[]') == 'g' ? 'selected' : '' }}>g</option>
                                                <option value="km" {{ old('satuan_barang[]') == 'km' ? 'selected' : '' }}>km</option>
                                                <option value="m" {{ old('satuan_barang[]') == 'm' ? 'selected' : '' }}>m</option>
                                                <option value="buah" {{ old('satuan_barang[]') == 'buah' ? 'selected' : '' }}>Buah</option>
                                                <option value="biji" {{ old('satuan_barang[]') == 'biji' ? 'selected' : '' }}>Biji</option>
                                                <option value="liter" {{ old('satuan_barang[]') == 'liter' ? 'selected' : '' }}>Liter</option>
                                            </select>
                                        </td>  
                                        <td width="10%"><input type="text" name="harga_satuan_barang[]" placeholder="Harga" class="form-control harga_satuan_barang_list val2"></td>  
                                        <td width="10%"><input type="text" name="jumlah_harga_barang[]" placeholder="Total 1" class="form-control jumlah_harga_barang_list multTotal"></td>
                                        <td><a name="add" id="add" class="btn btn-success"><i class="fa fa-plus"></i></a></td>  
                                       </tr>
                                       <tfoot>
                                        <tr>
                                            <td colspan="6" class="text-center">
                                                {{__('Total Pengeluaran Seluruh Transaksi') }}
                                            </td>
                                            <td colspan="2"><span id="grandTotal">0.00</span></td>
                                        </tr>
                                        </tfoot>  
                                   </table>
                                   <div class="text-center">
                                    <input type="button" name="submit" id="submit" class="btn btn-info" value="Simpan"/>
                                    <a href="{{ route('admin-laporan-kas.index') }}" class="btn btn-warning"><i class="fas fa-arrow-circle-left"></i>{{__(' Kembali') }}</a>
                                   </div>
                               </div>
                            </form>
                            @elseif($agent->isMobile())
                                
                            @include('admin.kasph.partials.mobilelap')
                            
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