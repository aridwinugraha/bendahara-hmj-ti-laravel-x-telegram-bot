@extends('layouts.app')

@section('content')
@if (Auth::user()->status_anggota == 'Pengurus Harian')
        @if (Auth::user()->username_telegram != null && Auth::user()->chat_id != null)
        @can('isAdmin')
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
                        @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                                @endif
                    </div>
                    <div class="col-md-3 ml-sm-auto d-flex align-items-stretch">
                        <div class="card shadow flex-fill">
                            <div class="card-body cr-1 flex-fill">
                            <h3 class="color-white">{{__('Anggota') }}</h3>
                                <div class="pisah"></div>
                                <div class="note-2 color-white">{{ $count_anggota }}</div>
                                <p class="mb-0 color-white">{{__('Member ') }}</p>
                            </div>
                            <div class="card-footer cd-1 flex-fill">
                                <a href="{{ route('admin-anggota.index') }}"><p class="mb-0 color-white text-center">{{__('More Info ') }}<i class="fas fa-arrow-circle-o-right "></i></p></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex align-items-stretch">
                        <div class="card shadow flex-fill">
                            <div class="card-body cr-2 flex-fill">
                                <h3 class="color-white">{{__('Reminder') }}</h3>
                                <div class="pisah"></div>
                                @if ($count_kas_ph == 0)
                                    <div class="note color-white">{{__('Notifikasi Belum Dibuat') }}</div>
                                    <p class="mb-0 color-white">{{__('Telah konfirmasi bayar : ') }}{{__('0') }}</p>
                                @else
                                    @foreach ($decode_batas as $b)
                                        <div class="note color-white">{{ \Carbon\Carbon::parse($b->tanggal_batas_iuran)->diffForHumans() }}</div>
                                    @endforeach
                                        @if ($reminder == 0 || $count_bayar_1 == 0 || $count_bayar_2 == 0)
                                            <p class="mb-0 color-white">{{__('Yang telah mengirim konfirmasi telah bayar iuran kas PH : ') }}{{__('0') }}</p>
                                        @elseif ($count_bayar_1 != 0 || $count_bayar_2 != 0)
                                            <p class="mb-0 color-white">{{__('Yang telah mengirim konfirmasi telah bayar iuran kas PH : ') }}{{ $count_bayar_total }}</p>
                                        @endif
                                @endif
                            </div>
                            <div class="card-footer cd-2 flex-fill">
                                <a href="{{ route('reminder.index')}}"><p class="mb-0 color-white text-center">{{__('More Info ') }}<i class="fas fa-arrow-circle-o-right "></i></p></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card shadow">
                            <div class="card-body cr-3">
                                <h3 class="color-white">{{__('Info Kas PH') }}</h3>
                                <div class="pisah"></div>
                            @if ($count_kas_ph == 0)
                                <div class="note-1 color-white">{{__('Tgl Batas Iuran Blm Dibuat') }}</div>
                                <p class="mb-0 color-white">{{__('Nominal Iuran PH : ' ) }}{{__('0') }}</p>
                            @else
                                @if (\Carbon\Carbon::now() > \Carbon\Carbon::parse($b->tanggal_batas_iuran))
                                    <div class="note-1 color-white">{{__('Batas Tgl Iuran Non Aktif') }}</div>
                                    <p class="mb-0 color-white">{{__('Nominal Iuran PH : ' ) }}{{ $b->iuran_ph }}</p>
                                    <p class="mb-0 color-white">{{__('Nominal Denda PH : ' ) }}{{ $b->denda_ph }}</p>
                                @else
                                    @foreach ($decode_batas as $b)
                                            <div class="note-1 color-white">{{ \Carbon\Carbon::parse($b->tanggal_batas_iuran)->isoFormat('D MMMM Y') }}</div>
                                            <p class="mb-0 color-white">{{__('Nominal Iuran PH : ' ) }}{{ $b->iuran_ph }}</p>
                                            <p class="mb-0 color-white">{{__('Nominal Denda PH : ' ) }}{{ $b->denda_ph }}</p>
                                    @endforeach
                                @endif
                            @endif
                            </div>
                            <div class="card-footer cd-3">
                                <a href="{{ route('admin-kas-ph.index') }}"><p class="mb-0 color-white text-center">{{__('More Info ') }}<i class="fas fa-arrow-circle-o-right "></i></p></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center register">
                    <div class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                        <div class="card shadow">
                            <div class="card-body">
                                <h2 class="font-weight-bolder text-center">{{__('Hi, ') }}{{ Auth::User()->name }} {{ Auth::User()->name_last }}</h2>
                            <div class="row justify-content-center">
                                <div class="col-md-6">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td>{{__('Nomor Pokok Keanggotaan') }}</td>
                                                <td>{{__(': ') }}{{ Auth::User()->npk }}</td>
                                            </tr>
                                
                                            <tr>                                 
                                                <td>{{__('Nama') }}</td>
                                                <td>{{__(': ') }}{{ Auth::User()->name }}</td>
                                            </tr>
                                
                                            <tr>
                                                <td>{{__('Email') }}</td>
                                                <td>{{__(': ') }}{{ Auth::User()->email }}</td>
                                            </tr>
                                
                                            <tr>
                                                <td>{{__('Username') }}</td>
                                                <td>{{__(': ') }}{{ Auth::User()->username }}</td>
                                            </tr>
                                            
                                            <tr>
                                                <td>{{__('Jenis Kelamin') }}</td>
                                                <td>{{__(': ') }}{{ Auth::User()->jk }}</td>
                                            </tr>                                         
                                        </tbody>
                                    </table>
                            </div>
                                </div>
                            <div class="col-md-6">
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>{{__('Agama') }}</td>
                                            <td>{{__(': ') }}{{ Auth::User()->agama }}</td>
                                        </tr>

                                        <tr>
                                            <td>{{__('Status Anggota') }}</td>
                                            <td>{{__(': ') }}{{ Auth::User()->status_anggota }}</td>
                                        </tr>

                                        <tr>
                                            <td>{{__('Total Kas Anda') }}</td>
                                            <td>{{__(': ') }}{{ Auth::User()->iuran_kas }}</td>
                                        </tr>

                                        <tr>
                                            <td>{{__('Denda') }}</td>
                                            <td>{{__(': ') }}{{ Auth::User()->denda }}</td>
                                        </tr>

                                        <tr>
                                            <td>{{__('Nomor Handphone') }}</td>
                                            <td>{{__(': ') }}{{ Auth::User()->no_hp }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                        </div>
                            </div>
                    </div>
                        <div class="text-center">    
                        <a href="{{ route('admin-anggota.edit', Auth::User()->id) }}" class="btn btn-warning"><i class="fas fa-edit"></i>{{__(' Edit') }}</a>
                        </div>
                </div>
            </div>
        </div>
        </div>
        </div>
        @endcan
        @can('isUser')
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
                </div>
                    <div class="col-md-3 ml-sm-auto d-flex align-items-stretch">
                    <div class="card shadow flex-fill">
                        <div class="card-body cr-1 flex-fill">
                        <h3 class="color-white">{{__('Anggota') }}</h3>
                            <div class="pisah"></div>
                            <div class="note-2 color-white">{{ $count_anggota }}</div>
                            <p class="mb-0 color-white">{{__('Member') }}</p>
                        </div>
                        <div class="card-footer cd-1 flex-fill">
                            <a href="{{ route('anggota.index') }}"><p class="mb-0 color-white text-center">{{__('More Info ') }}<i class="fas fa-arrow-circle-o-right "></i></p></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 d-flex align-items-stretch">
                    <div class="card shadow flex-fill">
                        <div class="card-body cr-2 flex-fill">
                            <h3 class="color-white">{{__('Reminder') }}</h3>
                            <div class="pisah"></div>
                            @if ($count_kas_ph == 0)
                            <div class="note color-white">{{__('Notifikasi Belum Dibuat') }}</div>
                            <p class="mb-0 color-white">{{__('Telah konfirmasi bayar : ') }}{{__('0') }}</p>
                            @else
                                @foreach ($decode_batas as $b)
                                    <div class="note color-white">{{ \Carbon\Carbon::parse($b->tanggal_batas_iuran)->diffForHumans() }}</div>
                                @endforeach
                                    @if ($reminder == 0 || $count_bayar_1 == 0 || $count_bayar_2 == 0)
                                        <p class="mb-0 color-white">{{__('Yang telah mengirim konfirmasi telah bayar iuran kas PH : ') }}{{__('0') }}</p>
                                    @elseif ($count_bayar_1 != 0 || $count_bayar_2 != 0)
                                        <p class="mb-0 color-white">{{__('Yang telah mengirim konfirmasi telah bayar iuran kas PH : ') }}{{ $count_bayar_total }}</p>
                                    @endif
                            @endif
                        </div>
                        <div class="card-footer cd-2 flex-fill p-3 pt-4">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow">
                        <div class="card-body cr-3">
                            <h3 class="color-white">{{__('Info Kas PH') }}</h3>
                            <div class="pisah"></div>
                            @if ($count_kas_ph == 0)
                                <div class="note-1 color-white">{{__('Tgl Batas Iuran Blm Dibuat') }}</div>
                                <p class="mb-0 color-white">{{__('Nominal Iuran PH : ' ) }}{{__('0') }}</p>
                            @else
                                @if (\Carbon\Carbon::now() > \Carbon\Carbon::parse($b->tanggal_batas_iuran))
                                    <div class="note-1 color-white">{{__('Batas Tgl Iuran Non Aktif') }}</div>
                                    <p class="mb-0 color-white">{{__('Nominal Iuran PH : ' ) }}{{ $b->iuran_ph }}</p>
                                    <p class="mb-0 color-white">{{__('Nominal Denda PH : ' ) }}{{ $b->denda_ph }}</p>
                                @else
                                    @foreach ($decode_batas as $b)
                                            <div class="note-1 color-white">{{ \Carbon\Carbon::parse($b->tanggal_batas_iuran)->isoFormat('D MMMM Y') }}</div>
                                            <p class="mb-0 color-white">{{__('Nominal Iuran PH : ' ) }}{{ $b->iuran_ph }}</p>
                                            <p class="mb-0 color-white">{{__('Nominal Denda PH : ' ) }}{{ $b->denda_ph }}</p>
                                    @endforeach
                                @endif
                            @endif
                        </div>
                        <div class="card-footer cd-3">
                            <a href="{{ route('kas-ph.index') }}"><p class="mb-0 color-white text-center">{{__('More Info ') }}<i class="fas fa-arrow-circle-o-right "></i></p></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center register">
                <div class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                    <div class="card shadow">
                    @if (Auth::user()->status_anggota=='Pengurus Harian')
                        <a href="{{ route('upgrade.admin', Auth::user()->id) }}" onclick="return confirm('Apakah Anda Yakin Ingin mengirim permintaan menjadi ADMIN WEB BENDAHARA HMJ TI ?')" class="btn btn-success float-right"><i class="fas fa-user-tag"></i>{{__(' UPGRADE to ADMIN') }}</a> 
                    @endif
                        <div class="card-body">
                                <h2 class="font-weight-bolder text-center">{{__('Hi, ') }}{{ Auth::User()->name }} {{ Auth::User()->name_last }}</h2>
                            <div class="row justify-content-center">
                                <div class="col-md-6">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td>{{__('Nomor Pokok Keanggotaan') }}</td>
                                                <td>{{__(': ') }}{{ Auth::User()->npk }}</td>
                                            </tr>
                                
                                            <tr>                                 
                                                <td>{{__('Nama') }}</td>
                                                <td>{{__(': ') }}{{ Auth::User()->name }}</td>
                                            </tr>
                                
                                            <tr>
                                                <td>{{__('Email') }}</td>
                                                <td>{{__(': ') }}{{ Auth::User()->email }}</td>
                                            </tr>
                                
                                            <tr>
                                                <td>{{__('Username') }}</td>
                                                <td>{{__(': ') }}{{ Auth::User()->username }}</td>
                                            </tr>
                                            
                                            <tr>
                                                <td>{{__('Jenis Kelamin') }}</td>
                                                <td>{{__(': ') }}{{ Auth::User()->jk }}</td>
                                            </tr>                                         
                                        </tbody>
                                    </table>
                            </div>
                                </div>
                            <div class="col-md-6">
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>{{__('Agama') }}</td>
                                            <td>{{__(': ') }}{{ Auth::User()->agama }}</td>
                                        </tr>

                                        <tr>
                                            <td>{{__('Status Anggota') }}</td>
                                            <td>{{__(': ') }}{{ Auth::User()->status_anggota }}</td>
                                        </tr>

                                        <tr>
                                            <td>{{__('Total Kas Anda') }}</td>
                                            <td>{{__(': ') }}{{ Auth::User()->iuran_kas }}</td>
                                        </tr>

                                        <tr>
                                            <td>{{__('Denda') }}</td>
                                            <td>{{__(': ') }}{{ Auth::User()->denda }}</td>
                                        </tr>

                                        <tr>
                                            <td>{{__('Nomor Hp') }}</td>
                                            <td>{{__(': ') }}{{ Auth::User()->no_hp }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                        </div>
                            </div>
                    </div>
                    <div class="text-center">
                        <a href="{{ route('anggota.edit', Auth::User()->id) }}" class="btn btn-warning"><i class="fas fa-edit"></i>{{__(' Edit') }}</a>
                    </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    @endcan
        @else
            @include('modal')
        @endif
    @else
    @can('isUser')
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
            </div>
                <div class="col-md-3 ml-sm-auto d-flex align-items-stretch">
                <div class="card shadow flex-fill">
                    <div class="card-body cr-1 flex-fill">
                    <h3 class="color-white">{{__('Anggota') }}</h3>
                        <div class="pisah"></div>
                        <div class="note-2 color-white">{{ $count_anggota }}</div>
                        <p class="mb-0 color-white">{{__('Member') }}</p>
                    </div>
                    <div class="card-footer cd-1 flex-fill">
                        <a href="{{ route('anggota.index') }}"><p class="mb-0 color-white text-center">{{__('More Info ') }}<i class="fas fa-arrow-circle-o-right "></i></p></a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 d-flex align-items-stretch">
                <div class="card shadow flex-fill">
                    <div class="card-body cr-2 flex-fill">
                        <h3 class="color-white">{{__('Reminder') }}</h3>
                        <div class="pisah"></div>
                        @if ($count_kas_ph == 0)
                        <div class="note color-white">{{__('Notifikasi Belum Dibuat') }}</div>
                        <p class="mb-0 color-white">{{__('Telah konfirmasi bayar : ') }}{{__('0') }}</p>
                        @else
                            @foreach ($decode_batas as $b)
                                <div class="note color-white">{{ \Carbon\Carbon::parse($b->tanggal_batas_iuran)->diffForHumans() }}</div>
                            @endforeach
                                @if ($reminder == 0 || $count_bayar_1 == 0 || $count_bayar_2 == 0)
                                    <p class="mb-0 color-white">{{__('Yang telah mengirim konfirmasi telah bayar iuran kas PH : ') }}{{__('0') }}</p>
                                @elseif ($count_bayar_1 != 0 || $count_bayar_2 != 0)
                                    <p class="mb-0 color-white">{{__('Yang telah mengirim konfirmasi telah bayar iuran kas PH : ') }}{{ $count_bayar_total }}</p>
                                @endif
                        @endif
                    </div>
                    <div class="card-footer cd-2 flex-fill p-3 pt-4">
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow">
                    <div class="card-body cr-3">
                        <h3 class="color-white">{{__('Info Kas PH') }}</h3>
                        <div class="pisah"></div>
                        @if ($count_kas_ph == 0)
                            <div class="note-1 color-white">{{__('Tgl Batas Iuran Blm Dibuat') }}</div>
                            <p class="mb-0 color-white">{{__('Nominal Iuran PH : ' ) }}{{__('0') }}</p>
                        @else
                            @if (\Carbon\Carbon::now() > \Carbon\Carbon::parse($b->tanggal_batas_iuran))
                                <div class="note-1 color-white">{{__('Batas Tgl Iuran Non Aktif') }}</div>
                                <p class="mb-0 color-white">{{__('Nominal Iuran PH : ' ) }}{{ $b->iuran_ph }}</p>
                                <p class="mb-0 color-white">{{__('Nominal Denda PH : ' ) }}{{ $b->denda_ph }}</p>
                            @else
                                @foreach ($decode_batas as $b)
                                        <div class="note-1 color-white">{{ \Carbon\Carbon::parse($b->tanggal_batas_iuran)->isoFormat('D MMMM Y') }}</div>
                                        <p class="mb-0 color-white">{{__('Nominal Iuran PH : ' ) }}{{ $b->iuran_ph }}</p>
                                        <p class="mb-0 color-white">{{__('Nominal Denda PH : ' ) }}{{ $b->denda_ph }}</p>
                                @endforeach
                            @endif
                        @endif
                    </div>
                    <div class="card-footer cd-3">
                        <a href="{{ route('kas-ph.index') }}"><p class="mb-0 color-white text-center">{{__('More Info ') }}<i class="fas fa-arrow-circle-o-right "></i></p></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center register">
            <div class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                <div class="card shadow">
                @if (Auth::user()->status_anggota=='Pengurus Harian')
                    <a href="{{ route('upgrade.admin', Auth::user()->id) }}" onclick="return confirm('Apakah Anda Yakin Ingin mengirim permintaan menjadi ADMIN WEB BENDAHARA HMJ TI ?')" class="btn btn-success float-right"><i class="fas fa-user-tag"></i>{{__(' UPGRADE to ADMIN') }}</a> 
                @endif
                    <div class="card-body">
                            <h2 class="font-weight-bolder text-center">{{__('Hi, ') }}{{ Auth::User()->name }} {{ Auth::User()->name_last }}</h2>
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>{{__('Nomor Pokok Keanggotaan') }}</td>
                                            <td>{{__(': ') }}{{ Auth::User()->npk }}</td>
                                        </tr>
                            
                                        <tr>                                 
                                            <td>{{__('Nama') }}</td>
                                            <td>{{__(': ') }}{{ Auth::User()->name }}</td>
                                        </tr>
                            
                                        <tr>
                                            <td>{{__('Email') }}</td>
                                            <td>{{__(': ') }}{{ Auth::User()->email }}</td>
                                        </tr>
                            
                                        <tr>
                                            <td>{{__('Username') }}</td>
                                            <td>{{__(': ') }}{{ Auth::User()->username }}</td>
                                        </tr>
                                        
                                        <tr>
                                            <td>{{__('Jenis Kelamin') }}</td>
                                            <td>{{__(': ') }}{{ Auth::User()->jk }}</td>
                                        </tr>                                         
                                    </tbody>
                                </table>
                        </div>
                            </div>
                        <div class="col-md-6">
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td>{{__('Agama') }}</td>
                                        <td>{{__(': ') }}{{ Auth::User()->agama }}</td>
                                    </tr>
    
                                    <tr>
                                        <td>{{__('Status Anggota') }}</td>
                                        <td>{{__(': ') }}{{ Auth::User()->status_anggota }}</td>
                                    </tr>
    
                                    <tr>
                                        <td>{{__('Total Kas Anda') }}</td>
                                        <td>{{__(': ') }}{{ Auth::User()->iuran_kas }}</td>
                                    </tr>
    
                                    <tr>
                                        <td>{{__('Denda') }}</td>
                                        <td>{{__(': ') }}{{ Auth::User()->denda }}</td>
                                    </tr>
    
                                    <tr>
                                        <td>{{__('Nomor Hp') }}</td>
                                        <td>{{__(': ') }}{{ Auth::User()->no_hp }}</td>
                                    </tr>
                                </tbody>
                            </table>
                    </div>
                        </div>
                </div>
                <div class="text-center">
                    <a href="{{ route('anggota.edit', Auth::User()->id) }}" class="btn btn-warning"><i class="fas fa-edit"></i>{{__(' Edit') }}</a>
                </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    @endcan
    @endif
    
    @forelse ($anggota as $t)    
    @empty
        @include('modal') 
    @endforelse

@endsection