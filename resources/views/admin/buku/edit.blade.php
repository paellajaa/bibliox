@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8 animate-fadeIn">
    {{-- Breadcrumb --}}
    <div class="mb-6 flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-400">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 transition-colors">Admin</a>
        <span>/</span>
        <a href="{{ route('admin.buku.index') }}" class="hover:text-blue-600 transition-colors">Buku</a>
        <span>/</span>
        <span class="text-slate-600">Edit Data</span>
    </div>

    {{-- Container Utama: Putih Bersih Modern --}}
    <div class="bg-white p-8 md:p-12 rounded-[3rem] border border-slate-100 shadow-[0_30px_70px_rgba(0,0,0,0.05)] relative overflow-hidden">
        
        {{-- Background Decoration --}}
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-blue-500/5 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-indigo-500/5 rounded-full blur-3xl"></div>
        
        {{-- Header Section --}}
        <div class="mb-12">
            <h3 class="text-3xl font-black text-slate-800 uppercase tracking-tighter italic">
                Edit Data Buku
            </h3>
            <p class="text-slate-400 text-sm font-medium mt-1">
                Perbarui informasi buku yang sudah ada di koleksi.
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

        <form action="{{ route('admin.buku.update', $buku->kode_buku) }}" method="POST" enctype="multipart/form-data" class="space-y-10">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-8">
                {{-- Judul Buku --}}
                <div class="space-y-2 md:col-span-2">
                    <label class="block text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] ml-1">Judul Buku</label>
                    <input type="text" name="judul" value="{{ old('judul', $buku->judul) }}" required 
                        class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-slate-700 outline-none focus:border-blue-500 focus:bg-white transition-all duration-300 font-bold">
                </div>

                {{-- Penulis --}}
                <div class="space-y-2">
                    <label class="block text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] ml-1">Penulis</label>
                    <input type="text" name="penulis" value="{{ old('penulis', $buku->penulis) }}" required 
                        class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-slate-700 outline-none focus:border-blue-500 focus:bg-white transition-all font-bold">
                </div>

                {{-- Kategori --}}
                <div class="space-y-2">
                    <label class="block text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] ml-1">Kategori / Genre</label>
                    <div class="relative">
                        <select name="kategori" required 
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 font-bold text-slate-700 outline-none focus:border-blue-500 focus:bg-white transition-all appearance-none cursor-pointer">
                            <option value="">-- Pilih Kategori --</option>
                            @php
                                $categories = ['Fantasi', 'Petualangan', 'Romance', 'Horor', 'Misteri', 'Thriller', 'Sci-Fi', 'Komedi', 'Drama', 'Biografi', 'Sejarah', 'Edukasi', 'Religi', 'Sains', 'Puisi', 'Komik'];
                            @endphp
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ old('kategori', $buku->kategori) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
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
                    <input type="number" name="stok" value="{{ old('stok', $buku->stok) }}" required min="0" 
                        class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-slate-700 outline-none focus:border-blue-500 focus:bg-white transition-all font-bold">
                </div>

                {{-- Tahun Terbit --}}
                <div class="space-y-2">
                    <label class="block text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] ml-1">Tahun Terbit</label>
                    <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}" required 
                        class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-slate-700 outline-none focus:border-blue-500 focus:bg-white transition-all font-bold">
                </div>
            </div>
            
            {{-- Action Buttons --}}
            <div class="pt-10 flex items-center justify-between border-t border-slate-50">
                <a href="{{ route('admin.buku.index') }}" 
                   class="text-slate-400 hover:text-blue-600 text-[11px] font-black uppercase tracking-[0.2em] transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Batal
                </a>
                
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-14 py-4 rounded-[1.2rem] font-black transition-all duration-300 shadow-[0_10px_30px_rgba(37,99,235,0.3)] hover:shadow-[0_15px_40px_rgba(37,99,235,0.4)] uppercase text-[11px] tracking-widest active:scale-95">
                    Perbarui Data
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