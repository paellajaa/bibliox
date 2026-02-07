@extends('layouts.admin')

@section('content')
<div class="space-y-10 animate-fadeIn">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-black text-slate-900 uppercase italic tracking-tighter leading-none">Manajemen Akun 👥</h2>
                <p class="text-slate-500 font-bold text-sm mt-2">Pantau dan kelola semua pengguna terdaftar di BiblioX.</p>
            </div>
        </div>
        <div class="bg-slate-900 p-8 rounded-[2.5rem] shadow-xl flex justify-around items-center text-white">
            <div class="text-center">
                <p class="text-[10px] font-black uppercase text-slate-400 mb-1">Admin</p>
                <p class="text-3xl font-black text-cyan-400">{{ $totalAdmin }}</p>
            </div>
            <div class="w-px h-10 bg-slate-800"></div>
            <div class="text-center">
                <p class="text-[10px] font-black uppercase text-slate-400 mb-1">Anggota</p>
                <p class="text-3xl font-black text-orange-400">{{ $totalAnggota }}</p>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-emerald-500 text-white px-6 py-4 rounded-2xl shadow-lg font-bold flex items-center gap-3">
            <span>✅</span> {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-[2.5rem] overflow-hidden shadow-sm border border-slate-100">
        <table class="w-full text-left">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="px-8 py-5 text-[10px] font-black uppercase text-blue-600">Nama User</th>
                    <th class="px-8 py-5 text-[10px] font-black uppercase text-blue-600">ID / Pengenal</th>
                    <th class="px-8 py-5 text-[10px] font-black uppercase text-blue-600">Peran</th>
                    <th class="px-8 py-5 text-[10px] font-black uppercase text-blue-600 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($users as $row) <tr class="hover:bg-slate-50/50 transition-all">
                    <td class="px-8 py-6 font-black text-slate-900 uppercase text-sm">{{ $row->nama }}</td>
                    <td class="px-8 py-6 font-bold text-slate-500 text-xs tracking-widest">{{ $row->pengenal }}</td>
                    <td class="px-8 py-6 text-sm">
                        <span class="px-3 py-1 rounded-lg font-black text-[9px] uppercase 
                            {{ $row->peran == 'admin' ? 'bg-cyan-100 text-cyan-600' : 'bg-orange-100 text-orange-600' }}">
                            {{ $row->peran }}
                        </span>
                    </td>
                    <td class="px-8 py-6 text-right">
                        @if($row->id != Auth::id())
                        <form action="{{ route('admin.users.destroy', $row->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus akun ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-400 hover:text-red-600 font-black text-[10px] uppercase tracking-widest transition-all">
                                Hapus Akun
                            </button>
                        </form>
                        @else
                        <span class="text-slate-300 italic text-[10px] font-bold uppercase tracking-widest">Akun Anda</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection