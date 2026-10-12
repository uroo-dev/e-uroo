<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatusLog;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of orders.
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'items', 'payment']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('recipient_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $orders = $query->latest()->paginate(15)->withQueryString();

        $statusCounts = [
            'all' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'completed' => Order::where('status', 'completed')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
        ];

        return view('Admin.orders.index', compact('orders', 'statusCounts'));
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        $order->load(['user', 'items.product', 'payment', 'statusLogs.changedBy']);

        return view('Admin.orders.show', compact('order'));
    }

    /**
     * Update order status.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
            'payment_status' => 'nullable|in:unpaid,pending,paid,failed,expired',
            'note' => 'nullable|string|max:500',
        ]);

        DB::transaction(function () use ($order, $data) {
            $oldStatus = $order->status;
            $newStatus = $data['status'];

            // If changing to cancelled, restore product stock
            if ($oldStatus !== 'cancelled' && $newStatus === 'cancelled') {
                foreach ($order->items as $item) {
                    if ($item->product_id) {
                        Product::where('id', $item->product_id)->increment('stock', $item->quantity);
                    }
                }
            }

            $updateData = ['status' => $newStatus];

            if (! empty($data['payment_status'])) {
                $updateData['payment_status'] = $data['payment_status'];
                if ($data['payment_status'] === 'paid' && ! $order->paid_at) {
                    $updateData['paid_at'] = now();
                }
            }

            if ($newStatus === 'completed' && ! $order->completed_at) {
                $updateData['completed_at'] = now();
            }

            $order->update($updateData);

            OrderStatusLog::create([
                'order_id' => $order->id,
                'status' => $newStatus,
                'note' => $data['note'] ?? "Status pesanan diubah oleh admin menjadi '{$newStatus}'",
                'changed_by' => Auth::id(),
            ]);
        });

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui');
    }
}
