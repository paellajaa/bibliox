<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - BIBLIOX Digital</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700;800&display=swap" rel="stylesheet">
</head>
<body class="bg-[#F8FAFC] flex items-center justify-center min-h-screen p-6 font-['Plus_Jakarta_Sans']">
    <div class="w-full max-w-md">
        <div class="text-center mb-10">
            <div class="inline-flex w-16 h-16 bg-blue-600 rounded-2xl items-center justify-center shadow-2xl shadow-blue-600/40 mb-4 transform -rotate-6">
                <span class="text-white font-black text-3xl italic">X</span>
            </div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tighter">BIBLIOX LOGIN</h1>
            <p class="text-slate-400 mt-2 font-medium">Silakan masuk ke akun pengelola Anda</p>
        </div>

        <div class="bg-white p-10 rounded-[40px] shadow-xl shadow-slate-200/50 border border-slate-100">
            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3 ml-1">Alamat Email</label>
                    <input type="email" name="email" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 text-slate-900 focus:ring-4 focus:ring-blue-100 focus:border-blue-600 outline-none transition-all font-semibold" placeholder="admin@bibliox.com" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3 ml-1">Kata Sandi</label>
                    <input type="password" name="kata_sandi" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 text-slate-900 focus:ring-4 focus:ring-blue-100 focus:border-blue-600 outline-none transition-all font-semibold" placeholder="••••••••" required>
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-5 rounded-2xl transition-all shadow-xl shadow-blue-600/30 hover:scale-[1.02] active:scale-95 text-lg italic tracking-wider">
                    OTENTIKASI MASUK
                </button>
            </form>
        </div>
        <p class="text-center mt-10 text-slate-400 font-bold text-sm tracking-wide">
            © 2026 BIBLIOX DIGITAL LIBRARY
        </p>
    </div>
</body>
</html>