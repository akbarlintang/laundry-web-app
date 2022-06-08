<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Softon\SweetAlert\Facades\SWAL;
use App\Karyawan;

class AkunController extends Controller
{
    public function index() {
        return view('pages.akun.ubah-password.index');
    }

    public function generalUpdate(Request $request) {
        $request->validate([
            'username' => 'required',
            'nama' => 'required',
            'email' => 'required',
            'no_hp' => 'required',
            'alamat' => 'required',
        ]);

        $update = Karyawan::whereId(auth()->user()->id)->update([
            'username' => $request->username,
            'nama' => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
        ]);

        if ($update > 0) {
            swal()->message('Data berhasil diperbarui','Perubahan pengaturan akun berhasil!','success');
        } else {
            swal()->message('Data gagal diperbarui','Perubahan pengaturan akun gagal!','danger');
        }

        return redirect()->route('pengaturan.index');
    }
}