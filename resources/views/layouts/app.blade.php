<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="icon" href="/images/logo-hmj.png"/>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('fontawesome/css/all.css') }}" rel="stylesheet">
    <link href="{{ asset('fontawesome/css/v4-shims.css') }}" rel="stylesheet">
</head>
    <body>
        <div id="app">
            @can('isAdmin')
            <nav class="navbar navbar-expand-md navbar-dark sticky-top bg-red flex-md-nowrap shadow-sm">
                <div class="navbar-header">
                        <a class="navbar-brand" href="{{ route('home') }}"><img width="35" height="30" alt="Deskripsi-Gambar" src="/images/logo-hmj.png"/>{{__(' ')}}{{ config('app.name') }}</a>
                        <button class="navbar-toggler float-left collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="nav-item-2 dropdown-mobile float-right">
                            <a id="navbarDropdown1" role="button" class="nav-link-mobile dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre><i data-count-mobile="{{ \DB::table('notifikasi')->count()-\DB::table('notifikasi')->where('status_notifikasi', 'setuju')->count() }}" class="fa fa-bell-o notification-icon-mobile bell-o" ></i></a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown1">
                                <div class="dropdown-toolbar dropdown-position-bottomright">
                            <h3 class="dropdown-toolbar-title">{{__('Notifications') }} (<span class="notif-count-mobile">{{ \DB::table('notifikasi')->count()-\DB::table('notifikasi')->where('status_notifikasi', 'setuju')->count() }}</span>)</h3>
                                </div> 
                                    <div>
                                        <li class="notification active">
                                            <div class="media">
                                                <div class="media-body">
                                                    @php
                                                        $notifikasi = \DB::table('notifikasi')->get();
                                                        $decode_notif = json_decode($notifikasi);

                                                        $tgl = \DB::table('kas_ph')->select('tanggal_batas_iuran')->where('id', '=', 1)->get();
                                                        $decode_tgl = json_decode($tgl);

                                                        foreach ($decode_tgl as $gl) {
                                                            $batas_tgl = $gl->tanggal_batas_iuran;
                                                        }
                                                    @endphp
                                                    @foreach ($decode_notif as $no)
                                                        @if ($no->status_notifikasi=='tunggu konfirmasi')
                                                            <strong class="notification-title">{{ $no->first_nama }} {{ $no->last_nama }}{{__(' Telah mengirim konfirmasi telah melakukan pembayaran iuran kas PH') }}</strong>
                                                            <p class="notification-desc">{{__("Untuk Info Lebih Lanjut Klik 'More Info'") }}</p>
                                                            <div class="notification-meta">
                                                            <small class="timestamp">{{ \Carbon\Carbon::parse($no->created_at)->diffForHumans() }}</small>
                                                            <a id="moreInfo" href="{{ route('notifikasi.bayar') }}">{{__('More Info') }}</a>
                                                            </div>
                                                        @elseif ($no->status_notifikasi=='tunggu konfirmasi lunas')
                                                            <strong class="notification-title">{{ $no->first_nama }} {{ $no->last_nama }}{{__(' Telah mengirim konfirmasi telah melakukan pelunasan iuran kas PH dan denda PH') }}</strong>
                                                            <p class="notification-desc">{{__("Untuk Info Lebih Lanjut Klik 'More Info'") }}</p>
                                                            <div class="notification-meta">
                                                            <small class="timestamp">{{ \Carbon\Carbon::parse($no->created_at)->diffForHumans() }}</small>
                                                            <a id="moreInfo" href="{{ route('notifikasi.lunas') }}">{{__('More Info') }}</a>
                                                            </div>
                                                        @elseif ($no->status_notifikasi=='tunggu konfirmasi upgrade ke admin')
                                                            <strong class="notification-title">{{ $no->first_nama }} {{ $no->last_nama }}{{__(' Telah mengirim permintaan ingin menjadi ADMIN') }}</strong>
                                                            <p class="notification-desc">{{__("Untuk Info Lebih Lanjut Klik 'More Info'") }}</p>
                                                            <div class="notification-meta">
                                                            <small class="timestamp">{{ \Carbon\Carbon::parse($no->created_at)->diffForHumans() }}</small>
                                                            <a id="moreInfo" href="{{ route('notifikasi.admin') }}">{{__('More Info') }}</a>
                                                            </div>
                                                        @elseif ($no->status_notifikasi=='tidak setuju')
                                                            @if (\Carbon\Carbon::now() > \Carbon\Carbon::parse($batas_tgl))
                                                                <strong class="notification-title">{{ $no->first_nama }} {{ $no->last_nama }}{{__(' Telah terkonfirmasi tidak membayar iuran kas PH periode bulan lalu') }}</strong>
                                                                <p class="notification-desc">{{__("Untuk Info Lebih Lanjut Klik 'More Info'") }}</p>
                                                                <div class="notification-meta">
                                                                <small class="timestamp">{{ \Carbon\Carbon::parse($no->created_at)->diffForHumans() }}</small>
                                                                <a id="moreInfo" href="{{ route('notifikasi.denda') }}">{{__('More Info') }}</a>
                                                                </div>
                                                            @else
                                                                <strong class="notification-title">{{ $no->first_nama }} {{ $no->last_nama }}{{__(' Telah terkonfirmasi belum membayar iuran kas PH') }}</strong>
                                                                <p class="notification-desc">{{__("Untuk Info Lebih Lanjut Klik 'More Info'") }}</p>
                                                                <div class="notification-meta">
                                                                <small class="timestamp">{{ \Carbon\Carbon::parse($no->created_at)->diffForHumans() }}</small>
                                                                <a id="moreInfo" href="{{ route('notifikasi.denda') }}">{{__('More Info') }}</a>
                                                                </div>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </li>
                                    </div>
                                <div class="dropdown-footer text-center">
                                <a href="{{ route('notifikasi.index') }}">{{__('View All') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="collapse navbar-collapse" id="sidebarMenu">
                    <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <a class="nav-link color-white">{{ Auth::User()->level }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link color-white">{{ Auth::User()->name }} {{ Auth::User()->name_last }}</a>
                            </li>
                            <li class="nav-item-1 dropdown">
                                <a id="navbarDropdown" role="button" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre><i data-count="{{ \DB::table('notifikasi')->count()-\DB::table('notifikasi')->where('status_notifikasi', 'setuju')->count() }}" class="fa fa-bell-o notification-icon bell-o"></i></a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <div class="dropdown-toolbar dropdown-position-bottomright">
                                <h3 class="dropdown-toolbar-title">{{__('Notifications') }} (<span class="notif-count">{{ \DB::table('notifikasi')->count()-\DB::table('notifikasi')->where('status_notifikasi', 'setuju')->count() }}</span>)</h3>
                                    </div> 
                                        <ul class="rata">
                                            <li class="notification active">
                                                <div class="media">
                                                    <div class="media-body">
                                                    @php
                                                    $notifikasi = \DB::table('notifikasi')->get();
                                                    $decode_notif = json_decode($notifikasi);

                                                    $tgl = \DB::table('kas_ph')->select('tanggal_batas_iuran')->where('id', '=', 1)->get();
                                                    $decode_tgl = json_decode($tgl);

                                                    foreach ($decode_tgl as $gl) {
                                                        $batas_tgl = $gl->tanggal_batas_iuran;
                                                    }
                                                    @endphp
                                                    @foreach ($decode_notif as $no)
                                                        @if ($no->status_notifikasi=='tunggu konfirmasi')
                                                            <strong class="notification-title">{{ $no->first_nama }} {{ $no->last_nama }}{{__(' Telah mengirim konfirmasi telah melakukan pembayaran iuran kas PH') }}</strong>
                                                            <p class="notification-desc">{{__("Untuk Info Lebih Lanjut Klik 'More Info'") }}</p>
                                                            <div class="notification-meta">
                                                            <small class="timestamp">{{ \Carbon\Carbon::parse($no->created_at)->diffForHumans() }}</small>
                                                            <a id="moreInfo" href="{{ route('notifikasi.bayar') }}">{{__('More Info') }}</a>
                                                            </div>
                                                        @elseif ($no->status_notifikasi=='tunggu konfirmasi lunas')
                                                            <strong class="notification-title">{{ $no->first_nama }} {{ $no->last_nama }}{{__(' Telah mengirim konfirmasi telah melakukan pelunasan iuran kas PH dan denda PH') }}</strong>
                                                            <p class="notification-desc">{{__("Untuk Info Lebih Lanjut Klik 'More Info'") }}</p>
                                                            <div class="notification-meta">
                                                            <small class="timestamp">{{ \Carbon\Carbon::parse($no->created_at)->diffForHumans() }}</small>
                                                            <a id="moreInfo" href="{{ route('notifikasi.lunas') }}">{{__('More Info') }}</a>
                                                            </div>
                                                        @elseif ($no->status_notifikasi=='tunggu konfirmasi upgrade ke admin')
                                                            <strong class="notification-title">{{ $no->first_nama }} {{ $no->last_nama }}{{__(' Telah mengirim permintaan ingin menjadi ADMIN') }}</strong>
                                                            <p class="notification-desc">{{__("Untuk Info Lebih Lanjut Klik 'More Info'") }}</p>
                                                            <div class="notification-meta">
                                                            <small class="timestamp">{{ \Carbon\Carbon::parse($no->created_at)->diffForHumans() }}</small>
                                                            <a id="moreInfo" href="{{ route('notifikasi.admin') }}">{{__('More Info') }}</a>
                                                            </div>
                                                        @elseif ($no->status_notifikasi=='tidak setuju')
                                                            @if (\Carbon\Carbon::now() > \Carbon\Carbon::parse($batas_tgl))
                                                                <strong class="notification-title">{{ $no->first_nama }} {{ $no->last_nama }}{{__(' Telah terkonfirmasi tidak membayar iuran kas PH periode bulan lalu') }}</strong>
                                                                <p class="notification-desc">{{__("Untuk Info Lebih Lanjut Klik 'More Info'") }}</p>
                                                                <div class="notification-meta">
                                                                <small class="timestamp">{{ \Carbon\Carbon::parse($no->created_at)->diffForHumans() }}</small>
                                                                <a id="moreInfo" href="{{ route('notifikasi.denda') }}">{{__('More Info') }}</a>
                                                                </div>
                                                            @else
                                                                <strong class="notification-title">{{ $no->first_nama }} {{ $no->last_nama }}{{__(' Telah terkonfirmasi belum membayar iuran kas PH') }}</strong>
                                                                <p class="notification-desc">{{__("Untuk Info Lebih Lanjut Klik 'More Info'") }}</p>
                                                                <div class="notification-meta">
                                                                <small class="timestamp">{{ \Carbon\Carbon::parse($no->created_at)->diffForHumans() }}</small>
                                                                <a id="moreInfo" href="{{ route('notifikasi.denda') }}">{{__('More Info') }}</a>
                                                                </div>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    <div class="dropdown-footer text-center">
                                    <a href="{{ route('notifikasi.index') }}">{{__('View All') }}</a>
                                    </div>
                                </div>
                            </li>
                    </ul>
                    </div>
                </nav>
                @elsecan('isUser')
                <nav class="navbar navbar-expand-md navbar-dark sticky-top bg-sidebar flex-md-nowrap shadow-sm">
                <a class="navbar-brand" href="{{ route('home') }}"><img width="35" height="30" alt="Deskripsi-Gambar" src="/images/logo-hmj.png"/>{{__('       ')}}{{ config('app.name', 'AppBendaharaHMJ-TI') }}</a>
                <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="sidebarMenu">
                    <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link color-white">{{ Auth::User()->name }} {{ Auth::User()->name_last }}</a>
                </li>
            </ul>
        </div>
    </nav>
                @endcan
        <div class="container-fluid">
            @can('isAdmin')
                <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-sidebar sidebar collapse">
                    <div class="sidebar-sticky pt-3">
                      <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('home*') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="fas fa-home"></i>
                            {{__('Dashboard') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin-anggota*') ? 'active' : '' }}" href="{{ route('admin-anggota.index') }}">
                            <i class="fas fa-users"></i>
                            {{__('Data Anggota') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin-kas-hmj*') ? 'active' : '' }}" href="{{ route('admin-kas-hmj.index') }}">
                            <i class="fas fa-money-check-alt"></i>
                            {{__('Kas HMJ TI') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin-kas-ph*') ? 'active' : '' }}{{ Request::is('admin-laporan-kas*') ? 'active' : '' }}" href="{{ route('admin-kas-ph.index') }}">
                            <i class="far fa-money-bill-alt"></i>
                            {{__('Kas PH') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('reminder*') ? 'active' : '' }}" href="{{ route('reminder.index') }}">
                            <i class="fas fa-cogs "></i>
                            {{__('Reminder') }}
                            </a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link {{ Request::is('about') ? 'active' : '' }}" href="{{ url('about') }}">
                            <i class="fas fa-info-circle"></i>
                            {{__('About') }}
                            </a>
                        </li>
                        <li class="nav-item">
                        <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i>
                                        {{__('Keluar') }}</a>
    
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        </li>
                    </ul>
                </div>
            </nav>
        @elsecan('isUser')
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-sidebar sidebar-user collapse">
            <div class="sidebar-sticky pt-3">
              <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('home*') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="fas fa-home"></i>
                            {{__('Dashboard') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('anggota*') ? 'active' : '' }}" href="{{ route('anggota.index') }}">
                            <i class="fas fa-users"></i>
                            {{__('Data Anggota') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('kas-hmj*') ? 'active' : '' }}" href="{{ route('kas-hmj.index') }}">
                            <i class="fas fa-money-check-alt"></i>
                            {{__('Kas HMJ TI') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('kas-ph*') ? 'active' : '' }}{{ Request::is('laporan-kas*') ? 'active' : '' }}" href="{{ route('kas-ph.index') }}">
                            <i class="far fa-money-bill-alt"></i>
                            {{__('Kas PH') }}
                            </a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link {{ request()->is('about') ? 'active' : '' }}" href="{{ url('about') }}">
                            <i class="fas fa-info-circle"></i>
                            {{__('About') }}
                            </a>
                        </li>
                        <li class="nav-item">
                        <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i>
                                        {{__('Keluar') }}</a>
    
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        </li>
                    </ul>
                </div>
            </nav>
        @endcan
    </div>
            <main role="main" class="py-4">
                @yield('content')
            </main>
        </div>
        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}"></script>
        <!-- Popper.JS -->
        <script src="{{ asset('js/popper.js') }}" ></script>
        <script>$('#myModal').modal({backdrop: 'static', keyboard: false}, 'show');</script>

        <script src="{{ asset('js/jquery-3.1.1.min.js') }}" ></script>

        <script type="text/javascript">
            $('#tujuan').on('change', function(e){
                        var id = e.target.value;

                        if (id=='') {
                            document.getElementById('first_nama_tujuan').value = '';
                            document.getElementById('last_nama_tujuan').value = '';
                            document.getElementById('username_telegram').value = '';
                            document.getElementById('chat_id').value = '';
                            document.getElementById('no_hp_tujuan').value = '';
                            document.getElementById('denda').value = '';
                            document.getElementById('total').style.display = 'block';
                            document.getElementById('total_price').style.display = 'block';
                            document.getElementById('pesan_petunjuk').style.display = 'block';
                            document.getElementById('jarak').style.display = 'block';
                            document.getElementById('iuran_ph').value = '';
                            document.getElementById('iuran_ph').disabled = false;
                            document.getElementById('pesan_pengingat').disabled = false;
                            document.getElementById('pesan_pengingat').value = '';   
                        }

                        if (id=='all') {
                            var op=" ";
                            $.get('{{ route('find.iuran') }}', function(data){
                                console.log(data);
                                $('#iuran_ph').empty();
                                $.each(data, function(index, element){
                                    for(var i=0;i<data.length;i++){
                                        $('#iuran_ph').val(element.iuran_ph);
                                }
                                });
                            })

                            document.getElementById('first_nama_tujuan').value = 'Semua Anggota Dipilih';
                            document.getElementById('last_nama_tujuan').value = 'Semua Anggota Dipilih';
                            document.getElementById('username_telegram').value = 'Semua Anggota Dipilih';
                            document.getElementById('chat_id').value = 'Semua Anggota Dipilih';
                            document.getElementById('no_hp_tujuan').value = 'Semua Anggota Dipilih';
                            document.getElementById('denda').value = 'Semua Anggota Dipilih';
                            document.getElementById('total').style.display = 'none';
                            document.getElementById('total_price').style.display = 'none';
                            document.getElementById('pesan_petunjuk').style.display = 'none';
                            document.getElementById('jarak').style.display = 'none';
                            document.getElementById('iuran_ph').disabled = true;
                            document.getElementById('pesan_pengingat').disabled = true;
                            document.getElementById('pesan_pengingat').value = "Karena Anda Memilih Pilihan 'Pilih Semua'\n"
                                                                                +"Maka Input Textarea di-disabled dan pesan pengingat akan disimpan dalam bentuk pesan default\n"
                                                                                +"Terima Kasih";
                            
                        } else {

                            document.getElementById('total').style.display = 'block';
                            document.getElementById('total_price').style.display = 'block';
                            document.getElementById('pesan_petunjuk').style.display = 'block';
                            document.getElementById('jarak').style.display = 'block';
                            document.getElementById('iuran_ph').value = '';
                            document.getElementById('iuran_ph').disabled = false;
                            document.getElementById('pesan_pengingat').disabled = false;
                            document.getElementById('pesan_pengingat').value = '';

                        var op=" ";
                        $.get('{{ URL::to('findNomorPenerima') }}/'+id, function(data){
                            console.log(id);
                            console.log(data);
                            $('#first_nama_tujuan').empty();
                            $('#last_nama_tujuan').empty();
                            $('#username_telegram').empty();
                            $('#chat_id').empty();
                            $('#no_hp_tujuan').empty();
                            $('#denda').empty();
                            $.each(data, function(index, element){
                                for(var i=0;i<data.length;i++){
                                    $('#first_nama_tujuan').val(element.name);
                                    $('#last_nama_tujuan').val(element.name_last);
                                    $('#username_telegram').val(element.username_telegram);
                                    $('#chat_id').val(element.chat_id);
                                    $('#no_hp_tujuan').val(element.no_hp);
                                    $('#denda').val(element.denda);
                            }
                            });
                        })
                    }
                    });


            function sumIt() {
            var total = 0, val;
            $('.inst_amount').each(function() {
                val = $(this).val();
                val = isNaN(val) || $.trim(val) === "" ? 0 : parseFloat(val);
                total += val;
            });
            $('#total_price').html(Math.round(total));
            $('.total_amount').val(Math.round(total));
            }
            
            $(function() {
            $(document).on('input', '.inst_amount', sumIt);
            sumIt() // run when loading
            });


            $('#rate, #box').keyup(function(){
                var rate = parseFloat($('#rate').val()) || 0;
                var box = parseFloat($('#box').val()) || 0;

                $('#amount').val(rate * box);    
            })


    $(document).ready(function(){      
      var url = "{{ route('admin-laporan-kas.store') }}";
      var i=1;  

      $('#add').click(function(){  
        i++;  
        $('#dynamic_field').append('<tr id="row'+i+'" class="dynamic-added"><td width="5%"><input type="text" name="no[]" class="form-control no_list" value="'+i+'" readonly></td>'+
                                    '<td width="15%"><input type="text" name="nama_barang[]" placeholder="Nama Barang" class="form-control nama_barang_list"/></td>'+
                                    '<td width="40%"><input type="text" name="keterangan[]" placeholder="Keterangan" class="form-control keterangan_list"/></td>'+
                                    '<td width="10%"><input type="text" name="jumlah_barang[]" placeholder="Jumlah" class="form-control jumlah_barang_list val1"/></td>'+
                                    '<td width="10%">'+
                                            '<select name="satuan_barang[]" class="form-control satuan_barang_list">'+
                                                '<option value=""></option>'+
                                                '<option value="kg" {{ old('satuan_barang[]') == 'kg' ? 'selected' : '' }}>kg</option>'+
                                                '<option value="g" {{ old('satuan_barang[]') == 'g' ? 'selected' : '' }}>g</option>'+
                                                '<option value="km" {{ old('satuan_barang[]') == 'km' ? 'selected' : '' }}>km</option>'+
                                                '<option value="m" {{ old('satuan_barang[]') == 'm' ? 'selected' : '' }}>m</option>'+
                                                '<option value="buah" {{ old('satuan_barang[]') == 'buah' ? 'selected' : '' }}>Buah</option>'+
                                                '<option value="biji" {{ old('satuan_barang[]') == 'biji' ? 'selected' : '' }}>Biji</option>'+
                                                '<option value="liter" {{ old('satuan_barang[]') == 'liter' ? 'selected' : '' }}>Liter</option>'+
                                            '</select>'+    
                                    '</td>'+
                                    '<td width="10%"><input type="text" name="harga_satuan_barang[]" placeholder="Harga" class="form-control harga_satuan_barang_list val2"/></td>'+
                                    '<td width="10%"><input type="text" name="jumlah_harga_barang[]" placeholder="Total '+i+'" class="form-control jumlah_harga_barang_list multTotal"/></td>'+
                                    '<td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');  
      });  


      $(document).on('click', '.btn_remove', function(){
           i--;  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });  


      $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });


      $('#submit').click(function(){            
           $.ajax({  
                url:url,  
                method:"POST",  
                data:$('#add_name').serialize(),
                type:'json',
                success:function(data)  
                {
                    if(data.error){
                        error_message_showing(data.error);
                    }else{
                        i=1;
                        $('.dynamic-added').remove();
                        $('#add_name')[0].reset();
                        $(".print-success-msg").find("p").html('');
                        $(".print-success-msg").css('display','block');
                        $(".print-error-msg").css('display','none');
                        $("#result").append('Data Berhasil Ditambahkan');
                  }
              }  
        });  
    });  

    function error_message_showing(msg) {
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display','block');
        $(".print-success-msg").css('display','none');
        $.each( msg, function( key, value ) {
          $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
        });
      }
    });


    $(document).ready(function () {
        $('tbody').delegate('.val1,.val2,.multTotal', 'keyup', function () {
            var tr = $(this).parent().parent();
            var val1 = tr.find('.val1').val();
            var val2 = tr.find('.val2').val();
            var total = (val1 * 1) * (val2 * 1);
            tr.find('.multTotal').val(total);
            multInputs();
        });

       function multInputs() {
           var mult = 0;
           // for each row:
           $(".multTotal").each(function (i,e) {
               // get the values from this row:
               var total = $(this).val()-0;
               mult += total;
           });
           $("#grandTotal").text(mult);
       }
    });
        </script>
    </body>
</html>