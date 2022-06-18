<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Status, HistoryTransaksi};

class LandingPageController extends Controller
{
    public function index() {
        return view('pages.landing.index');
    }

    public function cekNota() {
        return view('pages.landing.cek-nota');
    }
}
