@extends('admin.layouts.app')

@section('content')
    <div class="container mt-4">
        <h2>Edit Brand</h2>
        <form action="{{ route('brand.update', $brand->id) }}" method="POST">
            @csrf
            @method('PUT') 
            <div class="mb-3">
                <label for="brand_name" class="form-label">Brand Name</label>
                <input type="text" class="form-control" id="brand_name" name="brand_name" value="{{ old('brand_name', $brand->brand_name) }}">
                @error('brand_name')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="category_id">Category:</label>
                <select name="category_id" id="category_id" class="form-control">
                    @foreach ($categories as $item)
                        <option value="{{ $item->id }}" {{ old('category_id', $brand->category_id) == $item->id ? 'selected' : '' }}>
                            {{ $item->category_name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Update Changes</button>
        </form>
    </div>
@endsection
