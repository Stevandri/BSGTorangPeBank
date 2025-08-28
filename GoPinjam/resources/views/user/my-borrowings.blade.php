<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berkas Pinjaman Saya</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f8f9fa;
        }
        .page-title {
            background: linear-gradient(135deg, #0d6efd, #6610f2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .card-custom {
            border-radius: 1rem;
            border: none;
            box-shadow: 0 6px 18px rgba(0,0,0,0.08);
        }
        .table-hover tbody tr:hover {
            background-color: #f1f5ff;
            transition: background 0.3s ease;
        }
        .form-select, .btn {
            border-radius: 0.6rem;
        }
    </style>
</head>
<body>

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
                        <li class="nav-item"><a class="nav-link  fw-semibold" href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link active fw-semibold" href="{{ route('user.my-borrowings') }}">Pinjaman-ku</a></li>
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

    {{-- isi --}}
    <div class="container py-3">
        <h2 class="fw-bold mb-4 text-center page-title">{{ __('Berkas Pinjaman Saya') }}</h2>

        <div class="card card-custom">
            <div class="card-body">
                
                <!-- Filter -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <form action="{{ route('user.my-borrowings') }}" method="GET" class="d-flex align-items-center gap-3 flex-wrap">
                        <label for="status" class="form-label mb-0 fw-semibold">Filter Status:</label>
                        <select name="status" id="status" class="form-select">
                            <option value="">Semua</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Sedang Dipinjam</option>
                            <option value="returned" {{ request('status') === 'returned' ? 'selected' : '' }}>Telah Dikembalikan</option>
                        </select>
                        <button type="submit" class="btn btn-primary px-4">Filter</button>
                    </form>
                </div>

                <!-- Tabel -->
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-primary text-center">
                            <tr>
                                <th>No</th>
                                <th>Nama Debitur</th>
                                <th>Nomor Akad Kredit</th>
                                <th>Status</th>
                                <th>Peminjam</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tanggal Kembali</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Contoh looping data --}}
                            @forelse($borrowings as $borrowing)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $borrowing->item->name }}</td>
                                    <td><span class="badge bg-secondary">{{ $borrowing->item->unique_code }}</span></td>
                                    <td class="text-center">
                                        @if($borrowing->returned_at)
                                            <span class="badge bg-success"><i class="bi bi-check-circle"></i> Telah Dikembalikan</span>
                                        @else
                                            <span class="badge bg-danger"><i class="bi bi-x-circle"></i> Sedang Dipinjam</span>
                                        @endif
                                    </td>
                                    <td>{{ $borrowing->user->name ?? 'Tidak diketahui' }}</td>
                                    <td>{{ $borrowing->borrowed_at->format('d M Y H:i') }}</td>
                                    <td>{{ $borrowing->returned_at ? $borrowing->returned_at->format('d M Y H:i') : '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Tidak ada data pinjaman</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap JS + Icons -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>
