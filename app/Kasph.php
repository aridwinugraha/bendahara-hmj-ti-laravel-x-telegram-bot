<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kasph extends Model
{
    protected $table = 'kas_ph';

    public $timestamps = true;

    protected $primaryKey = 'id';

    protected $date = 'tanggal_batas_iuran';

    protected $fillable = ['total_kas_ph', 'total_pengeluaran_kas', 'tanggal_batas_iuran', 'iuran_ph', 'denda_ph',];
}
