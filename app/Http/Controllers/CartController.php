<?php

/*Name: Muhammad Fikri Khalilullah
NRP: 50262311198
Class: PPPL C
*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;

class CartController extends Controller
{
    /**
     * Show Cart Page
     */
    public function index()
    {
        $user = Auth::user();

        // Get or Create Cart
        $cart = Cart::firstOrCreate(
            ['id_user' => $user->id_user],
            ['created_at' => now()]
        );

        // Get cart items with product relationship
        $items = $cart->items()->with('product')->get();

        // Calculate total
        $total = $items->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('cart.cart', [
            'cart' => $cart,
            'items' => $items,
            'total' => $total
        ]);

    }

    /**
     * Add Product To Cart
     */
    public function addToCart(Request $request, $productId)
    {
        $user = Auth::user();

        // Get or Create cart
        $cart = Cart::firstOrCreate(
            ['id_user' => $user->id_user],
            ['created_at' => now()]
        );

        // Check product exists
        $product = Product::findOrFail($productId);

        // Check if item already exists
        $item = CartItem::where('id_cart', $cart->id_cart)
                        ->where('id_product', $productId)
                        ->first();

        if ($item) {
            // Increase quantity
            $item->quantity += 1;
            $item->save();
        } else {
            // Create new cart item
            CartItem::create([
                'id_cart' => $cart->id_cart,
                'id_product' => $productId,
                'quantity' => 1
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }

    /**
     * Update Quantity
     */
    public function updateQuantity(Request $request, $cartItemId)
    {
        $item = CartItem::findOrFail($cartItemId);

        // Handle increase/decrease actions
        if ($request->has('action')) {
            if ($request->action === 'increase') {
                $item->quantity += 1;
            } elseif ($request->action === 'decrease' && $item->quantity > 1) {
                $item->quantity -= 1;
            }
        } else {
            // Handle direct quantity update
            $request->validate([
                'quantity' => 'required|integer|min:1'
            ]);
            $item->quantity = $request->quantity;
        }

        $item->save();

        return back();
    }

    /**
     * Remove Item
     */
    public function removeItem($cartItemId)
    {
        $item = CartItem::findOrFail($cartItemId);
        $item->delete();

        return back();
    }

    /**
     * Proceed to Payment
     */
    public function checkout(Request $request)
    {
        $request->validate([
            'selected_items' => 'required|array|min:1',
            'selected_items.*' => 'exists:cart_item,id_cart_item'
        ]);

        // Store selected items in session
        session(['selected_cart_items' => $request->selected_items]);

        return redirect()->route('order.payment');
    }

}
