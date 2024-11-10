@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Create Variant</h1>
    <form action="{{ route('variants.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="product_id" class="form-label">Product</label>
            <select name="product_id" id="product_id" class="form-control" required>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>{{ $product->product_name }}</option>
                @endforeach
            </select>
            @error('product_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="parameter" class="form-label">Parameter</label>
            <textarea id="parameter" class="form-control" name="parameter" rows="4">{{ old('parameter') }}</textarea>
            @error('parameter')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="attribute" class="form-label">Attribute (Optional)</label>
            <input type="text" name="attribute" id="attribute" class="form-control" value="{{ old('attribute') }}">
            @error('attribute')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="colors" class="form-label">Colors (JSON format)</label>
            <input type="text" name="colors" id="colors" class="form-control" value="{{ old('colors') }}" >
            <small class="text-muted">e.g. "Red", "Blue", "Green"</small>
            @error('colors')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>        
        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" name="price" id="price" class="form-control" value="{{ old('price') }}"  step="0.01">
            @error('price')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="discount_price" class="form-label">Discount_price</label>
            <input type="number" name="discount_price" id="discount_price" class="form-control" value="{{ old('discount_price') }}"  step="0.01">
            @error('discount_price')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number" name="quantity" id="quantity" class="form-control" value="{{ old('quantity') }}" >
            @error('quantity')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-success">Create Variant</button>
    </form>
</div>
@endsection
