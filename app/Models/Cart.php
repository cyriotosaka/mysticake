<?php
/**
 * Cart Model
 * 
 * Updated by: Abdul Ghoni (5026231109)
 * 
 * Use Case 2 - Melakukan Pemesanan Produk:
 * - getSelectedItems(): Mengambil cart items berdasarkan ID yang dipilih user
 * - getTotalAmount(): Menghitung total harga untuk items yang dipilih
 * - clearSelectedItems(): Menghapus items dari cart setelah checkout berhasil
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'cart';
    protected $primaryKey = 'id_cart';
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'created_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function items()
    {
        return $this->hasMany(CartItem::class, 'id_cart');
    }

    /**
     * Get selected cart items by IDs
     */
    public function getSelectedItems($selectedIds)
    {
        return $this->items()->with('product')->whereIn('id_cart_item', $selectedIds)->get();
    }

    /**
     * Calculate total amount for selected items
     */
    public function getTotalAmount($selectedIds = null)
    {
        $items = $selectedIds 
            ? $this->getSelectedItems($selectedIds) 
            : $this->items()->with('product')->get();

        return $items->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });
    }

    /**
     * Clear selected items from cart
     */
    public function clearSelectedItems($selectedIds)
    {
        return CartItem::whereIn('id_cart_item', $selectedIds)
            ->where('id_cart', $this->id_cart)
            ->delete();
    }

}
