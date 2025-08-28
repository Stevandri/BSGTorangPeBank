<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang di Aplikasi Peminjaman Berkas</title>
    <style>
        body { font-family: sans-serif; text-align: center; margin-top: 50px; }
        a { display: inline-block; margin: 10px; padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; }
        a:hover { background-color: #0056b3; }
        .message { margin-top: 20px; font-size: 1.1em; color: green; }
        .error { margin-top: 20px; font-size: 1.1em; color: red; }
    </style>
</head>
<body>
    <h1>Selamat Datang di Aplikasi Peminjaman Benda</h1>
    <p>Silakan pilih tindakan:</p>

    @if (session('success'))
        <p class="message">{{ session('success') }}</p>
    @endif
    @if (session('error'))
        <p class="error">{{ session('error') }}</p>
    @endif

    <a href="{{ route('items.create') }}">Daftarkan Benda Baru</a>
    <a href="{{ route('scanner') }}">Pindai QR Code untuk Meminjam</a>
    <a href="{{ route('borrowings.active') }}">Lihat Peminjaman Aktif & Kembalikan</a>
    <a href="{{ route('borrowings.history') }}">Lihat Seluruh Riwayat Peminjaman</a>
</body>
</html>