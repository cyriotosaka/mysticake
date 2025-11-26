@extends('layout')

@section('title', $product->name_product)

@section('content')
<div class="container py-4">

    <div class="row g-4">
        
        <!-- Product Image -->
        <div class="col-md-6">
            <img 
                src="{{ asset($product->product_picture) }}" 
                class="img-fluid rounded shadow-sm"
                style="width: 100%; object-fit: cover;"
            >
        </div>

        <!-- Product Info -->
        <div class="col-md-6">

            <h3 class="fw-bold">{{ $product->name_product }}</h3>

            <p class="text-muted">
                {{ $product->description }}
            </p>

            <p class="fs-4 fw-bold text-primary">
                Rp {{ number_format($product->price, 0, ',', '.') }}
            </p>

            <p>
                <strong>Stock:</strong>
                @if($product->stock > 0)
                    <span class="text-success">{{ $product->stock }}</span>
                @else
                    <span class="text-danger">Out of stock</span>
                @endif
            </p>

            <p>
                <span class="badge bg-success fs-6">★ {{ number_format($product->rating_avg ?? 4.5, 1) }}</span>
            </p>

            <!-- Add to Cart -->
            <form action="{{ route('cart.add') }}" method="POST" class="mt-3">
                @csrf
                <input type="hidden" name="id_product" value="{{ $product->id_product }}">

                <div class="d-flex align-items-center mb-3" style="max-width: 200px;">
                    <label class="me-2">Qty:</label>
                    <input 
                        type="number" 
                        name="qty" 
                        class="form-control" 
                        value="1" 
                        min="1" 
                        max="{{ $product->stock }}"
                    >
                </div>

                <button 
                    class="btn btn-primary px-4"
                    @if($product->stock <= 0) disabled @endif
                >
                    Add to Cart
                </button>
            </form>

        </div>

    </div>

    <!-- Reviews Section -->
    <div class="mt-5">
        <h4 class="fw-bold">Product Reviews</h4>

        @forelse($product->reviews as $review)
        <div class="border-bottom py-3">
            <strong>{{ $review->user->username }}</strong>
            <span class="badge bg-warning text-dark">★ {{ $review->rating }}</span>
            <p class="mb-1">{{ $review->comment }}</p>
        </div>
        @empty
        <p class="text-muted">No reviews yet.</p>
        @endforelse
    </div>

</div>
@endsection
