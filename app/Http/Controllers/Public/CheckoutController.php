<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatusLog;
use App\Models\Payment;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Display the checkout page.
     */
    public function index()
    {
        $user = Auth::user();

        // 1. Mandatory Address Check before checkout
        $address = Address::where('user_id', $user->id)
            ->where('is_default', true)
            ->first() ?? Address::where('user_id', $user->id)->first();

        if (! $address) {
            return redirect()->route('profile')->with('error', 'Silakan lengkapi alamat pengiriman Anda terlebih dahulu sebelum melakukan pemesanan.');
        }

        // 2. Cart Verification
        $cart = Cart::with('items.product')->where('user_id', $user->id)->first();

        if (! $cart || $cart->items->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Keranjang belanja Anda masih kosong.');
        }

        $allAddresses = Address::where('user_id', $user->id)->get();

        return view('Public.checkout.index', compact('cart', 'address', 'allAddresses'));
    }

    /**
     * Process checkout and create order.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'address_id' => 'required|exists:addresses,id',
            'payment_method' => 'required|in:cod,transfer',
            'notes' => 'nullable|string|max:500',
        ]);

        $user = Auth::user();

        $address = Address::where('id', $data['address_id'])
            ->where('user_id', $user->id)
            ->firstOrFail();

        try {
            $order = DB::transaction(function () use ($user, $address, $data) {
                // Lock Cart & Items to prevent race conditions and duplicate order spam
                $cart = Cart::where('user_id', $user->id)->lockForUpdate()->first();

                if (! $cart || $cart->items()->count() === 0) {
                    throw new Exception('Keranjang belanja Anda kosong.');
                }

                $cartItems = $cart->items()->with('product')->get();

                $subtotal = 0;

                // Validate stock with pessimistic lock
                foreach ($cartItems as $item) {
                    $product = Product::where('id', $item->product_id)->lockForUpdate()->first();

                    if (! $product || ! $product->is_active) {
                        throw new Exception("Produk '{$item->product->name}' sudah tidak aktif atau tidak tersedia.");
                    }

                    if ($product->stock < $item->quantity) {
                        throw new Exception("Stok untuk produk '{$product->name}' tidak mencukupi (tersedia: {$product->stock}).");
                    }

                    $subtotal += $product->price * $item->quantity;
                }

                $grandTotal = $subtotal; // Subtotal for agricultural goods

                // Generate unique order number (e.g. INV-PT-YYYYMMDD-XXXX)
                $orderNumber = 'INV-'.date('Ymd').'-'.strtoupper(Str::random(5));

                $isCod = $data['payment_method'] === 'cod';

                $order = Order::create([
                    'user_id' => $user->id,
                    'order_number' => $orderNumber,
                    'status' => 'pending',
                    'subtotal' => $subtotal,
                    'discount_amount' => 0,
                    'grand_total' => $grandTotal,
                    'payment_method' => $data['payment_method'],
                    'payment_status' => $isCod ? 'unpaid' : 'pending',
                    'recipient_name' => $address->recipient_name.' ('.$address->phone.')',
                    'recipient_phone' => $address->phone,
                    'notes' => "Alamat: {$address->full_address}, {$address->district}, {$address->city}, {$address->province} {$address->postal_code}. Catatan: ".($data['notes'] ?? '-'),
                    'expired_at' => now()->addHours(24),
                ]);

                // Create Order Items & Decrement Stock
                foreach ($cartItems as $item) {
                    $product = Product::find($item->product_id);

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'product_sku' => $product->sku,
                        'product_price' => $product->price,
                        'quantity' => $item->quantity,
                        'subtotal' => $product->price * $item->quantity,
                    ]);

                    $product->decrement('stock', $item->quantity);
                }

                // Initial Payment Record
                Payment::create([
                    'order_id' => $order->id,
                    'method' => $data['payment_method'] === 'cod' ? 'COD (Bayar di Tempat)' : 'Transfer Bank / QRIS',
                    'amount' => $grandTotal,
                    'status' => 'pending',
                ]);

                // Order Status Log
                OrderStatusLog::create([
                    'order_id' => $order->id,
                    'status' => 'pending',
                    'note' => $isCod ? 'Pesanan dibuat dengan metode COD (Bayar di Tempat)' : 'Pesanan dibuat, menunggu konfirmasi pembayaran transfer',
                    'changed_by' => $user->id,
                ]);

                // Empty cart items
                $cart->items()->delete();

                return $order;
            });

            if ($data['payment_method'] === 'transfer') {
                return redirect()->route('payment.show', $order->order_number)
                    ->with('success', 'Pesanan berhasil dibuat! Silakan lakukan transfer dan unggah bukti pembayaran.');
            }

            return redirect()->route('orders.show', $order->order_number)
                ->with('success', 'Pesanan COD berhasil dibuat! Kurir kami akan mengantar ke alamat Anda.');
        } catch (Exception $e) {
            Log::error('Checkout failed: '.$e->getMessage(), ['user_id' => $user->id]);

            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
