<?php

namespace App\Http\Controllers;

use App\Http\Requests\KontenRequest;
use App\Models\Konten;
use App\Models\KategoriKoten;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class KontenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kontens = Konten::with('kategoriKoten')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('layouts.admin.manajemen-berita.konten-list', compact('kontens'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = KategoriKoten::orderBy('nama_kategori')->get();
        return view('layouts.admin.manajemen-berita.konten-create', compact('kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KontenRequest $request)
    {
        $validated = $request->validated();

        // Generate unique slug from title
        $baseSlug = Str::slug($validated['title']);
        $slug = $baseSlug;
        $counter = 1;

        while (Konten::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        $validated['slug'] = $slug;

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('konten-images', 'public');
        }

        // Set author to current user if not provided
        if (empty($validated['author'])) {
            $validated['author'] = Auth::user()->name ?? 'Admin';
        }

        Konten::create($validated);

        return redirect()->route('konten.index')
            ->with('success', 'Konten berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Konten $konten)
    {
        $konten->load('kategoriKoten');
        return view('layouts.admin.manajemen-berita.konten-preview', compact('konten'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Konten $konten)
    {
        $kategoris = KategoriKoten::orderBy('nama_kategori')->get();
        return view('layouts.admin.manajemen-berita.konten-edit', compact('konten', 'kategoris'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KontenRequest $request, Konten $konten)
    {
        $validated = $request->validated();

        // Generate new slug if title changed
        if ($validated['title'] !== $konten->title) {
            $baseSlug = Str::slug($validated['title']);
            $slug = $baseSlug;
            $counter = 1;

            while (Konten::where('slug', $slug)->where('id', '!=', $konten->id)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }

            $validated['slug'] = $slug;
        }

        // Handle image removal
        if ($request->has('remove_image') && $request->remove_image == '1') {
            if ($konten->image && Storage::disk('public')->exists($konten->image)) {
                Storage::disk('public')->delete($konten->image);
            }
            $validated['image'] = null;
        }
        // Handle image upload
        elseif ($request->hasFile('image')) {
            // Delete old image if exists
            if ($konten->image && Storage::disk('public')->exists($konten->image)) {
                Storage::disk('public')->delete($konten->image);
            }

            $validated['image'] = $request->file('image')->store('konten-images', 'public');
        }

        $konten->update($validated);

        return redirect()->route('konten.index')
            ->with('success', 'Konten berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Konten $konten)
    {
        try {
            // Delete image if exists
            if ($konten->image && Storage::disk('public')->exists($konten->image)) {
                Storage::disk('public')->delete($konten->image);
            }

            $konten->delete();

            return redirect()->route('konten.index')
                ->with('success', 'Konten berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('konten.index')
                ->with('error', 'Gagal menghapus konten.');
        }
    }

    /**
     * Update status of the specified resource.
     */
    public function updateStatus(Request $request, Konten $konten)
    {
        $request->validate([
            'status' => 'required|in:draft,published',
        ]);

        $konten->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diperbarui.',
            'status' => $konten->status,
        ]);
    }
}
