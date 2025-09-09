<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Borrowing;
use Maatwebsite\Excel\Facades\Excel; 
use App\Exports\BorrowingExport;
use Illuminate\Http\Request;


class BorrowingController extends Controller
{
    //================daftar peminjaman yang aktif (blum dikembalikan)==================
    public function activeBorrowings(){
        $activeBorrowings = Borrowing::with('item') 
                                    ->whereNull('returned_at')
                                    ->latest() //flter pling new
                                    ->get();
        return view('borrowings.active', compact('activeBorrowings'));
    }

    
    //=================proses pengembalian berkas kredit==========================
    public function returnItem(Borrowing $borrowing){
        if ($borrowing->returned_at !== null) {
            return redirect()->back()->with('error', 'Berkas ini sudah dikembalikan sebelumnya.');
        }

        $borrowing->update([
            'returned_at' => now(),
        ]);

        return redirect()->route('borrowings.active')
                         ->with('success', 'Berkas "' . $borrowing->item->name . '" berhasil dikembalikan.');
    }

    //=============ini untuk dftar riwayat peminjaman (kseluruhan)===================
    public function history(Request $request){
        $query = Borrowing::with('item', 'user')->latest('borrowed_at');

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
    
        $borrowings = $query->paginate(15);
    
        $users = User::orderBy('name')->get();

        return view('admin.borrowings.history', compact('borrowings', 'users'));
    }


    //===========================donwload .excel====================================
    public function downloadHistory(){
        $fileName = 'borrowing_history_' . now()->format('Ymd_His') . '.xlsx';
        return Excel::download(new BorrowingExport, $fileName);
    }


    //========================hapus riwayat pinjam==================================
    public function destroy(Borrowing $borrowing){
        $borrowing->delete();
        return redirect()->back()->with('success', 'Riwayat peminjaman berhasil dihapus.');
    }



    //=============riwayat pinjam untuk karywan pada pinjamannya yang lagi aktif===============
    public function myBorrowings(Request $request){
        $user = Auth::user();

        $query = Borrowing::where('user_id', $user->id)->with('item')->latest('borrowed_at');

        if ($request->has('status') && $request->status !== '') {
                if ($request->status === 'active') {
                    $query->whereNull('returned_at');
                } 
                elseif ($request->status === 'returned') {
                    $query->whereNotNull('returned_at');
                }
        }

        $borrowings = $query->paginate(15);

        return view('user.my-borrowings', compact('borrowings'));
    }

    //================= ini untuk download riwayat pinjam (tak terpakai)===============
    public function exportExcel()
    {
        return Excel::download(new BorrowingExport, 'riwayat_peminjaman.xlsx');
    }
    
}