<?php

namespace App\Http\Controllers;

use App\Http\Requests\KategoriKotenRequest;
use App\Models\KategoriKoten;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KategoriKotenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategoris = KategoriKoten::all();

        return view('layouts.admin.manajemen-berita.kategori-konten-list', compact('kategoris'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KategoriKotenRequest $request)
    {
        $validated = $request->validated();

        // Generate slug from nama_kategori
        $validated['slug'] = Str::slug($validated['nama_kategori']);

        // Ensure slug is unique
        $baseSlug = $validated['slug'];
        $counter = 1;
        while (KategoriKoten::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $baseSlug . '-' . $counter;
            $counter++;
        }

        KategoriKoten::create($validated);

        return redirect()->route('kategori-koten.index')
            ->with('success', 'Kategori konten berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(KategoriKoten $kategoriKoten)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KategoriKoten $kategoriKoten)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KategoriKotenRequest $request, KategoriKoten $kategoriKoten)
    {
        $validated = $request->validated();

        // Generate new slug if nama_kategori changed
        if ($validated['nama_kategori'] !== $kategoriKoten->nama_kategori) {
            $baseSlug = Str::slug($validated['nama_kategori']);
            $slug = $baseSlug;
            $counter = 1;

            while (KategoriKoten::where('slug', $slug)->where('id', '!=', $kategoriKoten->id)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }

            $validated['slug'] = $slug;
        }

        $kategoriKoten->update($validated);

        return redirect()->route('kategori-koten.index')
            ->with('success', 'Kategori konten berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KategoriKoten $kategoriKoten)
    {
        try {
            // Check if kategori has related konten
            if ($kategoriKoten->kontens()->count() > 0) {
                return redirect()->route('kategori-koten.index')
                    ->with('error', 'Kategori tidak dapat dihapus karena masih memiliki konten terkait.');
            }

            $kategoriKoten->delete();

            return redirect()->route('kategori-koten.index')
                ->with('success', 'Kategori konten berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('kategori-koten.index')
                ->with('error', 'Gagal menghapus kategori konten.');
        }
    }
}
