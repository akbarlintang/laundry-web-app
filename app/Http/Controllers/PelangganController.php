<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Pelanggan};

class PelangganController extends Controller
{
    public function index() {
        $pelanggan = Pelanggan::get();
        return view('pages.pelanggan.index', compact('pelanggan'));
    }

    public function store(Request $request) {
        // return $request;
        $request->validate([
            'nama' => 'required',
            'no_hp' => 'numeric|required',
            'alamat' => 'required',
        ]);

        Pelanggan::create([
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
        ]);
    }

    public function query($request) {
        $query = Pelanggan::get();
        return $query;
    }

    public function datatable(Request $request){
        return datatables($this->query($request))
        ->addIndexColumn()
        ->editColumn("aksi", function($item){
            return "<div class='text-center'>
                <a href='javascript:;' onclick='app.edit(".$item.")' class='btn btn-sm btn-warning'  title='Edit'><i class='mdi mdi-pencil'></i></a>
                <a href='javascript:;' onclick='app.delete(".$item.")' class='btn btn-sm btn-danger'  title='Hapus'><i class='mdi mdi-delete'></i></a>
            </div>";
        })
        ->rawColumns(['aksi'])
        ->toJson();
    }
}
