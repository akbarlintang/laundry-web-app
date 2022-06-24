<?php

namespace App\Exports;

use App\Transaksi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Illuminate\Http\Request;

class PemasukanExport implements WithColumnWidths, FromView
{
    public function __construct(Request $request) 
    {
        if ($request->session()->has('pemasukan_mulai')) {
            $this->pemasukan = Transaksi::whereBetween('tgl_order', [session('pemasukan_mulai'), session('pemasukan_selesai')])->where('pembayaran', 'lunas')->get();
        } else {
            $this->pemasukan = Transaksi::get();
        }
    }
    
    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 30,
            'C' => 20,
            'D' => 20,
            'E' => 20,
            'F' => 10,
            'G' => 20,
        ];
    }

    public function view(): View
    {
        $pemasukan = $this->pemasukan;
        foreach ($pemasukan as $keluar) {
            $keluar->tgl_order = date('d F Y', strtotime($keluar->tgl_order));
            $keluar->berat = number_format($keluar->berat).' Kg';
            $keluar->total = 'Rp '.number_format($keluar->total);
        }

        return view('pages.pemasukan.excel', [
            'pemasukan' => $pemasukan
        ]);
    }
}
