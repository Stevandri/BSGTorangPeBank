<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;



class UserController extends Controller
{
    /**
     * Menampilkan form pendaftaran pengguna baru oleh admin.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Memproses pendaftaran pengguna baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:'.User::class],
            'username' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'min:8', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->first_name . ' ' . $request->last_name, // Menggabungkan nama
            'username' => $request->username,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'position' => $request->position,
            'password' => Hash::make($request->password),
            'role' => 'user', // Otomatis menjadi 'user'
        ]);

        return redirect()->route('admin.users.create')->with('success', 'Pengguna berhasil didaftarkan.');
    }

    /**
     * Menampilkan daftar semua pengguna terdaftar.
     */
    public function index()
    {
        $users = User::paginate(15); // Mengambil semua pengguna dengan pagination

        return view('admin.users.index', compact('users'));
    }

    
//ini untuk hapus pengguna yaaaa
public function destroy($id)
{
    $user = User::findOrFail($id);
    $user->delete();

    return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
}



}