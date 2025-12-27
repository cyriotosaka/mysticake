@extends('layouts.app')

@section('content')
@include('partials.theme-script')
<div class="container">
    <h3>Tulis Review untuk: {{ $product->name }}</h3>

    <form action="{{ route('products.reviews.store', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="rating" class="form-label">Rating (1-5)</label>
            <select name="rating" id="rating" class="form-control" required>
                <option value="">Pilih</option>
                @for($i=5;$i>=1;$i--)
                    <option value="{{ $i }}">{{ $i }} ★</option>
                @endfor
            </select>
            @error('rating') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="comment" class="form-label">Komentar</label>
            <textarea name="comment" id="comment" class="form-control" rows="4">{{ old('comment') }}</textarea>
            @error('comment') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="photos" class="form-label">Foto (opsional, max 3)</label>
            <input type="file" name="photos[]" id="photos" class="form-control" multiple accept="image/*">
            @error('photos.*') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <button class="btn btn-success">Kirim Review</button>
    </form>
</div>
@endsection
