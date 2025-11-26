<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ReviewProduct; // pastikan ini ada ya

class Product extends Model
{
    /**
     * Tabel yang digunakan
     */
    protected $table = 'product';

    /**
     * Primary key
     */
    protected $primaryKey = 'id_product';

    /**
     * Tidak memakai timestamps
     */
    public $timestamps = false;

    /**
     * Kolom yang bisa di-mass assign
     */
    protected $fillable = [
        'id_store',
        'name_product',
        'description',
        'price',
        'stock',
        'product_picture'
    ];

    /**
     * Relasi ke Store (Many to One)
     */
    public function store()
    {
        return $this->belongsTo(Store::class, 'id_store', 'id_store');
    }

    /**
     * Relasi ke CartItem
     */
    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'id_product', 'id_product');
    }

    /**
     * Relasi ke OrderItem
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'id_product', 'id_product');
    }

    /**
     * Relasi ke ReviewProduct
     */
    public function reviews()
    {
        return $this->hasMany(ReviewProduct::class, 'id_product', 'id_product');
    }

    /**
     * Relasi Many-to-Many ke Mystery Box (via pivot table mystery_box_product)
     */
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
            'cashback'
        ]);
    }

    /**
     * URL gambar produk
     */
    public function getProductPictureUrlAttribute()
    {
        return $this->product_picture
            ? asset($this->product_picture)
            : asset('images/default-product.png');
    }

    /**
     * Cek stok habis
     */
    public function isOutOfStock()
    {
        return $this->stock <= 0;
    }

    /**
     * Kurangi stok (dipanggil setelah checkout)
     */
    public function reduceStock($qty)
    {
        if ($this->stock >= $qty) {
            $this->stock -= $qty;
            $this->save();
        }
    }

    /**
     * Tambah stok (opsional)
     */
    public function addStock($qty)
    {
        $this->stock += $qty;
        $this->save();
    }

    /*
    |--------------------------------------------------------------------------
    | Tambahan: Query Scope untuk Use Case Pencarian Dessert
    |--------------------------------------------------------------------------
    */

    /**
     * scopeSearch
     *
     * Memfilter produk berdasarkan keyword yang diketik user.
     * Digunakan di ProductController::searchProduct().
     *
     * Pemanggilan:
     * Product::search($keyword)->get();
     */
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

    /**
     * scopeHighestRated
     *
     * Mengambil produk dengan rating tertinggi, dibatasi $limit.
     * Digunakan di ProductController::showSearchPage().
     */
    public function scopeHighestRated($query, int $limit = 6)
    {
        return $query->withAvg('reviews', 'rating')
                     ->withCount('reviews')
                     ->orderByDesc('reviews_avg_rating')
                     ->take($limit);
    }
}
