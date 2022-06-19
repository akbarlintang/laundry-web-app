<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Config;

class ConfigController extends Controller
{
    public function index() {
        return view('pages.master.config.index');
    }

    public function update(Request $request, $id) {
        $request->validate([
            'value' => 'required',
        ]);

        Config::whereId($id)->update([
            'value' => $request->value,
        ]);
    }

    public function query($request) {
        $query = Config::get();
        return $query;
    }

    public function datatable(Request $request){
        return datatables($this->query($request))
        ->addIndexColumn()
        ->editColumn("aksi", function($item){
            return "<div class='text-center'>
                <a href='javascript:;' onclick='app.edit(".$item.")' class='btn btn-sm btn-warning'  title='Edit'><i class='mdi mdi-pencil'></i></a>
            </div>";
        })
        ->rawColumns(['aksi'])
        ->toJson();
    }
}
