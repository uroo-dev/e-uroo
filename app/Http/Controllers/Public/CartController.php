<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display the cart contents.
     */
    public function index()
    {
        $cart = Cart::with('items.product')->firstOrCreate([
            'user_id' => Auth::id(),
        ]);

        return view('Public.cart.index', compact('cart'));
    }

    /**
     * Add a product to the cart.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Cart::firstOrCreate([
            'user_id' => Auth::id(),
        ]);

        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $data['product_id'])
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $data['quantity']);
        } else {
            $data['cart_id'] = $cart->id;
            CartItem::create($data);
        }

        return redirect()->back()->with('success', 'Add to Cart Success');
    }

    /**
     * Update the quantity of a cart item.
     */
    public function update(Request $request, CartItem $cartItem)
    {
        $data = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem->update($data);

        return redirect()->back()->with('success', 'Update Cart Success');
    }

    /**
     * Remove an item from the cart.
     */
    public function destroy(CartItem $cartItem)
    {
        $cartItem->delete();

        return redirect()->back()->with('success', 'Delete Cart Item Success');
    }
}
