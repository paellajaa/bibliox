<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BiblioX - Dashboard Anggota</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0f172a] text-white">
    <nav class="border-b border-cyan-900/30 bg-[#0f172a]/80 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <h1 class="text-2xl font-black italic tracking-tighter text-cyan-500">BIBLIOX</h1>
            <div class="flex items-center gap-8">
                <a href="#" class="text-sm font-bold text-cyan-500">Katalog</a>
                <a href="#" class="text-sm font-bold text-white/50 hover:text-white">Pinjaman Saya</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="px-5 py-2 bg-red-500/10 text-red-500 rounded-xl text-xs font-bold hover:bg-red-500 hover:text-white transition-all">LOGOUT</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-6 py-10">
        @yield('content')
    </main>
</body>
</html>