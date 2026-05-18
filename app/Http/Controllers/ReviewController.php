<?php

/**
 * Updated by Abdul Ghoni (5026231109)
 * - Menambahkan fitur upload foto review
 * - Menambahkan CRUD (update, destroy) untuk review
 * - Menambahkan validasi: prevent duplicate review, purchase validation
 * - Menambahkan fitur like review
 */

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ReviewProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Menyimpan review baru untuk produk
     *
     * @param  int  $productId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $productId)
    {
        // Validasi input
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'review_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Cek apakah produk ada
        $product = Product::find($productId);
        if (! $product) {
            return back()->with('error', 'Produk tidak ditemukan.');
        }

        // Ambil user yang login
        $user = Auth::user();

        // ===========================================
        // HIGH PRIORITY FIX: Validasi Review
        // ===========================================

        // Cek apakah user sudah pernah review produk ini (Prevent Duplicate)
        if (ReviewProduct::hasUserReviewed($user->id_user, $productId)) {
            return back()->with('error', 'Anda sudah pernah memberikan review untuk produk ini. Silakan edit review yang sudah ada.');
        }

        // Cek apakah user pernah membeli produk ini (Purchase Validation)
        if (! ReviewProduct::hasUserPurchased($user->id_user, $productId)) {
            return back()->with('error', 'Anda harus membeli produk ini terlebih dahulu sebelum bisa memberikan review.');
        }

        // ===========================================

        // Handle photo upload
        $photoName = null;
        if ($request->hasFile('review_photo')) {
            $photo = $request->file('review_photo');
            $photoName = time().'_'.$user->id_user.'_'.$photo->getClientOriginalName();
            $photo->move(public_path('images/reviews'), $photoName);
        }

        // Buat review baru dengan timestamp
        ReviewProduct::create([
            'id_product' => $productId,
            'id_user' => $user->id_user,
            'rating' => $request->input('rating'),
            'comment' => $request->input('comment'),
            'like_review' => 0,
            'review_photo' => $photoName,
            'created_at' => now(), // MEDIUM PRIORITY FIX: Add timestamp
        ]);

        return back()->with('success', 'Terima kasih! Review Anda berhasil ditambahkan.');
    }

    /**
     * Update review
     */
    public function update(Request $request, $id)
    {
        $review = ReviewProduct::find($id);

        if (! $review) {
            return back()->with('error', 'Review tidak ditemukan.');
        }

        // Authorization: hanya pemilik yang bisa edit
        if ($review->id_user != Auth::user()->id_user) {
            return back()->with('error', 'Anda tidak memiliki akses untuk mengedit review ini.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'review_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle photo upload
        if ($request->hasFile('review_photo')) {
            // Hapus foto lama jika ada
            if ($review->review_photo) {
                $oldPhotoPath = public_path('images/reviews/'.$review->review_photo);
                if (file_exists($oldPhotoPath)) {
                    unlink($oldPhotoPath);
                }
            }

            $photo = $request->file('review_photo');
            $photoName = time().'_'.Auth::user()->id_user.'_'.$photo->getClientOriginalName();
            $photo->move(public_path('images/reviews'), $photoName);
            $review->review_photo = $photoName;
        }

        // Handle remove photo
        if ($request->input('remove_photo') == '1' && $review->review_photo) {
            $oldPhotoPath = public_path('images/reviews/'.$review->review_photo);
            if (file_exists($oldPhotoPath)) {
                unlink($oldPhotoPath);
            }
            $review->review_photo = null;
        }

        $review->rating = $request->input('rating');
        $review->comment = $request->input('comment');
        $review->save();

        return back()->with('success', 'Review berhasil diperbarui.');
    }

    /**
     * Delete review
     */
    public function destroy($id)
    {
        $review = ReviewProduct::find($id);

        if (! $review) {
            return back()->with('error', 'Review tidak ditemukan.');
        }

        // Authorization: hanya pemilik yang bisa hapus
        if ($review->id_user != Auth::user()->id_user) {
            return back()->with('error', 'Anda tidak memiliki akses untuk menghapus review ini.');
        }

        // Hapus foto jika ada
        if ($review->review_photo) {
            $photoPath = public_path('images/reviews/'.$review->review_photo);
            if (file_exists($photoPath)) {
                unlink($photoPath);
            }
        }

        $review->delete();

        return back()->with('success', 'Review berhasil dihapus.');
    }

    /**
     * Toggle like pada review
     * MEDIUM PRIORITY FIX: Make like button functional
     */
    public function toggleLike($id)
    {
        $review = ReviewProduct::find($id);

        if (! $review) {
            return back()->with('error', 'Review tidak ditemukan.');
        }

        // Increment like count
        $review->incrementLike();

        return back()->with('success', 'Terima kasih atas feedback Anda!');
    }
}
