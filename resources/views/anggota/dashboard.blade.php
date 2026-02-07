@extends('layouts.admin') @section('content')
<div class="space-y-8 animate-fadeIn">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-black text-white italic uppercase tracking-tighter">Halo, {{ Auth::user()->name }}! 👋</h2>
            <p class="text-cyan-100/50">Siap menjelajahi dunia pengetahuan hari ini?</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gradient-to-br from-cyan-600 to-blue-700 p-6 rounded-3xl shadow-xl">
            <p class="text-white/70 text-xs font-bold uppercase tracking-widest">Sedang Dipinjam</p>
            <h3 class="text-4xl font-black text-white mt-2">2 <span class="text-sm font-medium">Buku</span></h3>
        </div>
        <div class="bg-[#1e293b] border border-cyan-900/30 p-6 rounded-3xl">
            <p class="text-cyan-100/50 text-xs font-bold uppercase tracking-widest">Jatuh Tempo</p>
            <h3 class="text-4xl font-black text-orange-400 mt-2">3 <span class="text-sm font-medium">Hari lagi</span></h3>
        </div>
        <div class="bg-[#1e293b] border border-cyan-900/30 p-6 rounded-3xl">
            <p class="text-cyan-100/50 text-xs font-bold uppercase tracking-widest">Total Denda</p>
            <h3 class="text-4xl font-black text-red-400 mt-2">Rp 0</h3>
        </div>
    </div>

    <h3 class="text-xl font-bold text-white italic uppercase tracking-wider">Koleksi Terbaru</h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        <div class="group bg-[#1e293b] p-4 rounded-3xl border border-cyan-900/30 hover:border-cyan-500 transition-all duration-500">
            <div class="aspect-[3/4] bg-[#0f172a] rounded-2xl mb-4 overflow-hidden">
                 <div class="w-full h-full flex items-center justify-center text-cyan-900 font-black text-4xl italic">BIBLIOX</div>
            </div>
            <h4 class="text-white font-bold truncate">Seni Berpikir Digital</h4>
            <p class="text-cyan-100/50 text-xs mb-4">Penulis: Prof. X</p>
            <button class="w-full py-2 bg-cyan-600/10 hover:bg-cyan-600 text-cyan-500 hover:text-white rounded-xl text-xs font-black transition-all">PINJAM BUKU</button>
        </div>
    </div>
</div>
@endsection