<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Transaksi, HistoryTransaksi, Pelanggan, Paket, Status};

class TransaksiController extends Controller
{
    public function index() {
        $transaksi = Transaksi::get();
        $status = Status::get();
        return view('pages.transaksi.index', compact('transaksi', 'status'));
    }

    public function create() {
        $pelanggan = Pelanggan::get();
        $paket = Paket::get();
        $transaksi = Transaksi::get();
        $last = Transaksi::orderBy('id', 'DESC')->first();
        $last_id = $last ? $last->id : '1';

        return view('pages.transaksi.create', compact('transaksi', 'pelanggan', 'paket', 'last_id'));
    }

    public function store(Request $request) {
        $request->validate([
            'invoice' => 'required',
            'tgl_order' => 'required',
            'tgl_selesai' => 'required',
            'pelanggan_id' => 'required',
            'paket_id' => 'required',
            'berat' => 'required',
            'total' => 'required',
        ]);

        Transaksi::create([
            'no_invoice' => $request->invoice,
            'tgl_order' => date('Y-m-d', strtotime($request->tgl_order)),
            'tgl_selesai' => date('Y-m-d', strtotime($request->tgl_selesai)),
            'pelanggan_id' => $request->pelanggan_id,
            'paket_id' => $request->paket_id,
            'berat' => $request->berat,
            'total' => $request->total,
        ]);

        HistoryTransaksi::create([
            'transaksi_id' => Transaksi::orderBy('id', 'DESC')->first()->id,
            'status_id' => 1,
        ]);
    }

    public function edit($id) {
        $pelanggan = Pelanggan::get();
        $paket = Paket::get();
        $transaksi = Transaksi::get();
        $last = Transaksi::orderBy('id', 'DESC')->first();
        $last_id = $last ? $last->id : '1';
        $data = Transaksi::whereId($id)->first();
        $data->tgl_order = date('d F Y', strtotime($data->tgl_order));
        $data->tgl_selesai = date('d F Y', strtotime($data->tgl_selesai));

        return view('pages.transaksi.edit', compact('transaksi', 'pelanggan', 'paket', 'last_id', 'data'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'invoice' => 'required',
            'tgl_order' => 'required',
            'tgl_selesai' => 'required',
            'pelanggan_id' => 'required',
            'paket_id' => 'required',
            'berat' => 'required',
            'total' => 'required',
        ]);

        Transaksi::whereId($id)->update([
            'no_invoice' => $request->invoice,
            'tgl_order' => date('Y-m-d', strtotime($request->tgl_order)),
            'tgl_selesai' => date('Y-m-d', strtotime($request->tgl_selesai)),
            'pelanggan_id' => $request->pelanggan_id,
            'paket_id' => $request->paket_id,
            'berat' => $request->berat,
            'total' => $request->total,
        ]);
    }

    public function delete(Request $request, $id) {
        Transaksi::destroy($id);
    }

    public function updateStatus(Request $request, $id) {
        $request->validate([
            'status' => 'required',
        ]);

        HistoryTransaksi::whereId($id)->create([
            'transaksi_id' => $id,
            'status_id' => $request->status,
        ]);
    }

    public function query($request) {
        $query = Transaksi::all();
        foreach($query as $q){
            $q->status = HistoryTransaksi::with('Status')->where('transaksi_id', $q->id)->orderBy('id', 'DESC')->first();
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
        ->editColumn("tgl_selesai", function($item){
            return date('d F Y', strtotime($item->tgl_selesai));
        })
        ->editColumn("paket", function($item){
            return $item->Paket->nama;
        })
        ->editColumn("berat", function($item){
            return $item->berat." Kg";
        })
        ->editColumn("total", function($item){
            return "Rp ".number_format($item->total);
        })
        ->editColumn("status", function($item){
            return "<a href='javascript:;' onclick='app.status(".$item.")' class='btn btn-sm btn-success'>".$item->status->status->nama."</a>";
        })
        ->editColumn("aksi", function($item){
            return "<div class='text-center'>
                <a href='". route('transaksi.edit', $item->id)."' class='btn btn-sm btn-warning'  title='Edit'><i class='mdi mdi-pencil'></i></a>
                <a href='javascript:;' onclick='app.delete(".$item.")' class='btn btn-sm btn-danger'  title='Hapus'><i class='mdi mdi-delete'></i></a>
            </div>";
        })
        ->rawColumns(['status', 'aksi'])
        ->toJson();
    }

    public function cari(Request $request){
        $transaksi = Transaksi::with('History.Status', 'Pelanggan', 'Paket')->where('no_invoice', $request->invoice)->first();
        $transaksi->total = number_format($transaksi->total);
        $transaksi->tgl_order = date('d F Y', strtotime($transaksi->tgl_order));
        $transaksi->tgl_selesai = date('d F Y', strtotime($transaksi->tgl_selesai));

        return $transaksi;
    }
}
