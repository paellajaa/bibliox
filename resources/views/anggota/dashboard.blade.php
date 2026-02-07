@extends('layouts.admin') 

@section('content')
<div class="space-y-8 animate-fadeIn">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-black text-white italic uppercase tracking-tighter">Halo, {{ Auth::user()->nama }}! 👋</h2>
            <p class="text-cyan-100/50">Siap menjelajahi dunia pengetahuan hari ini?</p>
        </div>
        <div class="relative group">
            <input type="text" placeholder="Cari judul buku..." class="bg-[#1e293b] border border-cyan-900/30 text-white text-sm rounded-2xl px-6 py-3 w-64 focus:outline-none focus:border-cyan-500 transition-all">
            <span class="absolute right-4 top-3 text-cyan-900 group-hover:text-cyan-500">🔍</span>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-gradient-to-br from-cyan-600 to-blue-700 p-6 rounded-3xl shadow-xl">
            <p class="text-white/70 text-[10px] font-bold uppercase tracking-widest">Sedang Dipinjam</p>
            <h3 class="text-4xl font-black text-white mt-2">{{ $buku_dipinjam ?? 0 }} <span class="text-sm font-medium italic">Buku</span></h3>
        </div>
        <div class="bg-[#1e293b] border border-cyan-900/30 p-6 rounded-3xl">
            <p class="text-cyan-100/50 text-[10px] font-bold uppercase tracking-widest">Sisa Hari</p>
            <h3 class="text-4xl font-black text-orange-400 mt-2">--</h3>
        </div>
        <div class="bg-[#1e293b] border border-cyan-900/30 p-6 rounded-3xl">
            <p class="text-cyan-100/50 text-[10px] font-bold uppercase tracking-widest">Denda</p>
            <h3 class="text-4xl font-black text-red-400 mt-2">Rp 0</h3>
        </div>
        <div class="bg-[#1e293b] border border-cyan-900/30 p-6 rounded-3xl">
            <p class="text-cyan-100/50 text-[10px] font-bold uppercase tracking-widest">Katalog</p>
            <h3 class="text-4xl font-black text-white mt-2">{{ $total_katalog ?? 0 }}</h3>
        </div>
    </div>

    <div class="flex items-center justify-between border-b border-cyan-900/30 pb-4">
        <h3 class="text-xl font-bold text-white italic uppercase tracking-wider">Koleksi Terbaru</h3>
        <select class="bg-transparent text-cyan-500 text-xs font-bold focus:outline-none">
            <option>Semua Kategori</option>
            <option>Sains</option>
            <option>Novel</option>
        </select>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
        @forelse($all_books as $buku)
        <div class="group bg-[#1e293b] p-4 rounded-3xl border border-cyan-900/30 hover:border-cyan-500 transition-all duration-500">
            <div class="aspect-[3/4] bg-[#0f172a] rounded-2xl mb-4 overflow-hidden relative shadow-inner">
                @if($buku->cover)
                    <img src="{{ asset('covers/' . $buku->cover) }}" 
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                         alt="{{ $buku->judul }}"
                         onerror="this.onerror=null;this.src='https://placehold.co/400x600/0f172a/0891b2?text=No+Cover';">
                @else
                    <div class="w-full h-full flex items-center justify-center text-cyan-900/20 font-black text-4xl italic uppercase">
                        BiblioX
                    </div>
                @endif
                
                <div class="absolute top-2 right-2 px-3 py-1 bg-black/50 backdrop-blur-md rounded-lg text-[10px] font-bold text-cyan-400">
                    {{ $buku->stok > 0 ? 'Tersedia' : 'Kosong' }}
                </div>
            </div>

            <h4 class="text-white font-bold truncate text-sm">{{ $buku->judul }}</h4>
            <p class="text-cyan-100/50 text-[10px] mb-4 font-medium italic">Oleh: {{ $buku->penulis }}</p>
            
            <form action="{{ route('buku.pinjam', $buku->kode_buku) }}" method="POST">
                @csrf
                <button type="submit" 
                        {{ $buku->stok <= 0 ? 'disabled' : '' }}
                        class="w-full py-2.5 {{ $buku->stok > 0 ? 'bg-cyan-600/10 text-cyan-500 hover:bg-cyan-600 hover:text-white' : 'bg-red-500/10 text-red-500 cursor-not-allowed' }} rounded-xl text-[10px] font-black transition-all uppercase tracking-widest">
                    {{ $buku->stok > 0 ? 'Pinjam Buku' : 'Stok Habis' }}
                </button>
            </form>
        </div>
        @empty
        <div class="col-span-full py-20 text-center">
            <p class="text-cyan-100/30 italic font-medium">Belum ada koleksi buku yang tersedia di perpustakaan.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection