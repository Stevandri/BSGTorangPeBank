<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman Berhasil!</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-success bg-opacity-10">

    <!-- Navbar -->
    <div class="container-fluid p-0">
        <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold text-danger" href="{{ route('dashboard') }}">GoPinjam</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link active" href="{{ route('scanner') }}">Pinjam Berkas</a></li>
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

    <!-- Peminjaman Berhasil Card -->
    <div class="d-flex justify-content-center mt-5">
        <div class="card shadow-sm text-center p-4" style="max-width: 500px;">
            <div class="mb-3">
                <span class="display-1 text-success">&#10004;</span>
            </div>
            <h1 class="h3 text-success mb-3">Peminjaman Berhasil!</h1>
            <p class="mb-4 text-dark">
                @if (session('success'))
                    {{ session('success') }}
                @else
                    Berkas berhasil dicatat sebagai dipinjam.
                @endif
            </p>
            <a href="{{ route('dashboard') }}" class="btn btn-primary">Kembali ke Beranda</a>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
