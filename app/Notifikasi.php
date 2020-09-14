<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Notifications\Notifiable;

class Notifikasi extends Model
{
    // use Notifiable;

    protected $table = 'notifikasi';

    public $timestamps = true;

    protected $primaryKey = 'id';

    protected $fillable = ['first_nama', 'last_nama', 'username_telegram_notifikasi', 'chat_id_notifikasi', 'nominal_bayar', 'status_notifikasi',];
}
