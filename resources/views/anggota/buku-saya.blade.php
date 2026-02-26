@extends('layouts.admin')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="space-y-6 animate-fadeIn" x-data="{ openReturn: false, pinjamId: '', bukuJudul: '' }">
    <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-black text-slate-900 uppercase italic tracking-tighter">Koleksi Buku Saya</h2>
            <p class="text-slate-500 font-bold text-sm">Pantau status pinjaman dan tagihan denda kamu di sini.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-emerald-500 text-white px-6 py-4 rounded-2xl shadow-lg flex items-center gap-3 animate-bounce">
            <i class="fas fa-check-circle"></i>
            <p class="font-bold text-sm">{{ session('success') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($peminjaman as $p)
        <div class="bg-white p-6 rounded-[2.5rem] border border-slate-100 shadow-sm flex flex-col gap-4 relative overflow-hidden group hover:border-cyan-500 transition-all duration-300">
            
            <div class="absolute top-0 right-0 px-6 py-2 rounded-bl-3xl font-black text-[10px] uppercase tracking-widest z-10
                {{ $p->status == 'dipinjam' ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-100' : '' }}
                {{ $p->status == 'menunggu' ? 'bg-orange-400 text-white shadow-lg shadow-orange-100' : '' }}
                {{ $p->status == 'proses_kembali' ? 'bg-cyan-500 text-white shadow-lg shadow-cyan-100' : '' }}
                {{ $p->status == 'ditolak' ? 'bg-red-500 text-white shadow-lg shadow-red-100' : '' }}
                {{ $p->status == 'kembali' ? 'bg-slate-900 text-white' : '' }}
                {{ $p->status == 'rusak' ? 'bg-red-600 text-white' : '' }}">
                {{ str_replace('_', ' ', $p->status) }}
            </div>

            <div class="flex gap-5 items-start pt-4">
                <div class="w-24 h-32 bg-slate-100 rounded-2xl overflow-hidden flex-shrink-0 shadow-inner group-hover:scale-105 transition-transform duration-500">
                    <img src="{{ asset('covers/' . ($p->buku->cover ?? '')) }}" class="w-full h-full object-cover" onerror="this.src='https://placehold.co/200x300?text=No+Cover'">
                </div>
                <div class="flex-1">
                    <h4 class="font-black text-slate-900 leading-tight uppercase text-sm mb-1 truncate w-40">{{ $p->buku->judul ?? 'Buku Dihapus' }}</h4>
                    <p class="text-[10px] text-slate-400 font-bold mb-4 italic">Oleh: {{ $p->buku->penulis ?? '-' }}</p>
                    
                    @if($p->status == 'dipinjam')
                        <div class="bg-emerald-50 p-3 rounded-2xl border border-emerald-100">
                            <p class="text-[8px] text-emerald-600 font-black uppercase mb-1">Batas Kembali:</p>
                            <p class="text-xs font-black text-emerald-700">{{ \Carbon\Carbon::parse($p->tanggal_jatuh_tempo)->translatedFormat('d F Y') }}</p>
                        </div>
                        <button @click="openReturn = true; pinjamId = '{{ $p->id }}'; bukuJudul = '{{ $p->buku->judul }}'" 
                                class="w-full mt-4 py-3 bg-slate-900 text-white rounded-2xl font-black text-[9px] uppercase tracking-widest hover:bg-cyan-600 transition-all">
                            Kembalikan Buku
                        </button>

                    @elseif($p->status == 'rusak')
                        <div class="bg-red-50 p-4 rounded-3xl border-2 border-red-100 relative overflow-hidden">
                            <p class="text-[9px] text-red-600 font-black uppercase tracking-widest mb-1">Total Denda:</p>
                            <p class="text-xl font-black text-red-700 leading-none">Rp {{ number_format($p->total_denda, 0, ',', '.') }}</p>
                            
                            <div class="mt-3 pt-3 border-t border-red-100">
                                <p class="text-[9px] text-red-500 font-bold italic mb-3 leading-tight">
                                    Catatan: "{{ $p->catatan_admin ?? 'Buku rusak/hilang' }}"
                                </p>
                                <button onclick="showPayInfo('{{ number_format($p->total_denda, 0, ',', '.') }}')" 
                                        class="w-full py-2.5 bg-red-600 text-white rounded-xl font-black text-[8px] uppercase tracking-widest shadow-lg shadow-red-100 hover:opacity-90 transition-all">
                                    Cara Bayar
                                </button>
                            </div>
                        </div>

                    @elseif($p->status == 'menunggu')
                        <div class="bg-orange-50 p-4 rounded-2xl border border-orange-100 italic text-center">
                            <p class="text-[10px] text-orange-600 font-bold leading-relaxed">Menunggu persetujuan admin...</p>
                        </div>

                    @elseif($p->status == 'proses_kembali')
                        <div class="bg-cyan-50 p-4 rounded-2xl border border-cyan-100 italic text-center">
                            <p class="text-[10px] text-cyan-600 font-bold leading-relaxed">Sedang diperiksa admin...</p>
                        </div>

                    @elseif($p->status == 'kembali')
                        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 text-center">
                            <p class="text-[10px] text-slate-400 font-black uppercase italic tracking-widest">Selesai Dikembalikan</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-20 text-center bg-white rounded-[3rem] border-2 border-dashed border-slate-100">
            <p class="text-slate-400 font-black uppercase tracking-widest italic">Kamu belum meminjam buku apapun.</p>
            <a href="{{ route('anggota.dashboard') }}" class="inline-block mt-4 px-8 py-3 bg-cyan-600 text-white rounded-2xl font-black uppercase text-[10px] tracking-widest shadow-lg shadow-cyan-100">Cari Buku Sekarang →</a>
        </div>
        @endforelse
    </div>

    {{-- MODAL KEMBALI --}}
    <div x-show="openReturn" 
         class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4" 
         x-transition.opacity x-cloak>
        
        <div @click.away="openReturn = false" 
             class="bg-white rounded-[3rem] p-10 w-full max-w-md shadow-2xl transform transition-all">
            
            <div class="text-center mb-8">
                <div class="w-20 h-20 bg-orange-50 text-orange-500 rounded-3xl flex items-center justify-center text-3xl mx-auto mb-6 shadow-inner">
                    <i class="fas fa-box"></i>
                </div>
                <h3 class="text-2xl font-black text-slate-900 uppercase italic tracking-tighter leading-none">Kembalikan Buku</h3>
                <p class="text-slate-400 text-sm font-bold mt-2" x-text="bukuJudul"></p>
            </div>
            
            <form :action="`/anggota/buku-saya/ajukan-kembali/${pinjamId}`" method="POST">
                @csrf
                <div class="mb-8">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">
                        Laporkan kondisi buku saat ini:
                    </label>
                    <textarea name="catatan_siswa" required rows="3"
                        class="w-full bg-slate-50 border-2 border-slate-100 rounded-3xl px-6 py-4 text-sm font-bold text-slate-700 focus:outline-none focus:border-orange-500 transition-all shadow-inner"
                        placeholder="Contoh: Buku mulus bang, nggak ada yang sobek..."></textarea>
                </div>

                <div class="flex gap-4">
                    <button type="button" @click="openReturn = false" 
                            class="flex-1 py-5 bg-slate-100 text-slate-500 rounded-2xl font-black text-[11px] uppercase tracking-widest">
                        Batal
                    </button>
                    <button type="submit" 
                            class="flex-1 py-5 bg-orange-500 text-white rounded-2xl font-black text-[11px] uppercase tracking-widest shadow-xl shadow-orange-100 hover:bg-orange-600 transition-all">
                        Kirim Laporan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function showPayInfo(jumlah) {
        Swal.fire({
            title: 'INFO PEMBAYARAN',
            html: `
                <div class="text-center p-2">
                    <p class="text-slate-500 font-bold text-sm mb-4">Total denda yang harus dibayar:</p>
                    <div class="bg-slate-900 text-white py-4 rounded-3xl mb-6 shadow-xl shadow-blue-100">
                        <span class="text-xs font-bold block uppercase tracking-widest opacity-60">Rp</span>
                        <span class="text-3xl font-black italic tracking-tighter">${jumlah}</span>
                    </div>
                    
                    <div class="bg-blue-50 border-2 border-blue-100 rounded-[2rem] p-6 text-left">
                        <p class="text-[10px] font-black text-blue-400 uppercase tracking-widest mb-3">Metode Transfer:</p>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-xs font-black text-slate-700">Bank BCA</span>
                                <span class="text-xs font-bold text-blue-600 tracking-wider">123456789</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-xs font-black text-slate-700">DANA / OVO</span>
                                <span class="text-xs font-bold text-blue-600 tracking-wider">08123456789</span>
                            </div>
                        </div>
                    </div>
                    <p class="mt-6 text-[9px] font-bold text-slate-400 italic">*Silakan bawa bukti transfer atau bayar tunai langsung ke meja Pustakawan BIBLIOX.</p>
                </div>
            `,
            showConfirmButton: true,
            confirmButtonText: 'SAYA MENGERTI',
            confirmButtonColor: '#2563eb', // Warna Biru Primary Web Kamu
            background: '#ffffff',
            padding: '2rem',
            borderRadius: '3rem',
            customClass: {
                title: 'text-2xl font-black text-slate-900 tracking-tighter italic uppercase',
                popup: 'rounded-[3rem]',
                confirmButton: 'rounded-2xl px-10 py-4 font-black text-[10px] tracking-widest'
            }
        });
    }
</script>

<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection