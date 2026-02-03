<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BIBLIOX Admin - Modern Library</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-[#F8FAFC] text-slate-800">
    <div class="flex min-h-screen">
        <aside class="w-72 bg-white border-r border-slate-200 flex flex-col fixed h-full z-20 shadow-sm">
            <div class="p-8">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-600/30">
                        <span class="text-white font-black text-xl italic">X</span>
                    </div>
                    <div>
                        <h1 class="text-xl font-extrabold tracking-tighter text-slate-900 uppercase">BIBLIO<span class="text-blue-600">X</span></h1>
                        <p class="text-[10px] text-slate-400 uppercase tracking-widest font-bold">Administrator</p>
                    </div>
                </div>
            </div>
            
            <nav class="flex-1 px-4 space-y-1 mt-4">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-4 px-6 py-4 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-600 rounded-2xl font-bold' : 'text-slate-500 hover:bg-slate-50 rounded-2xl transition' }}">
                    <span class="text-xl">📊</span> Dashboard
                </a>
                <a href="{{ route('admin.buku.index') }}" class="flex items-center gap-4 px-6 py-4 {{ request()->routeIs('admin.buku.*') ? 'bg-blue-50 text-blue-600 rounded-2xl font-bold' : 'text-slate-500 hover:bg-slate-50 rounded-2xl transition' }}">
                    <span class="text-xl">📚</span> Kelola Buku
                </a>
                <a href="#" class="flex items-center gap-4 px-6 py-4 text-slate-500 hover:bg-slate-50 rounded-2xl transition">
                    <span class="text-xl">👥</span> Anggota
                </a>
            </nav>

            <div class="p-6 border-t border-slate-100">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="w-full flex items-center gap-3 px-6 py-3 text-slate-400 hover:text-red-600 transition font-bold text-sm">
                        <span>🚪</span> KELUAR SISTEM
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1 ml-72">
            <header class="h-20 flex items-center justify-between px-10 bg-white/80 backdrop-blur-md sticky top-0 z-10 border-b border-slate-100">
                <h2 class="text-sm font-bold text-slate-400 uppercase tracking-widest">Dashboard Pengelola</h2>
                <div class="flex items-center gap-4">
                    <div class="text-right mr-2">
                        <p class="text-xs font-bold text-slate-900">{{ auth()->user()->nama }}</p>
                        <p class="text-[10px] text-blue-600 font-bold uppercase">Admin Utama</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center border-2 border-white shadow-sm">
                        <span class="text-blue-600 font-bold text-xs">AD</span>
                    </div>
                </div>
            </header>

            <main class="p-10">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>