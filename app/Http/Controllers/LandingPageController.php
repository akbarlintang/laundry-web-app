<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Status, HistoryTransaksi, Config};

class LandingPageController extends Controller
{
    public function index() {
        return view('pages.landing.index');
    }

    public function cekNota() {
        $config = Config::all();
        return view('pages.landing.cek-nota', compact('config'));
    }
}
