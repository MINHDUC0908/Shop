@extends('admin.layouts.app')

@section('content')
    <div class="container mt-4">
        <h2>Edit Category</h2>
        <form action="{{ route('category.update', ['id' => $category->id]) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="category_name" class="form-label">Category Name</label>
                <input type="text" class="form-control" id="category_name" name="category_name" value="{{ old('category_name', $category->category_name) }}">
                @error('category_name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>
@endsection
