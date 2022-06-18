<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Status, HistoryTransaksi};

class StatusController extends Controller
{
    public function index() {
        return view('pages.master.status.index');
    }

    public function store(Request $request) {
        $request->validate([
            'status' => 'required',
        ]);

        Status::create([
            'nama' => $request->status,
        ]);
    }

    public function update(Request $request, $id) {
        $request->validate([
            'status' => 'required',
        ]);

        Status::whereId($id)->update([
            'nama' => $request->status,
        ]);
    }

    public function delete(Request $request, $id) {
        Status::destroy($id);
    }

    public function query($request) {
        $query = Status::get();
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
