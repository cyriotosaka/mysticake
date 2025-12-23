<?php
/**
 * Updated by Abdul Ghoni (5026231109)
 * - Menambahkan review_photo ke fillable untuk fitur upload foto review
 * - Menambahkan created_at untuk timestamp review
 * - Menambahkan helper methods untuk validasi review
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Product;
use App\Models\Orders;
use App\Models\OrderItem;

class ReviewProduct extends Model
{
    /**
     * Nama tabel
     */
    use HasFactory;

    protected $table = 'review_product';

    /**
     * Primary key
     */
    protected $primaryKey = 'id_review_product';

    /**
     * Tabel tidak menggunakan created_at / updated_at otomatis
     * Kita handle created_at secara manual
     */
    public $timestamps = false;

    /**
     * Kolom yang dapat di-fill
     */
    protected $fillable = [
        'id_product',
        'id_user',
        'comment',
        'like_review',
        'rating',
        'review_photo',
        'created_at'
    ];

    /**
     * Cast attributes
     */
    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * Relasi ke Product (Many to One)
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product', 'id_product');
    }

    /**
     * Relasi ke User (Many to One)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    /**
     * Helper: apakah review memiliki komentar?
     */
    public function hasComment()
    {
        return !empty($this->comment);
    }

    /**
     * Helper: apakah review memiliki rating baik?
     */
    public function isPositive()
    {
        return $this->rating >= 4;
    }

    /**
     * Scope: Ambil review berdasarkan product ID
     * Sesuai sequence diagram: findByProduct(productData.id)
     */
    public static function findByProduct($productId)
    {
        return self::where('id_product', $productId)
                   ->with('user') // Eager load user data
                   ->orderByDesc('created_at') // Terbaru dulu berdasarkan timestamp
                   ->orderByDesc('id_review_product')
                   ->get();
    }

    /**
     * Cek apakah user sudah pernah membeli produk ini
     * (HIGH Priority Fix: Purchase Validation)
     */
    public static function hasUserPurchased($userId, $productId)
    {
        // Cek di order_item yang terhubung dengan orders milik user
        // Order harus dalam status yang valid (tidak cancelled)
        return OrderItem::whereHas('orders', function ($query) use ($userId) {
            $query->where('id_user', $userId)
                  ->whereNotIn('status_order', ['Cancelled', 'Failed']);
        })
        ->where('id_product', $productId)
        ->exists();
    }

    /**
     * Cek apakah user sudah pernah review produk ini
     * (HIGH Priority Fix: Prevent Duplicate Review)
     */
    public static function hasUserReviewed($userId, $productId)
    {
        return self::where('id_user', $userId)
                   ->where('id_product', $productId)
                   ->exists();
    }

    /**
     * Cek apakah user bisa memberikan review
     * Return array dengan status dan pesan
     */
    public static function canUserReview($userId, $productId)
    {
        // Cek apakah sudah pernah review
        if (self::hasUserReviewed($userId, $productId)) {
            return [
                'can_review' => false,
                'message' => 'Anda sudah pernah memberikan review untuk produk ini.'
            ];
        }

        // Cek apakah pernah membeli
        if (!self::hasUserPurchased($userId, $productId)) {
            return [
                'can_review' => false,
                'message' => 'Anda harus membeli produk ini terlebih dahulu sebelum bisa memberikan review.'
            ];
        }

        return [
            'can_review' => true,
            'message' => ''
        ];
    }

    /**
     * Format tanggal review untuk display
     */
    public function getFormattedDate()
    {
        if ($this->created_at) {
            return $this->created_at->diffForHumans();
        }
        return 'Beberapa waktu lalu';
    }

    /**
     * Toggle like pada review
     */
    public function incrementLike()
    {
        $this->like_review = ($this->like_review ?? 0) + 1;
        $this->save();
        return $this->like_review;
    }
}
