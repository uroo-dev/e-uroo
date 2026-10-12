<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatusLog;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Display the payment page for the specified order.
     */
    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load(['items.product', 'payment']);

        return view('Public.payment.show', compact('order'));
    }

    /**
     * Store payment proof for the specified order.
     */
    public function store(Request $request, Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $data = $request->validate([
            'proof_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:3072',
            'sender_name' => 'nullable|string|max:255',
        ]);

        $proofPath = $request->file('proof_image')->store('payment_proofs', 'public');

        $payment = Payment::firstOrCreate(
            ['order_id' => $order->id],
            [
                'method' => 'Transfer Bank / QRIS',
                'amount' => $order->grand_total,
                'status' => 'pending',
            ]
        );

        $payment->update([
            'proof_image' => $proofPath,
            'status' => 'pending',
        ]);

        $order->update([
            'payment_status' => 'pending',
        ]);

        OrderStatusLog::create([
            'order_id' => $order->id,
            'status' => 'pending',
            'note' => 'Bukti pembayaran diunggah oleh pembeli'.($request->filled('sender_name') ? " (a.n. {$request->sender_name})" : ''),
            'changed_by' => Auth::id(),
        ]);

        return redirect()->route('orders.show', $order->order_number)
            ->with('success', 'Bukti pembayaran berhasil diunggah! Mohon tunggu verifikasi admin kami.');
    }
}
