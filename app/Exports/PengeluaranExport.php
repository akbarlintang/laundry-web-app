<?php

namespace App\Exports;

use App\Pengeluaran;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Illuminate\Http\Request;

class PengeluaranExport implements WithColumnWidths, FromView
{
    public function __construct(Request $request) 
    {
        if ($request->session()->has('pengeluaran_mulai')) {
            $this->pengeluaran = Pengeluaran::whereBetween('tgl_pengeluaran', [session('pengeluaran_mulai'), session('pengeluaran_selesai')])->get();
        } else {
            $this->pengeluaran = Pengeluaran::get();
        }
    }
    
    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 20,
            'C' => 30,
            'D' => 50,         
        ];
    }

    public function view(): View
    {
        $pengeluaran = $this->pengeluaran;
        foreach ($pengeluaran as $keluar) {
            $keluar->tgl_pengeluaran = date('d F Y', strtotime($keluar->tgl_pengeluaran));
            $keluar->total = 'Rp '.number_format($keluar->total);
        }

        return view('pages.pengeluaran.excel', [
            'pengeluaran' => $pengeluaran
        ]);
    }
}
