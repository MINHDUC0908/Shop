@extends('admin.layouts.app')

@section('content')
    <style>
        .prev, .next {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: transparent;;
            color: #141313;
            border: none;
            padding: 10px;
            cursor: pointer;
            z-index: 10;
        }
        .prev {
            left: 10px;
        }
        .next {
            right: 10px;
        }
        #mainImage {
            max-width: 100%;
            height: 400px;
            background-color: #f8f8f8;
            object-fit: cover; 
            transition: transform 0.3s ease;
            mix-blend-mode: multiply;
        }
        .image-container {
            display: flex;
            justify-content: center; 
            align-items: center; 
            min-height: 200px;
            border: 1px solid #ddd;
            padding: 5px;
            margin-bottom: 20px; 
            position: relative; 
        }
        .thumbnails {
            display: flex;
            overflow-x: auto;
            padding: 10px 0;
            scrollbar-width: none;
        }
        .thumbnails::-webkit-scrollbar {
            display: none;
        }
        .thumbnail-item {
            flex: 0 0 auto;
            width: 100px; 
            height: 100px;
            overflow: hidden; 
            border: 1px solid #ddd;
            margin-right: 10px; 
        }
        .thumbnail-item img {
            width: 100%;
            height: 100%;
            object-fit: cover; 
            transition: transform 0.2s;
        }
        .thumbnail-item img:hover {
            transform: scale(1.05);
        }
        .modal-content {
            max-width: 100%;
            max-height: 100vh;
            margin: auto;
        }
        .modal-body {
            display: flex;
            justify-content: center;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
    <div class="container">
        <h1>Variant Details</h1>

        <div class="card">
            <div class="card-header">
                <h3 id="selectedColor">Product: {{ $variant->product->product_name }}</h3> 
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="image-container">
                            <button class="prev" onclick="prevImage()"><i class="fas fa-chevron-left"></i></button>
                            <button class="next" onclick="nextImage()"><i class="fas fa-chevron-right"></i></button>
                            <img id="mainImage" name="mainImage" src="{{ asset('imgProduct/' . $variant->product->images) }}" class="img-fluid" alt="{{ $variant->product->product_name }}" onclick="openModal(mainImage.src)">
                        </div>
                        <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <img id="modalImage" src="" name="modalImage" alt="Image" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="thumbnails mt-3">
                            <div class="thumbnail-item">
                                <img src="{{ asset('imgProduct/' . $variant->product->images) }}" alt="Thumbnail" class="product-imgs" onclick="changeImage(this)">
                            </div>  
                            @if ($variant->product->description_image)
                                @foreach (json_decode($variant->product->description_image) as $descImage)
                                    <div class="thumbnail-item">
                                        <img src="{{ asset('imgDescriptionProduct/' . $descImage) }}" alt="Thumbnail" class="product-imgs" onclick="changeImage(this)">
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Product Name:</strong> {{ $variant->product->product_name }}</p>
                        <p><strong>Category:</strong> {{ $variant->product->category->category_name }}</p>
                        <p><strong>Brand:</strong> {{ $variant->product->brand->brand_name }}</p>
                        <p>
                            <strong>
                                Outstanding features:
                            </strong>
                            <p>
                                {!! html_entity_decode($variant->product->description) !!}
                            </p>
                        </p>
                        @if ($variant->attribute)
                            <p><strong>Attribute:</strong> {{ $variant->attribute }}</p>
                        @else
                            
                        @endif
                        <div>
                            <p style="display: inline; font-weight: bold; margin-right: 10px;">Colors:</p>
                            @foreach (json_decode($variant->colors) as $color)
                                <span 
                                    style="background-color: {{ $color }}; color: white; cursor: pointer; font-weight: bold; margin-right: 10px; padding: 5px 10px; border-radius: 5px;" 
                                    onclick="displaySelectedColor('{{ $color }}')">
                                    {{ $color }}
                                </span>
                            @endforeach
                        </div>                    
                        <p id="selectedColor" style="margin-top: 10px; font-weight: bold;"></p>
                        @if ($variant->attribute)
                            <p><strong>Price:</strong> {{ number_format($variant->price, 2) }}₫</p>
                        @else
                            <p><strong>Price:</strong> {{ number_format($variant->product->price, 2) }}₫</p>
                        @endif
                        <p><strong>Discount Price:</strong>
                            @if($variant->discount_price)
                                {{ number_format($variant->discount_price, 2) }}%
                            @else
                                N/A
                            @endif
                        </p>
                        <p><strong>Quantity:</strong> {{ $variant->quantity }}</p>
                        <p><strong>Status:</strong> {{ ucfirst($variant->status) }}</p>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <strong style="font-size: 30px">
                            Specifications:
                        </strong>
                        <p>
                            {!! html_entity_decode($variant->product->outstanding) !!}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <strong style="font-size: 30px">
                            Product Description:
                        </strong>
                        <p>
                            {!! html_entity_decode($variant->parameter) !!}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function displaySelectedColor(color) {
            document.getElementById('selectedColor').style.color = color; 
        }

        var currentIndex = 0;
        function changeImage(element) {
            var mainImage = document.getElementById('mainImage');
            mainImage.src = element.src;
        }

        function startSlideshow() {
            var thumbnails = document.querySelectorAll('.thumbnail-item img');
            if (thumbnails.length > 0) {
                setInterval(function() {
                    var mainImage = document.getElementById('mainImage');
                    currentIndex = (currentIndex + 1) % thumbnails.length;
                    mainImage.src = thumbnails[currentIndex].src;
                }, 15000);
            }
        }

        function prevImage() {
            var thumbnails = document.querySelectorAll('.thumbnail-item img');
            if (thumbnails.length > 0) {
                currentIndex = (currentIndex - 1 + thumbnails.length) % thumbnails.length;
                var mainImage = document.getElementById('mainImage');
                mainImage.src = thumbnails[currentIndex].src;
            }
        }

        function nextImage() {
            var thumbnails = document.querySelectorAll('.thumbnail-item img');
            if (thumbnails.length > 0) {
                currentIndex = (currentIndex + 1) % thumbnails.length;
                var mainImage = document.getElementById('mainImage');
                mainImage.src = thumbnails[currentIndex].src;
            }
        }
        document.addEventListener('DOMContentLoaded', function() {
            startSlideshow();
        });
        function openModal(imageUrl) {
            document.getElementById('modalImage').src = imageUrl; 
            $('#imageModal').modal('show');  
        }
    </script>
@endsection
