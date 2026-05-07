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

    public function show(string $uuid)
    {
        $infografis = Infografis::where('uuid', $uuid)->firstOrFail();
        abort_unless($infografis->is_active, 404);
        return view('infografis-detail', compact('infografis'));
    }
}
