<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Borrowing;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        //admin
        if ($user->role === 'admin') {
            $totalItems = Item::count();
            $borrowedItems = Borrowing::whereNull('returned_at')->count();
            $availableItems = $totalItems - $borrowedItems;

            return view('admin.dashboard', compact('totalItems', 'borrowedItems', 'availableItems'));
        }

        //karywan
        $totalBorrowedByUser = Borrowing::where('user_id', $user->id)->count();
        $activeBorrowedByUser = Borrowing::where('user_id', $user->id)
                                         ->whereNull('returned_at')
                                         ->count();
        $recentBorrowings = Borrowing::where('user_id', $user->id)
                                     ->with('item')
                                     ->latest('borrowed_at')
                                     ->limit(5)
                                     ->get();

        return view('user.dashboard', compact('totalBorrowedByUser', 'activeBorrowedByUser', 'recentBorrowings'));
    }
}