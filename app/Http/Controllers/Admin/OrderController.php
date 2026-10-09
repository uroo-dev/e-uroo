<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of orders.
     */
    public function index(Request $request)
    {
        //
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Update order status.
     */
    public function updateStatus(Request $request, Order $order)
    {
        //
    }
}
