<?php

namespace App\Http\Controllers;

use App\Models\Infografis;

class InfografisController extends Controller
{
    public function index()
    {
        $infografis = Infografis::where('is_active', true)->latest()->get();
        return view('infografis', compact('infografis'));
    }
}
