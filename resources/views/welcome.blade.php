<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BIBLIOX - Perpustakaan Digital Masa Kini</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-white text-slate-900 overflow-x-hidden">
    <nav class="flex items-center justify-between px-10 py-6 max-w-7xl mx-auto">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-blue-600 rounded flex items-center justify-center font-black text-white">X</div>
            <span class="text-xl font-extrabold tracking-tighter text-slate-900">BIBLIOX</span>
        </div>
        <div class="flex items-center gap-6">
            <a href="{{ route('login') }}" class="font-semibold text-slate-600 hover:text-blue-600 transition">Masuk</a>
            <a href="{{ route('register') }}" class="bg-blue-600 text-white px-6 py-2.5 rounded-full font-bold shadow-lg shadow-blue-600/20 hover:bg-blue-700 transition">Daftar Anggota</a>
        </div>
    </nav>

    <section class="max-w-7xl mx-auto px-10 py-20 flex flex-col lg:flex-row items-center gap-16 relative">
        <div class="absolute top-0 right-0 -z-10 opacity-10">
            <svg width="600" height="600" viewBox="0 0 600 600" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="300" cy="300" r="300" fill="url(#paint0_linear)"/>
                <defs><linearGradient id="paint0_linear" x1="0" y1="0" x2="600" y2="600" gradientUnits="userSpaceOnUse"><stop stop-color="#2563EB"/><stop offset="1" stop-color="#60A5FA" stop-opacity="0"/></linearGradient></defs>
            </svg>
        </div>

        <div class="flex-1 space-y-8">
            <h1 class="text-6xl lg:text-7xl font-extrabold leading-[1.1] tracking-tight">
                Perpustakaan <span class="text-blue-600">Modern</span> untuk <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500">Generasi Digital</span>
            </h1>
            <p class="text-lg text-slate-500 max-w-lg leading-relaxed">
                BIBLIOX adalah layanan perpustakaan digital yang dirancang untuk memenuhi kebutuhan literasi Anda dengan koleksi buku pilihan yang dapat diakses kapan saja.
            </p>
            <div class="flex items-center gap-4">
                <a href="{{ route('register') }}" class="bg-blue-600 text-white px-8 py-4 rounded-xl font-bold text-lg shadow-xl shadow-blue-600/30 hover:scale-105 transition-transform">Mulai Membaca</a>
                <button class="border-2 border-slate-200 text-slate-600 px-8 py-4 rounded-xl font-bold text-lg hover:bg-slate-50 transition">Tentang Kami</button>
            </div>
        </div>

        <div class="flex-1 relative">
            <div class="relative z-10 w-full max-w-md mx-auto aspect-[3/4] bg-gradient-to-br from-blue-100 to-white rounded-[2rem] border-8 border-white shadow-2xl overflow-hidden">
                <div class="p-8 space-y-4 text-center">
                    <span class="text-6xl">📖</span>
                    <h3 class="text-2xl font-bold text-slate-800">Koleksi Terpopuler</h3>
                    <div class="grid grid-cols-2 gap-3 mt-4">
                        <div class="h-32 bg-blue-200 rounded-lg animate-pulse"></div>
                        <div class="h-32 bg-blue-300 rounded-lg animate-pulse"></div>
                    </div>
                </div>
            </div>
            <div class="absolute -bottom-6 -left-6 w-24 h-24 bg-blue-600 rounded-3xl shadow-xl flex items-center justify-center animate-bounce">
                <span class="text-3xl text-white font-bold">X</span>
            </div>
        </div>
    </section>
</body>
</html>