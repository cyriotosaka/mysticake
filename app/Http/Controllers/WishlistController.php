<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Wishlist::where('id_user', Auth::id())
            ->with('product')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('wishlist.index', compact('wishlists'));
    }

    public function toggle($id_product)
    {
        $user = Auth::user();

        $existing = Wishlist::where('id_user', $user->id_user)
            ->where('id_product', $id_product)
            ->first();

        if ($existing) {
            $existing->delete();
            $wishlisted = false;
        } else {
            Wishlist::create([
                'id_user' => $user->id_user,
                'id_product' => $id_product,
                'created_at' => now(),
            ]);
            $wishlisted = true;
        }

        if (request()->wantsJson()) {
            return response()->json(['wishlisted' => $wishlisted]);
        }

        return back()->with('success', $wishlisted ? 'Ditambahkan ke wishlist!' : 'Dihapus dari wishlist.');
    }
}
