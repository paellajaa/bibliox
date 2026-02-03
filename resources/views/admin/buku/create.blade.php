@extends('layouts.admin')

@section('content')
<div class="max-w-2xl bg-[#1e293b] p-8 rounded-2xl border border-cyan-900/30 shadow-xl">
    <h3 class="text-xl font-bold text-cyan-100 mb-6">Tambah Koleksi Baru</h3>
    
    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-500/10 border border-red-500/50 rounded-lg">
            <ul class="list-disc list-inside text-sm text-red-400">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.buku.store') }}" method="POST" class="space-y-4">
        @csrf
        
        <div>
            <label class="block text-cyan-100/70 mb-2 text-sm">Judul Buku</label>
            <input type="text" name="judul" value="{{ old('judul') }}" required
                class="w-full bg-[#0f172a] border border-cyan-900 rounded-lg px-4 py-2 text-white outline-none focus:border-cyan-500 transition">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-cyan-100/70 mb-2 text-sm">Penulis</label>
                <input type="text" name="penulis" value="{{ old('penulis') }}" required
                    class="w-full bg-[#0f172a] border border-cyan-900 rounded-lg px-4 py-2 text-white outline-none focus:border-cyan-500 transition">
            </div>
            <div>
                <label class="block text-cyan-100/70 mb-2 text-sm">Kategori</label>
                <input type="text" name="kategori" value="{{ old('kategori') }}"
                    class="w-full bg-[#0f172a] border border-cyan-900 rounded-lg px-4 py-2 text-white outline-none focus:border-cyan-500 transition" 
                    placeholder="Contoh: Teknologi">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-cyan-100/70 mb-2 text-sm">Stok</label>
                <input type="number" name="stok" value="{{ old('stok') }}" required min="0"
                    class="w-full bg-[#0f172a] border border-cyan-900 rounded-lg px-4 py-2 text-white outline-none focus:border-cyan-500 transition">
            </div>
            <div>
                <label class="block text-cyan-100/70 mb-2 text-sm">Tahun Terbit</label>
                <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit') }}" required 
                    placeholder="Contoh: 2024"
                    class="w-full bg-[#0f172a] border border-cyan-900 rounded-lg px-4 py-2 text-white outline-none focus:border-cyan-500 transition">
            </div>
        </div>
        
        <div class="pt-6 flex gap-3">
            <button type="submit" class="bg-cyan-600 hover:bg-cyan-500 text-white px-6 py-2.5 rounded-lg font-bold transition shadow-lg shadow-cyan-900/20">
                Simpan Buku
            </button>
            <a href="{{ route('admin.buku.index') }}" class="text-gray-400 hover:text-white flex items-center px-4 transition">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection