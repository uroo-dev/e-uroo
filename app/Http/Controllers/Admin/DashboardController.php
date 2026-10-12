<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        $totalRevenue = Order::whereIn('status', ['completed', 'processing'])->sum('grand_total');
        $totalOrdersMonth = Order::whereMonth('created_at', now()->month)->count();
        $totalProducts = Product::where('is_active', true)->count();
        $totalCustomers = User::where('role', 'pelanggan')->count();

        // Recent 5 orders eager loaded
        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        // Top categories
        $topCategories = Category::withCount('products')
            ->orderBy('products_count', 'desc')
            ->take(4)
            ->get();

        return view('Admin.dashboard.index', compact(
            'totalRevenue',
            'totalOrdersMonth',
            'totalProducts',
            'totalCustomers',
            'recentOrders',
            'topCategories'
        ));
    }
}
