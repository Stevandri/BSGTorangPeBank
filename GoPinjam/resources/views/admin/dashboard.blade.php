<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>GoPinjam</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
</head>

<style>
    /* ini untuk bg dashboard untuk berkas tersedia */
    .modifstev{
        background-image: url(ilustrasiterdaftar.png);
        background-repeat: no-repeat;
        background-size: cover;
    }

    /* ini untuk bg dashboard untuk berkas siap dipinjam */
    .modifstev2{
        background-image: url(ilustrasitersedia.png);
        background-repeat: no-repeat;
        background-size: cover;
    }

    /* ini untuk bg dashboard untuk berkas sedang dipinjam */
    .modifstev3{
        background-image: url(ilustrasidipinjam.png);
        background-repeat: no-repeat;
        background-size: cover;
    }

.ataszindex{
    z-index: 10;
}
</style>


<body class="font-sans antialiased">
    <div class="container-fluid p-0">
        <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold text-danger" href="{{ route('dashboard') }}">GoPinjam</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('scanner') }}">Pinjam Berkas</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('borrowings.active') }}">Peminjaman Aktif</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('items.create') }}">Daftarkan Berkas</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('borrowings.history') }}">Riwayat Pinjam</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Lainnya</a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ route('admin.items.index') }}">Semua berkas</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.users.index') }}">Semua Pengguna</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.users.create') }}">Tambah Pengguna</a></li>
                        </ul>
                    </li>
                </ul>

                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fw-bold" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            {{ Auth::user()->name ?? 'Guest' }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Log Out</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    </div>

    <div class="container py-4">
        <h2 class="h3 mb-5">Dashboard Admin</h2>
        
        <div class="row g-4">
            <!-- Card Berkas Terdaftar -->
            <div class="col-lg-4 col-lg-3">
                <div class="card h-100 shadow border-0 modifstev text-white">
                        <a href="{{ route('admin.items.index') }}" class="text-white text-decoration-none small">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Berkas Terdaftar</h5>
                        <h1 class="display-3 fw-bold pe-3">{{ $totalItems }}</h1>
                            Lihat berkas terdaftar &gt;
                    </div>
                    </a>
                </div>
            </div>
            
            <!-- Card Siap Dipinjam -->
            <div class="col-lg-4 col-lg-3">
                <div class="card h-100 shadow border-0 modifstev2 text-white">
                    <a href="{{ route('admin.items.index', ['status' => 'available']) }}" class="text-white text-decoration-none small">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Siap dipinjam</h5>
                        <h1 class="display-3 fw-bold">{{ $availableItems }}</h1>
                            Lihat berkas siap dipinjam >&gt;
                    </div>
                    </a>
                </div>
            </div>

            <!-- Card Sedang Dipinjam -->
            <div class="col-lg-4 col-lg-3">
                <div class="card h-100 shadow border-0 modifstev3 text-white">
                    <a href="{{ route('borrowings.active') }}" class="text-white text-decoration-none small">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Sedang dipinjam</h5>
                        <h1 class="display-3 fw-bold">{{ $borrowedItems }}</h1>
                            Lihat berkas dipinjam &gt;
                    </div>
                    </a>

                </div>
            </div>
            
            <!-- Card Aksi -->
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 shadow border-0">
                    <div class="card-body">
                        <h5 class="card-title text-muted fw-bold mb-3">Aksi</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><a href="{{ route('scanner') }}" class="text-dark text-decoration-none">Pinjam Berkas</a></li>
                            <li class="list-group-item"><a href="{{ route('borrowings.active') }}" class="text-dark text-decoration-none">Berkas Aktif</a></li>
                            <li class="list-group-item"><a href="{{ route('items.create') }}" class="text-dark text-decoration-none">Daftar Berkas</a></li>
                            <li class="list-group-item"><a href="{{ route('borrowings.history') }}" class="text-dark text-decoration-none">Riwayat Peminjaman</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
