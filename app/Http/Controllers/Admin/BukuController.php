<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman; // <--- PASTIKAN BARIS INI ADA
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

// ... sisa kode lainnya

class BukuController extends Controller
{
    /**
     * Menampilkan daftar semua buku untuk Admin
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
    $request->validate([
        'judul'   => 'required|string|max:255',
        'penulis' => 'required|string|max:255',
        'stok'    => 'required|numeric|min:0',
        'cover'   => 'required|image|mimes:jpeg,png,jpg,webp|max:2048', 
    ]);

    // Mengambil semua data input kecuali cover
    $data = $request->except('cover');

    if ($request->hasFile('cover')) {
        $file = $request->file('cover');
        $nama_file = time() . "_" . str_replace(' ', '_', $file->getClientOriginalName());
        
        // Pindahkan file ke public/covers
        $file->move(public_path('covers'), $nama_file); 
        
        // Masukkan nama file ke dalam array $data
        $data['cover'] = $nama_file;
    }

    // Sekarang kolom 'cover' sudah bisa disimpan karena sudah ada di fillable Model
    Buku::create($data);

    return redirect()->route('admin.buku.index')->with('success', 'Buku baru berhasil ditambahkan!');
}

    /**
     * Menampilkan form edit
     */
    public function edit($id)
    {
        // Mencari berdasarkan Primary Key 'kode_buku'
        $buku = Buku::where('kode_buku', $id)->firstOrFail();
        return view('admin.buku.edit', compact('buku'));
    }

    /**
     * Memperbarui data buku
     */
    public function update(Request $request, $id)
    {
        $buku = Buku::where('kode_buku', $id)->firstOrFail();

        $validated = $request->validate([
            'judul'        => 'required|string|max:255',
            'penulis'      => 'required|string|max:255',
            'kategori'     => 'nullable|string|max:100',
            'stok'         => 'required|numeric|min:0',
            'tahun_terbit' => 'required|digits:4',
            'cover'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('cover')) {
            // Hapus file cover lama jika ada di folder
            if ($buku->cover && File::exists(public_path('covers/' . $buku->cover))) {
                File::delete(public_path('covers/' . $buku->cover));
            }

            $file = $request->file('cover');
            $nama_file = time() . "_" . str_replace(' ', '_', $file->getClientOriginalName());
            $file->move(public_path('covers'), $nama_file);
            $validated['cover'] = $nama_file;
        }

        $buku->update($validated);

        return redirect()->route('admin.buku.index')->with('success', 'Informasi buku berhasil diperbarui!');
    }

    /**
     * Menghapus buku
     */
    public function destroy($id)
    {
        $buku = Buku::where('kode_buku', $id)->firstOrFail();
        
        // Hapus file fisik cover agar folder public/covers tidak penuh sampah
        if ($buku->cover && File::exists(public_path('covers/' . $buku->cover))) {
            File::delete(public_path('covers/' . $buku->cover));
        }

        $buku->delete();
        return redirect()->route('admin.buku.index')->with('success', 'Buku telah dihapus dari sistem.');
    }

    /**
     * FUNGSI PINJAM BUKU (KHUSUS ANGGOTA/SISWA)
     */
public function pinjam(Request $request, $id)
{
    // Cari buku berdasarkan kode_buku
    $buku = Buku::where('kode_buku', $id)->firstOrFail();

    // 1. Cek stok
    if ($buku->stok <= 0) {
        return back()->with('error', 'Maaf, stok buku ini sedang habis!');
    }

    // 2. Validasi & Konversi Durasi ke Angka (Integer)
    $request->validate([
        'durasi' => 'required|integer|min:1|max:14',
    ]);

    $durasi = (int) $request->durasi; // Paksa jadi angka biar Carbon gak error

    // 3. Simpan data peminjaman ke tabel
    Peminjaman::create([
        'user_id'             => Auth::user()->pengenal, 
        'buku_id'             => $buku->kode_buku,
        'tanggal_pinjam'      => now(),
        'durasi_hari'         => $durasi,
        'tanggal_jatuh_tempo' => now()->addDays($durasi), // Sekarang aman karena sudah jadi int
        'status'              => 'menunggu'
    ]);

    // 4. Kurangi stok buku secara otomatis
    $buku->decrement('stok');

    return redirect()->route('anggota.dashboard')->with('success', 'Permintaan terkirim! Silakan tunggu verifikasi admin.');
}
}