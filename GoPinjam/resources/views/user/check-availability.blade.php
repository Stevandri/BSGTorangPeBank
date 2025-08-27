<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cek Ketersediaan Berkas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('user.check-availability') }}" method="GET" class="flex items-center space-x-2">
                    <input type="text" name="unique_code" placeholder="Masukkan Nomor Unik Berkas" value="{{ $uniqueCode }}" required class="flex-1 rounded-md shadow-sm border-gray-300">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Cari</button>
                </form>

                @isset($item)
                    <div class="mt-8 p-4 border rounded-md shadow-sm">
                        <h3 class="text-lg font-bold">{{ $item->name }}</h3>
                        <p class="text-sm text-gray-600 mb-4">Kode Unik: {{ $item->unique_code }}</p>

                        @if ($activeBorrowing)
                            <div class="p-3 rounded-md bg-red-100 text-red-700">
                                <p>Status: **Sedang Dipinjam**</p>
                                <p>Oleh: {{ $activeBorrowing->user->name ?? 'Pengguna tidak diketahui' }}</p>
                                <p>Sejak: {{ $activeBorrowing->borrowed_at->format('d M Y H:i') }}</p>
                            </div>
                        @else
                            <div class="p-3 rounded-md bg-green-100 text-green-700">
                                <p>Status: **Tersedia untuk Dipinjam**</p>
                            </div>
                        @endif
                    </div>
                @endisset

                @if ($uniqueCode && !$item)
                    <div class="mt-8 p-3 rounded-md bg-yellow-100 text-yellow-700">
                        <p>Berkas dengan nomor unik "{{ $uniqueCode }}" tidak ditemukan.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>