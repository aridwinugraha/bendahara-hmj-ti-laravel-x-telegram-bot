<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
  	<title>{{__('Laporan Kas Pengurus Harian') }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  </head>
<body>
<h5 class="text-center">{{__('Laporan Kas PH') }}</h5>
	<table class='table table-bordered'>
		<thead class="thead-dark">
	        <tr>
				<th scope="col">{{__('No') }}</th>
				<th scope="col">{{__('Tanggal Pengeluaran') }}</th>
				<th scope="col">{{__('Nama Barang') }}</th>
				<th scope="col">{{__('Keterangan') }}</th>
				<th scope="col">{{__('Jumlah dan Satuan Barang') }}</th>
				<th scope="col">{{__('Harga Satuan Barang(Rp)') }}</th>
				<th scope="col">{{__('Jumlah Harga Barang(Rp)') }}</th>
	        </tr>
	    </thead>
		 <tbody>
	         @php(
	            $no = 1 {{-- buat nomor urut --}}
				)
				@foreach ($lap as $data)
            <tr>
				<th scope="row">{{ $no++ }}</th>
				<td>{{ \Carbon\Carbon::parse($data->created_at)->isoFormat('D MMMM Y') }}</td>
				<td>{{ $data->nama_barang }}</td>
				<td>{{ $data->keterangan }}</td>
				<td>{{ $data->jumlah_barang }} {{ $data->satuan_barang }}</td>
				<td>{{ $data->harga_satuan_barang }}</td>
				<td>{{ $data->jumlah_harga_barang }}</td>
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
