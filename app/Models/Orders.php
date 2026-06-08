<?php

/**
 * Orders Model
 *
 * Updated by: Abdul Ghoni (5026231109)
 *
 * Use Case 2 - Melakukan Pemesanan Produk:
 * - findByUser(): Mengambil semua order berdasarkan user ID untuk history
 * - getFormattedDate(): Format tanggal order untuk display
 * - getFormattedTotal(): Format total pembayaran dengan Rupiah
 *
 * Use Case 3 - Rating dan Review:
 * - Model ini digunakan untuk validasi hasUserPurchased di ReviewProduct
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $table = 'orders';

    protected $primaryKey = 'id_order';

    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'id_payment_method',
        'id_address',
        'id_delivery',
        'order_date',
        'extra_charges',
        'total_payment',
        'status_order',
    ];

    /**
     * User yang membuat order
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    /**
     * Metode pembayaran
     */
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'id_payment_method', 'id_payment_method');
    }

    /**
     * Alamat pengiriman
     */
    public function address()
    {
        return $this->belongsTo(Address::class, 'id_address', 'id_address');
    }

    /**
     * Metode pengiriman (delivery)
     */
    public function delivery()
    {
        return $this->belongsTo(Delivery::class, 'id_delivery', 'id_delivery');
    }

    /**
     * Item-item di dalam order
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class, 'id_order', 'id_order');
    }

    /**
     * Hitung total item
     */
    public function totalItems()
    {
        return $this->items()->sum('quantity');
    }

    /**
     * Check apakah order sudah selesai
     */
    public function isCompleted()
    {
        return $this->status_order === 'completed';
    }

    public function histories()
    {
        return $this->hasMany(History::class, 'id_order', 'id_order');
    }

    /**
     * Create order from cart items
     */
    /**
     * Create order from cart items
     */
    public static function createFromCart($cartItems, $userId, $addressId, $deliveryId, $paymentMethodId, $extraCharges = 0)
    {
        // --- MERGED FIX ---
        // We use $item->price (from cart_items table) instead of $item->product->price.
        // This ensures Gacha items (price 0) and normal items (standard price) are both correct.
        $subtotal = $cartItems->sum(fn ($item) => $item->price * $item->quantity);

        $delivery = static::resolveDelivery($deliveryId);
        $deliveryCharges = $delivery ? $delivery->delivery_charges : 0;
        $totalPayment = $subtotal + $deliveryCharges + $extraCharges;

        // Create the Order Record
        $order = static::create([
            'id_user' => $userId,
            'id_address' => $addressId,
            'id_delivery' => $deliveryId,
            'id_payment_method' => $paymentMethodId,
            'order_date' => now(),
            'extra_charges' => $extraCharges,
            'total_payment' => $totalPayment,
            'status_order' => 'Pending',
        ]);

        // Move items from Cart to OrderItems
        foreach ($cartItems as $cartItem) {
            static::createOrderItem([
                'id_order' => $order->id_order,
                'id_product' => $cartItem->id_product,
                'quantity' => $cartItem->quantity,

                // --- MERGED FIX ---
                // Save the specific price the user "bought" it at (0 for Gacha)
                'subtotal' => $cartItem->price * $cartItem->quantity,
            ]);
        }

        return $order;
    }

    protected static function resolveDelivery($deliveryId)
    {
        return Delivery::find($deliveryId);
    }

    protected static function createOrderItem(array $data)
    {
        return OrderItem::create($data);
    }

    /**
     * Get all orders for a user
     */
    public static function findByUser($userId)
    {
        return static::where('id_user', $userId)
            ->with(['items.product', 'address', 'delivery', 'paymentMethod'])
            ->orderBy('order_date', 'desc')
            ->get();
    }

    /**
     * Get formatted order date
     */
    public function getFormattedDate()
    {
        return \Carbon\Carbon::parse($this->order_date)->format('d M Y, H:i');
    }

    /**
     * Get formatted total
     */
    public function getFormattedTotal()
    {
        return 'Rp '.number_format($this->total_payment, 0, ',', '.');
    }
}
