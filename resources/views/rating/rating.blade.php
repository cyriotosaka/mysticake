    <!-- Nama : Abdul Ghoni -->
    <!-- NRP : 5026231109 -->
    <!-- Updated by Abdul Ghoni (5026231109) - Menambahkan fitur upload foto, CRUD review, photo viewer lightbox -->
    <!-- Updated: Validasi review, timestamp display, like button functional -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rating - {{ $product->name_product }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/rating.css') }}">
</head>
<body>

    <div class="mobile-view">

        <!-- Header -->
        <header class="rating-header">
            <a href="{{ route('product.detail', $product->id_product) }}" class="btn-back">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h5 class="header-title">Rating & Reviews</h5>
        </header>

        <!-- Tabs: Product / Store -->
        <div class="nav-tabs-container">
            <a href="#" class="nav-tab-item active">Product</a>
            <a href="#" class="nav-tab-item disabled" style="color: #ccc; pointer-events: none;">Store</a>
        </div>

        <main class="content-area">
            
            <!-- Product Image -->
            <img src="{{ asset('images/products/' . ($product->product_picture ?? 'default.png')) }}" 
                 class="img-fluid product-main-image" 
                 alt="{{ $product->name_product }}" 
                 onerror="this.src='https://via.placeholder.com/400x300'">

            <!-- Product Info with Price -->
            <div class="product-info-section">
                <div class="product-details">
                    <h4 class="product-name">{{ $product->name_product }}</h4>
                    <div class="rating-summary">
                        <i class="bi bi-star-fill text-warning"></i>
                        {{ number_format($product->reviews->avg('rating') ?? 0, 1) }} Product Rating ({{ $product->reviews->count() }})
                    </div>
                </div>
                <div class="product-price-box">
                    <h4>Rp {{ number_format($product->price, 0, ',', '.') }}</h4>
                </div>
            </div>

            <!-- Filters -->
            <div class="filter-section">
                <nav class="nav nav-pills gap-2 review-filters">
                    <a class="nav-link active" href="#">All</a>
                    <a class="nav-link" href="#">With Photos</a>
                    <a class="nav-link" href="#">
                        <i class="bi bi-star-fill text-warning"></i> 5
                    </a>
                    <a class="nav-link" href="#">
                        <i class="bi bi-star-fill text-warning"></i> 4
                    </a>
                    <a class="nav-link" href="#">
                        <i class="bi bi-star-fill text-warning"></i> 3
                    </a>
                </nav>
            </div>

            <!-- Flash Messages -->
            @if(session('success'))
            <div class="alert alert-success mx-3 mt-3 mb-0" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger mx-3 mt-3 mb-0" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger mx-3 mt-3 mb-0" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i>
                @foreach($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
            @endif

            <!-- Add Review Form - Conditional based on canReview status -->
            @if(Auth::check())
                @if($canReview['can_review'])
                <div class="add-review-section">
                    <h6 class="add-review-title"><i class="bi bi-pencil-square me-2"></i>Tulis Review Anda</h6>
                    <form action="{{ route('review.store', $product->id_product) }}" method="POST" class="review-form" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Star Rating Input -->
                        <div class="star-rating-input">
                            <label class="rating-label">Rating:</label>
                            <div class="star-selector">
                            @for($i = 5; $i >= 1; $i--)
                            <input type="radio" name="rating" value="{{ $i }}" id="star{{ $i }}" {{ old('rating') == $i ? 'checked' : '' }} required>
                            <label for="star{{ $i }}" class="star-label"><i class="bi bi-star-fill"></i></label>
                            @endfor
                        </div>
                        </div>

                        <!-- Comment Input -->
                        <div class="comment-input">
                            <label for="comment" class="rating-label">Komentar (opsional):</label>
                            <textarea name="comment" id="comment" class="form-control" rows="3" placeholder="Bagikan pengalaman Anda dengan produk ini...">{{ old('comment') }}</textarea>
                        </div>

                        <!-- Photo Upload -->
                        <div class="photo-upload-input">
                            <label for="review_photo" class="rating-label">Upload Foto (opsional):</label>
                            <div class="photo-upload-area">
                                <input type="file" name="review_photo" id="review_photo" accept="image/*" class="form-control">
                                <small class="text-muted">Format: JPG, PNG, GIF. Max: 2MB</small>
                            </div>
                            <div id="photo-preview" class="photo-preview" style="display: none;">
                                <img id="preview-img" src="" alt="Preview">
                                <button type="button" id="remove-photo" class="btn-remove-photo"><i class="bi bi-x-circle"></i></button>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn-submit-review">
                            <i class="bi bi-send me-2"></i>Kirim Review
                        </button>
                    </form>
                </div>
                @else
                <!-- Cannot Review Message -->
                <div class="add-review-section">
                    <div class="alert alert-warning mb-0" role="alert">
                        <i class="bi bi-info-circle me-2"></i>{{ $canReview['message'] }}
                    </div>
                </div>
                @endif
            @else
            <!-- Not Logged In Message -->
            <div class="add-review-section">
                <div class="alert alert-info mb-0" role="alert">
                    <i class="bi bi-info-circle me-2"></i>Silakan <a href="{{ route('login') }}">login</a> untuk memberikan review.
                </div>
            </div>
            @endif
            
            <!-- Review List -->
            <div class="review-list">
                @forelse($reviews as $review)
                <div class="review-card" data-rating="{{ $review->rating }}" data-has-photos="{{ $review->review_photo ? 'yes' : 'no' }}">
                    <div class="review-header-section">
                        <div class="user-info">
                            <i class="bi bi-person-circle user-icon"></i>
                            <div>
                                <h6 class="user-name">{{ $review->user->username ?? 'Anonymous' }}</h6>
                                <div class="review-stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            <i class="bi bi-star-fill text-warning"></i>
                                        @else
                                            <i class="bi bi-star text-warning"></i>
                                        @endif
                                    @endfor
                                </div>
                                <!-- Timestamp Display (MEDIUM Priority Fix) -->
                                <small class="review-date text-muted">
                                    <i class="bi bi-clock me-1"></i>{{ $review->getFormattedDate() }}
                                </small>
                            </div>
                        </div>
                        <!-- Like Button - Now Functional (MEDIUM Priority Fix) -->
                        <div class="like-section">
                            <form action="{{ route('review.like', $review->id_review_product) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn-like-review" title="Like this review">
                                    <span class="like-count-num">({{ $review->like_review ?? 0 }})</span>
                                    <i class="bi bi-hand-thumbs-up"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <p class="review-text">{{ $review->comment }}</p>
                    
                    @if($review->review_photo)
                    <div class="review-photos">
                        <img src="{{ asset('images/reviews/' . $review->review_photo) }}" alt="Review Photo" onclick="openPhotoViewer(this.src)">
                    </div>
                    @endif

                    @if(Auth::check() && Auth::user()->id_user == $review->id_user)
                    <div class="review-actions">
                        <button type="button" class="btn-edit-review" 
                            data-review-id="{{ $review->id_review_product }}"
                            data-rating="{{ $review->rating }}"
                            data-comment="{{ $review->comment ?? '' }}"
                            data-photo="{{ $review->review_photo ? asset('images/reviews/' . $review->review_photo) : '' }}"
                            onclick="openEditModal(this)">
                            <i class="bi bi-pencil"></i> Edit
                        </button>
                        <form action="{{ route('review.destroy', $review->id_review_product) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus review ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete-review">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                    @endif

                </div>
                @empty
                <div class="text-center mt-5 text-muted">
                    <p>Belum ada ulasan untuk produk ini.</p>
                </div>
                @endforelse
            </div>

        </main>

    </div>

    <!-- Edit Review Modal -->
    <div class="modal fade" id="editReviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Edit Review</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editReviewForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <!-- Star Rating -->
                        <div class="mb-3">
                            <label class="form-label">Rating</label>
                            <div class="edit-star-selector">
                                @for($i = 5; $i >= 1; $i--)
                                <input type="radio" name="rating" value="{{ $i }}" id="edit-star{{ $i }}" required>
                                <label for="edit-star{{ $i }}" class="edit-star-label"><i class="bi bi-star-fill"></i></label>
                                @endfor
                            </div>
                        </div>

                        <!-- Comment -->
                        <div class="mb-3">
                            <label for="edit-comment" class="form-label">Komentar</label>
                            <textarea name="comment" id="edit-comment" class="form-control" rows="3" placeholder="Bagikan pengalaman Anda..."></textarea>
                        </div>

                        <!-- Current Photo -->
                        <div class="mb-3" id="current-photo-container" style="display: none;">
                            <label class="form-label">Foto Saat Ini</label>
                            <div class="current-photo-wrapper">
                                <img id="current-photo" src="" alt="Current Photo">
                                <label class="remove-photo-checkbox">
                                    <input type="checkbox" name="remove_photo" value="1" id="remove-photo-checkbox">
                                    <span>Hapus foto ini</span>
                                </label>
                            </div>
                        </div>

                        <!-- New Photo -->
                        <div class="mb-3">
                            <label for="edit-review-photo" class="form-label">Upload Foto Baru (opsional)</label>
                            <input type="file" name="review_photo" id="edit-review-photo" class="form-control" accept="image/*">
                            <small class="text-muted">Format: JPG, PNG, GIF. Max: 2MB</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Photo Viewer Modal -->
    <div class="modal fade" id="photoViewerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content photo-viewer-content">
                <button type="button" class="btn-close-photo" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </button>
                <div class="modal-body p-0">
                    <img id="photoViewerImage" src="" alt="Photo" class="photo-viewer-img">
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    // Function to open photo viewer modal
    function openPhotoViewer(src) {
        document.getElementById('photoViewerImage').src = src;
        const modal = new bootstrap.Modal(document.getElementById('photoViewerModal'));
        modal.show();
    }

    // Global function to open edit modal - must be outside DOMContentLoaded
    function openEditModal(button) {
        const reviewId = button.getAttribute('data-review-id');
        const rating = button.getAttribute('data-rating');
        const comment = button.getAttribute('data-comment');
        const photoUrl = button.getAttribute('data-photo');
        
        // Set form action
        document.getElementById('editReviewForm').action = '/review/' + reviewId;
        
        // Set rating
        const ratingInput = document.getElementById('edit-star' + rating);
        if (ratingInput) {
            ratingInput.checked = true;
        }
        
        // Set comment
        document.getElementById('edit-comment').value = comment || '';
        
        // Handle existing photo
        const photoContainer = document.getElementById('current-photo-container');
        const currentPhoto = document.getElementById('current-photo');
        const removeCheckbox = document.getElementById('remove-photo-checkbox');
        
        if (photoUrl && photoUrl !== '') {
            photoContainer.style.display = 'block';
            currentPhoto.src = photoUrl;
            removeCheckbox.checked = false;
        } else {
            photoContainer.style.display = 'none';
        }
        
        // Clear file input
        document.getElementById('edit-review-photo').value = '';
        
        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('editReviewModal'));
        modal.show();
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Filter functionality
        const filterButtons = document.querySelectorAll('.review-filters .nav-link');
        const reviewCards = document.querySelectorAll('.review-card');
        
        filterButtons.forEach((button, index) => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                filterButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                
                let filterType = index;
                
                reviewCards.forEach(card => {
                    const rating = parseInt(card.getAttribute('data-rating'));
                    const hasPhotos = card.getAttribute('data-has-photos');
                    
                    let shouldShow = false;
                    
                    switch(filterType) {
                        case 0: shouldShow = true; break;
                        case 1: shouldShow = hasPhotos === 'yes'; break;
                        case 2: shouldShow = rating === 5; break;
                        case 3: shouldShow = rating === 4; break;
                        case 4: shouldShow = rating === 3; break;
                    }
                    
                    card.style.display = shouldShow ? 'block' : 'none';
                });
            });
        });

        // Photo Preview functionality
        const photoInput = document.getElementById('review_photo');
        const photoPreview = document.getElementById('photo-preview');
        const previewImg = document.getElementById('preview-img');
        const removeBtn = document.getElementById('remove-photo');

        if (photoInput) {
            photoInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        photoPreview.style.display = 'block';
                    }
                    reader.readAsDataURL(file);
                }
            });
        }

        if (removeBtn) {
            removeBtn.addEventListener('click', function() {
                photoInput.value = '';
                previewImg.src = '';
                photoPreview.style.display = 'none';
            });
        }
    });
    </script>
</body>
</html>
