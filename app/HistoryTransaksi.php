<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoryTransaksi extends Model
{
    protected $fillable = [
        'transaksi_id', 'status'
    ];

    public function Transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }
}
