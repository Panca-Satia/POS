<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalTransactions = Transaction::count();
        $todayTransactions = Transaction::whereDate('created_at', today())->count();
        $todayRevenue = Transaction::whereDate('created_at', today())->sum('total');
        $totalRevenue = Transaction::sum('total');
        $lowStock = Product::where('stok', '<=', 5)->orderBy('stok')->get();
        $recentTransactions = Transaction::with('user')->latest()->take(5)->get();

        return view('dashboard', compact(
            'totalProducts',
            'totalTransactions',
            'todayTransactions',
            'todayRevenue',
            'totalRevenue',
            'lowStock',
            'recentTransactions'
        ));
    }
}
