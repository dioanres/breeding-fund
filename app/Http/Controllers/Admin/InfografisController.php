<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Infografis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InfografisController extends Controller
{
    public function index()
    {
        $infografis = Infografis::latest()->paginate(10);
        return view('admin.infografis.index', compact('infografis'));
    }

    public function create()
    {
        return view('admin.infografis.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'file' => 'required|file|mimes:jpg,jpeg,png,gif,pdf|max:5120',
            'is_active' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        $uploadedFile = $request->file('file');
        $mime = $uploadedFile->getMimeType();
        $type = $mime === 'application/pdf' ? 'pdf' : 'image';

        $path = $uploadedFile->store('infografis', 'public');

        Infografis::create([
            'name' => $validated['name'],
            'file' => '/storage/' . $path,
            'type' => $type,
            'is_active' => $request->boolean('is_active', true),
            'published_at' => $validated['published_at'] ?? null,
        ]);

        return redirect()->route('admin.infografis.index')->with('success', 'Infografis berhasil ditambahkan!');
    }

    public function edit(int $id)
    {
        $infografis = Infografis::findOrFail($id);
        return view('admin.infografis.edit', compact('infografis'));
    }

    public function update(Request $request, int $id)
    {
        $infografis = Infografis::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|max:255',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf|max:5120',
            'is_active' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        $data = [
            'name' => $validated['name'],
            'is_active' => $request->boolean('is_active'),
            'published_at' => $validated['published_at'] ?? null,
        ];

        if ($request->hasFile('file')) {
            if ($infografis->file && str_contains($infografis->file, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $infografis->file));
            }

            $uploadedFile = $request->file('file');
            $mime = $uploadedFile->getMimeType();
            $data['type'] = $mime === 'application/pdf' ? 'pdf' : 'image';
            $path = $uploadedFile->store('infografis', 'public');
            $data['file'] = '/storage/' . $path;
        }

        $infografis->update($data);

        return redirect()->route('admin.infografis.index')->with('success', 'Infografis berhasil diperbarui!');
    }

    public function destroy(int $id)
    {
        $infografis = Infografis::findOrFail($id);

        if ($infografis->file && str_contains($infografis->file, '/storage/')) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $infografis->file));
        }

        $infografis->delete();

        return redirect()->route('admin.infografis.index')->with('success', 'Infografis berhasil dihapus!');
    }
}
