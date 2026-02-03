<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    /**
     * Menampilkan daftar semua buku
     */
    public function index()
    {
        $semua_buku = Buku::all();
        return view('admin.buku.index', compact('semua_buku'));
    }

    /**
     * Menampilkan form tambah buku
     */
    public function create()
    {
        return view('admin.buku.create');
    }

    /**
     * Menyimpan buku baru ke database
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $validated = $request->validate([
            'judul'        => 'required|string|max:255',
            'penulis'      => 'required|string|max:255',
            'kategori'     => 'nullable|string|max:100',
            'stok'         => 'required|numeric|min:0',
            'tahun_terbit' => 'required|digits:4',
        ]);

        // 2. Simpan ke Database
        Buku::create($validated);

        // 3. Redirect dengan pesan sukses
        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil ditambahkan ke koleksi!');
    }

    /**
     * Menampilkan form edit berdasarkan kode_buku
     */
    public function edit($kode_buku)
    {
        // Mencari data menggunakan kode_buku (Primary Key kustom)
        $buku = Buku::where('kode_buku', $kode_buku)->firstOrFail();
        return view('admin.buku.edit', compact('buku'));
    }

    /**
     * Memperbarui data buku di database
     */
    public function update(Request $request, $kode_buku)
    {
        // 1. Cari data buku
        $buku = Buku::where('kode_buku', $kode_buku)->firstOrFail();

        // 2. Validasi Input (Pastikan tahun_terbit disertakan)
        $validated = $request->validate([
            'judul'        => 'required|string|max:255',
            'penulis'      => 'required|string|max:255',
            'kategori'     => 'nullable|string|max:100',
            'stok'         => 'required|numeric|min:0',
            'tahun_terbit' => 'required|digits:4',
        ]);

        // 3. Update data
        $buku->update($validated);

        return redirect()->route('admin.buku.index')->with('success', 'Data buku berhasil diperbarui!');
    }

    /**
     * Menghapus buku dari database
     */
    public function destroy($kode_buku)
    {
        // Cari dan hapus
        $buku = Buku::where('kode_buku', $kode_buku)->firstOrFail();
        $buku->delete();

        return redirect()->route('admin.buku.index')->with('success', 'Buku telah berhasil dihapus!');
    }
}