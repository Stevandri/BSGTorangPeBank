<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pindai QR Code untuk Meminjam Berkas</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
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

    <div class="container py-5">
        <div class="card shadow-lg mx-auto" style="max-width: 600px;">
            <div class="card-body text-center">
                <h1 class="h4 mb-3 text-primary">Input Kode Berkas atau Pindai QR </h1>

                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                
                {{-- Form Input Kode Unik Manual --}}
                <form action="{{ route('items.show-borrow-form') }}" method="GET" class="mb-4">
                    <div class="input-group">
                        <input type="text" name="unique_code" class="form-control" placeholder="Masukkan Kode Unik Berkas" required>
                        <button type="submit" class="btn btn-primary">Cari Berkas</button>
                    </div>
                </form>

                <hr>

                <h1 class="h5 mb-3 text-secondary">Atau Scan QR Code</h1>

                <div id="reader" class="border rounded p-2 mx-auto mb-3" style="max-width: 400px;"></div>
                <div id="result" class="fw-bold"></div>

                <a href="{{ route('dashboard') }}" class="btn btn-primary mt-3">Kembali ke Dashboard</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script type="text/javascript">
        function onScanSuccess(decodedText, decodedResult) {
            console.log(`Code matched = ${decodedText}`, decodedResult);
            document.getElementById('result').innerHTML = 
                `<div class="alert alert-success">QR Code berhasil dipindai! Mengalihkan...</div>`;

            try {
                const qrData = JSON.parse(decodedText);
                if (qrData.unique_code) {
                    window.location.href = `{{ route('items.show-borrow-form') }}?unique_code=${qrData.unique_code}`;
                } else {
                    document.getElementById('result').innerHTML = 
                        `<div class="alert alert-danger">Data QR Code tidak valid.</div>`;
                }
            } catch (e) {
                document.getElementById('result').innerHTML = 
                    `<div class="alert alert-warning">Format QR Code tidak dikenal: ${decodedText}</div>`;
            }

            html5QrcodeScanner.clear();
        }

        function onScanError(errorMessage) {
            // Bisa ditambahkan log kalau mau debugging
        }

        const html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", { fps: 10, qrbox: {width: 250, height: 250} }, false);
        html5QrcodeScanner.render(onScanSuccess, onScanError);
    </script>
</body>
</html>