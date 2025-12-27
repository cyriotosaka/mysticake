@extends('layouts.app')

@section('content')
@include('partials.theme-script')
<div class="container">
    <h3>Ulasan untuk: {{ $product->name }}</h3>
    <a href="{{ route('products.reviews.create', $product->id) }}" class="btn btn-primary mb-3">Tulis Review</a>

    @foreach($reviews as $review)
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <strong>{{ $review->user->name }}</strong>
                        <div>Rating: {{ $review->rating }} ★</div>
                    </div>
                    <small>{{ $review->created_at->format('d M Y') }}</small>
                </div>
                <p class="mt-2">{{ $review->comment }}</p>

                @if($review->photos)
                    <div class="d-flex gap-2">
                        @foreach($review->photos as $p)
                            <img src="{{ asset('storage/'.$p) }}" alt="photo" style="width:80px;height:80px;object-fit:cover;">
                        @endforeach
                    </div>
                @endif

                @can('delete', $review)
                    <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                @endcan
            </div>
        </div>
    @endforeach

    {{ $reviews->links() }}
</div>
@endsection
