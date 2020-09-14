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
              <h3 class="card-title m-t-10">{{__('Data Kas Pengurus Harian') }}</h3>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                      <thead>
                                        <tr>
                                          <th>{{__('No') }}</th>
                                          <th>{{__('NPK') }}</th>
                                          <th>{{__('Nama PH') }}</th>
                                          <th>{{__('Tabungan') }}</th>
                                          <th>{{__('Action') }}</th>
                                        </tr>
                                      </thead>
                                      @if ($count == 0)
                                      <tbody>
                                        <tr>
                                          <td colspan="5" class="i font-italic text-center">
                                                {{__("Data Pengurus Harian belum di-perbaharui, mohon perbaharui data anggota dengan mengganti status anggota menjadi 'Pengurus Harian'") }}
                                                <form action="{{ route('admin-anggota.index') }}" method="get"> @csrf @method('GET')
                                                  <div class="col-sm-12">
                                                    <br>
                                                    <button class="btn btn-success">{{__('Data Anggota') }}</button>
                                                  </div>
                                            </form>
                                          </td>
                                        </tr>
                                      </tbody>
                                      @else
                                      <tbody>
                                        @php(
                                              $no = 1 {{-- buat nomor urut --}}
                                              )
                                          
                                             @foreach ($users as $u)
                                                {{-- @if ($u->status_anggota=="Pengurus Harian") --}}
                                              <tr>
                                                  <td>{{ $no++ }}</td>
                                                  @if ($u->npk!=null)
                                                  <td>{{ $u->npk }}</td>
                                                  @else
                                                      <td class="i">{{__('Tidak Ada Data') }}</td>
                                                  @endif
                                                  @if ($u->name!=null)
                                                  <td>{{ $u->name }} {{ $u->name_last }}</td>
                                                  @else
                                                       <td class="i">{{__('Tidak Ada Data') }}</td>
                                                  @endif
                                                  @if ($u->iuran_kas!=null)
                                                  <td>{{ $u->iuran_kas }}</td>
                                                  @else
                                                      <td>{{ $u->iuran_kas }}</td>
                                                  @endif
                                              <td align="center">
                                                    <a href="{{ route('admin-anggota.edit', $u->id ) }}" class="btn btn-warning"><i class="fas fa-edit"></i>{{__(' Edit') }}</a>       
                                              </td>
                                          </tr>
                                            {{-- @endif --}}
                                          @endforeach
                                        </tbody>
                                      @endif
                            </table>
                        </div>
                    {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-lg-5 ml-sm-auto px-md-4 d-flex align-items-stretch">
            <div class="card flex-fill">
              <div class="card-body flex-fill">
            @if ($count_ph == 0)
            <div class="text-center">
              <h4 class="card-title m-t-10">{{__('Info Kas PH HMJ TI Akakom') }}</h4>
              <p class=" color-black font-weight-normal"><mark class="bg-yellow">{{__('Batas Waktu Bayar Uang Kas :') }} 
                    {{__('Belum Ada Tanggal Batas Iuran') }}
              </mark></p>
            </div>
            <div class="card-body flex-fill">
              <h6 class="col-md-12">{{__('Iuran Kas PH') }} <a class="h6 float-right">{{__('Terakhir Diperbaharui') }}</a> </h6>
                  <p class="col-sm-12 color-black"><b>Rp.{{__('0') }},-</b> <a class="float-right"><b>{{__('Belum Ada Data') }}</b></a> </p>
                <h6 class="col-md-12">{{__('Denda Kas PH') }} <a class="h6 float-right">{{__('Terakhir Diperbaharui') }}</a> </h6>
                  <p class="col-sm-12 color-black"><b>Rp.{{__('0') }},-</b> <a class="float-right"><b>{{__('Belum Ada Data') }}</b></a> </p>
                <h6 class="col-md-12">{{__('Total Kas PH') }} <a class="h6 float-right">{{__('Terakhir Diperbaharui') }}</a> </h6>
                <p class="col-sm-12 color-black"><b>Rp.{{__('0') }},-</b> <a class="float-right"><b>{{__('Belum Ada Data') }}</b></a> </p>
            </div>
                <div class="text-center">
                  <a href="{{ route('admin-kas-ph.create') }}" class="btn btn-primary"><i class="fas fa-edit"></i>{{__(' Buat Iuran') }}</a>
                </div>
            @else 
              @foreach ($kasph as $ph)
              <div class="text-center">
                <h4 class="card-title m-t-10">{{__('Info Kas PH HMJ TI Akakom') }}</h4>
                <p class="color-black font-weight-normal"><mark class="bg-yellow">{{__('Batas Waktu Bayar Uang Kas :') }} 
                  @if (\Carbon\Carbon::now() > \Carbon\Carbon::parse($ph->tanggal_batas_iuran))
                      {{__('Batas Waktu Iuran Telah Melewati Batas') }}
                  @else   
                      {{ Carbon\Carbon::parse($ph->tanggal_batas_iuran)->isoFormat('D MMMM Y') }}
                  @endif
                </mark></p>
              </div>
              <div class="card-body flex-fill">
                <h6 class="col-md-12">{{__('Iuran Kas PH') }} <a class="h6 float-right">{{__('Terakhir Diperbaharui') }}</a> </h6>
                    <p class="col-sm-12 color-black"><b>Rp.{{ $ph->iuran_ph }},-</b> <a class="float-right"><b>{{ \Carbon\Carbon::parse($ph->updated_at)->isoFormat('D MMMM Y') }}</b></a> </p>
                  <h6 class="col-md-12">{{__('Denda Kas PH') }} <a class="h6 float-right">{{__('Terakhir Diperbaharui') }}</a> </h6>
                    <p class="col-sm-12 color-black"><b>Rp.{{ $ph->denda_ph }},-</b> <a class="float-right"><b>{{ \Carbon\Carbon::parse($ph->updated_at)->isoFormat('D MMMM Y') }}</b></a> </p>
                  <h6 class="col-md-12">{{__('Total Kas PH') }} <a class="h6 float-right">{{__('Terakhir Diperbaharui') }}</a> </h6>
                  <p class="col-sm-12 color-black"><b>Rp.{{ $ph->total_kas_ph }},-</b> <a class="float-right"><b>{{ \Carbon\Carbon::parse($ph->updated_at)->isoFormat('D MMMM Y') }}</b></a> </p>
              </div>
                  <div class="text-center">
                    <a href="{{ route('admin-kas-ph.edit', $ph->id ) }}" class="btn btn-primary"><i class="fas fa-edit"></i>{{__(' Update Iuran') }}</a>
                  </div>
                @endforeach
            @endif
              </div>
              </div>
            </div>
          <!-- Column -->
          <!-- Column -->
          <div class="col-lg-5 px-md-4 d-flex align-items-stretch">
            <div class="card flex-fill">
              <div class="card-body flex-fill">
                <div class="text-center pb-3">
                  <h4 class="card-title m-t-10 pb-4">{{__('Info Pengeluaran Kas PH') }}</h4>
                  </div>
                  @if ($lap == 0)
                  <div class="card-body flex-fill">
                    <h6 class="col-md-12">{{__('Jumlah Transaksi') }} <a class="h6 float-right">{{__('Terakhir Diperbaharui') }}</a> </h6>
                        <p class="col-sm-12 color-black"><b>Rp.{{__('0') }},-</b> <a class="float-right"><b>{{__('Belum Ada Data') }}</b></a> </p>
                      <h6 class="col-md-12">{{__('Total Pengeluaran') }} <a class="h6 float-right">{{__('Terakhir Diperbaharui') }}</a> </h6>
                        <p class="col-sm-12 color-black"><b>Rp.{{__('0') }},-</b> <a class="float-right"><b>{{__('Belum Ada Data') }}</b></a> </p>
                      <h6 class="col-md-12 color-white">{{__('Total Kas PH') }}</h6>
                      <p class="col-sm-12 color-white"><b>Rp.{{__('0') }},-</b></p>
                </div>
                <div class="text-center">
                  <a href="{{ route('admin-laporan-kas.create') }}" class="btn btn-warning">{{__('Buat Data Pengeluaran') }}</a>
                </div>
                  @else
                  @foreach ($decode_date as $tgl)
                  <div class="card-body flex-fill">
                    <h6 class="col-md-12">{{__('Jumlah Transaksi') }} <a class="h6 float-right">{{__('Terakhir Diperbaharui') }}</a> </h6>
                      <p class="col-sm-12 color-black"><b>{{ $lap }}{{__(' Transaksi')}}</b> <a class="float-right"><b>{{ \Carbon\Carbon::parse($tgl->created_at)->isoFormat('D MMMM Y') }}</b></a> </p>
                    <h6 class="col-md-12">{{__('Total Pengeluaran') }} <a class="h6 float-right">{{__('Terakhir Diperbaharui') }}</a> </h6>
                      <p class="col-sm-12 color-black"><b>Rp.{{ $total }},-</b> <a class="float-right"><b>{{ \Carbon\Carbon::parse($tgl->created_at)->isoFormat('D MMMM Y') }}</b></a> </p>
                    <h6 class="col-md-12 color-white">{{__('Total Kas PH') }}</h6>
                      <p class="col-sm-12 color-white"><b>Rp.{{__('0') }},-</b></p>
                    </div>
                    <div class="text-center">
                      <a href="{{ route('admin-laporan-kas.index') }}" class="btn btn-warning"><i class="fas fa-table"></i>{{__(' Lihat Data Laporan Kas PH') }}</a>
                    </div>
                  @endforeach
                  @endif
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
