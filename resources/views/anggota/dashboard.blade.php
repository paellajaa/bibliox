@extends('layouts.admin') 

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="space-y-8 animate-fadeIn" x-data="{ openModal: false, bukuId: '', bukuJudul: '' }">
    
    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="bg-emerald-500 text-white px-6 py-4 rounded-[1.5rem] shadow-lg shadow-emerald-100 flex items-center gap-3 animate-bounce">
            <i class="fas fa-check-circle text-xl"></i>
            <p class="font-bold text-sm">{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-500 text-white px-6 py-4 rounded-[1.5rem] shadow-lg shadow-red-100 flex items-center gap-3">
            <i class="fas fa-exclamation-circle text-xl"></i>
            <p class="font-bold text-sm">{{ session('error') }}</p>
        </div>
    @endif

    {{-- Header & Search Bar (FIXED) --}}
    <div class="bg-white p-10 rounded-[3rem] border border-slate-100 shadow-sm flex flex-col lg:flex-row lg:items-center justify-between gap-8 relative overflow-hidden">
        <div class="relative z-10">
            <h2 class="text-4xl font-black text-slate-900 italic uppercase tracking-tighter leading-tight">
                Halo, {{ Auth::user()->nama }}!
            </h2>
            <p class="text-slate-400 font-bold text-lg mt-1">Cari inspirasi bacaanmu hari ini.</p>
        </div>

        {{-- Form Pencarian dengan GET Method --}}
        <form action="{{ route('anggota.dashboard') }}" method="GET" class="relative w-full lg:w-[450px] z-10 flex gap-2">
            {{-- Hidden input kategori agar pencarian tetap berada dalam kategori yang dipilih --}}
            @if(request('kategori'))
                <input type="hidden" name="kategori" value="{{ request('kategori') }}">
            @endif

            <div class="relative w-full">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari judul atau penulis..." 
                       class="w-full pl-14 pr-6 py-5 bg-slate-50 border-2 border-slate-100 rounded-[2rem] text-sm font-bold focus:outline-none focus:border-cyan-500 focus:bg-white transition-all shadow-inner">
                <i class="fas fa-search absolute left-5 top-1/2 -translate-y-1/2 text-slate-400"></i>
            </div>
            <button type="submit" class="px-8 py-5 bg-slate-900 text-white rounded-[2rem] font-black text-[10px] uppercase tracking-widest hover:bg-cyan-600 transition-all shadow-lg shadow-slate-200">
                Cari
            </button>
        </form>
        
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-cyan-50 rounded-full opacity-50"></div>
    </div>

    {{-- Filter Kategori Dinamis (FIXED) --}}
    <div class="flex flex-col gap-4">
        <div class="flex items-center gap-2 px-2">
            <i class="fas fa-tags text-cyan-600"></i>
            <span class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Pilih Kategori</span>
        </div>
        
        <div class="flex flex-wrap items-center gap-3">
            {{-- Tombol Semua Koleksi --}}
            <a href="{{ route('anggota.dashboard') }}" 
               class="px-8 py-3 rounded-2xl font-black text-[10px] uppercase tracking-widest transition-all duration-300
               {{ !request('kategori') ? 'bg-slate-900 text-white shadow-xl shadow-slate-200 -translate-y-1' : 'bg-white text-slate-500 border border-slate-100 hover:bg-slate-50' }}">
                Semua Koleksi
            </a>

            {{-- Menampilkan Kategori secara Otomatis dari Database --}}
            @php
                $daftarKategori = \App\Models\Buku::whereNotNull('kategori')->distinct()->pluck('kategori');
            @endphp

            @foreach($daftarKategori as $kat)
                <a href="{{ route('anggota.dashboard', ['kategori' => $kat, 'search' => request('search')]) }}" 
                   class="px-8 py-3 rounded-2xl font-black text-[10px] uppercase tracking-widest transition-all duration-300
                   {{ request('kategori') == $kat ? 'bg-cyan-600 text-white shadow-xl shadow-cyan-100 -translate-y-1' : 'bg-white text-slate-500 border border-slate-100 hover:bg-slate-50' }}">
                    {{ $kat }}
                </a>
            @endforeach
        </div>
    </div>

    {{-- Grid Buku --}}
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-8">
        @forelse($all_books as $buku)
        <div class="group bg-white p-5 rounded-[2.8rem] border border-slate-100 shadow-sm hover:shadow-2xl hover:shadow-cyan-100/50 hover:border-cyan-200 transition-all duration-500">
            <div class="aspect-[3/4] bg-slate-50 rounded-[2.2rem] mb-6 overflow-hidden relative shadow-inner">
                @if($buku->cover)
                    <img src="{{ asset('covers/' . $buku->cover) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                @else
                    <div class="w-full h-full flex items-center justify-center text-slate-200 font-black text-2xl italic uppercase bg-slate-50">BiblioX</div>
                @endif
                
                <div class="absolute top-4 left-4 px-3 py-1.5 bg-white/90 backdrop-blur-md rounded-full text-[8px] font-black uppercase text-cyan-700 shadow-sm">
                    {{ $buku->kategori ?? 'Umum' }}
                </div>

                <div class="absolute top-4 right-4 px-3 py-1.5 bg-white/90 backdrop-blur-md rounded-xl text-[9px] font-black {{ $buku->stok > 0 ? 'text-emerald-600' : 'text-red-500' }} shadow-sm">
                    <i class="fas fa-circle text-[6px] mr-1"></i> {{ $buku->stok > 0 ? 'Tersedia' : 'Habis' }}
                </div>
            </div>

            <div class="px-2">
                <h4 class="text-slate-900 font-black truncate text-sm mb-1 uppercase tracking-tight group-hover:text-cyan-600 transition-colors">{{ $buku->judul }}</h4>
                <p class="text-slate-400 text-[10px] mb-6 font-bold italic">Oleh: {{ $buku->penulis }}</p>
                
                <button @click="openModal = true; bukuId = '{{ $buku->kode_buku }}'; bukuJudul = '{{ $buku->judul }}'"
                        {{ $buku->stok <= 0 ? 'disabled' : '' }}
                        class="w-full py-4 {{ $buku->stok > 0 ? 'bg-slate-900 text-white hover:bg-cyan-600 hover:shadow-lg hover:shadow-cyan-200' : 'bg-slate-100 text-slate-400 cursor-not-allowed' }} rounded-[1.5rem] text-[10px] font-black transition-all uppercase tracking-widest active:scale-95 shadow-sm">
                    {{ $buku->stok > 0 ? 'Pinjam Sekarang' : 'Stok Habis' }}
                </button>
            </div>
        </div>
        @empty
            <div class="col-span-full py-32 text-center bg-white rounded-[3rem] border-2 border-dashed border-slate-100">
                <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-200 text-4xl">
                    <i class="fas fa-search"></i>
                </div>
                <h3 class="text-xl font-black text-slate-900 uppercase italic">Buku tidak ditemukan</h3>
                <p class="text-slate-400 font-bold mt-2">Coba kata kunci lain atau pilih kategori yang berbeda.</p>
                <a href="{{ route('anggota.dashboard') }}" class="inline-block mt-6 px-8 py-3 bg-cyan-600 text-white rounded-2xl font-black uppercase text-[10px] tracking-widest shadow-lg shadow-cyan-100">Reset Filter</a>
            </div>
        @endforelse
    </div>

    {{-- MODAL PINJAM --}}
    <div x-show="openModal" 
         class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-90"
         x-transition:enter-end="opacity-100 scale-100"
         x-cloak>
        
        <div @click.away="openModal = false" class="bg-white rounded-[3.5rem] p-12 w-full max-w-md shadow-2xl relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-cyan-50 rounded-full -mr-16 -mt-16 opacity-50"></div>

            <div class="text-center mb-10 relative">
                <div class="w-24 h-24 bg-cyan-50 text-cyan-600 rounded-[2rem] flex items-center justify-center text-4xl mx-auto mb-6 shadow-inner">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <h3 class="text-3xl font-black text-slate-900 uppercase italic tracking-tighter">Konfirmasi</h3>
                <p class="text-slate-400 text-sm font-bold mt-2 px-4" x-text="bukuJudul"></p>
            </div>
            
            <form :action="'/anggota/pinjam/' + bukuId" method="POST">
                @csrf
                <div class="mb-10 text-center">
                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.3em] mb-6">Durasi Pinjam (Hari)</label>
                    <input type="number" name="durasi" min="1" max="14" value="3" required
                           class="w-32 bg-slate-50 border-4 border-slate-100 rounded-[2rem] py-6 text-center text-5xl font-black text-cyan-600 focus:outline-none focus:border-cyan-500 transition-all shadow-inner">
                    <p class="text-[10px] text-slate-400 font-bold mt-4 italic">*Maksimal peminjaman adalah 14 hari</p>
                </div>

                <div class="flex flex-col gap-3">
                    <button type="submit" class="w-full py-5 bg-slate-900 text-white rounded-[1.8rem] font-black text-[11px] uppercase tracking-[0.2em] hover:bg-cyan-600 transition-all active:scale-95">
                        Kirim Permintaan
                    </button>
                    <button type="button" @click="openModal = false" class="w-full py-4 bg-transparent text-slate-400 font-black text-[10px] uppercase tracking-widest">
                        Batalkan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

<style>
    [x-cloak] { display: none !important; }
    .animate-fadeIn { animation: fadeIn 0.6s ease-out; }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection