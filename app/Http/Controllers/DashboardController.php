<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Karyawan, Transaksi};
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $user = Karyawan::whereId(auth()->user()->id)->first();
        $currentMonth = date('m');

        // Total transaksi
        $transaksi = Transaksi::all();

        // Total transaksi bulanan
        $totalTransaksi = Transaksi::whereMonth('tgl_order', $currentMonth)->get();

        // Pemasukan bulanan
        $pemasukan = 0;
        foreach ($transaksi as $trx) {
            $pemasukan += $trx->total;
        }
        $pemasukan = number_format($pemasukan);

        // Jumlah pegawai
        $pegawai = Karyawan::all();

        // Chart
        $label = [];
        $data = [];
        $chartTransaksi = Transaksi::whereMonth('tgl_order', $currentMonth)->get()->groupBy('tgl_order');
        foreach ($chartTransaksi as $index => $trx) {
            $total = 0;
            foreach ($trx as $key => $item) {
                $total += $item->total;
            }
            $tgl = new Carbon($index);
            array_push($label, $tgl->format('d F Y'));
            array_push($data, $total);
        }

        // return $label;

        return view('dashboard', compact('user', 'transaksi', 'totalTransaksi', 'pegawai', 'pemasukan', 'label', 'data'));
    }
}
