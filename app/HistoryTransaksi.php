<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoryTransaksi extends Model
{
    protected $fillable = [
        'transaksi_id', 'status_id'
    ];

    public function Transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    public function Status()
    {
        return $this->belongsTo(Status::class);
    }
}
