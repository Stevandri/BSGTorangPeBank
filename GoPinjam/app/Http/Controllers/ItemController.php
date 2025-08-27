<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Borrowing;
use App\Models\User; // Tambahkan ini
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ItemController extends Controller
{

      public function create()
    {
        return view('items.create');
    }
    
    //menmapilkan kode qr
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'unique_code' => 'required|string|max:255|unique:items,unique_code',
        ]);

        $item = Item::create([
            'name' => $request->name,
            'unique_code' => $request->unique_code,
        ]);

        // Generate QR Code
        $qrCodeData = json_encode([
            'item_id' => $item->id,
            'unique_code' => $item->unique_code,
            'item_name' => $item->name
        ]); // Data yang akan di-embed dalam QR code

        $fileName = 'qr-' . Str::slug($item->unique_code) . '.svg';
        $filePath = 'public/qrcodes/' . $fileName;

        // Pastikan direktori ada
        if (!Storage::exists('public/qrcodes')) {
            Storage::makeDirectory('public/qrcodes');
        }

        QrCode::format('svg')->size(200)->generate($qrCodeData, storage_path('app/' . $filePath));

        // Update path QR Code di database
        $item->qr_code_path = 'qrcodes/' . $fileName; // Path relatif dari storage/app/public
        $item->save();

        return redirect()->route('items.show', $item->id)
                         ->with('success', 'Benda berhasil didaftarkan dan QR Code berhasil dibuat!');
    }


      /**
     * Menampilkan detail benda beserta QR Code-nya.
     */
    public function show(Item $item)
    {
        // Untuk menampilkan gambar QR Code, kita perlu membuat symlink ke storage
        // Pastikan Anda sudah menjalankan: php artisan storage:link
        $qrCodeUrl = Storage::url($item->qr_code_path);
        return view('items.show', compact('item', 'qrCodeUrl'));
    }

    /**
     * Menampilkan form peminjaman setelah QR Code dipindai.
     */
    public function borrowForm(Request $request)
    {
        $uniqueCode = $request->query('unique_code');

        if (!$uniqueCode) {
            return redirect()->route('login')->with('error', 'Kode unik benda tidak ditemukan.');
        }

        $item = Item::where('unique_code', $uniqueCode)->first();

        if (!$item) {
            return redirect()->route('login')->with('error', 'Benda dengan kode unik tersebut tidak terdaftar.');
        }

        $activeBorrowing = Borrowing::where('item_id', $item->id)
                                    ->whereNull('returned_at')
                                    ->first();

        if ($activeBorrowing) {
            return view('items.borrow-locked', compact('item', 'activeBorrowing'));
        }

        // Ambil semua pengguna yang terdaftar untuk dropdown
        $users = User::orderBy('name')->get();

        return view('items.borrow', compact('item', 'users')); // Kirimkan data pengguna ke view
    }

    /**
     * Memproses dan menyimpan data peminjaman benda.
     */
    public function borrow(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'user_id' => 'required|exists:users,id', // Ganti 'borrower_name' dengan 'user_id'
            'purpose' => 'required|string',
        ]);

        $item = Item::find($request->item_id);

        // ... (logika cek benda dipinjam yang sudah ada) ...

        Borrowing::create([
            'item_id' => $item->id,
            'user_id' => $request->user_id, // Simpan user_id
            'purpose' => $request->purpose,
            'borrowed_at' => now(),
        ]);

        return redirect()->route('items.borrow-success')
                        ->with('success', 'Peminjaman benda "' . $item->name . '" berhasil dicatat!');
    }

    public function index(Request $request)
{
    $query = Item::query();

    // Menerapkan filter berdasarkan status ketersediaan
    if ($request->has('status') && $request->status !== '') {
        $status = $request->status;
        if ($status === 'available') {
            $query->doesntHave('activeBorrowing'); // Tidak memiliki peminjaman aktif
        } elseif ($status === 'borrowed') {
            $query->has('activeBorrowing'); // Memiliki peminjaman aktif
        }
    }

    $items = $query->with('activeBorrowing.user')->paginate(10);

    return view('admin.items.index', compact('items'));
}



    // Menambahkan method untuk halaman sukses peminjaman
    public function borrowSuccess()
    {
        return view('items.borrow-success');
    }


public function downloadQrCode(Item $item)
{
    // Pastikan ada data QR Code yang sudah tersimpan
    if (!$item->qr_code_path) {
        return redirect()->back()->with('error', 'QR Code tidak ditemukan.');
    }

    $qrCodeData = json_encode([
        'item_id' => $item->id,
        'unique_code' => $item->unique_code,
        'item_name' => $item->name
    ]);

    // Generate QR Code dalam format SVG
    $svg = QrCode::format('svg')->size(300)->generate($qrCodeData);

    // Tetapkan nama file dengan ekstensi .svg
    $fileName = 'qr-' . Str::slug($item->unique_code) . '.svg';

    // Mengirimkan file SVG sebagai respons unduhan
    return response($svg, 200)
            ->header('Content-Type', 'image/svg+xml')
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
}

// ini untuk hapus berkas terdaftar
public function destroy(Item $item)
{
    $item->delete();
    return redirect()->route('admin.items.index')->with('success', 'Berkas berhasil dihapus.');
}


// ... di dalam ItemController.php ...

public function checkAvailability(Request $request)
{
    $uniqueCode = $request->input('unique_code');
    $item = null;
    $activeBorrowing = null;

    if ($uniqueCode) {
        $item = Item::where('unique_code', $uniqueCode)->first();
        if ($item) {
            $activeBorrowing = $item->activeBorrowing;
        }
    }

    return view('user.check-availability', compact('item', 'activeBorrowing', 'uniqueCode'));
}


}