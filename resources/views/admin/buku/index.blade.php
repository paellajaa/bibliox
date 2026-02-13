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
                    <th class="pb-4">Penulis</th>
                    <th class="pb-4 text-center">Stok</th>
                    <th class="pb-4 text-right pr-6">Manajemen</th>
                </tr>
            </thead>
            <tbody>
                @forelse($semua_buku as $b)
                <tr class="bg-white hover:bg-blue-50/30 transition-all duration-300 group shadow-[0_2px_10px_-3px_rgba(0,0,0,0.07)] ring-1 ring-slate-100 rounded-2xl">
                    <td class="py-5 pl-6 rounded-l-2xl border-l border-y border-slate-100">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-16 bg-slate-100 rounded-lg overflow-hidden flex-shrink-0 shadow-sm border border-slate-200">
                                @if($b->cover)
                                    <img src="{{ asset('covers/' . $b->cover) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-300 font-bold text-lg italic bg-slate-50">B</div>
                                @endif
                            </div>
                            <div>
                                <div class="font-bold text-slate-800 group-hover:text-blue-600 transition-colors uppercase text-sm">{{ $b->judul }}</div>
                                <div class="text-[10px] text-slate-400 font-black tracking-widest mt-0.5 uppercase">KODE: {{ $b->kode_buku }}</div>
                            </div>
                        </div>
                    </td>

                    <td class="py-5 border-y border-slate-100">
                        <span class="text-slate-600 text-sm font-bold italic">{{ $b->penulis }}</span>
                    </td>

                    <td class="py-5 text-center border-y border-slate-100">
                        <div class="inline-flex items-center justify-center w-10 h-10 rounded-full {{ $b->stok > 0 ? 'bg-emerald-50 text-emerald-600 ring-emerald-200' : 'bg-red-50 text-red-600 ring-red-200' }} font-bold text-xs ring-1 ring-inset">
                            {{ $b->stok }}
                        </div>
                    </td>

                    <td class="py-5 text-right pr-6 rounded-r-2xl border-r border-y border-slate-100">
                        <div class="flex justify-end items-center gap-1">
                            <a href="{{ route('admin.buku.edit', $b->kode_buku) }}" class="p-2.5 hover:bg-blue-100 rounded-xl text-blue-600 transition-all" title="Edit Data">
                                <span class="text-[10px] font-black uppercase flex items-center gap-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Edit
                                </span>
                            </a>
                            <button onclick="toggleModal('modal-{{ $b->kode_buku }}')" class="p-2.5 hover:bg-red-50 rounded-xl text-red-400 hover:text-red-600 transition-all" title="Hapus Buku">
                                <span class="text-[10px] font-black uppercase flex items-center gap-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Hapus
                                </span>
                            </button>
                        </div>
                    </td>
                </tr>

                {{-- Modal Hapus --}}
                <div id="modal-{{ $b->kode_buku }}" class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-slate-900/40 backdrop-blur-[2px] p-4 transition-all">
                    <div class="bg-white p-8 rounded-[2rem] max-w-sm w-full shadow-2xl transform transition-all animate-pop-in">
                        <div class="w-16 h-16 bg-red-50 text-red-500 rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="text-center">
                            <h3 class="text-xl font-black text-slate-800 mb-2 uppercase">Hapus Buku?</h3>
                            <p class="text-slate-500 text-sm mb-8 italic">"{{ $b->judul }}" akan dihapus permanen.</p>
                        </div>
                        <div class="flex gap-4">
                            <button onclick="toggleModal('modal-{{ $b->kode_buku }}')" class="flex-1 py-3 bg-slate-100 text-slate-600 rounded-xl font-bold text-xs uppercase">Batal</button>
                            <form action="{{ route('admin.buku.destroy', $b->kode_buku) }}" method="POST" class="flex-1">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-full py-3 bg-red-500 text-white rounded-xl font-bold text-xs uppercase shadow-lg shadow-red-200">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <tr>
                    <td colspan="4" class="py-20 text-center text-slate-400 italic font-bold">Koleksi masih kosong.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINATION LINKS (Untuk Poin 1.7 PERF) --}}
    <div class="mt-8">
        {{ $semua_buku->links() }}
    </div>
</div>

<style>
    @keyframes slide-in { from { transform: translateX(20px); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
    @keyframes pop-in { 0% { transform: scale(0.9); opacity: 0; } 100% { transform: scale(1); opacity: 1; } }
    @keyframes fade-in { from { opacity: 0; } to { opacity: 1; } }
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
            document.body.style.overflow = 'hidden';
        } else {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }
    }
</script>
@endsection