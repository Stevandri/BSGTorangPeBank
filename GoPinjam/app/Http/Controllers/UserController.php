<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;



class UserController extends Controller
{
    //==========================ke form regist pengguna baru olh admin==========================
    public function create(){
        return view('admin.users.create');
    }

   

    //============================Proses daftar pengguna bru====================================
    public function store(Request $request){
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'max:255'],
            // 'phone_number' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:'.User::class],
            // 'username' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'min:8', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->first_name . ' ' . $request->last_name, 
            // 'username' => $request->username,
            'email' => $request->email,
            // 'phone_number' => $request->phone_number,
            // 'position' => $request->position,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.create')->with('success', 'Pengguna berhasil didaftarkan.');
    }

    

    //==========================Tampilkan semua pengguna trdftr===================================
    public function index(){
        $users = User::paginate(15); 

        return view('admin.users.index', compact('users'));
    }

    
    //=====================================ini untuk hapus pengguna yaaaa================================
    public function destroy($id){
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
    }



}