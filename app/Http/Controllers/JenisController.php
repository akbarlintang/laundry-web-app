<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\JenisCucian;

class JenisController extends Controller
{
    public function index() {
        return view('pages.master.jenis.index');
    }

    public function store(Request $request) {
        $request->validate([
            'nama' => 'required',
        ]);

        JenisCucian::create([
            'nama' => $request->nama,
        ]);
    }

    public function update(Request $request, $id) {
        $request->validate([
            'nama' => 'required',
        ]);

        JenisCucian::whereId($id)->update([
            'nama' => $request->nama,
        ]);
    }

    public function delete(Request $request, $id) {
        JenisCucian::destroy($id);
    }

    public function query($request) {
        $query = JenisCucian::get();
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
