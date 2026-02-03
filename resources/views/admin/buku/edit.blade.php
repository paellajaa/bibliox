@extends('layouts.admin')

@section('content')
<div class="max-w-2xl bg-[#1e293b] p-8 rounded-2xl border border-cyan-900/30 shadow-xl">
    <h3 class="text-xl font-bold text-cyan-100 mb-6">Edit Data Buku</h3>
    
    <form action="{{ route('admin.buku.update', $buku->kode_buku) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')
        
        <div>
            <label class="block text-cyan-100/70 mb-2 text-sm">Judul Buku</label>
            <input type="text" name="judul" value="{{ old('judul', $buku->judul) }}" required
                class="w-full bg-[#0f172a] border border-cyan-900 rounded-lg px-4 py-2 text-white outline-none focus:border-cyan-500">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-cyan-100/70 mb-2 text-sm">Penulis</label>
                <input type="text" name="penulis" value="{{ old('penulis', $buku->penulis) }}" required
                    class="w-full bg-[#0f172a] border border-cyan-900 rounded-lg px-4 py-2 text-white outline-none focus:border-cyan-500">
            </div>
            <div>
                <label class="block text-cyan-100/70 mb-2 text-sm">Kategori</label>
                <input type="text" name="kategori" value="{{ old('kategori', $buku->kategori) }}"
                    class="w-full bg-[#0f172a] border border-cyan-900 rounded-lg px-4 py-2 text-white outline-none focus:border-cyan-500">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-cyan-100/70 mb-2 text-sm">Stok</label>
                <input type="number" name="stok" value="{{ old('stok', $buku->stok) }}" required
                    class="w-full bg-[#0f172a] border border-cyan-900 rounded-lg px-4 py-2 text-white outline-none focus:border-cyan-500">
            </div>
            <div>
                <label class="block text-cyan-100/70 mb-2 text-sm">Tahun Terbit</label>
                <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}" required
                    class="w-full bg-[#0f172a] border border-cyan-900 rounded-lg px-4 py-2 text-white outline-none focus:border-cyan-500">
            </div>
        </div>
        
        <div class="pt-6 flex gap-3">
            <button type="submit" class="bg-cyan-600 hover:bg-cyan-500 text-white px-6 py-2 rounded-lg transition font-bold">
                Perbarui Data
            </button>
            <a href="{{ route('admin.buku.index') }}" class="text-gray-400 hover:text-white flex items-center">Batal</a>
        </div>
    </form>
</div>
@endsection