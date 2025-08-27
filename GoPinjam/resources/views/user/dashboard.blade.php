<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-center mb-8">
                    <div class="bg-gray-100 p-6 rounded-lg shadow-lg">
                        <h3 class="text-xl font-bold text-gray-700">Total Benda Dipinjam</h3>
                        <p class="text-5xl mt-4 font-extrabold text-blue-600">{{ $totalBorrowedByUser }}</p>
                    </div>
                    <div class="bg-gray-100 p-6 rounded-lg shadow-lg">
                        <h3 class="text-xl font-bold text-gray-700">Benda Aktif Dipinjam</h3>
                        <p class="text-5xl mt-4 font-extrabold text-red-600">{{ $activeBorrowedByUser }}</p>
                    </div>
                </div>

                <h3 class="text-lg font-bold mb-4">5 Riwayat Peminjaman Terbaru</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Benda</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu Pinjam</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($recentBorrowings as $borrowing)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $borrowing->item->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $borrowing->borrowed_at->format('d M Y H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($borrowing->returned_at)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Sudah Kembali</span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Sedang Dipinjam</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-gray-500">Belum ada riwayat peminjaman.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>