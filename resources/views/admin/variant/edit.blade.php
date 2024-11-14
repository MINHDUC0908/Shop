@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Edit Variant</h1>
    <form action="{{ route('variants.update', $variant->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <!-- Dropdown chọn sản phẩm -->
        <div class="mb-3">
            <label for="product_id" class="form-label">Product</label>
            <select name="product_id" id="product_id" class="form-control" required>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" {{ $variant->product_id == $product->id ? 'selected' : '' }}>
                        {{ $product->product_name }}
                    </option>
                @endforeach
            </select>
            @error('product_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label for="parameter" class="form-label">Parameter</label>
            <textarea id="parameter" class="form-control" name="parameter" rows="4">{{ old('parameter', $variant->parameter) }}</textarea>
            @error('parameter')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label for="attribute" class="form-label">Attribute (Optional)</label>
            <input type="text" name="attribute" id="attribute" class="form-control" value="{{ old('attribute', $variant->attribute) }}">
            @error('attribute')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label for="colors" class="form-label">Colors (JSON format)</label>
            <input type="text" name="colors" id="colors" class="form-control" value="{{ old('colors', implode(', ', json_decode($variant->colors, true))) }}">
            <small class="text-muted">e.g. "Red", "Blue", "Green"</small>
            @error('colors')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" name="price" id="price" class="form-control" value="{{ old('price', $variant->price) }}" step="0.01">
            @error('price')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label for="discount_price" class="form-label">Discount Price</label>
            <input type="number" name="discount_price" id="discount_price" class="form-control" value="{{ old('discount_price', $variant->discount_price) }}" step="0.01">
            @error('discount_price')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number" name="quantity" id="quantity" class="form-control" value="{{ old('quantity', $variant->quantity) }}">
            @error('quantity')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <button type="submit" class="btn btn-primary">Update Variant</button>
    </form>
</div>
@endsection
