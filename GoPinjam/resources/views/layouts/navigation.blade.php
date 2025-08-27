{{-- <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            <svg class="h-9 w-auto fill-current text-gray-800" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 2L2 22h20L12 2zm0 4.16L18.72 19H5.28L12 6.16z" fill="currentColor" />
            </svg>
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                @if(Auth::user()->role === 'admin')
                    <li class="nav-item">
                        <a class="nav-link @if(request()->routeIs('dashboard')) active @endif" href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(request()->routeIs('admin.items.index')) active @endif" href="{{ route('admin.items.index') }}">Daftar Benda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(request()->routeIs('borrowings.history')) active @endif" href="{{ route('borrowings.history') }}">Riwayat Peminjaman</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(request()->routeIs('items.create')) active @endif" href="{{ route('items.create') }}">Daftarkan Berkas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(request()->routeIs('borrowings.active')) active @endif" href="{{ route('borrowings.active') }}">Peminjaman Aktif</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(request()->routeIs('admin.users.index')) active @endif" href="{{ route('admin.users.index') }}">Semua Pengguna</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(request()->routeIs('admin.users.create')) active @endif" href="{{ route('admin.users.create') }}">Tambah Pengguna</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link @if(request()->routeIs('dashboard')) active @endif" href="{{ route('dashboard') }}">Dashboard Saya</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(request()->routeIs('user.my-borrowings')) active @endif" href="{{ route('user.my-borrowings') }}">Berkas Pinjaman Saya</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(request()->routeIs('user.check-availability')) active @endif" href="{{ route('user.check-availability') }}">Cek Ketersediaan</a>
                    </li>
                @endif
            </ul>

            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
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
</nav> --}}