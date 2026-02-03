@extends('layouts.admin')

@section('content')
<div class="max-w-2xl bg-[#1e293b] p-8 rounded-2xl border border-cyan-900/30 shadow-xl">
    <h3 class="text-xl font-bold text-cyan-100 mb-6 italic text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-500">
        Edit Koleksi: {{ $buku->judul }}
    </h3>
    
    <form action="{{ route('admin.buku.update', $buku->kode_buku) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')
        
        <div>
            <label class="block text-cyan-100/70 mb-2 text-sm">Judul Buku</label>
            <input type="text" name="judul" value="{{ $buku->judul }}" class="w-full bg-[#0f172a] border border-cyan-900 rounded-lg px-4 py-2 text-white outline-none focus:border-cyan-500 transition">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-cyan-100/70 mb-2 text-sm">Penulis</label>
                <input type="text" name="penulis" value="{{ $buku->penulis }}" class="w-full bg-[#0f172a] border border-cyan-900 rounded-lg px-4 py-2 text-white outline-none focus:border-cyan-500">
            </div>
            <div>
                <label class="block text-cyan-100/70 mb-2 text-sm">Stok</label>
                <input type="number" name="stok" value="{{ $buku->stok }}" class="w-full bg-[#0f172a] border border-cyan-900 rounded-lg px-4 py-2 text-white outline-none focus:border-cyan-500">
            </div>
        </div>
        
        <div class="pt-6 flex gap-3">
            <button type="submit" class="bg-gradient-to-r from-cyan-500 to-blue-600 text-white px-6 py-2 rounded-lg font-bold transition shadow-lg">
                UPDATE DATA
            </button>
            <a href="{{ route('admin.buku.index') }}" class="text-gray-400 hover:text-white flex items-center px-4">Batal</a>
        </div>
    </form>
</div>
@endsection