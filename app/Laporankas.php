<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Laporankas extends Model
{
    protected $table = 'lap_kas_ph';

    public $timestamps = true;

    protected $primaryKey='id';

    protected $fillable = ['nama_barang', 'keterangan', 'jumlah_barang', 'satuan_barang', 'harga_satuan_barang', 'jumlah_harga_barang',];

    protected $guarded = [];
}