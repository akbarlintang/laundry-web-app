<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Transaksi;
use App\Exports\PemasukanExport;
use Maatwebsite\Excel\Facades\Excel;

class PemasukanController extends Controller
{
    public function index(Request $request) {
        $request->session()->forget(['pemasukan_mulai', 'pemasukan_selesai']);
        return view('pages.pemasukan.index');
    }

    public function query($request) {
        if ($request->session()->has('pemasukan_mulai')) {
            $pemasukan_mulai = session('pemasukan_mulai');
            $pemasukan_selesai = session('pemasukan_selesai');

            $query = Transaksi::whereBetween('tgl_order', [$pemasukan_mulai, $pemasukan_selesai])->where('pembayaran', 'lunas')->get();
        } else {
            $query = Transaksi::where('pembayaran', 'lunas')->get();
        }
        return $query;
    }

    public function datatable(Request $request){
        return datatables($this->query($request))
        ->addIndexColumn()
        ->editColumn("pelanggan", function($item){
            return $item->Pelanggan->nama;
        })
        ->editColumn("tgl_order", function($item){
            return date('d F Y', strtotime($item->tgl_order));
        })
        ->editColumn("paket", function($item){
            return $item->Paket->nama;
        })
        ->editColumn("berat", function($item){
            return $item->berat." Kg";
        })
        ->editColumn("total", function($item){
            return "Rp ".$item->total;
        })
        ->rawColumns(['berat', 'total'])
        ->toJson();
    }

    public function filter(Request $request){
        $pemasukan_mulai = date('Y-m-d', strtotime($request->tgl_mulai));
        $pemasukan_selesai = date('Y-m-d', strtotime($request->tgl_selesai));

        $request->session()->put('pemasukan_mulai', $pemasukan_mulai);
        $request->session()->put('pemasukan_selesai', $pemasukan_selesai);
    }

    public function total(Request $request){
        if ($request->session()->has('pemasukan_mulai')) {
            $pemasukan_mulai = session('pemasukan_mulai');
            $pemasukan_selesai = session('pemasukan_selesai');

            $query = Transaksi::whereBetween('tgl_order', [$pemasukan_mulai, $pemasukan_selesai])->get();
            $total = 0;
            foreach ($query as $trx) {
                $total += $trx->total;
            }
            $total = number_format($total);
        } else {
            $query = Transaksi::get();
            $total = 0;
            foreach ($query as $trx) {
                $total += $trx->total;
            }
            $total = number_format($total);
        }
        return $total;
    }

    public function export(Request $request)
	{
		return Excel::download(new PemasukanExport($request), 'pemasukan.xlsx');
	}
}
