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
    </form>@extends('layouts.admin')

@section('content')
<div class="max-w-3xl animate-fadeIn">
    <div class="bg-[#1e293b] p-8 rounded-3xl border border-cyan-900/30 shadow-2xl relative overflow-hidden">
        <div class="absolute -top-24 -right-24 w-48 h-48 bg-cyan-500/10 blur-[80px] rounded-full"></div>
        
        <div class="relative z-10">
            <h3 class="text-2xl font-black text-white mb-2 uppercase tracking-tighter italic">Tambah Koleksi Baru</h3>
            <p class="text-cyan-100/50 text-sm mb-8">Lengkapi informasi untuk menambahkan buku ke pustaka digital.</p>
            
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-500/10 border border-red-500/50 rounded-2xl animate-shake">
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
                            class="w-full bg-[#0f172a] border border-cyan-900 rounded-2xl px-5 py-3 text-white outline-none focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 transition-all duration-300">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-cyan-100/70 text-xs font-bold uppercase tracking-widest ml-1">Cover Buku</label>
                        <input type="file" name="cover" 
                            class="w-full bg-[#0f172a] border border-cyan-900 rounded-2xl px-5 py-2 text-sm text-cyan-100/50 file:mr-4 file:py-1 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-cyan-600 file:text-white hover:file:bg-cyan-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-cyan-100/70 text-xs font-bold uppercase tracking-widest ml-1">Penulis</label>
                        <input type="text" name="penulis" value="{{ old('penulis') }}" required
                            class="w-full bg-[#0f172a] border border-cyan-900 rounded-2xl px-5 py-3 text-white outline-none focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 transition-all">
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
                        <label class="block text-cyan-100/70 text-xs font-bold uppercase tracking-widest ml-1">Tahun</label>
                        <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit') }}" required 
                            class="w-full bg-[#0f172a] border border-cyan-900 rounded-2xl px-5 py-3 text-white outline-none focus:border-cyan-500 transition-all">
                    </div>
                </div>
                
                <div class="pt-8 flex items-center gap-6">
                    <button type="submit" class="group relative bg-cyan-600 hover:bg-cyan-500 text-white px-8 py-3.5 rounded-2xl font-black transition-all duration-300 shadow-xl shadow-cyan-900/40 overflow-hidden">
                        <span class="relative z-10">SIMPAN KOLEKSI</span>
                        <div class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
                    </button>
                    <a href="{{ route('admin.buku.index') }}" class="text-gray-500 hover:text-white font-bold transition-colors">
                        BATAL
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes shake { 0%, 100% { transform: translateX(0); } 25% { transform: translateX(-5px); } 75% { transform: translateX(5px); } }
    .animate-fadeIn { animation: fadeIn 0.5s ease-out forwards; }
    .animate-shake { animation: shake 0.4s ease-in-out; }
</style>
@endsection
</div>
@endsection