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
        // Menampilkan yang statusnya menunggu, proses_kembali, sedang dipinjam, atau rusak (ada denda)
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
        $request->validate([
            'kondisi' => 'required|in:bagus,rusak,hilang',
            'denda' => 'nullable|numeric|min:0',
            'catatan_admin' => 'nullable|string',
        ]);

        $pinjam = Peminjaman::findOrFail($id);
        $buku = Buku::where('kode_buku', $pinjam->buku_id)->first();

        // Jika bagus status jadi 'kembali', jika rusak/hilang status jadi 'rusak' (tagihan denda)
        $statusAkhir = ($request->kondisi == 'bagus') ? 'kembali' : 'rusak';

        $pinjam->update([
            'status' => $statusAkhir,
            'tanggal_kembali' => now(),
            'total_denda' => $request->denda ?? 0,
            'catatan_admin' => $request->catatan_admin,
        ]);

        // Stok bertambah jika buku ada fisiknya (Bagus atau Rusak). Jika Hilang stok tidak nambah.
        if ($request->kondisi !== 'hilang' && $buku) {
            $buku->increment('stok');
        }

        $pesan = ($statusAkhir == 'rusak') ? 'Buku diterima dengan tagihan denda.' : 'Buku kembali dengan selamat.';
        return back()->with('success', $pesan);
    }

    /**
     * SISI ADMIN: Konfirmasi Pembayaran Denda
     */
    public function bayarDenda($id)
    {
        $pinjam = Peminjaman::findOrFail($id);

        // Update status ke 'kembali' (Lunas)
        $pinjam->update([
            'status' => 'kembali',
            'catatan_admin' => $pinjam->catatan_admin . ' | LUNAS PADA ' . now()->format('d/m/Y H:i')
        ]);

        return back()->with('success', 'Pembayaran denda berhasil dikonfirmasi! Status siswa sudah bersih.');
    }

    /**
     * SISI ANGGOTA: Daftar buku saya
     */
    public function bukuSaya()
    {
        $peminjaman = Peminjaman::with('buku')
            ->where('user_id', Auth::user()->pengenal)
            ->latest()
            ->get();

        return view('anggota.buku-saya', compact('peminjaman'));
    }
}