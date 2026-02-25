<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BIBLIOX - Perpustakaan Digital Masa Depan</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --secondary: #06b6d4;
            --accent: #8b5cf6;
            --dark: #0f172a;
            --light: #f8fafc;
            --gradient: linear-gradient(135deg, #2563eb, #06b6d4, #8b5cf6);
            --shadow-lg: 0 20px 40px rgba(0, 0, 0, 0.1);
            --shadow-xl: 0 25px 50px rgba(0, 0, 0, 0.15);
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--light);
            color: var(--dark);
            overflow-x: hidden;
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 10px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: var(--primary); border-radius: 5px; }
        
        /* Animations */
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.7; transform: scale(0.9); }
        }
        @keyframes slideInLeft {
            from { transform: translateX(-100px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes slideInRight {
            from { transform: translateX(100px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        /* Navbar */
        nav {
            position: fixed;
            top: 0; left: 0; right: 0;
            height: 80px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(221, 221, 221, 0.2);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 5%;
            z-index: 1000;
            transition: all 0.3s ease;
        }
        
        nav.scrolled { height: 70px; box-shadow: var(--shadow-lg); }
        
        /* NAVBAR LOGO GANTI TEKS */
        .logo-text {
            font-weight: 900;
            font-size: 28px;
            background: var(--gradient);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            background-size: 200% auto;
            animation: gradientShift 5s ease infinite;
            font-style: italic;
            text-transform: uppercase;
        }
        
        .nav-links { display: flex; gap: 30px; align-items: center; }
        .nav-links a {
            text-decoration: none;
            color: var(--dark);
            font-weight: 600;
            position: relative;
            padding: 5px 0;
            transition: color 0.3s;
        }
        .nav-links a:hover { color: var(--primary); }
        .nav-links a::after {
            content: ''; position: absolute; bottom: 0; left: 0;
            width: 0; height: 2px; background: var(--gradient);
            transition: width 0.3s ease;
        }
        .nav-links a:hover::after { width: 100%; }
        
        .auth-buttons { display: flex; gap: 15px; }
        .login-btn, .register-btn {
            padding: 10px 25px; border-radius: 50px;
            font-weight: 700; text-decoration: none;
            transition: all 0.3s ease; display: flex;
            align-items: center; gap: 8px;
        }
        .login-btn { color: var(--primary); border: 2px solid var(--primary); }
        .login-btn:hover { background: var(--primary); color: white; transform: translateY(-3px); }
        .register-btn { background: var(--gradient); color: white; background-size: 200% auto; animation: gradientShift 5s ease infinite; }
        .register-btn:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(37, 99, 235, 0.3); }

        /* Hero Section */
        .hero { min-height: 100vh; display: flex; align-items: center; padding: 120px 5% 80px; position: relative; overflow: hidden; }
        .hero-content {
            max-width: 1200px; margin: 0 auto;
            display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: center;
        }
        h1 { font-size: 4.5rem; font-weight: 900; line-height: 1.1; margin-bottom: 25px; }
        .gradient-text {
            background: var(--gradient); -webkit-background-clip: text;
            background-clip: text; color: transparent;
            background-size: 200% auto; animation: gradientShift 5s ease infinite;
        }
        .hero-description { font-size: 1.2rem; color: #64748b; line-height: 1.6; margin-bottom: 40px; }

        /* Hero Visual - LOGO GERAK */
        .floating-logo-container {
            width: 100%; max-width: 500px; padding: 40px;
            background: white; border-radius: 30px;
            box-shadow: var(--shadow-xl); text-align: center;
            position: relative;
        }
        .main-floating-logo {
            width: 180px; height: auto; margin: 0 auto;
            display: block; animation: float 5s ease-in-out infinite;
            filter: drop-shadow(0 15px 25px rgba(37,99,235,0.2));
        }
        .logo-shadow {
            width: 150px; height: 20px; background: rgba(0,0,0,0.1);
            border-radius: 50%; margin: -10px auto 30px;
            filter: blur(12px); animation: pulse 3s infinite;
        }

        /* Features Section */
        .features { padding: 100px 5%; background: #f1f5f9; position: relative; }
        .section-header { text-align: center; max-width: 800px; margin: 0 auto 70px; }
        .section-title { font-size: 3.5rem; font-weight: 900; margin-bottom: 20px; }
        .features-grid {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 40px; max-width: 1200px; margin: 0 auto;
        }
        .feature-card {
            background: white; border-radius: 20px; padding: 40px 30px;
            box-shadow: var(--shadow-lg); transition: all 0.4s ease;
            position: relative; overflow: hidden;
        }
        .feature-card:hover { transform: translateY(-15px); }
        .feature-icon { font-size: 2rem; color: var(--primary); margin-bottom: 25px; }

        /* Footer */
        footer { background: var(--dark); color: white; padding: 80px 5% 40px; position: relative; }
        .footer-logo-text {
            font-weight: 900; font-size: 28px; background: var(--gradient);
            -webkit-background-clip: text; background-clip: text; color: transparent;
            margin-bottom: 20px; display: inline-block;
        }
        .footer-links a { color: #cbd5e1; text-decoration: none; transition: 0.3s; }
        .footer-links a:hover { color: white; padding-left: 5px; }

        @media (max-width: 768px) {
            h1 { font-size: 2.8rem; }
            .hero-content { grid-template-columns: 1fr; text-align: center; }
            .nav-links { display: none; }
        }
    </style>
</head>
<body>
    <nav id="navbar">
        <div class="logo-text">BIBLIOX</div>
        
        <div class="nav-links">
            <a href="#home">Beranda</a>
            <a href="#features">Fitur</a>
            <a href="#collections">Koleksi</a>
            <a href="#about">Tentang</a>
            <a href="#contact">Kontak</a>
        </div>
        
        <div class="auth-buttons">
            <a href="/login" class="login-btn">Masuk</a>
            <a href="/register" class="register-btn">Daftar</a>
        </div>
    </nav>

    <section class="hero" id="home">
        <div class="hero-content">
            <div class="hero-text">
                <div style="background: rgba(37,99,235,0.1); padding: 10px 20px; border-radius: 50px; display: inline-block; margin-bottom: 30px;">
                    <span style="color: var(--primary); font-weight: 800; font-size: 14px; letter-spacing: 2px;">PUSTAKA DIGITAL MASA KINI</span>
                </div>
                
                <h1>Membaca Buku <br><span class="gradient-text">Tanpa Batas</span></h1>
                
                <p class="hero-description">
                    BIBLIOX menyatukan ribuan pengetahuan dalam satu genggaman Anda. 
                    Akses koleksi eksklusif langsung dari perangkat Anda kapan saja.
                </p>
                
                <div class="cta-buttons" style="display: flex; gap: 20px;">
                    <a href="/register" class="register-btn" style="padding: 18px 35px; border-radius: 15px;">Mulai Sekarang</a>
                    <a href="#features" class="login-btn" style="padding: 18px 35px; border-radius: 15px;">Jelajahi Fitur</a>
                </div>
            </div>
            
            <div class="hero-visual">
                <div class="floating-logo-container">
                    <img src="{{ asset('images/logo-bibliox.png') }}" alt="BiblioX Logo" class="main-floating-logo">
                    <div class="logo-shadow"></div>
                    
                    <div style="margin-top: 20px;">
                        <h3 style="font-weight: 800; font-size: 1.8rem; color: var(--dark);">Koleksi Populer</h3>
                        <p style="color: #64748b; font-weight: 600;">Update Mingguan BIBLIOX</p>
                    </div>

                    <div style="width: 100%; display: flex; flex-direction: column; gap: 15px; margin-top: 30px;">
                        <div style="display: flex; align-items: center; gap: 15px; padding: 15px; background: #f8fafc; border-radius: 15px;">
                            <div style="width: 50px; height: 65px; border-radius: 8px; background: var(--gradient); display: flex; align-items: center; justify-content: center; color: white;">
                                <i class="fas fa-book"></i>
                            </div>
                            <div style="text-align: left;">
                                <h4 style="font-size: 1rem; font-weight: 700;">Seni Berpikir Digital</h4>
                                <p style="font-size: 0.8rem; color: #64748b;">Teknologi & Masa Depan</p>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 15px; padding: 15px; background: #f8fafc; border-radius: 15px;">
                            <div style="width: 50px; height: 65px; border-radius: 8px; background: var(--gradient); display: flex; align-items: center; justify-content: center; color: white;">
                                <i class="fas fa-microchip"></i>
                            </div>
                            <div style="text-align: left;">
                                <h4 style="font-size: 1rem; font-weight: 700;">Quantum Learning</h4>
                                <p style="font-size: 0.8rem; color: #64748b;">Pendidikan & Pengembangan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="features" id="features">
        <div class="section-header">
            <span style="color: var(--primary); font-weight: 800; letter-spacing: 3px;">MENGAPA BIBLIOX?</span>
            <h2 class="section-title">Pengalaman Membaca <span class="gradient-text">Modern</span></h2>
        </div>
        
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-bolt"></i></div>
                <h3 style="margin-bottom: 15px;">Akses Instan</h3>
                <p style="color: #64748b; line-height: 1.6;">Dapatkan akses ke seluruh koleksi kami dalam hitungan detik tanpa perlu menunggu.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-mobile-screen"></i></div>
                <h3 style="margin-bottom: 15px;">Multi-Device</h3>
                <p style="color: #64748b; line-height: 1.6;">Lanjutkan bacaan Anda di smartphone, tablet, atau laptop dengan sinkronisasi otomatis.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-shield-halved"></i></div>
                <h3 style="margin-bottom: 15px;">Keamanan Data</h3>
                <p style="color: #64748b; line-height: 1.6;">Privasi dan riwayat bacaan Anda dilindungi dengan enkripsi keamanan tingkat tinggi.</p>
            </div>
        </div>
    </section>

    <footer id="contact">
        <div style="max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 50px; text-align: left;">
            <div>
                <div class="footer-logo-text">BIBLIOX</div>
                <p style="color: #cbd5e1; line-height: 1.6;">Platform perpustakaan digital terdepan yang menghubungkan pembaca dengan pengetahuan tanpa batas.</p>
            </div>
            <div>
                <h3 style="margin-bottom: 25px;">Tautan Cepat</h3>
                <ul style="list-style: none;" class="footer-links">
                    <li style="margin-bottom: 15px;"><a href="#home">Beranda</a></li>
                    <li style="margin-bottom: 15px;"><a href="#features">Fitur</a></li>
                    <li style="margin-bottom: 15px;"><a href="/login">Masuk Akun</a></li>
                </ul>
            </div>
            <div>
                <h3 style="margin-bottom: 25px;">Kontak Kami</h3>
                <p style="color: #cbd5e1; margin-bottom: 15px;"><i class="fas fa-envelope mr-2"></i> info@bibliox.com</p>
                <p style="color: #cbd5e1;"><i class="fas fa-phone mr-2"></i> +62 123 456 789</p>
            </div>
        </div>
        <div style="text-align: center; padding-top: 40px; margin-top: 60px; border-top: 1px solid rgba(255,255,255,0.1); color: #94a3b8;">
            <p>© 2026 BIBLIOX DIGITAL LIBRARY. Semua hak dilindungi.</p>
        </div>
    </footer>

    <script>
        // Navbar effect
        window.addEventListener('scroll', function() {
            const nav = document.getElementById('navbar');
            if (window.scrollY > 50) nav.classList.add('scrolled');
            else nav.classList.remove('scrolled');
        });

        // Simple Fade In
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.feature-card, .hero-text, .hero-visual').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'all 0.8s ease-out';
            observer.observe(el);
        });
    </script>
</body>
</html>