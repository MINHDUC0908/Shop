@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>Danh sách sản phẩm</h2>
    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <a href="{{ route('product.create') }}" class="btn btn-success mb-3">Thêm sản phẩm mới</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>Danh mục</th>
                <th>Thương hiệu</th>
                <th>Ảnh</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ number_format($product->price, 0, ',', '.') }} VNĐ</td>
                    <td>{{ $product->category->category_name }}</td>
                    <td>{{ $product->brand->brand_name }}</td>
                    <td>
                        @if($product->images)
                            <img src="{{ asset('imgProduct/' . $product->images) }}" alt="Image" style="width: 100px; height: auto;">
                        @else
                            <span>Không có ảnh</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('product.edit', ['id' => $product->id]) }}" class="btn btn-warning btn-sm">Sửa</a>
                        <form action="{{route('product.destroy', ['id' => $product->id])}}" method="POST" style="display: inline;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
