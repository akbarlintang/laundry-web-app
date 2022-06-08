<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Karyawan;

class DashboardController extends Controller
{
    public function index() {
        $user = Karyawan::whereId(auth()->user()->id)->first();

        return view('dashboard', compact('user'));
    }
}
