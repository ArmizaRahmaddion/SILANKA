<?php

namespace App\Http\Controllers;

use App\Models\PerangkatNagari;
use Illuminate\Http\Request;

class PerangkatNagariController extends Controller
{
    public function index()
    {
        $perangkat = PerangkatNagari::get();

        return view('layouts.admin.perangkat-nagari.perangkat-list', compact('perangkat'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'nullable|string|max:100',
            'jabatan' => 'required|string|max:255',
            'kontak' => 'nullable|string|max:100',
            'facebook' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only([
            'nama',
            'nip',
            'jabatan',
            'kontak',
            'facebook',
            'instagram',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('perangkat', 'public');
        }

        PerangkatNagari::create($data);

        return redirect()->back()->with('success', 'Perangkat berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50',
            'jabatan' => 'required|string|max:255',
            'kontak' => 'nullable|string|max:100',
            'facebook' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // max 2MB
        ]);

        $perangkat = PerangkatNagari::findOrFail($id);

        $perangkat->nama = $request->nama;
        $perangkat->nip = $request->nip;
        $perangkat->jabatan = $request->jabatan;
        $perangkat->kontak = $request->kontak;
        $perangkat->facebook = $request->facebook;
        $perangkat->instagram = $request->instagram;

        if ($request->hasFile('image')) {

            if ($perangkat->image && file_exists(storage_path('app/public/'.$perangkat->image))) {
                unlink(storage_path('app/public/'.$perangkat->image));
            }

            $imagePath = $request->file('image')->store('perangkat_images', 'public');
            $perangkat->image = $imagePath;
        }

        $perangkat->save();

        return redirect()->route('perangkat.index')->with('success', 'Data perangkat berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // Cari perangkat berdasarkan ID, kalau tidak ditemukan otomatis 404
        $perangkat = PerangkatNagari::findOrFail($id);

        // Jika ada foto, hapus filenya dari storage/public
        if ($perangkat->image && file_exists(storage_path('app/public/'.$perangkat->image))) {
            unlink(storage_path('app/public/'.$perangkat->image));
        }

        // Hapus data perangkat dari database
        $perangkat->delete();

        // Redirect kembali ke index dengan pesan sukses
        return redirect()->route('perangkat.index')->with('success', 'Data perangkat berhasil dihapus.');
    }
}
