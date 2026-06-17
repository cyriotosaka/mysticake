<?php

/**
 * Product Model
 *
 * Updated by: Abdul Ghoni (5026231109)
 *
 * Use Case 1 - Pencarian Produk:
 * - scopeSearch(): Query scope untuk memfilter produk berdasarkan keyword pencarian
 * - scopeHighestRated(): Query scope untuk mengambil produk dengan rating tertinggi
 *
 * FIXED:
 * - getProductPictureUrlAttribute() sebelumnya memanggil asset($this->product_picture)
 *   tanpa prefix 'images/products/', sehingga gambar tidak ditemukan.
 *   Sekarang di-prefix dengan 'images/products/' agar sesuai dengan path
 *   yang dipakai di home.blade.php dan product/detail.blade.php.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product';

    protected $primaryKey = 'id_product';

    public $timestamps = false;

    protected $fillable = [
        'id_store',
        'name_product',
        'description',
        'price',
        'stock',
        'product_picture',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class, 'id_store', 'id_store');
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'id_product', 'id_product');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'id_product', 'id_product');
    }

    public function reviews()
    {
        return $this->hasMany(ReviewProduct::class, 'id_product', 'id_product');
    }

    public function mysteryBoxes()
    {
        return $this->belongsToMany(
            MysteryBox::class,
            'mystery_box_product',
            'id_product',
            'id_mystery_box'
        )->withPivot([
            'price',
            'point_gacha',
            'history_gacha',
            'type_gacha',
            'drop_rate',
            'cashback',
        ]);
    }

    /**
     * URL gambar produk
     * FIX: Tambahkan prefix 'images/products/' agar path sesuai dengan
     *      struktur folder public/images/products/ yang ada di project.
     *      Sebelumnya: asset($this->product_picture) → path salah
     *      Sesudahnya: asset('images/products/' . $this->product_picture) → path benar
     */
    public function getProductPictureUrlAttribute()
    {
        return $this->product_picture
            ? asset('images/products/' . $this->product_picture)
            : asset('images/default-product.png');
    }

    public function isOutOfStock()
    {
        return $this->stock <= 0;
    }

    public function reduceStock($qty)
    {
        if ($this->stock >= $qty) {
            $this->stock -= $qty;
            $this->save();
        }
    }

    public function addStock($qty)
    {
        $this->stock += $qty;
        $this->save();
    }

    public function scopeSearch($query, ?string $keyword)
    {
        if (empty($keyword)) {
            return $query;
        }

        return $query->where(function ($q) use ($keyword) {
            $q->where('name_product', 'LIKE', "%{$keyword}%")
                ->orWhere('description', 'LIKE', "%{$keyword}%");
        });
    }

    public function scopeHighestRated($query, int $limit = 6)
    {
        return $query->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->orderByDesc('reviews_avg_rating')
            ->take($limit);
    }
}
