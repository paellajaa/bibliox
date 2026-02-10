@extends('layouts.admin') 

@section('content')
<div class="space-y-8 animate-fadeIn" x-data="{ openModal: false, bukuId: '', bukuJudul: '' }">
    
    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="bg-emerald-500 text-white px-6 py-4 rounded-2xl shadow-lg shadow-emerald-200 flex items-center gap-3">
            <span class="text-xl">✅</span>
            <p class="font-bold text-sm">{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-500 text-white px-6 py-4 rounded-2xl shadow-lg shadow-red-200 flex items-center gap-3">
            <span class="text-xl">❌</span>
            <p class="font-bold text-sm">{{ session('error') }}</p>
        </div>
    @endif

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
        <div>
            <h2 class="text-3xl font-black text-slate-900 italic uppercase tracking-tighter leading-tight">
                Halo, {{ Auth::user()->nama }}! 👋
            </h2>
            <p class="text-slate-500 font-bold text-lg">Siap menjelajahi dunia pengetahuan hari ini?</p>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-slate-900 p-7 rounded-[2rem] shadow-xl relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-cyan-500/10 rounded-full blur-2xl group-hover:bg-cyan-500/20 transition-all"></div>
            <p class="text-cyan-400 text-[10px] font-black uppercase tracking-[0.2em] mb-4">Sedang Dipinjam</p>
            <h3 class="text-4xl font-black text-white italic">{{ $buku_dipinjam ?? 0 }} <span class="text-sm font-medium opacity-50 italic">Buku</span></h3>
        </div>

        <div class="bg-white border-2 border-slate-100 p-7 rounded-[2rem] hover:border-cyan-200 transition-all">
            <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] mb-4">Total Katalog</p>
            <h3 class="text-4xl font-black text-slate-900 italic">{{ $total_katalog ?? 0 }}</h3>
        </div>
    </div>

    <div class="flex items-center gap-4 pt-4">
        <h3 class="text-xl font-black text-slate-900 uppercase italic tracking-wider whitespace-nowrap">Koleksi Terbaru</h3>
        <div class="h-[2px] w-full bg-slate-100"></div>
    </div>

    {{-- Grid Buku --}}
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-8">
        @forelse($all_books as $buku)
        <div class="group bg-white p-4 rounded-[2.5rem] border-2 border-transparent hover:border-cyan-500 hover:shadow-2xl hover:shadow-cyan-100 transition-all duration-500">
            <div class="aspect-[3/4] bg-slate-50 rounded-[2rem] mb-5 overflow-hidden relative shadow-inner">
                @if($buku->cover)
                    <img src="{{ asset('covers/' . $buku->cover) }}" 
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                         alt="{{ $buku->judul }}"
                         onerror="this.onerror=null;this.src='https://placehold.co/400x600/f1f5f9/64748b?text=No+Cover';">
                @else
                    <div class="w-full h-full flex items-center justify-center text-slate-300 font-black text-2xl italic uppercase bg-slate-100">
                        BiblioX
                    </div>
                @endif
                
                <div class="absolute top-3 right-3 px-3 py-1.5 bg-white/90 backdrop-blur-md rounded-xl text-[10px] font-black {{ $buku->stok > 0 ? 'text-cyan-600' : 'text-red-500' }} shadow-sm">
                    {{ $buku->stok > 0 ? 'Tersedia' : 'Habis' }}
                </div>
            </div>

            <div class="px-2">
                <h4 class="text-slate-900 font-black truncate text-sm mb-1 uppercase tracking-tight">{{ $buku->judul }}</h4>
                <p class="text-slate-400 text-[10px] mb-5 font-bold italic">Oleh: {{ $buku->penulis }}</p>
                
                {{-- TOMBOL PINJAM (Sudah diperbaiki ke kode_buku) --}}
                <button @click="openModal = true; bukuId = '{{ $buku->kode_buku }}'; bukuJudul = '{{ $buku->judul }}'"
                        {{ $buku->stok <= 0 ? 'disabled' : '' }}
                        class="w-full py-3.5 {{ $buku->stok > 0 ? 'bg-slate-900 text-white hover:bg-cyan-600 shadow-xl shadow-slate-200' : 'bg-slate-100 text-slate-400 cursor-not-allowed' }} rounded-2xl text-[10px] font-black transition-all uppercase tracking-widest active:scale-95">
                    {{ $buku->stok > 0 ? 'Pinjam Sekarang' : 'Stok Habis' }}
                </button>
            </div>
        </div>
        @empty
            <div class="col-span-full py-20 text-center bg-white rounded-[3rem] border-2 border-dashed border-slate-200">
                <p class="text-slate-400 italic font-black uppercase tracking-widest">Belum ada koleksi buku yang tersedia</p>
            </div>
        @endforelse
    </div>

    {{-- MODAL PINJAM --}}
    <div x-show="openModal" 
         class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4" 
         x-transition.opacity x-cloak>
        
        <div @click.away="openModal = false" 
             class="bg-white rounded-[3rem] p-10 w-full max-w-md shadow-2xl transform transition-all animate-fadeIn">
            
            <div class="text-center mb-8">
                <div class="w-20 h-20 bg-cyan-50 text-cyan-600 rounded-3xl flex items-center justify-center text-3xl mx-auto mb-6 shadow-inner">
                    📖
                </div>
                <h3 class="text-2xl font-black text-slate-900 uppercase italic tracking-tighter">Konfirmasi Pinjam</h3>
                <p class="text-slate-400 text-sm font-bold mt-1" x-text="bukuJudul"></p>
            </div>
            
            {{-- FORM ACTION --}}
            <form :action="'/anggota/pinjam/' + bukuId" method="POST">
                @csrf
                <div class="mb-8">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-center mb-4">Mau pinjam berapa hari?</label>
                    <div class="flex items-center justify-center gap-4">
                        <input type="number" name="durasi" min="1" max="14" value="3" required
                               class="w-full bg-slate-50 border-2 border-slate-100 rounded-3xl px-6 py-6 text-center text-5xl font-black text-cyan-600 focus:outline-none focus:border-cyan-500 transition-all">
                    </div>
                    <p class="text-[10px] text-center mt-4 text-slate-400 font-bold uppercase tracking-widest">Maksimal pinjam 14 hari</p>
                </div>

                <div class="flex gap-4">
                    <button type="button" @click="openModal = false" 
                            class="flex-1 py-5 bg-slate-100 text-slate-500 rounded-2xl font-black text-[11px] uppercase tracking-widest hover:bg-slate-200 transition-all">
                        Batal
                    </button>
                    <button type="submit" 
                            class="flex-1 py-5 bg-slate-900 text-white rounded-2xl font-black text-[11px] uppercase tracking-widest shadow-xl shadow-slate-200 hover:bg-cyan-600 transition-all">
                        Kirim Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection