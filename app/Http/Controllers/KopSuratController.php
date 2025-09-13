<?php

namespace App\Http\Controllers;

use App\Models\KopSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KopSuratController extends Controller
{
    public function index()
    {
        $kopSurat = KopSurat::latest()->paginate(10);

        return view('layouts.admin.pengaturan.kop-surat.kop-surat-view', compact('kopSurat'));
    }

    public function create()
    {
        return view('layouts.admin.pengaturan.kop-surat.kop-surat-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_instansi' => 'required|string|max:255',
            'nama_instansi_2' => 'nullable|string|max:255',
            'nama_instansi_3' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'kode_pos' => 'nullable|string|max:10',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'header_content' => 'nullable|string',
            'footer_content' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $data = $request->except(['logo']);

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
            $data['logo'] = $logoPath;
        }

        // Jika kop surat ini diset aktif, nonaktifkan yang lain
        if ($request->is_active) {
            KopSurat::where('is_active', true)->update(['is_active' => false]);
        }

        KopSurat::create($data);

        return redirect()->route('kop-surat.index')
            ->with('success', 'Kop surat berhasil dibuat.');
    }

    public function show(KopSurat $kopSurat)
    {
        return view('layouts.admin.pengaturan.kop-surat.kop-surat-detail', compact('kopSurat'));
    }

    public function edit(KopSurat $kopSurat)
    {
        return view('layouts.admin.pengaturan.kop-surat.edit', compact('kopSurat'));
    }

    public function update(Request $request, KopSurat $kopSurat)
    {
        $request->validate([
            'nama_instansi' => 'required|string|max:255',
            'nama_instansi_2' => 'nullable|string|max:255',
            'nama_instansi_3' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'kode_pos' => 'nullable|string|max:10',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'header_content' => 'nullable|string',
            'footer_content' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $data = $request->except(['logo']);

        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada
            if ($kopSurat->logo) {
                Storage::disk('public')->delete($kopSurat->logo);
            }
            $logoPath = $request->file('logo')->store('logos', 'public');
            $data['logo'] = $logoPath;
        }

        // Jika kop surat ini diset aktif, nonaktifkan yang lain
        if ($request->is_active) {
            KopSurat::where('id', '!=', $kopSurat->id)
                ->where('is_active', true)
                ->update(['is_active' => false]);
        }

        $kopSurat->update($data);

        return redirect()->route('kop-surat.index')
            ->with('success', 'Kop surat berhasil diperbarui.');
    }

    public function destroy(KopSurat $kopSurat)
    {
        if ($kopSurat->logo) {
            Storage::disk('public')->delete($kopSurat->logo);
        }

        $kopSurat->delete();

        return redirect()->route('kop-surat.index')
            ->with('success', 'Kop surat berhasil dihapus.');
    }

    public function activate(KopSurat $kopSurat)
    {
        // Nonaktifkan semua kop surat
        KopSurat::where('is_active', true)->update(['is_active' => false]);

        // Aktifkan kop surat yang dipilih
        $kopSurat->update(['is_active' => true]);

        return redirect()->route('kop-surat.index')
            ->with('success', 'Kop surat berhasil diaktifkan.');
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('tinymce-images', 'public');
            $url = Storage::url($path);

            return response()->json(['location' => $url]);
        }

        return response()->json(['error' => 'Upload failed'], 400);
    }

    public function generateTemplate(KopSurat $kopSurat, Request $request)
    {
        $jenisSurat = $request->get('jenis_surat', 'surat_keterangan');
        $nomor = $request->get('nomor', '');

        return view('layouts.admin.pengaturan.kop-surat.template', compact('kopSurat', 'jenisSurat', 'nomor'));
    }

    public function wordPreview(KopSurat $kopSurat, Request $request)
    {
        $jenisSurat = $request->get('jenis_surat', 'SURAT KETERANGAN TIDAK MAMPU');
        $nomor = $request->get('nomor', '.../SKTM/WN-KA/'.date('Y'));

        return view('layouts.admin.pengaturan.kop-surat.word-preview', compact('kopSurat', 'jenisSurat', 'nomor'));
    }
}
