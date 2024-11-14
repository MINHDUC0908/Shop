@extends('admin.layouts.app')

@section('content')
    <div class="container mt-4">
        @if(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <!-- Nút thêm danh mục -->
        <div class="mb-3" style="display: flex; justify-content: space-between; align-items: center;">
            <h2 style="margin: 0;">Brand List</h2>
            <a href="{{ route('brand.create') }}" class="btn btn-primary" style="margin-left: 20px;">
                <i class="fas fa-plus"></i> Add New Brand
            </a>
        </div> 
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Thướng hiệu</th>
                    <th>Danh mục sản phẩm</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($brands as $brand)
                    <tr>
                        <td>{{ $brand->id }}</td>
                        <td>{{ $brand->brand_name }}</td>
                        <td>{{ $brand->category_name }}</td>
                        <td>
                            <a href="{{ route('brand.show', ['id' => $brand->id]) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-edit"></i> Show
                            </a>
                            <a href="{{ route('brand.edit', ['id' => $brand->id]) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('brand.delete', ['id' => $brand->id]) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa không?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Delete">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <small>Showing {{ $brands->firstItem() }} to {{ $brands->lastItem() }} of {{ $brands->total() }} brands</small>
            </div>
            <div>
                <!-- Custom pagination -->
                {{ $brands->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
