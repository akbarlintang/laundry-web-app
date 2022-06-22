<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\{Pengeluaran, Transaksi};

class PengeluaranController extends Controller
{
    public function index(Request $request) {
        if ($request->session()->has('pemasukan_mulai')) {
            $pemasukan_mulai = date('d F Y', strtotime(session('pemasukan_mulai')));
            $pemasukan_selesai = date('d F Y', strtotime(session('pemasukan_selesai')));

            $transaksi = Transaksi::whereBetween('tgl_order', [$pemasukan_mulai, $pemasukan_selesai])->get();
        } else {
            $transaksi = Transaksi::get();
            $pemasukan_mulai = null;
            $pemasukan_selesai = null;
        }

        return view('pages.master.pengeluaran.index', compact('pemasukan_mulai', 'pemasukan_selesai'));
    }

    public function create() {
        return view('pages.master.pengeluaran.create');
    }

    public function store(Request $request) {
        // return $request;
        $request->validate([
            'tgl' => 'required',
            'total' => 'required',
            'keterangan' => 'required',
        ]);

        $files= [];
        if ($request->file) {
            foreach ($request->file('file') as $file) {
                $fileName = $file->getClientOriginalName();
                $file->storeAs('public/pengeluaran', $fileName);
                array_push($files, $fileName);
            }
        }

        Pengeluaran::create([
            'tgl_pengeluaran' => date('Y-m-d', strtotime($request->tgl)),
            'total' => $request->total,
            'keterangan' => $request->keterangan,
            'bukti' => json_encode($files),
        ]);

        $request->session()->flash('store', true);

        return redirect()->route('pengeluaran.index');
    }

    public function edit($id) {
        $data = Pengeluaran::whereId($id)->first();
        $data->tgl_pengeluaran = date('d F Y', strtotime($data->tgl_pengeluaran));
        $data->bukti = json_decode($data->bukti);

        return view('pages.master.pengeluaran.edit', compact('data'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'tgl' => 'required',
            'total' => 'required',
            'keterangan' => 'required',
        ]);

        $pengeluaran = Pengeluaran::whereId($id)->first();
        $pengeluaran->bukti = json_decode($pengeluaran->bukti);

        $files= count($pengeluaran->bukti) > 0 ? $pengeluaran->bukti : [];

        if ($request->file) {
            foreach ($request->file('file') as $file) {
                $fileName = $file->getClientOriginalName();
                $file->storeAs('public/pengeluaran', $fileName);
                array_push($files, $fileName);
            }
        }

        Pengeluaran::whereId($id)->update([
            'tgl_pengeluaran' => date('Y-m-d', strtotime($request->tgl)),
            'total' => $request->total,
            'keterangan' => $request->keterangan,
            'bukti' => json_encode($files),
        ]);
        // if (count($pengeluaran->bukti) > 0) {
        //     $files= json_decode($pengeluaran->bukti);
        //     if ($request->file) {
        //         foreach ($request->file('file') as $file) {
        //             $fileName = $file->getClientOriginalName();
        //             $file->storeAs('public/pengeluaran', $fileName);
        //             array_push($files, $fileName);
        //         }
        //     }

        //     Pengeluaran::create([
        //         'tgl_pengeluaran' => date('Y-m-d', strtotime($request->tgl)),
        //         'total' => $request->total,
        //         'keterangan' => $request->keterangan,
        //         'bukti' => json_encode($files),
        //     ]);
        // } else {
        //     $files= [];
        //     if ($request->file) {
        //         foreach ($request->file('file') as $file) {
        //             $fileName = $file->getClientOriginalName();
        //             $file->storeAs('public/pengeluaran', $fileName);
        //             array_push($files, $fileName);
        //         }
        //     }

        //     Pengeluaran::create([
        //         'tgl_pengeluaran' => date('Y-m-d', strtotime($request->tgl)),
        //         'total' => $request->total,
        //         'keterangan' => $request->keterangan,
        //         'bukti' => json_encode($files),
        //     ]);
        // }

        $request->session()->flash('store', true);

        return redirect()->route('pengeluaran.index');
    }

    public function delete(Request $request, $id) {
        Pengeluaran::destroy($id);
    }

    public function deleteFile(Request $request, $id, $index)
    {
        $item = Pengeluaran::whereId($id)->first();
        $data = json_decode($item->bukti);
        array_splice($data, $index, 1);

        Pengeluaran::whereId($id)->update([
            'bukti' => json_encode($data)
        ]);
    }

    public function query($request) {
        $query = Pengeluaran::get();
        foreach ($query as $q) {
            $q->bukti = json_decode($q->bukti);
        }
        return $query;
    }

    public function datatable(Request $request){
        return datatables($this->query($request))
        ->addIndexColumn()
        ->editColumn("tgl", function($item){
            return date('d F Y', strtotime($item->created_at));
        })
        ->editColumn("total", function($item){
            return 'Rp '.number_format($item->total);
        })
        ->editColumn("bukti", function($item){
            if ($item->bukti) {
                return "<a href='javascript:;' onclick='app.galeri(".$item.")' class='btn btn-sm btn-primary'><i class='mdi mdi-image'></i></a>";
            } else {
                return "-";
            }
        })
        ->editColumn("aksi", function($item){
            return "<div class='text-center'>
                <a href='". route('pengeluaran.edit', $item->id)."' class='btn btn-sm btn-warning'  title='Edit'><i class='mdi mdi-pencil'></i></a>
                <a href='javascript:;' onclick='app.delete(".$item.")' class='btn btn-sm btn-danger'  title='Hapus'><i class='mdi mdi-delete'></i></a>
            </div>";
        })
        ->rawColumns(['aksi', 'total', 'bukti'])
        ->toJson();
    }

    public function download($id, $index){
        $item = Pengeluaran::whereId($id)->firstOrFail();
        $item->bukti = json_decode($item->bukti);
        $link = $item->bukti[$index];
        $unduh = Storage::url('public/pengeluaran/'.$link);

        return response()->download(public_path($unduh));
    }
}
