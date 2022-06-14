<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
        'no_invoice', 'pelanggan_id', 'berat', 'paket_id', 'total', 'tgl_mulai', 'tgl_selesai'
    ];

    public function HistoryTransaksi()
    {
        return $this->hasMany(HistoryTransaksi::class);
    }
}
