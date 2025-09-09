<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Ketersediaan Berkas</title>
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>



</style>
<body class="bg-light">

    <!-- Navbar -->
    <div class="container-fluid p-0">
        <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm mb-4">
            <div class="container">
                <a class="navbar-brand fw-bold text-danger fs-4" href="{{ route('dashboard') }}">
                    GoPinjam
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link fw-semibold" href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link fw-semibold" href="{{ route('user.my-borrowings') }}">Pinjaman-ku</a></li>
                        <li class="nav-item"><a class="nav-link active fw-semibold" href="{{ route('user.check-availability') }}">Cek berkas tersedia</a></li>
                    </ul>

                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle fw-bold text-dark" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                {{ Auth::user()->name ?? 'Guest' }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}"> Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger"> Log Out</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

   {{-- isi --}}
<div class="container py-3">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-9 col-xl-8"> 
            <div class="card shadow rounded-4 p-3 mx-auto">
                <div class="card-header bg-primary text-white rounded-top-4">
                    <h2 class="h5 mb-0">
                        <i class="bi bi-search me-2"></i> Cek Ketersediaan Berkas
                    </h2>
                </div>
                <div class="card-body p-4">
                    <!-- Form pencarian -->
                    <form action="{{ route('user.check-availability') }}" method="GET" class="row g-2 mb-3">
                        <div class="col-12 col-md-9">
                            <input type="text" 
                                name="unique_code" 
                                placeholder="Masukkan Nomor Akad Kredit" 
                                value="{{ $uniqueCode }}" 
                                required 
                                class="form-control rounded-pill shadow-sm">
                        </div>
                        <div class="col-12 col-md-3 d-grid">
                            <button type="submit" class="btn btn-primary rounded-pill shadow-sm">
                                <i class="bi bi-search"></i> Cari
                            </button>
                        </div>
                    </form>

                    <!-- Jika item ditemukan -->
                    @isset($item)
                        <div class="mt-4 p-4 border rounded-3 shadow-sm bg-light">
                            <h3 class="h6 fw-bold text-primary">{{ $item->name }}</h3>
                            <p class="text-muted mb-3">Kode Unik: <span class="fw-semibold">{{ $item->unique_code }}</span></p>

                            @if ($activeBorrowing)
                                <div class="alert alert-danger mb-0 rounded-3">
                                    <p class="mb-1"><strong>Status:</strong> Sedang Dipinjam</p>
                                    <p class="mb-1">Oleh: {{ $activeBorrowing->user->name ?? 'Pengguna tidak diketahui' }}</p>
                                    <p class="mb-0">Sejak: {{ $activeBorrowing->borrowed_at->format('d M Y H:i') }}</p>
                                </div>
                            @else
                                <div class="alert alert-success mb-0 rounded-3">
                                    <p class="mb-0"><strong>Status:</strong> Tersedia untuk Dipinjam ✅</p>
                                </div>
                            @endif
                        </div>
                    @endisset

                    <!-- Jika kode unik tidak ditemukan -->
                    @if ($uniqueCode && !$item)
                        <div class="alert alert-warning mt-4 mb-0 rounded-3">
                            Berkas dengan Nomor Akad Kredit "<strong>{{ $uniqueCode }}</strong>" tidak ditemukan.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
