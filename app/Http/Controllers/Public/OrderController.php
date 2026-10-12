<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of orders for the authenticated customer.
     */
    public function index(Request $request)
    {
        $query = Order::with(['items.product', 'payment'])
            ->where('user_id', Auth::id());

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $orders = $query->latest()->paginate(10)->withQueryString();

        return view('Public.orders.index', compact('orders'));
    }

    /**
     * Display the specified order (Digital Receipt / Struk Digital).
     */
    public function show(Order $order)
    {
        // Check ownership
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load(['items.product', 'payment', 'statusLogs']);

        return view('Public.orders.show', compact('order'));
    }
}
