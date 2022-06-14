<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Transaksi, HistoryTransaksi, Pelanggan, Paket};

class TransaksiController extends Controller
{
    public function index() {
        $transaksi = Transaksi::get();
        return view('pages.transaksi.index', compact('transaksi'));
    }

    public function create() {
        $transaksi = Transaksi::get();
        $pelanggan = Pelanggan::get();
        $paket = Paket::get();
        return view('pages.transaksi.create', compact('transaksi', 'pelanggan', 'paket'));
    }
}
