<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    protected $table = 'reminder';

    public $timestamps = true;

    protected $primaryKey= 'id';

    protected $fillable = ['first_nama_tujuan', 'last_nama_tujuan', 'username_telegram_reminder', 'chat_id_reminder', 'no_hp_tujuan', 'nominal', 'notifikasi', 'status_iuran', 'pesan_pengingat',];
}
