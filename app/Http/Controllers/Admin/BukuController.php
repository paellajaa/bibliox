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
    public function store(Request $request) {
    $request->validate([
        'judul' => 'required',
        'cover' => 'image|mimes:jpeg,png,jpg|max:2048', // Validasi foto
    ]);

    $data = $request->all();

    if ($request->hasFile('cover')) {
        $file = $request->file('cover');
        $nama_file = time() . "_" . $file->getClientOriginalName();
        $file->move(public_path('covers'), $nama_file); // Simpan ke folder public/covers
        $data['cover'] = $nama_file;
    }

    Buku::create($data);
    return redirect()->route('admin.buku.index');
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
    // 1. Cari bukunya
    $buku = Buku::where('kode_buku', $kode_buku)->firstOrFail();

    // 2. (Opsional) Cek apakah sedang dipinjam? 
    // Jika ada sistem denda, pastikan buku tidak sedang dalam status dipinjam
    
    // 3. Hapus buku
    $buku->delete();

    // 4. Kembali dengan pesan sukses
    return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil dihapus dari sistem!');
}
}