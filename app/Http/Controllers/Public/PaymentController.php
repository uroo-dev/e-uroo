<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display the payment page for the specified order.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Store payment proof for the specified order.
     */
    public function store(Request $request, Order $order)
    {
        //
    }
}
