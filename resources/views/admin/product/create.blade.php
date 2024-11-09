@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>Thêm sản phẩm mới</h2>
    <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="product_name">Tên sản phẩm</label>
            <input type="text" class="form-control @error('product_name') is-invalid @enderror" id="product_name" name="product_name" value="{{ old('product_name') }}">
            
            @error('product_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Mô tả</label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="outstanding">Nổi bật</label>
            <textarea class="form-control @error('outstanding') is-invalid @enderror" id="outstanding" name="outstanding" rows="3">{{ old('outstanding') }}</textarea>
            @error('outstanding')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="price">Giá sản phẩm</label>
            <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}" step="0.01">
            @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="images">Ảnh sản phẩm</label>
            <input type="file" class="form-control @error('images') is-invalid @enderror" id="images" name="images" onchange="previewImages()">
            <div id="image-preview"></div>
            @error('images')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="description_image">Mô tả ảnh</label>
            <input type="file" class="form-control @error('description_image') is-invalid @enderror" id="description_image" name="description_image[]" multiple onchange="previewDescriptionImage()">
            <div id="description-image-preview"></div>
            @error('description_image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="category_id">Category</label>
            <select name="category_id" id="category_id" class="form-control" onchange="fetchBrands()">
                @foreach ($categories as $item)
                    <option value="{{ $item->id }}">{{ $item->category_name }}</option>
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
        <button type="submit" class="btn btn-primary" style="margin: 20px 0;">Thêm sản phẩm</button>
    </form>
</div>
    <script>
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

        // Xem trước ảnh mô tả
        function previewDescriptionImage() {
            var preview = document.getElementById('description-image-preview');
            preview.innerHTML = ""; // Clear previous previews

            var file = document.getElementById('description_image').files[0];
            if (file) {
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
    </script>
@endsection