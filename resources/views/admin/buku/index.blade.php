@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-8">
    <div>
        <h3 class="text-2xl font-bold text-cyan-100">Daftar Koleksi BIBLIOX</h3>
        <p class="text-cyan-400/60 text-sm italic">Kelola semua buku yang tersedia di perpustakaan</p>
    </div>
    <a href="{{ route('admin.buku.create') }}" class="bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-400 hover:to-blue-500 text-white px-5 py-2.5 rounded-xl font-bold transition shadow-lg shadow-cyan-500/20">
        + Tambah Buku
    </a>
</div>

<div class="bg-[#1e293b] rounded-2xl border border-cyan-900/30 overflow-hidden shadow-2xl">
    <table class="w-full text-left">
        <thead class="bg-[#0f172a]/50 text-cyan-400 text-sm uppercase tracking-wider">
            <tr>
                <th class="p-5 border-b border-cyan-900/30">Judul & Penulis</th>
                <th class="p-5 border-b border-cyan-900/30">Kategori</th>
                <th class="p-5 border-b border-cyan-900/30 text-center">Tahun</th>
                <th class="p-5 border-b border-cyan-900/30 text-center">Stok</th>
                <th class="p-5 border-b border-cyan-900/30 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="text-cyan-100/80 divide-y divide-cyan-900/10">
            @forelse($semua_buku as $b)
            <tr class="hover:bg-cyan-500/5 transition group">
                <td class="p-5">
                    <div class="font-bold text-cyan-100 group-hover:text-cyan-400 transition">{{ $b->judul }}</div>
                    <div class="text-xs text-cyan-100/40">{{ $b->penulis }}</div>
                </td>
                <td class="p-5">
                    <span class="bg-cyan-900/30 text-cyan-400 text-[10px] px-2 py-1 rounded-md border border-cyan-500/20">
                        {{ $b->kategori }}
                    </span>
                </td>
                <td class="p-5 text-center text-sm italic">{{ $b->tahun_terbit }}</td>
                <td class="p-5 text-center font-mono">{{ $b->stok }}</td>
                <td class="p-5 text-right space-x-2">
                    <button class="text-cyan-400 hover:text-cyan-300 transition">Edit</button>
                    <button class="text-red-400 hover:text-red-300 transition">Hapus</button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="p-10 text-center text-cyan-100/30 italic">
                    Belum ada koleksi buku. Klik "Tambah Buku" untuk memulai.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection