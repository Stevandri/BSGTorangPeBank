<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Borrowing;
use Maatwebsite\Excel\Facades\Excel; // Tambahkan ini
use App\Exports\BorrowingExport; // Tambahkan ini
use Illuminate\Http\Request;


class BorrowingController extends Controller
{
    /**
     * Menampilkan daftar peminjaman yang aktif (belum dikembalikan).
     */
    public function activeBorrowings()
    {
        $activeBorrowings = Borrowing::with('item') // Eager load relasi item
                                    ->whereNull('returned_at')
                                    ->latest() // Urutkan berdasarkan yang paling baru dipinjam
                                    ->get();

        return view('borrowings.active', compact('activeBorrowings'));
    }

    /**
     * Memproses pengembalian benda.
     */
    public function returnItem(Borrowing $borrowing)
    {
        // Pastikan benda belum dikembalikan
        if ($borrowing->returned_at !== null) {
            return redirect()->back()->with('error', 'Benda ini sudah dikembalikan sebelumnya.');
        }

        $borrowing->update([
            'returned_at' => now(), // Catat waktu pengembalian
        ]);

        return redirect()->route('borrowings.active')
                         ->with('success', 'Berkas "' . $borrowing->item->name . '" berhasil dikembalikan.');
    }

    /**
     * Menampilkan daftar seluruh riwayat peminjaman (aktif dan yang sudah dikembalikan).
     * Ini opsional, tapi bagus untuk melihat semua data.
     */
     public function history(Request $request)
{
    // Mengambil semua data peminjaman dengan relasi item dan user
    $query = Borrowing::with('item', 'user')->latest('borrowed_at');

    // Menerapkan filter hanya jika user_id ada dan tidak kosong
    if ($request->filled('user_id')) {
        $query->where('user_id', $request->user_id);
    }

    // filter pencarian nama debitur
    if ($request->filled('search')) {
        $search = $request->search;
        $query->whereHas('user', function($q) use ($search) {
            $q->where('name', 'like', "%$search%");
        })->orWhereHas('item', function($q) use ($search) {
            $q->where('name', 'like', "%$search%");
        });
    }
    
    // Paginate hasil query
    $borrowings = $query->paginate(15);
    
    // Ambil daftar pengguna untuk dropdown filter
    $users = User::orderBy('name')->get();

    return view('admin.borrowings.history', compact('borrowings', 'users'));
}


    /**
     * Mengunduh seluruh riwayat peminjaman dalam file Excel.
     */
    public function downloadHistory()
    {
        $fileName = 'borrowing_history_' . now()->format('Ymd_His') . '.xlsx';
        return Excel::download(new BorrowingExport, $fileName);
    }


      /**
     * Menghapus riwayat peminjaman tertentu.
     */
    public function destroy(Borrowing $borrowing)
    {
        $borrowing->delete();
        return redirect()->back()->with('success', 'Riwayat peminjaman berhasil dihapus.');
    }

    // app/Http/Controllers/BorrowingController.php

// ...

/**
 * Menampilkan riwayat peminjaman untuk pengguna yang sedang login.
 */
public function myBorrowings(Request $request)
{
    $user = Auth::user();

    $query = Borrowing::where('user_id', $user->id)->with('item')->latest('borrowed_at');

    if ($request->has('status') && $request->status !== '') {
        if ($request->status === 'active') {
            $query->whereNull('returned_at');
        } elseif ($request->status === 'returned') {
            $query->whereNotNull('returned_at');
        }
    }

    $borrowings = $query->paginate(15);

    return view('user.my-borrowings', compact('borrowings'));
}

public function exportExcel()
{
    return Excel::download(new BorrowingExport, 'riwayat_peminjaman.xlsx');
}
    
}