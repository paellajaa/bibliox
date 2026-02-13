<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    /**
     * SISI ADMIN: Menampilkan daftar permintaan (Pinjam, Kembali, & Denda)
     */
    public function index()
    {
        // Mengambil data yang butuh tindakan Admin
        $permintaan = Peminjaman::with(['user', 'buku'])
            ->whereIn('status', ['menunggu', 'proses_kembali', 'dipinjam', 'rusak'])
            ->latest()
            ->get();

        return view('admin.peminjaman.index', compact('permintaan'));
    }

    /**
     * SISI ADMIN: Menyetujui Peminjaman Baru
     */
    public function setujui($id)
    {
        $pinjam = Peminjaman::findOrFail($id);
        
        $pinjam->update([
            'status' => 'dipinjam',
            'tanggal_pinjam' => now(),
            'tanggal_jatuh_tempo' => now()->addDays($pinjam->durasi_hari)
        ]);

        return back()->with('success', 'Peminjaman telah disetujui! Buku resmi dipinjam.');
    }

    /**
     * SISI ADMIN: Menolak Peminjaman Baru
     */
    public function tolak($id)
    {
        $pinjam = Peminjaman::findOrFail($id);
        
        // Kembalikan stok karena batal pinjam
        $buku = Buku::where('kode_buku', $pinjam->buku_id)->first();
        if ($buku) {
            $buku->increment('stok');
        }

        $pinjam->update(['status' => 'ditolak']);
        
        return back()->with('success', 'Permintaan ditolak dan stok buku telah dikembalikan.');
    }

    /**
     * SISI SISWA: Mengajukan pengembalian (Lapor Kondisi)
     */
    public function ajukanPengembalian(Request $request, $id)
    {
        $request->validate([
            'catatan_siswa' => 'required|string|max:255',
        ]);

        $pinjam = Peminjaman::findOrFail($id);
        
        $pinjam->update([
            'status' => 'proses_kembali',
            'catatan_siswa' => $request->catatan_siswa
        ]);

        return back()->with('success', 'Laporan pengembalian dikirim! Silakan serahkan buku fisik ke Pustakawan.');
    }

    /**
     * SISI ADMIN: Verifikasi Akhir Pengembalian (Cek Kondisi & Denda)
     */
public function verifikasiKembali(Request $request, $id)
{
    $peminjaman = Peminjaman::findOrFail($id);

    // 1. Tangkap catatan dari request dan simpan ke database
    // Pastikan nama kolom di database sesuai (misal: 'catatan' atau 'keterangan')
    $peminjaman->status = 'dikembalikan';
    $peminjaman->catatan = $request->catatan; // Ini kuncinya!
    $peminjaman->save();

    // 2. Tambahkan stok buku kembali
    $buku = Buku::where('kode_buku', $peminjaman->buku_id)->first();
    if($buku) {
        $buku->increment('stok');
    }

    return back()->with('success', 'Buku berhasil diverifikasi kembali!');
}

    /**
     * SISI ADMIN: Konfirmasi Pembayaran Denda
     */
    public function bayarDenda($id)
    {
        $pinjam = Peminjaman::findOrFail($id);

        // Update status ke 'kembali' dan reset denda jadi 0 (karena sudah bayar)
        $pinjam->update([
            'status' => 'kembali',
            'total_denda' => 0,
            'catatan_admin' => $pinjam->catatan_admin . ' | LUNAS PADA ' . now()->format('d/m/Y H:i')
        ]);

        return back()->with('success', 'Pembayaran denda berhasil dikonfirmasi! Status siswa sudah bersih.');
    }

    /**
     * SISI ANGGOTA: Daftar buku saya
     */
    public function bukuSaya()
    {
        // Variabel harus $peminjaman agar cocok dengan @forelse($peminjaman as $p)
        $peminjaman = Peminjaman::with('buku')
            ->where('user_id', Auth::user()->pengenal)
            ->latest()
            ->get();

        return view('anggota.buku-saya', compact('peminjaman'));
    }
}