<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Softon\SweetAlert\Facades\SWAL;
use Illuminate\Support\Facades\Hash;
use App\Rules\MatchOldPassword;
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

        Karyawan::whereId(auth()->user()->id)->update([
            'username' => $request->username,
            'nama' => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
        ]);

        swal()->message('Data berhasil diperbarui','Perubahan pengaturan akun berhasil!','success');

        return redirect()->route('pengaturan.index');
    }

    public function passwordUpdate(Request $request) {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        Karyawan::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);

        swal()->message('Berhasil','Password berhasil diubah!','success');

        return redirect()->route('pengaturan.index');
    }
}