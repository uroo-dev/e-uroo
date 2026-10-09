<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of payments.
     */
    public function index(Request $request)
    {
        //
    }

    /**
     * Display the specified payment.
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Verify or reject a payment.
     */
    public function verify(Request $request, Payment $payment)
    {
        //
    }
}
