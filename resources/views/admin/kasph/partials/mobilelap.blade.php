<form method="POST" action="{{ route('simpan.mobile') }}">
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
                            <label for="nama_barang" class="col-md-4 col-form-label text-md-right">{{__('Nama Barang') }}</label>

                            <div class="col-md-6">
                                <input id="nama_barang" type="text" class="form-control" oninvalid="this.setCustomValidity('Tolong Masukkan Data Nama Barang Jangan Dibiarkan Kosong')"
                                oninput="setCustomValidity('')" name="nama_barang" required autocomplete="nama_barang" autofocus>
                                @error('iuran_ph')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="keterangan" class="col-md-4 col-form-label text-md-right">{{__('Keterangan') }}</label>

                            <div class="col-md-6">
                                <input id="keterangan" type="text" class="form-control" oninvalid="this.setCustomValidity('Tolong Masukkan Data Keterangan Jangan Dibiarkan Kosong')"
                                oninput="setCustomValidity('')" name="keterangan" required autocomplete="keterangan" autofocus>
                                @error('keterangan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="jumlah_barang" class="col-md-4 col-form-label text-md-right">{{__('Jumlah Barang') }}</label>

                            <div class="col-md-6">
                                <input id="rate" type="number" class="form-control" oninvalid="this.setCustomValidity('Tolong Masukkan Data Jumlah Barang Jangan Dibiarkan Kosong')"
                                oninput="setCustomValidity('')" name="jumlah_barang" required autocomplete="jumlah_barang" autofocus>
                                @error('jumlah_barang')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="satuan_barang" class="col-md-4 col-form-label text-md-right">{{__('Satuan Barang') }}</label>
                            <div class="col-md-6">
                                <select name="satuan_barang" class="form-control" oninvalid="this.setCustomValidity('Tolong Pilih Satuan Barang')"
                                oninput="setCustomValidity('')">
                                    <option value=""></option>
                                    <option value="kg" {{ old('satuan_barang[]') == 'kg' ? 'selected' : '' }}>kg</option>
                                    <option value="g" {{ old('satuan_barang[]') == 'g' ? 'selected' : '' }}>g</option>
                                    <option value="km" {{ old('satuan_barang[]') == 'km' ? 'selected' : '' }}>km</option>
                                    <option value="m" {{ old('satuan_barang[]') == 'm' ? 'selected' : '' }}>m</option>
                                    <option value="buah" {{ old('satuan_barang[]') == 'buah' ? 'selected' : '' }}>Buah</option>
                                    <option value="biji" {{ old('satuan_barang[]') == 'biji' ? 'selected' : '' }}>Biji</option>
                                    <option value="liter" {{ old('satuan_barang[]') == 'liter' ? 'selected' : '' }}>Liter</option>
                                </select>
                                @error('satuan_barang')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="harga_satuan_barang" class="col-md-4 col-form-label text-md-right">{{__('Harga Satuan Barang(Rp)') }}</label>

                            <div class="col-md-6">
                                <input id="box" type="number" class="form-control" oninvalid="this.setCustomValidity('Tolong Masukkan Data Harga Satuan Barang Jangan Dibiarkan Kosong')"
                                oninput="setCustomValidity('')" name="harga_satuan_barang" required autocomplete="harga_satuan_barang" autofocus>
                                @error('harga_satuan_barang')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="jumlah_harga_barang" class="col-md-4 col-form-label text-md-right">{{__('Jumlah Harga Barang(Rp)') }}</label>

                            <div class="col-md-6">
                                <input id="amount" type="number" class="form-control" oninvalid="this.setCustomValidity('Tolong Masukkan Data Jumlah Harga Barang Jangan Dibiarkan Kosong')"
                                oninput="setCustomValidity('')" name="jumlah_harga_barang" required autocomplete="jumlah_harga_barang" autofocus>
                                @error('jumlah_harga_barang')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="text-center">
                        <button type="submit" name="submit" class="btn btn-primary"><i class="fas fa-save"></i>
                                {{__(' Simpan') }}
                        </button>
                        <a href="{{ route('admin-laporan-kas.index') }}" class="btn btn-warning"><i class="fas fa-arrow-circle-left"></i>{{__(' Kembali') }}</a>
                        </div>
                    </form>
