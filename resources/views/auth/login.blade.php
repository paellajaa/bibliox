<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - BIBLIOX Digital</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700;800&display=swap" rel="stylesheet">
    <style>
        @keyframes slideDown {
            from { transform: translateY(-10px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .animate-slideDown { animation: slideDown 0.4s ease-out; }
    </style>
</head>
<body class="bg-[#F8FAFC] flex items-center justify-center min-h-screen p-6 font-['Plus_Jakarta_Sans']">
    <div class="w-full max-w-md">
        <div class="flex flex-col items-center justify-center mb-4">
            <img src="{{ asset('images/logo-bibliox.png') }}" alt="BiblioX" 
                class="w-36 h-36 object-contain drop-shadow-lg">
            <p class="text-slate-400 mt-2 font-medium">Silakan masuk ke akun Anda</p>
        </div>

        {{-- Pesan Sukses (Misal setelah register) --}}
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 rounded-r-xl animate-slideDown text-sm font-bold">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white p-10 rounded-[40px] shadow-xl shadow-slate-200/50 border border-slate-100">
            {{-- Menampilkan Error Kredensial --}}
            @if($errors->has('username'))
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-600 rounded-r-xl animate-slideDown text-sm font-bold">
                    {{ $errors->first('username') }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3 ml-1">Alamat Email / ID</label>
                    <input type="text" name="username" value="{{ old('username') }}" 
                        class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 text-slate-900 focus:ring-4 focus:ring-blue-100 focus:border-blue-600 outline-none transition-all font-semibold @error('username') border-red-300 @enderror" 
                        placeholder="nama@email.com atau ID" required autofocus>
                </div>
                
                <div>
                    <div class="flex justify-between items-center mb-3 ml-1">
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest">Kata Sandi</label>
                    </div>
                    <input type="password" name="password" 
                        class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 text-slate-900 focus:ring-4 focus:ring-blue-100 focus:border-blue-600 outline-none transition-all font-semibold" 
                        placeholder="••••••••" required>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="w-4 h-4 text-blue-600 rounded border-slate-300 focus:ring-blue-500">
                    <label for="remember" class="ml-2 text-sm font-bold text-slate-500">Ingat Saya</label>
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-5 rounded-2xl transition-all shadow-xl shadow-blue-200 active:scale-[0.98]">
                    OTENTIKASI MASUK
                </button>
            </form>
        </div>

        <div class="text-center mt-8">
            <p class="text-slate-400 font-medium">Belum punya akun? 
                <a href="{{ route('register') }}" class="text-blue-600 font-bold hover:underline">Daftar Sekarang</a>
            </p>
        </div>
        
        <p class="text-center mt-10 text-slate-300 font-bold text-[10px] tracking-[0.2em] uppercase">
            © 2026 BIBLIOX DIGITAL LIBRARY
        </p>
    </div>
</body>
</html>