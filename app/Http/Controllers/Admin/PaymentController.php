<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderStatusLog;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Display a listing of payments.
     */
    public function index(Request $request)
    {
        $query = Payment::with(['order.user', 'verifiedBy']);

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('order', function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('recipient_name', 'like', "%{$search}%");
            });
        }

        $payments = $query->latest()->paginate(15)->withQueryString();

        $statusCounts = [
            'pending' => Payment::where('status', 'pending')->count(),
            'verified' => Payment::where('status', 'verified')->count(),
            'rejected' => Payment::where('status', 'rejected')->count(),
        ];

        return view('Admin.payments.index', compact('payments', 'statusCounts'));
    }

    /**
     * Display the specified payment.
     */
    public function show(Payment $payment)
    {
        $payment->load(['order.items.product', 'order.user', 'verifiedBy']);

        return view('Admin.payments.show', compact('payment'));
    }

    /**
     * Verify or reject a payment.
     */
    public function verify(Request $request, Payment $payment)
    {
        $data = $request->validate([
            'status' => 'required|in:verified,rejected',
            'rejection_reason' => 'nullable|required_if:status,rejected|string|max:500',
        ]);

        DB::transaction(function () use ($payment, $data) {
            $isApproved = $data['status'] === 'verified';

            $payment->update([
                'status' => $data['status'],
                'rejection_reason' => $isApproved ? null : ($data['rejection_reason'] ?? null),
                'verified_by' => Auth::id(),
                'verified_at' => now(),
            ]);

            $order = $payment->order;

            if ($isApproved) {
                $order->update([
                    'status' => 'processing',
                    'payment_status' => 'paid',
                    'paid_at' => now(),
                ]);

                OrderStatusLog::create([
                    'order_id' => $order->id,
                    'status' => 'processing',
                    'note' => 'Pembayaran telah diverifikasi oleh Admin. Pesanan siap diproses & dikemas.',
                    'changed_by' => Auth::id(),
                ]);
            } else {
                $order->update([
                    'payment_status' => 'failed',
                ]);

                OrderStatusLog::create([
                    'order_id' => $order->id,
                    'status' => $order->status,
                    'note' => 'Pembayaran ditolak: '.($data['rejection_reason'] ?? 'Bukti pembayaran tidak valid'),
                    'changed_by' => Auth::id(),
                ]);
            }
        });

        $message = $data['status'] === 'verified' ? 'Pembayaran berhasil diverifikasi dan pesanan diproses' : 'Pembayaran telah ditolak';

        return redirect()->back()->with('success', $message);
    }
}
