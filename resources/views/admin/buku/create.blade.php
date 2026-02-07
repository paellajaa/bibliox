@extends('layouts.admin')

@section('content')
<div class="max-w-4xl animate-fadeIn text-white">
    <div class="bg-[#1e293b] p-8 rounded-3xl border border-cyan-900/30 shadow-2xl relative overflow-hidden">
        
        <div class="relative z-10">
            <h3 class="text-2xl font-black mb-2 uppercase tracking-tighter italic">Tambah Koleksi Baru</h3>
            <p class="text-cyan-100/50 text-sm mb-8">Pastikan memilih file cover agar muncul di dashboard.</p>
            
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-500/10 border border-red-500/50 rounded-2xl">
                    <ul class="list-disc list-inside text-sm text-red-400 font-medium">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.buku.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-cyan-100/70 text-xs font-bold uppercase tracking-widest ml-1">Judul Buku</label>
                        <input type="text" name="judul" value="{{ old('judul') }}" required
                            class="w-full bg-[#0f172a] border border-cyan-900 rounded-2xl px-5 py-3 text-white outline-none focus:border-cyan-500 transition-all duration-300">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-cyan-100/70 text-xs font-bold uppercase tracking-widest ml-1">Cover Buku (Foto)</label>
                        <input type="file" name="cover" required
                            class="w-full bg-[#0f172a] border border-cyan-900 rounded-2xl px-5 py-2 text-sm text-cyan-100/50 file:mr-4 file:py-1 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-cyan-600 file:text-white hover:file:bg-cyan-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-cyan-100/70 text-xs font-bold uppercase tracking-widest ml-1">Penulis</label>
                        <input type="text" name="penulis" value="{{ old('penulis') }}" required
                            class="w-full bg-[#0f172a] border border-cyan-900 rounded-2xl px-5 py-3 text-white outline-none focus:border-cyan-500 transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-cyan-100/70 text-xs font-bold uppercase tracking-widest ml-1">Kategori</label>
                        <select name="kategori" class="w-full bg-[#0f172a] border border-cyan-900 rounded-2xl px-5 py-3 text-white outline-none focus:border-cyan-500 transition-all">
                            <option value="Teknologi">Teknologi</option>
                            <option value="Sains">Sains</option>
                            <option value="Sastra">Sastra</option>
                            <option value="Bisnis">Bisnis</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-cyan-100/70 text-xs font-bold uppercase tracking-widest ml-1">Stok</label>
                        <input type="number" name="stok" value="{{ old('stok') }}" required min="0"
                            class="w-full bg-[#0f172a] border border-cyan-900 rounded-2xl px-5 py-3 text-white outline-none focus:border-cyan-500 transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-cyan-100/70 text-xs font-bold uppercase tracking-widest ml-1">Tahun Terbit</label>
                        <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit') }}" required 
                            class="w-full bg-[#0f172a] border border-cyan-900 rounded-2xl px-5 py-3 text-white outline-none focus:border-cyan-500 transition-all">
                    </div>
                </div>
                
                <div class="pt-8 flex items-center gap-6">
                    <button type="submit" class="bg-cyan-600 hover:bg-cyan-500 text-white px-8 py-3.5 rounded-2xl font-black transition-all duration-300 shadow-xl shadow-cyan-900/40">
                        SIMPAN KOLEKSI
                    </button>
                    <a href="{{ route('admin.buku.index') }}" class="text-gray-500 hover:text-white font-bold transition-colors">
                        BATAL
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection