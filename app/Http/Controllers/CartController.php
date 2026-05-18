<?php

// Muhammad Fikri Khalilullah/5026231198

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $cart = Cart::firstOrCreate(['id_user' => $user->id_user]);
        $items = $cart->items()->with('product')->get();

        // Use the Session instead of the database column
        $gachaIds = session('gacha_item_ids', []);

        // Separate items based on the Session IDs
        $gachaItems = $items->filter(fn ($item) => in_array($item->id_cart_item, $gachaIds));
        $regularItems = $items->filter(fn ($item) => ! in_array($item->id_cart_item, $gachaIds));

        $total = $items->sum(function ($item) use ($gachaIds) {
            // Price is 0 if it's a gacha win, otherwise use product price
            $currentPrice = in_array($item->id_cart_item, $gachaIds) ? 0 : $item->product->price;

            return $currentPrice * $item->quantity;
        });

        return view('cart.cart', [
            'cart' => $cart,
            'items' => $items,
            'gachaItems' => $gachaItems,
            'regularItems' => $regularItems,
            'total' => $total,
            'gachaIds' => $gachaIds,
        ]);
    }

    public function addToCart(Request $request, $productId)
    {
        $user = Auth::user();
        $cart = Cart::firstOrCreate(['id_user' => $user->id_user]);

        $item = CartItem::where('id_cart', $cart->id_cart)
            ->where('id_product', $productId)
            ->first();

        if ($item) {
            $item->quantity += 1;
            $item->save();
        } else {
            CartItem::create([
                'id_cart' => $cart->id_cart,
                'id_product' => $productId,
                'quantity' => 1,
            ]);
        }

        return redirect()->route('cart.index');
    }

    public function updateQuantity(Request $request, $cartItemId)
    {
        $item = CartItem::findOrFail($cartItemId);
        $gachaIds = session('gacha_item_ids', []);

        // Check if item is Gacha using Session instead of $item->price
        if (in_array($item->id_cart_item, $gachaIds)) {
            return back()->with('error', 'Reward quantities cannot be changed.');
        }

        if ($request->has('action')) {
            if ($request->action === 'increase') {
                $item->quantity += 1;
            } elseif ($request->action === 'decrease' && $item->quantity > 1) {
                $item->quantity -= 1;
            }
        } else {
            $request->validate(['quantity' => 'required|integer|min:1']);
            $item->quantity = $request->quantity;
        }

        $item->save();

        return back();
    }

    public function removeItem($id)
    {
        $item = CartItem::findOrFail($id);
        $gachaIds = session('gacha_item_ids', []);

        // Allow deletion, but maybe warn if it's gacha
        $item->delete();

        // Clean up session if gacha item is deleted
        if (in_array($id, $gachaIds)) {
            session(['gacha_item_ids' => array_diff($gachaIds, [$id])]);
        }

        return back()->with('success', 'Item removed.');
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'selected_items' => 'required|array|min:1',
            'selected_items.*' => 'exists:cart_item,id_cart_item',
        ]);

        session(['selected_cart_items' => $request->selected_items]);

        return redirect()->route('order.payment');
    }
}
