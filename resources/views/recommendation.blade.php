@extends('layout')

@section('title', 'Recommendations')

@section('content')
<div class="container py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Recommendations</h3>

        <form action="{{ route('recommendation.search') }}" method="GET" class="d-flex" style="max-width: 280px;">
            <input 
                type="text" 
                name="query" 
                class="form-control form-control-sm" 
                placeholder="Search products..."
            >
            <button class="btn btn-sm btn-primary ms-2">Search</button>
        </form>
    </div>

    <!-- Product Grid -->
    <div class="row g-4">
        @foreach($products as $product)
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card h-100 shadow-sm border-0">

                <a href="{{ route('product.detail', $product->id_product) }}">
                    <img 
                        src="{{ asset($product->product_picture) }}" 
                        class="card-img-top"
                        style="height: 180px; object-fit: cover;"
                    >
                </a>

                <div class="card-body">
                    <h6 class="fw-bold mb-1">
                        {{ Str::limit($product->name_product, 40) }}
                    </h6>

                    <p class="text-muted small mb-1">
                        {{ Str::limit($product->description, 50) }}
                    </p>

                    <p class="fw-bold mb-1 text-primary">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </p>

                    <span class="badge bg-success">★ {{ number_format($product->rating_avg ?? 4.5, 1) }}</span>
                </div>

            </div>
        </div>
        @endforeach
    </div>

</div>
@endsection
