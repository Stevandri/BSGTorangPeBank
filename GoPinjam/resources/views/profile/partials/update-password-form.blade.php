<section class="py-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <!-- Header -->
            <h5 class="fw-bold mb-2">Ubah Password</h5>
            <p class="text-muted mb-4">
                Pastikan akun Anda menggunakan kata sandi yang panjang dan acak agar tetap aman.
            </p>

            <!-- Form Update Password -->
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                @method('put')

                <div class="mb-3">
                    <label for="current_password" class="form-label">Password saat ini</label>
                    <input type="password" id="current_password" name="current_password" class="form-control" autocomplete="current-password">
                    @error('current_password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password baru</label>
                    <input type="password" id="password" name="password" class="form-control" autocomplete="new-password">
                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" autocomplete="new-password">
                    @error('password_confirmation')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="d-flex align-items-center gap-3">
                    <button type="submit" class="btn btn-primary">Ubah</button>

                    @if (session('status') === 'password-updated')
                        <div class="text-success small mb-0">Diubah.</div>
                    @endif
                </div>
            </form>
        </div>
    </div>
</section>
