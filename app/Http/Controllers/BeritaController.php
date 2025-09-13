<?php

namespace App\Http\Controllers;

use App\Models\Konten;
use App\Models\KategoriKoten;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    /**
     * Display a listing of published articles with optional category filter.
     */
    public function index(Request $request)
    {
        $categories = KategoriKoten::orderBy('nama_kategori')->get();

        $query = Konten::with('kategoriKoten')
            ->where('status', 'published')
            ->orderBy('created_at', 'desc');

        // Filter by category if provided
        if ($request->has('kategori') && $request->kategori != '') {
            $query->whereHas('kategoriKoten', function ($q) use ($request) {
                $q->where('slug', $request->kategori);
            });
        }

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('body', 'like', '%' . $request->search . '%');
            });
        }

        $kontents = $query->paginate(9);

        return view('layouts.landing-page.berita.lamanberita', compact('kontents', 'categories'));
    }

    /**
     * Display the specified article detail.
     */
    public function show(string $slug)
    {
        $konten = Konten::with('kategoriKoten')
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Get related articles (same category, excluding current article)
        $relatedKontents = Konten::with('kategoriKoten')
            ->where('kategori_koten_id', $konten->kategori_koten_id)
            ->where('id', '!=', $konten->id)
            ->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        return view('layouts.landing-page.berita.detailberita', compact('konten', 'relatedKontents'));
    }
}
