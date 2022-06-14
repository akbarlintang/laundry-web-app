<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Paket};

class PaketController extends Controller
{
    public function index() {
        $paket = Paket::get();
        return view('pages.paket.index', compact('paket'));
    }

    public function store(Request $request) {
        // return $request;
        $request->validate([
            'nama' => 'required',
            'harga' => 'numeric|required',
        ]);

        Paket::create([
            'nama' => $request->nama,
            'harga' => $request->harga,
        ]);
    }

    public function query($request) {
        $query = Paket::get();
        return $query;
    }

    public function datatable(Request $request){
        return datatables($this->query($request))
        ->addIndexColumn()
        ->editColumn("harga", function($item){
            return "Rp ".number_format($item->harga);
        })
        ->editColumn("aksi", function($item){
            return "<div class='text-center'>
                <a href='javascript:;' onclick='app.edit(".$item.")' class='btn btn-sm btn-warning'  title='Edit'><i class='mdi mdi-pencil'></i></a>
                <a href='javascript:;' onclick='app.delete(".$item.")' class='btn btn-sm btn-danger'  title='Hapus'><i class='mdi mdi-delete'></i></a>
            </div>";
        })
        ->rawColumns(['harga', 'aksi'])
        ->toJson();
    }

    public function get($id){
        $data = Paket::find($id);
        return response($data);
    }
}
