<?php

namespace App\Exports;

use App\{Transaksi, Pengeluaran};
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Illuminate\Http\Request;
use DateTime;
use DateInterval;
use DatePeriod;


class KeuanganExport implements WithColumnWidths, FromView
{
    public function __construct(Request $request) 
    {
        if ($request->session()->has('laporan_mulai')) {
            $this->pemasukan = Transaksi::whereBetween('tgl_order', [session('laporan_mulai'), session('laporan_selesai')])->where('pembayaran', 'lunas')->get()->groupBy('tgl_order');
            $this->pengeluaran = Pengeluaran::whereBetween('tgl_pengeluaran', [session('laporan_mulai'), session('laporan_selesai')])->get()->groupBy('tgl_pengeluaran');

            $this->laporan_mulai = date('d F Y', strtotime(session('laporan_mulai')));
            $this->laporan_selesai = date('d F Y', strtotime(session('laporan_selesai')));
        } else {
            $this->pemasukan = Transaksi::where('pembayaran', 'lunas')->get()->groupBy('tgl_order');
            $this->pengeluaran = Pengeluaran::get()->groupBy('tgl_pengeluaran');

            $this->laporan_mulai = null;
            $this->laporan_selesai = null;
        }
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 15,
            'C' => 25,
            'D' => 25,
            'E' => 30,
        ];
    }

    public function view(): View
    {
        $pengeluaran = $this->pengeluaran;
        // foreach ($pengeluaran as $keluar) {
        //     $keluar->tgl_pengeluaran = date('d F Y', strtotime($keluar->tgl_pengeluaran));
        //     $keluar->total = 'Rp '.number_format($keluar->total);
        // }

        $pemasukan = $this->pemasukan;
        // foreach ($pemasukan as $keluar) {
        //     $keluar->tgl_order = date('d F Y', strtotime($keluar->tgl_order));
        //     $keluar->berat = number_format($keluar->berat).' Kg';
        //     $keluar->total = 'Rp '.number_format($keluar->total);
        // }

        // $query = null;
        // $begin = new DateTime( "2000-01-01" );
        // $end   = new DateTime( "2030-01-01" );
        // $end = $end->modify( '+1 day' );

        // $interval = new DateInterval('P1D');
        // $daterange = new DatePeriod($begin, $interval ,$end);

        // foreach($daterange as $index => $date){
        //     $tgl = $date->format('Y-m-d');
        
        //     foreach ($pengeluaran as $key => $keluar) {
        //         if ($tgl == $key) {
        //             $total_klr = 0;
        //             foreach($keluar as $klr){
        //                 $total_klr += $klr->total;
        //             }

        //             $query[$index]['keluar'] = $total_klr;
        //             $query[$index]['tgl'] = $tgl;
        //         }
        //     }

        //     foreach ($pemasukan as $key => $masuk) {
        //         if ($tgl == $key) {
        //             $total_msk = 0;
        //             foreach($masuk as $msk){
        //                 $total_msk += $msk->total;
        //             }
    
        //             $query[$index]['masuk'] = $total_msk;
        //             $query[$index]['tgl'] = $tgl;
        //         }
        //     }
        // }

        // $query = null;
        // $begin = new DateTime( "2000-01-01" );
        // $end   = new DateTime( "2030-01-01" );
        // $end = $end->modify( '+1 day' );

        // $interval = new DateInterval('P1D');
        // $daterange = new DatePeriod($begin, $interval ,$end);

        // foreach($daterange as $index => $date){
        //     $tgl = $date->format('Y-m-d');
        //     foreach ($pengeluaran as $key => $keluar) {
        //         if ($tgl == $key) {
        //             $total_klr = 0;
        //             foreach($keluar as $klr){
        //                 $total_klr += $klr->total;
        //             }

        //             $query[$index]['keluar'] = $total_klr;
        //             $query[$index]['tgl'] = $tgl;
        //         }
        //     }

        //     foreach ($pemasukan as $key => $masuk) {
        //         if ($tgl == $key) {
        //             $total_msk = 0;
        //             foreach($masuk as $msk){
        //                 $total_msk += $msk->total;
        //             }

        //             $query[$index]['masuk'] = $total_msk;
        //             $query[$index]['tgl'] = $tgl;
        //         }
        //     }
        // }

        // $total_masuk = 0;
        // $total_keluar = 0;
        // foreach($query as $key => $item){
        //     if(isset($item['masuk'])){
        //         $total_masuk += $item['masuk'];
        //     }
        //     if(isset($item['keluar'])){
        //         $total_keluar += $item['keluar'];
        //     }
        // }
        // $total_untung = $total_masuk - $total_keluar;
        // $laporan_mulai = $this->laporan_mulai;
        // $laporan_selesai = $this->laporan_selesai;
        // $query = collect($query)->sortBy('tgl')->toArray();



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
            $laporan_mulai = $this->laporan_mulai;
            $laporan_selesai = $this->laporan_selesai;
            $query = collect($query)->sortBy('tgl')->toArray();

        return view('pages.laporan-keuangan.excel', compact('laporan_mulai', 'laporan_selesai', 'pemasukan', 'pengeluaran', 'query', 'total_masuk', 'total_keluar', 'total_untung'));
    }
}
