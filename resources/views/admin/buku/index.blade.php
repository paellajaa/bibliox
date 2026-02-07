@extends('layouts.admin')

@section('content')
<div class="animate-fade-in bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
    
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Koleksi Pustaka</h1>
            <p class="text-slate-500 mt-1 text-sm">Kelola aset digital dan pantau ketersediaan stok BIBLIOX.</p>
        </div>
        <a href="{{ route('admin.buku.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-2xl font-bold transition-all duration-300 transform hover:scale-105 shadow-lg shadow-blue-200 flex items-center gap-2">
            <span class="text-xl">+</span> Tambah Buku Baru
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 rounded-r-xl animate-slide-in flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="bg-emerald-500 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold">✓</span>
                <p class="font-medium text-sm">{{ session('success') }}</p>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-600">✕</button>
        </div>
    @endif

    <div class="overflow-x-auto px-1">
        <table class="w-full text-left border-separate border-spacing-y-3">
            <thead>
                <tr class="text-slate-400 uppercase text-[11px] font-bold tracking-[0.1em]">
                    <th class="pb-4 pl-6">Detail Katalog</th>
                    <th class="pb-4">Kategori</th>
                    <th class="pb-4 text-center">Tahun</th>
                    <th class="pb-4 text-center">Stok</th>
                    <th class="pb-4 text-right pr-6">Manajemen</th>
                </tr>
            </thead>
            <tbody>
                @forelse($semua_buku as $b)
                <tr class="bg-white hover:bg-blue-50/30 transition-all duration-300 group shadow-[0_2px_10px_-3px_rgba(0,0,0,0.07)] ring-1 ring-slate-100 rounded-2xl">
                    <td class="py-5 pl-6 rounded-l-2xl border-l border-y border-slate-100">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 font-bold group-hover:bg-blue-600 group-hover:text-white transition-all duration-500">
                                {{ substr($b->judul, 0, 1) }}
                            </div>
                            <div>
                                <div class="font-bold text-slate-800 group-hover:text-blue-600 transition-colors">{{ $b->judul }}</div>
                                <div class="text-xs text-slate-400 font-medium italic mt-0.5">{{ $b->penulis }}</div>
                            </div>
                        </div>
                    </td>

                    <td class="py-5 border-y border-slate-100">
                        <span class="bg-blue-50 text-blue-600 text-[10px] font-extrabold px-3 py-1.5 rounded-lg border border-blue-100 uppercase tracking-wider">
                            {{ $b->kategori ?? 'Umum' }}
                        </span>
                    </td>

                    <td class="py-5 text-center text-sm font-medium text-slate-500 border-y border-slate-100">
                        {{ $b->tahun_terbit }}
                    </td>

                    <td class="py-5 text-center border-y border-slate-100">
                        <div class="inline-flex items-center justify-center w-10 h-10 rounded-full {{ $b->stok > 0 ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-600' }} font-bold text-xs ring-1 ring-inset {{ $b->stok > 0 ? 'ring-emerald-200' : 'ring-red-200' }}">
                            {{ $b->stok }}
                        </div>
                    </td>

                    <td class="py-5 text-right pr-6 rounded-r-2xl border-r border-y border-slate-100">
                        <div class="flex justify-end items-center gap-1">
                            <a href="{{ route('admin.buku.edit', $b->kode_buku) }}" class="p-2.5 hover:bg-blue-100 rounded-xl text-blue-600 transition-all group/edit" title="Edit Data">
                                <span class="text-sm font-bold flex items-center gap-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Edit
                                </span>
                            </a>
                            <button onclick="toggleModal('modal-{{ $b->kode_buku }}')" class="p-2.5 hover:bg-red-50 rounded-xl text-red-400 hover:text-red-600 transition-all" title="Hapus Buku">
                                <span class="text-sm font-bold flex items-center gap-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Hapus
                                </span>
                            </button>
                        </div>
                    </td>
                </tr>

                <div id="modal-{{ $b->kode_buku }}" class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-slate-900/40 backdrop-blur-[2px] p-4 transition-all">
                    <div class="bg-white p-8 rounded-[2rem] max-w-sm w-full shadow-[0_20px_50px_rgba(0,0,0,0.1)] transform transition-all animate-pop-in">
                        <div class="w-20 h-20 bg-red-50 text-red-500 rounded-3xl flex items-center justify-center mx-auto mb-6 ring-4 ring-red-50/50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="text-center">
                            <h3 class="text-2xl font-black text-slate-800 mb-2">Konfirmasi Hapus</h3>
                            <p class="text-slate-500 text-sm leading-relaxed mb-8 px-2">Anda akan menghapus buku <span class="font-bold text-slate-800">"{{ $b->judul }}"</span> dari sistem selamanya.</p>
                        </div>
                        <div class="flex gap-4">
                            <button onclick="toggleModal('modal-{{ $b->kode_buku }}')" class="flex-1 py-4 bg-slate-100 text-slate-600 rounded-2xl font-bold hover:bg-slate-200 transition-all text-sm uppercase tracking-wider">Batal</button>
                            <form action="{{ route('admin.buku.destroy', $b->kode_buku) }}" method="POST" class="flex-1">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-full py-4 bg-red-500 text-white rounded-2xl font-bold hover:bg-red-600 transition-all shadow-lg shadow-red-200 text-sm uppercase tracking-wider">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <tr>
                    <td colspan="5" class="py-20 text-center">
                        <div class="flex flex-col items-center opacity-30">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <p class="text-xl font-bold italic tracking-wide">Belum ada koleksi buku yang terdaftar.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
    @keyframes slide-in {
        from { transform: translateX(20px); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes pop-in {
        0% { transform: scale(0.9); opacity: 0; }
        100% { transform: scale(1); opacity: 1; }
    }
    @keyframes fade-in {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    .animate-slide-in { animation: slide-in 0.4s ease-out; }
    .animate-pop-in { animation: pop-in 0.3s cubic-bezier(0.26, 0.53, 0.74, 1.48); }
    .animate-fade-in { animation: fade-in 0.6s ease-in-out; }
</style>

<script>
    function toggleModal(id) {
        const modal = document.getElementById(id);
        if (modal.classList.contains('hidden')) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden'; // Stop scrolling
        } else {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto'; // Re-enable scrolling
        }
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        if (event.target.classList.contains('fixed')) {
            event.target.classList.add('hidden');
            event.target.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }
    }
</script>
@endsection