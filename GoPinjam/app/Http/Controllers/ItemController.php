<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Borrowing;
use App\Models\User; 
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ItemController extends Controller
{
    public function create(){
        return view('items.create');
    }
    
    //==================menmapilkan kode qr==============================
    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'unique_code' => 'required|string|max:255|unique:items,unique_code',
        ]);

        $item = Item::create([
            'name' => $request->name,
            'unique_code' => $request->unique_code,
        ]);

        //generate QR
        $qrCodeData = json_encode([
            'item_id' => $item->id,
            'unique_code' => $item->unique_code,
            'item_name' => $item->name
        ]); 

        $fileName = 'qr-' . Str::slug($item->unique_code) . '.svg';
        $filePath = 'public/qrcodes/' . $fileName;

        //kalo gaada
        if (!Storage::exists('public/qrcodes')) {
            Storage::makeDirectory('public/qrcodes');
        }

        QrCode::format('svg')->size(200)->generate($qrCodeData, storage_path('app/' . $filePath));

        //update path QR Code di database
        $item->qr_code_path = 'qrcodes/' . $fileName;
        $item->save();

        return redirect()->route('items.show', $item->id)
                         ->with('success', 'Berkas berhasil didaftarkan dan QR Code berhasil dibuat!');
    }



    //==================================nampilkan qr code==================================
    public function show(Item $item){
        $qrCodeUrl = Storage::url($item->qr_code_path);
        return view('items.show', compact('item', 'qrCodeUrl'));
    }


    //===========================form peminjaman dengan akses qr=====================================
    public function borrowForm(Request $request){
        $uniqueCode = $request->query('unique_code');

        if (!$uniqueCode) {
            return redirect()->route('login')->with('error', 'Berkas tidak ditemukan.');
        }

        $item = Item::where('unique_code', $uniqueCode)->first();

        if (!$item) {
            return redirect()->route('login')->with('error', 'Berkas dengan nomor akad kredit tersebut tidak terdaftar.');
        }

        $activeBorrowing = Borrowing::where('item_id', $item->id)
                                    ->whereNull('returned_at')
                                    ->first();

        if ($activeBorrowing) {
            return view('items.borrow-locked', compact('item', 'activeBorrowing'));
        }

        //dropdown smua pengguna terfdtr
        $users = User::orderBy('name')->get();

        return view('items.borrow', compact('item', 'users')); 
    }

    
    //========================memproses dan menyimpan data peminjaman benda=====================
    public function borrow(Request $request){
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'user_id' => 'required|exists:users,id',
            'purpose' => 'required|string',
        ]);

        $item = Item::find($request->item_id);


        Borrowing::create([
            'item_id' => $item->id,
            'user_id' => $request->user_id, 
            'purpose' => $request->purpose,
            'borrowed_at' => now(),
        ]);

        return redirect()->route('items.borrow-success')
                        ->with('success', 'Peminjaman berkas "' . $item->name . '" berhasil dicatat!');
    }

    
    
    //=========================Nampilin berkas terdaftar===========================
    public function index(Request $request){
        $query = Item::query();

        if ($request->has('status') && $request->status !== '') {
            $status = $request->status;
            if ($status === 'available') {
                $query->doesntHave('activeBorrowing'); //siap dipinjam
            } 
            elseif ($status === 'borrowed') {
                $query->has('activeBorrowing'); //sedang dipinjam
            }
        }

        $items = $query->with('activeBorrowing.user')->paginate(10);

        return view('admin.items.index', compact('items'));
    }



    //======================Menambahkan method untuk halaman sukses peminjaman===========================
    public function borrowSuccess(){
        return view('items.borrow-success');
    }


    //============================================download QR===================================
    public function downloadQrCode(Item $item){
        if (!$item->qr_code_path) {
            return redirect()->back()->with('error', 'QR Code tidak ditemukan.');
        }

        $qrCodeData = json_encode([
            'item_id' => $item->id,
            'unique_code' => $item->unique_code,
            'item_name' => $item->name
        ]);

        $svg = QrCode::format('svg')->size(300)->generate($qrCodeData); //simpan dengan svg

        $fileName = 'qr-' . Str::slug($item->unique_code) . '.svg';

        return response($svg, 200) // Mengirimkan file SVG sebagai respons unduhan
                ->header('Content-Type', 'image/svg+xml')
                ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
    }

    //===================ini untuk hapus berkas terdaftar============================
    public function destroy(Item $item){
         if ($item->qr_code_path && Storage::disk('public')->exists($item->qr_code_path)) {
            Storage::disk('public')->delete($item->qr_code_path);
        }

        $item->delete();

        return redirect()->route('admin.items.index')->with('success', 'Berkas dan QR Code berhasil dihapus.');
    }


    //========================cek ketersediaan berkas oleh karyawan=================================
    public function checkAvailability(Request $request){
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