<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - BIBLIOX</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
        }
        .login-card {
            background: white;
            border-radius: 2rem;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.05);
        }
        .input-field {
            background-color: #eff6ff;
            border: 1px solid #dbeafe;
            transition: all 0.3s ease;
        }
        .input-field:focus {
            background-color: white;
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }
        .btn-primary {
            background: #1d4ed8;
            box-shadow: 0 10px 20px rgba(29, 78, 216, 0.2);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background: #1e40af;
            transform: translateY(-2px);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col items-center justify-center p-6">

    <div class="mb-8 text-center">
        <div class="bg-blue-600 w-12 h-12 rounded-xl flex items-center justify-center text-white font-black text-2xl mx-auto mb-4 shadow-lg shadow-blue-200">
            X
        </div>
        <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight uppercase">BiblioX Register</h1>
        <p class="text-slate-400 text-sm mt-1">Silakan lengkapi data diri Anda</p>
    </div>

    <div class="w-full max-w-[450px] login-card p-10">
        
        {{-- Menampilkan Error Validasi --}}
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-xl">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li class="text-red-600 text-xs font-bold">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FORM ACTION --}}
        <form action="{{ route('register') }}" method="POST" class="space-y-5">
            {{-- WAJIB: Token CSRF untuk mencegah Page Expired --}}
            @csrf

            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Nama Lengkap</label>
                <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Masukkan nama lengkap"
                    class="w-full input-field rounded-xl px-5 py-3.5 text-slate-700 outline-none">
            </div>

            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Username / ID Pengguna</label>
                <input type="text" name="username" value="{{ old('username') }}" required placeholder="Contoh: ryan123"
                    class="w-full input-field rounded-xl px-5 py-3.5 text-slate-700 outline-none">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Kata Sandi</label>
                    <input type="password" name="password" required placeholder="••••••••"
                        class="w-full input-field rounded-xl px-5 py-3.5 text-slate-700 outline-none">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Konfirmasi</label>
                    <input type="password" name="password_confirmation" required placeholder="••••••••"
                        class="w-full input-field rounded-xl px-5 py-3.5 text-slate-700 outline-none">
                </div>
            </div>

            <button type="submit" class="w-full btn-primary text-white py-4 rounded-xl font-bold text-sm italic uppercase tracking-wider mt-4">
                Daftar Sekarang
            </button>
        </form>
    </div>

    <div class="mt-8 text-center">
        <p class="text-slate-400 text-sm">Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-600 font-bold hover:underline">Masuk</a></p>
        <p class="text-[10px] font-bold text-slate-300 uppercase tracking-[0.3em] mt-10">© 2026 BiblioX Digital Library</p>
    </div>

</body>
</html>