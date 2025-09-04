<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftarkan Pengguna Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

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
                    <li class="nav-item"><a class="nav-link" href="{{ route('scanner') }}">Pinjam Berkas</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('borrowings.active') }}">Peminjaman Aktif</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('items.create') }}">Daftarkan Berkas</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('borrowings.history') }}">Riwayat Pinjam</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Lainnya</a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ route('admin.items.index') }}">Semua berkas</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.users.index') }}">Semua Pengguna</a></li>
                            <li><a class="dropdown-item active" href="{{ route('admin.users.create') }}">Tambah Pengguna</a></li>
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

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Daftarkan Pengguna Baru</h4>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form method="POST" action="{{ route('admin.users.store') }}">
                        @csrf

                        <div class="row mb-3">
                            <div class="col">
                                <label for="first_name" class="form-label">Nama Depan</label>
                                <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" required class="form-control">
                                @error('first_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="last_name" class="form-label">Nama Belakang</label>
                                <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" required class="form-control">
                                @error('last_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="position" class="form-label">Posisi/Jabatan</label>
                            <input type="text" id="role" name="role" value="{{ old('role') }}" required class="form-control">
                            @error('position')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- <div class="mb-3">
                            <label for="phone_number" class="form-label">Nomor Telepon</label>
                            <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required class="form-control">
                            @error('phone_number')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div> --}}

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control">
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" id="username" name="username" value="{{ old('username') }}" required class="form-control">
                            @error('username')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div> --}}

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" name="password" required class="form-control">
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Daftarkan Pengguna</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
