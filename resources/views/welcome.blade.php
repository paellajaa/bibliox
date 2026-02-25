<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BIBLIOX - Perpustakaan Digital Masa Depan</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://unpkg.com/@rive-app/canvas@1.0.118"></script>
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
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        html {
            scroll-behavior: smooth;
        }
        
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--light);
            color: var(--dark);
            overflow-x: hidden;
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 5px;
        }
        
        /* Animations */
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
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
            top: 0;
            left: 0;
            right: 0;
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
        
        nav.scrolled {
            height: 70px;
            box-shadow: var(--shadow-lg);
        }
        
        .logo {
            font-weight: 900;
            font-size: 28px;
            background: var(--gradient);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            background-size: 200% auto;
            animation: gradientShift 5s ease infinite;
            position: relative;
            padding-left: 40px;
        }
        
        .logo::before {
            content: "📚";
            position: absolute;
            left: 0;
            font-size: 24px;
        }
        
        .nav-links {
            display: flex;
            gap: 30px;
            align-items: center;
        }
        
        .nav-links a {
            text-decoration: none;
            color: var(--dark);
            font-weight: 600;
            position: relative;
            padding: 5px 0;
            transition: color 0.3s;
        }
        
        .nav-links a:hover {
            color: var(--primary);
        }
        
        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--gradient);
            transition: width 0.3s ease;
        }
        
        .nav-links a:hover::after {
            width: 100%;
        }
        
        .auth-buttons {
            display: flex;
            gap: 15px;
        }
        
        .login-btn, .register-btn {
            padding: 10px 25px;
            border-radius: 50px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .login-btn {
            color: var(--primary);
            border: 2px solid var(--primary);
        }
        
        .login-btn:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(37, 99, 235, 0.2);
        }
        
        .register-btn {
            background: var(--gradient);
            color: white;
            background-size: 200% auto;
            animation: gradientShift 5s ease infinite;
        }
        
        .register-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(37, 99, 235, 0.3);
        }
        
        .mobile-menu-btn {
            display: none;
            font-size: 24px;
            cursor: pointer;
            color: var(--dark);
        }
        
        /* Hero Section */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 120px 5% 80px;
            position: relative;
            overflow: hidden;
        }
        
        .hero-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }
        
        .floating-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
        }
        
        .shape {
            position: absolute;
            border-radius: 50%;
            background: var(--gradient);
            opacity: 0.1;
            animation: float 6s ease-in-out infinite;
        }
        
        .shape:nth-child(1) {
            width: 300px;
            height: 300px;
            top: 10%;
            left: 5%;
            animation-delay: 0s;
        }
        
        .shape:nth-child(2) {
            width: 200px;
            height: 200px;
            top: 60%;
            right: 10%;
            animation-delay: 2s;
            background: linear-gradient(135deg, var(--secondary), var(--accent));
        }
        
        .shape:nth-child(3) {
            width: 150px;
            height: 150px;
            bottom: 20%;
            left: 15%;
            animation-delay: 4s;
            background: linear-gradient(135deg, var(--primary), var(--accent));
        }
        
        .hero-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }
        
        .hero-text {
            animation: slideInLeft 1s ease-out;
        }
        
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: rgba(37, 99, 235, 0.1);
            border: 1px solid rgba(37, 99, 235, 0.2);
            padding: 10px 20px;
            border-radius: 50px;
            margin-bottom: 30px;
        }
        
        .badge-dot {
            width: 10px;
            height: 10px;
            background: var(--primary);
            border-radius: 50%;
            animation: pulse 2s infinite;
        }
        
        .badge-text {
            color: var(--primary);
            font-weight: 800;
            font-size: 14px;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        
        h1 {
            font-size: 4.5rem;
            font-weight: 900;
            line-height: 1.1;
            margin-bottom: 25px;
            background: linear-gradient(135deg, var(--dark) 60%, var(--primary) 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        .gradient-text {
            background: var(--gradient);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            background-size: 200% auto;
            animation: gradientShift 5s ease infinite;
        }
        
        .hero-description {
            font-size: 1.2rem;
            color: #64748b;
            line-height: 1.6;
            margin-bottom: 40px;
            max-width: 90%;
        }
        
        .cta-buttons {
            display: flex;
            gap: 20px;
            margin-bottom: 40px;
        }
        
        .primary-btn, .secondary-btn {
            padding: 18px 35px;
            border-radius: 15px;
            font-weight: 700;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        
        .primary-btn {
            background: var(--gradient);
            color: white;
            border: none;
            box-shadow: 0 10px 30px rgba(37, 99, 235, 0.3);
            background-size: 200% auto;
            animation: gradientShift 5s ease infinite;
        }
        
        .primary-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(37, 99, 235, 0.4);
        }
        
        .secondary-btn {
            background: white;
            color: var(--dark);
            border: 2px solid #e2e8f0;
        }
        
        .secondary-btn:hover {
            border-color: var(--primary);
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        
        .stats {
            display: flex;
            gap: 40px;
        }
        
        .stat-item {
            display: flex;
            flex-direction: column;
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--primary);
        }
        
        .stat-label {
            font-size: 0.9rem;
            color: #64748b;
            font-weight: 600;
        }
        
        .hero-visual {
            position: relative;
            animation: slideInRight 1s ease-out;
        }
        
        /* ===== PERBAIKAN: floating-logo-container dan style pendukung ===== */
        .floating-logo-container {
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
            padding: 30px;
            background: white;
            border-radius: 30px;
            box-shadow: var(--shadow-xl);
            position: relative;
            overflow: hidden;
            text-align: center;
        }

        .main-floating-logo {
            width: 180px;
            height: auto;
            margin: 20px auto;
            display: block;
            animation: float 5s ease-in-out infinite;
            filter: drop-shadow(0 15px 25px rgba(37,99,235,0.25));
            border-radius: 40px;
            background: linear-gradient(145deg, #ffffff, #f0f4ff);
            padding: 25px;
            box-shadow: 0 15px 35px -8px rgba(37,99,235,0.2);
        }

        .logo-shadow {
            width: 160px;
            height: 30px;
            background: rgba(0,0,0,0.1);
            border-radius: 50%;
            margin: -10px auto 30px;
            filter: blur(12px);
            animation: pulse 3s infinite;
        }

        .mt-8 {
            margin-top: 2rem;
        }

        .text-center {
            text-align: center;
        }

        .text-2xl {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 8px;
        }

        .text-slate-500 {
            color: #64748b;
            font-weight: 500;
        }

        .font-bold {
            font-weight: 700;
        }

        .book-list {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: 20px;
        }
        
        .book-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            background: #f8fafc;
            border-radius: 15px;
            transition: transform 0.3s ease;
        }
        
        .book-item:hover {
            transform: translateX(10px);
            background: #f1f5f9;
        }
        
        .book-cover {
            width: 50px;
            height: 65px;
            border-radius: 8px;
            background: var(--gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
        }
        
        .book-info h4 {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .book-info p {
            font-size: 0.8rem;
            color: #64748b;
        }
        
        .card-bg {
            position: absolute;
            bottom: -100px;
            right: -100px;
            width: 300px;
            height: 300px;
            background: var(--gradient);
            opacity: 0.1;
            border-radius: 50%;
            z-index: 1;
        }
        /* ===== AKHIR PERBAIKAN ===== */
        
        /* Features Section */
        .features {
            padding: 100px 5%;
            background: #f1f5f9;
            position: relative;
            overflow: hidden;
        }
        
        .section-header {
            text-align: center;
            max-width: 800px;
            margin: 0 auto 70px;
        }
        
        .section-subtitle {
            color: var(--primary);
            font-weight: 800;
            font-size: 1rem;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 15px;
            display: block;
        }
        
        .section-title {
            font-size: 3.5rem;
            font-weight: 900;
            margin-bottom: 20px;
            background: linear-gradient(135deg, var(--dark) 60%, var(--primary) 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        .section-description {
            font-size: 1.2rem;
            color: #64748b;
            line-height: 1.6;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 40px;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .feature-card {
            background: white;
            border-radius: 20px;
            padding: 40px 30px;
            box-shadow: var(--shadow-lg);
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        
        .feature-card:hover {
            transform: translateY(-15px);
            box-shadow: var(--shadow-xl);
        }
        
        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: var(--gradient);
            z-index: 2;
        }
        
        .feature-icon {
            width: 70px;
            height: 70px;
            background: rgba(37, 99, 235, 0.1);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 25px;
            font-size: 1.8rem;
            color: var(--primary);
        }
        
        .feature-title {
            font-size: 1.5rem;
            font-weight: 800;
            margin-bottom: 15px;
            color: var(--dark);
        }
        
        .feature-description {
            color: #64748b;
            line-height: 1.6;
        }
        
        /* Footer */
        footer {
            background: var(--dark);
            color: white;
            padding: 80px 5% 40px;
            position: relative;
            overflow: hidden;
        }
        
        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 50px;
            margin-bottom: 60px;
        }
        
        .footer-logo {
            font-weight: 900;
            font-size: 28px;
            margin-bottom: 20px;
            background: var(--gradient);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            display: inline-block;
        }
        
        .footer-description {
            color: #cbd5e1;
            line-height: 1.6;
            margin-bottom: 25px;
        }
        
        .social-links {
            display: flex;
            gap: 15px;
        }
        
        .social-link {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }
        
        .social-link:hover {
            background: var(--primary);
            transform: translateY(-5px);
        }
        
        .footer-heading {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 25px;
            color: white;
        }
        
        .footer-links {
            list-style: none;
        }
        
        .footer-links li {
            margin-bottom: 15px;
        }
        
        .footer-links a {
            color: #cbd5e1;
            text-decoration: none;
            transition: color 0.3s;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .footer-links a:hover {
            color: white;
            gap: 15px;
        }
        
        .footer-bottom {
            text-align: center;
            padding-top: 40px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: #94a3b8;
            font-size: 0.9rem;
        }
        
        /* Animasi saat scroll */
        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease;
        }
        
        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Rive Animation Container */
        #rive-animation {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }
        
        /* Responsiveness */
        @media (max-width: 1024px) {
            h1 {
                font-size: 3.5rem;
            }
            
            .hero-content {
                grid-template-columns: 1fr;
                text-align: center;
                gap: 40px;
            }
            
            .hero-description {
                max-width: 100%;
                margin-left: auto;
                margin-right: auto;
            }
            
            .cta-buttons, .stats {
                justify-content: center;
            }
            
            .section-title {
                font-size: 2.8rem;
            }
        }
        
        @media (max-width: 768px) {
            nav {
                padding: 0 20px;
            }
            
            .nav-links {
                display: none;
            }
            
            .mobile-menu-btn {
                display: block;
            }
            
            h1 {
                font-size: 2.8rem;
            }
            
            .hero {
                padding: 100px 20px 60px;
            }
            
            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .primary-btn, .secondary-btn {
                width: 100%;
                justify-content: center;
            }
            
            .stats {
                flex-direction: column;
                gap: 25px;
            }
            
            .section-title {
                font-size: 2.2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav id="navbar">
        <div class="logo">BIBLIOX</div>
        
        <div class="nav-links">
            <a href="#home">Beranda</a>
            <a href="#features">Fitur</a>
            <a href="#collections">Koleksi</a>
            <a href="#about">Tentang</a>
            <a href="#contact">Kontak</a>
        </div>
        
        <div class="auth-buttons">
            <a href="/login" class="login-btn">
                <i class="fas fa-sign-in-alt"></i> Masuk
            </a>
            <a href="/register" class="register-btn">
                <i class="fas fa-user-plus"></i> Daftar
            </a>
        </div>
        
        <div class="mobile-menu-btn">
            <i class="fas fa-bars"></i>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="hero-bg">
            <div class="floating-shapes">
                <div class="shape"></div>
                <div class="shape"></div>
                <div class="shape"></div>
            </div>
            <!-- Rive Animation Container -->
            <div id="rive-animation"></div>
        </div>
        
        <div class="hero-content">
            <div class="hero-text">
                <div class="badge">
                    <div class="badge-dot"></div>
                    <span class="badge-text">Pustaka Digital Masa Kini</span>
                </div>
                
                <h1>
                    Membaca Buku 
                    <span class="gradient-text">Tanpa Batas</span>
                </h1>
                
                <p class="hero-description">
                    BIBLIOX menyatukan ribuan pengetahuan dalam satu genggaman Anda. 
                    Akses koleksi eksklusif langsung dari perangkat Anda kapan saja, di mana saja, 
                    dengan pengalaman membaca yang tak tertandingi.
                </p>
                
                <div class="cta-buttons">
                    <a href="/register" class="primary-btn">
                        <i class="fas fa-play-circle"></i> Mulai Sekarang
                    </a>
                    <a href="#features" class="secondary-btn">
                        <i class="fas fa-info-circle"></i> Jelajahi Fitur
                    </a>
                </div>
                
                <div class="stats">
                    <div class="stat-item">
                        <div class="stat-number">50K+</div>
                        <div class="stat-label">Buku Digital</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">100+</div>
                        <div class="stat-label">Penerbit</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">24/7</div>
                        <div class="stat-label">Akses Tanpa Batas</div>
                    </div>
                </div>
            </div>
            
            <!-- ===== BAGIAN HERO VISUAL YANG SUDAH DIPERBAIKI ===== -->
            <div class="hero-visual">
                <div class="floating-logo-container fade-in">
                    <!-- Menggunakan data URI sementara agar tampil sebagai logo (simulasi gambar) -->
                    <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200' viewBox='0 0 100 100'%3E%3Crect width='100' height='100' rx='25' fill='url(%23g)' /%3E%3Cdefs%3E%3ClinearGradient id='g' x1='0%25' y1='0%25' x2='100%25' y2='100%25'%3E%3Cstop offset='0%25' stop-color='%232563eb'/%3E%3Cstop offset='50%25' stop-color='%2306b6d4'/%3E%3Cstop offset='100%25' stop-color='%238b5cf6'/%3E%3C/linearGradient%3E%3C/defs%3E%3Ctext x='20' y='65' font-family='Arial' font-size='36' font-weight='bold' fill='white'%3EBX%3C/text%3E%3C/svg%3E" 
                         alt="BiblioX Logo" class="main-floating-logo">
                    
                    <div class="logo-shadow"></div>
                    
                    <div class="mt-8 text-center">
                        <h3 class="text-2xl font-bold text-slate-800">Koleksi Populer</h3>
                        <p class="text-slate-500 font-medium">Update Mingguan BIBLIOX</p>
                    </div>

                    <div class="book-list">
                        <div class="book-item">
                            <div class="book-cover">
                                <i class="fas fa-book"></i>
                            </div>
                            <div class="book-info">
                                <h4>Seni Berpikir Digital</h4>
                                <p>Teknologi & Masa Depan</p>
                            </div>
                        </div>
                        <div class="book-item">
                            <div class="book-cover">
                                <i class="fas fa-atom"></i>
                            </div>
                            <div class="book-info">
                                <h4>Quantum Learning</h4>
                                <p>Pendidikan & Pengembangan</p>
                            </div>
                        </div>
                        <div class="book-item">
                            <div class="book-cover">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div class="book-info">
                                <h4>Ekonomi Kreatif</h4>
                                <p>Bisnis & Kewirausahaan</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-bg"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="section-header fade-in">
            <span class="section-subtitle">Mengapa Memilih BIBLIOX</span>
            <h2 class="section-title">Pengalaman Membaca <span class="gradient-text">Revolusioner</span></h2>
            <p class="section-description">
                Kami menggabungkan teknologi terkini dengan konten berkualitas tinggi 
                untuk menciptakan platform perpustakaan digital yang tak tertandingi.
            </p>
        </div>
        
        <div class="features-grid">
            <div class="feature-card fade-in">
                <div class="feature-icon">
                    <i class="fas fa-bolt"></i>
                </div>
                <h3 class="feature-title">Akses Instan</h3>
                <p class="feature-description">
                    Dapatkan akses ke seluruh koleksi kami dalam hitungan detik. 
                    Tidak perlu menunggu, langsung baca buku favorit Anda.
                </p>
            </div>
            
            <div class="feature-card fade-in">
                <div class="feature-icon">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <h3 class="feature-title">Multi-Device</h3>
                <p class="feature-description">
                    Akses dari smartphone, tablet, atau laptop. 
                    Sinkronisasi otomatis memungkinkan Anda melanjutkan bacaan dari perangkat mana pun.
                </p>
            </div>
            
            <div class="feature-card fade-in">
                <div class="feature-icon">
                    <i class="fas fa-headset"></i>
                </div>
                <h3 class="feature-title">Audio Books</h3>
                <p class="feature-description">
                    Nikmati buku dalam format audio dengan narasi profesional. 
                    Sempurna untuk mendengarkan saat bepergian atau beraktivitas.
                </p>
            </div>
            
            <div class="feature-card fade-in">
                <div class="feature-icon">
                    <i class="fas fa-user-friends"></i>
                </div>
                <h3 class="feature-title">Komunitas</h3>
                <p class="feature-description">
                    Bergabung dengan komunitas pembaca, berdiskusi tentang buku, 
                    dan dapatkan rekomendasi bacaan yang dipersonalisasi.
                </p>
            </div>
            
            <div class="feature-card fade-in">
                <div class="feature-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3 class="feature-title">Analitik Membaca</h3>
                <p class="feature-description">
                    Lacak progres membaca, atur target, dan dapatkan insight 
                    tentang kebiasaan membaca Anda untuk pengembangan diri.
                </p>
            </div>
            
            <div class="feature-card fade-in">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3 class="feature-title">Keamanan Data</h3>
                <p class="feature-description">
                    Data dan riwayat membaca Anda dilindungi dengan enkripsi tingkat tinggi. 
                    Privasi Anda adalah prioritas kami.
                </p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact">
        <div class="footer-content">
            <div class="footer-col">
                <div class="footer-logo">BIBLIOX</div>
                <p class="footer-description">
                    Platform perpustakaan digital terdepan yang menghubungkan 
                    pembaca dengan pengetahuan tanpa batas melalui teknologi modern.
                </p>
                <div class="social-links">
                    <a href="#" class="social-link">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="social-link">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="social-link">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="social-link">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>
            
            <div class="footer-col">
                <h3 class="footer-heading">Tautan Cepat</h3>
                <ul class="footer-links">
                    <li><a href="#home"><i class="fas fa-chevron-right"></i> Beranda</a></li>
                    <li><a href="#features"><i class="fas fa-chevron-right"></i> Fitur</a></li>
                    <li><a href="#collections"><i class="fas fa-chevron-right"></i> Koleksi</a></li>
                    <li><a href="#about"><i class="fas fa-chevron-right"></i> Tentang Kami</a></li>
                    <li><a href="#contact"><i class="fas fa-chevron-right"></i> Kontak</a></li>
                </ul>
            </div>
            
            <div class="footer-col">
                <h3 class="footer-heading">Layanan</h3>
                <ul class="footer-links">
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Buku Digital</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Audio Books</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Majalah Online</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Research Papers</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Komunitas</a></li>
                </ul>
            </div>
            
            <div class="footer-col">
                <h3 class="footer-heading">Kontak</h3>
                <ul class="footer-links">
                    <li><a href="#"><i class="fas fa-map-marker-alt"></i> Jakarta, Indonesia</a></li>
                    <li><a href="mailto:info@bibliox.com"><i class="fas fa-envelope"></i> info@bibliox.com</a></li>
                    <li><a href="tel:+62123456789"><i class="fas fa-phone"></i> +62 123 456 789</a></li>
                    <li><a href="#"><i class="fas fa-clock"></i> Buka 24/7</a></li>
                </ul>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>© 2026 BIBLIOX DIGITAL LIBRARY. Semua hak dilindungi.</p>
        </div>
    </footer>

    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Scroll animation for elements
        const fadeElements = document.querySelectorAll('.fade-in');
        
        const fadeInOnScroll = function() {
            fadeElements.forEach(element => {
                const elementTop = element.getBoundingClientRect().top;
                const elementVisible = 150;
                
                if (elementTop < window.innerHeight - elementVisible) {
                    element.classList.add('visible');
                }
            });
        };
        
        window.addEventListener('scroll', fadeInOnScroll);
        // Trigger once on load
        fadeInOnScroll();

        // Mobile menu toggle
        const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
        const navLinks = document.querySelector('.nav-links');
        
        mobileMenuBtn.addEventListener('click', function() {
            navLinks.style.display = navLinks.style.display === 'flex' ? 'none' : 'flex';
            if (navLinks.style.display === 'flex') {
                navLinks.style.flexDirection = 'column';
                navLinks.style.position = 'absolute';
                navLinks.style.top = '80px';
                navLinks.style.right = '20px';
                navLinks.style.background = 'white';
                navLinks.style.padding = '20px';
                navLinks.style.borderRadius = '10px';
                navLinks.style.boxShadow = '0 10px 30px rgba(0,0,0,0.1)';
                navLinks.style.width = '200px';
            }
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;
                
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });
                    
                    // Close mobile menu if open
                    if (window.innerWidth <= 768) {
                        navLinks.style.display = 'none';
                    }
                }
            });
        });

        // Rive fallback
        if (typeof rive !== 'undefined') {
            try {
                const r = new rive.Rive({
                    src: 'https://cdn.rive.app/animations/off_road_car_v7.riv',
                    canvas: document.getElementById('rive-animation'),
                    autoplay: true,
                    stateMachines: 'state_machine_name',
                    onLoad: () => {
                        r.resizeDrawingSurfaceToCanvas();
                    },
                });
            } catch (e) {
                fallbackRive();
            }
        } else {
            fallbackRive();
        }

        function fallbackRive() {
            const riveContainer = document.getElementById('rive-animation');
            riveContainer.style.background = 'linear-gradient(135deg, #2563eb, #06b6d4, #8b5cf6)';
            riveContainer.style.backgroundSize = '400% 400%';
            riveContainer.style.animation = 'gradientShift 15s ease infinite';
            riveContainer.style.opacity = '0.05';
        }

        // Interactive stats counter
        const statNumbers = document.querySelectorAll('.stat-number');
        const statsSection = document.querySelector('.hero');
        
        const animateStats = function() {
            statNumbers.forEach(stat => {
                const target = parseInt(stat.textContent);
                let current = 0;
                const increment = target / 50;
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        stat.textContent = target + (stat.textContent.includes('+') ? '+' : '');
                        clearInterval(timer);
                    } else {
                        stat.textContent = Math.floor(current) + (stat.textContent.includes('+') ? '+' : '');
                    }
                }, 30);
            });
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateStats();
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });
        
        observer.observe(statsSection);

        // Hover effect feature cards
        const featureCards = document.querySelectorAll('.feature-card');
        featureCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-15px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Typing effect for gradient-text (optional)
        const heroTitleSpan = document.querySelector('.gradient-text');
        if (heroTitleSpan) {
            const texts = ['Tanpa Batas', 'Dimana Saja', 'Kapan Saja', 'Gratis Akses'];
            let currentTextIndex = 0;
            
            function typeEffect() {
                let currentText = texts[currentTextIndex];
                let charIndex = 0;
                let isDeleting = false;
                
                function type() {
                    if (isDeleting) {
                        heroTitleSpan.textContent = currentText.substring(0, charIndex - 1);
                        charIndex--;
                    } else {
                        heroTitleSpan.textContent = currentText.substring(0, charIndex + 1);
                        charIndex++;
                    }
                    
                    if (!isDeleting && charIndex === currentText.length) {
                        isDeleting = true;
                        setTimeout(type, 2000);
                    } else if (isDeleting && charIndex === 0) {
                        isDeleting = false;
                        currentTextIndex = (currentTextIndex + 1) % texts.length;
                        currentText = texts[currentTextIndex];
                        setTimeout(type, 500);
                    } else {
                        setTimeout(type, isDeleting ? 50 : 100);
                    }
                }
                type();
            }
            setTimeout(typeEffect, 3000);
        }
    </script>
</body>
</html>