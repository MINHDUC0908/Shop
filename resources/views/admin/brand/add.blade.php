@extends('admin.layouts.app')

@section('content')
    <div class="container mt-4">
        <h2>Add New Brand</h2>

        <form action="{{ route('brand.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="brand_name" class="form-label">Brand Name</label>
                <input type="text" class="form-control" id="brand_name" name="brand_name" value="{{ old('brand_name') }}">
                @error('brand_name')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="category_id">Danh Mục:</label>
                <select name="category_id" id="category_id" class="form-control">
                    @foreach ($categories as $item)
                        <option value="{{ $item->id }}" {{ old('id') == $item->id ? 'selected' : '' }}>
                            {{ $item->category_name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <button style="margin-top: 10px;" type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection
