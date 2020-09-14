<!DOCTYPE html>
<html>
<head>
	<title>{{__('Laporan Kas PH EXCEL') }}</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
		<h5 class="text-center">{{__('Laporan Kas PH') }}</h5>

	<table class='table table-bordered'>
		<thead>
	        <tr>
	            <th>{{__('No') }}</th>
				<th>{{__('Tanggal Pengeluaran') }}</th>
				<th>{{__('Nama Barang') }}</th>
				<th>{{__('Keterangan') }}</th>
				<th>{{__('Jumlah dan Satuan Barang') }}</th>
				<th>{{__('Harga Satuan Barang(Rp)') }}</th>
				<th>{{__('Jumlah Harga Barang(Rp)') }}</th>
	        </tr>
	    </thead>
		 <tbody>
	         @php(
	            $no = 1 {{-- buat nomor urut --}}
				)
				@foreach ($excel as $e)
            <tr>
				<td>{{ $no++ }}</td>
				<td>{{ \Carbon\Carbon::parse($e->created_at)->isoFormat('D MMMM Y') }}</td>
				<td>{{ $e->nama_barang }}</td>
				<td>{{ $e->keterangan }}</td>
				<td>{{ $e->jumlah_barang }} {{ $e->satuan_barang }}</td>
				<td>{{ $e->harga_satuan_barang }}</td>
				<td>{{ $e->jumlah_harga_barang }}</td>
			</tr>
				@endforeach
			<tr>
				<td colspan="6" class="text-center">{{__('Total Keseluruhan Transaski')}}</td>
				<td>{{ \DB::table('lap_kas_ph')->sum('jumlah_harga_barang') }}</td>
			</tr>
	    </tbody>
	</table>

</body>
</html>