<?php

namespace App\Http\Controllers;

use App\Models\VerifikasiPengguna;

class PenggunaController extends Controller
{
    public function index()
    {

        $users = VerifikasiPengguna::where('status', 'verified')->get();

        return view('layouts.admin.pengguna-list', compact('users'));
    }
}
