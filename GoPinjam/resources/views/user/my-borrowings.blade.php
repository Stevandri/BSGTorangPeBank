<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Berkas Pinjaman Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <form action="{{ route('user.my-borrowings') }}" method="GET" class="flex items-center space-x-4">
                        <label for="status" class="font-medium">Filter Status:</label>
                        <select name="status" id="status" class="rounded-md shadow-sm border-gray-300">
                            <option value="">Semua</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Sedang Dipinjam</option>
                            <option value="returned" {{ request('status') === 'returned' ? 'selected' : '' }}>Telah Dikembalikan</option>
                        </select>
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Filter</button>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        {{-- ... (kode tabel yang sama seperti di riwayat admin) ... --}}
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>