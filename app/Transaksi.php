<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
        'no_invoice', 'pelanggan_id', 'berat', 'paket_id', 'total', 'tgl_order', 'tgl_selesai'
    ];

    public function History()
    {
        return $this->hasMany(HistoryTransaksi::class);
    }

    public function Pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function Paket()
    {
        return $this->belongsTo(Paket::class);
    }
}
