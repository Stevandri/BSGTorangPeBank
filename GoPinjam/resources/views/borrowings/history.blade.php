{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Peminjaman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container my-5">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="mb-0">Riwayat Peminjaman Benda</h4>
            </div>
            <div class="card-body">

                @if ($borrowings->isEmpty())
                    <div class="alert alert-warning text-center">
                        Tidak ada riwayat peminjaman.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle">
                            <thead class="table-primary text-center">
                                <tr>
                                    <th>Nama Benda</th>
                                    <th>Kode Unik</th>
                                    <th>Peminjam</th>
                                    <th>Tujuan</th>
                                    <th>Waktu Pinjam</th>
                                    <th>Waktu Kembali</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($borrowings as $borrowing)
                                    <tr>
                                        <td>{{ $borrowing->item->name }}</td>
                                        <td>{{ $borrowing->item->unique_code }}</td>
                                        <td>{{ $borrowing->user->name ?? 'Tidak diketahui' }}</td>
                                        <td>{{ $borrowing->purpose }}</td>
                                        <td>{{ $borrowing->borrowed_at->format('d M Y H:i') }}</td>
                                        <td>
                                            @if ($borrowing->returned_at)
                                                {{ $borrowing->returned_at->format('d M Y H:i') }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($borrowing->returned_at)
                                                <span class="badge bg-success">Dikembalikan</span>
                                            @else
                                                <span class="badge bg-danger">Aktif</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                <div class="text-center mt-4">
                    <a href="{{ route('login') }}" class="btn btn-outline-primary">
                        ⬅ Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> --}}
