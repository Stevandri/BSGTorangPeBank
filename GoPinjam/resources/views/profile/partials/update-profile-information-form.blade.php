<section class="py-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <!-- Header -->
            <h5 class="fw-bold mb-2">Informasi Profil</h5>
            <p class="text-muted mb-4">
                Perbarui informasi profil akun dan alamat email Anda.
            </p>

            <!-- Form verifikasi email -->
            <form id="send-verification" method="POST" action="{{ route('verification.send') }}">
                @csrf
            </form>

            <!-- Form update profile -->
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('patch')

                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" id="username" name="username" class="form-control" value="{{ old('username', $user->username) }}" required autocomplete="username">
                    @error('username')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div> --}}

                <div class="mb-3">
                    <label for="position" class="form-label">Posisi</label>
                    <input type="text" id="role" name="role" class="form-control" value="{{ old('role', $user->role) }}" readonly>
                </div>


                {{-- <div class="mb-3">
                    <label for="phone_number" class="form-label">Nomor Telepon</label>
                    <input type="text" id="phone_number" name="phone_number" class="form-control" value="{{ old('phone_number', $user->phone_number) }}" required autocomplete="tel">
                    @error('phone_number')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div> --}}

                <div class="mb-3">
                    <label for="email" class="form-label">Alamat Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required autocomplete="username">
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <p class="text-muted mt-2">
                            Alamat email Anda belum diverifikasi.
                            <button form="send-verification" class="btn btn-link p-0 align-baseline">Klik di sini untuk mengirim ulang email verifikasi.</button>
                        </p>
                        @if (session('status') === 'verification-link-sent')
                            <p class="text-success small mt-1">
                                Tautan verifikasi baru telah dikirim ke alamat email Anda.
                            </p>
                        @endif
                    @endif
                </div>

                <div class="d-flex align-items-center gap-3">
                    <button type="submit" class="btn btn-primary">Simpan</button>

                    @if (session('status') === 'profile-updated')
                        <div class="text-success small mb-0">Tersimpan.</div>
                    @endif
                </div>
            </form>
        </div>
    </div>
</section>
