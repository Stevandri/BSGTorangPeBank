<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GoPinjam</title>
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            background-color: #000;
            background-image: url("bglogin.png");
            background-size: cover;
            background-repeat: no-repeat;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar-custom {
            width: 100%;
            background-color: #fff;
            padding: 0.5rem 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        .navbar-brand img {
            height: 30px;
        }

        .main-content {
            flex: 1; 
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }

        .login-container {
            width: 100%;
            max-width: 1000px;
            background-color: #fff;
            border-radius: 1.5rem;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .form-section {
            padding: 3rem;
        }

        .form-control {
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
        }

        .btn-login {
            background-color: #000;
            color: #fff;
            border-radius: 0.75rem;
            padding: 0.75rem;
            font-weight: bold;
        }

        .btn-login:hover {
            background-color: #333;
            color: #fff;
        }

        .illustration-section {
            background: #f8f9fa;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 2rem;
        }
        
        .illustration-img {
            max-width: 80%;
            height: auto;
        }
        
        @media (max-width: 991.98px) {
            .illustration-section {
                display: none; /* Hilangkan ilustrasi di mobile */
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand" href="https://www.banksulutgo.co.id/">
                <img src="logo.png" alt="Logo BSG">
            </a>
        </div>
    </nav>

    <div class="main-content">
        <div class="login-container row mx-0">
            
            <!-- Bagian Form -->
            <div class="col-md-6 d-flex flex-column justify-content-center form-section">
                @php
                    date_default_timezone_set('Asia/Jakarta');
                    $hour = date('H');
                    $greeting = '';
                    if ($hour >= 5 && $hour < 12) {
                        $greeting = 'Selamat Pagi';
                    } elseif ($hour >= 12 && $hour < 18) {
                        $greeting = 'Selamat Siang';
                    } else {
                        $greeting = 'Selamat Malam';
                    }
                @endphp
                <h2><b>Halo, {{ $greeting }}!</b></h2>
                <p class="text-muted mb-4">Setiap Berkas Terdaftar, Setiap Peminjaman Terdata.</p>
                <x-auth-session-status class="mb-4" :status="session('status')" />
                @if ($errors->any() || session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        @if (session('error'))
                            {{ session('error') }}
                        @else
                            Terdapat kesalahan pada input Anda.
                        @endif
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Masukkan email" value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 position-relative">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password" required autocomplete="current-password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-login bg-danger">Masuk</button>
                    </div>
                </form>
            </div>

            <!-- Bagian Ilustrasi (hanya tampil di desktop) -->
            <div class="col-md-6 illustration-section d-none d-md-flex">
                <img src="ilustrasilogin.png" alt="Illustration" class="illustration-img">
                <h3 class="mt-4 text-danger"><b>Mari bertumbuh, raih prestasi bersama BSG!</b></h3>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    
</body>
</html>
