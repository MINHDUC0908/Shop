@extends('admin.layouts.app')

@section('content')
    <div class="container mt-4">
        <h2>Brand Details</h2>
        <div class="card">
            <div class="card-header">
                <h4>{{ $brand->brand_name }}</h4>
            </div>
            <div class="card-body">
                <p><strong>Category:</strong> {{ $brand->category->category_name }}</p>
                <p><strong>Brand Name:</strong> {{ $brand->brand_name }}</p>
                <a href="{{ route('brand.list') }}" class="btn btn-secondary">Back to Brand List</a>
            </div>
        </div>
    </div>
@endsection
