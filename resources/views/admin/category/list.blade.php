@extends('admin.layouts.app')

@section('content')
    <div class="container mt-4">
        <!-- Nút thêm danh mục -->
        <div class="mb-3" style="display: flex; justify-content: space-between; align-items: center;">
            <h2 style="margin: 0;">Category List</h2>
            <a href="{{ route('category.create') }}" class="btn btn-primary" style="margin-left: 20px;">
                <i class="fas fa-plus"></i> Add New Category
            </a>
        </div>          
        @if(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <table class="table table-striped" id="myTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->category_name }}</td>
                        <td>
                            <a href="{{ route('category.edit', ['id' => $category->id]) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('category.delete', ['id' => $category->id]) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa không?')">
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

    </div>
@endsection
