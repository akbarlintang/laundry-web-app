<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Transaksi, Pengeluaran};
use DateTime;
use DateInterval;
use DatePeriod;
use App\Exports\KeuanganExport;
use Maatwebsite\Excel\Facades\Excel;

class LaporanKeuanganController extends Controller
{
    public function index(Request $request) {
        if ($request->session()->has('laporan_mulai')) {
            $laporan_mulai = date('Y-m-d', strtotime(session('laporan_mulai')));
            $laporan_selesai = date('Y-m-d', strtotime(session('laporan_selesai')));
            
            $pemasukan = Transaksi::where('pembayaran', 'lunas')->whereBetween('tgl_order', [$laporan_mulai, $laporan_selesai])->get()->groupBy('tgl_order');
            $pengeluaran = Pengeluaran::whereBetween('tgl_pengeluaran', [$laporan_mulai, $laporan_selesai])->get()->groupBy('tgl_pengeluaran');

            $query = null;
            $begin = new DateTime( "2000-01-01" );
            $end   = new DateTime( "2030-01-01" );
            $end = $end->modify( '+1 day' );

            $interval = new DateInterval('P1D');
            $daterange = new DatePeriod($begin, $interval ,$end);

            foreach($daterange as $index => $date){
                $tgl = $date->format('Y-m-d');
            
                foreach ($pengeluaran as $key => $keluar) {
                    if ($tgl == $key) {
                        $total_klr = 0;
                        foreach($keluar as $klr){
                            $total_klr += $klr->total;
                        }

                        $query[$index]['keluar'] = $total_klr;
                        $query[$index]['tgl'] = $tgl;
                    }
                }

                foreach ($pemasukan as $key => $masuk) {
                    if ($tgl == $key) {
                        $total_msk = 0;
                        foreach($masuk as $msk){
                            $total_msk += $msk->total;
                        }
        
                        $query[$index]['masuk'] = $total_msk;
                        $query[$index]['tgl'] = $tgl;
                    }
                }
            }

            $total_masuk = 0;
            $total_keluar = 0;
            foreach($query as $key => $item){
                if(isset($item['masuk'])){
                    $total_masuk += $item['masuk'];
                }
                if(isset($item['keluar'])){
                    $total_keluar += $item['keluar'];
                }
            }
            $total_untung = $total_masuk - $total_keluar;
            $laporan_mulai = date('d F Y', strtotime(session('laporan_mulai')));
            $laporan_selesai = date('d F Y', strtotime(session('laporan_selesai')));
            $query = collect($query)->sortBy('tgl')->toArray();
        } else {
            $laporan_mulai = null;
            $laporan_selesai = null;

            $pemasukan = Transaksi::where('pembayaran', 'lunas')->get()->groupBy('tgl_order');
            $pengeluaran = Pengeluaran::get()->groupBy('tgl_pengeluaran');

            $query = null;
            $begin = new DateTime( "2000-01-01" );
            $end   = new DateTime( "2030-01-01" );
            $end = $end->modify( '+1 day' );

            $interval = new DateInterval('P1D');
            $daterange = new DatePeriod($begin, $interval ,$end);

            foreach($daterange as $index => $date){
                $tgl = $date->format('Y-m-d');
                foreach ($pengeluaran as $key => $keluar) {
                    if ($tgl == $key) {
                        $total_klr = 0;
                        foreach($keluar as $klr){
                            $total_klr += $klr->total;
                        }

                        $query[$index]['keluar'] = $total_klr;
                        $query[$index]['tgl'] = $tgl;
                    }
                }

                foreach ($pemasukan as $key => $masuk) {
                    if ($tgl == $key) {
                        $total_msk = 0;
                        foreach($masuk as $msk){
                            $total_msk += $msk->total;
                        }

                        $query[$index]['masuk'] = $total_msk;
                        $query[$index]['tgl'] = $tgl;
                    }
                }
            }

            $total_masuk = 0;
            $total_keluar = 0;
            foreach($query as $key => $item){
                if(isset($item['masuk'])){
                    $total_masuk += $item['masuk'];
                }
                if(isset($item['keluar'])){
                    $total_keluar += $item['keluar'];
                }
            }
            $total_untung = $total_masuk - $total_keluar;

            $query = collect($query)->sortBy('tgl')->toArray();

            // return $query;
        }

        // $request->session()->forget(['laporan_mulai', 'laporan_selesai']);
        $request->session()->reflash();
        return view('pages.laporan-keuangan.index', compact('laporan_mulai', 'laporan_selesai', 'pemasukan', 'pengeluaran', 'query', 'total_masuk', 'total_keluar', 'total_untung'));
    }

    public function query($request) {
        if ($request->session()->has('pemasukan_mulai')) {
            $pemasukan_mulai = session('pemasukan_mulai');
            $pemasukan_selesai = session('pemasukan_selesai');

            $query = Transaksi::whereBetween('tgl_order', [$pemasukan_mulai, $pemasukan_selesai])->get();
        } else {
            $pemasukan = Transaksi::where('pembayaran', 'lunas')->get()->groupBy('tgl_order');
            $pengeluaran = Pengeluaran::get()->groupBy('tgl_pengeluaran');

            $query = null;
            $begin = new DateTime( "2000-01-01" );
            $end   = new DateTime( "2030-01-01" );
            $end = $end->modify( '+1 day' );

            $interval = new DateInterval('P1D');
            $daterange = new DatePeriod($begin, $interval ,$end);

            foreach($daterange as $index => $date){
                foreach ($pengeluaran as $key => $keluar) {
                    $total_klr = 0;
                    foreach($keluar as $klr){
                        $total_klr += $klr->total;
                    }

                    $query[$key]['keluar'] = $total_klr;
                }

                foreach ($pemasukan as $key => $masuk) {
                    $total_msk = 0;
                    foreach($masuk as $msk){
                        $total_msk += $msk->total;
                    }

                    $query[$key]['masuk'] = $total_msk;
                }
            }
        }

        // $query = Transaksi::get();
        return $query;
    }

    public function datatable(Request $request){
        // return ($this->query($request));
        return datatables($this->query($request))
        ->addIndexColumn()
        ->editColumn("tgl", function($item){
            return $item;
        })
        ->editColumn("pemasukan", function($item){
            return isset($item['masuk']) ? $item['masuk'] : '-';
        })
        ->editColumn("pengeluaran", function($item){
            return isset($item['masuk']) ? $item['masuk'] : '-';
        })
        ->editColumn("total", function($item){
            return isset($item['masuk']) ? $item['masuk'] : '-';
        })
        // ->rawColumns(['berat', 'total'])
        ->toJson();
    }

    public function filter(Request $request){
        // $laporan_mulai = date('Y-m-d', strtotime($request->tgl_mulai));
        // $laporan_selesai = date('Y-m-d', strtotime($request->tgl_selesai));

        // $request->session()->flash('laporan_mulai', $laporan_mulai);
        // $request->session()->flash('laporan_selesai', $laporan_selesai);

        // return redirect()->route('laporan-keuangan.index')->with([
        //     'laporan_mulai' => $laporan_mulai,
        //     'laporan_selesai' => $laporan_selesai,
        // ]);

        if ($request->tgl_mulai) {
            $laporan_mulai = date('Y-m-d', strtotime($request->tgl_mulai));
        } else {
            $laporan_mulai = null;
        }

        if ($request->tgl_selesai) {
            $laporan_selesai = date('Y-m-d', strtotime($request->tgl_selesai));
        } else {
            $laporan_selesai = null;
        }

        $request->session()->flash('laporan_mulai', $laporan_mulai);
        $request->session()->flash('laporan_selesai', $laporan_selesai);
        
        return redirect()->route('laporan-keuangan.index');
    }

    public function export(Request $request)
	{
        $request->session()->reflash();
		return Excel::download(new KeuanganExport($request), 'laporan_keuangan.xlsx');
	}
}
