<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\{Karyawan, Role};

class KaryawanController extends Controller
{
    public function index() {
        $role = Role::get();
        return view('pages.master.karyawan.index', compact('role'));
    }

    public function store(Request $request) {
        $request->validate([
            'nama' => 'required',
            'username' => 'required',
            'email' => 'required|email',
            'no_hp' => 'required',
            'alamat' => 'required',
            'role' => 'required',
        ]);

        Karyawan::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'role_id' => $request->role,
            'password' => Hash::make('password'),
        ]);
    }

    public function update(Request $request, $id) {
        $request->validate([
            'nama' => 'required',
            'username' => 'required',
            'email' => 'required|email',
            'no_hp' => 'required',
            'alamat' => 'required',
            'role' => 'required',
        ]);

        Karyawan::whereId($id)->update([
            'nama' => $request->nama,
            'username' => $request->username,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'role_id' => $request->role,
        ]);
    }

    public function delete(Request $request, $id) {
        Karyawan::destroy($id);
    }

    public function query($request) {
        $query = Karyawan::get();
        return $query;
    }

    public function datatable(Request $request){
        return datatables($this->query($request))
        ->addIndexColumn()
        ->editColumn("role", function($item){
            return '<div class="badge badge-success">'.$item->Role->nama.'</div>';
        })
        ->editColumn("aksi", function($item){
            return "<div class='text-center'>
                <a href='javascript:;' onclick='app.edit(".$item.")' class='btn btn-sm btn-warning'  title='Edit'><i class='mdi mdi-pencil'></i></a>
                <a href='javascript:;' onclick='app.delete(".$item.")' class='btn btn-sm btn-danger'  title='Hapus'><i class='mdi mdi-delete'></i></a>
            </div>";
        })
        ->rawColumns(['aksi', 'role'])
        ->toJson();
    }
}
