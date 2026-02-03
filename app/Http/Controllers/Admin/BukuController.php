<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    // Menampilkan daftar semua buku
    public function index()
    {
        $semua_buku = Buku::all();
        return view('admin.buku.index', compact('semua_buku'));
    }

    // Menampilkan form tambah buku
    public function create()
    {
        return view('admin.buku.create');
    }

    // Menyimpan buku baru ke database
   public function store(Request $request)
{
    // 1. Validasi
    $validated = $request->validate([
        'judul' => 'required',
        'penulis' => 'required',
        'kategori' => 'nullable',
        'stok' => 'required|numeric',
        'tahun_terbit' => 'required|digits:4',
    ]);

    // 2. Simpan
    Buku::create($validated);

    // 3. Balik ke halaman index dengan pesan sukses
    return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil ditambahkan!');
}

    // Menampilkan form edit
public function edit($id)
{
    $buku = Buku::findOrFail($id);
    return view('admin.buku.edit', compact('buku'));
}

// Memperbarui data ke database
public function update(Request $request, $id)
{
    $request->validate([
        'judul' => 'required',
        'penulis' => 'required',
        'kategori' => 'required',
        'stok' => 'required|numeric',
    ]);

    $buku = Buku::findOrFail($id);
    $buku->update($request->all());

    return redirect()->route('admin.buku.index')->with('success', 'Data buku berhasil diperbarui!');
}

// Menghapus buku
public function destroy($id)
{
    $buku = Buku::findOrFail($id);
    $buku->delete();

    return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil dihapus!');
}
}