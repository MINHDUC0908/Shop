@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>Chỉnh sửa sản phẩm</h2>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <form action="{{ route('product.update', ['id' => $product->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="product_name">Tên sản phẩm</label>
            <input type="text" class="form-control @error('product_name') is-invalid @enderror" id="product_name" name="product_name" value="{{ old('product_name', $product->product_name) }}">
            @error('product_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Mô tả</label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $product->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="outstanding">Nổi bật</label>
            <textarea class="form-control @error('outstanding') is-invalid @enderror" id="outstanding" name="outstanding" rows="3">{{ old('outstanding', $product->outstanding) }}</textarea>
            @error('outstanding')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="price">Giá sản phẩm</label>
            <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $product->price) }}" step="0.01">
            @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="images">Ảnh sản phẩm hiện tại</label><br>
            <img src="{{ asset('imgProduct/' . $product->images) }}" style="height: 100px; margin-bottom: 10px;"><br>
            <label for="images" style="cursor: pointer;">
                <span style="font-size: 1.5rem;">📷 Chọn ảnh mới</span>
            </label>
            <input type="file" class="form-control @error('images') is-invalid @enderror" id="images" name="images" onchange="previewImages()" style="display: none;">
            <div id="image-preview" style="margin-top: 10px;"></div>
        </div>
        <div class="form-group">
            <label for="description_image">Mô tả ảnh hiện tại</label><br>
            @if (!is_null($product->description_image) && is_array(json_decode($product->description_image)))
                @foreach (json_decode($product->description_image) as $image)
                    <img src="{{ asset('imgDescriptionProduct/' . $image) }}" style="height: 100px; margin-bottom: 10px;">
                @endforeach
            @else
                <p>No images available.</p>
            @endif
            <br>
            <label for="description_image" style="cursor: pointer;">
                <span style="font-size: 1.5rem;">📷 Chọn ảnh mới</span>
            </label>            
            <input type="file" class="form-control @error('description_image') is-invalid @enderror hidden" id="description_image" name="description_image[]" multiple onchange="previewDescriptionImage()">
            <div id="description-image-preview" style="margin-top: 10px;"></div>
        </div>
        <div class="form-group">
            <label for="category_id">Category</label>
            <select name="category_id" id="category_id" class="form-control" onchange="fetchBrands()">
                @foreach ($categories as $item)
                    <option value="{{ $item->id }}" {{ $item->id == $product->category_id ? 'selected' : '' }}>{{ $item->category_name }}</option>
                @endforeach
            </select>
        </div>
        @error('category_id')
            <div class="error" style="color: red">{{ $message }}</div>
        @enderror

        <div class="form-group">
            <label for="brand_id">Brand</label>
            <select name="brand_id" id="brand_id" class="form-control">
                <!-- Thương hiệu sẽ được thêm qua AJAX -->
            </select>
        </div>
        @error('brand_id')
            <div class="error" style="color: red">{{ $message }}</div>
        @enderror

        <button type="submit" class="btn btn-primary" style="margin: 20px 0;">Cập nhật sản phẩm</button>
    </form>
</div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            fetchBrands();
        });

        function fetchBrands() {
            var categoryId = document.getElementById('category_id').value;
            var brandSelect = document.getElementById('brand_id');
            brandSelect.innerHTML = ''; 
            if (categoryId) {
                fetch(`/product/brands/${categoryId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length > 0) {
                            data.forEach(brand => {
                                var option = document.createElement('option');
                                option.value = brand.id;
                                option.textContent = brand.brand_name;
                                option.selected = brand.id == {{ $product->brand_id }} ? true : false;
                                brandSelect.appendChild(option);
                            });
                        } else {
                            var option = document.createElement('option');
                            option.value = '';
                            option.textContent = 'Không có thương hiệu';
                            brandSelect.appendChild(option);
                        }
                    })
                    .catch(error => console.error('Error fetching brands:', error));
            }
        }
        function previewDescriptionImage() {
            var previewContainer = document.getElementById('description-image-preview');
            previewContainer.innerHTML = ""; // Clear previous previews

            var files = document.getElementById('description_image').files;
            if (files.length === 0) {
                previewContainer.innerHTML = "<p>No new images selected.</p>";
            } else {
                for (var i = 0; i < files.length; i++) {
                    var file = files[i];
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        var img = document.createElement('img');
                        img.src = e.target.result;
                        img.style.height = '100px';
                        img.style.margin = '5px';
                        previewContainer.appendChild(img);
                    }

                    reader.readAsDataURL(file);
                }
            }
        }
        function previewImages() {
                var preview = document.getElementById('image-preview');
                preview.innerHTML = ""; // Clear previous previews

                var files = document.getElementById('images').files;
                for (var i = 0; i < files.length; i++) {
                    var file = files[i];
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        var img = document.createElement('img');
                        img.src = e.target.result;
                        img.style.height = '100px';
                        img.style.margin = '5px';
                        preview.appendChild(img);
                    }
                    reader.readAsDataURL(file);
                }
            }
    </script>
@endsection
