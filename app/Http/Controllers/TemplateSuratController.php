<?php

namespace App\Http\Controllers;

use App\Models\KopSurat;
use App\Models\TemplateSurat;
use Illuminate\Http\Request;

class TemplateSuratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $templates = TemplateSurat::orderBy('kategori')->orderBy('nama_template')->get();

        return view('layouts.admin.pengaturan.template-surat.index', compact('templates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = [
            'SKTM' => 'Surat Keterangan Tidak Mampu',
            'SKU' => 'Surat Keterangan Usaha',
            'SKD' => 'Surat Keterangan Domisili',
            'SKK' => 'Surat Keterangan Kelahiran',
            'SKM' => 'Surat Keterangan Menikah',
            'SKCK' => 'Surat Keterangan Catatan Kepolisian',
            'UMUM' => 'Surat Umum',
            'UNDANGAN' => 'Surat Undangan',
            'PEMBERITAHUAN' => 'Surat Pemberitahuan',
        ];

        return view('layouts.admin.pengaturan.template-surat.create', compact('kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_template' => 'required|string|max:255',
            'kategori' => 'required|string',
            'judul_surat' => 'required|string|max:255',
            'nomor_format' => 'nullable|string|max:255',
            'isi_surat' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        $template = TemplateSurat::create($request->all());

        // Auto-detect variables yang digunakan
        $variables = $template->getUsedVariables();
        $template->update(['variables' => $variables]);

        return redirect()->route('template-surat.index')
            ->with('success', 'Template surat berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(TemplateSurat $templateSurat)
    {
        $kopSurat = KopSurat::where('is_active', true)->first();

        return view('layouts.admin.pengaturan.template-surat.show', compact('templateSurat', 'kopSurat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TemplateSurat $templateSurat)
    {
        $kategoris = [
            'SKTM' => 'Surat Keterangan Tidak Mampu',
            'SKU' => 'Surat Keterangan Usaha',
            'SKD' => 'Surat Keterangan Domisili',
            'SKK' => 'Surat Keterangan Kelahiran',
            'SKM' => 'Surat Keterangan Menikah',
            'SKCK' => 'Surat Keterangan Catatan Kepolisian',
            'UMUM' => 'Surat Umum',
            'UNDANGAN' => 'Surat Undangan',
            'PEMBERITAHUAN' => 'Surat Pemberitahuan',
        ];

        return view('layouts.admin.pengaturan.template-surat.edit', compact('templateSurat', 'kategoris'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TemplateSurat $templateSurat)
    {
        $request->validate([
            'nama_template' => 'required|string|max:255',
            'kategori' => 'required|string',
            'judul_surat' => 'required|string|max:255',
            'nomor_format' => 'nullable|string|max:255',
            'isi_surat' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        $templateSurat->update($request->all());

        // Auto-detect variables yang digunakan
        $variables = $templateSurat->getUsedVariables();
        $templateSurat->update(['variables' => $variables]);

        return redirect()->route('template-surat.index')
            ->with('success', 'Template surat berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TemplateSurat $templateSurat)
    {
        $templateSurat->delete();

        return redirect()->route('template-surat.index')
            ->with('success', 'Template surat berhasil dihapus');
    }

    /**
     * Preview template dengan sample data
     */
    public function preview(TemplateSurat $templateSurat, Request $request)
    {
        $kopSurat = KopSurat::where('is_active', true)->first();

        // Sample data untuk preview
        $sampleData = [
            'nama' => $request->get('nama', 'John Doe'),
            'nik' => $request->get('nik', '1234567890123456'),
            'alamat' => $request->get('alamat', 'Jl. Contoh No. 123, RT 01/RW 02'),
            'tempat_lahir' => $request->get('tempat_lahir', 'Jakarta'),
            'tanggal_lahir' => $request->get('tanggal_lahir', '01 Januari 1990'),
            'jenis_kelamin' => $request->get('jenis_kelamin', 'Laki-laki'),
            'agama' => $request->get('agama', 'Islam'),
            'pekerjaan' => $request->get('pekerjaan', 'Swasta'),
            'kewarganegaraan' => $request->get('kewarganegaraan', 'Indonesia'),
            'tanggal_surat' => $request->get('tanggal_surat', date('d F Y')),
            'nomor_urut' => $request->get('nomor_urut', '001'),
            'tahun' => $request->get('tahun', date('Y')),
            'bulan_romawi' => $request->get('bulan_romawi', 'I'),
        ];

        // Replace variables dalam template
        $processedTemplate = $templateSurat->replaceVariables($sampleData);

        return view('layouts.admin.pengaturan.template-surat.preview', compact('templateSurat', 'kopSurat', 'processedTemplate', 'sampleData'));
    }

    /**
     * Generate surat dari template
     */
    public function generate(TemplateSurat $templateSurat)
    {
        $kopSurat = KopSurat::where('is_active', true)->first();
        $variables = $templateSurat->getUsedVariables();

        return view('layouts.admin.pengaturan.template-surat.generate', compact('templateSurat', 'kopSurat', 'variables'));
    }

    /**
     * Process generate surat
     */
    public function processGenerate(Request $request, TemplateSurat $templateSurat)
    {
        $kopSurat = KopSurat::where('is_active', true)->first();

        // Validasi input berdasarkan variables yang digunakan
        $variables = $templateSurat->getUsedVariables();
        $rules = [];
        foreach ($variables as $variable) {
            $rules[$variable] = 'required|string';
        }

        $request->validate($rules);

        // Get input data
        $inputData = $request->only($variables);

        // Replace variables dalam template
        $processedTemplate = $templateSurat->replaceVariables($inputData);

        return view('layouts.admin.pengaturan.template-surat.result', compact('templateSurat', 'kopSurat', 'processedTemplate', 'inputData'));
    }

    /**
     * Toggle status aktif template
     */
    public function toggleStatus(TemplateSurat $templateSurat)
    {
        $templateSurat->update(['is_active' => ! $templateSurat->is_active]);

        $status = $templateSurat->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->back()
            ->with('success', "Template surat berhasil {$status}");
    }
}
