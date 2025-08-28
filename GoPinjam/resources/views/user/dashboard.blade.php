<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>GoPinjam</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f8f9fc;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Navbar */
        .navbar {
            border-radius: 0 0 15px 15px;
        }

        /* Card background custom */
        .modifstev {
            background-image: url(ilustrasiterdaftar.png);
            background-repeat: no-repeat;
            background-size: cover;
            border-radius: 20px;
            backdrop-filter: blur(6px);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .modifstev3 {
            background-image: url(ilustrasidipinjam.png);
            background-repeat: no-repeat;
            background-size: cover;
            border-radius: 20px;
            backdrop-filter: blur(6px);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        /* Hover effect untuk card */
        .modifstev:hover,
        .modifstev3:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }

        /* Judul dashboard */
        h2.h3 {
            font-weight: 700;
            color: #343a40;
        }

        /* Tabel */
        table {
            border-radius: 10px;
            overflow: hidden;
        }
        .table thead {
            background: #ffeded;
            color: #b71c1c;
        }
        .table tbody tr:hover {
            background: #fdf2f2;
        }

        /* Badge */
        .badge {
            padding: 8px 12px;
            font-size: 0.85rem;
            border-radius: 12px;
        }
    </style>
</head>
<body class="font-sans antialiased">
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
                        <li class="nav-item"><a class="nav-link active fw-semibold" href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link fw-semibold" href="{{ route('user.my-borrowings') }}">Pinjaman-ku</a></li>
                        <li class="nav-item"><a class="nav-link fw-semibold" href="{{ route('user.check-availability') }}">Cek berkas tersedia</a></li>
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

    <!-- Konten Dashboard -->
    <div class="container py-4">
        <h2 class="h3 mb-5">Halo, {{ Auth::user()->name ?? 'Guest' }}</h2>
        
        <div class="row g-4">
            <!-- Card Total Berkas Dipinjam -->
            <div class="col-lg-6">
                <a class="nav-link fw-semibold" href="{{ route('user.my-borrowings') }}">
                <div class="card h-100 shadow border-0 modifstev text-white" style="min-height: 220px;">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <h5 class="card-title fw-bold">Total Berkas Dipinjam</h5>
                        <h1 class="display-3 fw-bold">{{ $totalBorrowedByUser }}</h1>
                    </div>
                </div>
                </a>
            </div>
            
            <!-- Card Berkas Aktif Dipinjam -->
            <div class="col-lg-6">
                <a class="nav-link fw-semibold" href="{{ route('user.my-borrowings') }}">
                <div class="card h-100 shadow border-0 modifstev3 text-white" style="min-height: 220px;">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <h5 class="card-title fw-bold">Berkas Aktif Dipinjam</h5>
                        <h1 class="display-3 fw-bold">{{ $activeBorrowedByUser }}</h1>
                    </div>
                </div>
                </a>
            </div>
        </div>

        <!-- Riwayat -->
        <div class="mt-5">
            <h3 class="h5 fw-bold mb-3">5 Riwayat Peminjaman Terbaru</h3>
            <div class="table-responsive shadow-sm">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>Nama Debitur</th>
                            <th>Waktu Pinjam</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentBorrowings as $borrowing)
                            <tr>
                                <td>{{ $borrowing->item->name ?? 'N/A' }}</td>
                                <td>{{ $borrowing->borrowed_at->format('d M Y H:i') }}</td>
                                <td>
                                    @if ($borrowing->returned_at)
                                        <span class="badge bg-success">✔ Sudah Dikembalikan</span>
                                    @else
                                        <span class="badge bg-danger">⏳ Sedang Dipinjam</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-4">
                                    Belum ada riwayat peminjaman
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
