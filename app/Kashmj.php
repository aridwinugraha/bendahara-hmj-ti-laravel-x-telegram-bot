<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kashmj extends Model
{
    protected $table = 'kas_hmj';

    public $timestamps = true;

    protected $primaryKey='id';

    protected $fillable = ['total_kas_hmj',];
}
