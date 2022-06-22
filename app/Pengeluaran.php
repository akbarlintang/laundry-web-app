<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    protected $fillable = [
        'total', 'bukti', 'keterangan', 'tgl_pengeluaran'
    ];
}
