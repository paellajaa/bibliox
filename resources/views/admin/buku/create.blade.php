@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8 animate-fadeIn">
    {{-- Breadcrumb Sederhana --}}
    <div class="mb-6 flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-400">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-600 transition-colors">Admin</a>
        <span>/</span>
        <a href="{{ route('admin.buku.index') }}" class="hover:text-indigo-600 transition-colors">Buku</a>
        <span>/</span>
        <span class="text-slate-600">Tambah Koleksi</span>
    </div>

    {{-- Container Utama --}}
    <div class="bg-white p-8 md:p-12 rounded-[2.5rem] border border-slate-100 shadow-[0_20px_60px_rgba(0,0,0,0.05)] relative overflow-hidden">
        
        {{-- Background Decoration: Glow Halus (Senada dengan Sidebar) --}}
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-indigo-500/5 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-blue-500/5 rounded-full blur-3xl"></div>
        
        {{-- Header Section --}}
        <div class="mb-12">
            <h3 class="text-3xl font-black text-slate-800 uppercase tracking-tighter italic">
                Tambah Koleksi Baru
            </h3>
            <p class="text-slate-400 text-sm font-medium mt-1">
                Lengkapi detail buku untuk memperkaya perpustakaan digital Anda.
            </p>
        </div>
        
        {{-- Error Messages --}}
        @if ($errors->any())
            <div class="mb-8 p-5 bg-red-50 rounded-2xl border border-red-100">
                <ul class="space-y-1">
                    @foreach ($errors->all() as $error)
                        <li class="text-red-500 text-xs font-bold flex items-center gap-2">
                            <span class="w-1.5 h-1.5 bg-red-400 rounded-full"></span> 
                            {{ $error }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.buku.store') }}" method="POST" enctype="multipart/form-data" class="space-y-10">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-8">
                {{-- Judul Buku --}}
                <div class="space-y-2">
                    <label class="block text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] ml-1">Judul Buku</label>
                    <input type="text" name="judul" value="{{ old('judul') }}" required 
                        placeholder="Masukkan judul buku..."
                        class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-slate-700 outline-none focus:border-indigo-500 focus:bg-white transition-all duration-300 font-bold placeholder:text-slate-300">
                </div>

                {{-- Cover Buku --}}
                <div class="space-y-2">
                    <label class="block text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] ml-1">Unggah Cover</label>
                    <input type="file" name="cover" required
                        class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-[13px] text-xs text-slate-400 file:mr-4 file:py-1.5 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 transition-all cursor-pointer">
                </div>

                {{-- Penulis --}}
                <div class="space-y-2">
                    <label class="block text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] ml-1">Penulis</label>
                    <input type="text" name="penulis" value="{{ old('penulis') }}" required 
                        placeholder="Nama pengarang..."
                        class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-slate-700 outline-none focus:border-indigo-500 focus:bg-white transition-all font-bold">
                </div>

                {{-- Kategori --}}
                <div class="space-y-2">
                    <label class="block text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] ml-1">Kategori / Genre</label>
                    <div class="relative">
                        <select name="kategori" required 
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 font-bold text-slate-700 outline-none focus:border-indigo-500 focus:bg-white transition-all appearance-none cursor-pointer">
                            <option value="">-- Pilih Kategori --</option>
                            @php
                                $categories = ['Fantasi', 'Petualangan', 'Romance', 'Horor', 'Misteri', 'Thriller', 'Sci-Fi', 'Komedi', 'Drama', 'Biografi', 'Sejarah', 'Edukasi', 'Religi', 'Sains', 'Puisi', 'Komik'];
                            @endphp
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}">{{ $cat }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-6 flex items-center pointer-events-none text-slate-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>

                {{-- Stok --}}
                <div class="space-y-2">
                    <label class="block text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] ml-1">Stok Tersedia</label>
                    <input type="number" name="stok" value="{{ old('stok') }}" required min="0" placeholder="0"
                        class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-slate-700 outline-none focus:border-indigo-500 focus:bg-white transition-all font-bold">
                </div>

                {{-- Tahun Terbit --}}
                <div class="space-y-2">
                    <label class="block text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] ml-1">Tahun Terbit</label>
                    <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit') }}" required 
                        placeholder="{{ date('Y') }}"
                        class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-slate-700 outline-none focus:border-indigo-500 focus:bg-white transition-all font-bold">
                </div>
            </div>
            
            {{-- Action Buttons --}}
            <div class="pt-10 flex items-center justify-between border-t border-slate-50">
                <a href="{{ route('admin.buku.index') }}" 
                   class="text-slate-400 hover:text-indigo-600 text-[11px] font-black uppercase tracking-[0.2em] transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Batal
                </a>
                
                <button type="submit" 
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-12 py-4 rounded-[1.2rem] font-black transition-all duration-300 shadow-[0_10px_30px_rgba(79,70,229,0.3)] hover:shadow-[0_15px_40px_rgba(79,70,229,0.4)] uppercase text-[11px] tracking-widest active:scale-95">
                    Simpan Koleksi
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fadeIn {
        animation: fadeIn 0.5s ease-out forwards;
    }
</style>
@endsection