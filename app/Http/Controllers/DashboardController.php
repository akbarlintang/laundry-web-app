<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Karyawan, Transaksi, Pengeluaran};
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request) {
        $user = Karyawan::whereId(auth()->user()->id)->first();

        $currentMonth = $request->session()->has('bulan') ? session('bulan') : date('m');
        // $currentMonth = date('m');

        // return $currentMonth;

        // Total transaksi
        $transaksi = Transaksi::all();

        // Total transaksi bulanan
        $totalTransaksi = Transaksi::where('pembayaran', 'lunas')->whereMonth('tgl_order', $currentMonth)->get();

        // Pemasukan bulanan
        $pemasukan = 0;
        foreach ($totalTransaksi as $trx) {
            $pemasukan += $trx->total;
        }
        $pemasukan = number_format($pemasukan);

        // Pengeluaran bulanan
        $keluar = Pengeluaran::whereMonth('tgl_pengeluaran', $currentMonth)->get();
        $pengeluaran = 0;
        foreach ($keluar as $klr) {
            $pengeluaran += $klr->total;
        }
        $pengeluaran = number_format($pengeluaran);

        // Jumlah pegawai
        $pegawai = Karyawan::all();

        // Chart pemasukan
        $label = [];
        $data = [];
        $chartTransaksi = Transaksi::where('pembayaran', 'lunas')->whereMonth('tgl_order', $currentMonth)->get()->groupBy('tgl_order');
        foreach ($chartTransaksi as $index => $trx) {
            $total = 0;
            foreach ($trx as $key => $item) {
                $total += $item->total;
            }
            $tgl = new Carbon($index);
            array_push($label, $tgl->format('d F Y'));
            array_push($data, $total);
        }

        // Chart pengeluaran
        $label_klr = [];
        $data_klr = [];
        $chartPengeluaran = Pengeluaran::whereMonth('tgl_pengeluaran', $currentMonth)->get()->groupBy('tgl_pengeluaran');
        foreach ($chartPengeluaran as $index => $klr) {
            $total = 0;
            foreach ($klr as $key => $item) {
                $total += $item->total;
            }
            $tgl = new Carbon($index);
            array_push($label_klr, $tgl->format('d F Y'));
            array_push($data_klr, $total);
        }

        // return $label;

        return view('dashboard', compact('user', 'transaksi', 'totalTransaksi', 'pegawai', 'pemasukan', 'pengeluaran', 'label', 'data', 'label_klr', 'data_klr', 'currentMonth'));
    }

    public function filter(Request $request){
        $bulan = $request->bulan;

        $request->session()->flash('bulan', $bulan);

        return redirect()->route('dashboard.index');
    }
}
